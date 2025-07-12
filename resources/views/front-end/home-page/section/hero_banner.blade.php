@php
use App\Models\Category;
use App\Models\SubCategory;
$category = Category::where('sys_state','=','0')->first();
$subcategory = SubCategory::where('sys_state','=','0')->first();
@endphp
<div class="bg hero_banner">
    <div class="container">
        <div class="d-flex align-items-center justify-content-center h-800">
            <div class="real_time">
                <label class="badge"><span>Trusted by 1,000+ companies</span></label>
                <h1 class="mt-0 mb-0">Premium Plugins, Themes, and Scripts</h1>
                <p>Browse our exclusive collection of developer-ready WordPress plugins, themes, Laravel scripts, React templates, and more — built for performance, security, and scalability.</p>
                <a  class="white_btn d-inline-block" href="{{ route('product.list.show') }}"><span>Explore Products</span> <img class="know_arrow" src="https://market-place-main.infinty-stage.com/front-end/images/up-right-arrow-light.png" alt="Button Arrow"></a>
            </div>
            <div class="banner_wrapper">
                <img class="MetalPrice_img" src="{{ asset('front-end/images/hero-img.webp') }}" alt="Hero Image">
            </div>
        </div>
    </div>
</div>
