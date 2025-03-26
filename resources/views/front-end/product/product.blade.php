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
        button{
            cursor: pointer;
        }
        .form-control{
            padding: 13px !important;
            height: calc(2.5em + 0.75rem + 2px);
        }
        .clearFilterButton .blue_common_btn svg {
            left: 0 !important;
            width: 100% !important;
        }
    </style>
@endsection
@section('meta')
    <title>Market Place | {{ $seoData->title ?? 'Default Title' }} - {{ $seoData->description ?? 'Default Description' }}
    </title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $seoData->description ?? 'Default description' }}">
    <meta name="keywords" content="{{ $seoData->keywords ?? 'default, keywords' }}">
    <meta property="og:title" content="{{ $seoData->title ?? 'Default Title' }}">
    <meta property="og:description" content="{{ $seoData->description ?? 'Default description' }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
@endsection
@section('content')
    <div class="container items-container">
        <div class="title">
            <h3><span class="color-blue underline-text">Products</span></h3>
        </div>
        {{-- <div class="container" style="padding-left: 330px; padding-right:330px;">
            <div class="row" style="display: flex; justify-content:space-between; align-items:center;">
                @if ($item->count() != 0)
                    @foreach ($item as $items)
                        <div class="col-lg-4 col-12 mt-2 mb-2" style="cursor: pointer;">
                            <div style="position: absolute; z-index:1; left:35px; color:white;">
                                <h1 style="color: #f5b04c;">{{ $items->name }}</h1>
                            </div>
                            <div class="card" style="width:410px; height:400px;">
                                <div class="card-body" style="padding: 0px;">
                                    <img src="{{ asset('public/storage/items_files/' . $items->thumbnail_image) }}"
                                        alt="Sub-Category Image" style="width: 100%; padding:7px; height:399px;">
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p>No Product Found</p>
                @endif
            </div>
        </div> --}}
        <div class="row">
            <div class="col-xl-11 col-md-12">
                <div class="wsus__product_page_search">
                    <form id="search_form">
                        @foreach ($categories as $category)
                        <input type="search" name="keyword" id="search_keyword" value placeholder="Search your products..."  data-item-id="{{ $category->id }}" oninput="searchItems(this)" required>
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
            <div class="col-xl-1 col-md-12 justify-content-end clearFilterButton">
                <button class="blue_common_btn mt-1" type="button" onclick="clearFilters()" id="clearFilterButton" style="display:none;">
                    <svg viewBox="0 0 100 100" preserveAspectRatio="none">
                        <polyline points="99,1 99,99 1,99 1,1 99,1" class="bg-line"></polyline>
                        <polyline points="99,1 99,99 1,99 1,1 99,1" class="hl-line"></polyline>
                    </svg>
                    <span>Clear Filter</span>
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="wsus__product_sidebar_area mt-3">
                    <div class="wsus__product_sidebar categories">
                    @foreach ($categories as $category)
                        <select name="sorting" id="sorting-{{ $category->id }}" class="form-control select-input mt-3" data-item-id="{{ $category->id }}" onchange="sortItems(this)">
                            <option value="0">Default Sorting</option>
                            <option value="1">Low to Highest Price</option>
                            <option value="2">Highest to Low Price</option>
                        </select>
                        @break
                    @endforeach  
                    </div>
                    <div class="wsus__product_sidebar categories">
                        <h3>Categories</h3>
                        @foreach ($categories as $category)
                        <ul class="p-0">
                            <li><a href="{{ route('product.list', ['categoryOrSubcategory' => $category->id]) }}">{{ $category->name}} <span>({{ $category->subcategories_count }})</span> </a></li>
                        </ul>
                        @endforeach
                    </div>
                    @foreach ($item as $items)
                        <div class="wsus__product_sidebar categories">
                            <h3>Tags</h3>
                            @foreach ($items->tags as $tag)
                            @foreach ($categories as $category)
                            <ul class="p-0">
                                <li><a href="{{ route('product.list', ['categoryOrSubcategory' => $category->id ?? '', 'tag' => $tag['tag_name']]) }}">{{ $tag['tag_name'] ?? ''}}</a></li>
                            </ul>
                            @break
                            @endforeach
                            @endforeach
                        </div>
                        @break
                    @endforeach
                    <div class="wsus__product_sidebar tags">
                        <h3>Filter Price</h3>
                        @foreach ($item as $items)
                            @php
                                // Get the max fixed price from all items
                                $maxPrice = ceil($item->max(function($items) {
                                    return $items->pricing['fixed_price'] ?? 0;
                                }) / 1000) * 1000; // Round up to the nearest thousand
                            @endphp
                        @endforeach
                        @foreach ($categories as $category)
                            <input type="range" id="priceRange" min="0" max="{{ $maxPrice ?? 100 }}" step="1" value="0" data-item-id="{{ $category->id }}"  oninput="updatePriceLabel(this.value)">
                            <p class="mt-2">Price: <span id="priceLabel">0</span></p>
                            @break
                        @endforeach  
                        <li class="signup-wrapper"><a class="blue_common_btn w-100" onclick="filterByPrice()"> 
                            <svg viewBox="0 0 100 100" preserveAspectRatio="none">
                                <polyline points="99,1 99,99 1,99 1,1 99,1" class="bg-line"></polyline>
                                <polyline points="99,1 99,99 1,99 1,1 99,1" class="hl-line"></polyline>
                          </svg><span> Filter</span></a></li>  
                        {{-- <button class="read_btn mt-3 w-100" onclick="filterByPrice()" type="submit">Filter</button> --}}
                    </div>
                </div>
            </div>
            @if ($item->count() != 0)
            <div class="col-xl-9 col-md-12">
                <div id="items-container" class="row">
                @foreach ($item as $items)
                <div class="col-xl-5 col-md-6">
                    <div class="wsus__gallery_item">
                        <div class="wsus__gallery_item_img">
                            <img src="{{ asset('public/storage/items_files/' . $items->thumbnail_image) }}"
                                alt="gallery" class="img-fluid w-100">
                            <ul class="wsus__gallery_item_overlay">
                                <li><a target="_blank" href="{{ $items->preview_url }}">Preview</a>
                                </li>
                                <li><a
                                        href="{{ route('buynow.list', ['id' => $items->id]) }}">Buy
                                        Now</a></li>
                            </ul>
                        </div>
                        <div class="wsus__gallery_item_text">
                            <p class="price">
                                {{ $items->pricing['fixed_price'] ?? 0 }}
                            </p>
                            <a class="title"
                                href="{{ route('buynow.list', ['id' => $items->id]) }}">
                                {{ $items->name }}</a>
                                <ul class="d-flex flex-wrap justify-content-between">
                                    <li>
                                        <p>
                                            @php
                                                $rating = round($items->reviews->avg('rating') ?? 0, 1); 
                                                $fullStars = floor($rating); 
                                                $halfStar = ($rating - $fullStars) >= 0.5 ? 1 : 0; 
                                                $emptyStars = 5 - ($fullStars + $halfStar);
                                            @endphp

                                            @for ($i = 0; $i < $fullStars; $i++)
                                                <i class="fas fa-star text-warning"></i>
                                            @endfor
                                
                                            @if ($halfStar)
                                                <i class="fas fa-star-half-alt text-warning"></i>
                                            @endif
                                
                                            @for ($i = 0; $i < $emptyStars; $i++)
                                                <i class="far fa-star text-warning"></i>
                                            @endfor
                                            <span>({{ $items->reviews->count() ?? 0 }})</span>
                                        </p>
                                    </li>
                                    <li>
                                        <span class="download"><i class="fa fa-download" aria-hidden="true"></i> {{ $items->order->count() ?? 0 }} Sale</span>
                                    </li>
                                </ul>
                                
                        </div>
                    </div>
                </div>
                @endforeach
                </div>
            </div>
            @else
                <div class="col-xl-9 col-md-12 text-center no-items">
                    <p>No products found.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
@section('scripts')
<script>
    function sortItems(selectElement) {
        var sortOption = selectElement.value;
        var itemId = selectElement.getAttribute("data-item-id");

        // Check if category ID is available
        if (itemId) {
            $.ajax({
                type: "GET",
                url: "{{ route('items.sort') }}", // Define this route in your web.php
                data: {
                    sort: sortOption,
                    item_id: itemId // Pass the selected category ID
                },
                success: function(response) {
                    // Empty the previous items before appending new ones
                    $("#items-container").empty(); // Assuming #items-container is the wrapper for your items
                    console.log(response);
                    
                    // Check if there are items in the response
                    if (response.length > 0) {
                        response.forEach(function(item) {
                            // Create the item HTML structure dynamically
                            var itemHTML = `
                                <div class="col-xl-5 col-md-6">
                                    <div class="wsus__gallery_item">
                                        <div class="wsus__gallery_item_img">
                                            <img src="{{ asset('public/storage/items_files/') }}/${item.thumbnail_image}" alt="gallery" class="img-fluid w-100">
                                            <ul class="wsus__gallery_item_overlay">
                                                <li><a target="_blank" href="${item.preview_url}">Preview</a></li>
                                                <li><a href="/product-details/${item.id}">Buy Now</a></li> <!-- Use direct URL concatenation -->
                                            </ul>
                                        </div>
                                        <div class="wsus__gallery_item_text">
                                            <p class="price">${item.pricing ? item.pricing.fixed_price : 0}</p>
                                            <a class="title" href="/product-details/${item.id}">${item.name}</a> <!-- Use direct URL concatenation -->
                                            <ul class="d-flex flex-wrap justify-content-between">
                                                <li>
                                                    <p>
                                                        ${getStarRating(item.reviews)}
                                                        <span>(${item.reviews.length ?? 0})</span>
                                                    </p>
                                                </li>
                                                <li>
                                                    <span class="download"><i class="fa fa-download" aria-hidden="true"></i> 0 Sale</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            `;

                            // Append the item HTML to the container
                            $("#items-container").append(itemHTML);
                        });
                        document.getElementById('clearFilterButton').style.display = 'block';
                    } else {
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

    // Helper function to generate star rating HTML
    function getStarRating(reviews) {
        // Calculate the average rating
        var totalRating = 0;
        var reviewCount = reviews.length;
        
        // Sum up all ratings
        reviews.forEach(function(review) {
            totalRating += review.rating; // Assuming review has a 'rating' property
        });

        // Calculate average rating
        var rating = reviewCount > 0 ? (totalRating / reviewCount) : 0;

        // Round the rating to the nearest integer
        var roundedRating = Math.round(rating);

        // Determine full stars, half stars, and empty stars
        var fullStars = Math.floor(roundedRating);
        var halfStar = roundedRating - fullStars >= 0.5 ? 1 : 0;
        var emptyStars = 5 - (fullStars + halfStar);

        // Create the star rating HTML
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

    function updatePriceLabel(value) {
        document.getElementById('priceLabel').innerText = value;
        // Update the background of the range slider
        var priceRange = document.getElementById('priceRange');
        var percentage = (value - priceRange.min) / (priceRange.max - priceRange.min) * 100;
        priceRange.style.background = `linear-gradient(to right, #007AC1 ${percentage}%, #ccc ${percentage}%)`;
    }

    function filterByPrice() {
        let priceRange = document.getElementById('priceRange');
        let price = priceRange.value; // Get the selected price
        let itemId = priceRange.getAttribute("data-item-id");
        
        $.ajax({
            type: "GET",
            url: "{{ route('items.sort') }}",
            data: {
                price: price,
                sort: $('#sorting').val(), // Assuming you have a sorting element
                item_id: itemId // Pass the selected category ID
            },
            success: function(response) {
                $("#items-container").empty();
                if (response.length > 0) {
                    response.forEach(function(item) {
                        var itemHTML = `
                            <div class="col-xl-5 col-md-6">
                                <div class="wsus__gallery_item">
                                    <div class="wsus__gallery_item_img">
                                        <img src="{{ asset('public/storage/items_files/') }}/${item.thumbnail_image}" alt="gallery" class="img-fluid w-100">
                                        <ul class="wsus__gallery_item_overlay">
                                            <li><a target="_blank" href="${item.preview_url}">Preview</a></li>
                                            <li><a href="/product-details/${item.id}">Buy Now</a></li>
                                        </ul>
                                    </div>
                                    <div class="wsus__gallery_item_text">
                                        <p class="price">${item.pricing ? item.pricing.fixed_price : 0}</p>
                                        <a class="title" href="/product-details/${item.id}">${item.name}</a>
                                        <ul class="d-flex flex-wrap justify-content-between">
                                            <li>
                                                <p>${getStarRating(item.reviews)} <span>(${item.reviews.length ?? 0})</span></p>
                                            </li>
                                            <li>
                                                <span class="download"><i class="fa fa-download" aria-hidden="true"></i> 0 Sale</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        `;
                        $("#items-container").append(itemHTML);
                    });
                    document.getElementById('clearFilterButton').style.display = 'block';
                } else {
                    $("#items-container").append(`  <div class="col-xl-12 col-md-12 text-center no-items">
                            <p>No products found</p>
                        </div>`);
                    document.getElementById('clearFilterButton').style.display = 'block';
                }
            }
        });
    }
    $("#search_form").on("submit", function (e) {
        e.preventDefault(); 
        let keyword = $("#search_keyword").val(); 
        let itemId = $("#search_keyword").data("item-id");
        $.ajax({
            url: "{{ route('items.sort') }}", 
            method: "GET",
            data: { 
                keyword: keyword,
                item_id: itemId
                },
            success: function (response) {
                $("#items-container").empty();
            if (response.length > 0) {
                response.forEach(function(item) {
                    var itemHTML = `
                        <div class="col-xl-5 col-md-6">
                            <div class="wsus__gallery_item">
                                <div class="wsus__gallery_item_img">
                                    <img src="{{ asset('public/storage/items_files/') }}/${item.thumbnail_image}" alt="gallery" class="img-fluid w-100">
                                    <ul class="wsus__gallery_item_overlay">
                                        <li><a target="_blank" href="${item.preview_url}">Preview</a></li>
                                        <li><a href="/product-details/${item.id}">Buy Now</a></li>
                                    </ul>
                                </div>
                                <div class="wsus__gallery_item_text">
                                    <p class="price">${item.pricing ? item.pricing.fixed_price : 0}</p>
                                    <a class="title" href="/product-details/${item.id}">${item.name}</a>
                                    <ul class="d-flex flex-wrap justify-content-between">
                                        <li>
                                            <p>${getStarRating(item.reviews)} <span>(${item.reviews.length ?? 0})</span></p>
                                        </li>
                                        <li>
                                            <span class="download"><i class="fa fa-download" aria-hidden="true"></i> 0 Sale</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    `;
                    $("#items-container").append(itemHTML);
                });
                document.getElementById('clearFilterButton').style.display = 'block';
            } else {
                $("#items-container").append(`  <div class="col-xl-12 col-md-12 text-center no-items">
                        <p>No products found</p>
                    </div>`);
                    document.getElementById('clearFilterButton').style.display = 'block';
            }
            },
            error: function () {
                alert("Error fetching search results.");
            }
        });
    });
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

</script>
@endsection
