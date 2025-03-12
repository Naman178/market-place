<div class="container header-container">
    <div class="header-row">
        <div class="col">
            <div class="logo-container">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('front-end/images/infiniylogo.png') }}" alt="Logo">
                </a>
            </div>
        </div>
        <div class="col">
            <div class="menu-container">
                <ul>
                    <li><a href="{{ route('user-price') }}">Price</a></li>
                    {{-- <li><a href="#">Documentation</a></li> --}}
                    <li><a href="#">Guide</a></li>
                    <li><a href="{{ route('user-faq') }}">Faq</a></li>
                    <li><a href="#">Status</a></li>
                    <li><a href="{{ route('contact-us') }}">Contact Us</a></li>
                </ul>
            </div>
        </div>
        <div class="col">
            <div class="signin-container">
                <ul>
                    @auth
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                        <li><a href="{{ url('/user-login') }}">Login</a></li>
                        <li class="signup-wrapper"><a class="signup_btn" href="{{ url('/signup') }}">Sign Up</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </div>
</div>