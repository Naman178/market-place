@extends('front-end.common.master')@section('meta')
@section('styles')
    <link rel="stylesheet" href="{{ asset('front-end/css/home-page.css') }}">
    <link rel="stylesheet" href="{{ asset('front-end/css/checkout.css') }}">
    <!-- Slick Slider CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick-theme.css"/>
    <style>
        .blog .item {
            height: auto !important;
        }
       .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            list-style: none;
            padding-left: 0;
            margin: 0;
            gap: 2px;
        }

        .pagination li {
            display: inline-flex;
        }

        .pagination li a,
        .pagination li span {
            padding: 6px 12px;
            font-size: 14px;
            border: 1px solid #ddd;
            background-color: white;
            color: #007AC1;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.2s, color 0.2s;
        }

        .pagination li a:hover {
            background-color: #e9f4ff;
            color: #0056b3;
        }

        .pagination .active span {
            background-color: #007AC1;
            color: #fff;
            border-color: #007AC1;
        }

        .pagination .disabled span,
        .pagination .disabled a {
            color: #ccc;
            pointer-events: none;
            background-color: #f8f9fa;
        }
        .match-height-item {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .match-height-item .blog_p {
            flex-grow: 1;
        }

        .mb-30{
                margin-bottom: 30px;
        }
    </style>
@endsection
@php 
    use App\Models\Settings;
    use App\Models\SEO;

    $site = Settings::where('key', 'site_setting')->first();

    $logoImage = $site['value']['logo_image'] ?? null;
    $ogImage = $logoImage 
        ? asset('storage/Logo_Settings/' . $logoImage) 
        : asset('front-end/images/infiniylogo.png');

    // Assuming you fetch SEO data for the blogs page like this:
    $seoData = SEO::where('page', 'blogs')->first();
@endphp

@section('meta')
@section('title'){{ $seoData->title ?? 'Blogs' }} @endsection

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

{{-- SEO Meta --}}
<meta name="description" content="{{ $seoData->description ?? 'Explore the latest blogs, insights, and trends on Market Place Main.' }}">
<meta name="keywords" content="{{ $seoData->keywords ?? 'blogs, insights, eCommerce, trends' }}">

{{-- Open Graph Meta --}}
<meta property="og:title" content="{{ $seoData->title ?? 'Blogs - Market Place Main' }}">
<meta property="og:description" content="{{ $seoData->description ?? 'Explore the latest blogs, insights, and trends on Market Place Main.' }}">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:type" content="website">
<meta property="og:image" content="{{ $ogImage }}">
<meta property="og:image:type" content="image/png">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">

{{-- Twitter Meta --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $seoData->title ?? 'Blogs - Market Place Main' }}">
<meta name="twitter:description" content="{{ $seoData->description ?? 'Explore the latest blogs, insights, and trends on Market Place Main.' }}">
<meta name="twitter:image" content="{{ $ogImage }}">
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
                <h1>Latest From Our <span class="underline">Blogs</span></h1>
            </div>
        </div>
        <div id="blogCarousel">
            <div class="row">
                @foreach ($Blogs as $blog)
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-30">
                        <a href="{{ route('blog_details', ['category' => $blog->categoryname->name, 'slug' => Str::slug($blog->title)]) }}">
                            <img class="blog_img" src="{{ asset('storage/images/' . $blog->image) }}" alt="not found">
                                <div class="item match-height-item p-3 bg-white rounded shadow-sm">
                                <p class="badge">{{ $blog->categoryname->name ?? ''}}</p>
                                <h3 class="mb-4 mt-1">{{ $blog->title }}</h3>
                                <div class="blog_p">{!! $blog->short_description ?? '' !!}</div>
                                <div class="d-flex">
                                    <a href="{{ route('blog_details', ['category' => $blog->categoryname->name, 'slug' => Str::slug($blog->title)]) }}" class="read_more_btn">
                                        <span class="text-line">
                                            <span class="text">Read More</span>
                                            <img class="know_arrow mt-0" src="{{ asset('front-end/images/blue_arrow.png') }}" alt="not found">
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if ($Blogs->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="pagination-info">
                        Showing {{ $Blogs->firstItem() }} to {{ $Blogs->lastItem() }} of {{ $Blogs->total() }} results
                    </div>
                    <div class="pagination-wrapper">
                        {!! $Blogs->links() !!}
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.matchHeight/0.7.2/jquery.matchHeight-min.js"></script>

<script>
$(document).ready(function() {
    // Wait for images to load
    $(window).on('load', function() {
        $('.match-height-item').matchHeight({
            property: 'min-height', // Match minimum height instead of exact height
            byRow: true // Only match items in the same row
        });
    });
    
    // Alternative: if images take too long to load
    setTimeout(function() {
        $('.match-height-item').matchHeight();
    }, 500);
});
</script>
@endsection