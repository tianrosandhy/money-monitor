<li class="dropdown d-none d-lg-block" title="Change language">
    <a class="nav-link dropdown-toggle mr-0" data-toggle="dropdown" href="#" role="button"
        aria-haspopup="false" aria-expanded="false">
        <i data-feather="globe"></i>
        <strong>{{ strtoupper(Language::current()) }}</strong>
    </a>
    <div class="dropdown-menu dropdown-menu-right">
        <!-- item-->
        @foreach(Language::available() as $lang_code => $lang_title)
        <a href="{{ route('admin.lang.switch', ['lang' => $lang_code]) }}" class="dropdown-item notify-item">
            <img src="{{ admin_asset('images/flag/'.strtoupper($lang_code).'.png') }}" alt="flag-{{ $lang_code }}" class="mr-2" height="12"> <span
                class="align-middle">{{ $lang_title }}</span>
        </a>
        @endforeach
    </div>
</li>