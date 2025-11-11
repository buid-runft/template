<section class="bottom-navigation-wrap d-lg-none">
    <div class="container">
        <ul class="bottom-navigation-items">
            <li>
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
                    @if (request()->routeIs('home'))
                        <svg></svg>
                    @else
                        <svg></svg>
                    @endif
                    <span>{{ 'หน้าแรก' }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('categories.index') }}" class="{{ request()->routeIs('categories.index') ? 'active' : '' }}">
                    @if (request()->routeIs('categories.index'))
                        <svg></svg>
                    @else
                        <svg></svg>
                    @endif
                    <span>{{ 'หมวดหมู่' }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('cart') }}" class="{{ request()->routeIs('cart') ? 'active' : '' }}">
                    @if (request()->routeIs('cart'))
                        <svg></svg>
                    @else
                        <svg></svg>
                    @endif
                    <span>{{ 'ตะกร้า' }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route(Auth::check() ? 'account.profile.edit' : 'login') }}" class="{{ request()->routeIs('login') || request()->routeIs('account.*') ? 'active' : '' }}">
                    @if (request()->routeIs('login') || request()->routeIs('account.*'))
                        <svg></svg>
                    @else
                        <svg></svg>
                    @endif
                    <span>{{ Auth::check() ? 'โปรไฟล์' : 'บัญชี' }}</span>
                </a>
            </li>
        </ul>
    </div>
</section>
