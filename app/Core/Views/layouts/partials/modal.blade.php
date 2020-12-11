@if(Permission::has('admin.setting.store'))
<div class="right-bar">
    <div class="rightbar-title">
        <a href="javascript:void(0);" class="right-bar-toggle float-right">
            <i data-feather="x-circle"></i>
        </a>
        <h5 class="m-0">{{ __('core::module.global.setting') }}</h5>
    </div>

    <div class="slimscroll-menu">
        @include ('core::layouts.partials.sidebar.global-setting')
    </div>
</div>
<div class="rightbar-overlay"></div>
@endif
@stack ('modal')