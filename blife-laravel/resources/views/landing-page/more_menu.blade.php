<ul class="sidebar-more-menu-items">
    <li>
        <a href="{{ route('contact.create') }}">
            <div class="sidebar-icon-parent">
                </div>

            <span>{{ trans('storefront::layouts.contact') }}</span>
        </a>
    </li>

    @if (setting('storefront_blogs_section_enabled'))
        <li>
            <a href="{{ route('blog_posts.index') }}">
                <div class="sidebar-icon-parent">
                    </div>

                <span>{{ trans('storefront::layouts.blog') }}</span>
            </a>
        </li>
    @endif
</ul>
