@extends('front-end.common.master')@section('meta')
@section('styles')
    <link rel="stylesheet" href="{{ asset('front-end/css/home-page.css') }}">
    <style>

        .main-content .container {
            max-width: 1375px;
        }

        .items-container .row {
            justify-content: start !important;
        }
        .wsus__product_page_search input, textarea {
            width: 100%;
            padding: 12px 20px;
            outline: none;
            resize: none;
            border: 1px solid #E4E7E9;
            border-radius: 3px;
            font-size: 16px;
            font-weight: 300;
        }
        .wsus__product_page_search form button {
            position: absolute;
            top: -3px;
            right: 6px;
        }
        button{
            cursor: pointer;
        }
        .form-control{
            padding: 13px !important;
            height: calc(2.5em + 0.75rem + 2px);
        }
        .clearFilterButton .blue_common_btn svg {
            left: 0 ;
            width: 100%;
        }
        .underline::after{
            bottom: -45px !important;
        }
        .border-bottom {
            border-bottom: 1px solid #dcdcdc;
            font-weight: 700;
        }
        .category-toggle {
            background: none;
            border: none;
            cursor: pointer;
            padding: 5px;
            display: flex;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .dropdown-icon {
            width: 20px;
            height: 20px;
            display: inline-block;
            align-items: center;
            justify-content: center;    
        }

        .rotated {
            transform: rotate(180deg);
        }
    </style>
@endsection

@php 
    use App\Models\Settings;
    use App\Models\SEO;

    $seoData = SEO::where('page', 'products')->first();

    $site = Settings::where('key', 'site_setting')->first();
    $logoImage = $site['value']['logo_image'] ?? null;
    $ogImage = $logoImage 
        ? asset('storage/Logo_Settings/' . $logoImage) 
        : asset('front-end/images/infiniylogo.png');
@endphp

@section('meta')
@section('title'){{ $seoData->title ?? 'Products' }} @endsection

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

{{-- SEO Meta --}}
<meta name="description" content="{{ $seoData->description ?? 'Explore a wide range of products available on Market Place. Find the best deals and latest items now.' }}">
<meta name="keywords" content="{{ $seoData->keywords ?? 'products, deals, Market Place, shop online' }}">

{{-- Open Graph Meta --}}
<meta property="og:title" content="{{ $seoData->title ?? 'Products - Market Place' }}">
<meta property="og:description" content="{{ $seoData->description ?? 'Explore our product selection and shop online at Market Place.' }}">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:type" content="website">
<meta property="og:image" content="{{ $ogImage }}">

{{-- Twitter Meta --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $seoData->title ?? 'Products - Market Place' }}">
<meta name="twitter:description" content="{{ $seoData->description ?? 'Explore our product selection and shop online at Market Place.' }}">
<meta name="twitter:image" content="{{ $ogImage }}">

@if ($logoImage)
    <meta property="og:logo" content="{{ asset('storage/Logo_Settings/'.$logoImage) }}" />
@else
    <meta property="og:logo" content="{{ asset('front-end/images/infiniylogo.png') }}" />
@endif
@endsection
@section('content')
    <div class="container items-container">

        <div class="title">
            <h3 class="txt-black">Explore Our <span class="color-blue underline">Products</span></h3>
        </div>

        <div class="row">
            <div class="col-xl-12 col-md-12">
                <div class="wsus__product_page_search">
                    <form id="search_form">
                        @foreach ($categories as $category)
                        <input type="search" name="keyword" id="search_keyword" value="" placeholder="Search your products..." data-item-id="{{ $id }}" required>

                        {{-- <input type="search" name="keyword" id="search_keyword" value placeholder="Search your products..."  data-item-id="{{ $category->id }}" oninput="searchItems(this)" required> --}}
                        <button class="blue_common_btn" type="submit"><i class="fa fa-search" aria-hidden="true"></i><svg viewBox="0 0 100 100" preserveAspectRatio="none">
                            <polyline points="99,1 99,99 1,99 1,1 99,1" class="bg-line"></polyline>
                            <polyline points="99,1 99,99 1,99 1,1 99,1" class="hl-line"></polyline>
                        </svg>
                        <span>Search</span></button>
                        @break
                        @endforeach
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-3 col-lg-6 col-md-12 xol-sm-12">
                <div class="wsus__product_sidebar_area mt-3">
                    <div class="wsus__product_sidebar categories mb-3">
                        @foreach ($categories as $category)
                            <select name="sorting" id="sorting" class="form-control select-input mt-3" onchange="applyFilters()">
                                <option value="0">Default Sorting</option>
                                <option value="1">Low to Highest Price</option>
                                <option value="2">Highest to Low Price</option>
                            </select>
                            @break
                        @endforeach  
                        <div class="d-flex justify-content-end clearFilterButton">
                            <button class="blue_common_btn mt-1 mb-1" type="button" onclick="clearFilters()" id="clearFilterButton" style="display:none;">
                                <svg viewBox="0 0 100 100" preserveAspectRatio="none">
                                    <polyline points="99,1 99,99 1,99 1,1 99,1" class="bg-line"></polyline>
                                    <polyline points="99,1 99,99 1,99 1,1 99,1" class="hl-line"></polyline>
                                </svg>
                                <span>Clear Filter</span>
                            </button>
                        </div>
                    </div>
                    <div class="wsus__product_sidebar categories">
                        <h3>Filter By Categories</h3>
                        <div class="category-dropdown mt-4">
                            @foreach ($categories as $category)
                                <div class="category-item">
                                    <div class="border-bottom d-flex align-items-center">
                                    <button class="category-toggle">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                                                stroke-width="2" stroke="currentColor" 
                                                class="dropdown-icon h-4 w-4 mr-2 transition-transform {{ (isset($selectedCategoryId) && $selectedCategoryId == $category->id) ? 'rotated' : '' }}">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path>
                                            </svg>
                                        </button>

                                        <label class="ms-2">
                                            <input 
                                                type="checkbox" 
                                                class="category-checkbox"
                                                data-category-id="{{ $category->id }}"
                                                {{ (isset($selectedCategoryId) && $selectedCategoryId == $category->id) ? 'checked' : '' }}>
                                            {{ $category->name }}
                                        </label>
                                    </div>

                                    {{-- Expand if the selected subcategory belongs here --}}
                                    <div class="subcategory-list mt-2 {{ $selectedCategoryId == $category->id ? 'active' : '' }}" style="margin-left: 38px; display: {{ $selectedCategoryId == $category->id ? 'block' : 'none' }};">
                                        @foreach ($category->subcategories as $subcategory)
                                            <label>
                                                <input 
                                                    type="checkbox" 
                                                    class="subcategory-checkbox"
                                                    data-subcategory-id="{{ $subcategory->id }}"
                                                    {{ (isset($selectedSubcategoryId) && $selectedSubcategoryId == $subcategory->id) ? 'checked' : '' }}>
                                                {{ $subcategory->name }}
                                            </label><br>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                   <div class="wsus__product_sidebar tags">
                        <h3>Tags</h3>
                        <ul class="p-0">
                            @foreach ($tags as $tag)
                                <li>
                                    <input type="checkbox" class="tag-checkbox" id="tag-{{ $tag->id }}" data-tag-name="{{ $tag->tag_name }}">
                                    <label for="tag-{{ $tag->id }}">{{ $tag->tag_name }}</label>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @if ($item->count() != 0)

            <div class="col-xl-9 col-lg-6 col-md-12">
                <div id="items-container" class="row">
                @foreach ($item as $items)
                    <div class="col-xl-4 col-md-12 mt-5">
                        <div class="wordpress_plugin_bg h-100">
                            <div class="wordpress_logo">
                                <a href="{{ route('buynow.list', $items->id) }}">
                                    <img src="{{ asset('public/storage/items_files/' . $items->thumbnail_image) }}" alt="gallery" class="img-fluid w-100 h-100">
                                </a>
                            </div>
                            <div class="product-box">
                                <a href="{{ route('buynow.list', $items->id) }}">
                                    <h4 class="plugin_h4">{{ $items->name }}</h4>
                                </a>
                                <div class="plugin_p">{!! $items->html_description ?? '' !!}</div>
                                <p class="product_price">
                                    <span class="price-usd">${{ $items->pricing['fixed_price'] ?? 0 }}</span>
                                    <span class="price-inr d-none">₹{{ $items->pricing['fixed_inr_price'] ?? 0 }}</span>
                                </p>

                                <div class="product_summery">
                                    <div class="product_rating">
                                        <div class="wsus__pro_det_review d-flex align-items-center">
                                            <p class="mb-0 d-flex align-items-center">
                                                @php
                                                    $rating = round($items->reviews->avg('rating') ?? 0, 1);
                                                    $fullStars = floor($rating);
                                                    $halfStar = ($rating - $fullStars) >= 0.5 ? 1 : 0;
                                                    $emptyStars = 5 - ($fullStars + $halfStar);
                                                @endphp

                                                @for ($i = 0; $i < $fullStars; $i++)
                                                    <i class="fas fa-star text-warning" style="font-size: 14px;"></i>
                                                @endfor

                                                @if ($halfStar)
                                                    <i class="fas fa-star-half-alt text-warning" style="font-size: 14px;"></i>
                                                @endif

                                                @for ($i = 0; $i < $emptyStars; $i++)
                                                    <i class="far fa-star text-warning" style="font-size: 14px;"></i>
                                                @endfor

                                                <span class="ml-1" style="font-size: 14px;">({{ $items->reviews->count() ?? 0 }})</span>
                                            </p>
                                        </div>
                                        <label>{{ $items->order->count() ?? 0 }} Sales</label>
                                    </div>
                                    <div class="product_btn d-flex justify-content-between align-items-center">
                                        <a href="{{ route('buynow.list', $items->id) }}"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Buy Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>

            @else
                <div class="col-xl-9 col-md-12 text-center no-items">
                   <div id="items-container" class="row">
                    <p>No products found.</p>
                </div>
              </div>
            @endif
        </div>
    </div>
@endsection
@section('scripts')

<script>
document.addEventListener("DOMContentLoaded", function () {
    const storedIP = localStorage.getItem('ip_address');
    const storedCountry = localStorage.getItem('country');
    const preferredCurrency = localStorage.getItem('preferred_currency');

    const setINRView = () => {
        document.querySelectorAll('.price-usd').forEach(el => el.classList.add('d-none'));
        document.querySelectorAll('.price-inr').forEach(el => el.classList.remove('d-none'));
    };

    const setUSDView = () => {
        document.querySelectorAll('.price-inr').forEach(el => el.classList.add('d-none'));
        document.querySelectorAll('.price-usd').forEach(el => el.classList.remove('d-none'));
    };
    if (preferredCurrency === 'inr') {
        setINRView();
    } else {
        setUSDView();
    }
});
</script>



<script>
    function sortItems(selectElement) {
        var sortOption = selectElement.value;
        var itemId = selectElement.getAttribute("data-item-id");
        if (itemId) {
            $.ajax({
                type: "GET",
                url: "{{ route('items.sort') }}",
                data: {
                    sort: sortOption,
                    item_id: itemId
                },
                success: function(response) {
                    $("#items-container").empty();
                    if (response.length > 0) {
                        response.forEach(function(item) {
                            $('.no-items').removeClass('no-items');
                            var itemHTML = `
                                <div class="col-xl-4 col-md-12 mt-5">
                                    <div class="wordpress_plugin_bg h-100">
                                        <div class="wordpress_logo">
                                            <a href="/product-details/${item.id}">
                                                <img src="{{ asset('public/storage/items_files/') }}/${item.thumbnail_image}" alt="not found" class="img-fluid w-100 h-100">
                                            </a>
                                        </div>
                                        <div class="product-box">
                                            <a href="/product-details/${item.id}">
                                                <h4 class="plugin_h4">${item.name}</h4>
                                            </a>
                                            <div class="plugin_p">{!! $items->html_description ?? '' !!}</div>

                                            <!-- Optional HTML description -->
                                            <!-- <div class="plugin_p">${item.html_description ?? ''}</div> -->

                                            <p class="product_price">
                                                <span class="price-usd">$${item.pricing ? item.pricing.fixed_price : 0}</span>
                                                <span class="price-inr d-none">₹${item.pricing ? item.pricing.fixed_inr_price : 0}</span>
                                            </p>

                                            <div class="product_summery">
                                                <div class="product_rating">
                                                    <div class="wsus__pro_det_review d-flex align-items-center">
                                                        <p class="mb-0 d-flex align-items-center">
                                                            ${getStarRating(item.reviews)}
                                                            <span class="ml-1" style="font-size: 14px;">(${item.reviews ? item.reviews.length : 0})</span>
                                                        </p>
                                                    </div>
                                                    <label>${item.order_count ?? 0} Sales</label>
                                                </div>
                                                <div class="product_btn d-flex justify-content-between align-items-center">
                                                    <a href="/product-details/${item.id}"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Buy Now</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;


                            // Append the item HTML to the container
                            $("#items-container").append(itemHTML);
                        });
                        if (localStorage.getItem('preferred_currency') === 'inr') {
                            document.querySelectorAll('.price-usd').forEach(el => el.classList.add('d-none'));
                            document.querySelectorAll('.price-inr').forEach(el => el.classList.remove('d-none'));
                        }

                        matchItemHeights();
                        document.getElementById('clearFilterButton').style.display = 'block';
                    } else {
                        $('.no-items').removeClass('no-items');
                        // If no items are found
                        $("#items-container").append(`  <div class="col-xl-12 col-md-12 text-center no-items">
                            <p>No products found</p>
                        </div>`);
                        document.getElementById('clearFilterButton').style.display = 'block';
                    }
                }
            });
        } else {
            alert("Please select a category before sorting.");
        }
    }

    function getStarRating(reviews) {
        reviews = Array.isArray(reviews) ? reviews : [];

        var totalRating = 0;
        var reviewCount = reviews.length;

        reviews.forEach(function(review) {
            totalRating += review.rating ?? 0;
        });

        var rating = reviewCount > 0 ? (totalRating / reviewCount) : 0;
        var roundedRating = Math.round(rating);

        var fullStars = Math.floor(roundedRating);
        var halfStar = (rating - fullStars >= 0.5) ? 1 : 0;
        var emptyStars = 5 - (fullStars + halfStar);

        var stars = '';
        for (var i = 0; i < fullStars; i++) {
            stars += '<i class="fas fa-star text-warning"></i>';
        }
        if (halfStar) {
            stars += '<i class="fas fa-star-half-alt text-warning"></i>';
        }
        for (var i = 0; i < emptyStars; i++) {
            stars += '<i class="far fa-star text-warning"></i>';
        }

        return stars;
    }
    function filterByPrice() {
        let priceRange = document.getElementById('priceRange');
        let price = priceRange.value;
        let itemId = priceRange.getAttribute("data-item-id");
        
        $.ajax({
            type: "GET",
            url: "{{ route('items.sort') }}",
            data: {
                price: price,
                sort: $('#sorting').val(),
                item_id: itemId
            },
            success: function(response) {
                $("#items-container").empty();
                if (response.length > 0) {
                    response.forEach(function(item) {
                        $('.no-items').removeClass('no-items');
                        var itemHTML = `
                                <div class="col-xl-4 col-md-12 mt-5">
                                    <div class="wordpress_plugin_bg h-100">
                                        <div class="wordpress_logo">
                                            <a href="/product-details/${item.id}">
                                                <img src="{{ asset('public/storage/items_files/') }}/${item.thumbnail_image}" alt="not found" class="img-fluid w-100 h-100">
                                            </a>
                                        </div>
                                        <div class="product-box">
                                            <a href="/product-details/${item.id}">
                                                <h4 class="plugin_h4">${item.name}</h4>
                                            </a>
                                            <div class="plugin_p">{!! $items->html_description ?? '' !!}</div>

                                            <!-- Optional HTML description -->
                                            <!-- <div class="plugin_p">${item.html_description ?? ''}</div> -->

                                            <p class="product_price">
                                                <span class="price-usd">$${item.pricing ? item.pricing.fixed_price : 0}</span>
                                                <span class="price-inr d-none">₹${item.pricing ? item.pricing.fixed_inr_price : 0}</span>
                                            </p>

                                            <div class="product_summery">
                                                <div class="product_rating">
                                                    <div class="wsus__pro_det_review d-flex align-items-center">
                                                        <p class="mb-0 d-flex align-items-center">
                                                            ${getStarRating(item.reviews)}
                                                            <span class="ml-1" style="font-size: 14px;">(${item.reviews ? item.reviews.length : 0})</span>
                                                        </p>
                                                    </div>
                                                    <label>${item.order_count ?? 0} Sales</label>
                                                </div>
                                                <div class="product_btn d-flex justify-content-between align-items-center">
                                                    <a href="/product-details/${item.id}"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Buy Now</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;

                        $("#items-container").append(itemHTML);
                    });
                    if (localStorage.getItem('preferred_currency') === 'inr') {
                        document.querySelectorAll('.price-usd').forEach(el => el.classList.add('d-none'));
                        document.querySelectorAll('.price-inr').forEach(el => el.classList.remove('d-none'));
                    }
                    matchItemHeights();
                    document.getElementById('clearFilterButton').style.display = 'block';
                } else {
                    $('.no-items').removeClass('no-items');
                    $("#items-container").append(`  <div class="col-xl-12 col-md-12 text-center no-items">
                            <p>No products found</p>
                        </div>`);
                    document.getElementById('clearFilterButton').style.display = 'block';
                }
            }
        });
    }
    function clearFilters() {
        document.getElementById('search_keyword').value = '';

        const sortingSelects = document.querySelectorAll('.form-control.select-input');
        sortingSelects.forEach(select => {
            select.value = '0'; 
        });

        const priceRange = document.getElementById('priceRange');
        if (priceRange) {
            priceRange.value = 0;
            document.getElementById('priceLabel').innerText = '0';
        }

        const form = document.getElementById('search_form');
        form.submit(); 

        document.getElementById('clearFilterButton').style.display = 'none';
    }

    $('.category-toggle').click(function () {
        let subcategoryList = $(this).closest('.category-item').find('.subcategory-list');
        subcategoryList.slideToggle();

        let icon = $(this).find('.dropdown-icon');
        icon.toggleClass('rotated');
    });


   $('.category-checkbox, .subcategory-checkbox, .tag-checkbox').on('change', function () {
        applyFilters();
    });

    $("#search_form").on("submit", function (e) {
        e.preventDefault();  
        applyFilters();     
    });

    $('#search_keyword').on('input', function() {
        clearTimeout(this.delay);
        this.delay = setTimeout(applyFilters, 500); 
    });

    // $('#priceRange').on('input change', applyFilters);

    function applyFilters() {
        let selectedCategories = [];
        let selectedSubcategories = [];
        let selectedTags = [];
        let price = $('#priceRange').val() || 0;

        let keyword = $("#search_keyword").val()?.trim() || '';
        let itemId = $("#search_keyword").data("item-id") || '';

        $('.category-checkbox:checked').each(function () {
            selectedCategories.push($(this).data('category-id'));
        });

        $('.subcategory-checkbox:checked').each(function () {
            selectedSubcategories.push($(this).data('subcategory-id'));
        });

        $('.tag-checkbox:checked').each(function () {
            selectedTags.push($(this).data('tag-name'));
        });
        let sortOption = $("#sorting").val() || 0;

        let requestData = {
            categories: selectedCategories,
            subcategories: selectedSubcategories,
            price: price,
            sort_option: sortOption // <-- added here
        };

        if (keyword) requestData.keyword = keyword;
        if (itemId) requestData.item_id = itemId;
        if (selectedTags.length > 0) requestData.tags = selectedTags;

        $.ajax({
            url: '{{ route("filter_products") }}',
            type: 'GET',
            data: requestData,
            success: function (response) {
                $('#items-container').empty();

                if (response.length > 0) {
                    // (Your code to render filtered items)
                    response.forEach(function (item) {
                        let price = item.fixed_price ?? item.pricing ? item.pricing.fixed_price : 0;
                        let itemKeyword = item.search_keyword ?? '';
                        
                        var itemHTML = `
                                <div class="col-xl-4 col-md-12 mt-5">
                                    <div class="wordpress_plugin_bg h-100">
                                        <div class="wordpress_logo">
                                            <a href="/product-details/${item.id}">
                                                <img src="{{ asset('public/storage/items_files/') }}/${item.thumbnail_image}" alt="not found" class="img-fluid w-100 h-100">
                                            </a>
                                        </div>
                                        <div class="product-box">
                                            <a href="/product-details/${item.id}">
                                                <h4 class="plugin_h4">${item.name}</h4>
                                            </a>
                                            <div class="plugin_p">{!! $items->html_description ?? '' !!}</div>

                                            <p class="product_price">
                                                <span class="price-usd">$${item.pricing ? item.pricing.fixed_price : 0}</span>
                                                <span class="price-inr d-none">₹${item.pricing ? item.pricing.fixed_inr_price : 0}</span>
                                            </p>

                                            <div class="product_summery">
                                                <div class="product_rating">
                                                    <div class="wsus__pro_det_review d-flex align-items-center">
                                                        <p class="mb-0 d-flex align-items-center">
                                                            ${getStarRating(item.reviews)}
                                                            <span class="ml-1" style="font-size: 14px;">(${item.reviews ? item.reviews.length : 0})</span>
                                                        </p>
                                                    </div>
                                                    <label>${item.order_count ?? 0} Sales</label>
                                                </div>
                                                <div class="product_btn d-flex justify-content-between align-items-center">                                                
                                                    <a href="/product-details/${item.id}"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Buy Now</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;

                        
                        $('#items-container').append(itemHTML);
                    });
                    if (localStorage.getItem('preferred_currency') === 'inr') {
                        document.querySelectorAll('.price-usd').forEach(el => el.classList.add('d-none'));
                        document.querySelectorAll('.price-inr').forEach(el => el.classList.remove('d-none'));
                    }
                    matchItemHeights();
                    $('.no-items').removeClass('no-items');
                    document.getElementById('clearFilterButton').style.display = 'block';
                } else {
                    $('#items-container').html('<div class="no-items text-center w-100">No items found.</div>');
                    document.getElementById('clearFilterButton').style.display = 'block';
                }
            },
            error: function () {
                alert("Error fetching filtered results.");
            }
        });
    }

    document.querySelectorAll('.category-toggle').forEach(btn => {
        btn.addEventListener('click', function() {
            const subcategoryList = this.closest('.category-item').querySelector('.subcategory-list');
            if (subcategoryList.classList.contains('active')) {
            subcategoryList.classList.remove('active');
            } else {
            subcategoryList.classList.add('active');
            }
        });
    });
    function matchItemHeights() {
        let items = document.querySelectorAll('.wsus__gallery_item');
        let maxHeight = 0;

        // Find the tallest item
        items.forEach(item => {
            item.style.height = 'auto'; // Reset height to get actual size
            let itemHeight = item.offsetHeight;
            if (itemHeight > maxHeight) {
                maxHeight = itemHeight;
            }
        });

        // Apply max height to all items
        items.forEach(item => {
            item.style.height = maxHeight + "px";
        });
    }

    // Run function when the page loads
    window.addEventListener('load', matchItemHeights);

    // Run function again when resizing the window
    window.addEventListener('resize', matchItemHeights);
</script>
@endsection
