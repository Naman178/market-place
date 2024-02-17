@extends('layouts.master')
@php
    use App\Models\Settings;
    $site = Settings::where('key','site_setting')->first();
@endphp
@section('title')
    <title>{{$site["value"]["site_name"] ?? "Infinity"}} | Profile Settings </title>
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
</style>
@endsection
@section('main-content')
<div class="breadcrumb">
    <div class="col-sm-12 col-md-12">
        <h4> <a href="{{route('dashboard')}}" class="text-uppercase">{{$site["value"]["site_name"] ?? "Infinity"}}</a> | Profile Settings </a>
        <a href="javascript:history.back()" class="btn btn-outline-primary ml-2 float-right">Back</a>
        <div class="btn-group dropdown float-right">
            <button type="submit" class="btn btn-outline-primary profile_settings_form">
                Save
            </button>
            <button type="button" class="btn btn-outline-primary dropdown-toggle dropdown-toggle-split _r_drop_right" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="sr-only">Toggle Dropdown</span>
            </button>
            <div class="dropdown-menu" x-placement="right-start">
                <a class="dropdown-item" href="#">Action</a>
            </div>
        </div>
    </div>
</div>
<h4 class="heading-color">Profile Settings</h4>
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-body">
                <form class="profile_settings_submit" data-url="{{route('profilesettings-store')}}" data-id="uid" data-name="name" data-email="email" data-pass="password">
                    <input type="hidden" id="erp-id" class="erp-id" value="{{$user->id}}" name="uid" />
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="fname">First Name</label>
                            <input placeholder="Enter First Name" class="form-control" id="fname" name="fname" type="text" value="{{ $user->fname }}">
                            <div class="error" style="color:red;" id="fname_error"></div>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="lname">Last Name</label>
                            <input placeholder="Enter Last Name" class="form-control" id="lname" name="lname" type="text" value="{{ $user->lname }}">
                            <div class="error" style="color:red;" id="lname_error"></div>
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="email">Email</label>
                            <input placeholder="Enter Email Address" class="form-control" id="email" name="email" type="text" value="{{ $user->email }}" readonly>
                            <div class="error" style="color:red;" id="email_error"></div>
                        </div>
                        <div class="col-md-12 form-group">
                            <a href="{{route('changePasswordGet')}}">To Update Your pasword Click : Here</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<a href="javascript:history.back()" class="btn btn-outline-primary ml-2 float-right">Back</a>
<div class="btn-group dropdown float-right">
    <button type="submit" class="btn btn-outline-primary profile_settings_form">
        Save
    </button>
    <button type="button" class="btn btn-outline-primary dropdown-toggle dropdown-toggle-split _r_drop_right" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="sr-only">Toggle Dropdown</span>
    </button>
    <div class="dropdown-menu" x-placement="right-start">
        <a class="dropdown-item" href="#">Action</a>
    </div>
</div>
@endsection
@section('page-js')
<script src="{{asset('assets/js/carousel.script.js')}}"></script>
@endsection
@section('bottom-js')
    @include('pages.common.modal-script')
@endsection
