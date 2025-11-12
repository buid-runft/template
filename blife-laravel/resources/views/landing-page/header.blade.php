<header x-ref="header" x-data="Header" class="header-wrap">
    <div
        class="header-wrap-inner"
        :class="{
            sticky: isStickyHeader,
            show: isShowingStickyHeader
        }"
    >
        <div class="container">
            <div class="d-flex flex-nowrap justify-content-between position-relative">
                <div class="header-column-left align-items-center">
                    <div class="sidebar-menu-icon-wrap" @click="$store.layout.openSidebarMenu()">
                        <div class="sidebar-menu-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50" width="150px" height="150px">
                                <path d="M 3 9 A 1.0001 1.0001 0 1 0 3 11 L 47 11 A 1.0001 1.0001 0 1 0 47 9 L 3 9 z M 3 24 A 1.0001 1.0001 0 1 0 3 26 L 47 26 A 1.0001 1.0001 0 1 0 47 24 L 3 24 z M 3 39 A 1.0001 1.0001 0 1 0 3 41 L 47 41 A 1.0001 1.0001 0 1 0 47 39 L 3 39 z"/>
                            </svg>
                        </div>
                    </div>

                    @include('storefront::public.layouts.header.logo')
                    @include('storefront::public.layouts.header.header_search')

                </div>

                <div class="header-column-right">
                    <a
                        href="{{ route('wishlist.index') }}"
                        class="header-column-right-item header-wishlist"
                        title="{{ trans('storefront::layouts.wishlist') }}"
                    >
                        <div x-data="Wishlist" class="icon-wrap">
                            <i class="las la-heart"></i>
                            
                            <span class="d-none d-xl-block">{{ trans('storefront::layouts.wishlist') }}</span>
                            
                            <div class="count" x-text="$store.wishlist.count">{{ $wishlistCount }}</div>
                        </div>
                    </a>
                    
                    <a
                        href="{{ route('cart.index') }}"
                        class="header-column-right-item header-cart"
                        @click="$store.layout.openSidebarCart($event)"
                    >  
                        <div x-data="CartButton" class="icon-wrap">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M7.5 7.67001V6.70001C7.5 4.45001 9.31 2.24001 11.56 2.03001C14.24 1.77001 16.5 3.88001 16.5 6.51001V7.89001" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M9.00001 22H15C19.02 22 19.74 20.39 19.95 18.43L20.7 12.43C20.97 9.99 20.27 8 16 8H8C3.73 8 3.03 9.99 3.3 12.43L4.05 18.43C4.26 20.39 4.98 22 9.00001 22Z" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            
                            <div class="count skeleton" :class="{ skeleton: $store.cart.fetching }" x-text="$store.cart.quantity"></div>
                        </div>
                    </a>

                    @auth
                        <a href="{{ route('account.dashboard.index') }}" class="header-column-right-item header-account d-lg-none">
                            <div class="icon-wrap">
                                <i class="las la-user"></i>
                            </div>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="header-column-right-item header-account d-lg-none">
                            <div class="icon-wrap">
                                <i class="las la-user"></i>
                            </div>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</header>
