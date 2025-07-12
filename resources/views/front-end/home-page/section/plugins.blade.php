<div class="plugins">
    <div class="container">
        <p class="plugin-label">
            <span class="label-line"></span> Top-Rated by Developers
        </p>

        <div class="wordpress_plugin">
            <h2>
                Featured Collection: Trending Now
            </h2>
        </div>

        <!-- Ensure all cards are inside a single row -->
        <div class="wordpress-plugin-grid">
            @foreach($items as $item)
                <div class="wordpress_plugin_bg h-100">
                    <div class="wordpress_logo">
                        <a  href="{{ route('buynow.list', $item->id) }}">
                            <img src="{{ asset('public/storage/items_files/' . $item->thumbnail_image) }}" alt="not found">
                        </a>
                    </div>
                    <div class="product-box">
                        <a  href="{{ route('buynow.list', $item->id) }}">
                            <h4 class="plugin_h4">{{ $item->name }}</h4>
                        </a>

                        {{-- Render HTML description --}}
                        <div class="plugin_p">{!! $item->html_description !!}</div>

                        {{-- Show price --}}
                        <p class="product_price"
                            data-sale="{{ $item->pricing->sale_price ?? '' }}"
                            data-fixed="{{ $item->pricing->fixed_price ?? '' }}"
                            data-sale-inr="{{ $item->pricing->sales_inr_price ?? '' }}"
                            data-fixed-inr="{{ $item->pricing->fixed_inr_price ?? '' }}">
                            ${{ $item->pricing->sale_price ?? $item->pricing->fixed_price ?? 'N/A' }}
                        </p>

                        <div class="product_summery">
                            <div class="product_rating">
                                <div class="wsus__pro_det_review d-flex align-items-center">
                                    <p class="mb-0 d-flex align-items-center">
                                        <!-- Star Rating Display -->
                                        @php $rating = $item->average_rating; @endphp
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if($rating >= $i)
                                                <i class="fas fa-star" style="color: #f9ae0e; font-size: 14px;"></i>
                                            @elseif($rating >= $i - 0.5)
                                                <i class="fas fa-star-half-alt" style="color: #f9ae0e; font-size: 14px;"></i>
                                            @else
                                                <i class="far fa-star" style="color: #ccc; font-size: 14px;"></i>
                                            @endif
                                        @endfor
                                        <span class="ml-1" style="font-size: 14px;">({{ $item->reviews_count }})</span>
                                    </p>
                                </div>
                                <label>{{ $item->order_count }} Sales</label>
                            </div>
                            <div class="product_btn">
                                <a  href="{{ route('buynow.list', $item->id) }}"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Buy Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center">
            <a  class="white_btn d-inline-block" href="https://market-place-main.infinty-stage.com/shop"><span>All Products</span> <img class="know_arrow" src="https://market-place-main.infinty-stage.com/front-end/images/up-right-arrow-light.png" alt="Button Arrow"></a>
        </div>
        
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const preferredCurrency = localStorage.getItem('preferred_currency') || 'usd';

    document.querySelectorAll('.product_price').forEach(function (priceElement) {
        const sale = priceElement.dataset.sale;
        const fixed = priceElement.dataset.fixed;
        const saleInr = priceElement.dataset.saleInr;
        const fixedInr = priceElement.dataset.fixedInr;

        let displayPrice = 'N/A';

        if (preferredCurrency === 'inr') {
            if (saleInr) {
                displayPrice = `₹${saleInr}`;
            } else if (fixedInr) {
                displayPrice = `₹${fixedInr}`;
            }
        } else {
            if (sale) {
                displayPrice = `$${sale}`;
            } else if (fixed) {
                displayPrice = `$${fixed}`;
            }
        }

        priceElement.textContent = displayPrice;
    });
});
</script>

