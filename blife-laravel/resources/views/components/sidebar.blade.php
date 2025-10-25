<!-- Page Sidebar Start-->
<div class="sidebar-wrapper">
    <div id="sidebarEffect"></div>
    <div>
        <div class="logo-wrapper logo-wrapper-center">
            <a href="{{ route('admin.dashboard') }}" data-bs-original-title="" title="">
                <img class="img-fluid for-white" src="{{ asset('assets/images/logo/full-white.png') }}" alt="logo">
            </a>
            <div class="back-btn">
                <i class="fa fa-angle-left"></i>
            </div>
            <div class="toggle-sidebar">
                <i class="ri-apps-line status_toggle middle sidebar-toggle"></i>
            </div>
        </div>
        <div class="logo-icon-wrapper">
            <a href="{{ route('admin.dashboard') }}">
                <img class="img-fluid main-logo main-white" src="{{ asset('assets/images/logo/1-white.png') }}" alt="logo">
                <img class="img-fluid main-logo main-dark" src="{{ asset('assets/images/logo/logo-white.png') }}" alt="logo">
            </a>
        </div>
        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow">
                <i data-feather="arrow-left"></i>
            </div>

            <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">
                    <li class="back-btn"></li>

                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                            <i class="ri-home-line"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li class="sidebar-list">
                        <a class="linear-icon-link sidebar-link sidebar-title {{ request()->routeIs('admin.products', 'admin.add-new-product') ? 'active' : '' }}" href="javascript:void(0)">
                            <i class="ri-store-3-line"></i>
                            <span>Product</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li>
                                <a href="{{ route('admin.products') }}">Products</a>
                            </li>
                            <li>
                                <a href="{{ route('admin.add-new-product') }}">Add New Products</a>
                            </li>
                        </ul>
                    </li>

                    <li class="sidebar-list">
                        <a class="linear-icon-link sidebar-link sidebar-title {{ request()->routeIs('admin.category', 'admin.add-new-category') ? 'active' : '' }}" href="javascript:void(0)">
                            <i class="ri-list-check-2"></i>
                            <span>Category</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li>
                                <a href="{{ route('admin.category') }}">Category List</a>
                            </li>
                            <li>
                                <a href="{{ route('admin.add-new-category') }}">Add New Category</a>
                            </li>
                        </ul>
                    </li>

                    <li class="sidebar-list">
                        <a class="linear-icon-link sidebar-link sidebar-title {{ request()->routeIs('admin.attributes', 'admin.add-new-attributes') ? 'active' : '' }}" href="javascript:void(0)">
                            <i class="ri-list-settings-line"></i>
                            <span>Attributes</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li>
                                <a href="{{ route('admin.attributes') }}">Attributes</a>
                            </li>
                            <li>
                                <a href="{{ route('admin.add-new-attributes') }}">Add Attributes</a>
                            </li>
                        </ul>
                    </li>

                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title {{ request()->routeIs('admin.all-users', 'admin.add-new-user') ? 'active' : '' }}" href="javascript:void(0)">
                            <i class="ri-user-3-line"></i>
                            <span>Users</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li>
                                <a href="{{ route('admin.all-users') }}">All users</a>
                            </li>
                            <li>
                                <a href="{{ route('admin.add-new-user') }}">Add new user</a>
                            </li>
                        </ul>
                    </li>

                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title {{ request()->routeIs('admin.role', 'admin.create-role') ? 'active' : '' }}" href="javascript:void(0)">
                            <i class="ri-user-3-line"></i>
                            <span>Roles</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li>
                                <a href="{{ route('admin.role') }}">All roles</a>
                            </li>
                            <li>
                                <a href="{{ route('admin.create-role') }}">Create Role</a>
                            </li>
                        </ul>
                    </li>

                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav {{ request()->routeIs('admin.media') ? 'active' : '' }}" href="{{ route('admin.media') }}">
                            <i class="ri-price-tag-3-line"></i>
                            <span>Media</span>
                        </a>
                    </li>

                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title {{ request()->routeIs('admin.order-list', 'admin.order-detail', 'admin.order-tracking') ? 'active' : '' }}" href="javascript:void(0)">
                            <i class="ri-archive-line"></i>
                            <span>Orders</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li>
                                <a href="{{ route('admin.order-list') }}">Order List</a>
                            </li>
                            <li>
                                <a href="{{ route('admin.order-detail') }}">Order Detail</a>
                            </li>
                            <li>
                                <a href="{{ route('admin.order-tracking') }}">Order Tracking</a>
                            </li>
                        </ul>
                    </li>

                    <li class="sidebar-list">
                        <a class="linear-icon-link sidebar-link sidebar-title {{ request()->routeIs('admin.translation', 'admin.currency-rates') ? 'active' : '' }}" href="javascript:void(0)">
                            <i class="ri-focus-3-line"></i>
                            <span>Localization</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li>
                                <a href="{{ route('admin.translation') }}">Translation</a>
                            </li>
                            <li>
                                <a href="{{ route('admin.currency-rates') }}">Currency Rates</a>
                            </li>
                        </ul>
                    </li>

                    <li class="sidebar-list">
                        <a class="linear-icon-link sidebar-link sidebar-title {{ request()->routeIs('admin.coupon-list', 'admin.create-coupon') ? 'active' : '' }}" href="javascript:void(0)">
                            <i class="ri-price-tag-3-line"></i>
                            <span>Coupons</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li>
                                <a href="{{ route('admin.coupon-list') }}">Coupon List</a>
                            </li>
                            <li>
                                <a href="{{ route('admin.create-coupon') }}">Create Coupon</a>
                            </li>
                        </ul>
                    </li>

                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav {{ request()->routeIs('admin.taxes') ? 'active' : '' }}" href="{{ route('admin.taxes') }}">
                            <i class="ri-price-tag-3-line"></i>
                            <span>Tax</span>
                        </a>
                    </li>

                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav {{ request()->routeIs('admin.product-review') ? 'active' : '' }}" href="{{ route('admin.product-review') }}">
                            <i class="ri-star-line"></i>
                            <span>Product Review</span>
                        </a>
                    </li>

                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav {{ request()->routeIs('admin.support-ticket') ? 'active' : '' }}" href="{{ route('admin.support-ticket') }}">
                            <i class="ri-phone-line"></i>
                            <span>Support Ticket</span>
                        </a>
                    </li>

                    <li class="sidebar-list">
                        <a class="linear-icon-link sidebar-link sidebar-title {{ request()->routeIs('admin.profile-setting') ? 'active' : '' }}" href="javascript:void(0)">
                            <i class="ri-settings-line"></i>
                            <span>Settings</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li>
                                <a href="{{ route('admin.profile-setting') }}">Profile Setting</a>
                            </li>
                        </ul>
                    </li>

                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav {{ request()->routeIs('admin.reports') ? 'active' : '' }}" href="{{ route('admin.reports') }}">
                            <i class="ri-file-chart-line"></i>
                            <span>Reports</span>
                        </a>
                    </li>

                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav {{ request()->routeIs('admin.list-page') ? 'active' : '' }}" href="{{ route('admin.list-page') }}">
                            <i class="ri-list-check"></i>
                            <span>List Page</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="right-arrow" id="right-arrow">
                <i data-feather="arrow-right"></i>
            </div>
        </nav>
    </div>
</div>
<!-- Page Sidebar Ends-->
