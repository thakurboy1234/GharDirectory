<?php

namespace Botble\Dashboard\Http\Controllers;

use Assets;
use Botble\ACL\Repositories\Interfaces\UserInterface;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Dashboard\Repositories\Interfaces\DashboardWidgetInterface;
use Botble\Dashboard\Repositories\Interfaces\DashboardWidgetSettingInterface;
use Botble\RealEstate\Repositories\Interfaces\AccountInterface;
use Botble\RealEstate\Repositories\Interfaces\ConsultInterface;
use Botble\RealEstate\Repositories\Interfaces\PropertyInterface;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class DashboardController extends BaseController
{
    protected DashboardWidgetSettingInterface $widgetSettingRepository;

    protected DashboardWidgetInterface $widgetRepository;

    protected UserInterface $userRepository;

    public function __construct(
        DashboardWidgetSettingInterface $widgetSettingRepository,
        DashboardWidgetInterface $widgetRepository,
        UserInterface $userRepository
    ) {
        $this->widgetSettingRepository = $widgetSettingRepository;
        $this->widgetRepository = $widgetRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @param Request $request
     * @return Factory|Application|View
     */
    public function getDashboard(Request $request)
    {
        page_title()->setTitle(trans('core/dashboard::dashboard.title'));

        Assets::addScripts(['blockui', 'sortable', 'equal-height', 'counterup'])
            ->addScriptsDirectly('vendor/core/core/dashboard/js/dashboard.js')
            ->addStylesDirectly('vendor/core/core/dashboard/css/dashboard.css')
            ->usingVueJS();

        do_action(DASHBOARD_ACTION_REGISTER_SCRIPTS);

        /**
         * @var Collection $widgets
         */
        $widgets = $this->widgetRepository->getModel()
            ->with([
                'settings' => function (HasMany $query) use ($request) {
                    $query->where('user_id', $request->user()->getKey())
                        ->select(['status', 'order', 'settings', 'widget_id'])
                        ->orderBy('order');
                },
            ])
            ->select(['id', 'name'])
            ->get();

        $widgetData = apply_filters(DASHBOARD_FILTER_ADMIN_LIST, [], $widgets);
        ksort($widgetData);

        $availableWidgetIds = collect($widgetData)->pluck('id')->all();

        $widgets = $widgets->reject(function ($item) use ($availableWidgetIds) {
            return ! in_array($item->id, $availableWidgetIds);
        });
       $totalVendor= app(AccountInterface::class)
                        ->getModel()
                        ->count();
       $activeVendor= app(AccountInterface::class)
                        ->getModel()
                        ->where('credits','>',0)
                        ->count();
       $inActiveVendor= app(AccountInterface::class)
                        ->getModel()
                        ->where('credits','==',0)
                        ->orwhere('credits',null)
                        ->count();
       $totalLeads= app(ConsultInterface::class)
                        ->getModel()
                        ->count();
       $inActiveVendorFilter = "filter_table_id=botble-real-estate-tables-account-table&class=Botble%5CRealEstate%5CTables%5CPropertyTable&filter_columns%5B0%5D=credits&filter_operators%5B0%5D=<&filter_values%5B0%5D=1" ;
       $activeVendorFilter = "filter_table_id=botble-real-estate-tables-account-table&class=Botble%5CRealEstate%5CTables%5CPropertyTable&filter_columns%5B0%5D=credits&filter_operators%5B0%5D=>=&filter_values%5B0%5D=1" ;

        $statWidgets = collect($widgetData)->where('type', '!=', 'widget')->pluck('view')->all();
        $userWidgets = collect($widgetData)->where('type', 'widget')->pluck('view')->all();

        return view('core/dashboard::list', compact(
            'widgets',
            'userWidgets',
            'statWidgets',
            'totalVendor',
            'totalLeads',
            'activeVendor',
            'inActiveVendor',
            'inActiveVendorFilter',
            'activeVendorFilter',

        ));
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function postEditWidgetSettingItem(Request $request, BaseHttpResponse $response)
    {
        try {
            $widget = $this->widgetRepository->getFirstBy([
                'name' => $request->input('name'),
            ]);

            if (! $widget) {
                return $response
                    ->setError()
                    ->setMessage(trans('core/dashboard::dashboard.widget_not_exists'));
            }

            $widgetSetting = $this->widgetSettingRepository->firstOrCreate([
                'widget_id' => $widget->id,
                'user_id' => $request->user()->getKey(),
            ]);

            $widgetSetting->settings = array_merge((array)$widgetSetting->settings, [
                $request->input('setting_name') => $request->input('setting_value'),
            ]);

            $this->widgetSettingRepository->createOrUpdate($widgetSetting);
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }

        return $response;
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function postUpdateWidgetOrder(Request $request, BaseHttpResponse $response)
    {
        foreach ($request->input('items', []) as $key => $item) {
            $widget = $this->widgetRepository->firstOrCreate([
                'name' => $item,
            ]);
            $widgetSetting = $this->widgetSettingRepository->firstOrCreate([
                'widget_id' => $widget->id,
                'user_id' => $request->user()->getKey(),
            ]);
            $widgetSetting->order = $key;
            $this->widgetSettingRepository->createOrUpdate($widgetSetting);
        }

        return $response->setMessage(trans('core/dashboard::dashboard.update_position_success'));
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function getHideWidget(Request $request, BaseHttpResponse $response)
    {
        $widget = $this->widgetRepository->getFirstBy([
            'name' => $request->input('name'),
        ], ['id']);
        if (! empty($widget)) {
            $widgetSetting = $this->widgetSettingRepository->firstOrCreate([
                'widget_id' => $widget->id,
                'user_id' => $request->user()->getKey(),
            ]);

            $widgetSetting->status = 0;
            $widgetSetting->order = 99 + $widgetSetting->id;
            $this->widgetRepository->createOrUpdate($widgetSetting);
        }

        return $response->setMessage(trans('core/dashboard::dashboard.hide_success'));
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function postHideWidgets(Request $request, BaseHttpResponse $response)
    {
        $widgets = $this->widgetRepository->all();
        foreach ($widgets as $widget) {
            $widgetSetting = $this->widgetSettingRepository->firstOrCreate([
                'widget_id' => $widget->id,
                'user_id' => $request->user()->getKey(),
            ]);

            if (array_key_exists($widget->name, $request->input('widgets', [])) &&
                $request->input('widgets.' . $widget->name) == 1
            ) {
                $widgetSetting->status = 1;
                $this->widgetRepository->createOrUpdate($widgetSetting);
            } else {
                $widgetSetting->status = 0;
                $widgetSetting->order = 99 + $widgetSetting->id;
                $this->widgetRepository->createOrUpdate($widgetSetting);
            }
        }

        return $response
            ->setNextUrl(route('dashboard.index'))
            ->setMessage(trans('core/dashboard::dashboard.hide_success'));
    }
}
