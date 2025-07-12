@extends('front-end.common.master')
@section('title', 'Checkout')
@section('styles')
   <link rel="stylesheet" href="{{ asset('front-end/css/checkout.css') }}">
   <link rel="stylesheet" href="{{ asset('front-end/css/register.css') }}">
@endsection
@section('scripts')
   <script src="https://js.stripe.com/v3/"></script>
@endsection
@section('content')
<div id="loader-overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(255,255,255,0.8); z-index:9999; justify-content:center; align-items:center;">
    <div class="spinner" style="border: 6px solid #f3f3f3; border-top: 6px solid #3498db; border-radius: 50%; width: 50px; height: 50px; animation: spin 1s linear infinite;"></div>
</div>
<div class="checkout-container">
   <div class="checkout padding container">
      <div class="container">
         <div class="row justify-content-center">
            <!-- if user is already logged in -->
            <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 col-12">
               @include("front-end.checkout.section.billing-details")
            </div>
            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 checkout-outer-card cart-details">
               @include("front-end.checkout.section.cart-details")
            </div>
         </div>
      </div>
   </div>
</div>
@include("front-end.checkout.checkout-script")
@endsection
@section('scripts')
   <script src="{{ asset('front-end/js/checkout.js') }}"></script>
@endsection
