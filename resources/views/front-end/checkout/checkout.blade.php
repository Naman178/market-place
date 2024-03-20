@extends('front-end.common.master')
@section('title', 'Checkout')
@section('styles')
   <link rel="stylesheet" href="{{ asset('front-end/css/checkout.css') }}">
@endsection
@section('content')
<div class="container checkout-container">
   <div class="checkout padding">
      <div class="container">
         <div class="row justify-content-center">
            <!-- if user is already logged in -->
            <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 col-12">
               <div class="col-md-12 border p-4 card dark-blue-card">
                  <p class="txt-white">Already Have an Account ?...Please <a href="#"> Login</a> or Register Below</p>
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
                           <select name="country_code" id="country_code" class="form-control" required="required">
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
                           <select name="country" id="country" class="form-control">
                              <option value="0">Select Country</option>
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
                     <div class="accordion" id="accordionExample">
                        <div class="card">
                           <h6 class="card-title mb-0">
                              <a data-toggle="collapse" class="text-default collapsed" href="#accordion-item-group1" aria-expanded="false">
                              Have Coupon Code ?
                              </a>
                           </h6>
                           <div id="accordion-item-group1" class="collapse" data-parent="#accordionExample" style="">
                              <div class="row mt-4">
                                 <div class="col-md-8">
                                    <div class="form-group">
                                       <input class="form-control" type="text" name="coupon_code" id="coupon_code" placeholder="Etner Your Promotional Code Here">
                                       <p class="error" id="coupon_code_error"></p>
                                    </div>
                                 </div>
                                 <div class="col-md-4">
                                    <button class="pink_blue_grad_button d-inline-block border-0 m-0" type="button" id="coupon_code_apply_btn">Apply</button>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <hr>
                     <div class="row mb-1">
                        <div class="col-lg-4 col-sm-4 col-4 cart-detail-img">
                           <h5 class="mb-2">Subtotal</h5>
                        </div>
                        <div class="col-lg-8 col-sm-8 col-8 cart-detail-product">
                           <h5 class="mb-2">  0</h5>
                        </div>
                     </div>
                     <div class="row mb-1 discount_row" style="display: none;">
                        <div class="col-lg-4 col-sm-4 col-4 cart-detail-img">
                           <h5 class="mb-2">Discount</h5>
                        </div>
                        <div class="col-lg-8 col-sm-8 col-8 cart-detail-product">
                           <h5 class="mb-2" id="discount_amount"> 0 </h5>
                        </div>
                     </div>
                     <div class="row mb-4">
                        <div class="col-lg-4 col-sm-4 col-4 cart-detail-img">
                           <h5 class="mb-2">Total</h5>
                        </div>
                        <div class="col-lg-8 col-sm-8 col-8 cart-detail-product">
                           <h5 class="mb-2" id="final_total">   0 </h5>
                        </div>
                     </div>
                     <hr>
                     <h4 class="mb-3">Select Payment Method</h4>
                     <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                           <a class="nav-link active show" id="profile-basic-tab" data-toggle="tab" href="#stripePayment" role="tab" aria-controls="stripePayment" aria-selected="false">Stripe</a>
                        </li>
                     </ul>
                     <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="stripePayment" role="tabpanel" aria-labelledby="profile-icon-pill">
                           <form role="form" action="https://skyfinity.co.in/stripe-payment" method="post" class="require-validation" data-cc-on-file="false" data-stripe-publishable-key="pk_live_51J3GsmSEC2amdbjF8aLtAjgt53oI47AMprFaOKdTiDgAFZIEuA7BICGB283A1IlYhdCGWrMe0dhft6cSflfR7hWu00UGQp5mf9" id="stripe-form">
                              <input type="hidden" name="_token" value="JHL3ScfngiobUpAC7ga0QnkLWSHrQhiIcb09ygZ1">     
                              <input type="hidden" name="product_id" value="">      
                              <input type="hidden" name="amount" id="amount" value="0">   
                              <input type="hidden" name="is_discount_applied" id="is_discount_applied" value="no">   
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
                                    <button class="pink_blue_grad_button d-inline-block border-0 proced_to_pay_btn" id="stripeBtn" type="button">Proceed To Pay 0 </button>
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