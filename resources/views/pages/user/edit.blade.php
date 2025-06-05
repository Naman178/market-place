@extends('layouts.master')
@php
    use App\Models\Settings;
    $site = Settings::where('key','site_setting')->first();
@endphp
@section('title')
    <title>{{$site["value"]["site_name"] ?? "Infinity"}} | {{ $user ? 'Edit: '.$user->id : 'New'}}</title>
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
   .eye-icon {
        top: -7px;
        left: -6px;
        width: 20px;
        height: 20px;
        position: relative;
        color: #888;
        vertical-align: middle;
    }
    .password button:focus, .confirm_password button:focus {
        outline: none;
    }

</style>
@endsection
<div class="loadscreen" id="preloader" style="display: none; z-index:90;">
    <div class="loader spinner-bubble spinner-bubble-primary"></div>
</div>
@section('main-content')
<div class="breadcrumb">
    <div class="col-sm-12 col-md-12">
        <h4> <a href="{{route('dashboard')}}" class="text-uppercase">{{$site["value"]["site_name"] ?? "Infinity"}}</a> | <a href="{{route('user-index')}}">User</a> | User {{ $user ? 'Edit: '.$user->id : 'New'}} </a>
        <a href="javascript:history.back()" class="btn btn-outline-primary ml-2 float-right">Back</a>
        <div class="btn-group dropdown float-right">
            <button type="submit" class="btn btn-outline-primary erp-user-form">
                Save
            </button>
            @role('Super Admin')
                <button type="button" class="btn btn-outline-primary dropdown-toggle dropdown-toggle-split _r_drop_right" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu" x-placement="right-start">
                    @if($user)
                    <a class="dropdown-item" href="{{route('user-send-reset-password',$user->email)}}"><i class="nav-icon i-Password-shopping font-weight-bold" aria-hidden="true"> </i> Send Password Reset Link</a>
                    @endif
                </div>
            @endrole
        </div>
    </div>
</div>
<h4 class="heading-color">User</h4>
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-body">
                @if($user)
                    <form class="erp-user-submit" data-url="{{route('user-store')}}" data-id="uid" data-name="name" data-email="email" data-pass="password">
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
                                <label for="roles">Role</label>
                                <select class="form-control" id="roles" name="roles[]">
                                    @foreach($roles as $role)
                                      <?php   $roleSelect = '';
                                        if($role == $user->roles[0]['name']){
                                            $roleSelect = 'selected';
                                        }
                                        else{
                                            $roleSelect = '';
                                        }
                                      ?>
                                        <option value="{{ $role }}" {{$roleSelect}}> {{ $role }} </option>
                                    @endforeach
                                </select>
                                <div class="error" style="color:red;" id="roles_error"></div>
                            </div>
                            <div class="col-md-12 form-group">
                                <label>User Status</label>
                                <input class="status" name="status" type="radio" value="1" <?php if($user->status == 1){echo 'checked="checked"';} ?>> Enable
                                <input class="status" name="status" type="radio" value="0" <?php if($user->status == 0){echo 'checked="checked"';} ?>> Disable
                            </div>
                        </div>
                    </form>
                @else
                <form class="erp-user-submit" data-url="{{route('user-store')}}" data-id="uid" data-name="name" data-email="email" data-pass="password">
                    <input type="hidden" id="erp-id" class="erp-id" name="uid" value="0" />
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="fname">First Name</label>
                            {!! Form::text('fname', null, array('placeholder' => 'Enter First Name','class' => 'form-control' , 'id' => 'fname')) !!}
                            <div class="error" style="color:red;" id="fname_error"></div>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="lname">Last Name</label>
                            {!! Form::text('lname', null, array('placeholder' => 'Enter Last Name','class' => 'form-control' , 'id' => 'lname')) !!}
                            <div class="error" style="color:red;" id="lname_error"></div>
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="email">Email</label>
                            {!! Form::text('email', null, array('placeholder' => 'Enter Email Address','class' => 'form-control' , 'id' => 'email')) !!}
                            <div class="error" style="color:red;" id="email_error"></div>
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="roles">Role</label>
                            {!! Form::select('roles[]', $roles,[], array('class' => 'form-control', 'id' => 'roles')) !!}
                            <div class="error" style="color:red;" id="roles_error"></div>
                        </div>
                       <div class="col-md-12 form-group password" style="position: relative;">
                            <label for="password">Password</label>
                            {!! Form::password('password', ['placeholder' => 'Enter Password', 'class' => 'form-control', 'id' => 'password']) !!}
                            <button type="button" class="toggle-button" data-toggle="password" aria-label="Toggle Password Visibility" style="position: absolute; right: 15px; top: 38px; background: none; border: none; cursor: pointer; padding: 0;">
                                <!-- default icon: eye open -->
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="eye-icon" width="24" height="24">
                                    <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                                    <path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div class="error" style="color:red;" id="password_error"></div>
                        </div>

                        <div class="col-md-12 form-group confirm_password" style="position: relative;">
                            <label for="confirm_password">Confirm Password</label>
                            {!! Form::password('confirm_password', ['placeholder' => 'Enter Confirm Password', 'class' => 'form-control', 'id' => 'confirm_password']) !!}
                            <button type="button" class="toggle-button" data-toggle="confirm_password" aria-label="Toggle Confirm Password Visibility" style="position: absolute; right: 15px; top: 38px; background: none; border: none; cursor: pointer; padding: 0;">
                                <!-- default icon: eye open -->
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="eye-icon" width="24" height="24">
                                    <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                                    <path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div class="error" style="color:red;" id="confirm_password_error"></div>
                        </div>
                        <div class="col-md-12 form-group">
                            <label>User Status</label>
                            <input class="status" name="status" checked="checked" type="radio" value="1"> Enable
                            <input class="status" name="status" type="radio" value="0"> Disable
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
    @role('Super Admin')
        <button type="button" class="btn btn-outline-primary dropdown-toggle dropdown-toggle-split _r_drop_right" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="sr-only">Toggle Dropdown</span>
        </button>
        <div class="dropdown-menu" x-placement="right-start">
            @if($user)
            <a class="dropdown-item" href="{{route('user-send-reset-password',$user->email)}}"><i class="nav-icon i-Password-shopping font-weight-bold" aria-hidden="true"> </i> Send Password Reset Link</a>
            @endif
        </div>
    @endrole
</div>
@endsection
@section('page-js')
<script src="{{asset('assets/js/carousel.script.js')}}"></script>
@endsection
@section('bottom-js')
    @include('pages.common.modal-script')
@endsection
