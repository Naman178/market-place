<div class="plugins">
    {{-- <img class="frame_img" src="{{ asset('front-end/images/Frame.png') }}" alt="not found"> --}}
    <div class="container">
        <p class="plugin-label">
            <span class="label-line"></span> Plugins
        </p>

        <div class="wordpress_plugin">
            <h2>
                Powerful <span>Features</span> <br>
                to Elevate Your <span class="underline">Store</span>
            </h2>
        </div>

        <!-- Ensure all cards are inside a single row -->
        {{-- <div class="row row_gap"> --}}
        <div class="wordpress-plugin-grid">
           
                <div class="wordpress_plugin_bg h-100">
                     <div class="wordpress_logo">
                    <img  src="{{ asset('front-end/images/store.png') }}" alt="not found">
                     </div>
                    <h4 class="plugin_h4 mt-20">Live Gold Price Updates</h4>
                    <p class="plugin_p ">Automatically fetch real-time gold, silver, and platinum prices to ensure accurate and <br> up-to-date pricing for your WooCommerce store</p>
                
                    @if (!empty($subcategory))
                        <a href="{{ route('product.list.show', ['subcategory' => Str::slug($subcategory->name ?? '')]) }}" class="know_more >Explore Products <span><img src="{{ asset('front-end/images/arrow.png') }}" alt="not found"></span></a>
                    @endif
                    {{-- <a href="#" class="know_more ml-40">Explore Products <span><img src="{{ asset('front-end/images/arrow.png') }}" alt="not found"></span></a> --}}
                </div>
           
           
                <div class="wordpress_plugin_bg h-100">
                     <div class="wordpress_logo">
                    <img  src="{{ asset('front-end/images/cart.png') }}" alt="not found">
                     </div>
                    <h4 class="plugin_h4 mt-20">Seamless WooCommerce Integration</h4>
                    <p class="plugin_p ">Fully compatible with WooCommerce, supporting both simple and variable products for effortless price automation.</p>
                   
                    @if (!empty($subcategory))
                    <a href="{{ route('product.list.show', ['subcategory' => Str::slug($subcategory->name ?? '')]) }}" class="know_more ml-40">Explore Prodspan><img src="{{ asset('front-end/images/arrow.png') }}" alt="not found"></span></a>
                    @endif
                </div>
           

           
                <div class="wordpress_plugin_bg h-100">
                     <div class="wordpress_logo">
                    <img  src="{{ asset('front-end/images/plug.png') }}" alt="not found">
                     </div>
                    <h4 class="plugin_h4 mt-20">Seamless Integration</h4>
                    <p class="plugin_p ">Easily integrate our plugin into your WordPress website with a hassle-free setup process and user-friendly controls.</p>
                    @if (!empty($subcategory))
                        <a href="{{ route('product.list.show', ['subcategory' => Str::slug($subcategory->name ?? '')]) }}" class="know_more">Explore Products <span><img src="{{ asset('front-end/images/arrow.png') }}" alt="not found"></span></a>
                    @endif
                </div>
           

           
                <div class="wordpress_plugin_bg h-100">
                     <div class="wordpress_logo">
                    <img  src="{{ asset('front-end/images/dependable.png') }}" alt="not found">
                     </div>
                    <h4 class="plugin_h4 mt-20">Smart Pricing Automation</h4>
                    <p class="plugin_p ">No more manual updates! Our plugin calculates prices dynamically based on global rates and product weight.</p>
                   
                    @if (!empty($subcategory))
                        <a href="{{ route('product.list.show', ['subcategory' => Str::slug($subcategory->name ?? '')]) }}" class="know_more">Explore Products <span><img src="{{ asset('front-end/images/arrow.png') }}" alt="not found"></span></a>
                    @endif
                </div>
           

           
                <div class="wordpress_plugin_bg h-100">
                     <div class="wordpress_logo">
                    <img  src="{{ asset('front-end/images/money-management.png') }}" alt="not found">
                     </div>
                    <h4 class="plugin_h4 mt-20">Quick & Hassle-Free Setup</h4>
                    <p class="plugin_p ">Install, configure, and start selling in minutes with a user-friendly interface and easy customization options.</p>
                    @if(!empty($subcategory))
                        <a href="{{ route('product.list.show', ['subcategory' => Str::slug($subcategory->name ?? '')]) }}" class="know_more">Explore Products <span><img src="{{ asset('front-end/images/arrow.png') }}" alt="not found"></span></a>
                    @endif
                </div>
           

           
                <div class="wordpress_plugin_bg h-100">
                     <div class="wordpress_logo">
                    <img  src="{{ asset('front-end/images/customer-support.png') }}" alt="not found">
                     </div>
                    <h4 class="plugin_h4 mt-20">Secure & Optimized Performance</h4>
                    <p class="plugin_p ">Built for speed, security, and reliability—ensuring smooth transactions and a seamless user experience.</p>
                    @if (!empty($subcategory))
                        <a href="{{ route('product.list.show', ['subcategory' => Str::slug($subcategory->name ?? '')]) }}" class="know_more">Explore Products <span><img src="{{ asset('front-end/images/arrow.png') }}" alt="not found"></span></a>
                    @endif
                </div>
           
        </div>
    </div>
</div>
