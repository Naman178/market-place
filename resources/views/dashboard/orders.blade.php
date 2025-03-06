@extends('dashboard.dashboard_layout')
@section('content')

 <!-- orders -->
 <div class="tab-pane fade mb-5" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="wsus__profile_overview">
                <h4 class="mb-4">ALL Orders</h4>
                @if ($orders->count() > 0)
                    <div class="accordion" id="accordionRightIcon">
                        @foreach ($orders as $order)
                            <div class="card mt-4">
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
                                <div id="accordion-item-icon-right-{{ $order->id ?? '' }}" class="collapse show"
                                    data-parent="#accordionRightIcon" style="">
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
                                                        <p class="copy-text">
                                                            {{ $order->key->key ?? '' }}
                                                            <button class="btn-copy"
                                                                style="height: 30px; width: 100px; display: flex; align-items: center; justify-content: center; padding: 0; margin-top: 12px; cursor: pointer;"
                                                                onclick="copy('{{ $order->key->key ?? '' }}','#copy_button_{{ $order->id }}')"
                                                                id="copy_button_{{ $order->id }}"
                                                                title="Click here to copy">
                                                                <img src="{{ asset('storage/Logo_Settings/copy_pic.png') }}"
                                                                    alt="Copy"
                                                                    style="max-width: 100%; max-height: 100%;">
                                                            </button>
                                                        </p>
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
        </div>
    </div>
</div>
@endsection
