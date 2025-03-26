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


<footer class="footer-04">
    <div class="container">
        <div class="row">
            {{-- <div class="col-md-6 col-lg-3 mb-md-0 mb-4">
                <h2 class="footer-heading"><a href="#" class="logo">Colorlib</a></h2>
                <p>A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
                <a href="#">read more <span class="ion-ios-arrow-round-forward"></span></a>
            </div> --}}
            <div class="col-md-5 col-lg-3 mb-md-0 mb-4 padding-left">
                <h2 class="footer-heading">Quick Links</h2>
                <ul class="list-unstyled">
                    @if ($category)
                        <li><a class="py-1 d-block" href="{{ route('product.list', ['categoryOrSubcategory' => $category->id]) }}">Products</a></li>
                    @elseif ($subcategory)
                        <li><a class="py-1 d-block" href="{{ route('product.list', ['categoryOrSubcategory' => $subcategory->id]) }}">Products</a></li>
                    @endif
                    <li><a class="py-1 d-block" href="{{ route('user-faq') }}">FAQ</a></li> 
                    <li><a class="py-1 d-block" href="{{ route('contact-us') }}">Contact</a></li>
                    <li><a class="py-1 d-block" href="{{ route('wishlist.index') }}">Wishlist</a></li>
                </ul>
            </div>
            <div class="col-md-6 col-lg-4 mb-md-0 mb-4">
                <h2 class="footer-heading">Contact</h2>
                <ul class="list-unstyled">
                    <li>  <p> B-Shop No. 4,</p><p>Shiv Shakti Luxuria,</p><p>Near Ocean Park 1,</p> <p> Bhagwati Circle,</p> <p> Kaliyabid, </p> <p>Bhavnagar - 364002,</p><p>Gujarat India</p></li>
                </ul>
            </div>

            {{-- <div class="col-md-6 col-lg-3 mb-md-0 mb-4">
                <h2 class="footer-heading">Tag cloud</h2>
                <div class="tagcloud">
                    <a href="#" class="tag-cloud-link">dish</a>
                    <a href="#" class="tag-cloud-link">menu</a>
                    <a href="#" class="tag-cloud-link">food</a>
                    <a href="#" class="tag-cloud-link">sweet</a>
                    <a href="#" class="tag-cloud-link">tasty</a>
                    <a href="#" class="tag-cloud-link">delicious</a>
                    <a href="#" class="tag-cloud-link">desserts</a>
                    <a href="#" class="tag-cloud-link">drinks</a>
                </div>
            </div> --}}
            <div class="col-md-6 col-lg-4 mb-md-0 mb-4 padding-left">
                <h2 class="footer-heading">Subcribe</h2>
                <div class="subscribe-form">
                    <div class="form-group d_flex">
                        <input type="email" class="form-control rounded-left" value="" name="email" placeholder="Enter your email">
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
        <div class="container">
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
</footer>
