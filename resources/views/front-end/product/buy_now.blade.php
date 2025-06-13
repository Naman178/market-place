@extends('front-end.common.master')@section('meta')
@section('styles')
    <link rel="stylesheet" href="{{ asset('front-end/css/home-page.css') }}">
    <link rel="stylesheet" href="{{ asset('front-end/css/checkout.css') }}">
    <!-- Slick Slider CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick-theme.css"/>
@endsection
@php
    use App\Models\SEO;
    use App\Models\Settings;

    $seoData = SEO::where('page', 'buy now')->first();
    $site = Settings::where('key', 'site_setting')->first();

    $logoImage = $site['value']['logo_image'] ?? null;
    $ogImage = $logoImage
        ? asset('storage/Logo_Settings/' . $logoImage)
        : asset('front-end/images/infiniylogo.png');
@endphp

@section('title'){{ $seoData->title ?? 'Buy Now' }}@endsection

@section('meta')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- SEO Meta --}}
    <meta name="description" content="{{ $seoData->description ?? 'Purchase your products now with Market Place. Enjoy fast and secure checkout with amazing deals.' }}">
    <meta name="keywords" content="{{ $seoData->keywords ?? 'buy now, quick checkout, Market Place products' }}">

    {{-- Open Graph Meta --}}
    <meta property="og:title" content="{{ $seoData->title ?? 'Buy Now - Market Place' }}">
    <meta property="og:description" content="{{ $seoData->description ?? 'Secure and instant product purchase experience on Market Place.' }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:image" content="{{ $ogImage }}">

    {{-- Twitter Meta --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seoData->title ?? 'Buy Now - Market Place' }}">
    <meta name="twitter:description" content="{{ $seoData->description ?? 'Secure and instant product purchase experience on Market Place.' }}">
    <meta name="twitter:image" content="{{ $ogImage }}">

    @if ($site && $site['value']['logo_image'])
        <meta property="og:logo" content="{{ asset('storage/Logo_Settings/'.$site['value']['logo_image']) }}" />
    @else
        <meta property="og:logo" content="{{ asset('front-end/images/infiniylogo.png') }}" />
    @endif
@endsection
@section('content')
@php
    use App\Models\Category;
    use App\Models\SubCategory;
    use App\Models\User;
    // $category = Category::where('sys_state','=','0')->first();
    // $subcategory = SubCategory::where('sys_state','=','0')->first();
    $category = Category::where('id', $item->categorySubcategory->category_id)->first();
    $subcategory = SubCategory::where('id', $item->categorySubcategory->subcategory_id)->first();
    $user = User::where('email', 'superadmin@gmail.com')->first();
@endphp
<div class="container items-container product_details">
    <nav class="breadcrumbs h-text-truncate d-flex align-items-center">
        <a class="js-breadcrumb-category" href="/">Home</a>
        <svg class="mx-1" xmlns="http://www.w3.org/2000/svg" width="6" height="10" viewBox="0 0 6 10" fill="none">
            <path d="M1 9L5 5L1 1" stroke="#bababa" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>

        <a class="js-breadcrumb-category" href="/">Category</a>
        <svg class="mx-1" xmlns="http://www.w3.org/2000/svg" width="6" height="10" viewBox="0 0 6 10" fill="none">
            <path d="M1 9L5 5L1 1" stroke="#bababa" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>

        <a class="js-breadcrumb-category" href="{{ route('category_details', $category->slug) }}">{{ $category->name }}</a>
        <svg class="mx-1" xmlns="http://www.w3.org/2000/svg" width="6" height="10" viewBox="0 0 6 10" fill="none">
            <path d="M1 9L5 5L1 1" stroke="#bababa" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>

        <a class="js-breadcrumb-category" href="{{ route('product.list', ['category' => $category->slug, 'slug' => $subcategory->slug]) }}">
            {{ $subcategory->name }}
        </a>
    </nav>

    <h1 class="mt-3 mb-3">{{ $item->name }}</h1>
    <div class="item-header__details-section d-flex">
        <div class="item-header__author-details">
            By <a rel="author" class="cursor-auto">{{ $user->name }}</a>
        </div>
        <div class="item-header__sales-count">
            <svg width="16px" height="16px" viewBox="0 0 16 16" class="item-header__sales-count-icon"
                xmlns="http://www.w3.org/2000/svg" aria-labelledby="title" role="img">
                <title>Cart</title>
                <path
                    d="M 0.009 1.349 C 0.009 1.753 0.347 2.086 0.765 2.086 C 0.765 2.086 0.766 2.086 0.767 2.086 L 0.767 2.09 L 2.289 2.09 L 5.029 7.698 L 4.001 9.507 C 3.88 9.714 3.812 9.958 3.812 10.217 C 3.812 11.028 4.496 11.694 5.335 11.694 L 14.469 11.694 L 14.469 11.694 C 14.886 11.693 15.227 11.36 15.227 10.957 C 15.227 10.552 14.886 10.221 14.469 10.219 L 14.469 10.217 L 5.653 10.217 C 5.547 10.217 5.463 10.135 5.463 10.031 L 5.487 9.943 L 6.171 8.738 L 11.842 8.738 C 12.415 8.738 12.917 8.436 13.175 7.978 L 15.901 3.183 C 15.96 3.08 15.991 2.954 15.991 2.828 C 15.991 2.422 15.65 2.09 15.23 2.09 L 3.972 2.09 L 3.481 1.077 L 3.466 1.043 C 3.343 0.79 3.084 0.612 2.778 0.612 C 2.777 0.612 0.765 0.612 0.765 0.612 C 0.347 0.612 0.009 0.943 0.009 1.349 Z M 3.819 13.911 C 3.819 14.724 4.496 15.389 5.335 15.389 C 6.171 15.389 6.857 14.724 6.857 13.911 C 6.857 13.097 6.171 12.434 5.335 12.434 C 4.496 12.434 3.819 13.097 3.819 13.911 Z M 11.431 13.911 C 11.431 14.724 12.11 15.389 12.946 15.389 C 13.784 15.389 14.469 14.724 14.469 13.911 C 14.469 13.097 13.784 12.434 12.946 12.434 C 12.11 12.434 11.431 13.097 11.431 13.911 Z">
                </path>

            </svg>

            <strong> {{ $item->order->count() ?? 0 }}</strong> sales
        </div>
        <div class="item-header__envato-highlighted d-flex align-items-center">
            <strong>Well Documented</strong>
            <svg width="16px" height="16px" viewBox="0 0 14 14" class="item-header__envato-checkmark-icon ml-2"
                xmlns="http://www.w3.org/2000/svg" aria-labelledby="title" role="img">
                <title></title>
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M0.333252 7.00004C0.333252 3.31814 3.31802 0.333374 6.99992 0.333374C8.76803 0.333374 10.4637 1.03575 11.714 2.286C12.9642 3.53624 13.6666 5.23193 13.6666 7.00004C13.6666 10.6819 10.6818 13.6667 6.99992 13.6667C3.31802 13.6667 0.333252 10.6819 0.333252 7.00004ZM6.15326 9.23337L9.89993 5.48671C10.0227 5.35794 10.0227 5.15547 9.89993 5.02671L9.54659 4.67337C9.41698 4.54633 9.20954 4.54633 9.07993 4.67337L5.91993 7.83337L4.91993 6.84004C4.85944 6.77559 4.77498 6.73903 4.68659 6.73903C4.5982 6.73903 4.51375 6.77559 4.45326 6.84004L4.09993 7.19337C4.03682 7.25596 4.00133 7.34116 4.00133 7.43004C4.00133 7.51892 4.03682 7.60412 4.09993 7.66671L5.68659 9.23337C5.74708 9.29782 5.83154 9.33439 5.91993 9.33439C6.00832 9.33439 6.09277 9.29782 6.15326 9.23337Z"
                    fill="#79B530"></path>

            </svg>

        </div>
    </div>
    <div class="row cust-page-padding">
        <div class="col-xl-8 col-lg-12 col-md-12">
          <div class="wsus__product_details_img position-relative">
                <img src="{{ asset('public/storage/items_files/' . $item->thumbnail_image) }}"
                    alt="product" class="img-fluid w-100 h-100">
                
                <button class="wishlist-btn" id="wishlistBtn-{{ $item->id }}" onclick="addWishlist({{ $item->id }})">
                    <i id="wishlistIcon-{{ $item->id }}" class="far fa-heart" aria-hidden="true"></i>
                </button>
            </div>
            @if ($item->pricing['pricing_type'] === 'one-time')
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

                    {{-- <li class="nav-item" role="presentation">
                        <button id="wishlistBtn-{{ $item->id }}" onclick="addWishlist({{ $item->id }})"><i id="wishlistIcon-{{ $item->id }}" class="far fa-heart" aria-hidden="true"></i>
                            Wishlist</button>
                    </li> --}}

                </ul>
                {{-- <div class="tab-content" id="pills-tabContent"> --}}
                    <div class="tab-content active" id="pills-home">
                        <div class="wsus__pro_description">
                            {!! $item->html_description !!}
                            @if(isset($item->images))
                                <div class="wsus__pro_det_img">
                                    <div class="row">
                                        @foreach ($item->images as $image)
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-3">
                                                <img src="{{ asset('public/storage/items_files/' . $image->image_path) }}" alt="product" class="img-fluid w-100 h-100">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="tab-content" id="pills-profile">
                        <div class="wsus__pro_det_comment">
                            <h3>Comments</h3>
                        </div>
                        <div class="wsus__pagination">
                        </div>
                        
                        <livewire:comments :model="$post" :itemId="$item->id" />
                        {{-- <form class="wsus__comment_input_area" id="productCommentForm" method="POST"  action="{{ route('product-comment-post') }}">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id ?? 0 }}">
                            <input type="hidden" name="item_id" value="{{ $item->id }}">
                            
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="wsus__comment_single_input mt-2">
                                        <fieldset>
                                            <legend>Comment*</legend>
                                            <textarea rows="7" name="comment" placeholder="Type here.." required></textarea>
                                        </fieldset>
                                    </div>
                                    <button type="submit" class="blue_common_btn " id="submitBtn" >
                                        <svg viewBox="0 0 100 100" preserveAspectRatio="none">
                                            <polyline points="99,1 99,99 1,99 1,1 99,1" class="bg-line"></polyline>
                                            <polyline points="99,1 99,99 1,99 1,1 99,1" class="hl-line"></polyline>
                                        </svg>
                                        <span> Submit Comment</span>
                                    </button>
                                    <button class="common_btn pink-blue-grad-button " id="submitBtn" type="submit">Submit Comment</button>
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
                                        <img src="{{ asset('public/assets/images/user.png') }}" class="comment_img rounded-circle" alt="User Image">

                                        <!-- Comment Content -->
                                        <div class="mx-3 w-100">
                                            <h4 class="mb-1 text-primary mt-2">
                                                {{ $comment->user->name ?? 'Anonymous' }}
                                                @if($comment->is_edited) <small class="text-muted">(edited)</small> @endif
                                            </h4>

                                            <!-- Comment Date -->
                                            <span class="text-muted small">{{ $comment->created_at->format('M d, Y h:i A') }}</span>

                                            <!-- Comment Text -->
                                            <p class="mb-0 mt-2 text-secondary comment-text-{{ $comment->id }}">
                                                {{ $comment->description ?? 'No comment provided.' }}
                                                @if ($comment->is_edited)
                                                    <span class="text-muted">(Edited by {{ $comment->user->name }})</span>
                                                @endif
                                            </p>


                                            <!-- Edit Form (Hidden by Default) -->
                                            <textarea class="form-control d-none edit-textarea-{{ $comment->id }}">{{ $comment->description }}</textarea>

                                            <!-- Action Buttons -->
                                            @if(Auth::check() && Auth::id() == $comment->user_id)
                                                <div class="mt-2">
                                                    <button class="blue_common_btn btn-sm btn-outline-primary edit-btn-{{ $comment->id }}" onclick="editComment({{ $comment->id }})">
                                                        Edit
                                                    </button>
                                                    <button class="blue_common_btn btn-sm btn-success save-btn-{{ $comment->id }} d-none" onclick="saveComment({{ $comment->id }})">
                                                        Save
                                                    </button>
                                                    <button class="blue_common_btn btn-sm btn-secondary cancel-btn-{{ $comment->id }} d-none" onclick="cancelEdit({{ $comment->id }})">
                                                        Cancel
                                                    </button>
                                                </div>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div> --}}
                        
                    </div>
                    <div class="tab-content" id="pills-contact">
                        <div class="wsus__pro_det_review d-flex align-items-center">
                            <h3>Reviews</h3> 
                                <!-- Star Rating -->
                                <p id="starRating" class="mb-0 mt-3 ml-2">
                                <i class="fas fa-star s1" data-value="1" onclick="setRating(1)"></i>
                                <i class="fas fa-star s2" data-value="2" onclick="setRating(2)"></i>
                                <i class="fas fa-star s3" data-value="3" onclick="setRating(3)"></i>
                                <i class="fas fa-star s4" data-value="4" onclick="setRating(4)"></i>
                                <i class="fas fa-star s5" data-value="5" onclick="setRating(5)"></i>
                                <span class="total_star" id="ratingValue">(0.0)</span>
                            </p>
                        </div>

                        <div class="wsus__pagination">
                        </div>
                        @if($orderitem)
                        <form class="wsus__comment_input_area" id="productReviewForm" method="POST" action="{{ route('product-review-post') }}">
                            @csrf
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="wsus__comment_single_input mt-3">
                                        <fieldset>
                                            <legend>Review*</legend>
                                            <textarea rows="7" name="review" placeholder="Type here.." required></textarea>
                                            <input type="hidden" name="user_id" value="{{ Auth::user()->id ?? 0 }}">
                                            <input type="hidden" name="item_id" value="{{ $item->id }}">
                                            <input type="hidden" id="ratingInput" name="rating" value="0"> <!-- Store Rating Here -->
                                        </fieldset>
                                    </div>
                                    <button type="submit" class="blue_common_btn " id="reviewSubmitBtn" >
                                        <svg viewBox="0 0 100 100" preserveAspectRatio="none">
                                            <polyline points="99,1 99,99 1,99 1,1 99,1" class="bg-line"></polyline>
                                            <polyline points="99,1 99,99 1,99 1,1 99,1" class="hl-line"></polyline>
                                        </svg>
                                        <span> Submit Review</span>
                                    </button>
                                    {{-- <button class="common_btn pink-blue-grad-button" id="reviewSubmitBtn" type="submit">Submit Review</button> --}}
                                    <button class="common_btn d-none" id="reviewShowSpain" type="submit">
                                        <i class="fas fa-spinner fa-spin" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                        @endif
                        <div class="wsus__pagination">
                            @foreach ($reviews as $review)
                                <div class="wsus__comment_single p-3 border rounded shadow-sm mb-3 bg-white mt-3">
                                    <div class="d-flex align-items-center">
                                        <!-- User Image -->
                                        <img src="{{ asset('public/assets/images/user.png') }}" class="comment_img rounded-circle" alt="User Image">
                                        
                                        <!-- Review Content -->
                                        <div class="ms-3 mx-2">
                                            <h4 class="mb-1 text-primary">{{ $review->user->name ?? 'Anonymous' }}</h4>
                                            
                                            <!-- Star Rating Display -->
                                            <div class="rating">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}" data-star="{{ $i }}"></i>
                                                @endfor
                                                <span class="text-muted ms-2">({{ number_format($review->rating, 1) }})</span>
                                            </div>
                                            
                                            <!-- Review Text -->
                                            <p class="review-text-{{ $review->id }} mb-0 mt-2 text-secondary">
                                                {{ $review->review ?? 'No review provided.' }}
                                                @if ($review->is_edited)
                                                    <span class="text-muted">(Edited by {{ $review->user->name }})</span>
                                                @endif
                                            </p>

                                            
                                            <!-- Edit Textarea (Hidden by default) -->
                                            <textarea class="review-edit-textarea-{{ $review->id }} d-none form-control" rows="3">{{ $review->review ?? '' }}</textarea>

                                            <!-- Edit Rating (Hidden by default) -->
                                            <div class="edit-rating-{{ $review->id }} d-none">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star rating-edit-{{ $review->id }} {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}" data-star="{{ $i }}" onclick="updateRating({{ $review->id }}, {{ $i }})"></i>
                                                @endfor
                                            </div>

                                            <!-- Buttons (Save and Cancel) -->
                                            <div class="mt-2">
                                                <!-- Edit Button -->
                                                @if (Auth::check() && Auth::id() == $review->user_id)
                                                    <button class="blue_common_btn btn-sm btn-outline-primary review-edit-btn-{{ $review->id }}" onclick="editReview({{ $review->id }})">Edit</button>
                                                @endif
                                                <button class="blue_common_btn btn-sm btn-success review-save-btn-{{ $review->id }} d-none" onclick="saveReview({{ $review->id }})">Save</button>
                                                <button class="blue_common_btn btn-sm btn-secondary review-cancel-btn-{{ $review->id }} d-none" onclick="cancelEdit({{ $review->id }})">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                {{-- </div> --}}
            </div>
            @else
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

                    {{-- <li class="nav-item" role="presentation">
                        <button class="nav-link" id="wishlistBtn-{{ $item->id }}" onclick="addWishlist({{ $item->id }})"><i id="wishlistIcon-{{ $item->id }}" class="far fa-heart" aria-hidden="true"></i>
                            Wishlist</button>
                    </li> --}}

                </ul>
                {{-- <div class="tab-content" id="pills-tabContent"> --}}
                    <div class="tab-content active" id="pills-home">
                        <div class="wsus__pro_description">
                           {!! $item->html_description !!}
                             @foreach ($pricingData as $index => $price)
                                @if (isset($images[$price->sub_id]) && $images[$price->sub_id]->isNotEmpty())
                                    <div class="wsus__pro_det_img">
                                        <div class="row">
                                            @if(isset($price->billing_cycle))
                                                <h3 class="col-12 text-capitalize">{{ $price->billing_cycle }}</h3>
                                            @endif
                                            
                                            @foreach ($images[$price->sub_id] as $img)
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                    <img src="{{ asset('public/storage/items_files/' . $img->image_path) }}"
                                                        alt="product"
                                                        class="img-fluid w-100 mr-3">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="tab-content" id="pills-profile">
                        <div class="wsus__pro_det_comment">
                            <h3>Comments</h3>
                        </div>
                        <div class="wsus__pagination">
                        </div>
                        <livewire:comments :model="$post" :itemId="$item->id" />

                        {{-- <form class="wsus__comment_input_area" id="productCommentForm" method="POST"  action="{{ route('product-comment-post') }}">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id ?? 0 }}">
                            <input type="hidden" name="item_id" value="{{ $item->id }}">
                          
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="wsus__comment_single_input mt-2">
                                        <fieldset>
                                            <legend>Comment*</legend>
                                            <textarea rows="7" name="comment" placeholder="Type here.." required></textarea>
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
                                        <img src="{{ asset('public/assets/images/user.png') }}" class="comment_img rounded-circle" alt="User Image">

                                        <!-- Comment Content -->
                                        <div class="mx-3 w-100">
                                            <h4 class="mb-1 text-primary mt-2">
                                                {{ $comment->user->name ?? 'Anonymous' }}
                                                @if($comment->is_edited) <small class="text-muted">(edited)</small> @endif
                                            </h4>

                                            <!-- Comment Date -->
                                            <span class="text-muted small">{{ $comment->created_at->format('M d, Y h:i A') }}</span>

                                            <!-- Comment Text -->
                                            <p class="mb-0 mt-2 text-secondary comment-text-{{ $comment->id }}">
                                                {{ $comment->description ?? 'No comment provided.' }}
                                                @if ($comment->is_edited)
                                                    <span class="text-muted">(Edited by {{ $comment->user->name }})</span>
                                                @endif
                                            </p>


                                            <!-- Edit Form (Hidden by Default) -->
                                            <textarea class="form-control d-none edit-textarea-{{ $comment->id }}">{{ $comment->description }}</textarea>

                                            <!-- Action Buttons -->
                                            @if(Auth::check() && Auth::id() == $comment->user_id)
                                                <div class="mt-2">
                                                    <button class="blue_common_btn btn-sm btn-outline-primary edit-btn-{{ $comment->id }}" onclick="editComment({{ $comment->id }})">
                                                        Edit
                                                    </button>
                                                    <button class="blue_common_btn btn-sm btn-success save-btn-{{ $comment->id }} d-none" onclick="saveComment({{ $comment->id }})">
                                                        Save
                                                    </button>
                                                    <button class="blue_common_btn btn-sm btn-secondary cancel-btn-{{ $comment->id }} d-none" onclick="cancelEdit({{ $comment->id }})">
                                                        Cancel
                                                    </button>
                                                </div>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                         --}}
                    </div>
                    <div class="tab-content" id="pills-contact">
                        <div class="wsus__pro_det_review d-flex align-items-center">
                            <h3>Reviews</h3> 
                              <!-- Star Rating -->
                              <p id="starRating" class="mb-0 mt-3 ml-2">
                                <i class="fas fa-star s1" data-value="1" onclick="setRating(1)"></i>
                                <i class="fas fa-star s2" data-value="2" onclick="setRating(2)"></i>
                                <i class="fas fa-star s3" data-value="3" onclick="setRating(3)"></i>
                                <i class="fas fa-star s4" data-value="4" onclick="setRating(4)"></i>
                                <i class="fas fa-star s5" data-value="5" onclick="setRating(5)"></i>
                                <span class="total_star" id="ratingValue">(0.0)</span>
                            </p>
                        </div>

                        <div class="wsus__pagination">
                        </div>
                        @if($orderitem)
                        <form class="wsus__comment_input_area" id="productReviewForm" method="POST" action="{{ route('product-review-post') }}">
                            @csrf
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="wsus__comment_single_input mt-3">
                                        <fieldset>
                                            <legend>Review*</legend>
                                            <textarea rows="7" name="review" placeholder="Type here.." required></textarea>
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
                        @endif
                        <div class="wsus__pagination">
                            @foreach ($reviews as $review)
                                <div class="wsus__comment_single p-3 border rounded shadow-sm mb-3 bg-white mt-3">
                                    <div class="d-flex align-items-center">
                                        <!-- User Image -->
                                        <img src="{{ asset('public/assets/images/user.png') }}" class="comment_img rounded-circle" alt="User Image">
                                        
                                        <!-- Review Content -->
                                        <div class="ms-3 mx-2">
                                            <h4 class="mb-1 text-primary">{{ $review->user->name ?? 'Anonymous' }}</h4>
                                            
                                          <!-- Star Rating Display (Read-Only) -->
                                            <div class="rating">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                                                @endfor
                                                <span class="text-muted ms-2">({{ number_format($review->rating, 1) }})</span>
                                            </div>
                                            
                                            <!-- Review Text -->
                                            <p class="review-text-{{ $review->id }} mb-0 mt-2 text-secondary">
                                                {{ $review->review ?? 'No review provided.' }}
                                                @if ($review->is_edited)
                                                    <span class="text-muted">(Edited by {{ $review->user->name }})</span>
                                                @endif
                                            </p>

                                            
                                            <!-- Edit Textarea (Hidden by default) -->
                                            <textarea class="review-edit-textarea-{{ $review->id }} d-none form-control" rows="3">{{ $review->review ?? '' }}</textarea>

                                            <!-- Edit Rating (Hidden by default) -->
                                            <div class="edit-rating-{{ $review->id }} d-none">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star rating-edit-{{ $review->id }} {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}" data-star="{{ $i }}" onclick="updateRating({{ $review->id }}, {{ $i }})"></i>
                                                @endfor
                                            </div>

                                            <!-- Buttons (Save and Cancel) -->
                                            <div class="mt-2">
                                                <!-- Edit Button -->
                                                @if (Auth::check() && Auth::id() == $review->user_id)
                                                    <button class="blue_common_btn btn-sm btn-outline-primary review-edit-btn-{{ $review->id }}" onclick="editReview({{ $review->id }})">Edit</button>
                                                @endif
                                                <button class="blue_common_btn btn-sm btn-success review-save-btn-{{ $review->id }} d-none" onclick="saveReview({{ $review->id }})">Save</button>
                                                <button class="blue_common_btn btn-sm btn-secondary review-cancel-btn-{{ $review->id }} d-none" onclick="cancelEdit({{ $review->id }})">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                {{-- </div> --}}
            </div>
            @endif
        </div>
        <div class="col-xl-4 col-lg-12 col-md-12">
            <div class="wsus__sidebar pl_30 xs_pl_0" id="sticky_sidebar">
                @if ($item->pricing['pricing_type'] === 'one-time')
                    <div class="wsus__sidebar_licence">
                        <h2 class="p-0">
                            @if($item->pricing['fixed_price'] != $item->pricing['sale_price']) 
                              <span class="old-price">{{ $item->currency ??  'INR' }}  <strong >{{ $item->pricing['fixed_price'] ?? 0 }}</strong> </span>
                            @endif 
                            
                            <span class="ml-2">{{ $item->currency ??  'INR' }} 
                            <strong class="new-price" id="price">{{ $item->pricing['sale_price'] ?? 0 }}</strong> </span>
                        </h2>
                        @if(count($item->features) > 0)
                            <ul class="p-0 m-0">
                                <li class="txt-white">
                                    <div class="d-flex justify-content-between align-items-center accordion-toggle" 
                                        style="cursor: pointer;" 
                                        data-target="#item-features-{{ $item->id }}">
                                        <div class="d-flex align-items-center">
                                            <i class="fa fa-check mr-2"></i>
                                            {{ $item->features[0]->key_feature ?? '' }}
                                        </div>
                                        <i class="fa fa-chevron-down toggle-icon"></i>
                                    </div>
                                </li>
                            </ul>

                            @if(count($item->features) > 1)
                                <div class="accordion-content" id="item-features-{{ $item->id }}"  style="display: none;">
                                    <ul class="mt-2">
                                        @foreach ($item->features->slice(1) as $feature)
                                            <li class="txt-white mt-2">
                                                <div class="d-flex align-items-center">
                                                    <i class="fa fa-check mr-2"></i>
                                                    {{ $feature->key_feature ?? '' }}
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        @endif

                        <ul class="button_area mt_50 d-flex flex-wrap mb-0">
                            <li><a class="white_signup_btn" target="__blank"
                                    href="{{ $item->preview_url }}">
                                    <svg viewBox="0 0 100 100" preserveAspectRatio="none">
                                        <polyline points="99,1 99,99 1,99 1,1 99,1" class="bg-line"></polyline>
                                        <polyline points="99,1 99,99 1,99 1,1 99,1" class="hl-line"></polyline>
                                    </svg>
                                    <span>  Live Preview </span></a></li>
                            <li><a class="common_btn white_signup_btn" href="{{ route("checkout", ["id" => base64_encode($item->id)]) }}" target="_blank"> <svg viewBox="0 0 100 100" preserveAspectRatio="none">
                                <polyline points="99,1 99,99 1,99 1,1 99,1" class="bg-line"></polyline>
                                <polyline points="99,1 99,99 1,99 1,1 99,1" class="hl-line"></polyline>
                            </svg>
                            <span> add to cart </span></a></li>
                        </ul>
                    </div>
                @else
                    @foreach ($pricingData as $index => $price)
                        <div class="wsus__sidebar_licence {{ $index != 0 ? 'mt_30' : '' }} ml-2">
                            <div class="price-slide">
                                <h2 class="p-0">
                                    @if($price->fixed_price != $price->sale_price) 
                                        <span class="old-price">{{ $item->currency ?? 'INR' }} <strong>{{ $price->fixed_price ?? 0 }}</strong></span>
                                    @endif 
                                    <span class="ml-2">{{ $item->currency ?? 'INR' }} 
                                    <strong class="new-price" id="price">{{ $price->sale_price ?? 0 }}</strong></span>
                                    @if(isset($price->billing_cycle))
                                        <span class="text-capitalize billing_cycle">per {{ $price->billing_cycle }}</span>
                                    @endif
                                </h2>

                                @php
                                    $priceFeatures = $filteredFeatures[$price->sub_id] ?? collect();
                                @endphp

                                @if ($priceFeatures->count() > 0)
                                    {{-- Show first feature --}}
                                    <ul class="p-0 m-0">
                                        <li class="txt-white">
                                            <div class="d-flex justify-content-between align-items-center accordion-toggle" style="cursor: pointer;" data-target="#accordion-{{ $index }}">
                                                <div class="d-flex align-items-center">
                                                    <i class="fa fa-check mr-2"></i>
                                                     {{ $priceFeatures->first()->key_feature ?? 'No features available' }}
                                                </div>
                                                @if ($priceFeatures->count() > 1)
                                                    <i class="fa fa-chevron-down toggle-icon"></i>
                                                @endif
                                            </div>
                                        </li>
                                    </ul>

                                    {{-- Show rest of features --}}
                                    @if ($priceFeatures->count() > 1)
                                        <div class="accordion-content" id="accordion-{{ $index }}" style="display: none;">
                                            <ul class="mt-2">
                                                @foreach ($priceFeatures->slice(1) as $feature)
                                                    <li class="txt-white mt-3">
                                                        <div class="d-flex align-items-center">
                                                            <i class="fa fa-check mr-2"></i>
                                                            {{ $feature->key_feature ?? '' }}
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                @endif


                                <ul class="button_area d-flex flex-wrap mb-0 p-0">
                                    <li><a class="live" target="__blank" href="{{ $item->preview_url }}">Live Preview</a></li>
                                    <li class="ml-1 mt-3">
                                        <a class="common_btn" href="{{ route('checkout', ['id' => base64_encode($item->id), 'pricing_id' => $price->id]) }}" target="_blank">Add to Cart</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @endforeach
                 @endif
                    <div class="wsus__sidebar_pro_info mt_30">
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
                                    @if ($category)
                                        <a href="{{ route('product.list', [
                                            'category' => $category->name ?? null,
                                            'slug' => Str::slug($subcategory['name'] ?? ''),
                                            'tag' => $tag['tag_name'] ?? ''
                                        ]) }}">{{ $tag['tag_name'] ?? '' }}</a>
                                    @elseif ($subcategory)
                                        <a href="{{ route('product.list', [
                                            'category' => $category->name ?? null,
                                            'slug' => Str::slug($subcategory['name'] ?? ''),
                                            'tag' => $tag['tag_name'] ?? ''
                                        ]) }}">{{ $tag['tag_name'] ?? '' }}</a>
                                    @endif
                                @endforeach
                            </p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
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
        console.log("Item ID:", itemId);
        
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
            if (data.redirect) {
                window.location.href = data.redirect;
                return;
            }

            if (data.success) {
                wishlistIcon.classList.toggle("fas");
                wishlistIcon.classList.toggle("far");

                wishlistBtn.innerHTML = `<i id="wishlistIcon-${itemId}" class="${wishlistIcon.classList.contains("fas") ? "fas" : "far"} fa-heart"></i>`;
                toastr.success(data.message);
            } else {
                toastr.error(data.message);
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
    $(document).ready(function() {
        setTimeout(function() { // Ensures DOM is fully loaded before initializing Slick
            var totalSlides = $('.price-slick-slider > div').length; // Count slides

            if (totalSlides > 0) {
                $('.price-slick-slider').slick({
                    slidesToShow: totalSlides >= 2 ? 2 : 1, // If only 1 slide, show 1
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 3000,
                    arrows: true,
                    dots: true,
                    infinite: totalSlides > 1, // Disable infinite scrolling if only 1 slide
                    adaptiveHeight: true,
                    responsive: [
                        {
                            breakpoint: 1024,
                            settings: {
                                slidesToShow: 2,
                                slidesToScroll: 1
                            }
                        },
                        {
                            breakpoint: 600,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1
                            }
                        }
                    ]
                });
            }
        }, 500); // Short delay for DOM readiness
    });

    $('.price-slick-slider').on('init reInit afterChange', function(event, slick) {
        $('.slick-slide').css('width', 'auto'); // Reset incorrect widths
    });
    function editComment(commentId) {
        // Hide the text and show the textarea
        document.querySelector(`.comment-text-${commentId}`).classList.add('d-none');
        document.querySelector(`.edit-textarea-${commentId}`).classList.remove('d-none');

        // Show Save and Cancel buttons, Hide Edit button
        document.querySelector(`.save-btn-${commentId}`).classList.remove('d-none');
        document.querySelector(`.cancel-btn-${commentId}`).classList.remove('d-none');
        document.querySelector(`.edit-btn-${commentId}`).classList.add('d-none');
    }

    function cancelEdit(commentId) {
        // Show the text and hide the textarea
        document.querySelector(`.comment-text-${commentId}`).classList.remove('d-none');
        document.querySelector(`.edit-textarea-${commentId}`).classList.add('d-none');

        // Hide Save and Cancel buttons, Show Edit button
        document.querySelector(`.save-btn-${commentId}`).classList.add('d-none');
        document.querySelector(`.cancel-btn-${commentId}`).classList.add('d-none');
        document.querySelector(`.edit-btn-${commentId}`).classList.remove('d-none');
    }


    function saveComment(commentId) {
        let newText = document.querySelector(`.edit-textarea-${commentId}`).value;
        let editCommentRoute = "{{ route('comments.update', ':id') }}".replace(':id', commentId);
        
        fetch(editCommentRoute, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ description: newText })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update the comment text
                document.querySelector(`.comment-text-${commentId}`).textContent = newText;
                document.querySelector(`.comment-text-${commentId}`).classList.remove('d-none');
                document.querySelector(`.edit-textarea-${commentId}`).classList.add('d-none');

                // Hide Save and Cancel buttons, Show Edit button
                document.querySelector(`.save-btn-${commentId}`).classList.add('d-none');
                document.querySelector(`.cancel-btn-${commentId}`).classList.add('d-none');
                document.querySelector(`.edit-btn-${commentId}`).classList.remove('d-none');

                // Add (edited) tag with username
                let commentTextElement = document.querySelector(`.comment-text-${commentId}`);
                if (!commentTextElement.innerHTML.includes('(edited)')) {
                    let editedTag = document.createElement('span');
                    editedTag.classList.add('text-muted');
                    editedTag.innerHTML = ` (Edited by ${data.username})`; // Show username
                    commentTextElement.appendChild(editedTag);
                }
            }
        })
        .catch(error => console.log("Error updating comment:", error));
    }

// Edit Review
function editReview(reviewId) {
    // Hide the text and show the textarea
    document.querySelector(`.review-text-${reviewId}`).classList.add('d-none');
    document.querySelector(`.review-edit-textarea-${reviewId}`).classList.remove('d-none');
    document.querySelector(`.edit-rating-${reviewId}`).classList.remove('d-none');

    // Show Save and Cancel buttons, Hide Edit button
    document.querySelector(`.review-save-btn-${reviewId}`).classList.remove('d-none');
    document.querySelector(`.review-cancel-btn-${reviewId}`).classList.remove('d-none');
    document.querySelector(`.review-edit-btn-${reviewId}`).classList.add('d-none');

    // Set the current rating visually in the edit stars
    let currentRating = document.querySelectorAll(`.rating-edit-${reviewId}.text-warning`).length;
    updateRating(reviewId, currentRating); // update the stars to the current rating
}

// Update Rating
function updateRating(reviewId, star) {
    let stars = document.querySelectorAll(`.rating-edit-${reviewId}`);
    stars.forEach((starElement, index) => {
        if (index < star) {
            starElement.classList.add('text-warning');
            starElement.classList.remove('text-muted');
        } else {
            starElement.classList.remove('text-warning');
            starElement.classList.add('text-muted');
        }
    });
    // Update the rating on the textarea
    document.querySelector(`.review-edit-textarea-${reviewId}`).setAttribute('data-rating', star);
}

// Save Review
function saveReview(reviewId) {
    let editReviewRoute = "{{ route('reviews.update', ':id') }}".replace(':id', reviewId);
    let newReviewText = document.querySelector(`.review-edit-textarea-${reviewId}`).value;

    let newRating = 0;
    document.querySelectorAll(`.rating-edit-${reviewId}.text-warning`).forEach(star => {
        newRating++;
    });

    fetch(editReviewRoute, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: JSON.stringify({ review: newReviewText, rating: newRating })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update the review text
            document.querySelector(`.review-text-${reviewId}`).innerText = newReviewText;
            document.querySelector(`.edit-rating-${reviewId}`).classList.add('d-none');
            // Conditionally show the edited user name if the review is edited
            let editedTag = document.createElement('span');
            editedTag.classList.add('text-muted');
            editedTag.innerText = `(Edited by ${data.username})`; // Update with the actual user name
            document.querySelector(`.review-text-${reviewId}`).appendChild(editedTag);

            document.querySelector(`.review-text-${reviewId}`).classList.remove('d-none');
            document.querySelector(`.review-edit-textarea-${reviewId}`).classList.add('d-none');

            // Update the star rating display
            updateRatingDisplay(reviewId, newRating);

            // Hide the save and cancel buttons, show the edit button
            document.querySelector(`.review-save-btn-${reviewId}`).classList.add('d-none');
            document.querySelector(`.review-cancel-btn-${reviewId}`).classList.add('d-none');
            document.querySelector(`.review-edit-btn-${reviewId}`).classList.remove('d-none');
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function updateRatingDisplay(reviewId, newRating) {
    // Update the displayed rating stars
    let stars = document.querySelectorAll(`.rating i`);
    stars.forEach((star, index) => {
        if (index < newRating) {
            star.classList.add('text-warning');
            star.classList.remove('text-muted');
        } else {
            star.classList.remove('text-warning');
            star.classList.add('text-muted');
        }
    });

    // Update the rating text
    let ratingText = document.querySelector(`.rating span`);
    if (ratingText) {
        ratingText.innerText = `(${newRating.toFixed(1)})`;
    }
}


// Cancel Edit
function cancelEdit(reviewId) {
    // Revert to the original review text and hide the textarea
    let originalText = document.querySelector(`.review-text-${reviewId}`).innerText;
    document.querySelector(`.review-text-${reviewId}`).classList.remove('d-none');
    document.querySelector(`.review-edit-textarea-${reviewId}`).classList.add('d-none');
    document.querySelector(`.edit-rating-${reviewId}`).classList.add('d-none');

    // Hide Save and Cancel buttons, Show Edit button
    document.querySelector(`.review-save-btn-${reviewId}`).classList.add('d-none');
    document.querySelector(`.review-cancel-btn-${reviewId}`).classList.add('d-none');
    document.querySelector(`.review-edit-btn-${reviewId}`).classList.remove('d-none');
}
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".accordion-toggle").forEach(function(toggle) {
        toggle.addEventListener("click", function() {
            const target = document.querySelector(this.getAttribute("data-target"));
            const icon = this.querySelector('.toggle-icon');

            if (target.style.display === "none" || target.style.display === "") {
                target.style.display = "block"; // Show content
                
                let height = target.scrollHeight + "px";
                target.style.overflow = "hidden"; // Prevent layout shift
                target.animate([{ height: "0px" }, { height: height }], { duration: 400, easing: "ease-out" });

                icon.classList.remove('fa-chevron-down');
                icon.classList.add('fa-chevron-up');
            } else {
                target.animate([{ height: target.scrollHeight + "px" }, { height: "0px" }], { duration: 400, easing: "ease-in" })
                    .onfinish = () => target.style.display = "none"; // Hide after animation

                icon.classList.remove('fa-chevron-up');
                icon.classList.add('fa-chevron-down');
            }
        });
    });
});

</script>   
@endsection
