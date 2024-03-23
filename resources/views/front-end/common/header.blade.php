<div class="container header-container">
    <div class="header-row">
        <div class="col">
            <div class="logo-container">
                <a href="#">
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
                    <li><a href="{{ url('/user-login') }}">Login</a></li>
                    <li class="signup-wrapper"><a href="#">Sign Up</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>