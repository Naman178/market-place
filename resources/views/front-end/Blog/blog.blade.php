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
    </style>
@endsection
@section('meta')
    @section('title'){{'Blogs'}} @endsection
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
            </div>
        </div>
        <div id="blogCarousel">
            <div class="row">
                @foreach ($Blogs as $blog)
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-5">
                        <a href="{{ route('blog_details', ['category' => $blog->categoryname->name, 'slug' => Str::slug($blog->title)]) }}">
                            <img class="blog_img" src="{{ asset('storage/images/' . $blog->image) }}" alt="not found">
                                <div class="item match-height-item p-3 bg-white rounded shadow-sm">
                                <p class="badge">{{ $blog->categoryname->name ?? ''}}</p>
                                <h3 class="mb-4 mt-1">{{ $blog->title }}</h3>
                                <div class="blog_p">{!! $blog->short_description ?? '' !!}</div>
                                <div class="d-flex">
                                    <a href="{{ route('blog_details', ['category' => $blog->categoryname->name, 'slug' => Str::slug($blog->title)]) }}" class="integration_know d-flex align-items-center">
                                        <span>Read More</span>
                                        <img class="know_arrow ms-2" src="{{ asset('front-end/images/blue_arrow.png') }}" alt="not found">
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