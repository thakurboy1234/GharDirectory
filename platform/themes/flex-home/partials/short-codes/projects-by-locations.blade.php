@php
    use Botble\Base\Enums\BaseStatusEnum;
    use Botble\Location\Repositories\Interfaces\CityInterface;

    $cities = collect([]);
    if (is_plugin_active('location')) {
        $cities = app(CityInterface::class)->advancedGet([
            'condition' => [
                'cities.is_featured' => true,
                'cities.status'      => BaseStatusEnum::PUBLISHED,
            ],
            'take'      => (int)theme_option('number_of_featured_cities', 10),
        ]);
    }
@endphp

@if ($cities->count() > 0)
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
                <div style="position:relative;">
                    <div class="owl-carousel" id="project-city-slides">
                        @foreach($cities as $city)
                            <div class="item itemarea">
                                <a href="{{ route('public.project-by-city', $city->slug) }}">
                                    <img src="{{ RvMedia::getImageUrl($city->image, 'small', false, RvMedia::getDefaultImage()) }}" alt="{{ $city->name }}">
                                    <h4>{{ $city->name }}</h4>
                                </a>
                            </div>
                        @endforeach
                    </div>
                    <i class="am-next"><img src="{{ Theme::asset()->url('images/aleft.png') }}" alt="pre"></i>
                    <i class="am-prev"><img src="{{ Theme::asset()->url('images/aright.png') }}" alt="next"></i>
                </div>
            </div>

        </div>
    </div>
@endif
