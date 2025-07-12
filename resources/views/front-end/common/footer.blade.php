@php 
 $site = \App\Models\Settings::where('key', 'site_setting')->first();
@endphp

<footer class="global-footer">
    <div class="container">

        <div class="global-footer__container">
            <div class="global-footer-company-links">
                <ul class="global-footer-company-links__list">
                    <li class="global-footer-company-links__list-item">
                        <a class="global-footer__text-link -opacity-full" href="{{route('terms-and-condition')}}">Terms of Service</a>
                    </li>
                    <li class="global-footer-company-links__list-item">
                        <a class="global-footer__text-link -opacity-full" href="{{route('privacy-policy')}}">Privacy Policy</a>
                    </li>
                    <li class="global-footer-company-links__list-item">
                        <a class="global-footer__text-link -opacity-full" href="{{route('contact-us')}}">Contact</a>
                    </li>
                </ul>
                <small class="global-footer-company-links__copyright">
                    © 2025 Market Place Pty Ltd. Trademarks and brands are the property of their respective owners.
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