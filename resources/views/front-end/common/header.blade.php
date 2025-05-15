@php 
 $site = \App\Models\Settings::where('key', 'site_setting')->first();
@endphp
<div class="container">
    <div class="header-row py-4">
        <div class="col p-0 m-0 logo-container">
            <a href="{{ url('/') }}">
                @if ($site && $site['value']['logo_image'] && $site['value']['logo_image'] != null)
                    <img src="{{ asset('storage/Logo_Settings/'.$site['value']['logo_image']) }}" alt="Logo">
                @else
                    <img src="{{ asset('front-end/images/infiniylogo.png') }}" alt="Logo">
                @endif
            </a>
        </div>
        <div class="col p-0 m-0 menu-container menu-1">
                <ul>
                    @if (!empty($category))
                        <li class="d-flex align-items-center justify-content-center"><a href="{{ route('product.list', ['category' => $category->name, 'slug' => Str::slug( $subcategory['name']) ?? null]) }}">Products</a></li>
                    @elseif (!empty($subcategory))
                        <li class="d-flex align-items-center justify-content-center"><a href="{{ route('product.list', ['category' => $category->name, 'slug' => Str::slug( $subcategory['name']) ?? null]) }}">Products</a></li>
                    @endif
                    {{-- <li><a href="#">Documentation</a></li> --}}
                    <li class="d-flex align-items-center justify-content-center"><a href="{{ route('blog-index') }}">Blog</a></li>
                    <li class="d-flex align-items-center justify-content-center"><a href="{{ route('user-faq') }}">FAQs</a></li>
                    <li class="d-flex align-items-center justify-content-center"><a href="{{ route('contact-us') }}">Contact Us</a></li>
                    @auth
                    <li class="dropdown d_flex align-items-center justify-content-center">
                        <a href="#" class="dropdown-toggle welcome" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="d_flex align-items-center justify-content-center">  
                            @if (empty(auth()->user()->profile_pic) || auth()->user()->profile_pic == null)
                                @php
                                    $names = explode(' ', auth()->user()->name);
                                    $initials = '';
                                    foreach ($names as $name) {
                                        $initials .= strtoupper(substr($name, 0, 1));
                                    }
                                @endphp
                                  <div class="rounded-full bg-gray-200 d_flex items-center justify-content-center text-gray-700 mr-2" title="{{ auth()->user()->name }}">
                                    {{ $initials ?: strtoupper(implode('', array_map(function($namePart) { return $namePart[0]; }, explode(' ', auth()->user()->name)))) }}
                                </div>
                            @else
                                @php
                                    $profilePic = filter_var(auth()->user()->profile_pic, FILTER_VALIDATE_URL) 
                                            ? auth()->user()->profile_pic 
                                            : asset('assets/images/faces/' . auth()->user()->profile_pic);
                                @endphp
                                <img src="{{ $profilePic }}" alt="profile"
                                    class="rounded-full header_image">
                            @endif 
                         <span class="dropdown_label" data-fullname="{{ Auth::user()->name }}"> {{ Auth::user()->name }}  </span></span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="{{ route('user-dashboard') }}">
                                <span class="dropdown_label">  Dashboard </span>
                            </a>
                            <a class="dropdown-item" href="{{ route('wishlist.index') }}">
                                <span class="dropdown_label">  Wishlist </span>
                            </a>
                            <a class="dropdown-item" href="{{ route('profile') }}">
                                <span class="dropdown_label">  Profile Setting </span>
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <span class="dropdown_label"> Logout </span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @else
                    <li class="dropdown d_flex align-items-center justify-content-center"><a class="welcome" href="{{ url('/user-login') }}">Login</a></li>
                    <li class="dropdown d_flex align-items-center justify-content-center"><a class="welcome" href="{{ url('/signup') }}">Sign Up</a></li>
                @endif
                </ul>
        </div>

        <div class="menu-toggle d-lg-none" id="menu-toggle">
            <button class="menu-btn">
                <svg class="vbp-header-menu-button__svg">
                    <line x1="0" y1="50%" x2="100%" y2="50%" class="top" shape-rendering="crispEdges" />
                    <line x1="0" y1="50%" x2="100%" y2="50%" class="middle" shape-rendering="crispEdges" />
                    <line x1="0" y1="50%" x2="100%" y2="50%" class="bottom" shape-rendering="crispEdges" />
                  </svg>
            </button>
        </div>

        <!-- Navigation Menu -->
        <div class="menu-container menu-1 d-none d-lg-block">
            <ul>
                @if (!empty($category))
                    <li class="d-flex align-items-center justify-content-center"><a href="{{ route('product.list', ['category' => $category->name, 'slug' => Str::slug( $subcategory['name']) ?? null]) }}">Products</a></li>
                @elseif (!empty($subcategory))
                    <li class="d-flex align-items-center justify-content-center"><a href="{{ route('product.list', ['category' => $category->name, 'slug' => Str::slug( $subcategory['name']) ?? null]) }}">Products</a></li>
                @endif
                {{-- <li><a href="#">Documentation</a></li> --}}
                <li class="d-flex align-items-center justify-content-center"><a href="{{ route('blog-index') }}">Blog</a></li>
                <li class="d-flex align-items-center justify-content-center"><a href="{{ route('user-faq') }}">Faq</a></li>
                <li class="d-flex align-items-center justify-content-center"><a href="{{ route('contact-us') }}">Contact Us</a></li>
                @auth
                <li class="dropdown d_flex align-items-center justify-content-center">
                    <a href="#" class="dropdown-toggle welcome" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d_flex align-items-center justify-content-center">  
                        @if (empty(auth()->user()->profile_pic) || auth()->user()->profile_pic == null)
                            @php
                                $names = explode(' ', auth()->user()->name);
                                $initials = '';
                                foreach ($names as $name) {
                                    $initials .= strtoupper(substr($name, 0, 1));
                                }
                            @endphp
                              <div class="rounded-full bg-gray-200 d_flex items-center justify-content-center text-gray-700 mr-2" title="{{ auth()->user()->name }}">
                                {{ $initials ?: strtoupper(implode('', array_map(function($namePart) { return $namePart[0]; }, explode(' ', auth()->user()->name)))) }}
                            </div>
                        @else
                            <img src="{{ asset('assets/images/faces/' . auth()->user()->profile_pic) }}" alt="profile"
                                class="rounded-full header_image">
                        @endif 
                     <span class="dropdown_label" data-fullname="{{ Auth::user()->name }}"> {{ Auth::user()->name }}  </span></span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="{{ route('user-dashboard') }}">
                            <span class="dropdown_label">  Dashboard </span>
                        </a>
                        <a class="dropdown-item" href="{{ route('profile') }}">
                            <span class="dropdown_label">  Profile Setting </span>
                        </a>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <span class="dropdown_label"> Logout </span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            @else
                <li class="dropdown d_flex align-items-center justify-content-center"><a class="welcome" href="{{ url('/user-login') }}">Login</a></li>
                <li class="dropdown d_flex align-items-center justify-content-center"><a class="welcome" href="{{ url('/signup') }}">Sign Up</a></li>
            @endif
            </ul>
        </div>
    </div>
    <!-- Mobile Navigation -->
    <div class="mobile-menu d-none" id="mobile-menu">
        <ul>
            @if (!empty($category))
                <li class="d-flex align-items-center justify-content-center"><a href="{{ route('product.list', ['category' => $category->name, 'slug' => Str::slug( $subcategory['name']) ?? null]) }}">Products</a></li>
            @elseif (!empty($subcategory))
                <li class="d-flex align-items-center justify-content-center"><a href="{{ route('product.list', ['category' => $category->name, 'slug' => Str::slug( $subcategory['name']) ?? null]) }}">Products</a></li>
            @endif
            <li><a href="{{ route('user-faq') }}">FAQs</a></li>
            <li><a href="{{ route('contact-us') }}">Contact Us</a></li>
            @auth
                <li><a href="{{ route('user-dashboard') }}">Dashboard</a></li>
                <li><a href="{{ route('profile') }}">Profile Setting</a></li>
                <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
            @else
                <li><a href="{{ url('/user-login') }}">Login</a></li>
                <li><a href="{{ url('/signup') }}">Sign Up</a></li>
            @endif
        </ul>
    </div>
        {{-- <div class="col ml-30">
            <div class="signin-container menu-1 mt_15">
                <ul>
                    @auth
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle welcome" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="dropdown_label">  Welcome, {{ Auth::user()->name }} </span>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="{{ route('user-dashboard') }}">
                                    <span class="dropdown_label">  Dashboard </span>
                                </a>
                                <a class="dropdown-item" href="{{ route('profile') }}">
                                    <span class="dropdown_label">  Profile Setting </span>
                                </a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <span class="dropdown_label"> Logout </span>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @else
                        <li><a class="welcome" href="{{ url('/user-login') }}">Login</a></li>
                        <li><a class="welcome" href="{{ url('/signup') }}">Sign Up</a></li>
                    
                        <li class="signup-wrapper"><a class="signup_btn" href="{{ url('/signup') }}"> 
                            <svg width="112px" height="49px" viewBox="0 0 180 60" >
                                <polyline points="179,1 179,59 1,59 1,1 179,1" class="bg-line" />
                                <polyline points="179,1 179,59 1,59 1,1 179,1" class="hl-line" />
                            </svg>
                          </svg><span> Sign Up </span></a></li>
                    @endauth
                </ul>
            </div>
        </div> --}}
    </div>
</div>