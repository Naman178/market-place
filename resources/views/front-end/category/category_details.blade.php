@extends('front-end.common.master')@section('meta')
@section('styles')
    <link rel="stylesheet" href="{{ asset('front-end/css/home-page.css') }}">
    <style>
        .main-content .container {
            max-width: 1375px;
        }

        .items-container .row {
            justify-content: start !important;
        }
        .underline::after{
            bottom: -45px !important;
        }
    </style>
@endsection
@php 
    use App\Models\Settings;

    $site = Settings::where('key', 'site_setting')->first();

    $logoImage = $site['value']['logo_image'] ?? null;
    $ogImage = $logoImage 
        ? asset('storage/Logo_Settings/' . $logoImage) 
        : asset('front-end/images/infiniylogo.png');
@endphp

@section('meta')
@section('title'){{ $seoData->title ?? $category->name }} @endsection

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

{{-- SEO Meta --}}
<meta name="description" content="{{ $seoData->description ?? 'Browse a wide range of products by category on Market Place Main. Find what you need easily and quickly.' }}">
<meta name="keywords" content="{{ $seoData->keywords ?? 'category, products, Market Place Main, browse, shopping' }}">

{{-- Open Graph Meta --}}
<meta property="og:title" content="{{ $seoData->title ?? $category->name }}">
<meta property="og:description" content="{{ $seoData->description ?? 'Explore our product categories and discover a variety of options tailored to your needs.' }}">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:type" content="website">
<meta property="og:image" content="{{ $ogImage }}">

{{-- Twitter Meta --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $seoData->title ?? $category->name }}">
<meta name="twitter:description" content="{{ $seoData->description ?? 'Explore our product categories and discover a variety of options tailored to your needs.' }}">
<meta name="twitter:image" content="{{ $ogImage }}">

{{-- Fallback Logo --}}
@if ($logoImage)
    <meta property="og:logo" content="{{ $ogImage }}" />
@else
    <meta property="og:logo" content="{{ asset('front-end/images/infiniylogo.png') }}" />
@endif
@endsection

@section('content')
    <div class="container items-container">
        <div class="title">
            <h3><span class="color-blue underline">{{ $category->name ?? ''}}</span></h3>
        </div>
        <div class="row">
            @if ($item->count() != 0)
                <div class="col-xl-12 col-md-12">
                    <div id="items-container" class="row">
                        @foreach ($item as $items)
                            <a href="{{ route('product.list', ['category' => Str::slug($category->name), 'slug' => Str::slug($items->name) ]) }}">
                                <div class="col-xl-4 col-md-6">
                                    <div class="wsus__gallery_item">
                                        <div class="wsus__gallery_item_img">
                                            <img src="{{ asset('public/storage/items_files/' . $items->thumbnail_image) }}"
                                                alt="gallery" class="img-fluid w-100">
                                        </div>
                                        <div class="wsus__gallery_item_text">
                                            <a class="title" href="{{ route('buynow.list', ['id' => $items->id]) }}">
                                                {{ $items->name }}</a>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @else
                <p>No Subcategory Found</p>
            @endif
        </div>
    </div>
@endsection
@section('scripts')
@endsection
