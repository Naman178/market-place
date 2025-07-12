@php $name = optional($user)->name ? explode(" ", $user->name) : ['', '']; @endphp
<style>
    .cart-features {
        padding: 1rem;
    }

    .features-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }

    .feature-item {
        display: flex;
        align-items: center;
        padding: 0.5rem;
    }

    .feature-item::before {
        content: "✔";
        margin-right: 0.5rem;
        color: #28a745;
    }
    .iti {
        width: 100% !important;
    }

    /* Proper spacing for country dropdown */
    .iti--separate-dial-code .iti__selected-flag {
        background-color: #ffffff !important; /* Light gray background */
        padding: 10px;
        border-radius: 5px 0 0 5px;
        /* border: 1px solid #ced4da; */
        height: 100%;
        display: flex;
        align-items: center;
    }

    .iti--separate-dial-code .iti__selected-flag:hover{
        background-color: rgba(0, 0, 0, 0.05) !important; 
    }

    /* Prevent overlapping input */
    .iti--allow-dropdown input {
        padding-left: 100px !important;
    }

    /* Align phone number input field */
    .iti input {
        height: 45px !important;
        border-radius: 5px !important;
    }
</style>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.css" />
</head>

<div class="col-md-12 p-4 card cart-doted-border" style="margin-bottom: 50px;">
    <p class="mb-0 mt-3" style="position: relative;">
    <div class="mb-5 cart-item-border text-center">Product Details</div>
    @php
        $selectedPricing = $cart['pricing'];
        $plan = $cart['item'];

        $itemPrice = (int) $selectedPricing['sale_price'];
        $gst = ($selectedPricing['gst_percentage'] / 100) * $itemPrice;
        $discount = (int) ($selectedPricing['discount'] ?? 0);
        $final_total = $itemPrice;
    @endphp
    <input type="hidden" id="server_discount" value="{{ $discount ?? 0 }}">
    <div class="cart-container" id="cart-container-{{ $plan->id }}-{{ $selectedPricing['id'] }}">
        <div class="cart-item" id="cart-item-{{ $plan->id }}-{{ $selectedPricing['id'] }}">
            <!-- Product Image -->
            <img src="@if (!empty($plan->thumbnail_image)) {{ asset('storage/items_files/' . $plan->thumbnail_image) }} @endif"
                alt="{{ $plan->name }}"
                class="h-30 w-30">

            <!-- Product Details -->
            <div class="cart-item-details">
                <h2 class="cart-item-title">{{ $plan->name }}</h2>
            </div>

            <!-- Price and Quantity -->
            <p>Each
            <span class="d-block">
                <span class="price-usd">
                    $ <strong class="new-price price-value-usd">{{ $selectedPricing['sale_price'] ?? 0 }}</strong>
                </span>
                <span class="price-inr d-none">
                    ₹ <strong class="new-price price-value-inr">{{ $selectedPricing['sales_inr_price'] ?? 0 }}</strong>
                </span>
                {{ $selectedPricing['billing_cycle'] ?? '' }}
            </span>
        </p>

            <div>
                <label for="quantity">Quantity:</label>
                <select class="d-block w-50" id="quantity" onchange="dynamicCalculation()">
                    @for ($i = 1; $i <= 10; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>

            <p>Total:
                <strong class="d-block finaltotals">
                    <span class="price-usd">
                        $ <span class="total-value-usd">{{ number_format($final_total) }}</span>
                    </span>
                    <span class="price-inr d-none">
                        ₹ <span class="total-value-inr">{{ number_format($selectedPricing['sales_inr_price']) }}</span>
                    </span>
                </strong>
            </p>
        </div>

        <!-- Remove and Wishlist -->
        <div class="cart-item-options">
            <a class="remove-item"
            data-plan-id="{{ $plan->id }}"
            data-pricing-id="{{ $selectedPricing['id'] }}"
            data-category="{{ $categoryName }}"
            data-slug="{{ $subcategorySlug }}">
                Remove
            </a>
            <a onclick="saveForLater({{ $plan->id }})">Move to Wishlist</a>
        </div>

        <div class="border-top"></div>

        <div class="d-flex align-items-center justify-content-between">
            <h5 id="items-count">1 Item</h5>
            <h5>
                <strong class="d-block finaltotals">
                    <span class="price-usd">
                        $ <span class="total-value-usd">{{ number_format($final_total) }}</span>
                    </span>
                    <span class="price-inr d-none">
                        ₹ <span class="total-value-inr">{{ number_format($selectedPricing['sales_inr_price']) }}</span>
                    </span>
                </strong>
            </h5>
        </div>
    </div>
</div>

<div class="col-md-12 p-4 mt-3 card cart-doted-border">
    <p class="mb-0 mt-3" style="position: relative;">
        @auth
        <!--  Billing Details of {{ Auth::user()->name }} -->
        @else
        Already Have an Account ?...Please <a href="{{ url('/user-login') }}"> Login</a> or Register Below
    </p>
    <div class="d-flex">
        <a href="{{ url('/user-login/google') }}" class="google-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 48 48">
                <path fill="#ffc107" d="M43.611 20.083H42V20H24v8h11.303c-1.649 4.657-6.08 8-11.303 8c-6.627 0-12-5.373-12-12s5.373-12 12-12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4C12.955 4 4 12.955 4 24s8.955 20 20 20s20-8.955 20-20c0-1.341-.138-2.65-.389-3.917" />
                <path fill="#ff3d00" d="m6.306 14.691l6.571 4.819C14.655 15.108 18.961 12 24 12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4C16.318 4 9.656 8.337 6.306 14.691" />
                <path fill="#4caf50" d="M24 44c5.166 0 9.86-1.977 13.409-5.192l-6.19-5.238A11.91 11.91 0 0 1 24 36c-5.202 0-9.619-3.317-11.283-7.946l-6.522 5.025C9.505 39.556 16.227 44 24 44" />
                <path fill="#1976d2" d="M43.611 20.083H42V20H24v8h11.303a12.04 12.04 0 0 1-4.087 5.571l.003-.002l6.19 5.238C36.971 39.205 44 34 44 24c0-1.341-.138-2.65-.389-3.917" />
            </svg>
            <span>
                Continue with Google
            </span>
        </a>
    </div>
    @endauth
    <div class="mb-5 cart-item-border text-center">Billing Details</div>
    <form id="guest-checkout-form">
    <div class="row mt-2">
        <!-- First Name -->
        <div class="col-md-6">
            <div class="form-group">
                <input type="text" name="firstname" id="firstname" class="form-control" placeholder=" " value="{{ $name[0] ?? '' }}" />
                <label for="firstname" class="floating-label">First Name</label>
                <div class="error" id="firstname_error"></div>
            </div>
        </div>

        <!-- Last Name -->
        <div class="col-md-6">
            <div class="form-group">
                <input type="text" name="lastname" id="lastname" class="form-control" placeholder=" " value="{{ $name[1] ?? '' }}" />
                <label for="lastname" class="floating-label">Last Name</label>
                <div class="error" id="lastname_error"></div>
            </div>
        </div>

        <!-- Email -->
        <div class="col-md-6">
            <div class="form-group">
                <input type="email" name="email" id="email" class="form-control" placeholder=" " value="{{ optional($user)->email }}" />
                <label for="email" class="floating-label">Email</label>
                <div class="error" id="email_error"></div>
            </div>
        </div>
        
        <!-- Contact Number -->
        <div class="col-md-6">
            <div class="form-group">
                <input type="tel" id="contact_number" name="contact_number" class="form-control" value="{{ optional($user)->contact_number ?? '' }}">
                <input type="hidden" name="country_code" id="country_code" value="{{  $user->country_code ?? '' }}">
                {{-- <input type="hidden" name="country_code_name" id="country_code_name" value="{{ $dialCode }}"> --}}
                <input type="hidden" name="country" id="country" value="{{$isoName ?? ''}}">
                @error('country_code')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                <div class="error" id="country_code_error"></div>
            </div>
        </div>

        <!-- Company Name -->
        <div class="col-md-6">
            <div class="form-group">
                <input type="text" name="company_name" id="company_name" class="form-control" placeholder=" " value="{{ optional($user)->company_name }}" />
                <label for="company_name" class="floating-label">Company Name</label>
                <div class="error" id="company_name_error"></div>
            </div>
        </div>

        <!-- Company Website -->
        <div class="col-md-6">
            <div class="form-group">
                <input type="text" name="company_website" id="company_website" class="form-control" placeholder=" " value="{{ optional($user)->company_website }}" />
                <label for="company_website" class="floating-label">Company Website</label>
                <div class="error" id="company_website_error"></div>
            </div>
        </div>

        <!-- Address Line 1 -->
        <div class="col-md-12">
            <div class="form-group">
                <input type="text" name="address_line1" id="address_line_one" class="form-control" placeholder=" " value="{{ optional($user)->address_line1 }}" />
                <label for="address_line_one" class="floating-label">Address Line 1</label>
                <div class="error" id="address_line_one_error"></div>
            </div>
        </div>

        <!-- Address Line 2 -->
        <div class="col-md-12">
            <div class="form-group">
                <input type="text" name="address_line2" id="address_line_two" class="form-control" placeholder=" " value="{{ optional($user)->address_line2 }}" />
                <label for="address_line_two" class="floating-label">Address Line 2</label>
                <div class="error" id="address_line_two_error"></div>
            </div>
        </div>

        <!-- City -->
        <div class="col-md-6">
            <div class="form-group">
                <input type="text" name="city" id="city" class="form-control" placeholder=" " value="{{ optional($user)->city }}" />
                <label for="city" class="floating-label">City</label>
                <div class="error" id="city_error"></div>
            </div>
        </div>

        <!-- Postal Code -->
        <div class="col-md-6">
            <div class="form-group">
                <input type="text" name="postal_code" id="postal" class="form-control" placeholder=" " value="{{ optional($user)->postal_code }}" />
                <label for="postal" class="floating-label">Zip / Postal Code</label>
                <div class="error" id="postal_error"></div>
            </div>
        </div>
    </div>
    </form>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        if (localStorage.getItem('preferred_currency') === 'inr') {
            document.querySelectorAll('.price-usd').forEach(el => el.classList.add('d-none'));
            document.querySelectorAll('.price-inr').forEach(el => el.classList.remove('d-none'));
        }
    });
    let unitPrice = localStorage.getItem('preferred_currency') === 'inr'
    ? parseFloat(document.querySelector('.price-value-inr')?.textContent || 0)
    : parseFloat(document.querySelector('.price-value-usd')?.textContent || 0);

    let quantity = parseInt(document.getElementById('quantity').value);
    let total = unitPrice * quantity;

    // Update total field
    if (localStorage.getItem('preferred_currency') === 'inr') {
        document.querySelector('.total-value-inr').textContent = total.toLocaleString();
    } else {
        document.querySelector('.total-value-usd').textContent = total.toLocaleString();
    }
</script>