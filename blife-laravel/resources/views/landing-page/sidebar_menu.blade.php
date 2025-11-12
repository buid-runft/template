<aside class="sidebar-menu-wrap" :class="{ active: $store.layout.isOpenSidebarMenu }">
    <div class="sidebar-menu-close" @click="$store.layout.closeSidebarMenu()">
        <i class="las la-times"></i>
    </div>

    <div class="sidebar-menu-curve-background">
        <ul class="nav nav-tabs sidebar-menu-tab" role="tablist">
            <li class="nav-item" role="presentation"> 
                <a class="nav-link active" data-bs-toggle="tab" href="#category-menu">
                    {{ trans('storefront::layouts.categories') }}
                </a>
            </li>

            <li class="nav-item" role="presentation">
                <a class="nav-link" data-bs-toggle="tab" href="#main-menu">
                    {{ trans('storefront::layouts.menu') }}
                </a>
            </li>

            <li class="nav-item" role="presentation">
                <a class="nav-link" data-bs-toggle="tab" href="#more-menu">
                    {{ trans('storefront::layouts.more') }}
                </a>
            </li>
        </ul>
    </div>

    <div class="tab-content custom-scrollbar">
        <div id="category-menu" class="tab-pane active">
            @include('storefront::public.layouts.sidebar_menu.menu', ['type' => 'category_menu', 'menu' => $categoryMenu])
        </div>

        <div id="main-menu" class="tab-pane">
            @include('storefront::public.layouts.sidebar_menu.menu', ['type' => 'primary_menu', 'menu' => $primaryMenu])
        </div>

        <div id="more-menu" class="tab-pane">
            @include('storefront::public.layouts.sidebar_menu.more_menu')
        </div>
    </div>
</aside>
