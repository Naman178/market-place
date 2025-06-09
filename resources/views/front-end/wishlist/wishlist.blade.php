@extends('front-end.common.master')
@section('title', 'Wishlist')
@section('styles')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
            .wishlist-container {
                max-width: 1400px;
                margin: auto;
                background: #fff;
                border: 1px dotted #007bff;
                padding: 20px;
                border-radius: 8px;
            }
            .wishlist-title {
                text-align: center;
                margin-bottom: 20px;
                font-size: 24px;
                font-weight: bold;
            }
            .wishlist-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 20px;
            }
            .wishlist-item {
                background: #fff;
                padding: 15px;
                border-radius: 8px;
                text-align: center;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                cursor: pointer;
                border-top: 1px solid #ddd; /* border-top added */
            }
            .wishlist-item img {
                width: 100px;
                height: auto;
                border-radius: 5px;
            }
            .wishlist-item h3 {
                font-size: 18px;
                margin: 10px 0;
                color: #4D4D4D;
            }
            .wishlist-item p {
                font-size: 16px;
            }
            .wishlist-actions {
                margin-top: 10px;
            }
            .wishlist-actions button {
                border-color: #dc3545;
                color: #dc3545;
                /* border: none; */
                background-color: transparent;
                padding: 5px 10px;
                cursor: pointer;
                margin-right: 5px;
            }
            .wishlist-actions button:hover {
                border-color: #c82333;
            }
            /* Wishlist border-top style */
            .border-top {
                margin-top: 20px;
                border-top: 1px solid #ddd;
            }
            .cart-container {
                max-width: 800px;
                padding: 20px;
                border-radius: 8px;
                border-bottom: 1px solid #ddd;
            }
            .cart-container:last-child {
                border-bottom: none;
            }
            .cart-item {
                display: flex;
                gap: 20px;
                padding-bottom: 15px;
                margin-bottom: 15px;
            }
            .cart-item img {
                width: 100px;
                height: auto;
                border-radius: 5px;
            }
            .cart-item-details {
                flex: 1;
            }
            .cart-item-title {
                font-size: 18px;
                margin: 0 0 5px;
            }
            .cart-item-options a {
                margin-right: 10px;
                color: #007bff;
                text-decoration: none;
            }
            .cart-item-options a:hover {
                text-decoration: underline;
            }
            .price-quantity {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            .price-label {
                font-size: 16px;
                color: #333;
                margin-bottom: 5px;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .summary {
                padding-top: 20px;
            }
            .promo-code input {
                width: calc(100% - 110px);
                padding: 5px;
                margin-right: 10px;
                border: 1px solid #ddd;
                border-radius: 4px;
            }
            .btn-apply {
                padding: 5px 15px;
                border: none;
                background-color: #007bff;
                color: white;
                border-radius: 4px;
            }
            @media (max-width: 991px) {
                .wishlist-container {
                    max-width: 90%; 
                }
                .wishlist-grid {
                    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); /* Adjust for small screens */
                    gap: 10px; /* Reduce the gap */
                }
            }
            .wishlist{
                margin-top:33px !important;
                margin-bottom: 33px !important;
            }
    </style>
</head>
@endsection
@section('content')
    <div class="wishlist pt-5 pb-5">
        <div class="wishlist-container">
            <h1 class="wishlist-title">My Wishlist</h1>
            <div class="wishlist-grid row p-2">
            @foreach($wishlists as $items)
    @foreach($items->plan as $item)
    <div class="col-md-12 col-12">
        <div class="wishlist-item row" onclick="redirectToBuyNow('{{ route('buynow.list', ['id' => $item->id]) }}')">
            <!-- Left Section (Product Image) -->
            <div class="col-md-6 col-12 m-auto">
                <img class="w-100 h-100" src="@if (!empty($item->thumbnail_image)) {{ asset('storage/items_files/' . $item->thumbnail_image) }} @endif" 
                    alt="{{ $item->name }}">
            </div>

            <!-- Right Section (Details & Buttons) -->
            <div class="col-md-6 col-12 wishlist-actions">
                <h3>{{ $item->name }}</h3>
                <p><strong>₹{{ $item->pricing->sale_price }}</strong></p>

                <!-- Buttons (Prevent Redirect When Clicking These) -->
                <a class="red_common_btn remove-btn" id="wishlistBtn-{{ $item->id }}" onclick="removeWishlist({{ $item->id }})">
                    <svg viewBox="0 0 100 100" preserveAspectRatio="none">
                        <polyline points="99,1 99,99 1,99 1,1 99,1" class="bg-line"></polyline>
                        <polyline points="99,1 99,99 1,99 1,1 99,1" class="hl-line"></polyline>
                    </svg>
                    <span> Remove </span>
                </a>

                <li class="mt-3">
                    <a class="blue_common_btn add-to-cart-btn" href="{{ route("checkout", ["id" => base64_encode($item->id)]) }}" target="_blank" onclick="event.stopPropagation();">
                        <svg viewBox="0 0 100 100" preserveAspectRatio="none">
                            <polyline points="99,1 99,99 1,99 1,1 99,1" class="bg-line"></polyline>
                            <polyline points="99,1 99,99 1,99 1,1 99,1" class="hl-line"></polyline>
                        </svg>
                        <span> Add to Cart </span>
                    </a>
                </li>
            </div>
        </div>
    </div>
    @endforeach
@endforeach

            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script>
     const addToWishlistRoute = "{{ route('wishlist.remove') }}";
     function removeWishlist(itemId) {
        // Find the button and icon elements using the itemId
        let wishlistBtn = document.getElementById(`wishlistBtn-${itemId}`);
        
        // Check if both elements exist before trying to manipulate them
        if (!wishlistBtn) {
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
                toastr.success(data.message);
                location.reload();
            } else {
                toastr.error(data.message);
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alert("An error occurred while processing your request.");
        });
    }
    function redirectToBuyNow(url) {
        window.location.href = url;
    }
</script>
@endsection
