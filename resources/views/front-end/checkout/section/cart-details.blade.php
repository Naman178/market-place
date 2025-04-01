{{-- @php $item = $data["item"]; @endphp --}}
<div class="card cart-doted-border">
    <div class="card-body position-relative">
        {{-- <div class="mb-3 cart-item-border text-center">Wallet Summary</div>
        <div class="cart-items mt-3">
                @if (!empty($mergedPricing))
                    @foreach ($mergedPricing as $key => $selectedPricing)
                        <div class="row mb-3 pb-3 cart-item border-bottom" id="cart-item-{{ $plan->id }}-{{ $selectedPricing['id'] }}">
                            <div class="col-lg-3 col-sm-4 col-4 cart-detail-img d-flex justify-content-center align-content-center">
                                <div class="cart-item-image">
                                    <img src="@if (!empty($plan->thumbnail_image)) {{ asset('storage/items_files/' . $plan->thumbnail_image) }} @endif" 
                                        alt="{{ $plan->name }}" 
                                        class="h-100 w-100">
                                </div>
                            </div>
                            <div class="col-lg-9 col-sm-8 col-8 cart-detail-product align-content-center ml-25">
                                <h3 class="mt-0 mb-2 cart-item-name">{{ $plan->name }}</h3>
                                @if($selectedPricing)
                                    <h5 class="mt-0 mb-2 cart-item-pri">
                                        <span class="ml-2">&#8377; <strong class="new-price">{{ $selectedPricing['sale_price'] ?? 0 }}</strong> {{ $selectedPricing['billing_cycle'] ?? '' }}</span>
                                    </h5>
                                @endif
                                <h5 class="mt-0 mb-2 cart-item-pri">
                                    Quantity: 1
                                </h5>
                                @if ((int) $selectedPricing['id'] > 1)
                                    <button class="pink-blue-grad-button d-inline-block border-0 m-0 remove-item" 
                                        data-plan-id="{{ $plan->id }}" 
                                        data-pricing-id="{{ $selectedPricing['id'] }}">
                                        Remove
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="row mb-3 pb-3 cart-item border-bottom">
                        <div class="col-lg-3 col-sm-4 col-4 cart-detail-img d-flex justify-content-center align-content-center">
                            <div class="cart-item-image">
                                <img src="@if (!empty($plan->thumbnail_image)) {{ asset('storage/items_files/' . $plan->thumbnail_image) }} @endif" 
                                    alt="{{ $plan->name }}" 
                                    class="h-100 w-100">
                            </div>
                        </div>
                        <div class="col-lg-9 col-sm-8 col-8 cart-detail-product align-content-center ml-25">
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
        </div> --}}
        {{-- <div class="accordion position-relative" id="accordionCouponCode"> --}}
            <div class="cart-item-border">
                <div class="text-center">Coupon Codes({{$couponCodes->count()}})</div>
            </div>
            <div class="coupon-container card cart-doted-border">
                <div class="card-body mb-3 coupon-overflow">
                    @if ($couponCodes->count() != 0)
                        @php
                            // Filter auto-apply coupons
                            $autoApplyCoupons = $couponCodes->filter(function ($c) {
                                return $c->auto_apply == 'yes';
                            });
                    
                            // Select the coupon with the minimum discount value
                            $autoApplyCoupon = $autoApplyCoupons->sortBy('discount_value')->first();
                        @endphp

                        @foreach ($couponCodes as $item)
                            @php
                                $val = $item->discount_type == 'flat' ? '₹' . $item->discount_value : $item->discount_value.'%';
                                $isAutoApplied = $autoApplyCoupon && $autoApplyCoupon->id == $item->id;
                            @endphp
                            <div class="card mt-4 coupon-max-width">
                                <div class="card-body">
                                    <h5 class="mt-0">{{$val}}</h5>
                                    <p>Same fee {{$val}} for all products in order</p>
                                    <input type="hidden" name="discount_coupon_type" id="discount_coupon_type" data-type="{{$item->discount_type}}" value="{{$item->discount_value}}">
                                    <div class="card">
                                        <div class="card-body p-10">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="font_weight_600">{{$item->coupon_code}}</div>
                                                {{-- <button class="pink-blue-grad-button d-inline-block border-0 m-0 coupon-btn 
                                                    {{ $isAutoApplied ? 'remove-btn' : '' }}" 
                                                    type="button" id="topapplybtn"
                                                    data-coupon-id="{{$item->id}}"
                                                    data-coupon-code="{{$item->coupon_code}}">
                                                    {{ $isAutoApplied ? 'Remove' : 'Apply' }}
                                                </button> --}}
                                                <button class="blue_common_btn d-inline-block border-0 m-0 coupon-btn"  {{ $isAutoApplied ? 'remove-btn' : '' }}" 
                                                    type="button" id="topapplybtn"
                                                    data-coupon-id="{{$item->id}}"
                                                    data-coupon-code="{{$item->coupon_code}}">
                                                    <svg viewBox="0 0 100 100" preserveAspectRatio="none">
                                                        <polyline points="99,1 99,99 1,99 1,1 99,1" class="bg-line"></polyline>
                                                        <polyline points="99,1 99,99 1,99 1,1 99,1" class="hl-line"></polyline>
                                                    </svg>
                                                    <span>  {{ $isAutoApplied ? 'Remove' : 'Apply' }}</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="card mt-4 coupon_min_width">
                            <div class="card-body">
                                <p>No Coupon Code Available For This Product</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="card border-radius-none mt-3">
                <h6 class="card-title mb-0 mt-0">
                    <a data-toggle="collapse" class="text-default" id="accordion_coupon_code" aria-expanded="false">
                    You have a coupon code ?
                    </a>
                </h6>
                <div id="accordion_coupon_code_form" class="accordion-body d-block" data-parent="#accordionCouponCode">
                    <div class="row mt-2">
                        <div class="col-md-9">
                        <div class="form-group mb-0">
                            <input class="form-control" type="text" name="coupon_code" id="coupon_code" placeholder="Enter Coupon Code...">
                            <p class="error" id="coupon_code_error"></p>
                        </div>
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="blue_common_btn border-0 m-0"  id="coupon_code_apply_btn">
                                <svg viewBox="0 0 100 100" preserveAspectRatio="none">
                                    <polyline points="99,1 99,99 1,99 1,1 99,1" class="bg-line"></polyline>
                                    <polyline points="99,1 99,99 1,99 1,1 99,1" class="hl-line"></polyline>
                                </svg>
                                <span> Apply</span>
                            </button>
                        {{-- <button class="pink-blue-grad-button d-inline-block border-0 m-0" type="button" id="coupon_code_apply_btn">Apply</button> --}}
                        </div>
                    </div>
                </div>
            </div>
            <p class="coupon-error text-danger"></p>
            <div class="apply-coupon-code-container d-none">
                <div class="alert alert-success d-flex justify-content-between align-items-center mb-0" role="alert">
                    <div>Coupon Code : <span class="applied-coupon-code font_weight_600"></span></div>
                    <button type="button" class="blue_common_btn remove-applied-coupon remove_coupon_btn">
                        <svg viewBox="0 0 100 100" preserveAspectRatio="none">
                            <polyline points="99,1 99,99 1,99 1,1 99,1" class="bg-line"></polyline>
                            <polyline points="99,1 99,99 1,99 1,1 99,1" class="hl-line"></polyline>
                        </svg>
                        <span> Remove</span>
                    </button>
                    {{-- <button type="button" class="btn pink-btn remove-applied-coupon remove_coupon_btn">Remove</button> --}}
                </div>
            </div>
        {{-- </div> --}}
        <hr>
        {{-- <div class="row mb-1">
            <div class="col-lg-4 col-sm-4 col-4 cart-detail-img">
                <h5 class="mt-0 mb-2">Subtotal</h5>
            </div>
            @if (!empty($mergedPricing))
                @foreach ($mergedPricing as $key => $selectedPricing)
                    <div class="col-lg-8 col-sm-8 col-8 cart-detail-product">
                    <h5 class="mt-0 mb-2">INR {{ number_format((int)  $selectedPricing['sale_price'] ) }}</h5>
                    </div>
                @endforeach
            @else
            <div class="col-lg-8 col-sm-8 col-8 cart-detail-product">
                <h5 class="mt-0 mb-2">INR {{ number_format((int)  $selectedPricing->sale_price ) }}</h5>
            </div>
            @endif
        </div>
        <div class="row mb-1">
            <div class="col-lg-4 col-sm-4 col-4 cart-detail-img">
                <h5 class="mt-0 mb-2">GST(+)</h5>
            </div>
            @php
                if(!empty($mergedPricing)){
                    foreach($mergedPricing as $key => $selectedPricing){
                        $total = (int)$selectedPricing['sale_price'];
                        $gst = ($selectedPricing['gst_percentage']/100) * $total;
                    }
                }
                else{
                    $total = (int)$selectedPricing->sale_price;
                    $gst = ($selectedPricing->gst_percentage/100) * $total;
                }
            @endphp
            <div class="col-lg-8 col-sm-8 col-8 cart-detail-product">
                <h5 class="mt-0 mb-2">INR {{ number_format((int) $gst ) }}</h5>
            </div>
        </div>
        <div class="row mb-1 discount_row">
            <div class="col-lg-4 col-sm-4 col-4 cart-detail-img">
                <h5 class="mt-0 mb-2">Discount(-)</h5>
            </div>
            <div class="col-lg-8 col-sm-8 col-8 cart-detail-product">

                <h5 class="mt-0 mb-2" id="discount_amount">INR</h5>
                @if (!empty($mergedPricing))
                    @foreach ($mergedPricing as $key => $selectedPricing)
                        <h5 class="mt-0 mb-2" id="discount_amount">INR {{ (int) $selectedPricing['fixed_price'] }}</h5>
                    @endforeach
                @else
                 <h5 class="mt-0 mb-2" id="discount_amount">INR {{ (int) $selectedPricing->fixed_price }}</h5>
                @endif
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-lg-4 col-sm-4 col-4 cart-detail-img">
                <h5 class="mt-0 mb-2">Total</h5>
            </div>
            <div class="col-lg-8 col-sm-8 col-8 cart-detail-product">
                @php
                    if(!empty($mergedPricing)){
                        foreach($mergedPricing as $key => $selectedPricing){
                            $total = (int)$selectedPricing['fixed_price'];
                            $gst = ($selectedPricing['gst_percentage']/100) * $total;
                            $final_total = $total + $gst;
                        }
                    }else{
                        $total = (int)$selectedPricing->fixed_price;
                        $gst = ($selectedPricing->gst_percentage/100) * $total;
                        $final_total = $total + $gst;
                    }
                @endphp
                <h5 class="mt-0 mb-2" id="final_total">INR {{ number_format($final_total) }}</h5>
             </div>
        </div> --}}
        @php
            $totalSubtotal = 0;
            $totalGST = 0;
            $totalDiscount = 0;
        @endphp

        @if (!empty($mergedPricing))
            @foreach ($mergedPricing as $key => $selectedPricing)
                @php
                    $itemPrice = (int) $selectedPricing['sale_price'];
                    $gst = ($selectedPricing['gst_percentage'] / 100) * $itemPrice;
                    $discount = (int) $selectedPricing['sale_price']  ?? 0;

                    $totalSubtotal += $itemPrice;
                    $totalGST += $gst;
                    $totalDiscount += $discount;
                @endphp
            @endforeach
            <div class="row mb-1">
                <div class="col-lg-4 col-sm-4 col-4 cart-detail-img">
                    <h5 class="mt-0 mb-2">Subtotal</h5>
                </div>
                <div class="col-lg-8 col-sm-8 col-8 cart-detail-product">
                    <h5 class="mt-0 mb-2" data-amount="{{ number_format($totalSubtotal) }}" id="subtotal_amount">INR {{ number_format($totalSubtotal) }}</h5>
                </div>
            </div>

            <div class="row mb-1">
                <div class="col-lg-4 col-sm-4 col-4 cart-detail-img">
                    <h5 class="mt-0 mb-2">GST (+)</h5>
                </div>
                <div class="col-lg-8 col-sm-8 col-8 cart-detail-product">
                    <h5 class="mt-0 mb-2" data-pr="{{ $selectedPricing['gst_percentage'] ?? 0 }}" id="gst_amount">INR {{ number_format($totalGST) }}</h5>
                </div>
            </div>
            <div class="row mb-1 discount_row d-none">
                <div class="col-lg-4 col-sm-4 col-4 cart-detail-img">
                    <h5 class="mt-0 mb-2">Discount(-)</h5>
                </div>
                <div class="col-lg-8 col-sm-8 col-8 cart-detail-product">
    
                    <h5 class="mt-0 mb-2" id="discount_amount">INR</h5>
                    {{-- <h5 class="mt-0 mb-2" id="subtotal_amount">INR {{ (int) $totalSubtotal }}</h5> --}}
                       
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-lg-4 col-sm-4 col-4 cart-detail-img">
                    <h5 class="mt-0 mb-2">Total</h5>
                </div>
                <div class="col-lg-8 col-sm-8 col-8 cart-detail-product">
                    @php
                      $final_total = $totalSubtotal + $totalGST;
                    @endphp
                    <h5 class="mt-0 mb-2" id="final_total">INR {{ number_format($final_total) }}</h5>
                </div>
            </div>

        @else
            @php
                $itemPrice = (int) $selectedPricing->sale_price;
                $gst = ($selectedPricing->gst_percentage / 100) * $itemPrice;
                $discount = (int) ($selectedPricing->discount ?? 0);
            @endphp
            <div class="row mb-1">
                <div class="col-lg-4 col-sm-4 col-4 cart-detail-img">
                    <h5 class="mt-0 mb-2">Subtotal</h5>
                </div>
                <div class="col-lg-8 col-sm-8 col-8 cart-detail-product">
                    <h5 class="mt-0 mb-2" id="subtotal_amount">INR {{ number_format($selectedPricing->sale_price) }}</h5>
                </div>
            </div>
            
            <div class="row mb-1">
                <div class="col-lg-4 col-sm-4 col-4 cart-detail-img">
                    <h5 class="mt-0 mb-2">GST (+)</h5>
                </div>
                <div class="col-lg-8 col-sm-8 col-8 cart-detail-product">
                    <h5 class="mt-0 mb-2" id="gst_amount">INR {{ number_format($gst) }}</h5>
                </div>
            </div>
            
            <div class="row mb-1 discount_row d-none">
                <div class="col-lg-4 col-sm-4 col-4 cart-detail-img">
                    <h5 class="mt-0 mb-2">Discount(-)</h5>
                </div>
                <div class="col-lg-8 col-sm-8 col-8 cart-detail-product">
    
                    <h5 class="mt-0 mb-2" id="discount_amount">INR</h5>
                     <h5 class="mt-0 mb-2" id="subtotal_amount">INR {{ (int) $selectedPricing->sale_price }}</h5>
                </div>
            </div>
            
            <div class="row mb-4">
                <div class="col-lg-4 col-sm-4 col-4 cart-detail-img">
                    <h5 class="mt-0 mb-2">Total</h5>
                </div>
                <div class="col-lg-8 col-sm-8 col-8 cart-detail-product">
                    @php
                        $final_total = $itemPrice + $gst;
                    @endphp
                      <h5 class="mt-0 mb-2" id="final_total">INR {{ number_format($final_total) }}</h5>
                </div>
            </div>
        @endif
        <hr>
        <h4 class="mb-3">Select Payment Method</h4>
        <ul class="nav nav-tabs" id="paymentTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active show" id="profile-basic-tab" data-toggle="tab" id="#stripePayment" role="tab" aria-controls="stripePayment" aria-selected="false">Stripe</a>
            </li>
        </ul>
        <div class="tab-content" id="paymentTabContent">
            <div class="tab-pane fade show active" id="stripePaymentForm" role="tabpanel" aria-labelledby="profile-icon-pill">
                <form role="form" action="{{ route('stripe-payment-store') }}"  method="post"  class="require-validation" data-cc-on-file="false" data-stripe-publishable-key="{{ env('STRIPE_KEY') }}" id="stripe-form">
                    @csrf
                    <input type="hidden" id="stripeToken" name="stripeToken">
                    @if (!empty($mergedPricing))
                        @foreach ($mergedPricing as $key => $selectedPricing)
                            <input type="hidden" id="plan_type" name="plan_type" value="{{$selectedPricing['pricing_type']}}">
                            <input type="hidden" id="billing_cycle" name="billing_cycle" value="{{$selectedPricing['billing_cycle']}}">
                            <input type="hidden" name="subtotal" id="subtotal" value="{{(int)$selectedPricing['sale_price']}}">
                            <input type="hidden" name="gst" id="gst" value="{{$selectedPricing['gst_percentage']}}">
                        @endforeach
                    @else
                        <input type="hidden" id="plan_type" name="plan_type" value="{{$selectedPricing->pricing_type}}">
                        <input type="hidden" id="billing_cycle" name="billing_cycle" value="{{$selectedPricing->billing_cycle}}">

                        <input type="hidden" name="subtotal" id="subtotal" value="{{(int)$selectedPricing->sale_price}}">
                        <input type="hidden" name="gst" id="gst" value="{{$selectedPricing->gst_percentage}}">
                    @endif
                    <input type="hidden" name="final_quantity" id="final_quantity" value="1">
                    <input type="hidden" id="plan_name" name="plan_name" value="{{$plan->name}}">
                    <input type="hidden" id="amount" name="amount" value="{{ $final_total * 100 }}">
                    <input type="hidden" id="amount" name="currency" value="{{  $plan->currency ?? 'INR' }}">
                    <input type="hidden" name="is_discount_applied" id="is_discount_applied" value="no">
                    <input type="hidden" name="final_coupon_code" id="final_coupon_code" value="">
                    <input type="hidden" name="discount_value" id="discount_value" value="">
                    <input type="hidden" name="product_id" id="is_discount_applied" value="{{ $plan->id }}">
                    <input type="hidden" name="is_discount_applied" id="is_discount_applied" value="no">
                    <input type="hidden" name="trial_period_days" id="trial_period_days" value="{{ $plan->trial_days ?? 0}}">
                <!-- Name on Card -->
                <div class="form-row row">
                    <div class="col-md-12 form-group">
                        <label class="control-label">Name on Card</label>
                        <input class="form-control" size="4" type="text" id="name_on_card" required="">
                        <div class="error" id="name_on_card_error"></div>
                    </div>
                </div>

                <!-- Card Number -->
                <div class="form-row row">
                    <div class="col-md-12 form-group">
                        <label class="control-label">Card Number</label>
                        <input autocomplete="off" class="form-control card-number" id="card_number" name="card_number" size="20" placeholder="xxxx xxxx xxxx xxxx" type="text" required="">
                        <div class="error" id="card_number_error"></div>
                    </div>
                </div>

                <!-- Expiration Month -->
                <div class="form-row row">
                    <div class="col-xs-12 col-md-4 form-group expiration">
                        <label class="control-label">Expiration Month</label>
                        <input class="form-control card-expiry-month" placeholder="MM" id="card_exp_month" size="2" name="card_month" type="text" required="">
                        <div class="error" id="card_exp_month_error"></div>
                    </div>

                    <!-- Expiration Year -->
                    <div class="col-xs-12 col-md-4 form-group expiration required">
                        <label class="control-label">Expiration Year</label>
                        <input class="form-control card-expiry-year" placeholder="YY" id="card_exp_year" size="4" name="card_year" type="text" required="">
                        <div class="error" id="card_exp_year_error"></div>
                    </div>

                    <!-- CVC -->
                    <div class="col-xs-12 col-md-4 form-group cvc">
                        <label class="control-label">CVC</label>
                        <input autocomplete="off" class="form-control card-cvc" id="card_cvc" name="card_cvc" placeholder="ex. 311" size="4" type="text" required="">
                        <div class="error" id="card_cvc_error"></div>
                    </div>
                </div>

                <p class="error" id="stripe_payment_error"></p>
                <div class="row">
                    @php
                        if(!empty($mergedPricing)){
                            foreach($mergedPricing as $pricing){
                                $total = (int)$pricing['sale_price'];
                                $gst = ($pricing['gst_percentage']/100) * $total;
                                $final_total = $total + $gst;
                            }
                        }else{
                            $total = (int)$selectedPricing->sale_price;
                            $gst = ($selectedPricing->gst_percentage / 100) * $total;
                            $final_total = $total + $gst;
                        }
                    @endphp

                 @if(Auth::check())
                    <!--<div class="col-md-12">-->
                    <!--     <button-->
                    <!--        class="pink-blue-grad-button d-inline-block border-0 proceed_to_pay_btn"-->
                    <!--        id="proceed_to_pay_btn"-->
                    <!--        type="button"-->
                    <!--        data-url="{{ route('payment') }}" >-->
                    <!--        Proceed To Pay {{ number_format((int) $final_total) }} INR-->
                    <!--    </button>-->
                    <!--</div>-->
                    <button type="submit" class="blue_common_btn border-0 proced_to_pay_btn">
                        <svg viewBox="0 0 100 100" preserveAspectRatio="none">
                            <polyline points="99,1 99,99 1,99 1,1 99,1" class="bg-line"></polyline>
                            <polyline points="99,1 99,99 1,99 1,1 99,1" class="hl-line"></polyline>
                        </svg>
                        @if($plan->trial_days > 0)
                            <span>    Free Trial for <span class="final_btn_text">{{ $plan->trial_days }}</span> Days</span>
                        @else
                            <span> Proceed To Pay <span class="final_btn_text">{{ number_format((int) $final_total) }}</span> INR</span>
                        @endif
                    </button>
                    {{-- <button class="pink-blue-grad-button d-inline-block border-0 proced_to_pay_btn" type="submit">Proceed To Pay <span class="final_btn_text">{{ number_format((int) $final_total) }}</span>  INR</button> --}}
                     {{-- <button class="pink-blue-grad-button d-inline-block border-0 proced_to_pay_btn" type="submit">Proceed To Pay {{ number_format((int) $final_total) }} INR</button> --}}
                @else
                 <div class="col-md-12">
                    <button type="submit" class="blue_common_btn border-0 proced_to_pay_btn">
                        <svg viewBox="0 0 100 100" preserveAspectRatio="none">
                            <polyline points="99,1 99,99 1,99 1,1 99,1" class="bg-line"></polyline>
                            <polyline points="99,1 99,99 1,99 1,1 99,1" class="hl-line"></polyline>
                        </svg>
                        @if($plan->trial_days > 0)
                            <span>    Free Trial for {{ $plan->trial_days }}</span> Days</span>
                        @else
                            <span> Proceed To Pay {{ number_format((int) $final_total) }}</span> INR</span>
                        @endif
                    </button>
                    {{-- <button  class="pink-blue-grad-button d-inline-block border-0 proceed_to_pay_btn" id="proceed_to_pay_btn" type="button">Proceed To Pay {{ number_format((int) $final_total) }} INR</button> --}}
                    </div>
                    @endif
                </div>
            </form>
            </div>
        </div>
    </div>
</div>

@include('front-end/checkout/apply-coupon-script')
