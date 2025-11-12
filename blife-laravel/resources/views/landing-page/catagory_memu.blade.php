<div
    x-data="{ open: false }"
    class="category-nav {{ request()->routeIs('home') ? 'show' : 'category-dropdown-menu' }}"
>
    <div class="category-nav-inner" @click="open = !open">
        <span>{{ trans('storefront::layouts.all_categories_header') }}</span>
        
        <i class="las la-bars"></i>
    </div>

    @if ($categoryMenu->menus()->isNotEmpty())
        <div
            class="category-dropdown-wrap"
            :class="{ show: open }"
        >
            <div class="category-dropdown">
                <ul class="list-inline mega-menu vertical-megamenu">
                    @foreach ($categoryMenu->menus() as $menu)
                        @include('storefront::public.layouts.navigation.menu', ['type' => 'category_menu'])
                    @endforeach

                    <li class="more-categories">
                        <a
                            href="{{ route('categories.index') }}"
                            class="menu-item"
                            title="{{ trans('storefront::layouts.all_categories') }}"
                        >
                            <span class="menu-item-icon">
                                <i class="las la-plus-square"></i>
                            </span>

                            {{ trans('storefront::layouts.all_categories') }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    @endif
</div>
