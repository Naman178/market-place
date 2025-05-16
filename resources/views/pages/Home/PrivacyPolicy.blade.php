@extends('front-end.common.master')

@php
    use App\Models\SEO;
    use App\Models\Settings;

    $seoData = SEO::where('page', 'privacy policy')->first();
    $site = Settings::where('key', 'site_setting')->first();
    $logoImage = $site['value']['logo_image'] ?? null;
    $ogImage = $logoImage 
        ? asset('storage/Logo_Settings/' . $logoImage) 
        : asset('front-end/images/infiniylogo.png');
@endphp

@section('title'){{ $seoData->title ?? 'Privacy Policy' }}@endsection

@section('meta')
    {{-- Charset & Viewport --}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- SEO Meta --}}
    <meta name="description" content="{{ $seoData->description ?? 'Read the privacy policy of Market Place to understand how we collect, use, and safeguard your data.' }}">
    <meta name="keywords" content="{{ $seoData->keywords ?? 'privacy policy, data protection, user information, Market Place' }}">

    {{-- Open Graph Meta --}}
    <meta property="og:title" content="{{ $seoData->title ?? 'Privacy Policy - Market Place' }}">
    <meta property="og:description" content="{{ $seoData->description ?? 'Learn about Market Place’s commitment to protecting your privacy and personal information.' }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">

    {{-- Twitter Meta --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seoData->title ?? 'Privacy Policy - Market Place' }}">
    <meta name="twitter:description" content="{{ $seoData->description ?? 'Learn about Market Place’s commitment to protecting your privacy and personal information.' }}">
    <meta name="twitter:image" content="{{ $ogImage }}">

    {{-- Optional OG Logo --}}
    @if ($site && $logoImage)
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
      .terms-and-condition  hr{
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
                <h3><span class="txt-black">Privacy </span><span class="color-blue underline"> Policy</span></h3>
            </div> 
            <div class="row"> 
                <div class="terms-and-condition cust-page-padding w-100">          
                    {{-- <h1 class="text-center feature_heading">Privacy Policy</h1> --}}
                    @foreach ($privacy_policies as  $privacy_policy)
                        <h4>{{ $privacy_policy->title ?? '' }}</h4>        
                        <p>{{ $privacy_policy->description ?? '' }}</p>
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts') 
@endsection