@extends('front-end.common.master')
@section('title', 'Invoice')

@section('styles')
   <link rel="stylesheet" href="{{ asset('front-end/css/checkout.css') }}">
   <link rel="stylesheet" href="{{ asset('front-end/css/register.css') }}">
@endsection

@section('scripts')
   <script src="https://js.stripe.com/v3/"></script>
@endsection

@section('content')
<style>
    table {
        width: 100%;
        border-collapse: collapse;
        
    }
    
    th, td {
        border-top: 1px solid #ddd; 
        border-bottom: 1px solid #ddd;
        padding: 8px;
        text-align: center;
    }
    
    thead {
        background-color: #ffffff;
    }
    .checkout .container{
        max-width: 1320px;
    }
</style>
@php
 use App\Models\Settings;
 $site = Settings::where('key','site_setting')->first();
    $createdAt = \Carbon\Carbon::parse($invoice->created_at);
    $nextDueDate = '';

    if ($invoice->pricing->pricing_type == 'recurring') {
        $billingCycle = $invoice->pricing->billing_cycle;

        switch ($billingCycle) {
            case 'monthly':
                $nextDueDate = $createdAt->copy()->addMonth()->format('d-m-Y');
                break;
            case 'yearly':
                $nextDueDate = $createdAt->copy()->addYear()->format('d-m-Y');
                break;
            case 'weekly':
                $nextDueDate = $createdAt->copy()->addWeek()->format('d-m-Y');
                break;
            case 'quarterly':
                $nextDueDate = $createdAt->copy()->addMonths(3)->format('d-m-Y');
                break;
            case 'custom':
                $customDays = $invoice->pricing->custom_cycle_days ?? 0;
                $nextDueDate = $createdAt->copy()->addDays($customDays)->format('d-m-Y');
                break;
            default:
                $nextDueDate = $createdAt->copy()->addDays(30)->format('d-m-Y');
        }
    } else {
        $nextDueDate = '-';
    }
@endphp
<div class="checkout-container py-5">
   <div class="checkout container">
      <div class="container">
         <div class="row justify-content-center">
            <div class="col-xl-12 col-md-12 col-12">
                <div class="card shadow-lg border-0">
                    <div class="card-body">
                        <div class="row p-4">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-4">
                                    @if ($site->value['logo_image'] != null)
                                        <img src="{{ asset('storage/Logo_Settings/' . $site->value['logo_image']) }}" height="50" width="180" alt="Site Logo">
                                    @else
                                        <img src="{{ asset('front-end/images/infiniylogo.png') }}" height="50" width="180" alt="Site Logo">
                                        
                                    @endif
                                </div>
                                <h3 class="fw-bold">Invoice #{{ $invoice->invoice_number ?? '' }}</h3>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <p><strong>Invoice Date:</strong> {{ $invoice->created_at ? $invoice->created_at->format('d-m-Y') : '-' }}</p>
                                <p><strong>Paid Date:</strong> {{ $invoice->created_at ? $invoice->created_at->format('d-m-Y') : '-' }}</p>
                                <p class="mb-4"><strong>Payment Status:</strong> 
                                    @if ($invoice->payment_status == 'succeeded')
                                        <span class="badge bg-success">{{ ucfirst($invoice->payment_status) }}</span>
                                    @elseif ($invoice->payment_status == 'cancelled')
                                        <span class="badge bg-danger">{{ ucfirst($invoice->payment_status) }}</span>
                                    @endif
                                </p>
                                <p><strong>Next Due Date: </strong> {{ $nextDueDate }}</p>
                                <a href="{{ route('invoice.download', ['id' => $invoice->id]) }}" target="_blank"
                                    class="btn btn-label-secondary pink-blue-grad-button d-grid w-100 mb-2"> <i class="fas fa-download me-2"></i>  Download Invoice</a>
                            </div>
                        </div>
                    </div>
                
                    <hr class="m-0" />

                    <div class="card-body">
                        <div class="row p-4">
                            <div class="col-md-6">
                                <h6 class="fw-bold">Pay To:</h6>
                                <p>{{$setting->value['site_name'] ?? ''}}</p>
                                <p>{{$setting->value['address_1'] ?? ''}} ,</p>
                                <p>{{$setting->value['address_2'] ?? ''}}</p>
                                <p>{{$setting->value['city'] ?? ''}}, {{$setting->value['state'] ?? ''}}, {{$setting->value['pin'] ?? ''}}</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="fw-bold">Invoice To:</h6>
                                <p><strong>{{ $user->company_name ?? '' }}</strong></p>
                                <p>{{ $user->name ?? '' }}</p>
                                <p>{{ $user->address_line1 ?? '' }}</p>
                                <p>{{ $user->city ?? '' }}, {{ $user->postal_code ?? '' }}</p>
                                <p>{{ $user->contact_number ?? '' }}</p>
                                <p>{{ $user->email ?? '' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive border-top">
                        <table>
                            <thead>
                                <tr style="text-align: center">
                                    <th>Item</th>
                                    <th>Validity</th>
                                    <th>Price</th>
                                </tr>
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $validity }}</td>
                                    <td>{{ $product->currency ?? '₹' }} {{ number_format($invoice->subtotal, 2) }} </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td class="text-end pe-1 py-4">
                                        <p class="mb-2 pt-3">Quantity:</p>
                                        <p class="mb-2 pt-3">Sub-Total:</p>
                                        @if ($invoice->gst_percentage > 0)
                                            <p class="mb-2">GST ({{ intval($invoice->gst_percentage) }}%)(+):</p>
                                        @endif
                                        @if ($invoice->discount > 0)
                                            @php
                                                $text = '';
                                                $amount = 0;
                                                if($invoice->coupon->discount_type == 'percentage'){
                                                    $amount = intval($invoice->coupon->discount_value) . '%';
                                                    $text = 'upto ' . $invoice->coupon->max_discount;
                                                }else{
                                                    $amount = $invoice->discount;
                                                    $text = 'flat';
                                                }
                                            @endphp
                                            <p class="mb-2">Applied coupon:</p>
                                            <p class="mb-2">Discount ({{ $amount }})({{$text}})(-):</p>
                                        @endif                                        
                                        <p class="mb-0 pb-3">Total:</p>

                                    <td class="ps-3 py-4">
                                        @php
                                            $quantity = $invoice->quantity ?? 1;
                                            $subtot = $invoice->subtotal * $quantity;
                                            // dd($subtot);
                                        @endphp
                                        <p class="fw-semibold mb-2 pt-3 text-start"> {{ $invoice->quantity }}</p>
                                        <p class="fw-semibold mb-2 pt-3 text-start">{{ $product->currency ?? '₹' }} {{ number_format($subtot, 2) }} </p>
                                        @if ($invoice->gst_percentage > 0)
                                            @php
                                                $taxAmount = ($subtot * $invoice->gst_percentage) / 100;
                                                $taxAmount = round($taxAmount);
                                                $total = round($invoice->total);
                                            @endphp
                                            <p class="fw-semibold mb-2 text-start">{{ $product->currency ?? '₹' }} {{ number_format($taxAmount, 2) ?? '' }} </p>
                                        @endif
                                        @if ($invoice->discount > 0)
                                            @php
                                                $discount =  round($invoice->discount, 2);
                                            @endphp
                                            <p class="fw-semibold mb-2 text-start">{{ $invoice->coupon->coupon_code }}</p>
                                            <p class="fw-semibold mb-2 text-start">{{ $product->currency ?? '₹' }} {{ number_format($discount, 2) ?? '' }}</p>
                                        @endif
                                        <p class="fw-semibold mb-0 pb-3 text-start">
                                            {{ $product->currency ?? '₹' }} {{ number_format($total, 2) }}
                                        </p>

                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            {{-- <div class="col-xl-3 col-md-4 col-12 invoice-actions">
                <div class="card">
                    <div class="card-body">
                        
                    </div>
                </div>
            </div> --}}
         </div>
      </div>
   </div>
</div>
@endsection
