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
               @include("front-end.checkout.section.billing-details")
            </div>
            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 checkout-outer-card cart-details">
               @include("front-end.checkout.section.cart-details")
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@section('scripts')
   <script src="{{ asset('front-end/js/checkout.js') }}"></script>
@endsection