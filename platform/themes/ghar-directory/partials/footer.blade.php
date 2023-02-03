        <div class="old-footer-as-without chage" style="display: none;">
            <!--FOOTER-->
            <section class="top__footer" >
                <div class="container-fluid w90">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="menu__top__footer">
                                <ul>
                                    <li><a href="{{ route('public.properties-by-city', 'chandigarh') }}">Properties for sale in Chandigarh</a></li>
                                    {{-- <li><a href="#!">Properties For Sale</a></li> --}}
                                    {{-- <li><a href="#!">Link</a></li>
                                    <li><a href="#!">Link</a></li>
                                    <li><a href="#!">Link</a></li> --}}
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="menu__top__footer">
                                <ul>
                                    <li><a href="{{ route('public.properties-by-city', 'gurugram') }}">Properties for sale in Gurugram</a></li>
                                    {{-- <li><a href="#!">Properties For Sale</a></li> --}}
                                    {{-- <li><a href="#!">Link</a></li>
                                    <li><a href="#!">Link</a></li>
                                    <li><a href="#!">Link</a></li> --}}
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="menu__top__footer">
                                <ul>
                                    <li><a href="{{ route('public.properties-by-city', 'mohali') }}">Properties for sale in Mohali</a></li>
                                    {{-- <li><a href="#!">Properties For Sale</a></li> --}}
                                    {{-- <li><a href="#!">Link</a></li>
                                    <li><a href="#!">Link</a></li>
                                    <li><a href="#!">Link</a></li>
                                </ul> --}}
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="menu__top__footer">
                                <ul>
                                    <li><a href="{{ route('public.properties-by-city', 'zirakpur') }}">Properties for sale in Zirakpur</a></li>
                                    {{-- <li><a href="#!">Properties For Sale</a></li> --}}
                                    {{-- <li><a href="#!">Link</a></li>
                                    <li><a href="#!">Link</a></li>
                                    <li><a href="#!">Link</a></li>
                                </ul> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <footer >
                <br>
                <div class="container-fluid w90">
                    <div class="row">
                        <div class="col-sm-3">
                            @if (theme_option('logo'))
                                <p>
                                    <a href="{{ route('public.index') }}">
                                        <img src="{{ RvMedia::getImageUrl(theme_option('logo'))  }}" style="max-height: 38px" alt="{{ theme_option('site_name') }}">
                                    </a>
                                </p>
                            @endif
                            @if (theme_option('address'))
                                <p><i class="fas fa-map-marker-alt"></i> &nbsp;{{ theme_option('address') }}</p>
                            @endif
                            @if (theme_option('hotline'))
                                <p><i class="fas fa-phone-square"></i> {{ __('Hotline') }}: &nbsp;<a href="tel:{{ theme_option('hotline') }}">{{ theme_option('hotline') }}</a></p>
                            @endif
                            @if (theme_option('email'))
                                <p><i class="fas fa-envelope"></i> {{ __('Email') }}: &nbsp;<a href="mailto:{{ theme_option('email') }}">{{ theme_option('email') }}</a></p>
                            @endif
                        </div>
                        <div class="col-sm-9 padtop10">
                            <div class="row">
                                {!! dynamic_sidebar('footer_sidebar') !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            {!! Theme::partial('language-switcher') !!}
                        </div>
                    </div>
                    <div class="copyright">
                        <div class="col-sm-12">
                            <p class="text-center">
                                {!! BaseHelper::clean(theme_option('copyright')) !!}
                            </p>
                        </div>
                    </div>
                </div>
            </footer>
            <!--FOOTER-->
        </div>



     <!--FOOTER-->
     {{-- <section class="top__footer" >
        <div class="container-fluid w90">
            <div class="row">
                <div class="col-sm-3">
                    <div class="menu__top__footer">
                        <ul>
                            <li><a href="{{ route('public.properties-by-city', 'chandigarh') }}">Properties for sale in Chandigarh</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="menu__top__footer">
                        <ul>
                            <li><a href="{{ route('public.properties-by-city', 'gurugram') }}">Properties for sale in Gurugram</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="menu__top__footer">
                        <ul>
                            <li><a href="{{ route('public.properties-by-city', 'mohali') }}">Properties for sale in Mohali</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="menu__top__footer">
                        <ul>
                            <li><a href="{{ route('public.properties-by-city', 'zirakpur') }}">Properties for sale in Zirakpur</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    <footer class="footer__new">
        <br>
        <div class="container-fluid w90">
            <div class="row">
                {{-- <div class="col-sm-3 padtop10">
                    <div class="menufooter menufooter__new">
                        <h4>Address</h4>
                            @if (theme_option('address'))
                                <p><i class="fas fa-map-marker-alt"></i> &nbsp;{{ theme_option('address') }}</p>
                            @endif
                            @if (theme_option('hotline'))
                                <p><i class="fas fa-phone-square"></i> {{ __('Hotline') }}: &nbsp;<a href="tel:{{ theme_option('hotline') }}">{{ theme_option('hotline') }}</a></p>
                            @endif
                            @if (theme_option('email'))
                                <p><i class="fas fa-envelope"></i> {{ __('Email') }}: &nbsp;<a href="mailto:{{ theme_option('email') }}">{{ theme_option('email') }}</a></p>
                            @endif
                    </div>
                </div> --}}
                <div class="col-sm-12 padtop10">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="menufooter menufooter__new">
                                <h4>More information</h4>
                                <ul>
                                    <li>
                                        <a href="{{url('/about-us')}}">
                                            <span>About us</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{url('/contact')}}">
                                            <span>Contact us</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{url('/terms-conditions')}}">
                                            <span>Terms &amp; Conditions</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{url('/packages')}}">
                                            <span>Our &amp; Packages</span>
                                        </a>
                                    </li>
                                </ul>

                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="menufooter menufooter__new">
                                <h4>Properties by locations
                                </h4>
                                <ul>
                                    <li>
                                        <a href="{{ route('public.properties-by-city', 'chandigarh') }}">
                                            <span>Properties for sale in Chandigarh</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('public.properties-by-city', 'gurugram') }}">
                                            <span>Properties for sale in Gurugram</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('public.properties-by-city', 'mohali') }}">
                                            <span>Properties for sale in Mohali</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('public.properties-by-city', 'zirakpur') }}">
                                            <span>Properties for sale in Zirakpur</span>
                                        </a>
                                    </li>
                                </ul>

                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="menufooter menufooter__new">
                                <h4>Social Links</h4>
                                <div class="bottom-socials">
                                    @if (theme_option('social_links'))
                                        @foreach(json_decode(theme_option('social_links'), true) as $socialLink)
                                            @if (count($socialLink) == 3)
                                                <a href="{{ $socialLink[2]['value'] }}"
                                                   title="{{ $socialLink[0]['value'] }}" target="_blank">
                                                    <i class="{{ $socialLink[1]['value'] }}"></i>
                                                </a>
                                            @endif
                                        @endforeach
                                    </div>
                                    @endif

                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">

                </div>
            </div>
            <div class="copyright">
                <div class="col-sm-12">
                    <p class="text-center text-white m-0">
                        {!! BaseHelper::clean(theme_option('copyright')) !!}
                    </p>
                </div>
            </div>
        </div>
    </footer>
    <!--FOOTER-->

{{-- mobile footer navigation --}}

@if(!request()->routeIs('public.account.login'))
<div class="mobileNavigation d-xl-none d-lg-none d-md-none d-sm-none d-block">
    <ul>
        <li class="{{ request()->routeIs('public.index') ? 'active' : '' }}">
            <a href="{{ route('public.index') }}">
                <em class="mobNav home"><i class="far fa-home"></i></em>
                <small>Home</small>
            </a>

        </li>
        <li data-toggle="modal" data-target="#Modalcity" class="{{ request()->routeIs('public.properties-by-city') ? 'active' : '' }}">
            <em class="mobNav search"><i class="far fa-search"></i></em>
            <small>Search</small>
        </li>
        <li data-toggle="modal" >
        <a href="{{ route('public.account.properties.index') }}" >
            <span>
                <em class="mobNav ourServicesEm"><i class="far fa-plus"></i></em>
            </span>
        </a>
        </li>
        <li class="{{ request()->routeIs('public.wishlist') ? 'active' : '' }}">
            @if (RealEstateHelper::isEnabledWishlist())
                <a href="{{ route('public.wishlist') }}">
                    <em class="mobNav ahortlist"><i class="far fa-heart"></i></em>
                    <small>Wishlist</small>
                </a>
            @endif
        </li>
        <li class="{{ request()->routeIs('public.account.login') ? 'active' : '' }}">
            @if (is_plugin_active('real-estate') && RealEstateHelper::isRegisterEnabled())
                <a href="{{ (auth('account')->check()) ?  route('public.account.dashboard')  :  route('public.account.login') }} ">
                    <em class="mobNav account"><i class="far fa-user"></i></em>
                    <small>Account</small>
                </a>
            @endif
        </li>
    </ul>
</div>
@endif

{{-- city modal --}}
<div class="modal fade" id="Modalcity" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
    <div class="modal-dialog modal-dialog-slideout Modalcity-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title align-right" id="exampleModalLabel">City
            <button type="button" class="fal fa-long-arrow-right Modalcity-close" data-dismiss="modal"></button>
        </h5>
        </div>
        <div class="modal-body">
            <div class="gblCityBox">
                <div class="gblCityBody">

                    <div id="section-India">
                        <div class="gblSearchBox">
                            <div class="gblSearch">
                                <label for="searchCity">Search Cities</label>
                                <div class="formGroup"><em class="far fa-search"></em>
                                    <input type="text" name="location" class="select-city-state-mobile  form-control" id="" placeholder="Select or type your city">
                                </div>
                            </div>
                        </div>

                        @php
                        $top_cities_count = 4;

                        $cities = app(\Botble\Location\Repositories\Interfaces\CityInterface::class)->advancedGet([
                            'condition' => [
                                'cities.is_featured' => true,
                                'cities.status' => \Botble\Base\Enums\BaseStatusEnum::PUBLISHED,
                            ],
                            'take' => (int)10,
                            'select' => ['cities.id', 'cities.name', 'cities.image', 'cities.slug'],
                            'order_by' => ['order' => 'ASC', 'name' => 'ASC'],
                        ]);

                         @endphp

                         <div class="mobile-view-search-responce"> </div>
                         <div class="mobile-view-search-hidden">
                            <div class="topCitiesBoxx">
                                <h4>Top Cities</h4>
                                <ul>
                                    @foreach($cities as $key => $city)
                                        @if($key < $top_cities_count)
                                            <li class=" Top_Misc_L3 headercityli" connectid="" dotcomcityid="">
                                                <a class="Top_Misc_L3 redirect_to" cityid="{{ $city->id}}" cityname="{{ $city->name}}" slugcityname="{{ $city->slug}}" redirect_to="" href="{{ route('public.properties-by-city', $city->slug) }}">
                                                <em class="sci"> <img src="{{ RvMedia::getImageUrl($city->image, 'small', false, RvMedia::getDefaultImage()) }}" alt="{{ $city->name }}">
                                                </em>
                                                <h5>{{ $city->name}}</h5></a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                            <div class="allCitiesBoxx">
                                <h4>Other Cities</h4>
                                <ul>
                                    @foreach($cities as $key => $city)
                                        @if($key >= $top_cities_count)
                                            <li class="Top_Misc_L3 headercityli" connectid="" dotcomcityid="">
                                                <a href="{{ route('public.properties-by-city', $city->slug) }}" class="Top_Misc_L3 redirect_to" cityid="{{ $city->id}}" cityname="{{ $city->name}}" slugcityname="{{ $city->slug}}" redirect_to="">{{ $city->name}}</a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                         </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div> --}}
      </div>
    </div>
</div>

{{-- contact modal --}}
<div class="modal fade" id="Modalcontact" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
    <div class="modal-dialog modal-dialog-slideout Modalcity-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title align-right" id="exampleModalLabel">Contact Our Real Estate Experts
            <button type="button" class="fal fa-long-arrow-right Modalcity-close" data-dismiss="modal"></button>
        </h5>
        </div>
        <div class="modal-body">
            <div class="mobileOurServices">
                <ul>
                    <li>
                        <a href="{{ route('public.account.properties.index') }}" >
                            <em class="fIcon1"><img src="{{ RvMedia::getImageUrl($city->image, 'small', false, RvMedia::getDefaultImage()) }}" alt="{{ $city->name }}"></em>
                            <strong>Add Property <span>on ghar directory</span></strong>
                        </a>
                    </li>
                    {{-- <li>
                        <em class="fIcon1"></em>
                        <strong>Buy a New Home <span>5Lac+ property options</span></strong>
                    </li>
                    <li>
                        <em class="fIcon1"></em>
                        <strong>Buy a New Home <span>5Lac+ property options</span></strong>
                    </li>
                    <li>
                        <em class="fIcon1"></em>
                        <strong>Buy a New Home <span>5Lac+ property options</span></strong>
                    </li>
                    <li>
                        <em class="fIcon1"></em>
                        <strong>Buy a New Home <span>5Lac+ property options</span></strong>
                    </li> --}}
                </ul>
            </div>
        </div>
        {{-- <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div> --}}
      </div>
    </div>
</div>

<script>
    window.trans = {
        "Price": "{{ __('Price') }}",
        "Number of rooms": "{{ __('Number of rooms') }}",
        "Number of rest rooms": "{{ __('Number of rest rooms') }}",
        "Square": "{{ __('Square') }}",
        "No property found": "{{ __('No property found') }}",
        "million": "{{ __('million') }}",
        "billion": "{{ __('billion') }}",
        "in": "{{ __('in') }}",
        "Added to wishlist successfully!": "{{ __('Added to wishlist successfully!') }}",
        "Removed from wishlist successfully!": "{{ __('Removed from wishlist successfully!') }}",
        "I care about this property!!!": "{{ __('I care about this property!!!') }}",
    };
    window.themeUrl = '{{ Theme::asset()->url('') }}';
    window.siteUrl = '{{ url('') }}';
    window.currentLanguage = '{{ App::getLocale() }}';


    $('.mobile-view-search-hidden').show();
    var locationTimeout = null;
        $('.select-city-state-mobile')
            .on('keydown', function () {
                $(this).parents('.location-input').find('.suggestion').html('').hide();
            })
            .on('keyup', function () {
                var k = $(this).val();
                if (k) {
                    var parent = $(this).parents('.location-input');
                    parent.find('.input-has-icon i').hide();
                    parent.find('.spinner-icon').show();
                    clearTimeout(locationTimeout);
                    locationTimeout = setTimeout(function () {
                        $.get((parent.data('url') ? parent.data('url') : window.siteUrl + '/ajax/cities/mob') + '?k=' + k, function (data) {
                            // $('.mobile-view-search-hidden').hide();
                        if(data.status){
                            $('.mobile-view-search-hidden').hide();
                            $('.mobile-view-search-responce').html(data.html);
                            $('.mobile-view-search-responce').show();
                        }else{
                            $('.mobile-view-search-responce').hide();
                            $('.mobile-view-search-hidden').show();
                        }

                        });
                    }, 500);
                }
            });
</script>

<!--END FOOTER-->

<div class="action_footer">
    <a href="#" class="cd-top" @if (!Theme::get('hotlineNumber') && !theme_option('hotline')) style="top: -82px;" @endif><i class="fas fa-arrow-up"></i></a>
    @if (Theme::get('hotlineNumber') || theme_option('hotline'))
        <a class="cd__button" href="tel:{{ Theme::get('hotlineNumber') ?: theme_option('hotline') }}"><i class="fas fa-phone"></i> <span>  &nbsp;{{ Theme::get('hotlineNumber') ?: theme_option('hotline') }}</span></a>
    @endif
</div>

    {!! Theme::footer() !!}
</body>
</html>
