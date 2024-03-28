<div class="container header-container">
    <div class="header-row">
        <div class="col">
            <div class="logo-container">
                <a href="{{ url('/home') }}">
                    <img src="{{ asset('front-end/images/header_logo.png') }}" alt="Logo">
                </a>
            </div>
        </div>
        <div class="col">
            <div class="menu-container">
                <ul>
                    <li><a href="#">Price</a></li>
                    <li><a href="#">Documentation</a></li>
                    <li><a href="#">Guide</a></li>
                    <li><a href="#">Faq</a></li>
                    <li><a href="#">Status</a></li>
                </ul>
            </div>
        </div>
        <div class="col">
            <div class="signin-container">
                <ul>
                    @auth
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Welcome, {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @else
                        <li><a href="{{ url('/user-login') }}">Login</a></li>
                        <li class="signup-wrapper"><a href="#">Sign Up</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </div>
</div>