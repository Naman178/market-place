@extends('front-end.common.master')@section('meta')
@section('styles')
    <link rel="stylesheet" href="{{ asset('front-end/css/home-page.css') }}">
    <link rel="stylesheet" href="{{ asset('front-end/css/checkout.css') }}">
    <!-- Slick Slider CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick-theme.css"/>
@endsection
@section('meta')
    <title>Market Place | {{ $seoData->title ?? 'Default Title' }} - {{ $seoData->description ?? 'Default Description' }}
    </title>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $seoData->description ?? 'Default description' }}">
    <meta name="keywords" content="{{ $seoData->keywords ?? 'default, keywords' }}">
    <meta property="og:title" content="{{ $seoData->title ?? 'Default Title' }}">
    <meta property="og:description" content="{{ $seoData->description ?? 'Default description' }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
@endsection
@section('content')
<div class="container items-container product_details">
    <div class="row cust-page-padding">
        <div class="col-xl-8 col-lg-7">
            <div class="wsus__product_details_img">
                <img  src="{{ asset('public/storage/items_files/' . $item->thumbnail_image) }}"
                    alt="product" class="img-fluod w-100">
            </div>

            <div class="wsus__product_details_text">
                <ul class="nav" id="pills-tab">
                    <li class="nav-item">
                        <button class="nav-link active" id="pills-home-tab" data-target="pills-home">
                            <i class="fa fa-layer-group"></i> Description
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" id="pills-profile-tab" data-target="pills-profile">
                            <i class="fa fa-comments"></i> Comments ({{ $userCommentsCount ?? 0 }})
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" id="pills-contact-tab" data-target="pills-contact">
                            <i class="fa fa-star"></i> Review ({{ $userReviewsCount ?? 0 }})
                        </button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button id="wishlistBtn-{{ $item->id }}" onclick="addWishlist({{ $item->id }})"><i id="wishlistIcon-{{ $item->id }}" class="far fa-heart" aria-hidden="true"></i>
                            Wishlist</button>
                    </li>

                </ul>
                {{-- <div class="tab-content" id="pills-tabContent"> --}}
                    <div class="tab-content active" id="pills-home">
                        <div class="wsus__pro_description">
                           {!! $item->html_description !!}
                        </div>
                    </div>
                    <div class="tab-content" id="pills-profile">
                        <div class="wsus__pro_det_comment">
                            <h4>Comments</h4>
                        </div>
                        <div class="wsus__pagination">
                        </div>
                        <form class="wsus__comment_input_area" id="productCommentForm" method="POST"  action="{{ route('product-comment-post') }}">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id ?? 0 }}">
                            <input type="hidden" name="item_id" value="{{ $item->id }}">
                            <h3>Leave a Comment</h3>
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="wsus__comment_single_input">
                                        <fieldset>
                                            <legend>Comment*</legend>
                                            <textarea rows="7" name="comment" placeholder="Type here.."></textarea>
                                        </fieldset>
                                    </div>
                                    <button class="common_btn pink-blue-grad-button" id="submitBtn" type="submit">Submit Comment</button>
                                    <button class="common_btn d-none" id="showSpain" type="submit"><i
                                            class="fas fa-spinner fa-spin" aria-hidden="true"></i></button>
                                </div>
                            </div>
                        </form>
                        <div class="wsus__pagination">
                            @foreach ($comments as $comment)
                                <div class="wsus__comment_single p-3 border rounded shadow-sm mb-3 bg-white mt-3">
                                    <div class="d-flex align-items-start">
                                        <!-- User Image -->
                                        <img src="{{ asset('public/assets/images/user.png') }}" class="comment_img rounded-circle" 
                                            alt="User Image">
                        
                                        <!-- Comment Content -->
                                        <div class="mx-3">
                                            <h4 class="mb-1 text-primary mt-2">{{ $comment->user->name ?? 'Anonymous' }}</h4>
                                            
                                            <!-- Comment Date -->
                                            <span class="text-muted small">{{ $comment->created_at->format('M d, Y h:i A') }}</span>
                        
                                            <!-- Comment Text -->
                                            <p class="mb-0 mt-2 text-secondary">{{ $comment->description ?? 'No comment provided.' }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                    </div>
                    <div class="tab-content" id="pills-contact">
                        <div class="wsus__pro_det_review">
                            <h3>Reviews</h3>
                        </div>

                        <div class="wsus__pagination">
                        </div>

                        <form class="wsus__comment_input_area" id="productReviewForm" method="POST" action="{{ route('product-review-post') }}">
                            @csrf
                            <h3>Write Your Reviews</h3>
                            
                            <!-- Star Rating -->
                            <p id="starRating">
                                <i class="fas fa-star s1" data-value="1" onclick="setRating(1)"></i>
                                <i class="fas fa-star s2" data-value="2" onclick="setRating(2)"></i>
                                <i class="fas fa-star s3" data-value="3" onclick="setRating(3)"></i>
                                <i class="fas fa-star s4" data-value="4" onclick="setRating(4)"></i>
                                <i class="fas fa-star s5" data-value="5" onclick="setRating(5)"></i>
                                <span class="total_star" id="ratingValue">(0.0)</span>
                            </p>
                        
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="wsus__comment_single_input">
                                        <fieldset>
                                            <legend>Comment*</legend>
                                            <textarea rows="7" name="review" placeholder="Type here.."></textarea>
                                            <input type="hidden" name="user_id" value="{{ Auth::user()->id ?? 0 }}">
                                            <input type="hidden" name="item_id" value="{{ $item->id }}">
                                            <input type="hidden" id="ratingInput" name="rating" value="0"> <!-- Store Rating Here -->
                                        </fieldset>
                                    </div>
                        
                                    <button class="common_btn pink-blue-grad-button" id="reviewSubmitBtn" type="submit">Submit Review</button>
                                    <button class="common_btn d-none" id="reviewShowSpain" type="submit">
                                        <i class="fas fa-spinner fa-spin" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                        <div class="wsus__pagination">
                            @foreach ($reviews as $review)
                                <div class="wsus__comment_single p-3 border rounded shadow-sm mb-3 bg-white mt-3">
                                    <div class="d-flex align-items-center">
                                        <!-- User Image -->
                                        <img src="{{ asset('public/assets/images/user.png') }}" class="comment_img rounded-circle" 
                                            alt="User Image">
                        
                                        <!-- Review Content -->
                                        <div class="ms-3 mx-2">
                                            <h4 class="mb-1 text-primary">{{ $review->user->name ?? 'Anonymous' }}</h4>
                                            
                                            <!-- Star Rating Display -->
                                            <div class="rating">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                                                @endfor
                                                <span class="text-muted ms-2">({{ number_format($review->rating, 1) }})</span>
                                            </div>
                        
                                            <!-- Review Text -->
                                            <p class="mb-0 mt-2 text-secondary">{{ $review->review ?? 'No review provided.' }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                {{-- </div> --}}
            </div>
        </div>
        <div class="col-xl-4 col-lg-5">
            <div class="wsus__sidebar pl_30 xs_pl_0" id="sticky_sidebar">
                @if ($item->pricing['pricing_type'] === 'one-time')
                    <div class="wsus__sidebar_licence">
                        <h2>
                            <span>&#8377;</span> <strong id="price">{{ $item->pricing['fixed_price'] ?? 0 }}</strong>
                        </h2>
                        <ul class="button_area mt_50 d-flex flex-wrap mt-3">
                            <li><a class="live" target="__blank"
                                    href="{{ $item->preview_url }}">Live Preview</a></li>
                            <li><a class="common_btn" href="{{ route("checkout", ["id" => base64_encode($item->id)]) }}" target="_blank">add to cart</a></li>
                        </ul>
                        <ul class="sell_rating mt_20 d-flex flex-wrap justify-content-between">
                            <li><i class="far fa-comments" aria-hidden="true"></i> {{ $userCommentsCount ?? 0 }}</li>
                            <li><i class="far fa-star" aria-hidden="true"></i> {{ $userReviewsCount ?? 0 }}</li>
                        </ul>
                    </div>
                @endif
                @if ($item->pricing['pricing_type'] == 'one-time')
                    <div class="wsus__sidebar_pro_info mt_30">
                @else
                    <div class="wsus__sidebar_pro_info ">
                @endif
                    <h3>product Info</h3>
                    <ul class="p-0">
                        <li><span>Released</span> {{ $item->created_at->format('M d, Y') }}</li>
                        <li><span>Updated</span> {{ $item->updated_at->format('M d, Y') }}</li>
                        <li><span>File Type</span> Zip</li>
                        <li><span>High Resolution</span> Yes</li>
                        <li><span>Cross browser</span> Yes</li>
                        <li><span>Documentation</span> Yes</li>
                        <li><span>Responsive</span> Yes</li>
                        <li><span>Tags</span>
                            <p>
                                @foreach ($item->tags as $tag)
                                    <a>{{ $tag['tag_name']   ?? '' }},</a>
                                @endforeach
                            </p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-start bg-white">
        @if ($item->pricing['pricing_type'] === 'recurring')
            <div class="price-slick-slider">
                @foreach ($pricingData as $index => $price)
                    <div class="slick-slide">
                        <div class="wsus__sidebar_licence mr-2 ml-2">
                            <div class="price-slide"> <!-- Each slide contains one pricing box -->
                                <h2 class="p-0">
                                    <span>&#8377;</span> <strong id="price">{{ $price->fixed_price ?? 0 }}</strong>
                                </h2>
                                @if (isset($filteredFeatures[$price->sub_id]))
                                    @foreach ($filteredFeatures[$price->sub_id] as $feature)
                                    <ul class="p-0">
                                        <li class="txt-white">
                                            <div class="d-flex align-items-center">
                                                <i class="fa fa-check"></i>
                                                {{ $feature->key_feature ?? '' }}
                                            </div>
                                        </li>
                                    </ul>                                    
                                    @endforeach
                                @endif
                                <ul class="button_area mt_50 d-flex flex-wrap mt-3 p-0">
                                    <li>
                                        <a class="live" target="__blank" href="{{ $item->preview_url }}">Live Preview</a>
                                    </li>
                                    <li class="ml-3">
                                        <a class="common_btn" href="{{ route('checkout', ['id' => base64_encode($item->id)]) }}" target="_blank">Add to Cart</a>
                                    </li>
                                </ul>
                                <ul class="sell_rating mt_20 d-flex flex-wrap justify-content-between">
                                    <li><i class="far fa-comments"></i> {{ $userCommentsCount ?? 0 }}</li>
                                    <li><i class="far fa-star"></i> {{ $userReviewsCount ?? 0 }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="slick-slide">
                <div class="wsus__sidebar_licence mr-2 ml-2">
                    <div class="price-slide"> <!-- Each slide contains one pricing box -->
                        <h2 class="p-0">
                            <span>₹</span> <strong id="price">37999.00</strong>
                        </h2>  
                        <ul class="button_area mt_50 d-flex flex-wrap mt-3 p-0">
                            <li><a class="live" target="__blank" href="https://infinitysoftech.co/">Live Preview</a></li>
                            <li><a class="common_btn" href="http://localhost/market-place/checkout/MQ==" target="_blank">add to cart</a></li>
                        </ul>
                        <ul class="sell_rating mt_20 d-flex flex-wrap justify-content-between">
                            <li><i class="far fa-comments" aria-hidden="true"></i> 1</li>
                            <li><i class="far fa-star" aria-hidden="true"></i> 2</li>
                        </ul>
                    </div>
                </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
@section('scripts')

<!-- jQuery (Required for Slick) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Slick Slider JS -->
<script src="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let tabs = document.querySelectorAll(".nav-link");
        let contents = document.querySelectorAll(".tab-content");
    
        tabs.forEach(tab => {
            tab.addEventListener("click", function () {
                let targetId = this.getAttribute("data-target");
    
                // Remove active class from all tabs and contents
                tabs.forEach(t => t.classList.remove("active"));
                contents.forEach(c => c.classList.remove("active"));
    
                // Add active class to the clicked tab and the corresponding content
                this.classList.add("active");
                document.getElementById(targetId).classList.add("active");
            });
        });
    });
    function setRating(rating) {
        // Update hidden input value
        document.getElementById("ratingInput").value = rating;
        
        // Update displayed rating count
        document.getElementById("ratingValue").textContent = `(${rating}.0)`;

        // Reset all stars to default (gray)
        document.querySelectorAll("#starRating i").forEach(star => {
            star.style.color = "#ccc"; // Reset color
        });

        // Highlight clicked stars
        for (let i = 1; i <= rating; i++) {
            document.querySelector(`.s${i}`).style.color = "gold"; // Set selected stars to yellow
        }
    }
    const addToWishlistRoute = "{{ route('wishlist.add') }}";

    function addWishlist(itemId) {
        // Find the button and icon elements using the itemId
        let wishlistBtn = document.getElementById(`wishlistBtn-${itemId}`);
        let wishlistIcon = document.getElementById(`wishlistIcon-${itemId}`);
        
        // Check if both elements exist before trying to manipulate them
        if (!wishlistBtn || !wishlistIcon) {
            console.error("Wishlist button or icon not found for itemId:", itemId);
            return; // Exit if the elements are not found
        }

        fetch(addToWishlistRoute, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ item_id: itemId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Toggle the heart icon classes
                wishlistIcon.classList.toggle("fas"); // Filled heart
                wishlistIcon.classList.toggle("far"); // Empty heart

                // Update the button text with the message
                wishlistBtn.innerHTML = `<i id="wishlistIcon-${itemId}" class="${wishlistIcon.classList.contains("fas") ? "fas" : "far"} fa-heart"></i> ${data.message}`;
            } else {
                alert("Failed to add to wishlist. Try again!");
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alert("An error occurred while processing your request.");
        });
    }
    const getWishlistRoute = "{{ route('get_wishlist') }}";
    document.addEventListener('DOMContentLoaded', function () {
        fetch(getWishlistRoute) 
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                let wishlistItems = data.wishlistItems;

                wishlistItems.forEach(itemId => {
                    let wishlistIcon = document.getElementById(`wishlistIcon-${itemId}`);
                    if (wishlistIcon) {
                        wishlistIcon.classList.remove('far');  
                        wishlistIcon.classList.add('fas'); 
                    }
                });
            }
        })
        .catch(error => {
            console.error("Error fetching wishlist:", error);
        });
    });
    $(document).ready(function(){
        // Initialize slick slider after the DOM is ready
        var totalSlides = $('.price-slide').length;

        // Initialize slick only if there are at least one slide
        if(totalSlides > 0) {
            $('.price-slick-slider').slick({
                slidesToShow: 3, // Show three slides at a time
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 3000, // Slide changes every 3 seconds
                arrows: true, // Enable navigation arrows
                dots: true, // Enable navigation dots
                infinite: true, // Loop slides
                adaptiveHeight: true, // Adjust height dynamically
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 2, // Show 2 slides on medium screens
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 1, // Show 1 slide on smaller screens
                            slidesToScroll: 1
                        }
                    }
                ]
            });
        }
    });

</script>   
@endsection
