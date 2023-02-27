@php
    $categories = get_property_categories(['indent' => '↳', 'conditions' => ['status' => \Botble\Base\Enums\BaseStatusEnum::PUBLISHED]]);
    $backgroundImage = $shortcode->background_image ?: theme_option('home_banner');
    $enableProjectsSearch = $shortcode->enable_search_projects_on_homepage_search ? $shortcode->enable_search_projects_on_homepage_search == 'yes' : (theme_option('enable_search_projects_on_homepage_search', 'yes') == 'yes');
    $defaultSearchType = $shortcode->default_home_search_type ?: theme_option('default_home_search_type', 'project');
@endphp
<div class="home_banner" style="background-image: url({{ $backgroundImage ? RvMedia::getImageUrl($backgroundImage) : Theme::asset()->url('images/banner.jpg') }})">
    <div class="topsearch">
        @if (theme_option('home_banner_description'))<h1 class="text-center text-white mb-4 banner-text-description">{{ $shortcode->title ?: theme_option('home_banner_description') }}</h1>@endif
        <form @if ($enableProjectsSearch && $defaultSearchType == 'project') action="{{ route('public.projects') }}" @else action="{{ route('public.properties') }}" @endif method="GET" id="frmhomesearch">
            <div class="typesearch" id="hometypesearch" style="display:none;">
                {{-- @if ($enableProjectsSearch)
                    <a href="javascript:void(0)" @if ($defaultSearchType == 'project') class="active" @endif rel="project" data-url="{{ route('public.projects') }}">{{ __('Projects') }}</a>
                @endif --}}
                <a href="javascript:void(0)" rel="sale" class="active"  data-url="{{ route('public.properties') }}">{{ __('Sale') }}</a>
                {{-- <a href="javascript:void(0)" rel="rent" @if ($defaultSearchType == 'rent') class="active" @endif data-url="{{ route('public.properties') }}">{{ __('Rent') }}</a> --}}
            </div>
            <div class="input-group input-group-lg">

                <input type="hidden" name="type" @if ($enableProjectsSearch && $defaultSearchType == 'project') value="project" @else value="{{ $defaultSearchType ?: 'sale' }}" @endif id="txttypesearch">

                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="far fa-search"></i></span>
                </div>
                <div class="keyword-input">
                    <input type="text" class="form-control" name="k" placeholder="{{ __('Enter keyword...') }}" id="txtkey" autocomplete="off">
                    <div class="spinner-icon">
                        <i class="fas fa-spin fa-spinner"></i>
                    </div>
                </div>
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-location-arrow "></i></span>
                </div>
                <div class="location-input" data-url="{{ route('public.ajax.cities') }}">
                    <input type="hidden" name="city_id">
                    <input class="select-city-state form-control" name="location" value="{{ request()->input('location') }}" placeholder="{{ __('City, State') }}" autocomplete="off">
                    <div class="spinner-icon">
                        <i class="fas fa-spin fa-spinner"></i>
                    </div>
                    <div class="suggestion">

                    </div>
                </div>
                <div class="select__input">
                    {!! Theme::partial('real-estate.filters.categories', compact('categories')) !!}
                </div>
                <div class="input-group-append search-button-wrapper">
                    <button class="btn btn-orange" type="submit">{{ __('Search') }}</button>
                </div>

                <div class="advanced-search d-none d-sm-block">
                    {{-- <a href="#" class="advanced-search-toggler">{{ __('Advanced') }} <i class="fas fa-caret-down"></i></a> --}}
                    {{-- <div class="advanced-search-content property-advanced-search active">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3 col-sm-6 pr-md-1">
                                    {!! Theme::partial('real-estate.filters.categories', compact('categories')) !!}
                                </div>
                                <div class="col-md-3 col-sm-6 px-md-1">
                                    {!! Theme::partial('real-estate.filters.bedroom') !!}
                                </div>
                                <div class="col-md-3 col-sm-6 px-md-1">
                                    {!! Theme::partial('real-estate.filters.bathroom') !!}
                                </div>
                                <div class="col-md-3 col-sm-6 pl-md-1">
                                    {!! Theme::partial('real-estate.filters.floor') !!}
                                </div>
                            </div>
                        </div>
                    </div> --}}

                    @if ($enableProjectsSearch)
                        <div class="advanced-search-content project-advanced-search">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        {!! Theme::partial('real-estate.filters.categories', compact('categories')) !!}
                                    </div>
                                    <div class="col-md-8">
                                        {!! Theme::partial('real-estate.filters.price') !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="listsuggest">

            </div>
        </form>
    </div>
</div>
