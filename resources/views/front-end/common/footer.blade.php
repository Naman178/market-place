<div class=" footer-container">
    <div class="container">
        <div class="horizontal-menu-row">
            <ul class="row menu-horizontal left-row">
                <li class="footer-link">
                    <a href="#">General</a>
                </li>
                <li class="footer-link">
                    <a href="#">Account</a>
                </li>
                <li class="footer-link">
                    <a href="#">Resources</a>
                </li>
                <li class="footer-link">
                    <a href="#">Legal</a>
                </li>
            </ul>
            <ul class="row menu-horizontal right-row">
                <li class="social-link">
                    <a href="#"><img class="footer_img" src="{{ asset('storage/Logo_Settings/footer_facebook.png') }}" alt="facebook"></a>
                </li>
                <li class="social-link">
                    <a href="#"><img class="footer_img" src="{{ asset('storage/Logo_Settings/instagram.png') }}" alt="instagram"></a>
                </li>
                <li class="social-link">
                    <a href="#"><img class="footer_img" src="{{ asset('storage/Logo_Settings/twitter.png') }}" alt="twitter"></a>
                </li>
            </ul>
        </div>
        <hr>
        <div class="vertical-menu-row">
            <div class="row left-row">
                <div>
                    <div class="title pb-2">General</div>
                    <ul class="menu-vertical list-style">
                        <li>Documentation</li>
                        <li><a href="{{ route('user-price') }}">Pricing</a></li>
                        <li><a href="{{ route('user-faq') }}">FAQ</a></li>
                        <li>Sponsorship</li>
                        <li><a href="{{ route('contact-us') }}">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <div class="title pb-2">Account</div>
                    <ul class="menu-vertical">
                        <li>Sign Up For Free</li>
                        <li>Free Log in</li>
                        <li><a href="{{url('/user-dashboard#list-settings')}}" id="forgot-password-link">Forgot Password</a></li>
                    </ul>
                </div>
                <div>
                    <div class="title pb-2">Resources</div>
                    <ul class="menu-vertical list-style">
                        <li>Currencies</li>
                        <li>Shopify</li>
                        <li>Gold</li>
                        <li>Silver</li>
                        <li>Forex</li>
                    </ul>
                </div>
                <div>
                    <div class="title pb-2">Legal</div>
                    <ul class="menu-vertical">
                        <li><a href="{{ route('terms-and-condition') }}">Terms & Conditions</a></li>
                        <li><a href="{{ route('privacy-policy') }}">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>
            <div class="row right-row contact">
                <div>
                    <div class="title pb-3">Contact</div>
                    <ul class="menu-vertical">
                        <li>
                            <p>Bhagwati Circle,</p><p>Opposite Annapurna</p><p>Dining Hall, Kaliyabid,</p><p>Bhavnagar - 364002,</p><p>Gujarat India</p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <hr>
        <div class="copyright-row">
            <p>© <script>
                document.write(new Date().getFullYear())
            </script> MetalpriceAPI. all rights reserved.</p>
        </div>
    </div>
</div>