@extends('layouts.master')
@php
    use App\Models\Settings;
    $site = Settings::where('key','site_setting')->first();
@endphp
@section('title')
    <title>{{$site["value"]["site_name"] ?? "Infinity"}} | {{ $sub_category ? 'Edit: '.$sub_category->id : 'New'}}</title>
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
    .previewImgCls:hover{
        transform: scale(5.0);
        border-radius: 2px;
        z-index: 1;
    }

    .previewImgCls{
        display: none;
    }
    
    .select2-container .select2-selection--single {
        padding-bottom: 2px;
        padding-top: 2px;
        height: unset;
    }
</style>
@endsection
<div class="loadscreen" id="preloader" style="display: none; z-index:90;">
    <div class="loader spinner-bubble spinner-bubble-primary"></div>
</div>
@section('main-content')
<div class="breadcrumb">
    <div class="col-sm-12 col-md-12">
        <h4> <a href="{{route('dashboard')}}" class="text-uppercase">{{$site["value"]["site_name"] ?? "Infinity"}}</a> | <a href="{{route('sub-category-index')}}">{{ trans('custom.sub_category_title') }}</a> | {{ trans('custom.sub_category_title') }} {{ $sub_category ? 'Edit: '.$sub_category->id : 'New'}} </a>
        <a href="javascript:history.back()" class="btn btn-outline-primary ml-2 float-right">Back</a>
        <div class="btn-group dropdown float-right">
            <button type="submit" class="btn btn-outline-primary erp-sub-category-form">
                Save
            </button>
        </div>
    </div>
</div>
<h4 class="heading-color">{{ trans('custom.sub_category_title') }}</h4>
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-body">
                @if($sub_category)
                    <form class="erp-sub-category-submit" id="sub_category_form" data-url="{{route('sub-category-store')}}" data-id="scid" data-name="name">
                        <input type="hidden" id="scid" class="erp-id" value="{{$sub_category->id}}" name="scid" />
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="name_label">Name</label>
                                <input placeholder="Enter sub category Name" class="form-control input-error" id="sub_category_name" name="name" type="text" value="{{ $sub_category->name }}">
                                <div class="error" style="color:red;" id="name_error"></div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="parent_category_label">Parent category</label>
                                {!! Form::select('parent_category_id', ['' => 'Select category'] + $categories, $sub_category->category_id, ['class' => 'form-control select-input', 'id' => 'parent_category']) !!}
                                <div class="error" style="color:red;" id="parent_category_error"></div>
                            </div>
                            <div class="form-group col-md-12 input-file-col">
                                <?php $showImagePrev = (!empty($sub_category->image)) ? 'display:inline-block' : ''; ?>
                                <label for="category_image">Image</label>
                                <label class="form-control filelabel image-input-wrapper">
                                    <input type="hidden" name="old_image" value="@if(!empty($sub_category->image)){{$sub_category->image}}@endif">
                                    <input type="file" name="image" id="category_image"  class="form-control input-error image-input">
                                    <span class="btn btn-outline-primary"><i class="i-File-Upload nav-icon font-weight-bold cust-icon"></i>Choose File</span>
                                    <img id="category_image_prev" class="previewImgCls hidepreviewimg" src="@if(!empty($sub_category->image)){{asset('storage/sub_category_images/'.$sub_category->image)}}@endif" style="{{$showImagePrev}}">
                                    <span class="title" id="sub_category_image_title">{{ $sub_category->image ??  ''}}</span>
                                </label>
                                <div class="error" style="color:red;" id="image_error"></div>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="category_status_label" class="">Status</label>
                                <div class="ul-form__radio-inline">
                                    <label class=" ul-radio__position radio radio-primary form-check-inline">
                                        <input type="radio" name="status" value="0" <?php if($sub_category->sys_state == 0){echo 'checked="checked"';} ?>>
                                        <span class="ul-form__radio-font">Active</span>
                                        <span class="checkmark"></span>
                                    </label>
                                    <label class="ul-radio__position radio radio-primary">
                                        <input type="radio" name="status" value="1" <?php if($sub_category->sys_state == 1){echo 'checked="checked"';} ?>>
                                        <span class="ul-form__radio-font">Deactive</span>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="error" style="color:red;" id="status_error"></div>
                            </div>
                        </div>
                    </form>
                @else
                <form class="erp-sub-category-submit" id="sub_category_form" data-url="{{route('sub-category-store')}}" data-id="scid">
                    <input type="hidden" id="scid" class="erp-id" name="scid" value="0" />
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="name_label">Name</label>
                            {!! Form::text('name', null, array('placeholder' => 'Enter sub category Name','class' => 'form-control input-error' , 'id' => 'sub_category_name')) !!}
                            <div class="error" style="color:red;" id="name_error"></div>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="parent_category_label">Parent category</label>
                            {!! Form::select('parent_category_id', ['' => 'Select category'] + $categories, null, ['class' => 'form-control select-input', 'id' => 'parent_category']) !!}
                            <div class="error" style="color:red;" id="parent_category_error"></div>
                        </div>
                        <div class="form-group col-md-12 input-file-col">
                            <label for="category_image_label">Image</label>
                            <label class="form-control filelabel image-input-wrapper">
                                <input type="file" name="image" id="category_image"  class="image-input form-control input-error">
                                <span class="btn btn-outline-primary"><i class="i-File-Upload nav-icon font-weight-bold cust-icon"></i>Choose File</span>
                                <img id="category_image_prev" class="previewImgCls hidepreviewimg" src="">
                                <span class="title" id="sub_category_image_title"></span>
                            </label>
                            <div class="error" style="color:red;" id="image_error"></div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="category_status_label" class="">Status</label>
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
    <button type="submit" class="btn btn-outline-primary erp-sub-category-form">
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
    @include('pages.sub-category.subcategory-script')
@endsection