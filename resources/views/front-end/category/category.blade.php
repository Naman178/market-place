@extends('front-end.common.master')@section('meta')
@section('styles')
    <link rel="stylesheet" href="{{ asset('front-end/css/home-page.css') }}">
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
            <h3><span class="txt-black">Sub</span> <span class="color-blue underline-text">Category</span></h3>
        </div>
        <div class="container" style="padding-left: 330px; padding-right:330px;">
            <div class="row" style="display: flex; justify-content:space-between; align-items:center;">
                @if ($subcategory->count() != 0)
                    @foreach ($subcategory as $item)
                        <div class="col-lg-4 col-12 mt-2 mb-2" style="cursor: pointer;">
                            <a href="{{ route('product.list', ['subcategory' => $item->id]) }}">
                                <div style="position: absolute; z-index:1; left:35px; color:white;">
                                    <h1>{{ $item->name }}</h1>
                                </div>
                                <div class="card" style="width:410px; height:400px;">
                                    <div class="card-body" style="padding: 0px;">
                                        <img src="{{ asset('public/storage/sub_category_images/' . $item->image) }}"
                                            alt="Sub-Category Image" style="width: 100%; padding:7px; height:399px;">
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @else
                    <p>No Subcategory Found</p>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('scripts')

@endsection
