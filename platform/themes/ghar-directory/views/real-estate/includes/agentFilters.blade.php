<div class="shop__sort bg-light p-2 round">
    <div class="row">
        <div class="col-toggle-filter col-12 col-xs-2 col-sm-2 d-md-none my-1 pr-sm-1">
            <div class="toggle-filter-offcanvas bg-light toggle-filter-mobile">
                <i class="fal fa-filter mr-1"></i> <span class="toggle-filter-name d-block d-xs-none d-sm-block d-md-block">{{ __('Filter') }}</span>
            </div>
        </div>
{{-- {{dd($cites)}} --}}
        <div class="col-showing col-6 col-sm-5 col-md-6 my-1">
            <div class="form-group--inline">
                <div class="form-group__content">
                    <div class="select--arrow">
                        <select name="per_page" id="per-page" class="form-control">
                            <option value="">{{ __('Showing') }}</option>
                            <option value="" @if (request()->input('per_page') == 15) selected @endif>15</option>
                            <option value="30" @if (request()->input('per_page') == 30) selected @endif>30</option>
                            <option value="45" @if (request()->input('per_page') == 45) selected @endif>45</option>
                            <option value="75" @if (request()->input('per_page') == 75) selected @endif>75</option>
                            <option value="120" @if (request()->input('per_page') == 120) selected @endif>120</option>
                        </select>
                        <i class="fas fa-angle-down"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sort-by col-6 col-sm-5 col-md-6 my-1">
            <div class="sort-by-wrap d-flex">
                <div class="form-group--inline">
                    <div class="form-group__content">
                        <div class="select--arrow">
                            <select name="sort_by" id="filter-agent-via-city" class="form-control">
                                <option value="">Select City</option>
                                @foreach($cites as $key => $cite)
                                <option {{isset($city_id)?$city_id==$cite->id?'selected':'':''}} value="{{$cite->id}}" >{{ $cite->name }}</option>
                                @endforeach

                            </select>
                            <i class="fas fa-angle-down"></i>
                        </div>
                    </div>
                    {{-- @if (!empty($isChangeView))
                        <div class="change-view ml-2">
                            <i class="fas fa-map-marker-alt view-type-map @if (Arr::get($_COOKIE, 'show_map_on_properties', 1)) active @endif"></i>
                        </div>
                    @endif --}}
                </div>
            </div>
        </div>
    </div>
</div>
