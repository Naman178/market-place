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
    .form-group {
        position: relative;
    }

    .toggle-button {
        position: absolute;
        top: 70%;
        right: 12px; 
        transform: translateY(-50%);
        background: transparent;
        border: none;
        padding: 0;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .eye-icon {
        width: 20px;
        height: 20px;
        color: #888;
    }
    button:focus{
            outline: none;
        }
    @media (max-width: 480px) {
        .eye-icon {
            width: 1rem; /* 16px */
            height: 1rem;
        }
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
                              <button type="button" class="toggle-button" data-toggle="password" aria-label="Toggle Password Visibility">
                                <!-- Eye icon SVG -->
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="eye-icon" viewBox="0 0 24 24">
                                    <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                                    <path fill-rule="evenodd"
                                        d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                            @if ($errors->has('current-password'))
                                <div class="error" style="color:red;">
                                    {{ $errors->first('current-password') }}
                                </div>
                            @endif
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="lname">New Password</label>
                            <input id="new-password" type="password" class="form-control" name="new-password" required>
                             <button type="button" class="toggle-button" data-toggle="password-new" aria-label="Toggle Password Visibility">

                                <!-- Eye icon SVG -->
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="eye-icon" viewBox="0 0 24 24">
                                    <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                                    <path fill-rule="evenodd"
                                        d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                            @if ($errors->has('new-password'))
                                <div class="error" style="color:red;" >
                                    {{ $errors->first('new-password') }}
                                </div>
                            @endif
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="lname">Confirm New Password</label>
                            <input id="new-password-confirm" type="password" class="form-control" name="new-password_confirmation" required>
                             <button type="button" class="toggle-button" data-toggle="password-confirm" aria-label="Toggle Password Visibility">

                                <!-- Eye icon SVG -->
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="eye-icon" viewBox="0 0 24 24">
                                    <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                                    <path fill-rule="evenodd"
                                        d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
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
