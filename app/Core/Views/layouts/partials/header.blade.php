<!-- Topbar Start -->
<div class="navbar navbar-expand flex-column flex-md-row navbar-custom">
    <div class="container-fluid">
        <!-- LOGO -->
        <a href="{{ admin_url('/') }}" class="navbar-brand mr-0 mr-md-2 logo">
            <span class="logo-lg">
                @if(setting('general.logo'))
                <img src="{{ setting('general.logo') }}" alt="" height="24" />
                @else
                <img src="{{ admin_asset('images/logo.png') }}" alt="" height="24" />
                @endif
                <span class="d-inline h5 ml-1 text-logo">{{ setting('general.title', env('APP_NAME')) }}</span>
            </span>
            <span class="logo-sm">
                <img src="{{ setting('general.logo') }}" alt="" height="24">
            </span>
        </a>

        <ul class="navbar-nav bd-navbar-nav flex-row list-unstyled menu-left mb-0">
            <li class="">
                <button class="button-menu-mobile open-left disable-btn">
                    <i data-feather="menu" class="menu-icon"></i>
                    <i data-feather="x" class="close-icon"></i>
                </button>
            </li>
        </ul>

        <ul class="navbar-nav flex-row ml-auto d-flex list-unstyled topnav-menu float-right mb-0">

            @if(Permission::has('admin.setting.store'))
            <li class="dropdown notification-list" title="Settings">
                <a href="javascript:void(0);" class="nav-link right-bar-toggle">
                    <i data-feather="settings"></i>
                </a>
            </li>
            @endif

            @include ('core::layouts.partials.header.user-dropdown')
        </ul>
    </div>

</div>
<!-- end Topbar -->