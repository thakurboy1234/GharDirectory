@extends('plugins/real-estate::account.layouts.skeleton')
@section('content')
    <div class="settings">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xs-12">
                    @include('plugins/payment::partials.form', [
                        'action'       => route('payments.checkout'),
                        'currency'     => $package->currency->title ? strtoupper($package->currency->title) : cms_currency()->getDefaultCurrency()->title,
                        'amount'       =>   ($package->gst != 0) ? ($package->price  * ((100 + $package->gst) / 100))  : ($package->price) ,
                        'name'         => $package->name,
                        'returnUrl'   => route('public.account.package.subscribe', $package->id),
                        'callbackUrl' => route('public.account.package.subscribe.callback', $package->id),
                    ])
                </div>
            </div>
        </div>
    </div>
@stop
