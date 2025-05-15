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
@section('meta')
    <title>Market Place | {{ $seoData->title ?? 'Default Title' }} - {{ $seoData->description ?? 'Default Description' }}
    </title>
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
