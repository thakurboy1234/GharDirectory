<section class="main-homes">
    <div class="bgheadproject hidden-xs" style="background: url('{{ theme_option('breadcrumb_background') ? RvMedia::url(theme_option('breadcrumb_background')) : Theme::asset()->url('images/banner-du-an.jpg') }}')">
        <div class="description">
            <div class="container-fluid w90">
                <h1 class="text-center">{{ __('Packages') }}</h1>
                {!! Theme::partial('breadcrumb') !!}
            </div>
        </div>
    </div>
    <div class="container-fluid w90 padtop30">
        <div class="rowm10">
            @if ($packages->count())
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="pricing__heading">
                                <h2>Pricing</h2>
                                <p>Everything you need to capture leads and turn them into customers.</p>
                            </div>
                        </div>
                    </div>
                    <div class="row flex-items-xs-middle flex-items-xs-center justify-content-center">
                        @foreach($packages as $package)
                        <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-xs-12" style="margin-top: 30px;">
                            <div class="packages__cardWrap">
                                <h2><span>{{$package->name}}</span><small> (for property budget upto {{ format_price($package->maximal_property_budget)}})</small></h2>
                                <h3>price: {{$package->price}} <small>@if($package->price != 0) (+18% gst) @endif</small></h3>
                                <div class="ul__listing">
                                    <ul>
                                        <li>free {{$package->total_leads}} leads</li>
                                        <li>{{$package->number_of_listings}} property listing</li>
                                        <li>{{$package->duration}} days duration</li>
                                    </ul>
                                </div>

                                <div class="buy__btn">
                                    <a class="btn" href="{{route('public.account.package.subscribe', $package->id)}}"> buy now</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            @else
                <p class="item">{{ __('0 results') }}</p>
            @endif
        </div>
    </div>
    {{-- {!! Theme::scope('real-estate.package', compact('packages'))->render() !!} --}}
</section>
<br>
<br>
