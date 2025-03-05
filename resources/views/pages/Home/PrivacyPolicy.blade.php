@extends('front-end.common.master')@section('meta')
<title>Market Place | {{ $seoData->title ?? 'Default Title' }} - {{ $seoData->description ?? 'Default Description' }}</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="{{ $seoData->description ?? 'Default description' }}">
<meta name="keywords" content="{{ $seoData->keywords ?? 'default, keywords' }}">
<meta property="og:title" content="{{ $seoData->title ?? 'Default Title' }}">
<meta property="og:description" content="{{ $seoData->description ?? 'Default description' }}">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:type" content="website">
@endsection
@section('styles')
<link rel="stylesheet" href="{{ asset('front-end/css/register.css') }}">
    <style>
        .cust-page-padding {
            padding: 2rem 58px 5rem;
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
    </style>
@endsection
@section('content')
    <div class="cust-page-padding">
        <div class="container register-container"> 
            <div class="title">
                <h3><span class="txt-black">Privacy </span><span class="color-blue underline-text"> Policy</span></h3>
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