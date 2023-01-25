<div class="padtop30">
    <div class="box_shadow propertie__sale">
        <div class="container-fluid w90">
            <div class="homehouse projecthome">
                <div class="row">
                    <div class="col-12">
                        <h2 class="text-white">{!! BaseHelper::clean($title) !!}</h2>
                        @if ($subtitle)
                            <p class="text-white">{!! BaseHelper::clean($subtitle) !!}</p>
                        @endif
                    </div>
                </div>
                <property-component type="sale" url="{{ route('public.ajax.properties') }}"></property-component>
            </div>
        </div>
    </div>
</div>
