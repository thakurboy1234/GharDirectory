<?php

namespace Botble\RealEstate\Forms;

use Assets;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Forms\FormAbstract;
use Botble\RealEstate\Http\Requests\PackageRequest;
use Botble\RealEstate\Models\Package;
use Botble\RealEstate\Repositories\Interfaces\CurrencyInterface;
use RealEstateHelper;

class PackageForm extends FormAbstract
{
    protected CurrencyInterface $currencyRepository;

    public function __construct(CurrencyInterface $currencyRepository)
    {
        parent::__construct();
        $this->currencyRepository = $currencyRepository;
    }

    public function buildForm(): void
    {
        Assets::addScripts(['input-mask']);

        $currencies = $this->currencyRepository->pluck('title', 'id');

        $this
            ->setupModel(new Package())
            ->setValidatorClass(PackageRequest::class)
            ->withCustomFields()
            ->add('name', 'text', [
                'label' => trans('core/base::forms.name'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'placeholder' => trans('core/base::forms.name_placeholder'),
                    'data-counter' => 120,
                ],
            ])
            ->add('rowOpen1', 'html', [
                'html' => '<div class="row">',
            ])
            ->add('price', 'text', [
                'label' => trans('plugins/real-estate::package.price'),
                'label_attr' => ['class' => 'control-label'],
                'wrapper' => [
                    'class' => 'form-group mb-3 col-md-3',
                ],
                'attr' => [
                    'id' => 'price-number',
                    'placeholder' => trans('plugins/real-estate::package.price'),
                    'class' => 'form-control input-mask-number',
                    'data-thousands-separator' => RealEstateHelper::getThousandSeparatorForInputMask(),
                    'data-decimal-separator' => RealEstateHelper::getDecimalSeparatorForInputMask(),
                ],
            ])
            ->add('currency_id', 'customSelect', [
                'label' => trans('plugins/real-estate::package.currency'),
                'label_attr' => ['class' => 'control-label'],
                'wrapper' => [
                    'class' => 'form-group mb-3 col-md-3',
                ],
                'attr' => [
                    'class' => 'form-control select-full',
                ],
                'choices' => $currencies,
            ])
            ->add('gst', 'text', [
                'label' => trans('plugins/real-estate::package.gst'),
                'label_attr' => ['class' => 'control-label'],
                'wrapper' => [
                    'class' => 'form-group mb-3 col-md-3',
                ],
                'attr' => [
                    'id' => 'gst',
                    'placeholder' => trans('plugins/real-estate::package.gst'),
                    'class' => 'form-control input-mask-number',
                ],
            ])
            ->add('maximal_property_budget', 'text', [
                'label' => trans('plugins/real-estate::package.maximal_property_budget'),
                'label_attr' => ['class' => 'control-label'],
                'wrapper' => [
                    'class' => 'form-group mb-3 col-md-3',
                ],
                'attr' => [
                    'id' => 'gst',
                    'placeholder' => trans('plugins/real-estate::package.maximal_property_budget'),
                    'class' => 'form-control input-mask-number',
                ],
            ])
            ->add('rowClose1', 'html', [
                'html' => '</div>',
            ])


            ->add('rowOpen2', 'html', [
                'html' => '<div class="row">',
            ])
            ->add('total_leads', 'text', [
                'label' => trans('plugins/real-estate::package.total_leads'),
                'label_attr' => ['class' => 'control-label'],
                'wrapper' => [
                    'class' => 'form-group mb-3 col-md-3',
                ],
                'attr' => [
                    'id' => 'percent-save-number',
                    'placeholder' => trans('plugins/real-estate::package.total_leads'),
                    'class' => 'form-control input-mask-number',
                ],
            ])
            ->add('number_of_listings', 'text', [
                'label' => trans('plugins/real-estate::package.number_of_listings'),
                'label_attr' => ['class' => 'control-label'],
                'wrapper' => [
                    'class' => 'form-group mb-3 col-md-3',
                ],
                'attr' => [
                    'id' => 'price-number',
                    'placeholder' => trans('plugins/real-estate::package.number_of_listings'),
                    'class' => 'form-control input-mask-number',
                ],
            ])
            ->add('duration', 'text', [
                'label' => trans('plugins/real-estate::package.duration'),
                'label_attr' => ['class' => 'control-label'],
                'wrapper' => [
                    'class' => 'form-group mb-3 col-md-3',
                ],
                'attr' => [
                    'id' => 'price-number',
                    'placeholder' => trans('plugins/real-estate::package.duration_in_days'),
                    'class' => 'form-control input-mask-number',
                ],
            ])
            ->add('account_limit', 'text', [
                'label' => trans('plugins/real-estate::package.account_limit'),
                'label_attr' => ['class' => 'control-label'],
                'wrapper' => [
                    'class' => 'form-group mb-3 col-md-3',
                ],
                'attr' => [
                    'id' => 'percent-save-number',
                    'placeholder' => trans('plugins/real-estate::package.account_limit_placeholder'),
                    'class' => 'form-control input-mask-number',
                ],
            ])
            ->add('rowClose2', 'html', [
                'html' => '</div>',
            ])

            ->add('is_default', 'onOff', [
                'label' => trans('core/base::forms.is_default'),
                'label_attr' => ['class' => 'control-label'],
                'default_value' => false,
            ])
            ->add('order', 'number', [
                'label' => trans('core/base::forms.order'),
                'label_attr' => ['class' => 'control-label'],
                'attr' => [
                    'placeholder' => trans('core/base::forms.order_by_placeholder'),
                ],
                'default_value' => 0,
            ])
            ->add('status', 'customSelect', [
                'label' => trans('core/base::tables.status'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'class' => 'form-control select-full',
                ],
                'choices' => BaseStatusEnum::labels(),
            ])
            ->setBreakFieldPoint('status');
    }
}
