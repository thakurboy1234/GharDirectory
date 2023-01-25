<!--FOOTER-->
<section class="top__footer">
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
<footer>
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

{{-- mobile footer navigation --}}
<div class="mobileNavigation d-xl-none d-lg-none d-md-none d-sm-none d-block">
    <ul>
        <li class="active">
            <em class="mobNav home"><i class="far fa-home"></i></em>
            <small>Home</small>
        </li>
        <li data-toggle="modal" data-target="#Modalcity">
            <em class="mobNav search"><i class="far fa-search"></i></em>
            <small>Search</small>
        </li>
        <li data-toggle="modal" data-target="#Modalcontact">
            <span>
                <em class="mobNav ourServicesEm"><i class="far fa-plus"></i></em>
            </span>
        </li>
        <li>
            <em class="mobNav ahortlist"><i class="far fa-heart"></i></em>
            <small>Wishlist</small>
        </li>
        <li>
            <em class="mobNav account"><i class="far fa-user"></i></em>
            <small>Account</small>
        </li>
    </ul>
</div>

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
                                    <input type="text" class="form-control" id="" placeholder="Select or type your city">
                                </div>
                            </div>
                        </div>
                        <div class="topCitiesBoxx">
                            <h4>Top Cities</h4>
                            <ul>
                                <li class=" Top_Misc_L3 headercityli" connectid="" dotcomcityid="">
                                    <a class="Top_Misc_L3 redirect_to" cityid="" cityname="Mumbai" slugcityname="mumbai" redirect_to="">
                                    <em class="sci"></em>
                                    <h5>Mumbai</h5></a>
                                </li>
                                <li class=" Top_Misc_L3 headercityli" connectid="" dotcomcityid="">
                                    <a class="Top_Misc_L3 redirect_to" cityid="" cityname="Delhi" slugcityname="delhi" redirect_to="">
                                    <em class="sci"></em>
                                    <h5>Delhi</h5></a>
                                </li>
                                <li class=" Top_Misc_L3 headercityli" connectid="" dotcomcityid="">
                                    <a class="Top_Misc_L3 redirect_to" cityid="" cityname="Mumbai" slugcityname="mumbai" redirect_to="">
                                    <em class="sci"></em>
                                    <h5>Mumbai</h5></a>
                                </li>
                                <li class=" Top_Misc_L3 headercityli" connectid="" dotcomcityid="">
                                    <a class="Top_Misc_L3 redirect_to" cityid="" cityname="Delhi" slugcityname="delhi" redirect_to="">
                                    <em class="sci"></em>
                                    <h5>Delhi</h5></a>
                                </li>
                                <li class=" Top_Misc_L3 headercityli" connectid="" dotcomcityid="">
                                    <a class="Top_Misc_L3 redirect_to" cityid="" cityname="Mumbai" slugcityname="mumbai" redirect_to="">
                                    <em class="sci"></em>
                                    <h5>Mumbai</h5></a>
                                </li>
                                <li class=" Top_Misc_L3 headercityli" connectid="" dotcomcityid="">
                                    <a class="Top_Misc_L3 redirect_to" cityid="" cityname="Delhi" slugcityname="delhi" redirect_to="">
                                    <em class="sci"></em>
                                    <h5>Delhi</h5></a>
                                </li>
                            </ul>
                        </div>
                        <div class="allCitiesBoxx">
                            <h4>Other Cities</h4>
                            <ul>
                                <li class="Top_Misc_L3 headercityli" connectid="" dotcomcityid="">
                                    <a class="Top_Misc_L3 redirect_to" cityid="" cityname="Nagpur" slugcityname="nagpur" redirect_to="">Nagpur</a>
                                </li>
                                <li class="Top_Misc_L3 headercityli" connectid="" dotcomcityid="">
                                    <a class="Top_Misc_L3 redirect_to" cityid="" cityname="Nagpur" slugcityname="nagpur" redirect_to="">Nagpur</a>
                                </li>
                                <li class="Top_Misc_L3 headercityli" connectid="" dotcomcityid="">
                                    <a class="Top_Misc_L3 redirect_to" cityid="" cityname="Nagpur" slugcityname="nagpur" redirect_to="">Nagpur</a>
                                </li>
                                <li class="Top_Misc_L3 headercityli" connectid="" dotcomcityid="">
                                    <a class="Top_Misc_L3 redirect_to" cityid="" cityname="Nagpur" slugcityname="nagpur" redirect_to="">Nagpur</a>
                                </li>
                                <li class="Top_Misc_L3 headercityli" connectid="" dotcomcityid="">
                                    <a class="Top_Misc_L3 redirect_to" cityid="" cityname="Nagpur" slugcityname="nagpur" redirect_to="">Nagpur</a>
                                </li>
                                <li class="Top_Misc_L3 headercityli" connectid="" dotcomcityid="">
                                    <a class="Top_Misc_L3 redirect_to" cityid="" cityname="Nagpur" slugcityname="nagpur" redirect_to="">Nagpur</a>
                                </li>
                            </ul>
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
                    </li>
                    <li>
                        <em class="fIcon1"></em>
                        <strong>Buy a New Home <span>5Lac+ property options</span></strong>
                    </li>
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
</script>

<!--END FOOTER-->

<div class="action_footer">
    <a href="#" class="cd-top" @if (!Theme::get('hotlineNumber') && !theme_option('hotline')) style="top: -82px;" @endif><i class="fas fa-arrow-up"></i></a>
    @if (Theme::get('hotlineNumber') || theme_option('hotline'))
        <a href="tel:{{ Theme::get('hotlineNumber') ?: theme_option('hotline') }}" style="color: white;font-size: 17px;"><i class="fas fa-phone"></i> <span>  &nbsp;{{ Theme::get('hotlineNumber') ?: theme_option('hotline') }}</span></a>
    @endif
</div>

    {!! Theme::footer() !!}
</body>
</html>
