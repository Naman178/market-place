@extends('layouts.master')
@php
    use App\Models\Settings;
    $site = Settings::where('key','site_setting')->first();
@endphp
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
<form class="form-horizontal" method="POST" action="{{ route('changePasswordPost') }}">
    <?php $user = auth()->user();?>
    <div class="breadcrumb">
        <div class="col-sm-12 col-md-12">
            <h4> <a href="{{route('dashboard')}}">ERP</a> | <a href="{{route('profile-settings',$user['id'])}}">Profile Settings</a> | Password Update </a>
            <a href="{{route('profile-settings',$user['id'])}}" class="btn btn-outline-primary ml-2 float-right">Cancel</a>
            <div class="btn-group dropdown float-right">
                <button type="submit" class="btn btn-outline-primary erp-user-form">
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
    <h4 class="heading-color">Change password</h4>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if($errors)
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger">{{ $error }}</div>
                        @endforeach
                    @endif
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="fname">Current Password</label>
                            <input id="current-password" type="password" class="form-control" name="current-password" required>
                            @if ($errors->has('current-password'))
                                <div class="error" style="color:red;">
                                    {{ $errors->first('current-password') }}
                                </div>
                            @endif
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="lname">New Password</label>
                            <input id="new-password" type="password" class="form-control" name="new-password" required>
                            @if ($errors->has('new-password'))
                                <div class="error" style="color:red;" >
                                    {{ $errors->first('new-password') }}
                                </div>
                            @endif
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="lname">Confirm New Password</label>
                            <input id="new-password-confirm" type="password" class="form-control" name="new-password_confirmation" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <a href="{{route('profile-settings',$user['id'])}}" class="btn btn-outline-primary ml-2 float-right">Cancel</a>
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
</form>
