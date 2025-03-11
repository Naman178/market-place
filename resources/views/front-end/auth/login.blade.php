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
    <style>
        .text-danger{
            color:red;
        }
        .form-control {
             padding: 21px 15px !important;
         }
    </style>
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
                <div class="col-xl-3 col-lg-8 col-md-12 col-sm-12 col-12">
                    <div class="card p-4 dark-blue-card">
                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::text('email', null, [
                                    'placeholder' => '',
                                    'class' => 'form-control',
                                    'id' => 'email',
                                    'required' => 'required',
                                ]) !!}
                                <label for="email" class="floating-label">Email</label>
                                @error('email')
                                    <span class="error" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <div class="error" id="email_error"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::password('password', [
                                    'placeholder' => '',
                                    'class' => 'form-control',
                                    'id' => 'password',
                                    'required' => 'required',
                                ]) !!}
                                <label for="password" class="floating-label">Password</label>
                                @error('password')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                <div class="error" id="password_error"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-block pink-btn mt-3" id="login-btn" style="cursor: pointer;">Sign In</button>
                            <p class="text-center d-block text-white">Don't Have an Account ..? <a
                                    href="{{ route('signup') }}"> Register </a> </p>
                            <p class="text-center d-block text-white">Forgot Your Password..?<a href="{{ route('forget-password-get') }}"> Reset Password </a></p>
                            <div class="float_right mt-2">
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
            grecaptcha.execute('{{ config('services.recaptcha.sitekey') }}', { action: 'signup' }).then(function(token) {
                if (token) {
                    let recaptchaField = document.getElementById('recaptcha');
                    let recaptchaField1 = document.getElementById('recaptcha1');

                    if (recaptchaField) {
                        recaptchaField.value = token;
                    }
                    if (recaptchaField1) {
                        recaptchaField1.value = token;
                    }
                }
            }).catch(function(error) {
                console.error("reCAPTCHA error:", error);
            });
        });
        document.addEventListener("DOMContentLoaded", function () {
            const inputFields = document.querySelectorAll(".form-control");
            // Function to handle floating label
            function updateFloatingLabel(input) {
                const label = input.nextElementSibling; // Get the corresponding label
                if (input.value.trim() !== "") {
                    label.style.top = "50%";
                    label.style.fontSize = "1rem";
                    label.style.color = "#70657b";
                } else {
                    label.style.top = "50%";
                    label.style.fontSize = "1rem";
                    label.style.color = "#70657b"; // Ensure this style on initial load if empty
                }
            }

            function handleBlur(input) {
                const label = input.nextElementSibling;
                if (input.value.trim() === "") {
                    label.style.color = "red"; // Set red when empty on blur
                    label.style.top = "35%"; // Set label top position when empty on blur
                }
            }

            // Initialize labels on page load
            inputFields.forEach(input => {
                updateFloatingLabel(input);
                const label = input.nextElementSibling;
                // Blur event: Check if empty & show error
                input.addEventListener("blur", function () {
                const errorDiv = document.getElementById(input.id + "_error");

                if (!input.value.trim()) {
                    if (errorDiv) { // ✅ Check if errorDiv exists
                        errorDiv.textContent = input.name.replace("_", " ") + " is required!";
                        errorDiv.style.display = "block";
                    }
                    input.style.borderColor = "red";
                    label.style.top = "35%";
                    label.style.fontSize = "1rem";
                    label.style.color = "red";
                } else {
                    if (errorDiv) {
                        errorDiv.style.display = "none";
                    }
                    input.style.borderColor = "#ccc";
                    label.style.color = "#70657b";
                }
            });
                // Focus event: Float label
                input.addEventListener("focus", function () {
                    const label = input.nextElementSibling;
                    label.style.top = "-1%";
                    label.style.fontSize = "0.8rem";
                    if (input.value.trim() !== "") {
                        label.style.color = "#70657b";
                        input.style.borderColor = "#70657b";
                    } else {
                        label.style.color = "red";
                        input.style.borderColor = "red";
                    }
                });
            });
        });
        $('#country').select2();
        $('#country_code').select2();
  </script>

@endsection
