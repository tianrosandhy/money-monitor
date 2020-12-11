<div class="media user-profile mt-2 mb-2">
    <img src="{{ $user->getImageUrl('image', 'cropped') }}" class="avatar-sm rounded-circle mr-2" alt="User Photo" />
    <img src="{{ $user->getImageUrl('image', 'cropped') }}" class="avatar-xs rounded-circle mr-2" alt="User Photo" />

    <div class="media-body">
        <h6 class="pro-user-name mt-0 mb-0">{{ $user->name ?? null }}</h6>
        <span class="pro-user-desc">{{ $role->name ?? null }}</span>
    </div>
    <div class="dropdown align-self-center profile-dropdown-menu">
        <a class="dropdown-toggle mr-0" data-toggle="dropdown" href="#" role="button" aria-haspopup="false"
            aria-expanded="false">
            <span data-feather="chevron-down"></span>
        </a>
        <div class="dropdown-menu profile-dropdown">
            <a href="{{ route('admin.my-profile') }}" class="dropdown-item notify-item">
                <i data-feather="user" class="icon-dual icon-xs mr-2"></i>
                <span>{{ __('core::module.global.my_profile') }}</span>
            </a>

            <div class="dropdown-divider"></div>

            <a href="{{ route('admin.logout') }}" class="dropdown-item notify-item">
                <i data-feather="log-out" class="icon-dual icon-xs mr-2"></i>
                <span>{{ __('core::module.global.logout') }}</span>
            </a>
        </div>
    </div>
</div>