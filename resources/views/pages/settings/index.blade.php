@extends('layouts.master')
@section('title')
    <title>{{$site["value"]["site_name"] ?? "Infinity"}} | Settings</title>
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
    .increment{
        align-items: center;
    }
    .myfrm{
        display:none;
    }
    .filelabel{
        height: auto;
        margin-bottom:0;
    }
    .cust-icon{
        margin-right:10px
    }
    .hide{
        display:none;
    }
    .hdtuto{
        margin-top:10px;
        align-items: center;
    }
    .hidepreviewpdf{
        display:none;
    }
    .delete_row{
        align-items: center;
    }
</style>
@endsection
<div class="loadscreen" id="preloader" style="display: none; z-index:90;">
    <div class="loader spinner-bubble spinner-bubble-primary"></div>
</div>
@section('main-content')
    <div class="breadcrumb">
        <div class="col-sm-12 col-md-12">
            <h4> <a href="{{route('dashboard')}}" class="text-uppercase">{{$site["value"]["site_name"] ?? "Infinity"}}</a> | Settings </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link show active" id="site_setting_tab" data-toggle="tab" href="#site_setting" role="tab" aria-controls="pdf_settings" aria-selected="true">Site Settings</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="login-register-settings-tab" data-toggle="tab" href="#loginRegisterSettings" role="tab" aria-controls="loginRegisterSettings" aria-selected="false">Login\Register Settings</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="site_setting" role="tabpanel" aria-labelledby="site_setting_tab">
                            <form class="erp-form-submit-pdf">
                                @csrf
                                <input type="hidden" name="key" id="key" value="site_setting" />
                                <div class="col-sm-12 col-md-12 mb-2 mt-4">
                                    <h4 class="heading-color d-inline-block mb-4">Logo Settings</h4>
                                </div>
                                <div class="row align-items-center">
                                    <div class="col-md-12 form-group mb-3">
                                        <label>Site Logo Image</label>
                                        <?php $imgdis4 = (!empty($site['value']['logo_image'])) ? 'display:inline-block' : ''; ?>
                                        <label class="form-control filelabel mb-3">
                                            <input type="hidden" name="logo_image_same" value="@if(!empty($site['value']['logo_image'])){{$site['value']['logo_image']}}@endif">
                                            <input type="file" name="logo_image" id="logo_image" class="myfrm form-control" >
                                            <span class="btn btn-outline-primary"><i class="i-File-Upload nav-icon font-weight-bold cust-icon"></i>Choose File</span>
                                            <img id="previewImgForLogo" class="previewImgCls hidepreviewimg" src="@if(!empty($site['value']['logo_image'])){{asset('storage/Logo_Settings/'.$site['value']['logo_image'])}}@endif" style="{{$imgdis4}}">
                                            <span class="title" id="titleForLogo">@if(!empty($site['value']['logo_image'])){{$site['value']['logo_image']}}@endif</span>
                                        </label>
                                        <div class="mb-3">
                                            <label for="site_name">Site Name</label>
                                            <input type="text" class="form-control" name="site_name" value="{{$site["value"]["site_name"] ?? ""}}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="address1">Address 1</label>
                                            <input type="text" class="form-control" name="address1" value="{{$site["value"]["address_1"] ?? ""}}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="address2">Address 2</label>
                                            <input type="text" class="form-control" name="address2" value="{{$site["value"]["address_2"] ?? ""}}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="city">City</label>
                                            <input type="text" class="form-control" name="city" value="{{$site["value"]["city"] ?? ""}}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="state">State</label>
                                            <input type="text" class="form-control" name="state" value="{{$site["value"]["state"] ?? ""}}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="country">Country</label>
                                            <input type="text" class="form-control" name="country" value="{{$site["value"]["country"] ?? ""}}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="pin">Pincode</label>
                                            <input type="text" class="form-control" name="pin" value="{{$site["value"]["pin"] ?? ""}}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="gst">GST No</label>
                                            <input type="text" class="form-control" name="gst" value="{{$site["value"]["gst"] ?? ""}}">
                                        </div>
                                        <div>
                                            <?php $showFavIcon = (!empty($site['value']['site_favicon'])) ? 'display:inline-block' : ''; ?>
                                            <label for="site_favicon">Favicon</label>
                                            <label class="form-control filelabel mb-3">
                                                <input type="hidden" name="favicon" value="@if(!empty($site['value']['site_favicon'])){{$site['value']['site_favicon']}}@endif">
                                                <input type="file" name="site_favicon" id="site_favicon" class="myfrm form-control" >
                                                <span class="btn btn-outline-primary"><i class="i-File-Upload nav-icon font-weight-bold cust-icon"></i>Choose File</span>
                                                <img id="favicon_preview" class="previewImgCls hidepreviewimg" src="@if(!empty($site['value']['site_favicon'])){{asset('storage/Logo_Settings/'.$site['value']['site_favicon'])}}@endif" style="{{$showFavIcon}}">
                                                <span class="title" id="favicon_title">@if(!empty($site['value']['site_favicon'])){{$site['value']['site_favicon']}}@endif</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="col-sm-12 col-md-12 mb-4 mt-4">
                                <a href="{{route('dashboard')}}" class="btn btn-outline-primary ml-2 float-right">Cancel</a>
                                <button type="submit" class="btn btn-outline-primary settings_form_pdf float-right">Save</button>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="loginRegisterSettings" role="tabpanel" aria-labelledby="login-register-settings-tab">
                            <div class="col-sm-12 col-md-12 mb-4 mt-4">
                                <h4 class="heading-color d-inline-block">Login Register Settings</h4>
                                <a href="{{route('dashboard')}}" class="btn btn-outline-primary ml-2 float-right">Cancel</a>
                                <button type="submit" class="btn btn-outline-primary settings_form_login_register float-right">Save</button>
                            </div>
                            <form class="erp-form-submit-login-register">
                                @csrf
                                <input type="hidden" name="key" id="key" value="login_register_settings" />
                                <div class="row align-items-center">
                                    <div class="col-md-12 form-group mb-3">
                                        <label>Login Register Background Image</label>
                                        <?php $imgdis3 = (!empty($login_register['value']['login_register_bg'])) ? 'display:inline-block' : ''; ?>
                                        <label class="form-control filelabel">
                                            <input type="hidden" name="login_register_bg_same" value="@if(!empty($login_register['value']['login_register_bg'])){{$login_register['value']['login_register_bg']}}@endif">
                                            <input type="file" name="login_register_bg" id="login_register_bg" class="myfrm form-control" >
                                            <span class="btn btn-outline-primary"><i class="i-File-Upload nav-icon font-weight-bold cust-icon"></i>Choose File</span>
                                            <img id="previewImgForLoginRegister" class="previewImgCls hidepreviewimg" src="@if(!empty($login_register['value']['login_register_bg'])){{asset('storage/Login_Register_Settings/'.$login_register['value']['login_register_bg'])}}@endif" style="{{$imgdis3}}">
                                            <span class="title" id="titleForLoginRegister">@if(!empty($login_register['value']['login_register_bg'])){{$login_register['value']['login_register_bg']}}@endif</span>
                                        </label>
                                    </div>
                                </div>
                            </form>
                            <div class="col-sm-12 col-md-12 mb-4 mt-4">
                                <a href="{{route('dashboard')}}" class="btn btn-outline-primary ml-2 float-right">Cancel</a>
                                <button type="submit" class="btn btn-outline-primary settings_form_login_register float-right">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-js')
<script src="{{asset('assets/js/carousel.script.js')}}"></script>
@endsection
@section('bottom-js')
    @include('pages.settings.script')
    @include('pages.common.modal-script')
@endsection
