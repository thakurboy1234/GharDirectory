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
                        {{-- @foreach($packages as $package)
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
                        @endforeach --}}

                        @foreach($packages as $package)
                        <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-xs-12" style="margin-top: 30px;">
                            <div class="packages__cardWrapNew">
                                <h2>{{$package->name}}</h2>
                                <ul class="price__area">
                                    <li><p class="old_price">₹ @if($package->id == 1){{$package->price+2000}}@endif @if($package->id == 2){{$package->price+3000}}@endif @if($package->id == 3){{$package->price+5000}}@endif  @if($package->id == 4){{$package->price+10000}}@endif</p></li>
                                    <li><p class="new_price">₹ {{$package->price}}<br><small>exclusive of GST</small></p></li>
                                    <li><p class="save_amount">You save: ₹ @if($package->id == 1)2000 @endif @if($package->id == 2)3000 @endif @if($package->id == 3)5000 @endif  @if($package->id == 4)10000 @endif</p></li>
                                </ul>
                                <div class="buy__btn">
                                    <a href="{{route('public.account.package.subscribe', $package->id)}}">buy now</a>
                                </div>
                                <div class="list__detail">
                                    <ul>
                                        <li><p>{{$package->number_of_listings}} Property Listings</p></li>
                                        <li><p>{{$package->duration}} Days Validity</p></li>
                                        <li><p><b>{{$package->total_leads}} Qualified Leads</b></p></li>
                                        <li><p>Budget Base Leads</p></li>
                                        <li><p>Location Base Leads</p></li>
                                        @if($package->id != 1)
                                             <li><p>Expert Photography/Videography</p></li>
                                         @endif
                                        @if($package->id != 1 && $package->id !=2 && $package->id !=3 )
                                            <li><p>Min. 80% Qualified Leads</p></li>
                                            <li><p>Dedicated Executive</p></li>
                                            <li><p>10000 WhatsApp Messaging</p></li>
                                            <li><p>Voiceover Audio Ad (1 No.)</p></li>
                                         @elseif($package->id != 1 && $package->id !=2)
                                         <li><p>Min. 60% Qualified Leads</p></li>
                                         <li><p>Dedicated Executive</p></li>
                                        @endif
                                        <li><p>Directory Expert Listing</p></li>
                                        <li><p>Suitable For Property Budget upto {{format_price($package->maximal_property_budget)}} </p></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @endforeach

                        {{-- <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-xs-12" style="margin-top: 30px;">
                            <div class="packages__cardWrapNew">
                                <h2>basic</h2>
                                <ul class="price__area">
                                    <li><p class="old_price">₹ 9500</p></li>
                                    <li><p class="new_price">₹ 8500<br><small>exclusive of GST</small></p></li>
                                    <li><p class="save_amount">You save: ₹ 1000</p></li>
                                </ul>
                                <div class="buy__btn">
                                    <a href="#!">buy now</a>
                                </div>
                                <div class="list__detail">
                                    <ul>
                                        <li><p>5 Property Listings</p></li>
                                        <li><p>30 Days Validity</p></li>
                                        <li><p><sup>*</sup>Qualified Leads<sup>*</sup></p></li>
                                        <li><p>Budget Base Leads</p></li>
                                        <li><p>Location Base Leads</p></li>
                                        <li><p>Directory Expert Listing</p></li>
                                        <li><p>Suitable For Property Budget upto 50 Lakhs<sup>*</sup></p></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-xs-12" style="margin-top: 30px;">
                            <div class="packages__cardWrapNew">
                                <h2>premium</h2>
                                <ul class="price__area">
                                    <li><p class="old_price">₹ 14900</p></li>
                                    <li><p class="new_price">₹ 15900<br><small>exclusive of GST</small></p></li>
                                    <li><p class="save_amount">You save: ₹ 1000</p></li>
                                </ul>
                                <div class="buy__btn">
                                    <a href="#!">buy now</a>
                                </div>
                                <div class="list__detail">
                                    <ul>
                                        <li><p>12 Property Listings</p></li>
                                        <li><p>30 Days Validity</p></li>
                                        <li><p><sup>*</sup>50 Qualified Leads<sup>*</sup></p></li>
                                        <li><p>Budget Base Leads</p></li>
                                        <li><p>Location Base Leads</p></li>
                                        <li><p>Expert Photography/Videography</p></li>
                                        <li><p>Directory Expert Listing</p></li>
                                        <li><p>Suitable For Property Budget 50-70 Lakhs</p></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-xs-12" style="margin-top: 30px;">
                            <div class="packages__cardWrapNew">
                                <h2>premium plus</h2>
                                <ul class="price__area">
                                    <li><p class="old_price">₹ 25900</p></li>
                                    <li><p class="new_price">₹ 35900<br><small>exclusive of GST</small></p></li>
                                    <li><p class="save_amount">You save: ₹ 1000</p></li>
                                </ul>
                                <div class="buy__btn">
                                    <a href="#!">buy now</a>
                                </div>
                                <div class="list__detail">
                                    <ul>
                                        <li><p>15 Property Listings</p></li>
                                        <li><p>1 Featured Project Listing</p></li>
                                        <li><p>60 Days Validity</p></li>
                                        <li><p><sup>*</sup>100 Qualified Leads<sup>*</sup></p></li>
                                        <li><p>Location Base Leads</p></li>
                                        <li><p>Budget Based Leads</p></li>
                                        <li><p>Min. 60% Qualified Leads</p></li>
                                        <li><p>Dedicated Executive</p></li>
                                        <li><p>Expert Photography/Videography</p></li>
                                        <li><p>Directory Expert Listing</p></li>
                                        <li><p>Suitable For Property Budget 60- 80 Lakhs<sup>*</sup></p></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-xs-12" style="margin-top: 30px;">
                            <div class="packages__cardWrapNew">
                                <h2>online assistance</h2>
                                <ul class="price__area">
                                    <li><p class="old_price">₹ 55900</p></li>
                                    <li><p class="new_price">₹ 65900<br><small>exclusive of GST</small></p></li>
                                    <li><p class="save_amount">You save: ₹ 1000</p></li>
                                </ul>
                                <div class="buy__btn">
                                    <a href="#!">buy now</a>
                                </div>
                                <div class="list__detail">
                                    <ul>
                                        <li><p>30 Property Listings</p></li>
                                        <li><p>5 Featured Project Listings</p></li>
                                        <li><p>90 Days Validity</p></li>
                                        <li><p><sup>*</sup>150 Qualified Leads<sup>*</sup></p></li>
                                        <li><p>Location Base Leads</p></li>
                                        <li><p>Project Base Leads</p></li>
                                        <li><p>Budget Based Leads</p></li>
                                        <li><p>Min. 80% Qualified Leads</p></li>
                                        <li><p>Dedicated Executive</p></li>
                                        <li><p>Expert Photography/Videography</p></li>
                                        <li><p>10000 WhatsApp Messaging</p></li>
                                        <li><p>Voiceover Audio Ad (1 No.)</p></li>
                                        <li><p>Directory Expert Listing</p></li>
                                        <li><p>Suitable For Property Budget above 80 Lakhs<sup>*</sup></p></li>
                                    </ul>
                                </div>
                            </div>
                        </div> --}}
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
