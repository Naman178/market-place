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
    /* .previewImgCls:hover{
        transform: scale(5.0);
        border-radius: 2px;
        z-index: 1;
    } */
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
                            <a class="nav-link show active" id="site_setting_tab" data-toggle="tab" href="#site_setting" role="tab" aria-controls="pdf_settings" aria-selected="true">General Settings</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="login-register-settings-tab" data-toggle="tab" href="#loginRegisterSettings" role="tab" aria-controls="loginRegisterSettings" aria-selected="false">Login\Register Settings</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="stripe-settings-tab" data-toggle="tab" href="#StripeSettings" role="tab" aria-controls="StripeSettings" aria-selected="false">Stripe Settings</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="smtp-setting-tab" data-toggle="tab" href="#SmtpSetting" role="tab" aria-controls="SmtpSetting" aria-selected="false">Smtp Setting</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="invoice-setting-tab" data-toggle="tab" href="#invoice_pdf_setting" role="tab" aria-controls="invoice_pdf_setting" aria-selected="false">Invoice PDF Settings</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        
                        <div class="tab-pane fade show active" id="site_setting" role="tabpanel" aria-labelledby="site_setting_tab">
                            <form class="erp-form-submit-pdf">
                                @csrf
                                <input type="hidden" name="key" id="key" value="site_setting" />
                                <div class="col-sm-12 col-md-12 mb-2 mt-4">
                                    <h4 class="heading-color d-inline-block mb-4">General Settings</h4>
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

                        <div class="tab-pane fade" id="StripeSettings" role="tabpanel" aria-labelledby="login-register-settings-tab">
                            <div class="col-sm-12 col-md-12 mb-4 mt-4">
                                <h4 class="heading-color d-inline-block">Stripe Settings</h4>
                                <a href="{{route('dashboard')}}" class="btn btn-outline-primary ml-2 float-right">Cancel</a>
                                <button type="submit" class="btn btn-outline-primary settings_stripe_register float-right">Save</button>
                            </div>
                            <form class="erp-form-submit-stripe">
                                @csrf
                                <input type="hidden" name="key" value="stripe_setting" />
                                
                                <div class="row align-items-center">
                                    <div class="col-md-12 form-group mb-3">
                                        <div class="mb-3">
                                            <label for="stripe_key">Stripe Key</label>
                                            <input type="text" class="form-control" name="stripe_key" value="{{$stripe_setting['value']['stripe_key'] ?? ''}}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="stripe_secret">Stripe Secret</label>
                                            <input type="text" class="form-control" name="stripe_secret" value="{{$stripe_setting['value']['stripe_secret'] ?? ''}}">
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="col-sm-12 col-md-12 mb-4 mt-4">
                                <a href="{{route('dashboard')}}" class="btn btn-outline-primary ml-2 float-right">Cancel</a>
                                <button type="submit" class="btn btn-outline-primary settings_stripe_register float-right">Save</button>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="SmtpSetting" role="tabpanel" aria-labelledby="SmtpSetting">
                            <div class="col-sm-12 col-md-12 mb-4 mt-4">
                                <h4 class="heading-color d-inline-block">SMTP Settings</h4>
                                <a href="{{route('dashboard')}}" class="btn btn-outline-primary ml-2 float-right">Cancel</a>
                                <button type="button" class="btn btn-outline-primary settings_smtp_register float-right">Save</button>
                                <button type="button" class="btn btn-outline-primary float-right mr-2" data-bs-toggle="modal" data-bs-target="#sendMailModal">Send Test Mail</button>
                            </div>
                            
                            <form class="erp-form-submit-smtp">
                                @csrf
                                <input type="hidden" name="key" value="smtp_setting">
                                
                                <div class="row align-items-center">
                                    <div class="col-md-12 form-group mb-3">
                                        <div class="mb-3">
                                            <label for="mail_mailer">Mail driver (e.g., smtp, sendmail, mail)</label>
                                            <input type="text" class="form-control" name="mail_mailer" value="{{$smtp_setting['value']['mail_mailer'] ?? ''}}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="mail_host">Mail Host (e.g., smtp.yourdomain.com)</label>
                                            <input type="text" class="form-control" name="mail_host" value="{{$smtp_setting['value']['mail_host'] ?? ''}}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="mail_port">Mail Port (e.g., 2525, 465)</label>
                                            <input type="text" class="form-control" name="mail_port" value="{{$smtp_setting['value']['mail_port'] ?? ''}}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="mail_username">Mail Username</label>
                                            <input type="text" class="form-control" name="mail_username" value="{{$smtp_setting['value']['mail_username'] ?? ''}}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="mail_pass">Mail Password</label>
                                            <input type="text" class="form-control" name="mail_pass" value="{{$smtp_setting['value']['mail_pass'] ?? ''}}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="mail_encryption">Mail Encryption (e.g., TLS/SSL)</label>
                                            <input type="text" class="form-control" name="mail_encryption" value="{{$smtp_setting['value']['mail_encryption'] ?? ''}}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="mail_sender">Sender</label>
                                            <input type="text" class="form-control" name="mail_sender" value="{{$smtp_setting['value']['mail_sender'] ?? ''}}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="mail_app">Mail From Name</label>
                                            <input type="text" class="form-control" name="mail_app" value="{{$smtp_setting['value']['mail_app'] ?? ''}}">
                                        </div>
                                    </div>
                                </div>
                        
                                <div class="col-sm-12 col-md-12 mb-4 mt-4">
                                    <a href="{{route('dashboard')}}" class="btn btn-outline-primary ml-2 float-right">Cancel</a>
                                    <button type="button" class="btn btn-outline-primary settings_smtp_register float-right">Save</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="invoice_pdf_setting" role="tabpanel" aria-labelledby="invoice_pdf_setting">
                            <form class="erp-invoice-form-submit-pdf">
                                @csrf
                                <input type="hidden" name="key" id="key" value="invoice_site_setting" />
                                <div class="col-sm-12 col-md-12 mb-2 mt-4">
                                    <h4 class="heading-color d-inline-block mb-4">Invoice PDF Settings</h4>
                                </div>
                                <div class="row align-items-center">
                                    <div class="col-md-12 form-group mb-3">
                                        <div class="mb-3">
                                            <label for="site_name">Site Name</label>
                                            <input type="text" class="form-control" name="site_name" value="{{$invoice_setting["value"]["site_name"] ?? ""}}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="address1">Address 1</label>
                                            <input type="text" class="form-control" name="address1" value="{{$invoice_setting["value"]["address_1"] ?? ""}}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="address2">Address 2</label>
                                            <input type="text" class="form-control" name="address2" value="{{$invoice_setting["value"]["address_2"] ?? ""}}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="city">City</label>
                                            <input type="text" class="form-control" name="city" value="{{$invoice_setting["value"]["city"] ?? ""}}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="state">State</label>
                                            <input type="text" class="form-control" name="state" value="{{$invoice_setting["value"]["state"] ?? ""}}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="country">Country</label>
                                            <input type="text" class="form-control" name="country" value="{{$invoice_setting["value"]["country"] ?? ""}}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="pin">Pincode</label>
                                            <input type="text" class="form-control" name="pin" value="{{$invoice_setting["value"]["pin"] ?? ""}}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="gst">GST No</label>
                                            <input type="text" class="form-control" name="gst" value="{{$invoice_setting["value"]["gst"] ?? ""}}">
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="col-sm-12 col-md-12 mb-4 mt-4">
                                <a href="{{route('dashboard')}}" class="btn btn-outline-primary ml-2 float-right">Cancel</a>
                                <button type="submit" class="btn btn-outline-primary settings_invoice_form_pdf float-right">Save</button>
                            </div>
                        </div>
                        <!-- Bootstrap Modal -->
                        <div class="modal fade" id="sendMailModal" tabindex="-1" aria-labelledby="sendMailModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="sendMailModalLabel">Send Test Mail</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="sendMailForm">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="test_email" class="form-label">Enter Email</label>
                                                <input type="email" class="form-control" id="test_email" name="test_email" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Send</button>
                                        </form>
                                    </div>
                                </div>
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
