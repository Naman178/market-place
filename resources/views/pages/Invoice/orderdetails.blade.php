@extends('layouts.master')
@php
    use App\Models\Settings;
    $site = Settings::where('key', 'site_setting')->first();
@endphp
@section('title')
    <title>{{ $site['value']['site_name'] ?? 'Infinity' }} | {{ trans('custom.Blog_title') }}</title>
@endsection
@section('page-css')
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/datatables.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href=" https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.min.css " rel="stylesheet">
    <style>
        .img-fluid {
            object-fit: cover;
        }
        .filled-star {
            content: "\2605"; /* Unicode for a filled star (★) */
        }

        .half-star {
            content: "\2BEA"; /* Unicode for a half-star (⯪) or use a different approach */
        }

        .empty-star {
            content: "\2606"; /* Unicode for an empty star (☆) */
        }

    </style>
@endsection
@section('main-content')
    <div class="breadcrumb">
        <div class="col-sm-12 col-md-6">
            <h4><a href="{{ route('dashboard') }}" class="text-uppercase">{{ $site['value']['site_name'] ?? 'Infinity' }}</a> | Orders  </h4>
        </div>
    </div>
    @can('invoice-list')
        <div class="separator-breadcrumb border-top"></div>
        
        @foreach ($order as $ord )
        <div class="row">
            <div class="col-xl-9">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h5 class="card-title flex-grow-1 mb-0">Order Details</h5>
                            <div class="flex-shrink-0">
                                <a href="{{ route('invoice.download', ['id' => $ord->invoice->id]) }}" target="_blank" class="btn btn-primary btn-sm"><i class="ri-download-2-fill align-middle me-1"></i> Invoice</a>
                                <a href="javascript:void(0);" class="btn btn-danger btn-sm suspend-key" 
                                data-key="{{ $ord->key->key }}">
                                 <i class="ri-printer-fill align-middle me-1"></i> Suspend Licence
                             </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table-card">
                            <table class="table table-nowrap align-middle table-borderless mb-0">
                                <thead class="table-light text-muted">
                                    <tr>
                                        <th scope="col">Product Details</th>
                                        <th scope="col">Item Price</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Rating</th>
                                        <th scope="col" class="text-end">Total Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  
                                    <tr>
                                        <td>
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 avatar-md bg-light rounded p-1">
                                                    <img src="{{ asset('public/storage/items_files/' . $ord->product->thumbnail_image) }}" alt="" class="img-fluid d-block w-100 h-100">
                                                </div>
                                                <div class="flex-grow-1 ml-3">
                                                    <h5 class="fs-14"><a href="apps-ecommerce-product-details.html" class="text-body">{{ $ord->product->name ?? '' }}</a></h5>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $ord->product->pricing->sale_price }}</td>
                                        <td>{{ $ord->invoice->quantity ?? 1 }}</td>
                                        <td>
                                            <div class="text-warning wsus__gallery_item_text fs-15">
                                                <p id="starRating" class="mb-0 mt-3 ml-2">
                                                    @php
                                                        $rating = round($ord->product->reviews[0]['rating'] ?? 0, 1); // Get rating, default 0
                                                        $fullStars = floor($rating); // Full stars
                                                        $halfStar = ($rating - $fullStars) >= 0.5 ? 1 : 0; // Half star
                                                        $emptyStars = 5 - ($fullStars + $halfStar); // Empty stars
                                                    @endphp
                                                
                                                    {{-- Render full stars --}}
                                                    @for ($i = 0; $i < $fullStars; $i++)
                                                        <i class="fa fa-star text-warning filled-star"></i>
                                                    @endfor
                                                
                                                    {{-- Render half star --}}
                                                    @if ($halfStar)
                                                        <i class="fa fa-star-half-o text-warning half-star"></i>
                                                    @endif
                                                
                                                    {{-- Render empty stars --}}
                                                    @for ($i = 0; $i < $emptyStars; $i++)
                                                        <i class="fa fa-star-o text-warning empty-star"></i>
                                                    @endfor
                                                
                                                    <span class="total_star" id="ratingValue">({{ $rating ?? 0.0 }})</span>
                                                </p>                                                
                                            </div>
                                        </td>
                                        <td class="fw-medium text-end">
                                            {{ $ord->currency ?? 'INR' }} {{ number_format(ceil($ord->payment_amount / 100), 2) }}
                                        </td>
                                    </tr>
                                    <tr class="border-top border-top-dashed">
                                        <td colspan="3"></td>
                                        <td colspan="2" class="fw-medium p-0">
                                            <table class="table table-borderless mb-0">
                                                <tbody>
                                                    {{-- Subtotal --}}
                                                    <tr>
                                                        <td>Sub Total :</td>
                                                        <td class="text-end">
                                                            {{ $ord->currency ?? 'INR' }} {{ number_format(round($ord->invoice->subtotal), 2) }}
                                                        </td>
                                                    </tr>

                                                    {{-- Discount --}}
                                                    @if($ord->invoice->discount > 0)
                                                        <tr>
                                                            <td>
                                                                Discount 
                                                                @if($ord->invoice->coupon)
                                                                    <span class="text-muted">({{ $ord->invoice->coupon->coupon_code }})</span>
                                                                @endif
                                                                :
                                                            </td>
                                                            <td class="text-end text-danger">
                                                                -{{ $ord->currency ?? 'INR' }} {{ number_format(round($ord->invoice->discount), 2) }}
                                                            </td>
                                                        </tr>
                                                    @endif

                                                    {{-- GST Tax --}}
                                                    @if($ord->invoice->gst_percentage > 0)
                                                        @php
                                                            $gstAmount = round(($ord->invoice->gst_percentage * $ord->invoice->subtotal) / 100);
                                                        @endphp
                                                        <tr>
                                                            <td>GST Tax ({{ $ord->invoice->gst_percentage }}%) :</td>
                                                            <td class="text-end">
                                                                {{ $ord->currency ?? 'INR' }} {{ number_format($gstAmount, 2) }}
                                                            </td>
                                                        </tr>
                                                    @endif

                                                    {{-- Total --}}
                                                    <tr class="border-top border-top-dashed">
                                                        <th scope="row">Total ({{ $ord->currency ?? 'INR' }}) :</th>
                                                        <th class="text-end">
                                                            {{ $ord->currency ?? 'INR' }} {{ number_format(ceil($ord->payment_amount / 100), 2) }}
                                                        </th>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!--end card-->
            </div>
            <!--end col-->
            <div class="col-xl-3">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex">
                            <h5 class="card-title flex-grow-1 mb-0">Customer Details</h5>
                            <div class="flex-shrink-0">
                                <a href="{{ route('profilesettings', Auth::user()->id) }}" class="link-secondary">View Profile</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0 vstack gap-3">
                            <li class="mb-2">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        @if (Auth::user()->profile_pic)
                                            <img src="{{asset('assets/images/faces/' . Auth::user()->profile_pic) }}" alt="" class="avatar-sm rounded">
                                        @else
                                            <img src="{{asset('assets/images/faces/1.png') }}" alt="" class="avatar-sm rounded">
                                        @endif
                                    </div>
                                    <div class="flex-grow-1 ml-3">
                                        <h6 class="fs-14 mb-1">{{ Auth::user()->name }}</h6>
                                        <p class="text-muted mb-0">{{ Auth::user()->roles[0]['name'] }}</p>
                                    </div>
                                </div>
                            </li>
                            <li class="mb-2"><i class="ri-mail-line me-2 align-middle text-muted fs-16"></i>{{ Auth::user()->email }}</li>
                            <li class="mb-2"><i class="ri-phone-line me-2 align-middle text-muted fs-16"></i>{{ Auth::user()->contact_number }}</li>
                        </ul>
                    </div>
                </div>
                <!--end card-->
                <div class="card mt-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><i class="ri-map-pin-line align-middle me-1 text-muted"></i> Billing Address</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled vstack gap-2 fs-13 mb-0">
                            <li class="fw-medium fs-14 mb-2">{{ $ord->user->name }}</li>
                            <li class="mb-2">{{ $ord->user->contact_number }}</li>
                            <li class="mb-2">{{ $ord->user->address_line1. ','. $ord->user->address_line2 }}</li>
                            <li class="mb-2"{{ $ord->user->city . ','. $ord->user->state.'-'. $ord->user->postal_code }}</li>
                            <li class="mb-2">{{ $ord->user->country }}</li>
                        </ul>
                    </div>
                </div>
                <!--end card-->
                <div class="card mt-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><i class="ri-map-pin-line align-middle me-1 text-muted"></i> Shipping Address</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled vstack gap-2 fs-13 mb-0">
                            <li class="fw-medium fs-14">{{ $ord->user->name }}</li>
                            <li class="mb-2">{{ $ord->user->contact_number }}</li>
                            <li class="mb-2">{{ $ord->user->address_line1. ','. $ord->user->address_line2 }}</li>
                            <li class="mb-2"{{ $ord->user->city . ','. $ord->user->state.'-'. $ord->user->postal_code }}</li>
                            <li class="mb-2">{{ $ord->user->country }}</li>
                        </ul>
                    </div>
                </div>
                <!--end card-->
                <div class="card mt-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><i class="ri-secure-payment-line align-bottom me-1 text-muted"></i> Payment Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="flex-shrink-0">
                                <p class="text-muted mb-0">Transactions:</p>
                            </div>
                            <div class="flex-grow-1 ms-2">
                                <h6 class="mb-0">#{{$ord->transaction->transaction_id }}</h6>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <div class="flex-shrink-0">
                                <p class="text-muted mb-0">Payment Method:</p>
                            </div>
                            <div class="flex-grow-1 ms-2">
                                <h6 class="mb-0">{{ $ord->invoice->payment_method }}</h6>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <p class="text-muted mb-0">Total Amount:</p>
                            </div>
                            <div class="flex-grow-1 ms-2">
                                <h6 class="mb-0">{{ $ord->payment_amount }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end card-->
            </div>
            <!--end col-->
        </div>
        
        @endforeach
    @else
        <h1><b>You don't have permission to view this page</b></h1>
    @endcan
   
@endsection

@section('page-js')
    <script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('.suspend-key').on('click', function(){
                let key = $(this).data('key');
                let button = $(this);

                let isSuspended = button.hasClass('btn-danger'); 

                Swal.fire({
                    title: isSuspended ? 'Are you sure you want to suspend this licence?' : 'Are you sure you want to reactivate this licence?',
                    text: isSuspended ? 'You can reactivate it later.' : 'It will be active again.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: isSuspended ? 'Yes, Suspend!' : 'Yes, Reactivate!',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('key.suspend', ':id') }}".replace(':id', key),
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                action: isSuspended ? 'suspend' : 'reactivate'
                            },
                            success: function(response) {
                                if (response.success) {
                                    if (isSuspended) {
                                        toastr.success(response.message);
                                        button.text('Reactivate Licence').removeClass('btn-danger').addClass('btn-primary');
                                    } else {
                                        toastr.success("Licence Reactivated Successfully!");
                                        button.text('Suspend Licence').removeClass('btn-primary').addClass('btn-danger');
                                    }
                                }
                            },
                            error: function(xhr) {
                                toastr.error("Error processing the request.");
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection