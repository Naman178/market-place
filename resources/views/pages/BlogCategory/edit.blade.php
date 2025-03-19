@extends('layouts.master')
@php
    use App\Models\Settings;
    $site = Settings::where('key','site_setting')->first();
@endphp
@section('title')
    <title>{{$site["value"]["site_name"] ?? "Infinity"}} | {{ $Blog_category ? 'Edit: '.$Blog_category->id : 'New'}}</title>
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
        <h4> <a href="{{route('dashboard')}}" class="text-uppercase">{{$site["value"]["site_name"] ?? "Infinity"}}</a> | <a href="{{route('Blog_category-index')}}">{{ trans('custom.Blog_category_title') }}</a> | {{ trans('custom.Blog_category_title') }} {{ $Blog_category ? 'Edit: '.$Blog_category->id : 'New'}} </a>
        <a href="javascript:history.back()" class="btn btn-outline-primary ml-2 float-right">Back</a>
        <div class="btn-group dropdown float-right">
            <button type="submit" class="btn btn-outline-primary erp-Blog_category-form">
                Save
            </button>
        </div>
    </div>
</div>
<h4 class="heading-color">{{ trans('custom.Blog_category_title') }}</h4>
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-body">
                @if($Blog_category)
                    <form class="erp-Blog_category-submit" id="Blog_category_form" enctype="multipart/form-data" data-url="{{route('Blog_category-store')}}" data-id="scid" data-name="name">
                        <input type="hidden" id="scid" class="erp-id" value="{{$Blog_category->category_id}}" name="scid" />
                        <input type="hidden" id="old_image" value="{{ $Blog_category->image }}" name="old_image" />
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="title_label">Name</label>
                                <input placeholder="Enter Name" class="form-control input-error" id="name" name="name" type="text" value="{{ $Blog_category->name }}">
                                <div class="error" style="color:red;" id="name_error"></div>
                            </div>
                            <div class="form-group col-md-6 input-file-col">
                                <?php $showImagePrev = (!empty($Blog_category->image)) ? 'display:inline-block' : ''; ?>
                                <label for="Blog_category_image_label">Upload Image</label>
                                <label class="form-control filelabel image-input-wrapper">
                                    <input type="hidden" name="old_image" value="@if(!empty($Blog_category->image)){{$Blog_category->image}}@endif">
                                    <input type="file" name="image" id="Blog_category_image"  class="form-control input-error image-input">
                                    <span class="btn btn-outline-primary"><i class="i-File-Upload nav-icon font-weight-bold cust-icon"></i>Choose File</span>
                                    <img id="Blog_category_image_prev" class="previewImgCls hidepreviewimg" src="@if(!empty($Blog_category->image)){{asset('storage/images/'.$Blog_category->image)}}@endif" style="{{$showImagePrev}}">
                                    <span class="title" id="category_image_title">{{ $Blog_category->image ??  ''}}</span>
                                </label>
                                <div class="error" style="color:red;" id="image_error"></div>
                            </div>
                            {{-- <div class="form-group col-md-6">
                                <label for="image">Upload Image</label>
                                <input type="file" class="form-control-file" id="image" name="image">
                                <img class="mt-2" src="{{ asset('storage/images/' .$Blog_category->image) }}" width="100px" alt="not found">
                                <div class="error" style="color:red;" id="image_error"></div>
                            </div> --}}

                            <div class="form-group col-md-12">
                                <label for="description">Description</label>
                                <div id="quill_editor" class="quill_editor" style="height: 200px; width:100%;">{!!$Blog_category->description!!}</div>
                                <input type="hidden" name="description" id="description" value="{{$Blog_category->description}}">
                                <div class="error" style="color:red;" id="description_error"></div>
                            </div>
                        </div>
                    </form>
                @else
                <form class="erp-Blog_category-submit" id="Blog_category_form" enctype="multipart/form-data" data-url="{{route('Blog_category-store')}}" data-id="scid">
                    <input type="hidden" id="scid" class="erp-id" name="scid" value="0" />
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="title_label">Name</label>
                            {!! Form::text('name', null, array('placeholder' => 'Enter Name','class' => 'form-control input-error filelabel image-input-wrapper' , 'id' => 'name')) !!}
                            <div class="error" style="color:red;" id="name_error"></div>
                        </div>
                        {{-- <div class="form-group col-md-6">
                            <label for="image">Upload Image</label>
                            <input type="file" class="form-control-file" id="image" name="image">
                            
                            <div id="image-previews" class="mt-2">
                            </div>
                            
                            <div class="error" style="color:red;" id="image_error"></div>
                        </div> --}}
                        <div class="form-group col-md-6 input-file-col">
                            <label for="Blog_category_image_label">Upload Image</label>
                            <label class="form-control filelabel image-input-wrapper">
                                <input type="hidden" name="old_image" value="">
                                <input type="file" name="image" id="Blog_category_image"  class="image-input form-control input-error">
                                <span class="btn btn-outline-primary"><i class="i-File-Upload nav-icon font-weight-bold cust-icon"></i>Choose File</span>
                                <img id="Blog_category_image_prev" class="previewImgCls hidepreviewimg" src="">
                                <span class="title" id="Blog_category_image_title"></span>
                            </label>
                            <div class="error" style="color:red;" id="image_error"></div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="description">Description</label>
                            <div id="quill_editor" class="quill_editor" style="height: 200px; width:100%;"></div>
                            <input type="hidden" name="description" id="description">
                            
                            <div class="error" style="color:red;" id="description_error"></div>
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
    <button type="submit" class="btn btn-outline-primary erp-Blog_category-form">
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
    @include('pages.BlogCategory.Blog_category-script')
@endsection