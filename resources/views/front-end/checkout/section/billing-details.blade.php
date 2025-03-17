@php $name = optional($user)->name ? explode(" ", $user->name) : ['', ''];  @endphp
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
</style>
<div class="col-md-12 p-4 card cart-doted-border" style="height: 200px; margin-bottom: 50px;">
    <p class="mb-0 mt-3" style="position: relative;">
    <div class="mb-5 cart-item-border text-center">Product Details</div>
    <div class="cart-items mt-3">
        @if (!empty($mergedPricing))
            @foreach ($mergedPricing as $key => $selectedPricing)
            <div class="row mb-3 pb-3 cart-item" id="cart-item-{{ $plan->id }}-{{ $selectedPricing['id'] }}">
                <!-- Product Image Section -->
                <div class="col-lg-3 col-sm-4 col-4 cart-detail-img d-flex justify-content-center align-content-center">
                    <div class="cart-item-image">
                        <img src="@if (!empty($plan->thumbnail_image)) {{ asset('storage/items_files/' . $plan->thumbnail_image) }} @endif" 
                            alt="{{ $plan->name }}" 
                            class="h-100 w-100">
                    </div>
                </div>
            
                <!-- Product Details Section -->
                <div class="col-lg-5 col-sm-8 col-8 cart-detail-product align-content-center">
                    <h3 class="mt-0 mb-2 cart-item-name" style="margin-top: -20px !important">{{ $plan->name }}</h3>
                    @if($selectedPricing)
                        <h5 class="mt-0 mb-2 cart-item-pri">
                            <span class="ml-2">&#8377; <strong class="new-price">{{ $selectedPricing['sale_price'] ?? 0 }}</strong> {{ $selectedPricing['billing_cycle'] ?? '' }}</span>
                        </h5>
                    @endif
                    <h5 class="mt-0 mb-2 cart-item-pri">
                        Quantity: <span id="quantity">1</span>
                    </h5>
                    <button id="decrement" class="pink-blue-grad-button d-inline-block border-0 m-0" disabled onclick="dynamicCalculation()">-</button>
                    <button id="increment" class="pink-blue-grad-button d-inline-block border-0 m-0" onclick="dynamicCalculation()">+</button>
                    {{-- @if ((int) $selectedPricing['id'] > 1)
                        <button class="pink-blue-grad-button d-inline-block border-0 m-0 remove-item" 
                            data-plan-id="{{ $plan->id }}" 
                            data-pricing-id="{{ $selectedPricing['id'] }}">
                            Remove
                        </button>
                    @endif --}}
                </div>

                <!-- Cart Features Section (Two-column side by side) -->
                @if (!empty($selectedPricing['key_features']))
                    <div class="col-lg-4 col-sm-12 cart-features d-flex justify-content-between align-items-start">
                        <div class="d-flex flex-wrap w-100" style="margin-left: -95px;">
                            @php
                                $half = ceil(count($selectedPricing['key_features']) / 2);
                                $leftColumn = array_slice($selectedPricing['key_features'], 0, $half);
                                $rightColumn = array_slice($selectedPricing['key_features'], $half);
                            @endphp
                            
                            <div class="w-50">
                                @foreach ($leftColumn as $feature)
                                    <div class="mb-2">{{ $feature }}</div>
                                @endforeach
                            </div>

                            <div class="w-50">
                                @foreach ($rightColumn as $feature)
                                    <div class="mb-2">{{ $feature }}</div>
                                @endforeach
                            </div>
                        </div>

                        @if ((int) $selectedPricing['id'] > 1)
                            <button class="pink-blue-grad-button d-inline-block border-0 m-0 remove-item"
                                data-plan-id="{{ $plan->id }}" 
                                data-pricing-id="{{ $selectedPricing['id'] }}">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        @endif
                    </div>
                @endif
            </div>
            @endforeach
        @else
            <div class="row mb-3 pb-3 cart-item">
                <div class="col-lg-3 col-sm-4 col-4 cart-detail-img d-flex justify-content-center align-content-center">
                    <div class="cart-item-image">
                        <img src="@if (!empty($plan->thumbnail_image)) {{ asset('storage/items_files/' . $plan->thumbnail_image) }} @endif" 
                            alt="{{ $plan->name }}" 
                            class="h-100 w-100">
                    </div>
                </div>
                <div class="col-lg-9 col-sm-8 col-8 cart-detail-product align-content-center" style="margin-left: -25px;">
                    <h3 class="mt-0 mb-2 cart-item-name">{{ $plan->name }}</h3>
                    @if($selectedPricing)
                        <h5 class="mt-0 mb-2 cart-item-pri">
                            <span class="ml-2">&#8377; <strong class="new-price">{{ $selectedPricing->sale_price ?? 0 }}</strong> {{ $selectedPricing->billing_cycle ?? '' }}</span>
                        </h5>
                    @endif
                    <h5 class="mt-0 mb-2 cart-item-pri">
                        Quantity: 1
                    </h5>
                </div>
            </div>
        @endif
    </div>
</div>

<div class="col-md-12 p-4 mt-3 card cart-doted-border">
    <p class="mb-0 mt-3" style="position: relative;">
        @auth
           <!--  Billing Details of {{ Auth::user()->name }} -->
        @else
            Already Have an Account ?...Please <a href="{{ url('/user-login') }}"> Login</a> or Register Below</p>
            <div class="d-flex">
                <a href="{{ url('/user-login/google') }}" class="google-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 48 48"><path fill="#ffc107" d="M43.611 20.083H42V20H24v8h11.303c-1.649 4.657-6.08 8-11.303 8c-6.627 0-12-5.373-12-12s5.373-12 12-12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4C12.955 4 4 12.955 4 24s8.955 20 20 20s20-8.955 20-20c0-1.341-.138-2.65-.389-3.917"/><path fill="#ff3d00" d="m6.306 14.691l6.571 4.819C14.655 15.108 18.961 12 24 12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4C16.318 4 9.656 8.337 6.306 14.691"/><path fill="#4caf50" d="M24 44c5.166 0 9.86-1.977 13.409-5.192l-6.19-5.238A11.91 11.91 0 0 1 24 36c-5.202 0-9.619-3.317-11.283-7.946l-6.522 5.025C9.505 39.556 16.227 44 24 44"/><path fill="#1976d2" d="M43.611 20.083H42V20H24v8h11.303a12.04 12.04 0 0 1-4.087 5.571l.003-.002l6.19 5.238C36.971 39.205 44 34 44 24c0-1.341-.138-2.65-.389-3.917"/></svg>
                    <span>
                        Continue with Google
                    </span>
                </a>
            </div>
        @endauth
    <div class="mb-5 cart-item-border text-center">Billing Details</div>
    <div class="row mt-2">
         <!-- First Name -->
        <div class="col-md-6">
            <div class="form-group">
                <input type="text" name="firstname" id="firstname" class="form-control" placeholder=" " value="{{ $name[0] }}" />
                <label for="firstname" class="floating-label">First Name</label>
                <div class="error" id="firstname_error"></div>
            </div>
        </div>

        <!-- Last Name -->
        <div class="col-md-6">
            <div class="form-group">
                <input type="text" name="lastname" id="lastname" class="form-control" placeholder=" " value="{{ $name[1] }}" />
                <label for="lastname" class="floating-label">Last Name</label>
                <div class="error" id="lastname_error"></div>
            </div>
        </div>

        <!-- Email -->
        <div class="col-md-6">
            <div class="form-group">
                <input type="text" name="email" id="email" class="form-control" placeholder=" " value="{{ optional($user)->email }}" />
                <label for="email" class="floating-label">Email</label>
                <div class="error" id="email_error"></div>
            </div>
        </div>
        
        <!-- Country Code -->
        <div class="col-md-6">
            <div class="form-group">
                <select name="country_code" id="country_code" class="form-control select-input" required="required">
                    <option value="">Select country code</option>
                    @foreach($countaries as $countery)
                        <option value="{{ $countery->id }}" {{ optional($user)->country == $countery->id ? 'selected' : '' }}>{{ $countery->country_code }}</option>
                    @endforeach
                </select>
                <div class="error" id="country_code_error"></div>
            </div>
        </div>

        <!-- Contact Number -->
        <div class="col-md-6">
            <div class="form-group">
                <input type="number" name="contact" id="contact" class="form-control" placeholder=" " value="{{ optional($user)->contact_number }}" />
                <label for="contact" class="floating-label">Contact Number</label>
                <div class="error" id="contact_error"></div>
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
                <input type="text" name="address_line_one" id="address_line_one" class="form-control" placeholder=" " value="{{ optional($user)->address_line1 }}" />
                <label for="address_line_one" class="floating-label">Address Line 1</label>
                <div class="error" id="address_line_one_error"></div>
            </div>
        </div>

        <!-- Address Line 2 -->
        <div class="col-md-12">
            <div class="form-group">
                <input type="text" name="address_line_two" id="address_line_two" class="form-control" placeholder=" " value="{{ optional($user)->address_line2 }}" />
                <label for="address_line_two" class="floating-label">Address Line 2</label>
                <div class="error" id="address_line_two_error"></div>
            </div>
        </div>
        
        <!-- Country -->
        <div class="col-md-6">
            <div class="form-group">
                <select name="country" id="country" class="form-control select-input">
                    <option value="0">Select Country</option>
                    @foreach($countaries as $countery)
                        <option value="{{ $countery->id }}" data-country-code="{{ $countery->ISOname }}" {{ optional($user)->country == $countery->id ? 'selected' : '' }}>{{ $countery->name }}</option>
                    @endforeach
                </select>
                <div class="error" id="country_error"></div>
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
                <input type="text" name="postal" id="postal" class="form-control" placeholder=" " value="{{ optional($user)->postal_code }}" />
                <label for="postal" class="floating-label">Zip / Postal Code</label>
                <div class="error" id="postal_error"></div>
            </div>
        </div>
    </div>
</div>
