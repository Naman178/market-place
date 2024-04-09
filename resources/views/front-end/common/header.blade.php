<style>
    .dropdown-item {
        border-radius: .375rem;
        padding-left: .75rem;
        padding-right: .75rem;
        background-color: transparent;
        transition: all .1s ease-in-out;
        &:hover {
            background-color: rgb(236 239 241);
            color : rgb(38 50 56);
        }
    }

    .dropdown-menu{
        border-radius: .375rem;
        padding: .75rem;
    }
</style>

<div class="container header-container">
    <div class="header-row">
        <div class="col">
            <div class="logo-container">
                <a href="{{ url('/') }}">
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
                                <a class="dropdown-item" href="{{ route('orders') }}">Orders</a>
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
