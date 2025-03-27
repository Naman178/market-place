<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('front-end/css/mainstylesheet.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('front-end/css/home-page.css') }}">
    <link rel="stylesheet" href="{{ asset('front-end/css/checkout.css') }}">
    <link rel="stylesheet" href="{{ asset('front-end/css/home_page_responsive.css') }}">
    <!-- Toastr CSS (Toast notifications) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    

    <script src="{{ asset('front-end/js/jquery-3.3.1.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $seoData->description ?? 'Default description' }}">
    <meta name="keywords" content="{{ $seoData->keywords ?? 'default, keywords' }}">
    <meta property="og:title" content="{{ $seoData->title ?? 'Default Title' }}">
    <meta property="og:description" content="{{ $seoData->description ?? 'Default description' }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <title>Market Place | {{ $seoData->title ?? 'Default Title' }}</title>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">
    @php
    use App\Models\Category;
    use App\Models\SubCategory;
      $category = Category::where('sys_state','=','0')->first();
      $subcategory = SubCategory::where('sys_state','=','0')->first();
      $setting = \App\Models\Settings::where('key', 'site_setting')->first();
    @endphp
    <style>
        table.dataTable {
            width: 100% !important;
            border-collapse: collapse !important;
            margin: 20px 0 !important;
            font-size: 14px !important;
        }

        table.dataTable th {
            padding: 12px 15px !important;
            text-align: left !important;
        }
        .dataTables_empty{
            text-align: center !important;
        }
        table.dataTable td{
            padding: 12px 15px !important;
            text-align: left;
        }
        #DataTables_Table_0_info{
            display: flex !important;
            justify-content: space-between !important;
        }
        .dataTables_wrapper .dataTables_paginate {
            float: right  !important;
            text-align: right  !important;
            padding-top: .25em !important;
        }
        #DataTables_Table_0_paginate{
            display: flex !important;
            align-items: center !important;
            justify-content: end !important;
        }
        /* Table header styling */
        table.dataTable th {
            background-color: #0274b8 !important;
            color: white !important;
            font-weight: bold !important;
        }

        /* Zebra striping for rows */
        table.dataTable tr:nth-child(even) {
            background-color: #f9f9f9 !important;
        }

        table.dataTable tr:hover {
            background-color: #f1f1f1 !important;
        }

        /* Style search input */
        .dataTables_filter input {
            border: 1px solid #ccc !important;
            padding: 5px 10px !important;
            border-radius: 4px !important;
            font-size: 14px !important;
        }
        .dataTables_filter label{
            display: flex !important;
            align-items: center !important;
            justify-content: end !important;
        }

        /* Style pagination buttons */
        /* .dataTables_paginate .paginate_button {
            border: 1px solid #fff  !important;
            color: #FFFFFF !important;
            background: #007AC1 !important;
        }
        .dataTables_paginate .paginate_button:hover {
            color: #007AC1 !important;
            background-color: #fff !important;
            border: 1px solid #007AC1  !important;
            transition: 0.5s !important;
        } */
         /* Apply common button styles to pagination buttons */
        .dataTables_paginate .paginate_button {
            position: relative !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 8px 15px !important;
            color: #007AC1 !important;
            font-size: 14px !important;
            text-decoration: none !important;
            border: 1px solid #91C9FF !important;
            overflow: hidden !important;
            cursor: pointer !important;
            white-space: nowrap !important;
            transition: all 0.3s ease-in-out !important;
        }

        /* SVG animation effect for pagination buttons */
        .dataTables_paginate .paginate_button svg {
            position: absolute;
            width: 100%;
            height: 100%;
            fill: none;
            stroke: #007AC1;
            stroke-width: 2;
            stroke-dasharray: 150 480;
            stroke-dashoffset: 150;
            transition: stroke-dashoffset 1s ease-in-out;
        }

        .dataTables_paginate .paginate_button:hover svg {
            stroke-dashoffset: -480;
        }
        /* Responsive Design */
        @media (max-width: 768px) {
            table.dataTable {
                font-size: 12px !important;
            }

            table.dataTable th, table.dataTable td {
                padding: 8px !important;
            }

            .dataTables_wrapper .dataTables_filter {
                margin-top: 10px !important;
            }
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled{
            color: #007AC1 !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover{
            color: #007AC1 !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current, .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover{
            background: #fff !important;
            color: #007AC1 !important;
        }
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
            bottom: -7px;
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

        .wsus__profile_header {
            background-position: center !important;
            background-size: cover !important;
            background-repeat: no-repeat !important;
            padding: 100px 0;
        }

        .wsus__profile_header_text {
            position: relative;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            overflow: hidden;
        }

        .wsus__profile_header_text .img {
            width: 260px;
            height: 260px;
            border: 2px solid #fff;
            border-radius: 5px;
            margin-right: 45px;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            -ms-border-radius: 5px;
            -o-border-radius: 5px;
        }

        .wsus__profile_header_text .img img {
            border-radius: 5px;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            -ms-border-radius: 5px;
            -o-border-radius: 5px;
        }

        .wsus__profile_header_text .text {
            max-width: 60%;
            position: relative;
            z-index: 2;
        }

        .wsus__profile_header_text .text h2 {
            font-size: 35px;
            font-weight: 700;
            margin-bottom: 10px;
            color: #fff;
        }

        .wsus__profile_header_text .text .join {
            font-weight: 500;
            font-size: 20px;
            color: #fff;
            text-transform: capitalize;
        }

        .wsus__profile_header_text .text .join span {
            font-weight: 400;
            font-size: 20px;
            color: #fff;
            text-transform: capitalize;
        }

        .wsus__profile_header_text .text .skills {
            font-size: 18px;
            color: #fff;
            margin-bottom: 20px;
            border-top: 1px solid #DCDCDC;
            padding-top: 20px;
            margin-top: 20px;
        }

        .wsus__profile_header_text .rating {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            color: #fff;
            font-size: 14px;
            line-height: 24px;
        }

        .wsus__profile_header_text .rating span {
            color: #FFC107;
            display: inline-block;
            margin-right: 5px;
        }

        .wsus__profile_header_text .rating p {
            font-size: 18px;
            color: #fff;
        }

        .wsus__profile_header_text .header_button {
            position: absolute;
            right: 0;
            bottom: 25px;
        }

        .wsus__profile_header_text .header_button li {
            background: #679acb;
            border-radius: 5px;
            padding: 20px 40px;
            margin-left: 30px;
        }

        .wsus__profile_header_text .header_button li h4 {
            font-size: 25px;
            font-weight: 600;
            color: #fff;
            text-align: center;
            margin-bottom: 5px;
            display: block;
        }

        .wsus__profile_header_text .header_button li h4 i {
            margin-right: 5px;
        }

        .wsus__profile_header_text .header_button li p {
            font-size: 18px;
            color: #fff;
            text-transform: capitalize;
            text-align: center;
        }

        .header_menu {
            background: #fff;
            border: 1px solid #E9E9E9;
            border-radius: 5px;
            justify-content: space-around;
            margin-top: 40px;
            padding: 25px;
            margin-bottom: 30px;
            filter: drop-shadow(0px 25px 63px rgba(0, 0, 0, 0.05));
        }

        .header_menu {
            background: #fff;
            border: 1px solid #E9E9E9;
            border-radius: 5px;
            display: flex;
            flex-wrap: nowrap;
            justify-content: space-between;
            margin-top: 40px;
            padding: 10px 15px;
            margin-bottom: 30px;
            filter: drop-shadow(0px 25px 63px rgba(0, 0, 0, 0.05));
        }
        .header_menu li {
            flex-grow: 1;
            text-align: center;
            min-width: 140px;
        }
        .header_menu li a {
            font-weight: 500;
            font-size: 16px;
            color: #616161;
            border-bottom: 1px solid transparent;
            margin-bottom: -1px;
            padding: 10px 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            white-space: normal;
            line-height: 1.2;
            min-height: 50px;
        }
        .header_menu li a.active {
            color: #055BFF;
            border-color: #055BFF;
            /* display: inline-block;
            white-space: nowrap; */
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .header_menu li a:hover {
            color: #183EBD;
        }

        @media (max-width: 1024px) {
            .header_menu {
                flex-wrap: wrap;
            }
            .header_menu li {
                flex: 1 1 25%;
                min-width: auto;
            }
            .header_menu li a {
                font-size: 14px;
                padding: 8px 4px;
            }
        }
        .wsus__profile_overview {
            background: #ffffff;
            border-radius: 8px; 
            padding: 20px 30px; 
            box-shadow: none; border:1px dotted #0274b8;
            transition: all 0.3s ease; 
        }
        .wsus__profile_overview .accordion button{
            /* color:#fff; */
            padding: 5px 10px !important;
            background: #fff;
            cursor: pointer;
            /* border: 1px solid #263646; */
        }
        .dot_border{
            box-shadow: none; border:1px dotted #0274b8;
        }
        .accordion > .card{
            overflow: visible !important;
        }
        .cart-item-border{
            font-size: 15px;
            width: 160px; border:1px solid #0274b8; border-radius: 3px; padding: 3px; background-color: white; position: absolute; z-index: 1; top: -13px; left: 15px;
        }
        .badge-success {
            color: #fff;
            background-color: #28a745;
        }

        .badge {
            display: inline-block;
            padding: .25em .4em;
            font-size: 75%;
            font-weight: 700;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: .25rem;
        }
        .wsus__profile_overview h2 {
            font-weight: 700;
            font-size: 30px;
            margin-top: 35px;
        }

       .over-view  .wsus__profile_overview p {
            margin-top: 25px;
        }

        .wsus__profile_overview ul,
        .wsus__profile_overview ol {
            margin-top: 35px;
        }

        .wsus__profile_overview ul li,
        .wsus__profile_overview ol li {
            padding-left: 35px;
            color: #333333;
            font-weight: 400;
            font-size: 16px;
            margin-top: 15px;
            position: relative;
        }

        .wsus__profile_overview ul li::after,
        .wsus__profile_overview ol li::after {
            position: absolute;
            content: "";
            background: url(../images/check_icon_4.png);
            background-position: center;
            background-repeat: no-repeat;
            background-size: contain;
            width: 20px;
            height: 20px;
            top: 0;
            left: 0;
        }

        .container {
            max-width: 1320px;
        }

        .text-white {
            color: #fff !important;
        }

        .font-weight-bold {
            font-weight: 700 !important;
        }
        @media (max-width: 1024px) {
            .wsus__profile_header_text .rating p {
                font-size: 15px;
            }
        }
        @media (max-width: 991px) {
            .wsus__profile_header_text .header_button {
                position: relative;
                padding: 0;
            }
            .wsus__profile_header_text .header_button li{
                margin-left: 0;
                margin-top: 10px;
            }
            .accordion .mb-0{
                margin-bottom: 15px !important;
            }
        }
    </style>
</head>
<body>
    @include('front-end.common.header')

    <!-- Profile Header -->
    <div class="wsus__profile_header" style="background: #0274b8;">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="wsus__profile_header_text">
                        <div class="img">
                            @if (empty(auth()->user()->profile_pic) || auth()->user()->profile_pic == null)
                                @php
                                    $names = explode(' ', auth()->user()->name);
                                    $initials = '';
                                    foreach ($names as $name) {
                                        $initials .= strtoupper(substr($name, 0, 1));
                                    }
                                @endphp
                                <div class="rounded-full bg-gray-200 d-flex items-center justify-content-center text-gray-700 mr-2 w-100 h-100 dashboard_initial" title="{{ auth()->user()->name }}">
                                    {{ $initials ?: strtoupper(implode('', array_map(function($namePart) { return $namePart[0]; }, explode(' ', auth()->user()->name)))) }}
                                </div>
                            @else
                                @php
                                    // Check if the profile picture is a Google URL or local file
                                    $profilePic = filter_var(auth()->user()->profile_pic, FILTER_VALIDATE_URL) 
                                                ? auth()->user()->profile_pic 
                                                : asset('assets/images/faces/' . auth()->user()->profile_pic);
                                @endphp
                                <img src="{{ $profilePic }}" alt="profile" class="rounded-full w-100 h-100">
                            @endif
                        </div>
                        <div class="text">
                            <h2>{{ auth()->user()->name }}</h2>
                            <p class="join"><span>Joined:</span> {{ auth()->user()->created_at->format('M d, Y') }}</p>
                            <p class="skill text-white">
                                Not {{ auth()->user()->name }} ? 
                                <a class="text-white font-weight-bold" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                            </p>
                            <div class="rating">
                                <p>Manage your account, orders, downloads, and more from here.</p>
                            </div>
                        </div>
                        <ul class="header_button d-flex flex-wrap">
                            <li>
                                <h4><i class="fa fa-box"></i> {{ \App\Models\Order::where('user_id', auth()->id())->count() }}</h4>
                                <p>Total Products</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Menu -->
    <div class="container mb-5">
        <ul class="header_menu d-flex flex-wrap">
            <li><a href="{{ route('user-dashboard') }}" class="{{ request()->is('user-dashboard') ? 'active' : '' }}">Dashboard</a></li>
            <li><a href="{{ route('orders') }}" class="{{ request()->is('orders') ? 'active' : '' }}">Orders</a></li>
            <li><a href="{{ route('downloads') }}" class="{{ request()->is('downloads') ? 'active' : '' }}">Downloads</a></li>
            <li><a href="{{ route('support') }}" class="{{ request()->is('support') ? 'active' : '' }}">Support</a></li>
            <li><a href="{{ route('transactions') }}" class="{{ request()->is('transactions') ? 'active' : '' }}">Transactions</a></li>
            <li><a href="{{ route('invoice') }}" class="{{ request()->is('invoice') ? 'active' : '' }}">Invoice</a></li>
            <li><a href="{{ route('subscription') }}" class="{{ request()->is('subscription') ? 'active' : '' }}">Subscription</a></li>
            <li><a href="{{ route('profile-settings') }}" class="{{ request()->is('profile-settings') ? 'active' : '' }}">Settings</a></li>
            <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
        </ul>
    </div>

    <!-- Page Content -->
    <div class="container">
        @yield('content')
    </div>
    @include('front-end.common.footer')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- Toastr JS (Toast notifications) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <script>
        @if(Session::has('success'))
            toastr.success("{{ Session::get('success') }}");
        @elseif(Session::has('error'))
            toastr.error("{{ Session::get('error') }}");
        @elseif(Session::has('info'))
            toastr.info("{{ Session::get('info') }}");
        @elseif(Session::has('warning'))
            toastr.warning("{{ Session::get('warning') }}");
        @endif
    </script>   
    <script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatables.script.js') }}"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Include DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
    //   $(document).ready(function () {
    //         $('.data-table').DataTable({
    //             "responsive": true,
    //             "lengthChange": false,
    //             "searching": true,
    //             "paging": true,
    //             "info": true
    //         });

    //         // Set initial color
    //         $('.dataTables_paginate .paginate_button').css({
    //             'color': 'white',
    //             'border': '1px solid #fff',
    //             'background': '#007AC1',
    //             'cursor' : 'pointer'
    //         });

    //         // Add hover effect using jQuery
    //         $('.dataTables_paginate .paginate_button').hover(
    //             function () {
    //                 // Mouse enters: Change hover styles
    //                 $(this).css({
    //                     'color': '#007AC1',
    //                     'background-color': 'white',
    //                     'border': '1px solid #007AC1',
    //                     'transition': '0.5s'
    //                 });
    //             },
    //             function () {
    //                 // Mouse leaves: Restore original styles
    //                 $(this).css({
    //                     'color': 'white',
    //                     'background': '#007AC1',
    //                     'border': '1px solid #fff'
    //                 });
    //             }
    //         );
    //     });
    $(document).ready(function () {
        // Initialize DataTables
        var table = $('.data-table').DataTable();

        // Modify pagination buttons after table is loaded
        function modifyPaginationButtons() {
            $(".dataTables_paginate .paginate_button").each(function () {
                if (!$(this).hasClass("blue_common_btn")) {
                    $(this).addClass("blue_common_btn");
                    
                    // Add SVG if it doesn't exist
                    if ($(this).find("svg").length === 0) {
                        $(this).html(`
                            <svg viewBox="0 0 100 100" preserveAspectRatio="none">
                                <polyline points="99,1 99,99 1,99 1,1 99,1" class="bg-line"></polyline>
                                <polyline points="99,1 99,99 1,99 1,1 99,1" class="hl-line"></polyline>
                            </svg>
                            <span>${$(this).text()}</span>
                        `);
                    }
                }
            });
        }

        // Run function on DataTables draw event
        table.on("draw", function () {
            modifyPaginationButtons();
        });

        // Run it initially after table is fully loaded
        setTimeout(modifyPaginationButtons, 100);
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
                image: "@if ($setting && $setting['value']['logo_image']) {{ asset('storage/Logo_Settings/'.$setting['value']['logo_image']) }} @else {{ asset('front-end/images/infiniylogo.png') }} @endif",
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
            document.querySelectorAll('.header_menu a').forEach(item => {
                item.classList.remove('active', 'show');
            });

            document.querySelectorAll('.tab-pane').forEach(item => {
                item.classList.remove('active', 'show');
                item.classList.add('d-none');
            });
            event.currentTarget.classList.add('active', 'show');

            var tabContent = document.getElementById(tabId);
            if (tabContent) {
                tabContent.classList.add('active', 'show');
                tabContent.classList.remove('d-none');
            }
            if (tabId === "wallet") {
                let stripeSection = document.getElementById("stripePayment");
                if (stripeSection) {
                    stripeSection.classList.remove('d-none');
                    stripeSection.classList.add('active', 'show');
                }
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
                e.preventDefault(); // Prevent the default link behavior
                document.getElementById('list-settings-list').click(); // Trigger the list-settings tab
            });
        });
        document.addEventListener("DOMContentLoaded", function () {
            const inputFields = document.querySelectorAll(".form-control");
            // Function to handle floating label
            function updateFloatingLabel(input) {
                const label = input.nextElementSibling; // Get the corresponding label
                if (input.value.trim() !== "") {
                    label.style.top = "50%";
                    label.style.fontSize = "1rem";
                    label.style.color = "#70657b";
                } else {
                    label.style.top = "50%";
                    label.style.fontSize = "1rem";
                    label.style.color = "#70657b"; // Ensure this style on initial load if empty
                }
            }
    
            function handleBlur(input) {
                const label = input.nextElementSibling;
                if (input.value.trim() === "") {
                    label.style.color = "red"; // Set red when empty on blur
                    label.style.top = "35%"; // Set label top position when empty on blur
                }
            }
    
            // Initialize labels on page load
            inputFields.forEach(input => {
                updateFloatingLabel(input);
                const label = input.nextElementSibling;
                // Blur event: Check if empty & show error
                input.addEventListener("blur", function () {
                const errorDiv = document.getElementById(input.id + "_error");
    
                if (!input.value.trim()) {
                    if (errorDiv) { // ✅ Check if errorDiv exists
                        errorDiv.textContent = input.name.replace("_", " ") + " is required!";
                        errorDiv.style.display = "block";
                    }
                    input.style.borderColor = "red";
                    label.style.top = "35%";
                    label.style.fontSize = "1rem";
                    label.style.color = "red";
                } else {
                    if (errorDiv) {
                        errorDiv.style.display = "none";
                    }
                    input.style.borderColor = "#ccc";
                    label.style.color = "#70657b";
                }
            });
                // Focus event: Float label
                input.addEventListener("focus", function () {
                    const label = input.nextElementSibling;
                    label.style.top = "-1%";
                    label.style.fontSize = "0.8rem";
                    if (input.value.trim() !== "") {
                        label.style.color = "#70657b";
                        input.style.borderColor = "#70657b";
                    } else {
                        label.style.color = "red";
                        input.style.borderColor = "red";
                    }
                });
            });
        });
        const menuToggle = document.getElementById('menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');

        if (menuToggle && mobileMenu) {
            menuToggle.addEventListener('click', function() {
                // Toggle the 'd-none' class on the mobile menu
                mobileMenu.classList.toggle('d-none');
                menuToggle.classList.remove('d-none');
                console.log('Menu toggled');
            });
        } else {
            console.log('Menu toggle elements not found');
        }
    </script>

</body>
</html>
