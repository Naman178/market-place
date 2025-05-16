@extends('front-end.common.master')

@php 
    $site = \App\Models\Settings::where('key', 'site_setting')->first();

    $logoImage = $site['value']['logo_image'] ?? null;
    $ogImage = $logoImage 
        ? asset('storage/Logo_Settings/' . $logoImage) 
        : asset('front-end/images/infiniylogo.png');

    // Assuming you fetch SEO data for login page like this:
    use App\Models\SEO;
    $seoData = SEO::where('page', 'login')->first();
@endphp

@section('meta')
@section('title'){{ $seoData->title ?? 'Login' }} @endsection

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

{{-- SEO Meta --}}
<meta name="description" content="{{ $seoData->description ?? 'Access your account and manage your settings on Market Place Main.' }}">
<meta name="keywords" content="{{ $seoData->keywords ?? 'login, user access, Market Place Main' }}">

{{-- Open Graph Meta --}}
<meta property="og:title" content="{{ $seoData->title ?? 'Login - Market Place Main' }}">
<meta property="og:description" content="{{ $seoData->description ?? 'Access your account and manage your settings on Market Place Main.' }}">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:type" content="website">
<meta property="og:image" content="{{ $ogImage }}">

{{-- Twitter Meta --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $seoData->title ?? 'Login - Market Place Main' }}">
<meta name="twitter:description" content="{{ $seoData->description ?? 'Access your account and manage your settings on Market Place Main.' }}">
<meta name="twitter:image" content="{{ $ogImage }}">

@if ($site && $site['value']['logo_image'] && $site['value']['logo_image'] != null)
    <meta property="og:logo" content="{{ asset('storage/Logo_Settings/'.$site['value']['logo_image']) }}" />
@else
    <meta property="og:logo" content="{{ asset('front-end/images/infiniylogo.png') }}" />
@endif
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
         .footer-04 .form-control {
             padding: 14px 15px !important;
         }
          .register-container{
            max-width: 100% !important;
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
                        <div class=" mb-1">
                            <div class="text-center mt-2">
                                <div class="google">
                                    <a href="{{ url('/user-login/google') }}" class="btn btn-google blue_common_btn"> 
                                        <svg viewBox="0 0 100 100" preserveAspectRatio="none">
                                        <polyline points="99,1 99,99 1,99 1,1 99,1" class="bg-line"></polyline>
                                        <polyline points="99,1 99,99 1,99 1,1 99,1" class="hl-line"></polyline>
                                  </svg><span class="ml-4">Continue with Google</span></a>
                                </div>
                                <div class="google mt-3">
                                    <a href="{{ route('github.login') }}"class="btn btn-github blue_common_btn"> 
                                        <svg viewBox="0 0 100 100" preserveAspectRatio="none">
                                        <polyline points="99,1 99,99 1,99 1,1 99,1" class="bg-line"></polyline>
                                        <polyline points="99,1 99,99 1,99 1,1 99,1" class="hl-line"></polyline>
                                  </svg><span class="ml-4"> Sign in with GitHub</span></a>
                                </div>
                                <div class="google mt-3">
                                    <a href="{{ route('linkedin.login') }}"class="btn btn-linkedin blue_common_btn"> 
                                        <svg viewBox="0 0 100 100" preserveAspectRatio="none">
                                        <polyline points="99,1 99,99 1,99 1,1 99,1" class="bg-line"></polyline>
                                        <polyline points="99,1 99,99 1,99 1,1 99,1" class="hl-line"></polyline>
                                  </svg><span class="ml-4"> Sign in with LinkedIn</span></a>
                                </div>
                                {{-- <a href="{{ url('/user-login/google') }}" class="btn btn-google">Continue with Google</a>

                                <a href="{{ route('github.login') }}" class="btn btn-github mt-3">
                                    Sign in with GitHub
                                </a>
                                <a href="{{ route('linkedin.login') }}" class="btn btn-linkedin mt-3">
                                    Sign in with LinkedIn
                                </a> --}}
                                
                            </div>
                        </div>
                        <div class="d-flex flex-wrap or_border">
                            <div class="left_border"></div>
                            <span class="mt-3">or</span>
                            <div class="left_border"></div>
                          </div>                          
                        <div class=" mt-4">
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
                        <div class="">
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
                        <div class="">
                            <button type="submit" class="blue_common_btn btn btn-block pink-btn" id="login-btn">
                                <svg viewBox="0 0 100 100" preserveAspectRatio="none">
                                    <polyline points="99,1 99,99 1,99 1,1 99,1" class="bg-line"></polyline>
                                    <polyline points="99,1 99,99 1,99 1,1 99,1" class="hl-line"></polyline>
                                </svg>
                                <span class="ml-3">Sign In</span>
                            </button>
                            {{-- <button type="submit" class="btn btn-block pink-btn mb-3 mt-1" id="login-btn" style="cursor: pointer;">Sign In</button> --}}
                            <p class="text-center d-block text-white">Don't Have an Account ..? <a
                                 class="a_color"   href="{{ route('signup') }}"> Register </a> </p>
                            <p class="text-center d-block text-white mb-1">Forgot Your Password..?<a class="a_color" href="{{ route('forget-password-get') }}"> Reset Password </a></p>
                            <div class="bottom-border mb-3 mt-3"></div>
                            <span class="sc-FEMpB jDOPhs font-13">By continuing, you confirm you are 18 or over and agree to our <a
                                href="{{ route('privacy-policy') }}" class="a_color"
                                target="_blank" rel="noopener noreferrer" data-testid="privacyPolicyLink">Privacy
                                Policy</a> and <a href="{{ route('terms-and-condition') }}"
                                class="a_color" target="_blank" rel="noopener noreferrer"
                                data-testid="userTermsLink">Terms of Use</a>.
                            </span>
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
