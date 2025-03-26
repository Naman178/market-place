<div class="side-content-wrap">
    <div class="sidebar-left rtl-ps-none ps ps--active-y open" data-perfect-scrollbar="" data-suppress-scroll-x="true">
        <ul class="navigation-left">
            <li class="nav-item {{ request()->is('/*') ? 'active' : '' }}">
                <a class="nav-item-hold" href="{{ route('dashboard') }}">
                    <i class="nav-icon i-Bar-Chart"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
                <div class="triangle"></div>
            </li>
            @can('category-tab-show')
                <li class="nav-item" data-item="product">
                    <a class="nav-item-hold" href="#">
                        <i class="nav-icon i-Professor"></i>
                        <span class="nav-text">Product</span>
                    </a>
                    <div class="triangle"></div>
                </li>
            @endcan
            @can('order-tab-show')
                <li class="nav-item" data-item="orders">
                    <a class="nav-item-hold" href="#">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="nav-text">Orders</span>
                    </a>
                    <div class="triangle"></div>
                </li>
            @endcan
            @can('privacy-policy-tab-show')
                <li class="nav-item" data-item="cms">
                    <a class="nav-item-hold" href="#">
                        <i class="nav-icon i-David-Star"></i>
                        <span class="nav-text">CMS</span>
                    </a>
                    <div class="triangle"></div>
                </li>
            @endcan
            @can('Blog-tab-show')
                <li class="nav-item" data-item="blog">
                    <a class="nav-item-hold" href="#">
                        <i class="nav-icon i-Blogger"></i>
                        <span class="nav-text">Blog</span>
                    </a>
                    <div class="triangle"></div>
                </li>
            @endcan
            @can('email-tab-show')
                <li class="nav-item" data-item="email">
                    <a class="nav-item-hold" href="#">
                        <i class="nav-icon i-Letter-Open"></i>
                        <span class="nav-text">Email</span>
                    </a>
                    <div class="triangle"></div>
                </li>
            @endcan
            @can('user-tab-show')
                <li class="nav-item" data-item="user">
                    <a class="nav-item-hold" href="#">
                        <i class="nav-icon i-Add-UserStar"></i>
                        <span class="nav-text">User</span>
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
        <ul class="childNav" data-parent="product" style="display: none;">
            @can('category-tab-show')
                <li class="nav-item">
                    <a class="{{ request()->is('category*') ? 'active' : '' }}" href="{{ route('category-index') }}">
                        <i class="nav-icon i-Receipt"></i>
                        <span class="nav-text">Category</span>
                    </a>
                </li>
            @endcan
            @can('sub-category-tab-show')
                <li class="nav-item">
                    <a class="{{ request()->is('sub-category*') ? 'active' : '' }}" href="{{ route('sub-category-index') }}">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="nav-text">{{ trans('custom.sub_category_title') }}</span>
                    </a>
                </li>
            @endcan
            @can('items-tab-show')
                <li class="nav-item">
                    <a class="{{ request()->is('items*') ? 'active' : '' }}" href="{{ route('items-index') }}">
                        <i class="nav-icon i-Receipt-3"></i>
                        <span class="nav-text">{{ trans('custom.items_title') }}</span>
                    </a>
                </li>
            @endcan
            @can('coupon-tab-show')
                <li class="nav-item">
                    <a class="{{ request()->is('coupon*') ? 'active' : '' }}" href="{{ route('coupon-index') }}">
                        <i class="nav-icon i-Gift-Box"></i>
                        <span class="nav-text">{{ trans('custom.coupon_title') }}</span>
                    </a>
                </li>
            @endcan
            @can('reviews-tab-show')
                <li class="nav-item">
                    <a class="{{ request()->is('reviews*') ? 'active' : '' }}" href="{{ route('items-list') }}">
                        <i class="nav-icon i-Technorati"></i>
                        <span class="nav-text">{{ trans('custom.reviews_title') }}</span>
                    </a>
                </li>
            @endcan
        </ul>
        <ul class="childNav" data-parent="orders" style="display: none;">
            @can('invoice-tab-show')
                <li class="nav-item">
                    <a class="{{ request()->is('invoice*') ? 'active' : '' }}" href="{{ route('invoice-list') }}">
                        <i class="nav-icon i-Receipt-3"></i>
                        <span class="nav-text">Invoice</span>
                    </a>
                </li>
            @endcan
            @can('order-tab-show')
                <li class="nav-item">
                    <a class="{{ request()->is('order*') ? 'active' : '' }}" href="{{ route('order-list') }}">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="nav-text">Orders</span>
                    </a>
                </li>
            @endcan
        </ul>
        <ul class="childNav" data-parent="cms" style="display: none;">
            @can('privacy-policy-tab-show')
                <li class="nav-item">
                    <a class="{{ request()->is('privacy-policy*') ? 'active' : '' }}" href="{{ route('privacy-policy-index') }}">
                        <i class="nav-icon i-Receipt-4"></i>
                        <span class="nav-text">{{ trans('custom.privacy_policy_title') }}</span>
                    </a>
                </li>
            @endcan
            @can('term-condition-tab-show')
                <li class="nav-item">
                    <a class="{{ request()->is('term-condition*') ? 'active' : '' }}" href="{{ route('term-condition-index') }}">
                        <i class="nav-icon i-File-Text--Image"></i>
                        <span class="nav-text">{{ trans('custom.term_condition_title') }}</span>
                    </a>
                </li>
            @endcan
            @can('FAQ-tab-show')
                <li class="nav-item">
                    <a class="{{ request()->is('FAQ*') ? 'active' : '' }}" href="{{ route('FAQ-index') }}">
                        <i class="nav-icon i-Information"></i>
                        <span class="nav-text">{{ trans('custom.FAQ_title') }}</span>
                    </a>
                </li>
            @endcan
            @can('Testimonial-tab-show')
                <li class="nav-item">
                    <a class="{{ request()->is('Testimonial*') ? 'active' : '' }}" href="{{ route('Testimonial-index') }}">
                        <i class="nav-icon i-Receipt-3"></i>
                        <span class="nav-text">Testimonial</span>
                    </a>
                </li>
            @endcan
            @can('SocialMedia-tab-show')
                <li class="nav-item">
                    <a class="{{ request()->is('SocialMedia*') ? 'active' : '' }}" href="{{ route('SocialMedia-index') }}">
                        <i class="nav-icon i-Receipt-3"></i>
                        <span class="nav-text">Social Media</span>
                    </a>
                </li>
            @endcan
            @can('SEO-tab-show')
                <li class="nav-item">
                    <a class="{{ request()->is('SEO*') ? 'active' : '' }}" href="{{ route('SEO-index') }}">
                        <i class="nav-icon i-Search-on-Cloud"></i>
                        <span class="nav-text">{{ trans('custom.SEO_title') }}</span>
                    </a>
                </li>
            @endcan
        </ul>
        <ul class="childNav" data-parent="blog" style="display: none;">
            @can('Blog-tab-show')
                <li class="nav-item">
                    <a class="{{ request()->is('Blog*') ? 'active' : '' }}" href="{{ route('Blog-index') }}">
                        <i class="nav-icon i-Blogger"></i>
                        <span class="nav-text">{{ trans('custom.Blog_title') }}</span>
                    </a>
                </li>
            @endcan
            @can('Blog_category-tab-show')
                <li class="nav-item">
                    <a class="{{ request()->is('Blog_category*') ? 'active' : '' }}" href="{{ route('Blog_category-index') }}">
                        <i class="nav-icon i-File-Clipboard-File--Text"></i>
                        <span class="nav-text">{{ trans('custom.Blog_category_title') }}</span>
                    </a>
                </li>
            @endcan
        </ul>
        <ul class="childNav" data-parent="email" style="display: none;">
            @can('newsletter-tab-show')
                <li class="nav-item">
                    <a class="{{ request()->is('newsletter*') ? 'active' : '' }}" href="{{ route('newsletter') }}">
                        <i class="nav-icon i-Receipt"></i>
                        <span class="nav-text">Newsletter</span>
                    </a>
                </li>
            @endcan
            @can('email-tab-show')
                <li class="nav-item">
                    <a class="{{ request()->is('email*') ? 'active' : '' }}" href="{{ route('email') }}">
                        <i class="nav-icon i-Receipt-3"></i>
                        <span class="nav-text">Sent Mail</span>
                    </a>
                </li>
            @endcan
        </ul>
        <ul class="childNav" data-parent="user" style="display: none;">
            @can('user-tab-show')
                <li class="nav-item">
                    <a class="{{ request()->is('user*') ? 'active' : '' }}" href="{{ route('user-index') }}">
                        <i class="nav-icon i-Add-User"></i>
                        <span class="nav-text">User</span>
                    </a>
                </li>
            @endcan
            @can('role-tab-show')
                <li class="nav-item">
                    <a class="{{ request()->is('role*') ? 'active' : '' }}" href="{{ route('roles.index') }}">
                        <i class="nav-icon i-Add-UserStar"></i>
                        <span class="nav-text">Roles</span>
                    </a>
                </li>
            @endcan
        </ul>
    </div>
    <div class="sidebar-overlay"></div>
</div>
<!--=============== Left side End ================-->
