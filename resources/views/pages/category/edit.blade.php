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
    .myfrm{
        display:none;
    }
    .filelabel{
        height: auto;
        margin-bottom:0;
    }
    .image-prev{
        height: 100px;
        width: 100px;
        position: absolute;
    }
    .image-prev img{
        position: absolute;
        height: 100%;
        width: 100%;
        object-fit: cover;
    }

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
        <h4> <a href="{{route('dashboard')}}" class="text-uppercase">{{$site["value"]["site_name"] ?? "Infinity"}}</a> | <a href="{{route('category-index')}}">Category</a> | Category {{ $category ? 'Edit: '.$category->id : 'New'}} </a>
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
                            <div class="col-md-6 form-group">
                                <label for="name">Category Name</label>
                                <input placeholder="Enter Category Name" class="form-control" id="name" name="name" type="text" value="{{ $category->name }}">
                                <div class="error" style="color:red;" id="name_error"></div>
                            </div>
                            <div class="form-group col-md-6 input-file-col">
                                <?php $showFavIcon = (!empty($category->image)) ? 'display:inline-block' : ''; ?>
                                <label for="category_image">Category Image</label>
                                <div class="input-group mb-3">
                                    <div class="custom-file">
                                        <input type="hidden" name="old_image" value="@if(!empty($category->image)){{$category->image}}@endif">
                                        <input type="file" name="image" id="category_image"  class="custom-file-input">
                                        <label class="custom-file-label" for="inputGroupFile02" aria-describedby="inputGroupFileAddon02">Choose file</label>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="inputGroupFileAddon02">Upload</span>
                                    </div>
                                </div>
                                <div class="error" style="color:red;" id="image_error"></div>
                                <div class="image-prev">
                                    <p class="title" id="category_image_title">@if(!empty($category->image)){{$category->image}}@endif</p>
                                    <img id="category_image_prev" class="previewImgCls hidepreviewimg" src="@if(!empty($category->image)){{asset('storage/category_images/'.$category->image)}}@endif" style="{{$showFavIcon}}">
                                </div>
                            </div>
                            <div class="form-group col-md-6 ">
                                <label for="category_status" class="">Category status:</label>
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
                        <div class="col-md-6 form-group">
                            <label for="name">Category Name</label>
                            {!! Form::text('name', null, array('placeholder' => 'Enter Category Name','class' => 'form-control' , 'id' => 'category_name')) !!}
                            <div class="error" style="color:red;" id="name_error"></div>
                        </div>
                        <div class="form-group col-md-6 input-file-col">
                            <label for="category_image">Category Image</label>
                            <div class="input-group mb-3">
                                <div class="custom-file">
                                    <input type="file" name="image" id="category_image"  class="custom-file-input">
                                    <label class="custom-file-label" for="inputGroupFile02" aria-describedby="inputGroupFileAddon02">Choose file</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="inputGroupFileAddon02">Upload</span>
                                </div>
                            </div>
                            <div class="error" style="color:red;" id="image_error"></div>
                            <div class="image-prev">
                                <p class="title" id="category_image_title"></p>
                                <img id="category_image_prev" class="previewImgCls hidepreviewimg" src="">
                            </div>
                        </div>
                        <div class="form-group col-md-6 ">
                            <label for="category_status" class="">Category status:</label>
                            <div class="ul-form__radio-inline">
                                <label class=" ul-radio__position radio radio-primary form-check-inline">
                                    <input type="radio" name="status" value="0">
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
@endsection
@section('bottom-js')
    @include('pages.category.script')
    @include('pages.common.modal-script')
@endsection