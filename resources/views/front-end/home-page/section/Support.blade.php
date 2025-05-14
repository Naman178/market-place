<div class="support">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-lg-12 col-sm-12 col-12">
                <div class="integration">
                    <p class="plugin-label">
                        <span class="label-line"></span> 24/7
                    </p>
                    <h1>Continuous Support and Upgrade Seamless <span class="underline"> Performance</span></h1>
                    <p class="integra_p mb-60 mt-3">
                        We believe in delivering long-term value, not just a one-time solution. Our team ensures
                            your products are always up-to-date with the latest features, security patches, and enhancements. <br><br>

                        With Infinity Softech, you’re never alone! We provide continuous support, regular updates, and feature enhancements to keep your products running smoothly and efficiently.


                    </p>
                    <div>
                        <img class="tick_img" src="{{ asset('front-end/images/tick-svgrepo-com 5.png') }}" alt="not found">
                        <span class="ml-2 integra_p"><b>Regular Feature Updates</b> - Stay ahead with new functionalities.</span>
                    </div>
                    <div class="mt-3">
                        <img class="tick_img" src="{{ asset('front-end/images/tick-svgrepo-com 5.png') }}" alt="not found">
                        <span class="ml-2 integra_p"><b>Security Enhancements</b> - Get the latest security patches for a safe experience.</span>
                    </div>
                    <div class="mt-3">
                        <img class="tick_img" src="{{ asset('front-end/images/tick-svgrepo-com 5.png') }}" alt="not found">
                        <span class="ml-2 integra_p"><b> Bug Fixes & Performance Optimizations</b> - Smooth and fast operations.</span>
                    </div>
                    <div class="mt-3">
                        <img class="tick_img" src="{{ asset('front-end/images/tick-svgrepo-com 5.png') }}" alt="not found">
                        <span class="ml-2 integra_p"><b>Customer-Driven Improvements</b> - Your feedback helps shape our updates</span>
                    </div>
                    <div class="mt-3 mb-53">
                        <img class="tick_img" src="{{ asset('front-end/images/tick-svgrepo-com 5.png') }}" alt="not found">
                        <span class="ml-2 integra_p"><b>Dedicated Support Team</b> - Quick resolutions for your queries.</span>
                    </div>
                    
                </div>
                <div class="signup-wrapper">
                    @if (!empty($category))
                    <a href="{{ route('product.list', ['categoryOrSubcategory' => $category->id ?? null]) }}" class="blue_common_btn"> 
                        <svg viewBox="0 0 100 100" preserveAspectRatio="none">
                        <polyline points="99,1 99,99 1,99 1,1 99,1" class="bg-line"></polyline>
                        <polyline points="99,1 99,99 1,99 1,1 99,1" class="hl-line"></polyline>
                    </svg><span>Get Lifetime Support </span>
                    {{-- <span class="ml-1 mr-3">
                                <i class="fa-solid fa-greater-than"></i>
                            </span> --}}
                    </a>
                @elseif (!empty($subcategory))
                    <a href="{{ route('product.list', ['categoryOrSubcategory' => $subcategory->id ?? null]) }}" class="blue_common_btn"> 
                        <svg viewBox="0 0 100 100" preserveAspectRatio="none">
                        <polyline points="99,1 99,99 1,99 1,1 99,1" class="bg-line"></polyline>
                        <polyline points="99,1 99,99 1,99 1,1 99,1" class="hl-line"></polyline>
                        </svg><span>Get Lifetime Support </span></a>
                @endif
                </div>
            </div>
            <div class="col-xl-6 col-lg-12 col-sm-12 col-12">
                <img class="cust_support_img" src="{{ asset('front-end/images/Rectangle 3998.png') }}" alt="not found">
            </div>
            
        </div>
    </div>
    <img class="circle_img text-right" src="{{ asset('front-end/images/Group 1000002962.png') }}" alt="not found">
</div>
