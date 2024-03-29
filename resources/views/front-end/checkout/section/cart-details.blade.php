{{-- @php $item = $data["item"]; @endphp --}}
<div class="card">
    <div class="card-body">
        <h4 class="mb-3">Wallet Summary</h4>
        <hr>
        <div class="row mb-1">
            <div class="col-lg-4 col-sm-4 col-4 cart-detail-img">
                <div class="cart-item-image">
                    <img src="@if (!empty($plan->thumbnail_image)) {{ asset('storage/items_files/' . $plan->thumbnail_image) }} @endif" alt="{{ $plan->name }}" class="h-100 w-100">
                </div>
            </div>
            <div class="col-lg-8 col-sm-8 col-8 cart-detail-product align-content-center">
                <h3 class="mt-0 mb-2">{{ $plan->name }}</h3>
                {{-- <h5 class="mt-0 mb-2">INR {{ (int) $plan->pricing->fixed_price }} Quantity: 1</h5> --}}
                <h5 class="mt-0 mb-2">INR {{ number_format((int) $plan->pricing->sale_price ) }} Quantity: 1</h5>
            </div>
        </div>
        <hr>
        <div class="accordion" id="accordionCouponCode">
            <div class="card border-radius-none">
                <h6 class="card-title mb-0 mt-0">
                    <a data-toggle="collapse" class="text-default" id="accordion_coupon_code" aria-expanded="false">
                    Have Coupon Code ?
                    </a>
                </h6>
                <div id="accordion_coupon_code_form" class="accordion-body" data-parent="#accordionCouponCode" style="display: none;">
                    <div class="row mt-4">
                        <div class="col-md-8">
                        <div class="form-group mb-0">
                            <input class="form-control" type="text" name="coupon_code" id="coupon_code" placeholder="Enter Your Promotional Code Here">
                            <p class="error" id="coupon_code_error"></p>
                        </div>
                        </div>
                        <div class="col-md-4">
                        <button class="pink-blue-grad-button d-inline-block border-0 m-0" type="button" id="coupon_code_apply_btn">Apply</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row mb-1">
            <div class="col-lg-4 col-sm-4 col-4 cart-detail-img">
                <h5 class="mt-0 mb-2">Subtotal</h5>
            </div>
            <div class="col-lg-8 col-sm-8 col-8 cart-detail-product">
                <h5 class="mt-0 mb-2">INR {{ number_format((int) $plan->pricing->sale_price ) }}</h5>
            </div>
        </div>
        <div class="row mb-1 discount_row d-none">
            <div class="col-lg-4 col-sm-4 col-4 cart-detail-img">
                <h5 class="mt-0 mb-2">Discount</h5>
            </div>
            <div class="col-lg-8 col-sm-8 col-8 cart-detail-product">
                <h5 class="mt-0 mb-2" id="discount_amount">INR {{ (int) $plan->pricing->fixed_price }}</h5>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-lg-4 col-sm-4 col-4 cart-detail-img">
                <h5 class="mt-0 mb-2">Total</h5>
            </div>
            <div class="col-lg-8 col-sm-8 col-8 cart-detail-product">
                @php
                    $total = (int)$plan->pricing->sale_price;
                    $gst = ($plan->pricing->gst_percentage/100) * $total;
                    $final_total = $total + $gst;
                @endphp
                <h5 class="mt-0 mb-2" id="final_total">INR {{ number_format($final_total) }}</h5>
             </div>
        </div>
        <hr>
        <h4 class="mb-3">Select Payment Method</h4>
        <ul class="nav nav-tabs" id="paymentTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active show" id="profile-basic-tab" data-toggle="tab" id="#stripePayment" role="tab" aria-controls="stripePayment" aria-selected="false">Stripe</a>
            </li>
        </ul>
        <div class="tab-content" id="paymentTabContent">
            <div class="tab-pane fade show active" id="stripePaymentForm" role="tabpanel" aria-labelledby="profile-icon-pill">
                <form role="form" action="" method="post" id="stripe-for">
                    <div class="form-row row">
                        <div class="col-md-12 form-group">
                        <label class="control-label">Name on Card</label>
                        <input class="form-control" size="4" type="text" id="name_on_card" required="">
                        </div>
                    </div>
                    <div class="form-row row">
                        <div class="col-md-12 form-group">
                        <label class="control-label">Card Number</label>
                        <input autocomplete="off" class="form-control card-number" id="card_number" name="card_number" size="20" placeholder="xxxx xxxx xxxx xxxx" type="text" required="">
                        </div>
                    </div>
                    <div class="form-row row">
                        <div class="col-xs-12 col-md-4 form-group expiration">
                        <label class="control-label">Expiration Month</label>
                        <input class="form-control card-expiry-month" placeholder="MM" id="card_exp_month" size="2" name="card_month" type="text" required="">
                        </div>
                        <div class="col-xs-12 col-md-4 form-group expiration required">
                        <label class="control-label">Expiration Year</label>
                        <input class="form-control card-expiry-year" placeholder="YY" id="card_exp_year" size="4" name="card_year" type="text" required="">
                        </div>
                        <div class="col-xs-12 col-md-4 form-group cvc">
                        <label class="control-label">CVC</label>
                        <input autocomplete="off" class="form-control card-cvc" id="card_cvc" name="card_cvc" placeholder="ex. 311" size="4" type="text" required="">
                        </div>
                    </div>
                    <p class="error" id="stripe_payment_error"></p>
                    <div class="row">
                        <div class="col-md-12">
                        <button
                            class="pink-blue-grad-button d-inline-block border-0 proceed_to_pay_btn"
                            {{-- id="stripeBtn" --}}
                            id="proceed_to_pay_btn"
                            type="button"
                            data-url="{{ route("payment") }}"
                        >
                            Proceed To Pay {{ number_format((int) $final_total) }} INR
                        </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
