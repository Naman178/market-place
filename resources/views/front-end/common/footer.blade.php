@php 
 $site = \App\Models\Settings::where('key', 'site_setting')->first();
@endphp
{{-- <div class=" footer-container">
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
                        @if ($category)
                            <li><a href="{{ route('product.list', ['categoryOrSubcategory' => $category->id]) }}">Products</a></li>
                        @elseif ($subcategory)
                            <li><a href="{{ route('product.list', ['categoryOrSubcategory' => $subcategory->id]) }}">Products</a></li>
                        @endif
                        <li><a href="{{ route('user-faq') }}">FAQ</a></li>
                        <li>Sponsorship</li>
                        <li><a href="{{ route('contact-us') }}">Contact</a></li>
                        <li><a href="{{ route('wishlist.index') }}">Wishlist</a></li>
                    </ul>
                </div>
                <div>
                    <div class="title pb-2">Account</div>
                    <ul class="menu-vertical">
                        <li>Sign Up For Free</li>
                        <li>Free Log in</li>
                        @if (Auth::check())
                            <li><a href="{{url('/profile-settings')}}">Forgot Password</a></li>
                        @endif
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
                <div>
                    <div class="title pb-2">Contact</div>
                    <ul class="menu-vertical">
                        <li>
                            <p> B-Shop No. 4,</p><p>Shiv Shakti Luxuria,</p><p>Near Ocean Park 1,</p> <p> Bhagwati Circle,</p> <p> Kaliyabid, </p> <p>Bhavnagar - 364002,</p><p>Gujarat India</p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row right-row contact">
                <div class="w-100">
                    <div class="title pb-3">Contact</div>
                    <ul class="menu-vertical">
                        <li>
                            <p> B-Shop No. 4,</p><p>Shiv Shakti Luxuria,</p><p>Near Ocean Park 1,</p> <p> Bhagwati Circle,</p> <p> Kaliyabid, </p> <p>Bhavnagar - 364002,</p><p>Gujarat India</p>
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
</div> --}}

{{-- 
<footer class="footer-04">
    <div class="container">
        <div class="row">
            <div class="col-md-5 col-lg-3 mb-md-0 mb-4 padding-left">
                <h2 class="footer-heading">Quick Links</h2>
                <ul class="list-unstyled">
                     @if (!empty($subcategory))
                        <li>
                            <a href="{{ route('product.list.show') }}">
                                Products
                            </a>
                        </li>
                    @elseif (!empty($category))
                        <li>
                            <a href="{{ route('product.list.show') }}">
                                Products
                            </a>
                        </li>
                    @endif
                    <li><a class="py-1 d-block" href="{{ route('user-faq') }}">FAQ</a></li> 
                    <li><a class="py-1 d-block" href="{{ route('contact-us') }}">Contact</a></li>
                    <li><a class="py-1 d-block" href="{{ route('wishlist.index') }}">Wishlist</a></li>
                </ul>
            </div>
            <div class="col-md-6 col-lg-4 mb-md-0 mb-4 padding-left">
                <h2 class="footer-heading">Contact</h2>
                <ul class="list-unstyled">
                    <li>  <p> B-Shop No. 4,</p><p>Shiv Shakti Luxuria,</p><p>Near Ocean Park 1,</p> <p> Bhagwati Circle,</p> <p> Kaliyabid, </p> <p>Bhavnagar - 364002,</p><p>Gujarat India</p></li>
                </ul>
            </div>
            <div class="col-md-6 col-lg-4 mb-md-0 mb-4 padding-left">
                <h2 class="footer-heading">Subcribe</h2>
                <div class="subscribe-form">
                    <div class="form-group d_flex">
                        <input type="email" class="form-control rounded-left email_txt" value="" name="email" placeholder="Enter your email" required>
                        <a class="form-control submit rounded-right subscribe_btn" data-route="{{route('newsletter-add')}}"> 
                                <span class="sr-only">Submit</span><i class="fa fa-paper-plane"></i></a>
                      
                    </div>
                    <span class="subscribe_success ml-0"></span>
                </div>
                <h2 class="footer-heading mt-5">Follow us</h2>
                <ul class="ftco-footer-social p-0">
                    <li class="ftco-animate"><a href="#" data-toggle="tooltip" data-placement="top" title=""
                            data-original-title="Twitter"><span class="ion-logo-twitter"><img class="footer_img" src="{{ asset('storage/Logo_Settings/twitter.png') }}" alt="facebook"></span></a></li>
                    <li class="ftco-animate"><a href="#" data-toggle="tooltip" data-placement="top" title=""
                            data-original-title="Facebook"><span class="ion-logo-facebook"><img class="footer_img" src="{{ asset('storage/Logo_Settings/footer_facebook.png') }}" alt="instagram"></span></a></li>
                    <li class="ftco-animate"><a href="#" data-toggle="tooltip" data-placement="top" title=""
                            data-original-title="Instagram"><span class="ion-logo-instagram"><img class="footer_img" src="{{ asset('storage/Logo_Settings/instagram.png') }}" alt="twitter"></span></a></li>
                    <li class="ftco-animate"><a href="#" data-toggle="tooltip" data-placement="top" title=""
                        data-original-title="Instagram"><span class="ion-logo-instagram"><img class="footer_img" src="{{ asset('storage/Logo_Settings/linkedin.png') }}" alt="Linked In"></span></a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="w-100 mt-5 border-top py-5">
        <div class="container padding-left">
            <div class="row">
                <div class="col-md-6 col-lg-7">

                    <p class="copyright">© <script>
                            document.write(new Date().getFullYear())
                        </script> MetalpriceAPI. all rights reserved.</p>
                    </p>
                </div>
                <div class="col-md-6 col-lg-5 text-md-right">
                    <p class="mb-0 list-unstyled">
                        <a class="mr-1" href="{{ route('terms-and-condition') }}">Terms & Conditions</a>
                        <a> | </a>
                        <a class="mr-2 ml-1" href="{{ route('privacy-policy') }}">Privacy Policy</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer> --}}
<footer class="global-footer">
    <div class="container">
        <div class="global-footer__container">
            <nav class="global-footer-info-links">
                <hr class="global-footer__separator is-hidden-desktop h-mb4">

                <ul class="global-footer-info-links__list">
                    <li class="global-footer-info-links__list-item">
                        <ul class="global-footer-sublist">
                            <li class="global-footer-sublist__item-title">
                                Envato Market
                            </li>
                            <li class="global-footer-sublist__item h-p0">
                                <a class="global-footer__text-link" href="#">Terms</a>
                            </li>
                            <li class="global-footer-sublist__item h-p0">
                                <a class="global-footer__text-link" href="#">Licenses</a>
                            </li>
                            <li class="global-footer-sublist__item h-p0">
                                <a class="global-footer__text-link" href="#">Market API</a>
                            </li>
                            <li class="global-footer-sublist__item h-p0">
                                <a class="global-footer__text-link" href="#">Become an affiliate</a>
                            </li>
                            <li class="global-footer-sublist__item h-p0">
                                <a class="global-footer__text-link" href="#">Cookies</a>
                            </li>
                            <li class="global-footer-sublist__item h-p0">
                                <button type="button" class="global-footer__text-link"
                                    data-view="cookieSettings">Cookie Settings</button>
                            </li>
                        </ul>
                    </li>
                    <li class="global-footer-info-links__list-item">
                        <ul class="global-footer-sublist">
                            <li class="global-footer-sublist__item-title">
                                Help
                            </li>
                            <li class="global-footer-sublist__item h-p0">
                                <a class="global-footer__text-link" href="#">Help Center</a>
                            </li>
                            <li class="global-footer-sublist__item h-p0">
                                <a class="global-footer__text-link" href="#">Authors</a>
                            </li>
                        </ul>
                    </li>
                    <li class="global-footer-info-links__list-item">
                        <ul class="global-footer-sublist">
                            <li class="global-footer-sublist__item-title">
                                Our Community
                            </li>
                            <li class="global-footer-sublist__item h-p0">
                                <a class="global-footer__text-link" href="#">Community</a>
                            </li>
                            <li class="global-footer-sublist__item h-p0">
                                <a class="global-footer__text-link" href="#">Blog</a>
                            </li>
                            <li class="global-footer-sublist__item h-p0">
                                <a class="global-footer__text-link" href="#">Forums</a>
                            </li>
                            <li class="global-footer-sublist__item h-p0">
                                <a class="global-footer__text-link" href="#">Meetups</a>
                            </li>
                        </ul>
                    </li>
                    <li class="global-footer-info-links__list-item">
                        <ul class="global-footer-sublist">
                            <li class="global-footer-sublist__item-title">
                                Meet Envato
                            </li>
                            <li class="global-footer-sublist__item h-p0">
                                <a class="global-footer__text-link" href="#">About Envato</a>
                            </li>
                            <li class="global-footer-sublist__item h-p0">
                                <a class="global-footer__text-link" href="#">Careers</a>
                            </li>
                            <li class="global-footer-sublist__item h-p0">
                                <a class="global-footer__text-link" href="#">Privacy Policy</a>
                            </li>
                            <li class="global-footer-sublist__item h-p0">
                                <a class="global-footer__text-link" href="#">Do not sell or share my personal
                                    information</a>
                            </li>
                            <li class="global-footer-sublist__item h-p0">
                                <a class="global-footer__text-link" href="#">Sitemap</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>

            <div class="global-footer-stats">
                <div class="global-footer-stats__content">
                    <img class="global-footer-stats__logo" alt="Envato Market"
                        src="https://public-assets.envato-static.com/assets/logos/envato_market-dd390ae860330996644c1c109912d2bf63885fc075b87215ace9b5b4bdc71cc8.svg">
                        {{-- @if ($site && $site['value']['logo_image'] && $site['value']['logo_image'] != null)
                            <img class="global-footer-stats__logo" src="{{ asset('storage/Logo_Settings/'.$site['value']['logo_image']) }}" alt="Logo">
                        @else
                            <img class="global-footer-stats__logo" src="{{ asset('front-end/images/infiniylogo.png') }}" alt="Logo">
                        @endif --}}
                    <ul class="global-footer-stats__list">
                        <li class="global-footer-stats__list-item h-p0">
                            <span class="global-footer-stats__number">77,430,912</span> items sold

                        </li>
                        <li class="global-footer-stats__list-item h-p0">
                            <span class="global-footer-stats__number">$1,216,496,956</span> community earnings

                        </li>
                    </ul>
                </div>
                <div class="global-footer-stats__bcorp">
                    <a target="_blank" rel="noopener noreferrer" class="global-footer-bcorp-link" href="#">
                        <img class="global-footer-bcorp-logo" width="50" alt="B Corp Logo" loading="lazy"
                            src="https://public-assets.envato-static.com/assets/header-footer/logo-bcorp-e83f7da84188b8edac311fbf08eaa86634e9db7c67130cdc17837c1172c5f678.svg">
                    </a>
                </div>
            </div>
        </div>

        <hr class="global-footer__separator">
        <div class="global-footer__container">
            <div class="global-footer-company-links">
                <ul class="global-footer-company-links__list">
                    <li class="global-footer-company-links__list-item">
                        <a class="global-footer__text-link -opacity-full"
                            data-analytics-view-payload="{&quot;eventName&quot;:&quot;view_promotion&quot;,&quot;contextDetail&quot;:&quot;footer nav&quot;,&quot;ecommerce&quot;:{&quot;promotionId&quot;:&quot;elements_mkt-footernav&quot;,&quot;promotionName&quot;:&quot;elements_mkt-footernav&quot;,&quot;promotionType&quot;:&quot;elements referral&quot;}}"
                            data-analytics-click-payload="{&quot;eventName&quot;:&quot;select_promotion&quot;,&quot;contextDetail&quot;:&quot;footer nav&quot;,&quot;ecommerce&quot;:{&quot;promotionId&quot;:&quot;elements_mkt-footernav&quot;,&quot;promotionName&quot;:&quot;elements_mkt-footernav&quot;,&quot;promotionType&quot;:&quot;elements referral&quot;}}"
                            href="https://elements.envato.com?utm_campaign=elements_mkt-footernav"
                            data-analytics-viewed="true">Envato Elements</a>
                    </li>
                    <li class="global-footer-company-links__list-item">
                        <a class="global-footer__text-link -opacity-full" href="#">Placeit by Envato</a>
                    </li>
                    <li class="global-footer-company-links__list-item">
                        <a class="global-footer__text-link -opacity-full" href="#">Envato Tuts+</a>
                    </li>
                    <li class="global-footer-company-links__list-item">
                        <a class="global-footer__text-link -opacity-full" href="#">All Products</a>
                    </li>
                    <li class="global-footer-company-links__list-item">
                        <a class="global-footer__text-link -opacity-full" href="#">Sitemap</a>
                    </li>
                </ul>

                <hr class="global-footer__separator is-hidden-tablet-and-above h-mt3">


                <small class="global-footer-company-links__price-disclaimer">
                    Price is in US dollars and excludes tax and handling fees
                </small>

                <small class="global-footer-company-links__copyright">
                    © 2025 Envato Pty Ltd. Trademarks and brands are the property of their respective owners.
                </small>
            </div>

            <div class="global-footer-social">
                <ul>
                    <li class="global-footer-social__list-item">
                        <a class="global-footer__icon-link" rel="nofollow" href="#">
                            <img src="https://public-assets.envato-static.com/assets/header-footer/social/twitter-fed054cb31fc18407431a26876142c31a26c6bd59026c684d9625e4d7e58002a.svg"
                                class="global-footer-social__icon" alt="Twitter" title="Twitter" width="22"
                                height="22">
                        </a>
                    </li>
                    <li class="global-footer-social__list-item">
                        <a class="global-footer__icon-link" rel="nofollow" href="#">
                            <img src="https://public-assets.envato-static.com/assets/header-footer/social/facebook-20d27cecd9ae46e6f7bad373316a0dc544669d42dbe0f66b3672720fbe5592fc.svg"
                                class="global-footer-social__icon" alt="Facebook" title="Facebook" width="22"
                                height="22">
                        </a>
                    </li>
                    <li class="global-footer-social__list-item">
                        <a class="global-footer__icon-link" rel="nofollow" href="#">
                            <img src="https://public-assets.envato-static.com/assets/header-footer/social/youtube-2d6a8f758426e727939834a47fe9e16ed6b651afed9ca4327a986f76f496594a.svg"
                                class="global-footer-social__icon" alt="YouTube" title="YouTube" width="22"
                                height="22">
                        </a>
                    </li>
                    <li class="global-footer-social__list-item">
                        <a class="global-footer__icon-link" rel="nofollow" href="#">
                            <img src="https://public-assets.envato-static.com/assets/header-footer/social/instagram-dce9fbf4d8428e6f75492fdc4e32ef7543ce3ba6347a5b055e7ac68c45416dc2.svg"
                                class="global-footer-social__icon" alt="Instagram" title="Instagram" width="22"
                                height="22">
                        </a>
                    </li>
                    <li class="global-footer-social__list-item">
                        <a class="global-footer__icon-link" rel="nofollow" href="#">
                            <img src="https://public-assets.envato-static.com/assets/header-footer/social/pinterest-2e00aae335d66e4e28273bbfe4e9428ca8d8d91cbd9122d81312218ea34747df.svg"
                                class="global-footer-social__icon" alt="Pinterest" title="Pinterest" width="22"
                                height="22">
                        </a>
                    </li>
                </ul>
            </div>
        </div>

    </div>
</footer>