@extends('front-end.common.master')
@section('title')
    <title>Skyfinity Quick Checkout | Login</title>
@endsection
@section('content')
<div class="forgot_password cust-page-padding">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-8 col-md-12 col-sm-12 col-12">
                <div class="card p-4 dark-blue-card mb-5">                    
                    <h1 class="mb-3 text-8 text-center text-white">Forgot Password</h1>                    
                    @if (Session::has('message'))
                        <p class="text-white"> {{ Session::get('message') }} </p>                    
                    @endif
                    <form action="{{ route('forget-password-post') }}" method="POST">
                        @csrf
                        <div class="col-md-12 form-group">
                            <label for="email_address">E-Mail Address</label>
                            <input type="text" id="email_address" class="form-control" placeholder="Enter Email Address" name="email" required autofocus>
                            @if ($errors->has('email'))
                                <span class="error">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-block pink-btn mt-3" id="login-btn">Send Password Reset Link</button>
                            <p class="text-center d-block text-white"><a href="{{ url('user-login') }}">Back to Login </a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
@endsection