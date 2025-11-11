<ul class="list-inline sidebar-menu">
    @foreach ($menu->menus() as $menu)
        <li
            class="{{ $menu->hasSubMenus() ? 'dropdown multi-level' : '' }}"
            @click="
                // [TECHNICAL COMMENT]: Toggle submenu visibility and active class on click.
                $($el).children('ul.list-inline').slideToggle(200);
                $($el).toggleClass('active');
            "
        >
            <a
                href="{{ $menu->url() }}"
                class="menu-item"
                target="{{ $menu->target() }}"
                @click.stop
            >
                @if ($type === 'category_menu' && $menu->hasIcon())
                    <span class="menu-item-icon">
                        <i class="{{ $menu->icon() }}"></i>
                    </span>
                @endif

                {{ $menu->name() }}
            </a>

            @if ($menu->hasSubMenus())
                <i class="las la-angle-right"></i>
            @endif

            @if ($menu->hasSubMenus())
                @include('storefront::public.layouts.sidebar_menu.dropdown', ['subMenus' => $menu->subMenus()])
            @endif
        </li>
    @endforeach

    @if ($type === 'category_menu')
        <li class="more-categories">
            <a href="{{ route('categories.index') }}" class="menu-item">
                <span class="menu-item-icon">
                    <i class="las la-plus-square"></i>
                </span>

                {{ trans('storefront::layouts.all_categories') }}
            </a>
        </li>
    @endif
</ul>
