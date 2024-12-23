@extends('front-end.common.master')
@section('meta')
    <title>Market Place | {{ $seoData->title ?? 'Default Title' }} - {{ $seoData->description ?? 'Default Description' }}
    </title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $seoData->description ?? 'Default description' }}">
    <meta name="keywords" content="{{ $seoData->keywords ?? 'default, keywords' }}">
    <meta property="og:title" content="{{ $seoData->title ?? 'Default Title' }}">
    <meta property="og:description" content="{{ $seoData->description ?? 'Default description' }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">
@endsection
@section('styles')
    <style>
        .tip {
            background-color: #263646;
            padding: 0 14px;
            line-height: 27px;
            position: absolute;
            border-radius: 4px;
            z-index: 100;
            color: #fff;
            font-size: 12px;
            animation-name: tip;
            animation-duration: .6s;
            animation-fill-mode: both
        }

        .tip:before {
            content: "";
            background-color: #263646;
            height: 10px;
            width: 10px;
            display: block;
            position: absolute;
            transform: rotate(45deg);
            top: -4px;
            left: 17px
        }

        #copied_tip {
            animation-name: come_and_leave;
            animation-duration: 1s;
            animation-fill-mode: both;
            bottom: -35px;
            left: 2px
        }

        .text-line {
            font-size: 14px
        }

        .cust-page-padding {
            padding: 5rem 12rem 5rem;
            margin-bottom: 10rem;
        }

        .list-group {
            display: flex;
            flex-direction: column;
            padding-left: 0;
            margin-bottom: 0;
            border-radius: 0.25rem;
        }

        .user-dashboard-list-grp .list-group-item {
            font-size: 16px;
        }

        .list-group-item:first-child {
            border-top-left-radius: inherit;
            border-top-right-radius: inherit;
        }

        .list-group-item {
            position: relative;
            display: block;
            padding: 0.75rem 1.25rem;
            background-color: #fff;
            border: 1px solid rgba(0, 0, 0, 0.125);
        }

        .list-group-item-action {
            width: 100%;
            color: #665c70;
            text-align: inherit;
        }

        .user-dashboard-list-grp .list-group-item.active {
            background-image: linear-gradient(to right, #007ac1, #2B2842, #007ac1, #2B2842);
            border-color: #007ac1;
        }

        .list-group-item+.list-group-item.active {
            margin-top: -1px;
            border-top-width: 1px;
        }

        .user-dashboard-list-grp .list-group-item {
            font-size: 16px;
        }

        .list-group-item+.list-group-item {
            border-top-width: 0;
        }

        .list-group-item.active {
            z-index: 2;
            color: #fff;
            background-color: #335699;
            border-color: #335699;
        }

        .card-icon [class^=i-],
        .card-icon .lead {
            color: #335699;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 20px 1px rgba(0, 0, 0, 0.06), 0 1px 4px rgba(0, 0, 0, 0.08);
            border: 0;
        }

        .card-icon .card-body {
            padding: 2rem 0.5rem;
        }

        .text-muted {
            color: #70657b !important;
        }

        .text-24 {
            font-size: 24px;
        }

        .line-height-1 {
            line-height: 1;
        }

        .form-group label {
            font-size: 15px;
            color: #70657b;
            margin-bottom: 4px;
        }

        .plan_select_btn {
            display: flex;
            margin-bottom: 20px;
        }

        .wallet_plan_radio_button {
            margin: 0 5px 0 0;
            width: 120px;
            height: 45px;
            position: relative;
            border: 2px solid #7486b7;
            border-radius: 4px;
        }

        .text-primary {
            color: #335699 !important;
        }

        .wallet_plan_radio_button input[type="radio"] {
            opacity: 0.011;
            z-index: 100;
        }

        .wallet_plan_radio_button label,
        .wallet_plan_radio_button input {
            display: block;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            text-align: center;
            cursor: pointer;
        }

        .nav-tabs {
            border-bottom: 1px solid #335699;
        }

        .checkout .nav-tabs .nav-item,
        .user-dashboard .nav-tabs .nav-item {
            width: 50%;
            text-align: center;
        }

        .nav-tabs .nav-item .nav-link.active {
            border: 1px solid transparent;
            background: rgb(51 96 153 / 10%);
            border-color: #335699 #335699 #fff;
        }

        .nav-tabs .nav-item .nav-link.active {
            border-bottom: 2px solid #335699;
            background: rgb(51 96 153 / 10%);
        }

        .nav-tabs .nav-item .nav-link:not(.disabled) {
            color: inherit;
        }

        .nav-tabs .nav-item .nav-link {
            border: 0;
            padding: 1rem;
        }

        .nav-tabs .nav-link.active,
        .nav-tabs .nav-item.show .nav-link {
            color: #665c70;
            background-color: #fff;
            border-color: #dee2e6 #dee2e6 #fff;
        }

        .nav-tabs .nav-link {
            border: 1px solid transparent;
            border-top-left-radius: 0.25rem;
            border-top-right-radius: 0.25rem;
        }

        .nav-link {
            display: block;
            padding: 0.5rem 1rem;
        }

        .tab-content {
            padding: 1rem;
        }

        .btn-dark-blue {
            background: #2B2842;
            border-radius: 8px;
            padding: 10px;
            color: #FFF;
            text-align: center;
            font-family: 'DM Sans', sans-serif;
            font-style: normal;
            font-weight: 500;
            font-size: 14px;
            line-height: 17px;
        }

        .user-dashboard #list-messages {
            overflow-x: scroll;
        }

        ::-webkit-scrollbar {
            width: 0.5em;
            height: 0.5em;
        }

        ::-webkit-scrollbar-thumb {
            background-color: #2B2842;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-track {
            background-color: #007ac1;
        }

        .dark-blue-btn {
            background: #2B2842;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 700;
            font-size: 15px;
            line-height: 23px;
            padding: 17.5px 44.5px;
            color: #fff;
            transition: all 0.3s ease 0s;
            background-image: linear-gradient(to right, #2B2842, #2B2842, #007ac1, #007ac1);
            background-size: 300% 100%;
            moz-transition: all .4s ease-in-out;
            -o-transition: all .4s ease-in-out;
            -webkit-transition: all .4s ease-in-out;
            transition: all .4s ease-in-out;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
        }

        #list-settings .dark-blue-btn {
            padding: 10px 17px;
        }

        .dark-blue-btn:hover {
            color: #fFF;
            background-position: 99% 0;
            border-color: #007ac1;
            moz-transition: all .4s ease-in-out;
            -o-transition: all .4s ease-in-out;
            -webkit-transition: all .4s ease-in-out;
            transition: all .4s ease-in-out;
        }
        .pink-blue-grad-button {
            padding: 10px 30px;
            text-decoration: none;
            font-size: 15px;
            /* margin: 15px 15px; */
            border-radius: 10px;
            background-image: linear-gradient(to right, #2b2842, #007ac1, #2b2842, #007ac1);
            color: #f4f4f4;
            background-size: 300% 100%;
            moz-transition: all 0.4s ease-in-out;
            -o-transition: all 0.4s ease-in-out;
            -webkit-transition: all 0.4s ease-in-out;
            transition: all 0.4s ease-in-out;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
            cursor: pointer;
        }

        .pink-blue-grad-button:hover {
            color: #f4f4f4;
            background-position: 99% 0;
            moz-transition: all 0.4s ease-in-out;
            -o-transition: all 0.4s ease-in-out;
            -webkit-transition: all 0.4s ease-in-out;
            transition: all 0.4s ease-in-out;
        }
    </style>
@endsection
@section('content')
    @php $user = auth()->user(); @endphp
    <div class="user-dashboard cust-page-padding">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                    <div class="list-group user-dashboard-list-grp" id="list-tab" role="tablist">
                        <a class="list-group-item list-group-item-action active show" id="list-home-list" data-toggle="list"
                            href="#list-home" role="tab" aria-controls="list-home" aria-selected="true"
                            onclick="showTab(event, 'list-home')">Dashboard</a>
                        {{-- <a class="list-group-item list-group-item-action" id="list-profile-list" data-toggle="list" href="#wallet" role="tab" aria-controls="list-profile" aria-selected="false">Wallet</a> --}}
                        <a class="list-group-item list-group-item-action" id="list-profile-list" data-toggle="list"
                            href="#wallet" role="tab" aria-controls="list-profile" aria-selected="false"
                            onclick="showTab(event, 'wallet')">Wallet</a>
                        <a class="list-group-item list-group-item-action" id="list-profile-list" data-toggle="list"
                            href="#list-profile" role="tab" onclick="showTab(event, 'list-profile')"
                            aria-controls="list-profile" aria-selected="false">Orders</a>
                        <a class="list-group-item list-group-item-action" id="list-messages-list" data-toggle="list"
                            href="#list-messages" role="tab" aria-controls="list-messages"
                            onclick="showTab(event, 'list-messages')"aria-selected="false">Downloads</a>
                        <a class="list-group-item list-group-item-action" id="list-support-list" data-toggle="list"
                            href="#list-support" role="tab" aria-controls="list-support"
                            onclick="showTab(event, 'list-support')"aria-selected="false">Support</a>
                        <a class="list-group-item list-group-item-action" id="list-profile-list" data-toggle="list"
                            href="#transaction" role="tab" aria-controls="list-profile"
                            onclick="showTab(event, 'transaction')"aria-selected="false">Transaction History</a>
                        <a class="list-group-item list-group-item-action" id="list-profile-list" data-toggle="list"
                            href="#wooOrderHistory" role="tab" aria-controls="list-profile"
                            onclick="showTab(event, 'wooOrderHistory')"aria-selected="false">WooCommerce Order History</a>
                        <a class="list-group-item list-group-item-action" id="list-profile-list" data-toggle="list"
                            href="#wooUser" role="tab" aria-controls="list-profile"
                            onclick="showTab(event, 'wooUser')"aria-selected="false">WooCommerce Users</a>
                        <a class="list-group-item list-group-item-action" id="list-settings-list" data-toggle="list"
                            href="#list-settings" role="tab" aria-controls="list-settings"
                            onclick="showTab(event, 'list-settings')"aria-selected="false">Profile Settings</a>
                        <a class="list-group-item list-group-item-action" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                    </div>
                </div>
                <div class="col-xl=8 col-lg-8 col-md-12 col-sm-12 col-12 dashboard-contect">
                    <div class="tab-content border rounded" id="nav-tabContent">
                        <!-- dashboard -->
                        <div class="tab-pane fade active show" id="list-home" role="tabpanel"
                            aria-labelledby="list-home-list">
                            @php $name = $user['fname'] .' '. $user['lname']; @endphp
                            <h4 class="mb-4">Hello {{ $name ?? '' }}</h4>
                            <p>Not {{ $name ?? '' }} ? <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">logout</a>
                            </p>
                            <p>From your account dashboard you can view your recent orders, manage and download the key and
                                files , and edit your password and account details.</p>
                        </div>
                        <!-- wallet -->
                        <div class="tab-pane fade d-none" id="wallet" role="tabpanel"
                            aria-labelledby="list-profile-list">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <h4 class="mb-4">Wallet</h4>
                                    <div class="row">
                                        <div class="col-lg-4 col-md-6 col-sm-6">
                                            <div class="card card-icon mb-4">
                                                <div class="card-body text-center">
                                                    <i class="i-Money-2" style="font-weight: 500 !important;"></i>
                                                    <p class="text-muted mt-2 mb-2">Current Wallet Amount</p>
                                                    <p class="text-primary text-24 line-height-1 m-0">
                                                        {{ $wallet->wallet_amount ?? '0' }} ₹</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-sm-6">
                                            <div class="card card-icon mb-4">
                                                <div class="card-body text-center">
                                                    <i class="i-Checkout-Basket" style="font-weight: 500 !important;"></i>
                                                    <p class="text-muted mt-2 mb-2">Total Orders</p>
                                                    <p class="text-primary text-24 line-height-1 m-0">
                                                        {{ $wallet->total_order ?? '0' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-sm-6">
                                            <div class="card card-icon mb-4">
                                                <div class="card-body text-center">
                                                    <i class="i-Financial" style="font-weight: 500 !important;"></i>
                                                    <p class="text-muted mt-2 mb-2">Remaining Orders</p>
                                                    <p class="text-primary text-24 line-height-1 m-0">
                                                        {{ $wallet->remaining_order ?? '0' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 border-top pt-4">
                                    <h4 class="mb-4">Topup Your Wallet</h4>
                                    <?php
                                    $currency = $_COOKIE['currency'] ?? '';
                                    $plan = '';
                                    $min_amount = 1;
                                    if ($wallet) {
                                        // $plan = \App\Models\Plan::where('id', $wallet->product_id)->first();
                                        // $min_amount = $plan->yearly_price;
                                    }
                                    ?>
                                    @if ($wallet)
                                        <div class="form-group">
                                            <label for="plan">Select Plan</label>
                                            <div class="plan_select_btn">
                                                @if ($allplan)
                                                    @foreach ($allplan as $key => $plan)
                                                        <div class="wallet_plan_radio_button"
                                                            style="@if (6 == $plan->id && 6 == $wallet->product_id) {{ 'display:block;' }} @endif ">
                                                            <input type="radio" id="{{ $plan->product_name ?? '' }}"
                                                                data-min-amount="{{ $plan->yearly_price ?? '' }}"
                                                                name="product_ids" value="{{ $plan->id ?? '' }}"
                                                                @if ($wallet->product_id == $plan->id) {{ 'checked' }} data-current="yes" @else data-current="no" @endif />
                                                            <label for="starter">{{ $plan->product_name ?? '' }}</label>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <p id="plan_error" class="error"></p>
                                        </div>
                                        <div class="form-group">
                                            <label for="amount">Enter Amount for Recharge Wallet</label>
                                            <input type="number" name="amount" id="amount" class="form-control"
                                                placeholder="Enter Amount to Recharge Wallet" autocomplete="off">
                                            <p class="error" id="amount_error"></p>
                                        </div>
                                        <h4 class="mb-3">Select Payment Method</h4>
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                               <li class="nav-item">
                                                <a class="nav-link" id="home-basic-tab" data-toggle="tab" href="#razorpayPayment" role="tab" aria-controls="razorpayPayment" aria-selected="true">RazorPay</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link active show" id="profile-basic-tab" data-toggle="tab"
                                                    href="#stripePayment" onclick="showTab(event, 'stripePayment')"
                                                    role="tab" aria-controls="stripePayment"
                                                    aria-selected="false">Stripe</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content" id="myTabContent">
                                             <div class="tab-pane fade" id="razorpayPayment" role="tabpanel" aria-labelledby="home-icon-pill">
                                                <form action="{{ route('razorpay-payment-store') }}" method="POST" class="razropay_form">
                                                    @csrf
                                                    <input type="hidden" name="product_id" id="product_id" value="">
                                                    <input type="hidden" name="name" id="username" value="{{ $user['name'] ?? '' }}">
                                                    <input type="hidden" name="useremail" id="useremail" value="{{ $user['email'] ?? '' }}">
                                                    <input type="hidden" name="usercontact" id="usercontact" value="{{ $user['contact'] ?? '' }}">
                                                    <input type="hidden" name="userrazorpayid" id="userrazorpayid" value="{{ $user['razorpay_customer_id'] ?? '' }}">
                                                    <input type="hidden" name="wallet_product_id" value="{{ $wallet->product_id ?? '' }}">
                                                    <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
                                                    <input type="hidden" name="currency" value="{{ $currency }}" id="currency">
                                                    <button class="pink_blue_grad_button d-inline-block border-0" id="rzp-button1">Proceed To Pay</button>            
                                                </form>
                                            </div>
                                            <div class="tab-pane fade d-none" id="stripePayment" role="tabpanel"
                                                aria-labelledby="profile-icon-pill">
                                                <form role="form" action="{{ route('stripe-payment-store') }}"
                                                    method="post" class="require-validation" data-cc-on-file="false"
                                                    data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"
                                                    id="stripe-form">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="">
                                                    <input type="hidden" name="amount" value=""
                                                        id="stripe_amount">
                                                    <input type="hidden" name="is_discount_applied"
                                                        id="is_discount_applied" value="no">
                                                    <div class='form-row row'>
                                                        <div class='col-md-12 form-group'>
                                                            <label class='control-label'>Name on Card</label>
                                                            <input class='form-control' size='4' type='text'
                                                                id="name_on_card" required>
                                                        </div>
                                                    </div>
                                                    <div class='form-row row'>
                                                        <div class='col-md-12 form-group'>
                                                            <label class='control-label'>Card Number</label>
                                                            <input autocomplete='off' class='form-control card-number'
                                                                id="card_number" name="card_number" size='20'
                                                                placeholder="xxxx xxxx xxxx xxxx" type='text' required>
                                                        </div>
                                                    </div>
                                                    <div class='form-row row'>
                                                        <div class='col-xs-12 col-md-4 form-group expiration'>
                                                            <label class='control-label'>Expiration Month</label>
                                                            <input class='form-control card-expiry-month' placeholder='MM'
                                                                id="card_exp_month" size='2' name="card_month"
                                                                type='text' required>
                                                        </div>
                                                        <div class='col-xs-12 col-md-4 form-group expiration required'>
                                                            <label class='control-label'>Expiration Year</label>
                                                            <input class='form-control card-expiry-year' placeholder='YY'
                                                                id="card_exp_year" size='4' name="card_year"
                                                                type='text' required>
                                                        </div>
                                                        <div class='col-xs-12 col-md-4 form-group cvc'>
                                                            <label class='control-label'>CVC</label>
                                                            <input autocomplete='off' class='form-control card-cvc'
                                                                id="card_cvc" name="card_cvc" placeholder='ex. 311'
                                                                size='4' type='text' required>
                                                        </div>
                                                    </div>
                                                    <p class="error" id="stripe_payment_error"></p>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <button class="pink-blue-grad-button d-inline-block border-0"
                                                                id="stripePayBtn" type="button">Proceed To Pay</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    @else
                                        <div class="form-group">
                                            <label for="plan">Select Plan</label>
                                            <div class="plan_select_btn">
                                                @if ($allplan)
                                                    @foreach ($allplan as $key => $plan)
                                                        <div class="wallet_plan_radio_button">
                                                            <input type="radio" id="{{ $plan->product_name ?? '' }}"
                                                                data-min-amount="{{ $plan->yearly_price ?? '' }}"
                                                                name="product_ids" value="{{ $plan->id ?? '' }}"
                                                                data-current="no" />
                                                            <label for="starter">{{ $plan->product_name ?? '' }}</label>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <p id="plan_error" class="error"></p>
                                        </div>
                                        <div class="form-group">
                                            <label for="amount">Enter Amount for Recharge Wallet</label>
                                            <input type="number" name="amount" id="amount" class="form-control"
                                                placeholder="Enter Amount to Recharge Wallet" autocomplete="off">
                                            <p class="error" id="amount_error"></p>
                                        </div>
                                        <h4 class="mb-3">Select Payment Method</h4>
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                             <li class="nav-item">
                                                <a class="nav-link" id="home-basic-tab" data-toggle="tab" href="#razorpayPayment" role="tab" aria-controls="razorpayPayment" aria-selected="true">RazorPay</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link active show" id="profile-basic-tab" data-toggle="tab"
                                                    href="#stripePayment" role="tab" aria-controls="stripePayment"
                                                    aria-selected="false">Stripe</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content" id="myTabContent">
                                             <div class="tab-pane fade" id="razorpayPayment" role="tabpanel" aria-labelledby="home-icon-pill">
                                                <form action="{{ route('razorpay-payment-store') }}" method="POST" class="razropay_form">
                                                    @csrf
                                                    <input type="hidden" name="product_id" id="product_id" value="">
                                                    <input type="hidden" name="name" id="username" value="{{ $user['name'] ?? '' }}">
                                                    <input type="hidden" name="useremail" id="useremail" value="{{ $user['email'] ?? '' }}">
                                                    <input type="hidden" name="usercontact" id="usercontact" value="{{ $user['contact'] ?? '' }}">
                                                    <input type="hidden" name="userrazorpayid" id="userrazorpayid" value="{{ $user['razorpay_customer_id'] ?? '' }}">
                                                    <input type="hidden" name="wallet_product_id" value="{{ $wallet->product_id ?? '' }}">
                                                    <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
                                                    <input type="hidden" name="currency" value="{{ $currency }}" id="currency">
                                                    <button class="pink_blue_grad_button d-inline-block border-0" id="rzp-button1">Proceed To Pay</button>            
                                                </form>
                                            </div>
                                            <div class="tab-pane fade d-none" id="stripePayment" role="tabpanel"
                                                aria-labelledby="profile-icon-pill">
                                                <form role="form" action="{{ route('stripe-payment-store') }}"
                                                    method="post" class="require-validation" data-cc-on-file="false"
                                                    data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"
                                                    id="stripe-form">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="">
                                                    <input type="hidden" name="amount" value=""
                                                        id="stripe_amount">
                                                    <input type="hidden" name="is_discount_applied"
                                                        id="is_discount_applied" value="no">
                                                    <div class='form-row row'>
                                                        <div class='col-md-12 form-group'>
                                                            <label class='control-label'>Name on Card</label>
                                                            <input class='form-control' size='4' type='text'
                                                                id="name_on_card" required>
                                                        </div>
                                                    </div>
                                                    <div class='form-row row'>
                                                        <div class='col-md-12 form-group'>
                                                            <label class='control-label'>Card Number</label>
                                                            <input autocomplete='off' class='form-control card-number'
                                                                id="card_number" name="card_number" size='20'
                                                                placeholder="xxxx xxxx xxxx xxxx" type='text' required>
                                                        </div>
                                                    </div>
                                                    <div class='form-row row'>
                                                        <div class='col-xs-12 col-md-4 form-group expiration'>
                                                            <label class='control-label'>Expiration Month</label>
                                                            <input class='form-control card-expiry-month' placeholder='MM'
                                                                id="card_exp_month" size='2' name="card_month"
                                                                type='text' required>
                                                        </div>
                                                        <div class='col-xs-12 col-md-4 form-group expiration required'>
                                                            <label class='control-label'>Expiration Year</label>
                                                            <input class='form-control card-expiry-year' placeholder='YY'
                                                                id="card_exp_year" size='4' name="card_year"
                                                                type='text' required>
                                                        </div>
                                                        <div class='col-xs-12 col-md-4 form-group cvc'>
                                                            <label class='control-label'>CVC</label>
                                                            <input autocomplete='off' class='form-control card-cvc'
                                                                id="card_cvc" name="card_cvc" placeholder='ex. 311'
                                                                size='4' type='text' required>
                                                        </div>
                                                    </div>
                                                    <p class="error" id="stripe_payment_error"></p>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <button class="pink-blue-grad-button d-inline-block border-0"
                                                                id="stripePayBtn" type="button">Proceed To Pay</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                </div> --}}
                                {{-- @endif --}}
                            </div>
                        </div>
                        <!-- orders -->
                        <div class="tab-pane fade d-none" id="list-profile" role="tabpanel"
                            aria-labelledby="list-profile-list">
                            <h4 class="mb-4">ALL Orders</h4>                            
                            @if ($orders->count() > 0)
                                <div class="accordion" id="accordionRightIcon">
                                    @foreach ($orders as $order)
                                        <div class="card ">
                                            <div class="card-header header-elements-inline">
                                                <h6
                                                    class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0 w-100">
                                                    <a data-toggle="collapse" class="text-default"
                                                        href="#accordion-item-icon-right-{{ $order->id ?? '' }}"
                                                        aria-expanded="false">
                                                        <div class="d-flex">
                                                            <div class="w-50 text-left text-white">
                                                                {{ $order->product->product_name ?? '' }}</div>
                                                            <div class="w-50 text-right mr-5 text-white">OrderId:
                                                                #{{ $order->id ?? '' }}</div>
                                                        </div>
                                                    </a>
                                                </h6>
                                            </div>
                                            <div id="accordion-item-icon-right-{{ $order->id ?? '' }}"
                                                class="collapse show" data-parent="#accordionRightIcon" style="">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="d-flex">
                                                                <div class="w-25">
                                                                    <p>Order Id:</p>
                                                                </div>
                                                                <div class="w-75">
                                                                    <p>#{{ $order->id ?? '' }}</p>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex">
                                                                <div class="w-25">
                                                                    <p>Product:</p>
                                                                </div>
                                                                <div class="w-75">
                                                                    <p> <img width="70px"
                                                                            src="{{ asset('storage/plan/' . $order->product->created_by . '/' . $order->product->id . '/' . $order->product->thumbnail) }}"
                                                                            alt="{{ $order->product->product_name ?? '' }}">
                                                                        {{ $order->product->product_name ?? '' }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="d-flex">
                                                                <div class="w-25">
                                                                    <p>Product File:</p>
                                                                </div>
                                                                <div class="w-75">
                                                                    <a href="{{ asset('storage/plan/' . $order->product->created_by . '/' . $order->product->id . '/' . $order->product->main_file) }}"
                                                                        download="{{ $order->product->product_name ?? '' }}">Click
                                                                        Here To Download</a>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex">
                                                                <div class="w-25">
                                                                    <p>Product Key:</p>
                                                                </div>
                                                                <div class="w-75">
                                                                    <p class="copy-text">{{ $order->key->key ?? '' }}
                                                                        <button class="btn-copy"
                                                                            onclick="copy('{{ $order->key->key ?? '' }}','#copy_button_{{ $order->id }}')"
                                                                            id="copy_button_{{ $order->id }}"><img
                                                                                src="{{ asset('storage/Logo_Settings/copy_pic.png') }}"
                                                                                alt=""></button></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="d-inline-block mr-4">No Orders Found</p>
                                <a href="{{ url('/') }}" class="btn-dark-blue d-inline-block"><i
                                        class="nav-icon i-Left" aria-hidden="true"> </i> &nbsp; Continue Shopping</a>
                            @endif
                        </div>
                        <!-- downloads -->
                        <div class="tab-pane fade d-none" id="list-messages" role="tabpanel"
                            aria-labelledby="list-messages-list">
                            <h4 class="mb-4">Downloads</h4>
                            @if ($orders->count() > 0)
                                <table class="display table table-striped table-bordered dataTable data-table"
                                    style="width:100%" role="grid" aria-describedby="zero_configuration_table_info">
                                    <thead>
                                        <tr role="row">
                                            <th>Order Id</th>
                                            <th>Product Key</th>
                                            <th>Product File</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $order)
                                            <tr role="row">
                                                <td>#{{ $order->id ?? '' }}</td>
                                                <td>{{ $order->key->key ?? '' }}</td>
                                                <td><a href="{{ asset('storage/plan/' . $order->product->created_by . '/' . $order->product->id . '/' . $order->product->main_file) }}"
                                                        download="{{ $order->product->product_name ?? '' }}">Download</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr role="row">
                                            <th>Order Id</th>
                                            <th>Product Key</th>
                                            <th>Product File</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            @else
                                <p class="d-inline-block mr-4">No Downloads Found</p>
                                <a href="{{ url('/') }}" class="btn-dark-blue d-inline-block"><i
                                        class="nav-icon i-Left" aria-hidden="true"> </i> &nbsp; Browse Products</a>
                            @endif
                        </div>
                        <!-- support -->
                        <div class="tab-pane fade d-none" id="list-support" role="tabpanel"
                            aria-labelledby="list-support-list">
                            <h4 class="mb-4">Support</h4>
                            @if ($wallet)
                                @if ($wallet->product_id && $wallet->product_id == 1)
                                    <p>Need Support? Contact us at <a
                                            href="mailto:support@skyfinity.co.in">support@skyfinity.co.in</a> for
                                        assistance.
                                    </p>
                                @elseif($wallet->product_id && $wallet->product_id == 2)
                                    <p>Feel free to reach out to us via email at <a href="mailto:support@skyfinity.co.in">
                                            support@skyfinity.co.in </a> or give us a call at <a href="tel:+916359389818">
                                            +91-6359389818 </a> . Our dedicated support team is ready to assist you.</p>
                                    <p>Please note that the estimated waiting time for support is approximately 30 minutes.
                                    </p>
                                @elseif(($wallet->product_id && $wallet->product_id == 3) || ($wallet->product_id && $wallet->product_id == 6))
                                    <p>Feel free to reach out to us via email at <a href="mailto:support@skyfinity.co.in">
                                            support@skyfinity.co.in </a> or give us a call at <a href="tel:+916359389818">
                                            +91-6359389818 </a> . Our dedicated support team is ready to assist you.</p>
                                    <p>We are here to assist you promptly and provide immediate support without any waiting
                                        time.</p>
                                @endif
                            @else
                                <p class="d-inline-block mr-4">Please Topup Your Wallte For Suppot</p>
                            @endif
                        </div>
                        <!-- transaction -->
                        <div class="tab-pane fade d-none" id="transaction" role="tabpanel"
                            aria-labelledby="list-profile-list">
                            <h4 class="mb-4">Payment History</h4>
                            <table class="display table table-striped table-bordered transacion_history_tbl data-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Payment Status</th>
                                        <th>Payment Amount</th>
                                        <th>Payment Date</th>
                                        <th>Plan</th>
                                        <th>Payment Id</th>
                                        <th>Payment Method</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($transactions)
                                        @foreach ($transactions as $key => $tran)
                                            <tr>
                                                <td> {{ $key + 1 }} </td>
                                                <td> {{ $tran->payment_status ? ($tran->payment_status == 'captured' ? 'Success' : $tran->payment_status) : '' }}
                                                </td>
                                                <td> {{ $tran->payment_amount ?? '' }} </td>
                                                <td> {{ Helper::dateFormatForView($tran->created_at) ?? '' }} </td>
                                                <td>{{ $tran->product->product_name ?? '' }}</td>
                                                <td> {{ $tran->razorpay_payment_id ?? '' }} </td>
                                                <td> {{ $tran->payment_method ?? '' }} </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Payment Status</th>
                                        <th>Payment Amount</th>
                                        <th>Payment Date</th>
                                        <th>Plan</th>
                                        <th>Payment Id</th>
                                        <th>Payment Method</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- Woo Order History -->
                        <div class="tab-pane fade d-none" id="wooOrderHistory" role="tabpanel"
                            aria-labelledby="list-profile-list">
                            <h4 class="mb-4">WooCommerce Order History</h4>
                            <table class="display table table-striped table-bordered data-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Order Id</th>
                                        <th>Order Total</th>
                                        <th>Order Date</th>
                                        <th>Order URL</th>
                                        <th>Per Order Charge</th>
                                        <th>Remaining Amount Wallet</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($order_history)
                                        @foreach ($order_history as $key => $list)
                                            <tr>
                                                <td> {{ $key + 1 }} </td>
                                                <td> {{ $list->woocommerce_order_id ?? '' }} </td>
                                                <td> {{ $list->woocommerce_order_total ?? '' }} </td>
                                                <td> {{ Helper::dateFormatForView($list->woocommerce_order_date) ?? '' }}
                                                </td>
                                                <td> {{ $list->woocommerce_order_url ?? '' }} </td>
                                                <td> {{ $list->per_order_price ?? '' }} </td>
                                                <td> {{ $list->remaining_wallet_amount ?? '' }} </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Order Id</th>
                                        <th>Order Total</th>
                                        <th>Order Date</th>
                                        <th>Order URL</th>
                                        <th>Per Order Charge</th>
                                        <th>Remaining Amount Wallet</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- Woo user customer -->
                        <div class="tab-pane fade d-none" id="wooUser" role="tabpanel"
                            aria-labelledby="list-profile-list">
                            <h4 class="mb-4">WooCommerce User</h4>
                            <table class="display table table-striped table-bordered data-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>Site URL</th>
                                        <th>Register Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($woo_user)
                                        @foreach ($woo_user as $key => $list)
                                            <tr>
                                                <td> {{ $key + 1 }} </td>
                                                <td> {{ $list->email ?? '' }} </td>
                                                <td> {{ $list->contact_number ?? '' }} </td>
                                                <td> {{ $list->site_url ?? '' }} </td>
                                                <td> {{ Helper::dateFormatForView($list->created_at) ?? '' }} </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>Site URL</th>
                                        <th>Register Date</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- update password -->
                        <div class="tab-pane fade d-none" id="list-settings" role="tabpanel"
                            aria-labelledby="list-settings-list">
                            <h4 class="mb-4">Update Password</h4>
                            <form class="form-horizontal" method="POST" action="{{ route('changePasswordPost') }}">
                                @if (session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif
                                @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                @if ($errors)
                                    @foreach ($errors->all() as $error)
                                        <div class="alert alert-danger">{{ $error }}</div>
                                    @endforeach
                                @endif
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label for="fname">Current Password</label>
                                        <input id="current-password" type="password" class="form-control"
                                            name="current-password" placeholder="Enter Current Password" required>
                                        @if ($errors->has('current-password'))
                                            <div class="error" style="color:red;">
                                                {{ $errors->first('current-password') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <label for="lname">New Password</label>
                                        <input id="new-password" type="password" class="form-control"
                                            name="new-password" placeholder="Enter New Password" required>
                                        @if ($errors->has('new-password'))
                                            <div class="error" style="color:red;">
                                                {{ $errors->first('new-password') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <label for="lname">Confirm New Password</label>
                                        <input id="new-password-confirm" type="password" class="form-control"
                                            name="new-password_confirmation" placeholder="Re-Enter New Password" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn dark-blue-btn my-4"> Update Password</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatables.script.js') }}"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        $(document).ready(function() {
            $('.data-table').DataTable();
        });

        function copy(text, target) {
            setTimeout(function() {
                $('#copied_tip').remove();
            }, 800);

            $(target).append("<div class='tip' id='copied_tip'>Copied!</div>");

            var input = document.createElement('input');
            input.setAttribute('value', text);
            document.body.appendChild(input);
            input.select();
            var result = document.execCommand('copy');
            document.body.removeChild(input)
            return result;
        }
        // set the product id value
        $(document).ready(function() {
            var initialValue = $('input[name="product_ids"]:checked').val();
            $('input[type="hidden"][name="product_id"]').val(initialValue);
            // Handle radio button change event
            $('input[name="product_ids"]').change(function() {
                var selectedValue = $(this).val();
                $('input[type="hidden"][name="product_id"]').val(selectedValue);
            });
        });

        var currenMinValue = $('.plan_select_btn input[data-current="yes"]').data('min-amount');
        if (currenMinValue === 0) {
            $('#amount').val(currenMinValue).prop('disabled', true);
        }
        // amount field enable-disable based on the condition
        $('input[name="product_ids"]').change(function() {
            let product_ids = $('input[name="product_ids"]:checked').val();
            let min_amount = $(this).data('min-amount');
            let current = $(this).data('current');
            let currency = $('#currency').val();

            if (current === 'no' || min_amount === 0) {
                $('#amount').val(min_amount).prop('disabled', true);
                $('#rzp-button1').text('Proceed To Pay ' + min_amount + ' ' + currency);
                $('#stripePayBtn').text('Proceed To Pay ' + min_amount + ' ' + currency);
            } else {
                $('#amount').val('').prop('disabled', false);
                $('#rzp-button1').text('Proceed To Pay');
                $('#stripePayBtn').text('Proceed To Pay');
            }
        });
        // button key down change butoon text for amount and currency
        $('#amount').on('keyup', function() {
            let amount = $(this).val();
            let currency = $('#currency').val();
            $('#rzp-button1').text('Proceed To Pay ' + amount + ' ' + currency);
            $('#stripePayBtn').text('Proceed To Pay ' + amount + ' ' + currency);
        });
        // click on razorpay payment button to open razorapy paymennt popup
        $('#rzp-button1').click(function(e) {
            e.preventDefault();
            // condition for the any plan not selected and direct try to topup from wallet
            if ($('input[type="radio"]').filter('[data-current="yes"]').length == 0) {
                if ($('#amount').val() === "0") {
                    var product_ids = $('input[type="radio"]:checked').val();
                    freeplancreate(product_ids);
                } else {
                    $('#plan_error').text('');
                    if (!$('input[name="product_ids"]').is(':checked')) {
                        $('#plan_error').text('Please Select Plan To Topup');
                    } else if (!$('#amount').val()) {
                        $('#amount_error').text('Please Enter Amount To Pay');
                    } else {
                        $('.error').text('');
                        let name = $('#username').val();
                        let email = $('#useremail').val();
                        let contact = $('#usercontact').val();
                        let razorpay_customer_id = $('#userrazorpayid').val();
                        let amount = $('#amount').val();
                        let currency = $('#currency').val();

                        openRazorpayPopup(name, email, contact, razorpay_customer_id, amount, currency);
                    }
                }
            }
            // condition already any one plan is selected and try to topup from wallet
            else {
                if ($('#amount').val() === "0") {
                    $('#amount_error').text(
                        'Since you already have an existing plan, please select a different plan. The free plan is not available for selection.'
                    );
                } else {
                    $('#plan_error').text('');
                    if (!$('input[name="product_ids"]').is(':checked')) {
                        $('#plan_error').text('Please Select Plan To Topup');
                    } else if (!$('#amount').val()) {
                        $('#amount_error').text('Please Enter Amount To Pay');
                    } else {
                        $('.error').text('');
                        let name = $('#username').val();
                        let email = $('#useremail').val();
                        let contact = $('#usercontact').val();
                        let razorpay_customer_id = $('#userrazorpayid').val();
                        let amount = $('#amount').val();
                        let currency = $('#currency').val();

                        openRazorpayPopup(name, email, contact, razorpay_customer_id, amount, currency);
                    }
                }
            }
        });
        // function for razorpay payment 
        function openRazorpayPopup(name, email, contact, razorpay_customer_id, amount, currency) {
            var options = {
                key: "{{ env('RAZORPAY_KEY') }}",
                amount: amount * 100,
                currency: currency,
                name: "Skyfinity Quick Checkout",
                description: "Payment For The Topup of Skyfinity Quick Checkout Wallet",
                image: "{{ asset('front-end/images/header_logo.png') }}",
                prefill: {
                    name: name,
                    email: email,
                    contact: contact
                },
                customer_id: razorpay_customer_id,
                theme: {
                    color: "#2B2842"
                },
                handler: function(response) {
                    $('#razorpay_payment_id').val(response.razorpay_payment_id);
                    $('.razropay_form').submit();
                    $('#preloader').show();
                }
            };

            var razorpayPopup = new Razorpay(options);
            razorpayPopup.open();
        }
        // functuin for freeplan creation
        function freeplancreate(product_id) {
            $('#preloader').show();
            $.ajax({
                url: "{{ route('razorpay-free-plan-store') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    product_id: product_id,
                },
                dataType: 'json',
                success: function(response) {
                    if (response.error) {
                        $('#preloader').hide();
                        $("#plan_error").text(response.error);
                    }
                    if (response.success) {
                        let order_id = response.order_id;
                        var page = `{{ route('thankyou', ['order_id' => ':order_id']) }}`;
                        page = page.replace(':order_id', order_id);
                        location.href = page;
                    }
                }
            });
        }
        // for clicling the wallet tab when found hash in url
        const hash = window.location.hash;
        if (hash === '#wallet') {
            document.getElementById('list-profile-list').click();
        }
    </script>
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script>
        $('#stripePayBtn').click(function(e) {
            e.preventDefault();
            // condition for the any plan not selected and direct try to topup from wallet
            if ($('input[type="radio"]').filter('[data-current="yes"]').length == 0) {
                if ($('#amount').val() === "0") {
                    var product_ids = $('input[type="radio"]:checked').val();
                    freeplancreate(product_ids);
                } else {
                    $('#plan_error').text('');
                    if (!$('input[name="product_ids"]').is(':checked')) {
                        $('#plan_error').text('Please Select Plan To Topup');
                    } else if (!$('#amount').val()) {
                        $('#amount_error').text('Please Enter Amount To Pay');
                    } else {
                        let name_on_card = $('#name_on_card').val();
                        let card_number = $('#card_number').val();
                        let card_cvc = $('#card_cvc').val();
                        let card_exp_month = $('#card_exp_month').val();
                        let card_exp_year = $('#card_exp_year').val();

                        Stripe.setPublishableKey($('.require-validation').data('stripe-publishable-key'));
                        Stripe.createToken({
                            number: card_number,
                            cvc: card_cvc,
                            exp_month: card_exp_month,
                            exp_year: card_exp_year,
                        }, stripeResponseHandlernew);
                        var errorMessage = $('#stripe_payment_error').text();
                    }
                }
            }
            // condition already any one plan is selected and try to topup from wallet
            else {
                if ($('#amount').val() === "0") {
                    $('#amount_error').text(
                        'Since you already have an existing plan, please select a different plan. The free plan is not available for selection.'
                    );
                } else {
                    $('#plan_error').text('');
                    if (!$('input[name="product_ids"]').is(':checked')) {
                        $('#plan_error').text('Please Select Plan To Topup');
                    } else if (!$('#amount').val()) {
                        $('#amount_error').text('Please Enter Amount To Pay');
                    } else {
                        let name_on_card = $('#name_on_card').val();
                        let card_number = $('#card_number').val();
                        let card_cvc = $('#card_cvc').val();
                        let card_exp_month = $('#card_exp_month').val();
                        let card_exp_year = $('#card_exp_year').val();

                        Stripe.setPublishableKey($('.require-validation').data('stripe-publishable-key'));
                        Stripe.createToken({
                            number: card_number,
                            cvc: card_cvc,
                            exp_month: card_exp_month,
                            exp_year: card_exp_year,
                        }, stripeResponseHandlernew);
                        var errorMessage = $('#stripe_payment_error').text();
                    }
                }
            }
        });

        function stripeResponseHandlernew(status, response) {
            var $form = $(".require-validation");
            if (response.error) {
                $('#stripe_payment_error').text(response.error.message);
            } else {
                $('#stripe_payment_error').text('');
                var token = response['id'];
                $form.find('input[type=text]').empty();
                $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                let final_amoumnt = $('#amount').val();
                $('#stripe_amount').val(final_amoumnt);
                $('#preloader').show();
                $(".require-validation").submit();
            }
        }

        function showTab(event, tabId) {
            // Remove active classes from all tabs and tab content
            document.querySelectorAll('.list-group-item-action').forEach(item => {
                item.classList.remove('active');
            });

            document.querySelectorAll('.tab-pane').forEach(item => {
                item.classList.remove('active', 'show');
                item.classList.add('d-none');  // Ensure content is hidden initially
            });

            // Add active class to the clicked tab
            event.currentTarget.classList.add('active');

            // Show the corresponding tab content
            var tabContent = document.getElementById(tabId);
            tabContent.classList.add('active', 'show');
            tabContent.classList.remove('d-none');

            // Check if the Wallet tab is shown and show Stripe Payment as well
            if (tabId === "wallet") {
                document.getElementById("stripePayment").classList.remove('d-none');
                document.getElementById("stripePayment").classList.add('active', 'show');
            }
        }

        // Check if the URL has the hash and trigger the tab
        document.addEventListener('DOMContentLoaded', function() {
            if (window.location.hash === "#list-settings") {
                // Trigger click on the corresponding tab link if URL contains #list-settings
                document.getElementById('list-settings-list').click();
            }

            // Optional: If the Forgot Password link is clicked, you can trigger the tab manually
            document.getElementById('forgot-password-link')?.addEventListener('click', function(e) {
                e.preventDefault();  // Prevent the default link behavior
                document.getElementById('list-settings-list').click();  // Trigger the list-settings tab
            });
        });



    </script>
@endsection
