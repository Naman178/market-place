@extends('dashboard.dashboard_layout')
@section('content')

 <!-- orders -->
 <div class="tab-pane fade mb-5" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="wsus__profile_overview">
                <h4 class="mb-4">ALL Orders</h4>
                @if ($orders->count() > 0)
                    <div class="row">
                        @foreach ($orders as $index => $order)
                            <div class="col-md-6 col-12">
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
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                                        <div class="d-flex mb-3">
                                                            <div class="text-muted"><strong>Order Id:</strong></div>
                                                            <div class="ml-2"><p>#{{ $order->id ?? '' }}</p></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                                        <div class="d-flex mb-3 align-items-center">
                                                            <div class="text-muted"><strong>Product File:</strong></div>
                                                            <div class="ml-2">
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
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                                        <div class="d-flex mb-3 align-items-center flex-wrap">
                                                            <div class="text-muted"><strong>Product:</strong></div>
                                                            <div class="ml-2 d-flex  align-items-center flex-wrap">
                                                                <img width="70px" src="{{ asset('storage/items_files/' . $order->product->thumbnail_image) }}" 
                                                                    alt="{{ $order->product->name ?? '' }}" class="rounded">
                                                                <span class="ml-2">{{ $order->product->name ?? '' }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                                        <div class="d-flex mb-3">
                                                            <div class="text-muted"><strong>Product Type:</strong></div>
                                                            <div class="ml-2">
                                                                <p class="mb-0 ml-2 badge badge-primary text-capitalize">
                                                                    {{ $order->pricing->pricing_type ?? '' }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                                        <div class="d-flex mb-3">
                                                            <div class="text-muted"><strong>Product Billng Cycle:</strong></div>
                                                            <div class="ml-2">
                                                                @if ($order->pricing->billing_cycle)
                                                                    <p class="mb-0 ml-2 badge badge-info text-capitalize">
                                                                        {{ $order->pricing->billing_cycle ?? '' }}
                                                                    </p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                                        <div class="d-flex mb-3">
                                                            <div class="text-muted"><strong>Payment Status:</strong></div>
                                                            <div class="ml-2">
                                                                <span class="badge badge-success text-capitalize"> {{ $order->payment_status ?? '' }} </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- <i class="fa fa-inr" aria-hidden="true"></i> --}}
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                                        <div class="d-flex mb-3">
                                                            <div class="text-muted"><strong>Payment Amount:</strong></div>
                                                            <div class="ml-2">
                                                                <p class="mb-0 ml-2">
                                                                    {{ $order->currency ?? 'INR' }}   
                                                                    @if(isset($order->invoice->discount))
                                                                        {{ number_format(ceil((float) $order->payment_amount / 100), 2, '.', '') }}
                                                                    @elseif($order->payment_amount)
                                                                         {{ number_format(ceil((float) $order->payment_amount / 100), 2, '.', '') }}
                                                                    @else
                                                                        {{ number_format(((float) $order->payment_amount / 100), 2, '.', '') }}
                                                                    @endif
                                                                </p>
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
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                                        <div class="d-flex mb-3">
                                                            @php
                                                                $subscriptionId = $order->subscription->id ?? '';
                                                            @endphp
                                                            <div class="button-container">
                                                                 @if (isset($order->subscription) && $order->subscription)
                                                                @if ($order->pricing->pricing_type == 'recurring')
                                                                    {{-- @if ($order->subscription->status == 'active')  --}}
                                                                        <!-- Stop AutoPay Button -->
                                                                        <button class="blue_common_btn btn btn-sm btn-outline-secondary confirm-btn"
                                                                            data-url="/subscription/cancel-auto-pay/{{ $subscriptionId }}"
                                                                            data-message="Are you sure you want to stop auto-renewal?">
                                                                            <svg viewBox="0 0 100 100" preserveAspectRatio="none">
                                                                                <polyline points="99,1 99,99 1,99 1,1 99,1" class="bg-line"></polyline>
                                                                                <polyline points="99,1 99,99 1,99 1,1 99,1" class="hl-line"></polyline>
                                                                            </svg>
                                                                            <span>Stop AutoPay</span>
                                                                        </button>

                                                                        <!-- Cancel Subscription Immediately Button -->
                                                                        <button class="blue_common_btn btn btn-sm btn-outline-secondary confirm-btn"
                                                                            data-url="/subscription/reactivate/{{ $subscriptionId }}"
                                                                            data-message="This will cancel your subscription immediately. Are you sure?">
                                                                            <svg viewBox="0 0 100 100" preserveAspectRatio="none">
                                                                                <polyline points="99,1 99,99 1,99 1,1 99,1" class="bg-line"></polyline>
                                                                                <polyline points="99,1 99,99 1,99 1,1 99,1" class="hl-line"></polyline>
                                                                            </svg>
                                                                            <span>Cancel Subscription Immediately</span>
                                                                        </button>
                                                                    {{-- @else   
                                                                        <!-- Reactivate Button -->
                                                                        <button class="blue_common_btn btn btn-sm btn-outline-success confirm-btn"
                                                                            data-url="/subscription/reactivate/{{ $subscriptionId }}"
                                                                            data-message="Do you want to reactivate your subscription?">
                                                                            <svg viewBox="0 0 100 100" preserveAspectRatio="none">
                                                                                <polyline points="99,1 99,99 1,99 1,1 99,1" class="bg-line"></polyline>
                                                                                <polyline points="99,1 99,99 1,99 1,1 99,1" class="hl-line"></polyline>
                                                                            </svg>
                                                                            <span>Reactivate</span>
                                                                        </button>
                                                                    @endif --}}
                                                                @else
                                                                    <!-- Deactivate Product Button -->
                                                                    <button class="blue_common_btn btn btn-sm btn-outline-secondary confirm-btn"
                                                                        data-url="/deactivate-product/{{ $order->key->id }}"
                                                                        data-message="This will permanently disable access. No refunds will be issued. Continue?">
                                                                        <svg viewBox="0 0 100 100" preserveAspectRatio="none">
                                                                            <polyline points="99,1 99,99 1,99 1,1 99,1" class="bg-line"></polyline>
                                                                            <polyline points="99,1 99,99 1,99 1,1 99,1" class="hl-line"></polyline>
                                                                        </svg>
                                                                        <span>Deactivate Product</span>
                                                                    </button>
                                                                @endif
                                                                @endif
                                                            </div>
                                                            {{-- <div class="button-container">
                                                                @if (isset($order->subscription) && $order->subscription)
                                                                    @if ($order->pricing->pricing_type == 'recurring')
                                                                        @if ($order->subscription->status == 'active') 
                                                                            <!-- Stop AutoPay Button -->
                                                                            <form method="POST" action="{{ url('/subscription/cancel-auto-pay/' . $subscriptionId) }}" style="display:inline;">
                                                                                @csrf
                                                                                <button type="submit" class="blue_common_btn btn btn-sm btn-outline-secondary">
                                                                                    <svg viewBox="0 0 100 100" preserveAspectRatio="none">
                                                                                        <polyline points="99,1 99,99 1,99 1,1 99,1" class="bg-line"></polyline>
                                                                                        <polyline points="99,1 99,99 1,99 1,1 99,1" class="hl-line"></polyline>
                                                                                    </svg>
                                                                                    <span>Stop AutoPay</span>
                                                                                </button>
                                                                            </form>

                                                                            <!-- Cancel Subscription Immediately Button -->
                                                                            <form method="POST" action="{{ url('/subscription/reactivate/' . $subscriptionId) }}" style="display:inline;">
                                                                                @csrf
                                                                                <button type="submit" class="blue_common_btn btn btn-sm btn-outline-secondary">
                                                                                    <svg viewBox="0 0 100 100" preserveAspectRatio="none">
                                                                                        <polyline points="99,1 99,99 1,99 1,1 99,1" class="bg-line"></polyline>
                                                                                        <polyline points="99,1 99,99 1,99 1,1 99,1" class="hl-line"></polyline>
                                                                                    </svg>
                                                                                    <span>Cancel Subscription Immediately</span>
                                                                                </button>
                                                                            </form>
                                                                        @else   
                                                                            <!-- Reactivate Button -->
                                                                            <form method="POST" action="{{ url('/subscription/reactivate/' . $subscriptionId) }}" style="display:inline;">
                                                                                @csrf
                                                                                <button type="submit" class="blue_common_btn btn btn-sm btn-outline-success">
                                                                                    <svg viewBox="0 0 100 100" preserveAspectRatio="none">
                                                                                        <polyline points="99,1 99,99 1,99 1,1 99,1" class="bg-line"></polyline>
                                                                                        <polyline points="99,1 99,99 1,99 1,1 99,1" class="hl-line"></polyline>
                                                                                    </svg>
                                                                                    <span>Reactivate</span>
                                                                                </button>
                                                                            </form>
                                                                        @endif
                                                                    @else
                                                                        <!-- Deactivate Product Button -->
                                                                        <form method="POST" action="{{ url('/deactivate-product/' . $order->key->id) }}" style="display:inline;">
                                                                            @csrf
                                                                            <button type="submit" class="blue_common_btn btn btn-sm btn-outline-secondary">
                                                                                <svg viewBox="0 0 100 100" preserveAspectRatio="none">
                                                                                    <polyline points="99,1 99,99 1,99 1,1 99,1" class="bg-line"></polyline>
                                                                                    <polyline points="99,1 99,99 1,99 1,1 99,1" class="hl-line"></polyline>
                                                                                </svg>
                                                                                <span>Deactivate Product</span>
                                                                            </button>
                                                                        </form>
                                                                    @endif
                                                                @endif
                                                                </div> --}}

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
@endsection
