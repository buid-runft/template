<ul class="sidebar-more-menu-items">
    <li>
        <a href="{{ route('contact.create') }}">
            <div class="sidebar-icon-parent">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M17 20.5H7C4 20.5 2 19 2 15.5V8.5C2 5 4 3.5 7 3.5H17C20 3.5 22 5 22 8.5V15.5C22 19 20 20.5 17 20.5Z" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M17 9L13.87 11.5C12.84 12.32 11.15 12.32 10.12 11.5L7 9" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>

            <span>{{ trans('storefront::layouts.contact') }}</span> 
        </a>
    </li>

    @if (setting('storefront_blogs_section_enabled'))
        <li>
            <a href="{{ route('blog_posts.index') }}">
                <div class="sidebar-icon-parent">
                    <svg class="blog-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="vuesax/linear/message-text">
                            <g id="message-text">
                                <path id="Vector" d="M8.5 19H8C4 19 2 18 2 13V8C2 4 4 2 8 2H16C20 2 22 4 22 8V13C22 17 20 19 16 19H15.5C15.19 19 14.89 19.15 14.7 19.4L13.2 21.4C12.54 22.28 11.46 22.28 10.8 21.4L9.3 19.4C9.14 19.18 8.77 19 8.5 19Z" stroke="#292..."/>
                            </g>
                        </g>
                    </svg>
                </div>

                <span>{{ trans('storefront::layouts.blog') }}</span> 
            </a>
        </li>
    @endif
</ul>
