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
    .form-group label {
        width: 100%;
    }
    .select2-container {
       width: 150px;
    }
    .dropdown-menu.show{
        left: -100% !important;
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
            <button type="submit" class="btn btn-outline-primary erp-user-form">
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
                    <form class="erp-category-submit" data-url="{{route('category-store')}}" data-id="uid" data-name="name" data-email="email" data-pass="password">
                        <input type="hidden" id="erp-id" class="erp-id" value="{{$category->id}}" name="uid" />
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="name">Category Name</label>
                                <input placeholder="Enter Category Name" class="form-control" id="name" name="name" type="text" value="{{ $category->name }}">
                                <div class="error" style="color:red;" id="name_error"></div>
                            </div>
                            <div class="col-md-6 form-group"> 
                                <?php $showFavIcon = (!empty($category->image)) ? 'display:inline-block' : ''; ?>
                                <label for="site_favicon">Category Image</label>
                                <label class="form-control filelabel mb-3">
                                    <input type="hidden" name="image" value="@if(!empty($category->image)){{$category->image}}@endif">
                                    <input type="file" name="image" id="site_favicon" class="myfrm form-control" >
                                    <span class="btn btn-outline-primary"><i class="i-File-Upload nav-icon font-weight-bold cust-icon"></i>Choose File</span>
                                    <img id="image_preview" class="previewImgCls hidepreviewimg" src="@if(!empty($category->image)){{asset('storage/Logo_Settings/'.$category->image)}}@endif" style="{{$showFavIcon}}">
                                    <span class="title" id="image_title">@if(!empty($category->image)){{$category->image}}@endif</span>
                                </label>
                            </div>
                            <div class="col-md-12 form-group">
                                <label>Category Status</label>
                                <input class="status" name="sys_state" type="radio" value="0" <?php if($category->sys_state == 0){echo 'checked="checked"';} ?>> Active 
                                <input class="status" name="sys_state" type="radio" value="1" <?php if($category->sys_state == 1){echo 'checked="checked"';} ?>> Deactive
                            </div>
                        </div>
                    </form>
                @else
                <form class="erp-user-submit" data-url="{{route('user-store')}}" data-id="cid">
                    <input type="hidden" id="erp-id" class="erp-id" name="cid" value="0" />
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="name">Category Name</label>
                            {!! Form::text('name', null, array('placeholder' => 'Enter First Name','class' => 'form-control' , 'id' => 'name')) !!}
                            <div class="error" style="color:red;" id="name_error"></div>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="category_image">Category Image</label>
                            <label class="form-control filelabel mb-3">
                                <input type="hidden" name="image" value="">
                                <input type="file" name="image" id="category_image" class="myfrm form-control" >
                                <span class="btn btn-outline-primary"><i class="i-File-Upload nav-icon font-weight-bold cust-icon"></i>Choose File</span>
                                <img id="image_preview" class="previewImgCls hidepreviewimg" src="">
                                <span class="title" id="image_title"></span>
                            </label>
                            <div class="error" style="color:red;" id="lname_error"></div>
                        </div>
                        <div class="col-md-12 form-group">
                            <label>User Status</label>
                            <input class="status" name="status" checked="checked" type="radio" value="0"> Active
                            <input class="status" name="status" type="radio" value="1"> Deactive
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
    <button type="submit" class="btn btn-outline-primary erp-user-form">
        Save
    </button>
</div>
@endsection
@section('page-js')
<script src="{{asset('assets/js/carousel.script.js')}}"></script>
@endsection
@section('bottom-js')
    @include('pages.common.modal-script')
@endsection
