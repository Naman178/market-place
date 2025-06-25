<!DOCTYPE html>
@php
    use App\Models\Settings;
    $site = Settings::where('key','site_setting')->first();
@endphp
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/styles/css/themes/lite-purple.min.css')}}">
    @if ($site && $site['value']['site_favicon'])
        <link rel="icon"  href="{{asset('storage/Logo_Settings/'.$site['value']['site_favicon'])}}">
    @endif
    <style>
        @page {
            margin: 0px;
        }

        body {
            border: 3px solid #000;
            padding: 18px;
            margin: 8px;
        }

        .contentWrapper {
            font-family: Arial, Helvetica, sans-serif;
            line-height: 22px;
            position: relative;
        }

        .companyLogo {
            margin-bottom: 10px;
        }

        .companyLogo div {
            width: 200px;
        }

        .companyLogo img {
            max-width: 100%;
            margin-top: 125px;

        }

        .contentWrapper .vnetCompanyInfo,
        .paidimgDiv {
            margin-left: auto;
            margin-right: 0;
        }

        .paidImg {
            widows: 98%;
        }

        .paidimgDiv {
            position: absolute;
            top: -30px;
            right: -30px;
        }

        .contentWrapper .vnetCompanyInfo {
            text-align: right;
            width: 300px;
        }

        .contentWrapper .vnetCompanyInfo h3,
        .contentWrapper .vnetCompanyInfo h5 {
            text-transform: uppercase;
        }

        .contentWrapper p,
        .contentWrapper h3,
        .contentWrapper h5,
        .contentWrapper h6 {
            margin: 0;
        }

        .contentWrapper .innerDiv {
            margin-top: 20px;
        }

        .contentWrapper .innerDiv .username {
            text-transform: capitalize;
        }

        .contentWrapper .invoiceDetails {
            background-color: #d3d3d375;
            padding: 12px 8px 12px 8px;
            border-radius: 5px;
        }

        .contentWrapper .ventTable {
            width: 100%;
            margin: 48px 0;
        }

        .contentWrapper .ventTable,
        .contentWrapper .ventTable th,
        .contentWrapper .ventTable td {
            border: 0.5px solid lightgrey;
            border-collapse: collapse;
            height: 30px;
            text-align: right;
            padding: 0 5px;
        }

        .contentWrapper .ventTable thead th,
        .contentWrapper .ventTable .planDetailRow {
            text-align: center;
        }

        .contentWrapper .ventTable .descAtLeft {
            text-align: left;
        }

        .contentWrapper .ventTable thead tr {
            background-color: #d3d3d375;
        }

        .contentWrapper .tandcwrapper {
            margin-top: 38px;
        }

        ol li,
        .contentWrapper .ventTable tbody,
        .contentWrapper .innerDiv .fSize {
            font-size: 14px;
        }

        .p_size {
            font-size: 14px;
        }

        .mb {
            margin-bottom: 5px;
        }
    </style>
</head>

<body>
    @php

        $path = is_array($setting->value) && isset($setting->value['logo_image'])
        ? public_path('storage/Logo_Settings/' . $setting->value['logo_image'])
        : public_path('front-end/images/infiniylogo.png');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
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
    <div class="contentWrapper">
        <div class="companyLogo">
            <img src="{{$base64}}" alt="logo" class="logo" width="180" height="50">
        </div>
        <div class="vnetCompanyInfo">
            <h3>{{ $setting->value['site_name'] ?? '' }}</h3>
            <p><span>{{ $setting->value['address_1'] ?? '' }},
                    {{ $setting->value['address_2'] ?? '' }}, {{ $setting->value['city'] ?? '' }},
                    {{ $setting->value['pin'] ?? '' }}</span></p>
        </div>
        <div class="innerDiv invoiceDetails">
            <h3>Invoice# <span>{{ $invoice->invoice_number ?? '' }}</span></h3>
            <p>Invoice Date: <span>{{ $invoice->created_at ? $invoice->created_at->format('d-m-Y') : '-' }}</span></p>
            <p>Paid Date: <span>{{ $invoice->created_at ? $invoice->created_at->format('d-m-Y') : '-' }}</span></p>
            <p>Next Due Date:<span> {{ $nextDueDate }} </span></p>
        </div>
        <div class="innerDiv">
            <h3>Invoiced To</h3>
            <p><span>{{ $user->company_name ?? '' }}</span></p>
            <p class="fSize">Attn: <span class="username">{{ $user->name ?? '' }}</span></p>
            <p class="fSize"><span>{{ $user->address_line1 ?? '' }} , {{ $user->city ?? '' }}, {{ $user->postal_code ?? '' }}</span></p>
            <p class="fSize"><span>{{ $user->contact_number ?? '' }}</span></p>
            <p class="fSize"><span>{{ $user->email ?? '' }}</span></p>
        </div>
        <table class="ventTable">
            <thead>
                <tr>
                    <th scope="col">S.No.</th>
                    <th scope="col">Description</th>
                    <th scope="col">Validity</th>
                    <th scope="col">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="planDetailRow">1</td>
                    <td class="planDetailRow">{{ $product->name }} </td>
                    <td class="planDetailRow"> {{ $validity }} </td>
                    <td> {{ $product->currency ?? 'Rs.'}}  {{ number_format($invoice->subtotal, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="3">Sub-Total</td>
                    <td>{{ $product->currency ?? 'Rs.'}} {{ number_format($invoice->subtotal, 2) }} </td>
                </tr>
                @if ($invoice->gst_percentage > 0)
                    @php
                        $taxAmount =   ($invoice->subtotal * $invoice->gst_percentage) / 100;
                    @endphp
                    <tr>
                        <td colspan="3">GST ({{ intval($invoice->gst_percentage) }}%)(+)</td>
                        <td>{{ $product->currency ?? 'Rs'}} {{ isset($taxAmount) ? number_format($taxAmount, 2) : 0 }} </td>
                    </tr>
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
                    <tr>
                        <td colspan="3">Applied coupon: </td>
                        <td> {{ $invoice->coupon->coupon_code }}</td>
                    </tr>
                    <tr>
                        <td colspan="3">Discount ({{ $amount }})({{$text}})(-): </td>
                        <td>{{ $product->currency ?? 'Rs'}}  {{ number_format($invoice->discount, 2) ?? '' }} </td>
                    </tr>
                @endif
                <tr>
                   @php
                        $total = $invoice->total; 
                        $total = number_format($total, 2); 
                        if($invoice->discount > 0){
                            $total = $invoice->total;
                        }
                    @endphp
                    <td colspan="3">Total Amount</td>
                    <td>  {{ $product->currency ?? 'Rs.'}} {{ $total ?? '' }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>