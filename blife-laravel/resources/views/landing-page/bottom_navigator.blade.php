<section class="bottom-navigation-wrap d-lg-none">
    <div class="container">
        <ul class="bottom-navigation-items">
            <li>
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
                    <span>{{ trans('storefront::layouts.home') }}</span>
                </a>
            </li>

            <li>
                <a href="#" class="categories-btn" @click="$store.layout.openSidebarMenuTab('#category-menu')">
                    <span>{{ trans('storefront::layouts.categories') }}</span>
                </a>
            </li>

            <li>
                <a href="#" class="cart-btn" @click="$store.layout.openSidebarCart($event)">
                    <div class="count skeleton" :class="{ skeleton: $store.cart.fetching }" x-text="$store.cart.quantity"></div>
                </a>
            </li>

            <li>
                <a
                    href="{{ auth()->check() ? route('account.dashboard.index') : route('login') }}"
                    class="{{ request()->routeIs('login') || request()->routeIs('account.*') ? 'active' : '' }}"
                >
                    <span>{{ trans('storefront::layouts.account') }}</span>
                </a>
            </li>
        </ul>
    </div>
</section>
