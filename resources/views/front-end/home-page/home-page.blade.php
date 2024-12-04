@extends('front-end.common.master')
@section('styles')
<link rel="stylesheet" href="{{ asset('front-end/css/home-page.css') }}">
<!-- Slick CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>

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
@include('front-end.home-page.section.hero_banner')
@include('front-end.home-page.section.plugins')
@include('front-end.home-page.section.Integration')
@include('front-end.home-page.section.Features')
@include('front-end.home-page.section.items-grid')
@endsection
@section('scripts')
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

<!-- Slick JS -->
<script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

<script>
   $(document).ready(function () {
    $('.slider').slick({
        slidesToShow: 3,
        slidesToScroll: 1, 
        infinite: true,
        // dots: true, 
        arrows: true,
        autoplay: true,
        autoplaySpeed: 3000,
        // prevArrow: '<img class="slick-prev" src="{{ asset("front-end/images/Arrow_scroll.png") }}" alt="Prev">',
        // nextArrow: '<img class="slick-next" src="{{ asset("front-end/images/Arrow_scroll.png") }}" alt="Next">'
    });
});


</script>
@endsection