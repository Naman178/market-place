@extends('front-end.common.master')
@section('title')
   Infinity Marketplace | Thank You
@endsection
@section('styles')
   <link rel="stylesheet" href="{{ asset('front-end/css/checkout.css') }}">
@endsection
@section('content')
    
    <div class="thankyou cust-page-padding">
        <div class="container items-container text-center">
            <img src="https://infinty-stage.com/storage/homepage/thankyou.png" alt="thankyou" class="thankyou-img">
            <p class="plan-feature-heading mt-5">Your wallet has been successfully topped up with the requested amount. We appreciate your trust in our services and value your business.</p>
            <p>If you have any questions or need further assistance, please feel free to contact our customer support team. They are available to assist you with any inquiries you may have.</p>
            <p class="mb-5">Thank you for choosing Skyfinity Quick Checkout for your wallet top-up. We look forward to serving you again in the future!</p>
            <a href="/" class="pink-blue-grad-button">Go to Dashboard</a>
            <a href="https://infinty-stage.com/user-dashboard#wallet" class="pink-blue-grad-button">Go to Wallet</a>
        </div>
    </div>
    
@endsection