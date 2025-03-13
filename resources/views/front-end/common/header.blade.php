<div class="header-container">
    <div class="header-row">
        <div class="col">
            <div class="logo-container">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('front-end/images/infiniylogo.png') }}" alt="Logo">
                </a>
            </div>
        </div>
        <div class="col">
            <div class="menu-container menu-1 mt_15">
                <ul>
                    @if ($category)
                        <li><a href="{{ route('product.list', ['categoryOrSubcategory' => $category->id]) }}">Products</a></li>
                    @elseif ($subcategory)
                        <li><a href="{{ route('product.list', ['categoryOrSubcategory' => $subcategory->id]) }}">Products</a></li>
                    @endif
                    {{-- <li><a href="#">Documentation</a></li> --}}
                    <li><a href="{{ route('user-faq') }}">Faq</a></li>
                    <li><a href="{{ route('contact-us') }}">Contact Us</a></li>
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
                @endif
                </ul>
            </div>
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