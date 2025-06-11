@extends('layouts.master')
@php
    use App\Models\Settings;
    $site = Settings::where('key','site_setting')->first();
@endphp
@section('title')
    <title>{{$site["value"]["site_name"] ?? "Infinity"}} | {{ $testimonial ? 'Edit: '.$testimonial->id : 'New'}}</title>
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
     .previewImgCls {
        width: 200px;
        height: 150px;
        object-fit: contain;
        display: none;
    }

    .previewImgCls.show {
        display: inline-block;
    }
</style>
@endsection
<div class="loadscreen" id="preloader" style="display: none; z-index:90;">
    <div class="loader spinner-bubble spinner-bubble-primary"></div>
</div>
@section('main-content')
<div class="breadcrumb">
    <div class="col-sm-12 col-md-12">
        <h4> <a href="{{route('dashboard')}}" class="text-uppercase">{{$site["value"]["site_name"] ?? "Infinity"}}</a> | <a href="{{route('Testimonial-index')}}">{{ trans('custom.Testimonial_title') }}</a> | {{ trans('custom.Testimonial_title') }} {{ $testimonial ? 'Edit: '.$testimonial->id : 'New'}} </a>
        <a href="javascript:history.back()" class="btn btn-outline-primary ml-2 float-right">Back</a>
        <div class="btn-group dropdown float-right">
            <button type="submit" class="btn btn-outline-primary erp-testimonial-form">
                Save
            </button>
        </div>
    </div>
</div>
<h4 class="heading-color">{{ trans('custom.Testimonial_title') }}</h4>
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-body">
                @if($testimonial)
                    <form class="erp-testimonial-submit" id="testimonial_form" enctype="multipart/form-data" data-url="{{route('Testimonial-store')}}" data-id="scid" data-name="name">
                        <input type="hidden" id="scid" class="erp-id" value="{{$testimonial->id}}" name="scid" />
                        <input type="hidden" id="old_image" value="{{ $testimonial->image }}" name="old_image" />
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="title_label">Name</label>
                                <input placeholder="Enter Name" class="form-control input-error" id="name" name="name" type="text" value="{{ $testimonial->name }}">
                                <div class="error" style="color:red;" id="name_error"></div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="designation">Designation</label>
                                <input placeholder="Enter Designation" class="form-control input-error" id="designation" name="designation" type="text" value="{{ $testimonial->designation }}">
                                <div class="error text-danger" id="designation_error"></div>
                            </div>
                            <div class="form-group col-md-6 input-file-col">
                                <?php $showImagePrev = (!empty($testimonial->image)) ? 'display:inline-block' : ''; ?>
                                <label for="testimonial_image_label">Upload Image</label>
                                <label class="form-control filelabel image-input-wrapper">
                                    <input type="hidden" name="old_image" value="@if(!empty($testimonial->image)){{$testimonial->image}}@endif">
                                    <input type="file" name="image" id="testimonial_image"  class="form-control input-error image-input">
                                    <span class="btn btn-outline-primary"><i class="i-File-Upload nav-icon font-weight-bold cust-icon"></i>Choose File</span>
                                    <img id="testimonial_image_prev" class="previewImgCls hidepreviewimg" src="@if(!empty($testimonial->image)){{asset('storage/images/'.$testimonial->image)}}@endif" style="{{$showImagePrev}}">
                                    <span class="title" id="category_image_title">{{ $testimonial->image ??  ''}}</span>
                                </label>
                                <div class="error" style="color:red;" id="image_error"></div>
                            </div>
                            {{-- <div class="form-group col-md-6">
                                <label for="image">Upload Image</label>
                                <input type="file" class="form-control-file" id="image" name="image">
                                <img class="mt-2" src="{{ asset('storage/images/' .$testimonial->image) }}" width="100px" alt="not found">
                                <div class="error" style="color:red;" id="image_error"></div>
                            </div> --}}

                            <div class="form-group col-md-12">
                                <label for="message">Message</label>
                                <div id="quill_editor" class="quill_editor" style="height: 200px; width:100%;">{!!$testimonial->message!!}</div>
                                <input type="hidden" name="message" id="message" value="{{$testimonial->message}}">
                                <div class="error" style="color:red;" id="message_error"></div>
                            </div>
                        </div>
                    </form>
                @else
                <form class="erp-testimonial-submit" id="testimonial_form" enctype="multipart/form-data" data-url="{{route('Testimonial-store')}}" data-id="scid">
                    <input type="hidden" id="scid" class="erp-id" name="scid" value="0" />
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="title_label">Name</label>
                            {!! Form::text('name', null, array('placeholder' => 'Enter Name','class' => 'form-control input-error filelabel image-input-wrapper' , 'id' => 'name')) !!}
                            <div class="error" style="color:red;" id="name_error"></div>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="designation">Designation</label>
                            {!! Form::text('designation', null, array('placeholder' => 'Enter Designation','class' => 'form-control input-error' , 'id' => 'designation')) !!}
                            <div class="error text-danger" id="designation_error"></div>
                        </div>
                        {{-- <div class="form-group col-md-6">
                            <label for="image">Upload Image</label>
                            <input type="file" class="form-control-file" id="image" name="image">
                            
                            <div id="image-previews" class="mt-2">
                            </div>
                            
                            <div class="error" style="color:red;" id="image_error"></div>
                        </div> --}}
                        <div class="form-group col-md-6 input-file-col">
                            <label for="testimonial_image_label">Upload Image</label>
                            <label class="form-control filelabel image-input-wrapper">
                                <input type="hidden" name="old_image" value="">
                                <input type="file" name="image" id="testimonial_image"  class="image-input form-control input-error">
                                <span class="btn btn-outline-primary"><i class="i-File-Upload nav-icon font-weight-bold cust-icon"></i>Choose File</span>
                                <img id="testimonial_image_prev" class="previewImgCls hidepreviewimg" src="">
                                <span class="title" id="testimonial_image_title"></span>
                            </label>
                            <div class="error" style="color:red;" id="image_error"></div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="message">Message</label>
                            <div id="quill_editor" class="quill_editor" style="height: 200px; width:100%;"></div>
                            <input type="hidden" name="message" id="message">
                            
                            <div class="error" style="color:red;" id="message_error"></div>
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
    <button type="submit" class="btn btn-outline-primary erp-testimonial-form">
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
    @include('pages.Testimonial.Testimonial-script')
@endsection