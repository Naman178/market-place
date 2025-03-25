@extends('layouts.master')
@php
    use App\Models\Settings;
    $site = Settings::where('key','site_setting')->first();
@endphp
@section('title')
    <title>{{$site["value"]["site_name"] ?? "Infinity"}} | {{ $socialmedia ? 'Edit: '.$socialmedia->id : 'New'}}</title>
@endsection
@section('page-css')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<style>
    .custom-textarea {
        height: auto !important;
    }
    .form-control{
        height: auto !important;
    }
    .form-group label {
        font-size: 16px !important;
    }
    .image-input {
        display: none;
    }
</style>
@endsection
<div class="loadscreen" id="preloader" style="display: none; z-index:90;">
    <div class="loader spinner-bubble spinner-bubble-primary"></div>
</div>
@section('main-content')
<div class="breadcrumb">
    <div class="col-sm-12 col-md-12">
        <h4> <a href="{{route('dashboard')}}" class="text-uppercase">{{$site["value"]["site_name"] ?? "Infinity"}}</a> | <a href="{{route('SocialMedia-index')}}">{{ trans('custom.SocialMedia_title') }}</a> | {{ trans('custom.SocialMedia_title') }} {{ $socialmedia ? 'Edit: '.$socialmedia->id : 'New'}} </a>
        <a href="javascript:history.back()" class="btn btn-outline-primary ml-2 float-right">Back</a>
        <div class="btn-group dropdown float-right">
            <button type="submit" class="btn btn-outline-primary erp-socialmedia-form">
                Save
            </button>
        </div>
    </div>
</div>
<h4 class="heading-color">{{ trans('custom.SocialMedia_title') }}</h4>
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-body">
                @if($socialmedia)
                    <form class="erp-socialmedia-submit" id="socialmedia_form" enctype="multipart/form-data" data-url="{{route('SocialMedia-store')}}" data-id="scid" data-name="name">
                        <input type="hidden" id="scid" class="erp-id" value="{{$socialmedia->id}}" name="scid" />
                        <input type="hidden" id="old_image" value="{{ $socialmedia->image }}" name="old_image" />
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="title_label">Name</label>
                                <input placeholder="Enter Name" class="form-control input-error" id="name" name="name" type="text" value="{{ $socialmedia->name }}">
                                <div class="error" style="color:red;" id="name_error"></div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="link">Link</label>
                                <input placeholder="Enter Link" class="form-control input-error" id="link" name="link" type="text" value="{{ $socialmedia->link }}">
                                <div class="error text-danger" id="link_error"></div>
                            </div>
                            <div class="form-group col-md-6 input-file-col">
                                <?php $showImagePrev = (!empty($socialmedia->image)) ? 'display:inline-block' : ''; ?>
                                <label for="socialmedia_image_label">Upload Image</label>
                                <label class="form-control filelabel image-input-wrapper">
                                    <input type="hidden" name="old_image" value="@if(!empty($socialmedia->image)){{$socialmedia->image}}@endif">
                                    <input type="file" name="image" id="socialmedia_image"  class="form-control input-error image-input">
                                    <span class="btn btn-outline-primary"><i class="i-File-Upload nav-icon font-weight-bold cust-icon"></i>Choose File</span>
                                    <img id="socialmedia_image_prev" class="previewImgCls hidepreviewimg" src="@if(!empty($socialmedia->image)){{asset('storage/images/'.$socialmedia->image)}}@endif" style="{{$showImagePrev}}">
                                    <span class="title" id="category_image_title">{{ $socialmedia->image ??  ''}}</span>
                                </label>
                                <div class="error" style="color:red;" id="image_error"></div>
                            </div>
                        </div>
                    </form>
                @else
                <form class="erp-socialmedia-submit" id="socialmedia_form" enctype="multipart/form-data" data-url="{{route('SocialMedia-store')}}" data-id="scid">
                    <input type="hidden" id="scid" class="erp-id" name="scid" value="0" />
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="title_label">Name</label>
                            {!! Form::text('name', null, array('placeholder' => 'Enter Name','class' => 'form-control input-error filelabel image-input-wrapper' , 'id' => 'name')) !!}
                            <div class="error" style="color:red;" id="name_error"></div>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="link">Link</label>
                            {!! Form::text('link', null, array('placeholder' => 'Enter Link','class' => 'form-control input-error' , 'id' => 'link')) !!}
                            <div class="error text-danger" id="link_error"></div>
                        </div>
                        <div class="form-group col-md-6 input-file-col">
                            <label for="socialmedia_image_label">Upload Image</label>
                            <label class="form-control filelabel image-input-wrapper">
                                <input type="hidden" name="old_image" value="">
                                <input type="file" name="image" id="socialmedia_image"  class="image-input form-control input-error">
                                <span class="btn btn-outline-primary"><i class="i-File-Upload nav-icon font-weight-bold cust-icon"></i>Choose File</span>
                                <img id="socialmedia_image_prev" class="previewImgCls hidepreviewimg" src="">
                                <span class="title" id="socialmedia_image_title"></span>
                            </label>
                            <div class="error" style="color:red;" id="image_error"></div>
                        </div>
                    </div>
                </form>
                @endif
            </div>
        </div> 
    </div>
</div>
<a href="javascript:history.back()" class="btn btn-outline-primary ml-2 float-right">Back</a>
<div class="btn-group dropdown float-right">
    <button type="submit" class="btn btn-outline-primary erp-socialmedia-form">
        Save
    </button>
</div>
@endsection
@section('page-js')
<script src="{{ asset('assets/js/common-bundle-script.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>
@endsection
@section('bottom-js')
    @include('pages.common.modal-script')  
    @include('pages.SocialMedia.SocialMedia-script')
@endsection