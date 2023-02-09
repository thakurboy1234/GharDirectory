<section class="main-homes">
    <div class="bgheadproject hidden-xs" style="background: url('{{ theme_option('breadcrumb_background') ? RvMedia::url(theme_option('breadcrumb_background')) : Theme::asset()->url('images/banner-du-an.jpg') }}')">
        <div class="description">
            <div class="container-fluid w90">
                <h1 class="text-center">{{ __('Directory Experts') }}</h1>
                {!! Theme::partial('breadcrumb') !!}
            </div>
        </div>
    </div>
    <div class="container-fluid w90 padtop30">
        <div class="projecthome">
            {{-- <form action="{{ url()->current() }}" method="get" > --}}
                {{-- @include(Theme::getThemeNamespace() . '::views.real-estate.includes.search-box', ['type' => 'property', 'categories' => $categories]) --}}
                {{-- <div class="row rowm10">
                    <div class="@if (theme_option('show_map_on_properties_page', 'yes') == 'yes' && Arr::get($_COOKIE, 'show_map_on_properties', 1)) col-lg-12 left-page-content @else col-lg-12 full-page-content @endif"
                        @if (theme_option('show_map_on_properties_page', 'yes') == 'yes')
                            data-class-full="col-lg-12 full-page-content"
                            data-class-left="col-lg-12 left-page-content"
                        @endif
                        > --}}
                        @include(Theme::getThemeNamespace() . '::views.real-estate.includes.agentFilters', ['isChangeView' => theme_option('show_map_on_properties_page', 'yes') == 'yes'])
                        {{-- <div class="data-listing mt-2">
                            {!! Theme::partial('real-estate.properties.items', compact('properties')) !!}
                        </div> --}}
                    </div>
                    {{-- @if (theme_option('show_map_on_properties_page', 'yes') == 'yes')
                        <div class="col-md-5 @if (!Arr::get($_COOKIE, 'show_map_on_properties', 1)) d-none @endif" id="properties-map">
                            <div class="rightmap h-100">
                                <div
                                    id="map"
                                    data-type="{{ request()->input('type') }}"
                                    data-url="{{ route('public.ajax.properties.map') }}{{ isset($city) && $city ? '?city_id=' . $city->id : '' }}"
                                    data-center="{{ json_encode([43.615134, -76.393186]) }}"></div>
                            </div>
                        </div>
                    @endif --}}
                </div>
            {{-- </form> --}}
        </div>
    </div>
    <div class="container-fluid w90 padtop30">
        <div class="rowm10">
            @if ($accounts->count())
                <div class="container-fluid">
                    <div class="row rowm10 list-agency">
                        @foreach($accounts as $account)
                            <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                                {!! Theme::partial('real-estate.agents.item', compact('account')) !!}
                            </div>
                        @endforeach
                        <div class="colm10 col-sm-12">
                            <nav class="d-flex justify-content-center pt-3">
                                {!! $accounts->withQueryString()->links() !!}
                            </nav>
                        </div>
                    </div>
                </div>
            @else
                <p class="item">{{ __('0 results') }}</p>
            @endif
        </div>
    </div>
</section>
<br>
<br>
