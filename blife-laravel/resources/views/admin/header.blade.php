<header class="page-header">
    <div class="header-wrapper">
        <div class="header-logo-wrapper">
            <a href="{{ route('home') }}">
                <img src="{{ asset('assets/images/logo/1.png') }}" alt="logo" class="main-logo">
            </a>
        </div>
        <div class="nav-right">
            <ul class="nav-menus">
                <li><i class="ri-search-line"></i></li>
                <li class="onhover-dropdown">
                    <x-ui.notification />
                </li>
                <li class="profile-nav onhover-dropdown">
                    <x-ui.profile-menu :user="Auth::user()" />
                </li>
            </ul>
        </div>
    </div>
</header>
