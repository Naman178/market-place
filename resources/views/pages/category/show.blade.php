@extends('layouts.master')
@php
    use App\Models\Settings;
    use Carbon\Carbon;

    $site = Settings::where('key','site_setting')->first();

    $createdDate = Carbon::parse($category->created_at);
    $formattedDate = $createdDate->format('d.m.Y');
@endphp
@section('title')
    <title>{{$site["value"]["site_name"] ?? "Infinity"}} | {{ $category ? $category->name : ''}}</title>
@endsection
@section('page-css')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<style>
    .category-img{
        height: 300px;
        object-fit: cover;
    }
    .ul-widget-card__title{
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        margin: 0;
    }
</style>
@endsection
<div class="loadscreen" title="preloader" style="display: none; z-index:90;">
    <div class="loader spinner-bubble spinner-bubble-primary"></div>
</div>
@section('main-content')
<div class="breadcrumb">
    <div class="col-sm-12 col-md-12">
        <h4> <a href="{{route('dashboard')}}" class="text-uppercase">{{$site["value"]["site_name"] ?? "Infinity"}}</a> | <a href="{{route('category-index')}}">Category</a> | Category {{ $category ? 'View: '.$category->name : ''}} </a>
        <a href="javascript:history.back()" class="btn btn-outline-primary ml-2 float-right">Back</a>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="ul-widget-card__title"><span>{{ $category->name }}</span>
                    @if($category->sys_state == 0)
                        <span class="badge badge-pill badge-success m-2">Active</span>
                    @else
                        <span class="badge badge-pill badge-danger m-2">Deactive</span>
                    @endif
                </h5>
                <p class="d-flex align-items-center"><i class="i-Calendar-4 mr-2"></i>{{$formattedDate}}</p>
                <img class="d-block w-100 rounded category-img" src="@if(!empty($category->image)){{asset('storage/category_images/'.$category->image)}}@endif" alt="Second slide">

               <!--  <div class="ul-widget-card__rate-icon --version-2">
                    <span class="d-flex align-items-center"><i class="i-Calendar-4 mr-2"></i>{{ $category->updated_at }}</span>
                </div> -->
            </div>
        </div>
       <!--  <div class="card bg-dark text-white o-hidden mb-4">
            <img class="card-img" src="@if(!empty($category->image)){{asset('storage/category_images/'.$category->image)}}@endif" alt="Card image">
            <div class="card-img-overlay">
                <h5 class="card-title text-white">{{ $category->name }}</h5>
                <p class="card-text">{{ $category->sys_state == 0 ? 'Active':'Deactive' }}</p>
                <p class="card-text">{{ $category->updated_at }}</p>
            </div>
        </div> -->
    </div>
</div>
<a href="javascript:history.back()" class="btn btn-outline-primary ml-2 float-right">Back</a>
@endsection