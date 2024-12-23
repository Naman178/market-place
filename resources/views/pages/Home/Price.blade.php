@extends('front-end.common.master')@section('meta')
@section('styles')
<link rel="stylesheet" href="{{ asset('front-end/css/home-page.css') }}">
@endsection
@section('meta')
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
@section('content')
{{-- <div class="cust-page-padding">
        <div class="container">  
            <div class="row justify-content-center"> 
                <div class="terms-and-condition cust-page-padding">          
                    <h1 class="text-center feature_heading">FAQ</h1>
                    @foreach ($term_conditions as $term_condition)
                        <h4>{{ $term_condition->title ?? '' }}</h4>        
                        <p>{{ $term_condition->description ?? '' }}</p>
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div> --}}
    <div class="container items-container">
        <div class="title">
            <h3><span class="txt-black">Our</span> <span class="color-blue underline-text">Plans</span></h3>
        </div>
        <div class="row">
            @foreach ($data['items'] as $key => $item)
                @if ($item && $item->features && $item->pricing)
                    <div class="col bg-blue">
                        <div class="item-wrapper">
                            <div class="header">
                                <div class="thumb-img">
                                    <img src="@if (!empty($item->thumbnail_image)) {{ asset('storage/items_files/' . $item->thumbnail_image) }} @endif" alt="{{ $item->name }}">
                                </div>
                                <div class="item-name txt-white">
                                    <h3>{{ $item->name }}</h3>
                                </div>
                            </div>
                            <div class="description">
                                <p class="txt-white">{{ $item->description }}</p>
                            </div>
                            <div class="price">
                                <h2>&#8377; {{ (int) $item->pricing->fixed_price }} <span class="duration">/monthly</span></h2>
                            </div>
                            <div class="feature txt-white">
                                <p class="title">What's included</p>
                                <ul>
                                    @foreach($item->features as $feature)
                                        @if ($feature)
                                            <li>{{ $feature->key_feature }}</li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                            <div class="btn">
                                <a href="{{ route("checkout", ["id" => base64_encode($item->id)]) }}" target="_blank" rel="noopener noreferrer">Get started</a>
                            </div>
                        </div>
                        {{-- <div class="description">
                            <p class="txt-white">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
                        </div> --}}
                        {{-- <div class="price">
                            <h2>&#8377; {{ (int) $item->pricing->fixed_price }} <span class="duration">/monthly</span></h2>
                        </div>
                        <div class="feature txt-white">
                            <p class="title">What's included</p>
                            <ul>
                                @foreach($item->features as $feature)
                                    <li>{{ $feature->key_feature }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="btn">
                            <a href="{{ route('checkout', ["id" => $item->id]) }}" class="checkout_btn" target="_blank" rel="noopener noreferrer">Get started</a>
                        </div> --}}
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endsection
@section('scripts')
<script>
 function toggleAccordion(header) {
    const body = header.nextElementSibling;
    if (body && body.classList) {
        body.classList.toggle("show");
        header.classList.toggle("collapsed");
    } else {
        console.error("Accordion structure issue: 'accordion-body' not found for this header.");
    }
}

</script>
@endsection
