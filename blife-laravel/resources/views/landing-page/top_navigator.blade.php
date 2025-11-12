<section class="top-nav-wrap">
    <div class="container">
        <div class="top-nav">
            <div class="d-flex justify-content-between">
                <div class="top-nav-left d-none d-lg-block">
                    <span>{{ setting('storefront_welcome_text') }}</span>
                </div>

                <div class="top-nav-right">
                    <ul class="list-inline top-nav-right-list"> 
                        <li>
                            <a href="{{ route('contact.create') }}">
                                <i class="las la-envelope"></i>

                                {{ trans('storefront::layouts.contact') }}
                            </a>
                        </li>

                        @if (is_multilingual())
                            @endif

                        @if (is_multi_currency())
                            @endif

                        @auth
                            <li class="top-nav-account">
                                <a href="{{ route('account.dashboard.index') }}">
                                    <i class="las la-user"></i>

                                    {{ trans('storefront::layouts.account') }}
                                </a>
                            </li>
                        @else
                            <li>
                                <a href="{{ route('login') }}">
                                    <i class="las la-sign-in-alt"></i>

                                    {{ trans('storefront::layouts.login_register') }}
                                </a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
