@extends('layouts.master')
@php
    use App\Models\Settings;
    $site = Settings::where('key','site_setting')->first();
@endphp
@section('title')
    <title>{{$site["value"]["site_name"] ?? "Infinity"}} | {{ $item ? 'Edit: '.$item->id : 'New'}}</title>
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
    
</style>
@endsection
<div class="loadscreen" id="preloader" style="display: none; z-index:90;">
    <div class="loader spinner-bubble spinner-bubble-primary"></div>
</div>
@section('main-content')
<div class="breadcrumb">
    <div class="col-sm-12 col-md-12">
        <h4> <a href="{{route('dashboard')}}" class="text-uppercase">{{$site["value"]["site_name"] ?? "Infinity"}}</a> | <a href="{{route('items-index')}}">Item</a> | Item {{ $item ? 'Edit: '.$item->name : 'New'}} </a>
        <a href="javascript:history.back()" class="btn btn-outline-primary ml-2 float-right">Back</a>
        <div class="btn-group dropdown float-right">
            <button type="submit" class="btn btn-outline-primary erp-item-form">
                Save
            </button>
        </div>
    </div>
</div>
<h4 class="heading-color">Item</h4>
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-body">
                @if($item)
                    <form class="erp-item-submit" id="item_form" data-url="{{route('items-store')}}" data-id="uid" data-name="name" data-email="email" data-pass="password">
                        <input type="hidden" id="erp-id" class="erp-id" value="{{$item->id}}" name="item_id" />
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="name">Item Name</label>
                                <input placeholder="Enter Item Name" class="form-control input-error" id="item_name" name="name" type="text" value="{{ $item->name }}">
                                <div class="error" style="color:red;" id="name_error"></div>
                            </div>
                            <div class="form-group col-md-12 input-file-col">
                                <?php $showImagePrev = (!empty($item->thumbnail_image)) ? 'display:inline-block' : ''; ?>
                                <label for="item_image">Item Thumbnail</label>
                                <label class="form-control filelabel image-input-wrapper">
                                    <input type="hidden" name="old_image" value="@if(!empty($item->thumbnail_image)){{$item->thumbnail_image}}@endif">
                                    <input type="file" name="image" id="item_image"  class="form-control input-error image-input">
                                    <span class="btn btn-outline-primary"><i class="i-File-Upload nav-icon font-weight-bold cust-icon"></i>Choose File</span>
                                    <img id="item_image_prev" class="previewImgCls hidepreviewimg" src="@if(!empty($item->thumbnail_image)){{asset('storage/items_images/'.$item->thumbnail_image)}}@endif" style="{{$showImagePrev}}">
                                    <span class="title" id="item_image_title">{{ $item->thumbnail_image ??  ''}}</span>
                                </label>
                                <div class="error" style="color:red;" id="image_error"></div>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="item_status" class="">Item status:</label>
                                <div class="ul-form__radio-inline">
                                    <label class=" ul-radio__position radio radio-primary form-check-inline">
                                        <input type="radio" name="status" value="0" <?php if($item->sys_state == 0){echo 'checked="checked"';} ?>>
                                        <span class="ul-form__radio-font">Active</span>
                                        <span class="checkmark"></span>
                                    </label>
                                    <label class="ul-radio__position radio radio-primary">
                                        <input type="radio" name="status" value="1" <?php if($item->sys_state == 1){echo 'checked="checked"';} ?>>
                                        <span class="ul-form__radio-font">Inactive</span>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="error" style="color:red;" id="status_error"></div>
                            </div>
                        </div>
                    </form>
                @else
                <form class="erp-item-submit" id="item_form" data-url="{{route('items-store')}}" data-id="item_id">
                    <input type="hidden" id="erp-id" class="erp-id" name="item_id" value="0" />
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="name">Name</label>
                            {!! Form::text('name', null, array('placeholder' => 'Enter Item Name','class' => 'form-control input-error' , 'id' => 'name')) !!}
                            <div class="error" style="color:red;" id="name_error"></div>
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="item_thumbnail">Description</label>
                            <textarea name="html_description"  id="html_description"></textarea>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="key_feature">Tags</label>
                            {!! Form::text('key_feature', null, array('placeholder' => 'Enter key feature','class' => 'form-control' , 'id' => 'key_feature')) !!}
                        </div>
                        <div class="form-group col-md-12 input-file-col">
                            <label for="item_thumbnail">Item Thumbnail</label>
                            <label class="form-control filelabel image-input-wrapper">
                                <input type="hidden" name="old_image" value="">
                                <input type="file" name="item_thumbnail" id="item_thumbnail"  class="image-input form-control input-error">
                                <span class="btn btn-outline-primary"><i class="i-File-Upload nav-icon font-weight-bold cust-icon"></i>Choose File</span>
                                <img id="item_thumbnail_prev" class="previewImgCls hidepreviewimg" src="">
                                <span class="title" id="item_thumbnail_title"></span>
                            </label>
                            <div class="error" style="color:red;" id="image_error"></div>
                        </div>
                        <div class="form-group col-md-12 input-file-col">
                            <label for="item_images">Images</label>
                            <label class="form-control filelabel image-input-wrapper">
                                <input type="hidden" name="old_image" value="">
                                <input type="file" name="item_images" id="item_images"  class="image-input form-control input-error">
                                <span class="btn btn-outline-primary"><i class="i-File-Upload nav-icon font-weight-bold cust-icon"></i>Choose File</span>
                                <img id="item_images_prev" class="previewImgCls hidepreviewimg" src="">
                                <span class="title" id="item_images_title"></span>
                            </label>
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="item_main_file">Description</label>
                            <input type="file" name="item_main_file" id="item_main_file"  accept=".zip" class="form-control">
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="preview_url">Preview URL</label>
                            <input type="url" id="preview_url" name="preview_url" pattern="https?://.*" title="Include http:// or https:// in the URL">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="category">Category</label>
                            {!! Form::select('category_id', ['' => 'Select category'] + $categories, null, ['class' => 'form-control', 'id' => 'category_id']) !!}
                            <div class="error" style="color:red;" id="category_error"></div>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="subcategory">Sub category</label>
                            {!! Form::select('subcategory_id', ['' => 'Select sub category'] + $subcategories, null, ['class' => 'form-control', 'id' => 'subcategory_id']) !!}
                            <div class="error" style="color:red;" id="subcategories_error"></div>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="tags">Tags</label>
                            <input type="text" id="tags-input" placeholder="Enter tags">
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="pricing">Pricing</label>
                            {!! Form::text('fixed_price', null, array('placeholder' => 'Enter fixed price','class' => 'form-control input-error' , 'id' => 'item_fixed_price')) !!}
                            {!! Form::text('sale_price', null, array('placeholder' => 'Enter sale price','class' => 'form-control input-error' , 'id' => 'item_sale_price')) !!}
                            {!! Form::text('gst_percentage', null, array('placeholder' => 'Enter GST %','class' => 'form-control input-error' , 'id' => 'item_gst_percentage')) !!}
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
    <button type="submit" class="btn btn-outline-primary erp-item-form">
        Save
    </button>
</div>
@endsection
@section('page-js')
<script src="{{asset('assets/js/carousel.script.js')}}"></script>
<!-- <script src="{{ asset('assets/js/tinymce.min.js') }}"></script>
 --><script src="{{ asset('assets/js/vendor/tagging.min.js') }}"></script>
<script src="{{ asset('assets/js/common-bundle-script.js') }}"></script>
@endsection
@section('bottom-js')
    @include('pages.common.modal-script')
    @include('pages.items.items-script')
@endsection