@php
use App\Models\Category;
use App\Models\SubCategory;
$category = Category::where('sys_state','=','0')->first();
$subcategory = SubCategory::where('sys_state','=','0')->first();
@endphp
 {{-- Real-time Precious Metal Rates and Currency Conversion API start section --}}
 <div class="bg hero_banner">
    <div class="container">
        <div class="d-flex align-items-center justify-content-center h-800">
            <div class="real_time">
                <h1 class="mt-0 mb-0">Premium Plugins, Themes, and  <span class="white-underline"> Scripts </span></h1>
                {{-- <img class="vector5_img" src="{{ asset('front-end/images/Vector 5.png') }}" alt="not found"> --}}
                <p>Browse our exclusive collection of developer-ready WordPress     plugins, themes, Laravel scripts, React templates, and more — built for performance, security, and scalability.
                </p>
                @if (!empty($subcategory))
                <a  class="white_btn mr-20 d-inline-block" href="{{ route('product.list.show') }}"><i class="fa fa-eye"></i> <span>Explore Products</span></a>
                @endif
                {{-- <a href="" class="white_btn mr-20"><i class="fa fa-eye"></i>
                    <span>Explore Buttons</span></a> --}}
                {{-- <a href="#" class="setting_btn mr-20"><i class="fab fa-wordpress" aria-hidden="true"></i>
                    <span>Settings Pictures</span></a>
                <a href="#" class="setting_btn"><i class="fa-solid fa-cart-arrow-down"></i>
                    <span>$100 Buy Now</span></a> --}}
            </div>
            <div class="banner_wrapper">
                <img class="MetalPrice_img"
                    src="{{ asset('front-end/images/hero_banner.png') }}" alt="not found">
            </div>
        </div>
    </div>
</div>
{{-- Real-time Precious Metal Rates and Currency Conversion API section end --}}
