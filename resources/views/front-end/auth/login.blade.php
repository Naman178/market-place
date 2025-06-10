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
        .form-group {
            position: relative;
        }

        .toggle-button {
            position: absolute;
            top: 50%;
            right: 12px; /* adjust spacing from the right edge */
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
        @media (max-width: 480px) {
            .eye-icon {
                width: 1rem; /* 16px */
                height: 1rem;
            }
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
                                {!! Form::email('email', null, [
                                    'placeholder' => '',
                                    'class' => 'form-control',
                                    'id' => 'email',
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
                            <div class="form-group" style="position: relative;">
                                {!! Form::password('password', [
                                    'placeholder' => '',
                                    'class' => 'form-control',
                                    'id' => 'password',
                                ]) !!}
                            <label for="password" class="floating-label">Password</label>
                               <button type="button" class="toggle-button" data-toggle="password" aria-label="Toggle Password Visibility">
                                    <!-- Eye icon SVG -->
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="eye-icon" viewBox="0 0 24 24">
                                        <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                                        <path fill-rule="evenodd"
                                            d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                                @error('password')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                <div class="error" id="password_error"></div>
                            </div>
                        </div>
                        <div class="">
                          <button type="button" class="blue_common_btn btn btn-block pink-btn" id="login-btn">
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
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        @endif

        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if (session('error'))
            toastr.error("{{ session('error') }}");
        @endif
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
            const form = document.querySelector("form[action='{{ route('user-login-post') }}']");
            const inputFields = Array.from(document.querySelectorAll(".form-control")).filter(input => input.id && input.id.trim() !== '');
            const loginBtn = document.getElementById("login-btn");

            function getLabelText(input) {
                const label = document.querySelector(`label[for="${input.id}"]`);
                return label ? label.textContent.trim() : input.name || input.id || 'This field';
            }

            function updateFloatingLabel(input) {
                const label = input.nextElementSibling;
                const errorDiv = document.getElementById(input.id + "_error");
                const hasError = errorDiv && errorDiv.textContent.trim() !== "";

                if (!label) return;

                if (input.value.trim() !== "") {
                    label.style.top = "-1%";
                    label.style.fontSize = "0.8rem";
                    label.style.color = hasError ? "red" : "#70657b";
                    input.style.borderColor = hasError ? "red" : "#ccc";
                } else if (hasError) {
                    label.style.top = "35%";
                    label.style.fontSize = "14px";
                    label.style.color = "red";
                    input.style.borderColor = "red";
                } else {
                    label.style.top = "50%";
                    label.style.fontSize = "14px";
                    label.style.color = "#70657b";
                    input.style.borderColor = "#ccc";
                }
                const toggleButton = input.parentElement.querySelector('.toggle-button');
                if (toggleButton) {
                    // If error is shown, push eye icon slightly lower
                    toggleButton.style.top = hasError ? '37%' : '50%';
                    }
            }

            function validateInput(input) {
                console.log("Validating input:", input.id);

                if (!input.id) {
                    console.warn("Skipping validation: input has no id", input);
                    return true; // skip validation or change as needed
                }

                const errorDiv = document.getElementById(input.id + "_error");
                if (!errorDiv) {
                    console.warn("No error div found for input:", input.id);
                    return false;
                }

                const rawValue = input.value;
                const value = (typeof rawValue === 'string') ? rawValue.trim() : '';

                const labelText = getLabelText(input);
                let valid = true;

                if (!value) {
                    errorDiv.textContent = `${labelText} is required!`;
                    valid = false;
                } else if (input.type === "email" && !/^\S+@\S+\.\S+$/.test(value)) {
                    errorDiv.textContent = "Please enter a valid email address!";
                    valid = false;
                } else {
                    errorDiv.textContent = "";
                }

                errorDiv.style.display = valid ? "none" : "block";
                input.style.borderColor = valid ? "#ccc" : "red";
                updateFloatingLabel(input);

                return valid;
            }

            function validateFormAndSubmit() {
                let formIsValid = true;
                inputFields.forEach(input => {
                    if (!validateInput(input)) {
                        formIsValid = false;
                    }
                });

                if (formIsValid) {
                    form.submit();
                }
            }

            // Input events
            inputFields.forEach(input => {
                input.addEventListener("blur", () => validateInput(input));
                input.addEventListener("input", () => validateInput(input));
                input.addEventListener("focus", () => {
                    const label = input.nextElementSibling;
                    if (!label) return;

                    label.style.top = "-1%";
                    label.style.fontSize = "0.8rem";

                    const errorDiv = document.getElementById(input.id + "_error");
                    const hasError = errorDiv && errorDiv.textContent.trim() !== "";
                    label.style.color = hasError ? "red" : "#70657b";
                    input.style.borderColor = hasError ? "red" : "#70657b";
                });

                // Enter key event
                input.addEventListener("keydown", function (event) {
                    if (event.key === "Enter") {
                        event.preventDefault(); // prevent default Enter behavior
                        validateFormAndSubmit(); // use same logic as button
                    }
                });
            });

            // Click event on Sign In button
            loginBtn.addEventListener("click", function () {
                validateFormAndSubmit();
            });

            // Set floating label on page load
            inputFields.forEach(input => updateFloatingLabel(input));
        });
       const eyeIcons = {
            open: `<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="eye-icon" viewBox="0 0 24 24" width="24" height="24">
                    <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                    <path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z" clip-rule="evenodd"/>
                    </svg>`,
            closed: `<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="eye-icon" viewBox="0 0 24 24" width="24" height="24">
                        <path d="M3.53 2.47a.75.75 0 00-1.06 1.06l18 18a.75.75 0 101.06-1.06l-18-18zM22.676 12.553a11.249 11.249 0 01-2.631 4.31l-3.099-3.099a5.25 5.25 0 00-6.71-6.71L7.759 4.577a11.217 11.217 0 014.242-.827c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113z"/>
                        <path d="M15.75 12c0 .18-.013.357-.037.53l-4.244-4.243A3.75 3.75 0 0115.75 12zM12.53 15.713l-4.243-4.244a3.75 3.75 0 004.243 4.243z"/>
                        <path d="M6.75 12c0-.619.107-1.213.304-1.764l-3.1-3.1a11.25 11.25 0 00-2.63 4.31c-.12.362-.12.752 0 1.114 1.489 4.467 5.704 7.69 10.675 7.69 1.5 0 2.933-.294 4.242-.827l-2.477-2.477A5.25 5.25 0 016.75 12z"/>
                    </svg>`
            };

        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.toggle-button').forEach(button => {
                const inputId = button.getAttribute('data-toggle');
                const input = document.getElementById(inputId);
                if (!input) return;

                // Set initial icon (eye open)
                button.innerHTML = eyeIcons.open;

                button.addEventListener('click', () => {
                const isOpen = button.classList.toggle('open');
                input.type = isOpen ? 'text' : 'password';
                button.innerHTML = isOpen ? eyeIcons.closed : eyeIcons.open;
                });
            });
        });

        $('#country').select2();
        $('#country_code').select2();
  </script>

@endsection
