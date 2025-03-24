<div class="side-content-wrap">
    <div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
        <ul class="navigation-left">
            <li class="nav-item {{ request()->is('/*') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ route('dashboard') }}">
                    <i class="nav-icon i-Bar-Chart"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
                <div class="triangle"></div>
            </li>
            @can('category-tab-show')
                <li class="nav-item {{ request()->is('category*') ? 'active' : '' }}">
                    <a class="nav-item-hold" href="{{ route('category-index') }}">
                        <i class="nav-icon i-Receipt"></i>
                        <span class="nav-text">Category</span>
                    </a>
                    <div class="triangle"></div>
                </li>
            @endcan
            @can('sub-category-tab-show')
                <li class="nav-item {{ request()->is('sub-category*') ? 'active' : '' }}">
                    <a class="nav-item-hold" href="{{ route('sub-category-index') }}">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="nav-text">{{ trans('custom.sub_category_title') }}</span>
                    </a>
                    <div class="triangle"></div>
                </li>
            @endcan
            @can('items-tab-show')
                <li class="nav-item {{ request()->routeIs('items-index') ? 'active' : '' }}">
                    <a class="nav-item-hold" href="{{ route('items-index') }}">
                        <i class="nav-icon i-Receipt-3"></i>
                        <span class="nav-text">{{ trans('custom.items_title') }}</span>
                    </a>
                    <div class="triangle"></div>
                </li>
            @endcan
            @can('coupon-tab-show')
                <li class="nav-item {{ request()->routeIs('coupon-index') ? 'active' : '' }}">
                    <a class="nav-item-hold" href="{{ route('coupon-index') }}">
                        <i class="nav-icon i-Gift-Box"></i>
                        <span class="nav-text">{{ trans('custom.coupon_title') }}</span>
                    </a>
                    <div class="triangle"></div>
                </li>
            @endcan
            @can('reviews-tab-show')
                <li class="nav-item {{ request()->routeIs('items-list') ? 'active' : '' }}">
                    <a class="nav-item-hold" href="{{ route('items-list') }}">
                        <i class="nav-icon i-Technorati"></i>
                        <span class="nav-text">{{ trans('custom.reviews_title') }}</span>
                    </a>
                    <div class="triangle"></div>
                </li>
            @endcan
            @can('term-condition-tab-show')
                <li class="nav-item {{ request()->routeIs('term-condition*') ? 'active' : '' }}">
                    <a class="nav-item-hold" href="{{ route('term-condition-index') }}">
                        <i class="nav-icon i-File-Text--Image"></i>
                        <span class="nav-text">{{ trans('custom.term_condition_title') }}</span>
                    </a>
                    <div class="triangle"></div>
                </li>
            @endcan
            @can('privacy-policy-tab-show')
                <li class="nav-item {{ request()->routeIs('privacy-policy*') ? 'active' : '' }}">
                    <a class="nav-item-hold" href="{{ route('privacy-policy-index') }}">
                        <i class="nav-icon i-Security-Settings"></i>
                        <span class="nav-text">{{ trans('custom.privacy_policy_title') }}</span>
                    </a>
                    <div class="triangle"></div>
                </li>
            @endcan
            @can('SEO-tab-show')
                <li class="nav-item {{ request()->routeIs('SEO*') ? 'active' : '' }}">
                    <a class="nav-item-hold" href="{{ route('SEO-index') }}">
                        <i class="nav-icon i-Search-on-Cloud"></i>
                        <span class="nav-text">{{ trans('custom.SEO_title') }}</span>
                    </a>
                    <div class="triangle"></div>
                </li>
            @endcan
            @can('FAQ-tab-show')
                <li class="nav-item {{ request()->routeIs('FAQ*') ? 'active' : '' }}">
                    <a class="nav-item-hold" href="{{ route('FAQ-index') }}">
                        <i class="nav-icon i-Information"></i>
                        <span class="nav-text">{{ trans('custom.FAQ_title') }}</span>
                    </a>
                    <div class="triangle"></div>
                </li>
            @endcan
            @can('Blog-tab-show')
                <li class="nav-item {{ request()->routeIs('Blog-index*') ? 'active' : '' }}">
                    <a class="nav-item-hold" href="{{ route('Blog-index') }}">
                        <i class="nav-icon i-Blogger"></i>
                        <span class="nav-text">{{ trans('custom.Blog_title') }}</span>
                    </a>
                    <div class="triangle"></div>
                </li>
            @endcan
            @can('Blog_category-tab-show')
                <li class="nav-item {{ request()->routeIs('Blog_category-index*') ? 'active' : '' }}">
                    <a class="nav-item-hold" href="{{ route('Blog_category-index') }}">
                        <i class="nav-icon i-File-Clipboard-File--Text"></i>
                        <span class="nav-text">{{ trans('custom.Blog_category_title') }}</span>
                    </a>
                    <div class="triangle"></div>
                </li>
            @endcan
            @can('user-tab-show')
                <li class="nav-item {{ request()->is('user*') ? 'active' : '' }}">
                    <a class="nav-item-hold" href="{{ route('user-index') }}">
                        <i class="nav-icon i-Add-User"></i>
                        <span class="nav-text">User</span>
                    </a>
                    <div class="triangle"></div>
                </li>
            @endcan
            @can('role-tab-show')
                <li class="nav-item {{ request()->is('role*') ? 'active' : '' }}">
                    <a class="nav-item-hold" href="{{ route('roles.index') }}">
                        <i class="nav-icon i-Add-UserStar"></i>
                        <span class="nav-text">Roles</span>
                    </a>
                    <div class="triangle"></div>
                </li>
            @endcan
            @can('newsletter-tab-show')
                <li class="nav-item {{ request()->is('newsletter*') ? 'active' : '' }}">
                    <a class="nav-item-hold" href="{{ route('newsletter') }}">
                        <i class="nav-icon i-Receipt"></i>
                        <span class="nav-text">Newsletter</span>
                    </a>
                    <div class="triangle"></div>
                </li>
            @endcan
            @can('email-tab-show')
                <li class="nav-item {{ request()->is('email*') ? 'active' : '' }}">
                    <a class="nav-item-hold" href="{{ route('email') }}">
                        <i class="nav-icon i-Receipt-3"></i>
                        <span class="nav-text">Sent Mail</span>
                    </a>
                    <div class="triangle"></div>
                </li>
            @endcan
            @can('invoice-tab-show')
                <li class="nav-item {{ request()->routeIs('invoice-list') ? 'active' : '' }}">
                    <a class="nav-item-hold" href="{{ route('invoice-list') }}">
                        <i class="nav-icon i-Receipt-3"></i>
                        <span class="nav-text">Invoice</span>
                    </a>
                    <div class="triangle"></div>
                </li>
            @endcan
            @can('Testimonial-tab-show')
                <li class="nav-item {{ request()->routeIs('Testimonial-list') ? 'active' : '' }}">
                    <a class="nav-item-hold" href="{{ route('Testimonial-index') }}">
                        <i class="nav-icon i-Receipt-3"></i>
                        <span class="nav-text">Testimonial</span>
                    </a>
                    <div class="triangle"></div>
                </li>
            @endcan
            @can('order-tab-show')
                <li class="nav-item {{ request()->is('order-list') ? 'active' : '' }}">
                    <a class="nav-item-hold" href="{{ route('order-list') }}">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="nav-text">Orders</span>
                    </a>
                    <div class="triangle"></div>
                </li>
            @endcan
            @can('settings-tab-show')
                <li class="nav-item {{ request()->is('settings*') ? 'active' : '' }}">
                    <a class="nav-item-hold" href="{{ route('settings-index') }}">
                        <i class="nav-icon i-Cloud-Settings"></i>
                        <span class="nav-text">Settings</span>
                    </a>
                    <div class="triangle"></div>
                </li>
            @endcan
        </ul>
    </div>

    <div class="sidebar-left-secondary rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
    </div>
    <div class="sidebar-overlay"></div>
</div>
<!--=============== Left side End ================-->
