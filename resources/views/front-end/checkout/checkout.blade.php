@extends('front-end.common.master')
@section('title', 'Checkout')
@section('styles')
   <link rel="stylesheet" href="{{ asset('front-end/css/checkout.css') }}">
   <link rel="stylesheet" href="{{ asset('front-end/css/register.css') }}">
   <style>
    .google-btn{
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 5px;
        padding: 10px;
        box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
        border-radius: 5px;
        margin-bottom: 30px;
        background-color: white;
    }

    .google-btn > span{
        color: black;
    }
   </style>
@endsection
@section('content')
<div class="container checkout-container">
   <div class="checkout padding">
      <div class="container">
         <div class="row justify-content-center">
            <!-- if user is already logged in -->
            <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 col-12">
               <div class="col-md-12 border p-4 card dark-blue-card">
                  <p class="txt-white" style="margin-bottom: 20px">Already Have an Account ?...Please <a href="#"> Login</a> or Register Below</p>
                    <div style="display: flex;">
                        <a href="{{ url('/user-login/google') }}" class="google-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 48 48"><path fill="#ffc107" d="M43.611 20.083H42V20H24v8h11.303c-1.649 4.657-6.08 8-11.303 8c-6.627 0-12-5.373-12-12s5.373-12 12-12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4C12.955 4 4 12.955 4 24s8.955 20 20 20s20-8.955 20-20c0-1.341-.138-2.65-.389-3.917"/><path fill="#ff3d00" d="m6.306 14.691l6.571 4.819C14.655 15.108 18.961 12 24 12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4C16.318 4 9.656 8.337 6.306 14.691"/><path fill="#4caf50" d="M24 44c5.166 0 9.86-1.977 13.409-5.192l-6.19-5.238A11.91 11.91 0 0 1 24 36c-5.202 0-9.619-3.317-11.283-7.946l-6.522 5.025C9.505 39.556 16.227 44 24 44"/><path fill="#1976d2" d="M43.611 20.083H42V20H24v8h11.303a12.04 12.04 0 0 1-4.087 5.571l.003-.002l6.19 5.238C36.971 39.205 44 34 44 24c0-1.341-.138-2.65-.389-3.917"/></svg>
                            <span>
                                Continue with Google
                            </span>
                        </a>
                    </div>
                  <h4 class="mb-5 txt-white">Billing Details</h4>
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                           <label for="firstname">First Name</label>
                           <input type="text" name="firstname" id="firstname" class="form-control" placeholder="Enter First Name">
                           <div class="error" id="firstname_error"></div>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <label for="lastname">Last Name</label>
                           <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Enter Last Name">
                           <div class="error" id="lastname_error"></div>
                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="form-group">
                           <label for="email">Email</label>
                           <input type="text" name="email" id="email" class="form-control" placeholder="Enter Email">
                           <div class="error" id="email_error"></div>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group">
                           <label for="country_code">Country Code</label>
                           <select name="country_code" id="country_code" class="form-control select-input" required="required">
                              <option value="">Select country code</option>
                           </select>
                        </div>
                     </div>
                     <div class="col-md-8">
                        <div class="form-group">
                           <label for="contact">Contact Number</label>
                           <input type="number" name="contact" id="contact" class="form-control" placeholder="Enter Contact Number">
                           <div class="error" id="contact_error"></div>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <label for="company_name">Company Name</label>
                           <input type="text" name="company_name" id="company_name" class="form-control" placeholder="Enter Company Name">
                           <div class="error" id="company_name_error"></div>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <label for="company_website">Company Website</label>
                           <input type="text" name="company_website" id="company_website" class="form-control" placeholder="Enter Company Website">
                           <div class="error" id="company_website_error"></div>
                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="form-group">
                           <label for="company_name">Country</label>
                           <select name="country" id="country" class="form-control select-input">
                              <option value="0">Select Country</option>
                              @foreach($countaries as $countery)
                                 <option value="{{ $countery->id }}">{{ $countery->name }}</option>
                              @endforeach
                           </select>
                           <div class="error" id="country_error"></div>
                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="form-group">
                           <label for="address_line_one">Address Line 1</label>
                           <input type="text" name="address_line_one" id="address_line_one" class="form-control" placeholder="Enter Address Line 1">
                           <div class="error" id="address_line_one_error"></div>
                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="form-group">
                           <label for="address_line_two">Address Line 2</label>
                           <input type="text" name="address_line_two" id="address_line_two" class="form-control" placeholder="Enter Address Line 2">
                           <div class="error" id="address_line_two_error"></div>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <label for="city">City</label>
                           <input type="text" name="city" id="city" class="form-control" placeholder="Enter City Name">
                           <div class="error" id="city_error"></div>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <label for="postal">Zip / Postal Code</label>
                           <input type="text" name="postal" id="postal" class="form-control" placeholder="Enter Zip / Postal Code">
                           <div class="error" id="postal_error"></div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 checkout-outer-card">
               <div class="card">
                  <div class="card-body">
                     <h4 class="mb-3">Wallet Summary</h4>
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
                           <h5 class="mt-0 mb-2">Price</h5>
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
                           <h5 class="mt-0 mb-2" id="discount_amount">INR 1999</h5>
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
                                    <button class="pink-blue-grad-button d-inline-block border-0 proced_to_pay_btn" id="stripeBtn" type="button">Proceed To Pay 0 INR</button>
                                 </div>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@section('scripts')
   <script src="{{ asset('front-end/js/checkout.js') }}"></script>
@endsection
