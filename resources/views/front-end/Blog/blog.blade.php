@extends('front-end.common.master')@section('meta')
@section('styles')
    <link rel="stylesheet" href="{{ asset('front-end/css/home-page.css') }}">
    <link rel="stylesheet" href="{{ asset('front-end/css/checkout.css') }}">
    <!-- Slick Slider CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick-theme.css"/>
@endsection
@section('meta')
    <title>Market Place | {{ $seoData->title ?? 'Default Title' }} - {{ $seoData->description ?? 'Default Description' }}
    </title>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $seoData->description ?? 'Default description' }}">
    <meta name="keywords" content="{{ $seoData->keywords ?? 'default, keywords' }}">
    <meta property="og:title" content="{{ $seoData->title ?? 'Default Title' }}">
    <meta property="og:description" content="{{ $seoData->description ?? 'Default description' }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
@endsection
@section('content')
<!-- Integration section start -->
@php
    use Carbon\Carbon;
@endphp

<div class="int_bg blog mb-37">
    <div class="container">
         <p class="plugin-label">
            <span class="label-line"></span> Recent Posts
        </p>
        <div class="d_flex">
            <div class="integration">
                <h1>Latest From Our <span class="underline">Blog</span></h1>
                {{-- <img class="vector2_img" src="front-end/images/Vector 10.png" alt="not found"> --}}
            </div>
            <div class="arrow-container w-70">
                <a href="javascript:void(0)" role="button" data-slide="prev" id="blog-left-arrow-btn"><span class="arrow left-arrow"></span></a>
                <a href="javascript:void(0)" role="button" data-slide="next" id="blog-right-arrow-btn"><span class="arrow right-arrow"></span></a>
            </div>
        </div>
        <div id="blogCarousel" >
            <div class="row blog-slider">
                @foreach ($Blogs as $blog)
                    <div class="col-4 match-height-item">
                        <a href="{{ route('blog_details', ['category' => $blog->categoryname->name, 'slug' => Str::slug($blog->title)]) }}">
                        <img class="blog_img" src="{{ asset('storage/images/' . $blog->image) }}" alt="not found">
                        <div class="item">
                           <p class="badge">{{ $blog->categoryname->name ?? ''}}</p>
                            <h3 class="mb-4 mt-1">{{ $blog->title }}</h3>
                            <div class="blog_p">{!! $blog->short_description ?? '' !!}</div>
                            <div class="d-flex">
                                <a href="{{ route('blog_details', ['category' => $blog->categoryname->name, 'slug' => Str::slug($blog->title)]) }}" class="integration_know d-flex align-items-center">
                                    <span>Read More</span>
                                    <img class="know_arrow d-flex align-items-center" src="front-end/images/blue_arrow.png" alt="not found" style="margin-top: 1px;">
                                </a>
                            </div>
                        </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- Slick JS -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script>
     
        $(document).ready(function(){
            $('.blog-slider').slick({
                slidesToShow: 3,
                slidesToScroll: 1,
                arrows: false,
                autoplay: true,
                autoplaySpeed: 2000,
                responsive: [
                    {
                        breakpoint: 991,
                        settings: {
                            slidesToShow: 2,
                            dots: true,
                            arrows: false,
                        }
                    },
                    {
                        breakpoint: 767,
                        settings: {
                            slidesToShow: 1,
                            dots: true,
                            arrows: false,
                        }
                    }
                ]
            });

            $('#blog-left-arrow-btn').click(function(event) {
                event.preventDefault();
                $('.blog-slider').slick('slickPrev');
            });

            $('#blog-right-arrow-btn').click(function(event) {
                event.preventDefault();
                $('.blog-slider').slick('slickNext');
            });
        });

</script>
<!-- Integration section end -->
@endsection
