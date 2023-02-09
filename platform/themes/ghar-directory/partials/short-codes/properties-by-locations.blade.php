<div class="container-fluid w90">

    <div class="padtop70">
        <div class="areahome">
            <div class="row">
                <div class="col-12">
                    <h2>{!! BaseHelper::clean($title) !!}</h2>
                    @if ($subtitle)
                        <p>{!! BaseHelper::clean($subtitle) !!}</p>
                    @endif
                </div>
            </div>
            <div style="position:relative;" class="d-none d-sm-block">
                <div class="owl-carousel" id="cityslide">
                    @foreach($cities as $city)
                        <div class="item itemarea">
                            <a href="{{ route('public.properties-by-city', $city->slug) }}">
                                <figure class="Home_City_L1">
                                    <img src="{{ RvMedia::getImageUrl($city->image, 'small', false, RvMedia::getDefaultImage()) }}" alt="{{ $city->name }}">
                                </figure>
                                <figcaption class="Home_City_L1">
                                    <h4>{{ $city->name }}</h4>
                                </figcaption>
                            </a>
                        </div>
                    @endforeach
                </div>
                <i class="am-prev"><img src="{{ Theme::asset()->url('images/aleft.png') }}" alt="pre"></i>
                <i class="am-next"><img src="{{ Theme::asset()->url('images/aright.png') }}" alt="next"></i>
            </div>
            <div class="mobileView__properties d-sm-none">
                <div class="row">
                    @foreach($cities as $city)
                        <div class="col-4">
                            <div class="item itemarea">
                                <a href="{{ route('public.properties-by-city', $city->slug) }}">
                                    <figure class="Home_City_L1">
                                        <img src="{{ RvMedia::getImageUrl($city->image, 'small', false, RvMedia::getDefaultImage()) }}" alt="{{ $city->name }}">
                                    </figure>
                                    <figcaption class="Home_City_L1">
                                        <h4>{{ $city->name }}</h4>
                                    </figcaption>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</div>
