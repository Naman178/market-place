<div class="features infinity_softech">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-lg-12 col-sm-12 col-12">
                <img class="support_img" src="{{ asset('front-end/images/Group 5.png') }}" alt="not found">
                <img class="rates_img" src="{{ asset('front-end/images/Group 6.png') }}" alt="not found">
                <img class="feature_img" src="{{ asset('front-end/images/Metalprice-Some-feature-PSD-File 2.png') }}" alt="not found">
            </div>
            <div class="col-xl-6 col-lg-12 col-sm-12 col-12">
                {{-- <img class="mt-65" src="{{ asset('front-end/images/Group 1000002956.png') }}" alt="not found"> --}}
                 <p class="plugin-label">
                    <span class="label-line"></span> Features
                 </p>
                <div class="integration">
                    <h2>Why Choose <span class="underline">Infinity Softech?</span></h2>
                    {{-- <img class="vector2_img" src="{{ asset('front-end/images/Vector 4.png') }}" alt="not found"> --}}
                    <p class="integra_p mb-60 mt-3">
                        At Infinity Softech, we provide cutting-edge digital solutions that simplify your business processes, enhance efficiency, and drive success. Our expertise in web and mobile development ensures you get the best tools for your needs.
                    </p>
                    <div>
                        <img class="tick_img" src="{{ asset('front-end/images/tick-svgrepo-com 5.png') }}" alt="not found">
                        <span class="ml-2 integra_p"><b>Reliable & Scalable Solutions</b> - High-performance software tailored to your business needs.</span>
                    </div>
                    <div class="mt-3">
                        <img class="tick_img" src="{{ asset('front-end/images/tick-svgrepo-com 5.png') }}" alt="not found">
                        <span class="ml-2 integra_p"><b>Easy Integration</b> - Compatible with major platforms, making setup hassle-free.</span>
                    </div>
                    <div class="mt-3">
                        <img class="tick_img" src="{{ asset('front-end/images/tick-svgrepo-com 5.png') }}" alt="not found">
                        <span class="ml-2 integra_p"><b>Regular Updates & Support</b> - Stay ahead with frequent updates and expert assistance.</span>
                    </div>
                    <div class="mt-3">
                        <img class="tick_img" src="{{ asset('front-end/images/tick-svgrepo-com 5.png') }}" alt="not found">
                        <span class="ml-2 integra_p"><b>Optimized for Performance</b> - Lightweight, fast, and built for maximum efficiency.</span>
                    </div>
                    <div class="mt-3 mb-53">
                        <img class="tick_img" src="{{ asset('front-end/images/tick-svgrepo-com 5.png') }}" alt="not found">
                        <span class="ml-2 integra_p"><b>Secure & Trustworthy</b> - Industry-standard security to protect your business.</span>
                    </div>
                    <div class="signup-wrapper">
                        @if (!empty($subcategory))
                           <a href="{{ route('product.list.show', ['subcategory' => Str::slug($subcategory->name ?? '')]) }}" class="blue_common_btn"> 
                                <svg viewBox="0 0 100 100" preserveAspectRatio="none">
                                <polyline points="99,1 99,99 1,99 1,1 99,1" class="bg-line"></polyline>
                                <polyline points="99,1 99,99 1,99 1,1 99,1" class="hl-line"></polyline>
                                </svg><span>Explore Our Products </span></a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
