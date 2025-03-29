@php
use App\Models\Category;
use App\Models\SubCategory;
$category = Category::where('sys_state','=','0')->first();
$subcategory = SubCategory::where('sys_state','=','0')->first();
@endphp
 {{-- Real-time Precious Metal Rates and Currency Conversion API start section --}}
 <div class="bg hero_banner">
    <div class="container">
        <div class="real_time_section">
            <div class="d-flex">
                <div class="real_time">
                    <h1>Revolutionize Your Pricing with Automation!</h1>
                    <img class="vector5_img" src="{{ asset('front-end/images/Vector 5.png') }}" alt="not found">
                    <p>Say goodbye to manual price updates! Our  <b>Gold Price Plugin for WordPress</b> automatically calculates real-time gold, silver, and platinum prices for WooCommerce products. Boost efficiency, reduce errors, and ensure accurate pricing—effortlessly.
                    </p>
                    @if (!empty($category))
                    <a class="white_btn mr-20" href="{{ route('product.list', ['categoryOrSubcategory' => $category->id]) }}"><i class="fa fa-eye"></i> <span>Explore Products</span></a>
                    @elseif (!empty($subcategory))
                    <a  class="white_btn mr-20" href="{{ route('product.list', ['categoryOrSubcategory' => $subcategory->id]) }}"><i class="fa fa-eye"></i> <span>Explore Products</span></a>
                    @endif
                    {{-- <a href="" class="white_btn mr-20"><i class="fa fa-eye"></i>
                        <span>Explore Buttons</span></a> --}}
                    {{-- <a href="#" class="setting_btn mr-20"><i class="fab fa-wordpress" aria-hidden="true"></i>
                        <span>Settings Pictures</span></a>
                    <a href="#" class="setting_btn"><i class="fa-solid fa-cart-arrow-down"></i>
                        <span>$100 Buy Now</span></a> --}}
                </div>
                <div>
                    <img class="gold_price_img" src="{{ asset('front-end/images/Group 1000002957.png') }}"
                        alt="not found">
                    <img class="MetalPrice_img"
                        src="{{ asset('front-end/images/hero_banner.png') }}" alt="not found">
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Real-time Precious Metal Rates and Currency Conversion API section end --}}
