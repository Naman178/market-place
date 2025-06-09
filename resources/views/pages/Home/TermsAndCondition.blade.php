@extends('front-end.common.master')

@php 
    use App\Models\Settings;
    use App\Models\SEO;

    $seoData = SEO::where('page', 'terms and conditions')->first();
    $site = Settings::where('key', 'site_setting')->first();

    $logoImage = $site['value']['logo_image'] ?? null;
    $ogImage = $logoImage 
        ? asset('storage/Logo_Settings/' . $logoImage) 
        : asset('front-end/images/infiniylogo.png');
@endphp

@section('title'){{ $seoData->title ?? 'Terms and Conditions' }}@endsection

@section('meta')
    {{-- SEO Meta --}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $seoData->description ?? 'Read the terms and conditions of using Market Place Main. Understand your rights and responsibilities as a user.' }}">
    <meta name="keywords" content="{{ $seoData->keywords ?? 'terms and conditions, legal, user agreement, Market Place Main' }}">

    {{-- Open Graph Meta --}}
    <meta property="og:title" content="{{ $seoData->title ?? 'Terms and Conditions - Market Place Main' }}">
    <meta property="og:description" content="{{ $seoData->description ?? 'Understand the legal agreement when using Market Place Main.' }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:image" content="{{ $ogImage }}">

    {{-- Twitter Meta --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seoData->title ?? 'Terms and Conditions - Market Place Main' }}">
    <meta name="twitter:description" content="{{ $seoData->description ?? 'Understand the legal agreement when using Market Place Main.' }}">
    <meta name="twitter:image" content="{{ $ogImage }}">

    {{-- Custom Logo for OG --}}
    @if ($logoImage)
        <meta property="og:logo" content="{{ asset('storage/Logo_Settings/' . $logoImage) }}" />
    @else
        <meta property="og:logo" content="{{ asset('front-end/images/infiniylogo.png') }}" />
    @endif
@endsection
@section('styles')
<link rel="stylesheet" href="{{ asset('front-end/css/register.css') }}">
    <style>
        .cust-page-padding {
            padding: 2rem 10rem 5rem;
        }
        h1.feature_heading {
            margin-top: 0;
        }
        .terms-and-condition h1, .privacy-policy h1, .cancellation-and-refund-policy h1, .about-us h1 {
            margin-bottom: 50px;
        }
        .feature_heading {
            font-style: normal;
            font-weight: 600;
            font-size: 40px;
            line-height: 52px;
            color: #182433;
            margin: 80px 0 85px;
        }
        .terms-and-condition hr{
            border: none;
            border-bottom: 1px solid #007ac1;
        }
        .underline::after{
            bottom: -45px !important;
        }
    </style>
@endsection
@section('content')
    <div class="cust-page-padding">
        <div class="container register-container"> 
            <div class="title">
                <h3><span class="txt-black">Terms and </span><span class="color-blue underline"> Conditions</span></h3>
            </div> 
            <div class="row  "> 
                <div class="terms-and-condition cust-page-padding w-100">          
                    {{-- <h1 class="text-center feature_heading">Terms and Conditions</h1> --}}
                    @foreach ($term_conditions as  $term_condition)
                        <h4>{{ $term_condition->title ?? '' }}</h4>        
                        <p>{!! $term_condition->description ?? '' !!}</p>
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts') 
@endsection