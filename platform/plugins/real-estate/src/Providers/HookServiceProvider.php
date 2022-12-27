<?php

namespace Botble\RealEstate\Providers;

use Botble\Dashboard\Supports\DashboardWidgetInstance;
use Botble\LanguageAdvanced\Supports\LanguageAdvancedManager;
use Botble\Payment\Enums\PaymentMethodEnum;
use Botble\Payment\Enums\PaymentStatusEnum;
use Botble\Payment\Models\Payment;
use Botble\Payment\Supports\PaymentHelper;
use Botble\RealEstate\Enums\ConsultStatusEnum;
use Botble\RealEstate\Enums\ModerationStatusEnum;
use Botble\RealEstate\Models\Account;
use Botble\RealEstate\Models\Category;
use Botble\RealEstate\Repositories\Interfaces\AccountInterface;
use Botble\RealEstate\Repositories\Interfaces\ConsultInterface;
use Botble\RealEstate\Repositories\Interfaces\PackageInterface;
use Botble\RealEstate\Repositories\Interfaces\PropertyInterface;
use Botble\RealEstate\Repositories\Interfaces\TransactionInterface;
use Botble\RealEstate\Tables\PropertyTable;
use Botble\Theme\Supports\ThemeSupport;
use Form;
use Html;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Language;
use Menu;
use MetaBox;
use RealEstateHelper;
use Route;
use Theme;

class HookServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->app->booted(function () {
            add_filter(BASE_FILTER_TOP_HEADER_LAYOUT, [$this, 'registerTopHeaderNotification'], 130);
            add_filter(BASE_FILTER_APPEND_MENU_NAME, [$this, 'getUnReadCount'], 130, 2);
            add_filter(BASE_FILTER_MENU_ITEMS_COUNT, [$this, 'getMenuItemCount'], 130);

            if (defined('MENU_ACTION_SIDEBAR_OPTIONS')) {
                Menu::addMenuOptionModel(Category::class);
                add_action(MENU_ACTION_SIDEBAR_OPTIONS, [$this, 'registerMenuOptions'], 13);
            }

            $this->app->booted(function () {
                if (defined('PAYMENT_FILTER_PAYMENT_PARAMETERS')) {
                    add_filter(PAYMENT_FILTER_PAYMENT_PARAMETERS, function ($html) {
                        if (! auth('account')->check()) {
                            return $html;
                        }

                        return $html . Form::hidden('customer_id', auth('account')->id())->toHtml() .
                            Form::hidden('customer_type', Account::class)->toHtml();
                    }, 123);
                }

                if (defined('PAYMENT_ACTION_PAYMENT_PROCESSED')) {
                    add_action(PAYMENT_ACTION_PAYMENT_PROCESSED, function ($data) {
                        $payment = PaymentHelper::storeLocalPayment($data);

                        MetaBox::saveMetaBoxData($payment, 'subscribed_packaged_id', session('subscribed_packaged_id'));
                    }, 123);

                    add_action(BASE_ACTION_META_BOXES, function ($context, $payment) {
                        if (get_class($payment) == Payment::class && $context == 'advanced' && Route::currentRouteName() == 'payments.show') {
                            MetaBox::addMetaBox('additional_payment_data', __('Package information'), function () use ($payment) {
                                $subscribedPackageId = MetaBox::getMetaData($payment, 'subscribed_packaged_id', true);

                                $package = app(PackageInterface::class)->findById($subscribedPackageId);

                                if (! $package) {
                                    return null;
                                }

                                return view('plugins/real-estate::partials.payment-extras', compact('package'));
                            }, get_class($payment), $context);
                        }
                    }, 128, 2);
                }

                if (defined('PAYMENT_FILTER_REDIRECT_URL')) {
                    add_filter(PAYMENT_FILTER_REDIRECT_URL, function ($checkoutToken) {
                        $checkoutToken = $checkoutToken ?: session('subscribed_packaged_id');

                        return route('public.account.package.subscribe.callback', $checkoutToken);
                    }, 123);
                }

                if (defined('PAYMENT_FILTER_CANCEL_URL')) {
                    add_filter(PAYMENT_FILTER_CANCEL_URL, function ($checkoutToken) {
                        $checkoutToken = $checkoutToken ?: session('subscribed_packaged_id');

                        if (str_contains($checkoutToken, url(''))) {
                            return $checkoutToken;
                        }

                        return route('public.account.package.subscribe', $checkoutToken) . '?' . http_build_query(['error' => true, 'error_type' => 'payment']);
                    }, 123);
                }

                if (defined('ACTION_AFTER_UPDATE_PAYMENT')) {
                    add_action(ACTION_AFTER_UPDATE_PAYMENT, function ($request, $payment) {
                        if (in_array($payment->payment_channel, [PaymentMethodEnum::COD, PaymentMethodEnum::BANK_TRANSFER])
                            && $request->input('status') == PaymentStatusEnum::COMPLETED
                            && $payment->status == PaymentStatusEnum::PENDING
                        ) {
                            $subscribedPackageId = MetaBox::getMetaData($payment, 'subscribed_packaged_id', true);

                            if (! $subscribedPackageId) {
                                return false;
                            }

                            $package = app(PackageInterface::class)->findById($subscribedPackageId);

                            if (! $package) {
                                return false;
                            }

                            $account = app(AccountInterface::class)->findById($payment->customer_id);

                            if (! $account) {
                                return false;
                            }

                            $account->credits += $package->number_of_listings;
                            $account->save();

                            $account->packages()->attach($package);

                            app(TransactionInterface::class)->createOrUpdate([
                                'user_id' => 0,
                                'account_id' => $payment->customer_id,
                                'credits' => $package->number_of_listings,
                                'payment_id' => $payment ? $payment->id : null,
                            ]);
                        }
                    }, 123, 2);
                }

                if (defined('PAYMENT_FILTER_PAYMENT_DATA')) {
                    add_filter(PAYMENT_FILTER_PAYMENT_DATA, function (array $data, Request $request) {
                        $orderIds = [session('subscribed_packaged_id')];

                        $package = $this->app->make(PackageInterface::class)
                            ->findById(Arr::first($orderIds));

                        $products = [
                            [
                                'id' => $package->id,
                                'name' => $package->name,
                                'price' => $package->price,
                                'price_per_order' => $package->price,
                                'qty' => 1,
                            ],
                        ];

                        $account = auth('account')->user();

                        $address = [
                            'name' => $account->name,
                            'email' => $account->email,
                            'phone' => $account->phone,
                            'country' => null,
                            'state' => null,
                            'city' => null,
                            'address' => null,
                            'zip' => null,
                        ];

                        return [
                            'amount' => (float)$package->price,
                            'shipping_amount' => 0,
                            'shipping_method' => null,
                            'tax_amount' => 0,
                            'discount_amount' => 0,
                            'currency' => strtoupper(get_application_currency()->title),
                            'order_id' => $orderIds,
                            'description' => trans('plugins/payment::payment.payment_description', ['order_id' => Arr::first($orderIds), 'site_url' => request()->getHost()]),
                            'customer_id' => $account->id,
                            'customer_type' => Account::class,
                            'return_url' => $request->input('return_url'),
                            'callback_url' => $request->input('callback_url'),
                            'products' => $products,
                            'orders' => [$package],
                            'address' => $address,
                            'checkout_token' => session('subscribed_packaged_id'),
                        ];
                    }, 120, 2);
                }

                add_filter(DASHBOARD_FILTER_ADMIN_LIST, function ($widgets) {
                    foreach ($widgets as $key => $widget) {
                        if (in_array($key, [
                                'widget_total_themes',
                                'widget_total_users',
                                'widget_total_plugins',
                                'widget_total_pages',
                            ]) && $widget['type'] == 'stats') {
                            Arr::forget($widgets, $key);
                        }
                    }

                    return $widgets;
                }, 150);

                add_filter(DASHBOARD_FILTER_ADMIN_LIST, function ($widgets, $widgetSettings) {
                    $items = app(PropertyInterface::class)
                        ->getModel()
                        ->notExpired()
                        ->where(RealEstateHelper::getPropertyDisplayQueryConditions())
                        ->count();

                    return (new DashboardWidgetInstance())
                        ->setType('stats')
                        ->setPermission('property.index')
                        ->setTitle(trans('plugins/real-estate::property.active_properties'))
                        ->setKey('widget_total_1')
                        ->setIcon('fas fa-briefcase')
                        ->setColor('#8e44ad')
                        ->setStatsTotal($items)
                        ->setRoute(route('property.index', [
                            'filter_table_id' => strtolower(Str::slug(Str::snake(PropertyTable::class))),
                            'class' => PropertyTable::class,
                            'filter_columns' => [
                                'status',
                            ],
                            'filter_operators' => [
                                '=',
                            ],
                            'filter_values' => [
                                'active',
                            ],
                        ]))
                        ->init($widgets, $widgetSettings);
                }, 2, 2);

                add_filter(DASHBOARD_FILTER_ADMIN_LIST, function ($widgets, $widgetSettings) {
                    $items = app(PropertyInterface::class)
                        ->getModel()
                        ->notExpired()
                        ->where('moderation_status', ModerationStatusEnum::PENDING)
                        ->count();

                    return (new DashboardWidgetInstance())
                        ->setType('stats')
                        ->setPermission('property.index')
                        ->setTitle(trans('plugins/real-estate::property.pending_properties'))
                        ->setKey('widget_total_2')
                        ->setIcon('fas fa-briefcase')
                        ->setColor('#32c5d2')
                        ->setStatsTotal($items)
                        ->setRoute(route('property.index', [
                            'filter_table_id' => strtolower(Str::slug(Str::snake(PropertyTable::class))),
                            'class' => PropertyTable::class,
                            'filter_columns' => [
                                'moderation_status',
                            ],
                            'filter_operators' => [
                                '=',
                            ],
                            'filter_values' => [
                                ModerationStatusEnum::PENDING,
                            ],
                        ]))
                        ->init($widgets, $widgetSettings);
                }, 3, 2);

                add_filter(DASHBOARD_FILTER_ADMIN_LIST, function ($widgets, $widgetSettings) {
                    $items = app(PropertyInterface::class)
                        ->getModel()
                        ->expired()
                        ->count();

                    return (new DashboardWidgetInstance())
                        ->setType('stats')
                        ->setPermission('property.index')
                        ->setTitle(trans('plugins/real-estate::property.expired_properties'))
                        ->setKey('widget_total_3')
                        ->setIcon('fas fa-briefcase')
                        ->setColor('#e7505a')
                        ->setStatsTotal($items)
                        ->setRoute(route('property.index', [
                            'filter_table_id' => strtolower(Str::slug(Str::snake(PropertyTable::class))),
                            'class' => PropertyTable::class,
                            'filter_columns' => [
                                'status',
                            ],
                            'filter_operators' => [
                                '=',
                            ],
                            'filter_values' => [
                                'expired',
                            ],
                        ]))
                        ->init($widgets, $widgetSettings);
                }, 4, 2);

                add_filter(DASHBOARD_FILTER_ADMIN_LIST, function ($widgets, $widgetSettings) {
                    $items = app(AccountInterface::class)->count();

                    return (new DashboardWidgetInstance())
                        ->setType('stats')
                        ->setPermission('account.index')
                        ->setTitle(trans('plugins/real-estate::account.agents'))
                        ->setKey('widget_total_4')
                        ->setIcon('fas fa-users')
                        ->setColor('#3598dc')
                        ->setStatsTotal($items)
                        ->setRoute(route('account.index'))
                        ->init($widgets, $widgetSettings);
                }, 5, 2);
            });

            if (defined('LANGUAGE_MODULE_SCREEN_NAME')) {
                add_action(BASE_ACTION_META_BOXES, [$this, 'addLanguageChooser'], 55, 2);
            }

            add_filter('social_login_before_saving_account', function ($data, $oAuth, $providerData) {
                if (Arr::get($providerData, 'model') == Account::class && Arr::get($providerData, 'guard') == 'account') {
                    $firstName = implode(' ', explode(' ', $oAuth->getName(), -1));
                    Arr::forget($data, 'name');
                    $data = array_merge($data, [
                        'first_name' => $firstName,
                        'last_name' => trim(str_replace($firstName, '', $oAuth->getName())),
                    ]);
                }

                return $data;
            }, 49, 3);

            if (is_plugin_active('language') && is_plugin_active('language-advanced')) {
                add_filter(BASE_FILTER_BEFORE_RENDER_FORM, function ($form, $data) {
                    if (is_in_admin() &&
                        request()->segment(1) === 'account' &&
                        Auth::guard('account')->check() &&
                        Language::getCurrentAdminLocaleCode() != Language::getDefaultLocaleCode() &&
                        $data &&
                        $data->id &&
                        LanguageAdvancedManager::isSupported($data)
                    ) {
                        $refLang = null;

                        if (Language::getCurrentAdminLocaleCode() != Language::getDefaultLocaleCode()) {
                            $refLang = '?ref_lang=' . Language::getCurrentAdminLocaleCode();
                        }

                        $form->setFormOption(
                            'url',
                            route('public.account.language-advanced.save', $data->id) . $refLang
                        );
                    }

                    return $form;
                }, 9999, 2);
            }

            add_filter('account_dashboard_header', function ($html) {
                $customCSSFile = public_path(Theme::path() . '/css/style.integration.css');
                if (File::exists($customCSSFile)) {
                    $html .= Html::style(Theme::asset()
                        ->url('css/style.integration.css?v=' . filectime($customCSSFile)));
                }

                return $html . ThemeSupport::getCustomJS('header');
            }, 15);
        });
    }

    public function registerTopHeaderNotification(?string $options): ?string
    {
        if (Auth::user()->hasPermission('consults.edit')) {
            $consults = $this->app->make(ConsultInterface::class)
                ->advancedGet([
                    'condition' => [
                        'status' => ConsultStatusEnum::UNREAD,
                    ],
                    'paginate' => [
                        'per_page' => 10,
                        'current_paged' => 1,
                    ],
                    'select' => ['id', 'name', 'email', 'phone', 'created_at'],
                    'order_by' => ['created_at' => 'DESC'],
                ]);

            if ($consults->count() == 0) {
                return $options;
            }

            return $options . view('plugins/real-estate::notification', compact('consults'))->render();
        }

        return $options;
    }

    public function getUnReadCount(?string $number, string $menuId): ?string
    {
        if ($menuId == 'cms-plugins-consult') {
            $attributes = [
                'class' => 'badge badge-success menu-item-count unread-consults',
                'style' => 'display: none;',
            ];

            return Html::tag('span', '', $attributes)->toHtml();
        }

        return $number;
    }

    public function getMenuItemCount(array $data = []): array
    {
        if (Auth::user()->hasPermission('consult.index')) {
            $data[] = [
                'key' => 'unread-consults',
                'value' => app(ConsultInterface::class)->countUnread(),
            ];
        }

        return $data;
    }

    public function registerMenuOptions(): void
    {
        if (Auth::user()->hasPermission('property_category.index')) {
            Menu::registerMenuOptions(Category::class, trans('plugins/real-estate::category.menu'));
        }
    }

    public function addLanguageChooser(string $priority, ?Model $model): void
    {
        if ($priority == 'head' && $model instanceof Category) {
            echo view('plugins/language::partials.admin-list-language-chooser', [
                'route' => 'property_category.index',
            ])->render();
        }
    }
}
