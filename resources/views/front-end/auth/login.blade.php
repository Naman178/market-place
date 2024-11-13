@extends('front-end.common.master')
@section('meta')
<title>Market Place | {{ $seoData->title ?? 'Default Title' }} - {{ $seoData->description ?? 'Default Description' }}</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="{{ $seoData->description ?? 'Default description' }}">
<meta name="keywords" content="{{ $seoData->keywords ?? 'default, keywords' }}">
<meta property="og:title" content="{{ $seoData->title ?? 'Default Title' }}">
<meta property="og:description" content="{{ $seoData->description ?? 'Default description' }}">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:type" content="website">
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset('front-end/css/register.css') }}">
@endsection
@section('content')
    <div class="container pt-5 pb-5 register-container">
        <div class="title">
            <h3><span class="txt-black">Login</h3>
        </div>
        {{-- <form action="#" method="POST">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="row  border p-3 pt-4 pb-4 border-radius-1">
                    <a href="{{ url('/user-login/google') }}" class="btn btn-google">Continue with Google</a>
                </div>
            </div>
        </div>
    </form> --}}
        <form method="POST" action="{{ route('user-login-post') }}">
            <input type="hidden" name="recaptcha" id="recaptcha">
            @csrf
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-8 col-md-12 col-sm-12 col-12">
                    <div class="card p-4 dark-blue-card">
                        <div class="col-md-12 form-group">
                            <label for="email">Email</label>
                            {!! Form::text('email', null, [
                                'placeholder' => 'Enter Email Address',
                                'class' => 'form-control',
                                'id' => 'email',
                                'required' => 'required',
                            ]) !!}
                            @error('email')
                                <span class="error" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="password">Password</label>
                            {!! Form::password('password', [
                                'placeholder' => 'Enter Password',
                                'class' => 'form-control',
                                'id' => 'password',
                                'required' => 'required',
                            ]) !!}
                            @error('password')
                                <span class="error" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-block pink-btn mt-3" id="login-btn">Sign In</button>
                            <p class="text-center d-block text-white">Don't Have an Account ..? <a
                                    href="{{ route('signup') }}"> Register </a> </p>
                            <p class="text-center d-block text-white">Forgot Your Password..?<a href="{{ route('forget-password-get') }}"> Reset Password </a></p>
                            <div class="float_right">
                                <a href="{{ url('/user-login/google') }}" class="btn btn-google">Continue with Google</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('scripts')
  <!--Google Captcha-->
  <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.sitekey') }}"></script>
  <script>
          grecaptcha.ready(function() {
              grecaptcha.execute('{{ config('services.recaptcha.sitekey') }}', {action: 'signin'}).then(function(token) {
                  if (token) {
                  document.getElementById('recaptcha').value = token;
                  }
              });
          });
  </script>

@endsection
