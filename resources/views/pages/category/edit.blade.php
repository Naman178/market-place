@extends('layouts.master')
@php
    use App\Models\Settings;
    $site = Settings::where('key','site_setting')->first();
@endphp
@section('title')
    <title>{{$site["value"]["site_name"] ?? "Infinity"}} | {{ $category ? 'Edit: '.$category->id : 'New'}}</title>
@endsection
@section('page-css')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<style>
    .image-input{
        display:none;
    }
    .filelabel{
        height: auto;
        margin-bottom:0;
    }
    .previewImgCls{
        width: 50px;
        height: 50px;
        margin: 0 20px;
        object-fit: scale-down!important;
        transition: transform .2s;
        position: relative;
    }
    /* .previewImgCls:hover{
        transform: scale(5.0);
        border-radius: 2px;
        z-index: 1;
    } */

    .previewImgCls{
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
        <h4> <a href="{{route('dashboard')}}" class="text-uppercase">{{$site["value"]["site_name"] ?? "Infinity"}}</a> | <a href="{{route('category-index')}}">Category</a> | Category {{ $category ? 'Edit: '.$category->name : 'New'}} </a>
        <a href="javascript:history.back()" class="btn btn-outline-primary ml-2 float-right">Back</a>
        <div class="btn-group dropdown float-right">
            <button type="submit" class="btn btn-outline-primary erp-category-form">
                Save
            </button>
        </div>
    </div>
</div>
<h4 class="heading-color">Category</h4>
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-body">
                @if($category)
                    <form class="erp-category-submit" id="category_form" data-url="{{route('category-store')}}" data-id="uid" data-name="name" data-email="email" data-pass="password">
                        <input type="hidden" id="erp-id" class="erp-id" value="{{$category->id}}" name="cid" />
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="name_label">Category Name</label>
                                <input placeholder="Enter Category Name" class="form-control input-error" id="category_name" name="name" type="text" value="{{ $category->name }}">
                                <div class="error" style="color:red;" id="name_error"></div>
                            </div>
                            <div class="form-group col-md-12 input-file-col">
                                <?php $showImagePrev = (!empty($category->image)) ? 'display:inline-block' : ''; ?>
                                <label for="category_image_label">Category Image</label>
                                <label class="form-control filelabel image-input-wrapper">
                                    <input type="hidden" name="old_image" value="@if(!empty($category->image)){{$category->image}}@endif">
                                    <input type="file" name="image" id="category_image"  class="form-control input-error image-input">
                                    <span class="btn btn-outline-primary"><i class="i-File-Upload nav-icon font-weight-bold cust-icon"></i>Choose File</span>
                                    <img id="category_image_prev" class="previewImgCls hidepreviewimg" src="@if(!empty($category->image)){{asset('storage/category_images/'.$category->image)}}@endif" style="{{$showImagePrev}}">
                                    <span class="title" id="category_image_title">{{ $category->image ??  ''}}</span>
                                </label>
                                <div class="error" style="color:red;" id="image_error"></div>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="category_status_label" class="">Category status:</label>
                                <div class="ul-form__radio-inline">
                                    <label class=" ul-radio__position radio radio-primary form-check-inline">
                                        <input type="radio" name="status" value="0" <?php if($category->sys_state == 0){echo 'checked="checked"';} ?>>
                                        <span class="ul-form__radio-font">Active</span>
                                        <span class="checkmark"></span>
                                    </label>
                                    <label class="ul-radio__position radio radio-primary">
                                        <input type="radio" name="status" value="1" <?php if($category->sys_state == 1){echo 'checked="checked"';} ?>>
                                        <span class="ul-form__radio-font">Deactive</span>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="error" style="color:red;" id="status_error"></div>
                            </div>
                        </div>
                    </form>
                @else
                <form class="erp-category-submit" id="category_form" data-url="{{route('category-store')}}" data-id="cid">
                    <input type="hidden" id="erp-id" class="erp-id" name="cid" value="0" />
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="name_label">Category Name</label>
                            {!! Form::text('name', null, array('placeholder' => 'Enter Category Name','class' => 'form-control input-error' , 'id' => 'category_name')) !!}
                            <div class="error" style="color:red;" id="name_error"></div>
                        </div>
                        <div class="form-group col-md-12 input-file-col">
                            <label for="category_image_label">Category Image</label>
                            <label class="form-control filelabel image-input-wrapper">
                                <input type="hidden" name="old_image" value="">
                                <input type="file" name="image" id="category_image"  class="image-input form-control input-error">
                                <span class="btn btn-outline-primary"><i class="i-File-Upload nav-icon font-weight-bold cust-icon"></i>Choose File</span>
                                <img id="category_image_prev" class="previewImgCls hidepreviewimg" src="">
                                <span class="title" id="category_image_title"></span>
                            </label>
                            <div class="error" style="color:red;" id="image_error"></div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="category_status_label" class="">Category status:</label>
                            <div class="ul-form__radio-inline">
                                <label class=" ul-radio__position radio radio-primary form-check-inline">
                                    <input type="radio" name="status" value="0" checked>
                                    <span class="ul-form__radio-font">Active</span>
                                    <span class="checkmark"></span>
                                </label>
                                <label class="ul-radio__position radio radio-primary">
                                    <input type="radio" name="status" value="1">
                                    <span class="ul-form__radio-font">Deactive</span>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="error" style="color:red;" id="status_error"></div>
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
    <button type="submit" class="btn btn-outline-primary erp-category-form">
        Save
    </button>
</div>
@endsection
@section('page-js')
<script src="{{asset('assets/js/carousel.script.js')}}"></script>
<script src="{{ asset('js/custom.js') }}"></script>
@endsection
@section('bottom-js')
    @include('pages.common.modal-script')
@endsection