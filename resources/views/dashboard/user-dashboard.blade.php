@extends('dashboard.dashboard_layout')
@php 
    use App\Models\SEO;
    use App\Models\Settings;

    $seoData = SEO::where('page', 'user dashboard')->first();
    $site = Settings::where('key', 'site_setting')->first();

    $logoImage = $site['value']['logo_image'] ?? null;
    $ogImage = $logoImage 
        ? asset('storage/Logo_Settings/' . $logoImage) 
        : asset('front-end/images/infiniylogo.png');
@endphp

@section('title'){{ $seoData->title ?? 'User Dashboard' }}@endsection

@section('meta')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- SEO Meta --}}
    <meta name="description" content="{{ $seoData->description ?? 'Access your dashboard to manage orders, view account activity, and update your preferences on Market Place Main.' }}">
    <meta name="keywords" content="{{ $seoData->keywords ?? 'user dashboard, account management, Market Place Main' }}">

    {{-- Open Graph Meta --}}
    <meta property="og:title" content="{{ $seoData->title ?? 'User Dashboard - Market Place Main' }}">
    <meta property="og:description" content="{{ $seoData->description ?? 'Quickly access and manage your Market Place account through the dashboard.' }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:image" content="{{ $ogImage }}">

    {{-- Twitter Meta --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seoData->title ?? 'User Dashboard - Market Place Main' }}">
    <meta name="twitter:description" content="{{ $seoData->description ?? 'Quickly access and manage your Market Place account through the dashboard.' }}">
    <meta name="twitter:image" content="{{ $ogImage }}">

    {{-- Optional Logo Meta (not standard but custom fallback) --}}
    <meta property="og:logo" content="{{ $ogImage }}" />
@endsection
@section('content')
@php
    $user = auth()->user();
@endphp
  <!-- dashboard -->
  <div class="tab-pane fade active show mb-5 user_tab over-view" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="wsus__profile_overview">
                <h3>About Me</h3>
                <p>Hello, I’m {{ $user->name ?? '' }}</p>

                <p><span>Joined:</span> {{ $user->created_at->format('M d, Y') ?? '' }}</p>
                <p>Not {{ $user->name ?? '' }} ? <a class="text-black font-weight-bold"
                        href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">logout</a>
                </p>
                <div>
                    <p>From your account dashboard you can view your recent orders,manage and download the key and
                        files , and edit your password and account details.</p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- accprdion --}}
<div class="container mb-5 mobile_accordion-container mt-3">
    <div class="mobile_accordion active">
        <div class="mobile_accordion-header" onclick="toggleAccordion(this)">
            <h5 class="mb-1 mt-1">User Dashboard</h5>
        </div>
        <div class="mobile_accordion-body">
            @php
                $user = auth()->user();
            @endphp
            <!-- dashboard -->
            <div class="tab-pane fade active show mb-5 over-view" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
                <div class="row">
                    <div class="col-xl-12 col-lg-12">
                        <div class="wsus__profile_overview">
                            <h3>About Me</h3>
                            <p>Hello, I’m {{ $user->name ?? '' }}</p>
            
                            <p><span>Joined:</span> {{ $user->created_at->format('M d, Y') ?? '' }}</p>
                            <p>Not {{ $user->name ?? '' }} ? <a class="text-black font-weight-bold"
                                    href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">logout</a>
                            </p>
                            <div>
                                <p>From your account dashboard you can view your recent orders,manage and download the key and
                                    files , and edit your password and account details.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mobile_accordion mt-3">
        <div class="mobile_accordion-header" onclick="toggleAccordion(this)">
            <h5 class="mb-1 mt-2">Orders</h5>
        </div>
        <div class="mobile_accordion-body">
            <!-- orders -->
            <div class="tab-pane fade mb-5" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">
                <div class="row">
                    <div class="col-xl-12 col-lg-12">
                        <div class="wsus__profile_overview">
                            <h4 class="mb-4">ALL Orders</h4>
                            @if ($orders->count() > 0)
                                <div class="row">
                                    @foreach ($orders as $index => $order)
                                        <div class="col-md-6 col-12 p_0">
                                            <div class="accordion" id="accordionRightIcon-{{ $index }}">
                                                <div class="card mt-4 shadow-sm rounded-lg dot_border">
                                                    <div class="cart-item-border text-center">{{ $order->product->name ?? 'Product Name' }}</div>
                                                    {{-- <div class="card mt-4">
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
                                                    </div> --}}
                                                    <div id="accordion-item-icon-right-{{ $order->id ?? '' }}" class="collapse mt-2" data-parent="#accordionRightIcon-{{ $index }}">
                                                        <div class="card-body bg-light">
                                                            <div class="row">
                                                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                                                    <div class="d-flex mb-3">
                                                                        <div class="text-muted"><strong>Order Id:</strong></div>
                                                                        <div class="ml-2"><p>#{{ $order->id ?? '' }}</p></div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                                                    <div class="d-flex mb-3">
                                                                        <div class="text-muted"><strong>Product File:</strong></div>
                                                                        <div class="ml-2 mt-2">
                                                                            <a href="{{ asset('storage/plan/' . $order->product->created_by . '/' . $order->product->id . '/' . $order->product->main_file) }}" 
                                                                            class="btn blue_common_btn" 
                                                                            download="{{ $order->product->name ?? '' }}">
                                                                            <svg viewBox="0 0 100 100" preserveAspectRatio="none">
                                                                                <polyline points="99,1 99,99 1,99 1,1 99,1" class="bg-line"></polyline>
                                                                                <polyline points="99,1 99,99 1,99 1,1 99,1" class="hl-line"></polyline>
                                                                        </svg>
                                                                                <i class="fas fa-download"></i> <span class="ml-2">Download</span>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                                                    <div class="d-flex mb-3">
                                                                        <div class="text-muted"><strong>Product:</strong></div>
                                                                        <div class="ml-2">
                                                                            <div class="d-flex align-items-center">
                                                                                <img width="70px" src="{{ asset('storage/plan/' . $order->product->created_by . '/' . $order->product->id . '/' . $order->product->thumbnail) }}" 
                                                                                    alt="{{ $order->product->name ?? '' }}" class="rounded">
                                                                                <span class="ml-2">{{ $order->product->name ?? '' }}</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                                                    <div class="d-flex mb-3">
                                                                        <div class="text-muted"><strong>Payment Status:</strong></div>
                                                                        <div class="ml-2">
                                                                            <span class="badge badge-success"> {{ $order->payment_status ?? '' }} </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                                                    <div class="d-flex mb-3">
                                                                        <div class="text-muted"><strong>Payment Amount:</strong></div>
                                                                        <div class="ml-2">
                                                                            <p class="mb-0 ml-2"> <i class="fa fa-inr" aria-hidden="true"></i> {{ $order->payment_amount ?? '' }}</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                                                    <div class="d-flex mb-3">
                                                                        <div class="text-muted"><strong>Product Key:</strong></div>
                                                                        <div class="d-flex flex-wrap align-items-center">
                                                                            <div class="mr-3 text-break" style="word-break: break-word; max-width: 100%;">
                                                                                <p class="mb-0">{{ $order->key->key ?? '' }}</p>
                                                                            </div>
                                                                            <button type="submit" class="blue_common_btn btn  btn-sm btn-outline-secondary"   onclick="copy('{{ $order->key->key ?? '' }}','#copy_button_{{ $order->id }}')"
                                                                                id="copy_button_{{ $order->id }}"
                                                                                title="Click here to copy">
                                                                                <svg viewBox="0 0 100 100" preserveAspectRatio="none">
                                                                                    <polyline points="99,1 99,99 1,99 1,1 99,1" class="bg-line"></polyline>
                                                                                    <polyline points="99,1 99,99 1,99 1,1 99,1" class="hl-line"></polyline>
                                                                                </svg>
                                                                                <span>   <i class="fas fa-copy"></i></span>
                                                                            </button>
                                                                                {{-- <button class="btn btn-sm btn-outline-secondary"
                                                                                        onclick="copy('{{ $order->key->key ?? '' }}','#copy_button_{{ $order->id }}')"
                                                                                        id="copy_button_{{ $order->id }}"
                                                                                        title="Click here to copy">
                                                                                    <i class="fas fa-copy"></i>
                                                                                </button> --}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div> <!-- Row End -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                            
                                        <!-- Start new row after every 2 cards -->
                                        @if (($index + 1) % 2 == 0)
                                            </div><div class="row">
                                        @endif
                                    @endforeach
                                </div> <!-- Closing row -->
                            @else
                                <p class="d-inline-block mr-4">No Orders Found</p>
                                {{-- <a href="{{ url('/') }}" class="btn-dark-blue d-inline-block"><i
                                        class="nav-icon i-Left" aria-hidden="true"> </i> &nbsp; Continue Shopping</a> --}}
                                <a href="{{ url('/') }}"class="btn btn-linkedin blue_common_btn"> 
                                    <svg viewBox="0 0 100 100" preserveAspectRatio="none">
                                    <polyline points="99,1 99,99 1,99 1,1 99,1" class="bg-line"></polyline>
                                    <polyline points="99,1 99,99 1,99 1,1 99,1" class="hl-line"></polyline>
                                </svg><span>Browse Products</span></a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mobile_accordion  mt-3">
        <div class="mobile_accordion-header" onclick="toggleAccordion(this)">
            <h5 class="mb-1 mt-1">Downloads</h5>
        </div>
        <div class="mobile_accordion-body">
           <!-- downloads -->
            <div class="tab-pane fade mb-5" id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">
                <div class="row">
                    <div class="col-xl-12 col-lg-12">
                        <div class="wsus__profile_overview">
                            <h4 class="mb-4">Downloads</h4>
                            
                            @if ($orders->count() > 0)
                                <table class="display table table-striped table-bordered dataTable data-table"
                                    style="width:100%" role="grid" aria-describedby="zero_configuration_table_info">
                                    <thead>
                                        <tr>
                                            <th scope="col">Order Id</th>
                                            <th scope="col">Product Key</th>
                                            <th scope="col">Product File</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $order)
                                            <tr role="row">
                                                <td data-label="order id "> #{{ $order->id ?? '' }}</td>
                                                <td data-label="product key "> {{ $order->key->key ?? '' }}</td>
                                                <td data-label="product file "> <a href="{{ asset('storage/plan/' . $order->product->created_by . '/' . $order->product->id . '/' . $order->product->main_file) }}"
                                                        download="{{ $order->product->name ?? '' }}">Download</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    
                                    <tfoot>
                                        <tr role="row">
                                            <th scope="col">Order Id</th>
                                            <th scope="col">Product Key</th>
                                            <th scope="col">Product File</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            @else
                                <p class="d-inline-block mr-4">No Downloads Found</p>
                                {{-- <a href="{{ url('/') }}" class="btn-dark-blue d-inline-block"><i
                                        class="nav-icon i-Left" aria-hidden="true"> </i> &nbsp; Browse Products</a> --}}
                                    <a href="{{ url('/') }}"class="btn btn-linkedin blue_common_btn"> 
                                        <svg viewBox="0 0 100 100" preserveAspectRatio="none">
                                        <polyline points="99,1 99,99 1,99 1,1 99,1" class="bg-line"></polyline>
                                        <polyline points="99,1 99,99 1,99 1,1 99,1" class="hl-line"></polyline>
                                    </svg><span>Browse Products</span></a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mobile_accordion  mt-3">
        <div class="mobile_accordion-header" onclick="toggleAccordion(this)">
            <h5 class="mb-1 mt-1">Support</h5>
        </div>
        <div class="mobile_accordion-body">
            <!-- support -->
            <div class="tab-pane fade mb-5" id="list-support" role="tabpanel" aria-labelledby="list-support-list">
                <div class="row">
                    <div class="col-xl-12 col-lg-12">
                        <div class="wsus__profile_overview">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mobile_accordion  mt-3">
        <div class="mobile_accordion-header" onclick="toggleAccordion(this)">
            <h5 class="mb-1 mt-1">Transactions</h5>
        </div>
        <div class="mobile_accordion-body">
            <!-- transaction -->
            <div class="tab-pane fade mb-5" id="transaction" role="tabpanel" aria-labelledby="list-profile-list">
                <div class="row">
                    <div class="col-xl-12 col-lg-12">
                        <div class="wsus__profile_overview">
                            <h4 class="mb-4">Payment History</h4>
                            <table class="display table table-striped table-bordered transacion_history_tbl data-table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Payment Status</th>
                                        <th scope="col">Payment Amount</th>
                                        <th scope="col">Payment Date</th>
                                        <th scope="col">Plan</th>
                                        <th scope="col">Payment Id</th>
                                        <th scope="col">Payment Method</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($transactions)
                                        @foreach ($transactions as $key => $tran)
                                            <tr>
                                                <td data-label="# "> {{ $key + 1 }} </td>
                                                <td data-label="Payment Status "> {{ $tran->payment_status ? ($tran->payment_status == 'captured' ? 'Success' : $tran->payment_status) : '' }}
                                                </td>
                                                <td data-label="Payment Amount"> {{ $tran->payment_amount ?? '' }} </td>
                                                <td data-label="Payment Date"> {{ Helper::dateFormatForView($tran->created_at) ?? '' }} </td>
                                                <td data-label="Plan">{{ $tran->product->name ?? '' }}</td>
                                                <td data-label="Payment Id"> {{ $tran->razorpay_payment_id ?? '' }} </td>
                                                <td data-label="Payment Method"> {{ $tran->payment_method ?? '' }} </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Payment Status</th>
                                        <th scope="col">Payment Amount</th>
                                        <th scope="col">Payment Date</th>
                                        <th scope="col">Plan</th>
                                        <th scope="col">Payment Id</th>
                                        <th scope="col">Payment Method</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mobile_accordion  mt-3">
        <div class="mobile_accordion-header" onclick="toggleAccordion(this)">
            <h5 class="mb-1 mt-1">Invoice</h5>
        </div>
        <div class="mobile_accordion-body">
            <!-- Invoice -->
            <div class="tab-pane fade mb-5" id="invoice" role="tabpanel" aria-labelledby="list-settings-list">
                <div class="row">
                    <div class="col-xl-12 col-lg-12">
                        <div class="wsus__profile_overview">
                            <h4 class="mb-4">User Invoice</h4>
                            <table class="display table table-striped table-bordered transacion_history_tbl data-table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Invoice Number</th>
                                        <th scope="col">Payment Amount</th>
                                        <th scope="col">Payment Date</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($invoice)
                                        @foreach ($invoice as $key => $inv)
                                            <tr>
                                                <td data-label=" #"> {{ $key + 1 }} </td>
                                                <td data-label="Invoice Number">
                                                    <a href="{{ route('invoice-preview', $inv->id) }}" target="_blank"
                                                        class="text-primary">
                                                        {{ $inv->invoice_number }}
                                                    </a>
                                                </td>
                                                <td data-label="Payment Amount"> Rs. {{ $inv->total ?? '' }}</td>
                                                <td data-label="Payment Date"> {{ $inv->created_at }} </td>
                                                <td data-label="Action"> <a href="{{ route('invoice-preview', $inv->id) }}" target="_blank"
                                                        class="btn btn-primary">Preview</a> </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Invoice Number</th>
                                        <th scope="col">Payment Amount</th>
                                        <th scope="col">Payment Date</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mobile_accordion  mt-3">
        <div class="mobile_accordion-header" onclick="toggleAccordion(this)">
            <h5 class="mb-1 mt-1">Subscription</h5>
        </div>
        <div class="mobile_accordion-body">
            <!-- Subscription -->
            <div class="tab-pane fade mb-5" id="subscription" role="tabpanel"aria-labelledby="list-settings-list">
                <div class="row">
                    <div class="col-xl-12 col-lg-12">
                        <div class="wsus__profile_overview">
                            <h4 class="mb-4">User Subscription</h4>
                            <table class="display table table-striped table-bordered transacion_history_tbl data-table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Product</th>
                                        <th scope="col">Subscription start date</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($subscription)
                                        @foreach ($subscription as $key => $sub)
                                            <tr>
                                                <td data-label="#"> {{ $key + 1 }} </td>
                                                <td data-label="Product"> {{ $sub->product->name ?? '' }}</td>
                                                <td data-label="Subscription start date"> {{ $sub->created_at }} </td>
                                                <td data-label="Status">{{ $sub->status }}</td>
                                                <td data-label="Action">
                                                    @if ($sub->status === 'active')
                                                        <a href="{{ route('subscription.cancel', ['id' => $sub->id]) }}"
                                                            class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Are you sure you want to cancel this subscription?');">
                                                            Stop
                                                        </a>
                                                    @else
                                                        <a href="{{ route('subscription.reactivate', ['id' => $sub->id]) }}"
                                                            class="btn btn-success btn-sm"
                                                            onclick="return confirm('Are you sure you want to reactivate this subscription?');">
                                                            Re-Active
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Product</th>
                                        <th scope="col">Subscription start date</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mobile_accordion  mt-3">
        <div class="mobile_accordion-header" onclick="toggleAccordion(this)">
            <h5 class="mb-1 mt-1">Settings</h5>
        </div>
        <div class="mobile_accordion-body">
            <!-- update password -->
            <div class="tab-pane fade mb-5" id="list-settings" role="tabpanel" aria-labelledby="list-settings-list">
                <div class="row">
                    <div class="col-xl-12 col-lg-12">
                        <div class="wsus__profile_overview">
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
                                    <div class="col-md-12">
                                        <div class="form-group">
                                        <input id="current-password" type="password" class="form-control"
                                            name="current-password" placeholder="" required>
                                            <label for="fname" class="floating-label">Current Password</label>
                                        @if ($errors->has('current-password'))
                                            <div class="error" style="color:red;">
                                                {{ $errors->first('current-password') }}
                                            </div>
                                        @endif
                                        <div class="error" id="current-password_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                        <input id="new-password" type="password" class="form-control" name="new-password"
                                            placeholder="" required>
                                            <label for="lname" class="floating-label">New Password</label>
                                        @if ($errors->has('new-password'))
                                            <div class="error" style="color:red;">
                                                {{ $errors->first('new-password') }}
                                            </div>
                                        @endif
                                        <div class="error" id="new-password_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                        <input id="new-password-confirm" type="password" class="form-control"
                                            name="new-password_confirmation" placeholder="" required>
                                            
                                        <label for="lname" class="floating-label">Confirm New Password</label>
                                        @if ($errors->has('new-password_confirmation'))
                                            <div class="error" style="color:red;">
                                                {{ $errors->first('new-password_confirmation') }}
                                            </div>
                                        @endif
                                        <div class="error" id="new-password-confirm_error"></div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="blue_common_btn btn">
                                    <svg viewBox="0 0 100 100" preserveAspectRatio="none">
                                        <polyline points="99,1 99,99 1,99 1,1 99,1" class="bg-line"></polyline>
                                        <polyline points="99,1 99,99 1,99 1,1 99,1" class="hl-line"></polyline>
                                    </svg>
                                    <span>Update Password</span>
                                </button>
                                {{-- <button type="submit" class="btn read_btn my-4" style="cursor: pointer;"> Update Password</button> --}}
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mobile_accordion mt-3">
        <div class="mobile_accordion-header" onclick="logout()">
            <h5 class="mb-1 mt-1">Logout</h5>
        </div>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

</div>
@endsection
