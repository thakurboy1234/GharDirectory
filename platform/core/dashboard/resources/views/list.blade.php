@extends(BaseHelper::getAdminMasterLayoutTemplate())
@section('content')
{{-- <div id="dashboard-alerts">
    <verify-license-component verify-url="{{ route('settings.license.verify') }}"
        setting-url="{{ route('settings.options') }}"></verify-license-component>
    @if (config('core.base.general.enable_system_updater') && Auth::user()->isSuperUser())
    <check-update-component check-update-url="{{ route('system.check-update') }}"
        setting-url="{{ route('system.updater') }}"></check-update-component>
    @endif
</div> --}}
{{-- {!! apply_filters(DASHBOARD_FILTER_ADMIN_NOTIFICATIONS, null) !!} --}}
<div class="row">
    {!! apply_filters(DASHBOARD_FILTER_TOP_BLOCKS, null) !!}
</div>
<div class="row">
    @foreach ($statWidgets as $widget)
    {!! $widget !!}
    @endforeach

</div>
<div class="row">
    <div class="col-md-4">
        <a class="dashboard-stat dashboard-stat-v2 text-white" style="background-color: rgb(142, 68, 173);"
            href="{{route('public.account.properties.get.leads')}}">
            {{-- <a class="dashboard-stat dashboard-stat-v2 text-white" style="background-color: rgb(50, 197, 210);"
                href="javascript:void(0)"> --}}

                <div class="visual">
                    <i class="fas fa-briefcase" style="opacity: .1;"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{ $totalLeads }}">0</span>
                    </div>
                    <div class="desc">Total Leads</div>
                </div>
            </a>
    </div>
    <div class="col-md-4">
        <a class="dashboard-stat dashboard-stat-v2 text-white" style="background-color: rgb(50, 197, 210);"
            href="{{route('account.index')}}">
            {{-- <a class="dashboard-stat dashboard-stat-v2 text-white" style="background-color: rgb(142, 68, 173);"
                href="javascript:void(0)"> --}}

                <div class="visual">
                    <i class="fas fa-briefcase" style="opacity: .1;"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{ $totalVendor }}">0</span>
                    </div>
                    <div class="desc">Total Vendors</div>
                </div>
            </a>
    </div>
    <div class="col-md-4">
        <a class="dashboard-stat dashboard-stat-v2 text-white" style="background-color:  rgb(231, 80, 90);"
        href="{{route('account.index',"$activeVendorFilter")}}">
            {{-- <a class="dashboard-stat dashboard-stat-v2 text-white" style="background-color: rgb(231, 80, 90);"
                href="javascript:void(0)"> --}}

                <div class="visual">
                    <i class="fas fa-briefcase" style="opacity: .1;"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{ $activeVendor }}">0</span>
                    </div>
                    <div class="desc">Active Vendors</div>
                </div>
            </a>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <a class="dashboard-stat dashboard-stat-v2 text-white" style="background-color:rgb(142, 68, 173);"
            href="{{route('account.index',"$inActiveVendorFilter")}}">
            {{-- <a class="dashboard-stat dashboard-stat-v2 text-white" style="background-color: rgb(142, 68, 173);"
                href="javascript:void(0)"> --}}

                <div class="visual">
                    <i class="fas fa-briefcase" style="opacity: .1;"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{ $inActiveVendor }}">0</span>
                    </div>
                    <div class="desc">Inactive Vendors</div>
                </div>
            </a>
    </div>
</div>




{{-- <div id="list_widgets" class="row">
    @foreach ($userWidgets as $widget)
    {!! $widget !!}
    @endforeach
</div> --}}

{{-- @if (count($widgets) > 0)
<a href="#" class="manage-widget">
    <i class="fa fa-plus"></i>
    {{ trans('core/dashboard::dashboard.manage_widgets') }}
</a>
@include('core/dashboard::partials.modals', compact('widgets'))
@endif --}}
@stop
