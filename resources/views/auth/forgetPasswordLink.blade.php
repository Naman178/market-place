@extends('front-end.common.master')
@section('title')
    <title>Skyfinity Quick Checkout | Login</title>
@endsection
@section('content')

<div class="forgot_password cust-page-padding">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-8 col-md-12 col-sm-12 col-12">
                <div class="card p-4 dark-blue-card">                    
                    <h1 class="mb-3 text-8 text-center text-white">Reset Password</h1>                    
                    <div class="card-body">
                        <form action="{{ route('reset-password-post') }}" method="POST">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="col-md-12 form-group">
                                <label for="email_address">E-Mail Address</label>
                                <input type="text" id="email_address" class="form-control" name="email" required autofocus placeholder="Enter Email Address">
                                @if ($errors->has('email'))
                                    <span class="error">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="password">Password</label>
                                <input type="password" id="password" class="form-control" name="password" required autofocus placeholder="Enter Password">
                                @if ($errors->has('password'))
                                    <span class="error">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="password-confirm">Confirm Password</label>
                                <input type="password" id="password-confirm" class="form-control" name="password_confirmation" required autofocus placeholder="Enter Confirm Password">
                                @if ($errors->has('password_confirmation'))
                                    <span class="error">{{ $errors->first('password_confirmation') }}</span>
                                @endif
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-block pink-btn mt-3" id="login-btn">Reset Password</button>
                            </div>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
@endsection