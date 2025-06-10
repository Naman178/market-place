@extends('front-end.common.master')
@php 
    $site = \App\Models\Settings::where('key', 'site_setting')->first();

    $logoImage = $site['value']['logo_image'] ?? null;
    $ogImage = $logoImage 
        ? asset('storage/Logo_Settings/' . $logoImage) 
        : asset('front-end/images/infiniylogo.png');

    // Assuming $seoData is passed from controller or you fetch SEO for sign up page:
    use App\Models\SEO;
    $seoData = SEO::where('page', 'sign up')->first();
@endphp

@section('meta')
@section('title'){{ $seoData->title ?? 'Sign Up' }} @endsection

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

{{-- SEO Meta --}}
<meta name="description" content="{{ $seoData->description ?? 'Create your account on Market Place Main to get started with our platform. Join now for exclusive features and benefits.' }}">
<meta name="keywords" content="{{ $seoData->keywords ?? 'sign up, register, create account, Market Place Main' }}">

{{-- Open Graph Meta --}}
<meta property="og:title" content="{{ $seoData->title ?? 'Sign Up - Market Place Main' }}">
<meta property="og:description" content="{{ $seoData->description ?? 'Create your account on Market Place Main to get started with our platform. Join now for exclusive features and benefits.' }}">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:type" content="website">
<meta property="og:image" content="{{ $ogImage }}">

{{-- Twitter Meta --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $seoData->title ?? 'Sign Up - Market Place Main' }}">
<meta name="twitter:description" content="{{ $seoData->description ?? 'Create your account on Market Place Main to get started with our platform. Join now for exclusive features and benefits.' }}">
<meta name="twitter:image" content="{{ $ogImage }}">

@if ($site && $site['value']['logo_image'] && $site['value']['logo_image'] != null)
    <meta property="og:logo" content="{{ asset('storage/Logo_Settings/' . $site['value']['logo_image']) }}" />
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
        .select2-container .select2-selection--single .select2-selection__rendered {
            padding-top: 7px;
        }
        .select2-container .select2-selection--single{
            height: 43px !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px !important;
        }
        .iti {
            width: 100%;
        }

        .iti--separate-dial-code .iti__selected-flag {
            background-color: #ffffff !important; /* Light gray background */
            padding: 5px;
            border-radius: 5px 0 0 5px;
            /* border: 1px solid #ced4da; */
        }

        .iti--separate-dial-code .iti__flag-container {
            padding-left: 0px;
        }

        .iti--allow-dropdown input {
            padding-left: 100px !important; /* Adjust padding to start after country code */
        }
        /* .btn-google{
            background-position: 122px 12px !important;
        } */
        .text-left{
            text-align: left !important;
            font-size: 15px;
        }
        .underline::after{
            bottom: -45px !important;
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
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.css" />
@endsection
@section('content')
<div class="container pt-5 pb-5 register-container">
    <div class="title">
        <h3><span class="txt-black">Sign</span> <span class="color-blue underline"> Up</span></h3>
    </div>
    <form action="{{ route('user-register-post') }}" method="POST">
       @csrf
       <input type="hidden" name="recaptcha" id="recaptcha">
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
                        </div>
                    </div>
                    <div class=" d-flex flex-wrap or_border">
                        <div class="left_border"></div>
                        <span class="mt-3">or</span>
                        <div class="left_border"></div>
                    </div>
                    <div class=" mt-4">
                        <div class="form-group">
                            <input type="text" name="firstname" id="firstname" class="form-control" placeholder=""/>
                            <label for="firstname" class="floating-label">First Name</label>
                            <div class="error" id="firstname_error"></div>
                            @error('firstname')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>   
                    <div class="">
                        <div class="form-group">
                            {{-- <label for="last_name">Last Name</label> --}}
                            <input type="text" class="form-control" id="last_name" name="last_name"  placeholder="">
                            <label for="last_name" class="floating-label">Last Name</label>
                            @error('last_name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <div class="error" id="last_name_error"></div>
                        </div>
                    </div>
                    <div class="">
                        <div class="form-group">
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                            <label for="email" class="floating-label">Email</label>
                            @error('email')
                                <div class="text-danger" id="email_error_message">{{ $message }}</div>
                            @enderror
                            <div class="error" id="email_error"></div>
                        </div>
                    </div>
                   <div class="">
                        <div class="form-group mb-1" style="position: relative;">
                            <input type="password" class="form-control" id="password" name="password">
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
                        <div class="form-group mb-1">
                            <div class="d-flex flex-wrap">
                                <input id="promotionsSubscriber" name="promotionsSubscriber" type="checkbox" class="form-check-input" checked>
                                <span for="promotionsSubscriber" class="text-left d-block text-white mt-3 mb-2 ml-2 cursor-pointer">Send me tips, trends, freebies, updates & offers. <br> You can unsubscribe at any time.</span> 
                            </div> 
                            <button type="button" class="blue_common_btn btn btn-block pink-btn" id="login-btn">
                                <svg viewBox="0 0 100 100" preserveAspectRatio="none">
                                    <polyline points="99,1 99,99 1,99 1,1 99,1" class="bg-line"></polyline>
                                    <polyline points="99,1 99,99 1,99 1,1 99,1" class="hl-line"></polyline>
                                </svg>
                                <span class="ml-3">Register</span>
                            </button>
                            {{-- <button type="submit" class="btn btn-block pink-btn mt-3 mb-2" style="cursor: pointer;">Register</button> --}}
                          <p class="text-center d-block text-white mt-3 mb-2">Already an Account ..? <a class="a_color" href="{{ url('user-login') }}"> Login </a> </p>       
                        </div>
                        <div class="bottom-border mb-3 mt-3"></div>
                        <span class="sc-FEMpB jDOPhs font-13">By continuing, you confirm you are 18 or over and agree to our <a
                            href="{{ route('privacy-policy') }}" class="a_color"
                            target="_blank" rel="noopener noreferrer" data-testid="privacyPolicyLink">Privacy
                            Policy</a> and <a href="{{ route('terms-and-condition') }}"
                            class="a_color" target="_blank" rel="noopener noreferrer"
                            data-testid="userTermsLink">Terms of Use</a>.
                        </span>
                    </div>
                    {{-- <div class="col-md-6">
                        <div class="form-group">
                            <input type="tel" id="phone" name="phone" class="form-control" required="required">
                            <input type="hidden" name="country_code" id="country_code">
                            @error('country_code')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div> --}}
                    {{-- <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" id="contact_number" name="contact_number">
                            <label for="contact_number" class="floating-label">Contact Number</label>
                            @error('contact_number')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <div class="error" id="contact_number_error"></div>
                        </div>
                    </div> --}}
                    {{-- <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" name="company_name" id="company_name" class="form-control" placeholder=""/>
                            <label for="company_name" class="floating-label">Company Name</label>
                            @error('company_name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <div class="error" id="company_name_error"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="url" name="company_website" id="company_website" class="form-control" placeholder=""/>
                            <label for="company_website" class="floating-label">Company Website</label>
                            @error('company_website')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <div class="error" id="company_website_error"></div>
                        </div>
                    </div> --}}
                    {{-- <div class="col-md-6">
                        <div class="form-group">
                            <select name="country" id="country" class="form-control select-input">
                                <option value="0">Select Country</option>
                                @foreach ($countaries as $countery)
                                    <option value="{{ $countery->id }}"
                                        data-country-code="{{ $countery->ISOname }}">
                                        {{ $countery->name }}</option>
                                @endforeach
                            </select>
                            @error('country')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div> --}}
                    {{-- <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" name="address_line1" id="address_line1" class="form-control" placeholder=""/>
                            <label for="address_line1" class="floating-label">Address Line 1</label>
                            @error('address_line1')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <div class="error" id="address_line1_error"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" name="address_line2" id="address_line2" class="form-control" placeholder=""/>
                            <label for="address_line2" class="floating-label">Address Line 2</label>
                            <div class="error" id="address_line2_error"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" name="city" id="city" class="form-control" placeholder=""/>
                            <label for="city" class="floating-label">City</label>
                            @error('city')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <div class="error" id="city_error"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" name="postal_code" id="postal_code" class="form-control" placeholder=""/>
                            <label for="postal_code" class="floating-label">Zip / Postal Code</label>
                            @error('postal_code')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <div class="error" id="postal_code_error"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                            <label for="password_confirmation" class="floating-label">Confirm Password</label>
                            @error('password_confirmation')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <div class="error" id="password_confirmation_error"></div>
                        </div>
                    </div>                    
                    <div class="col-md-12 pt-3">
                        <div class="form-group">
                            <button type="submit" class="btn btn-block pink-btn mt-3" style="cursor: pointer;">Register</button>
                          <p class="text-center d-block text-white mt-3">Already an Account ..? <a href="{{ url('user-login') }}"> Login </a> </p>       
                        </div>
                    </div> --}}
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
            // document.addEventListener("DOMContentLoaded", function () {
            //     const inputFields = document.querySelectorAll(".form-control");

            //     function updateFloatingLabel(input) {
            //         const label = input.nextElementSibling;
            //         const errorDiv = document.getElementById(input.id + "_error");
            //         const hasError = errorDiv && errorDiv.textContent.trim() !== "";

            //         // Specific check for disposable email message
            //         const isDisposableEmailError =
            //             input.id === "email" &&
            //             document.getElementById("email_error_message") &&
            //             document.getElementById("email_error_message").textContent.includes("Disposable Email");

            //         if (isDisposableEmailError) {
            //             label.style.top = "22px";
            //             label.style.fontSize = "0.8rem";
            //             label.style.color = "red";
            //             input.style.borderColor = "red";
            //         } else if (input.value.trim() !== "") {
            //             label.style.top = "-1%";
            //             label.style.fontSize = "0.8rem";
            //             label.style.color = "#70657b";
            //             input.style.borderColor = "#ccc";
            //         } else if (hasError) {
            //             label.style.top = "35%";
            //             label.style.fontSize = "1rem";
            //             label.style.color = "red";
            //             input.style.borderColor = "red";
            //         } else {
            //             label.style.top = "50%";
            //             label.style.fontSize = "1rem";
            //             label.style.color = "#70657b";
            //             input.style.borderColor = "#ccc";
            //         }
            //     }

            //     inputFields.forEach(input => {
            //         const errorDiv = document.getElementById(input.id + "_error");

            //         updateFloatingLabel(input);

            //         input.addEventListener("blur", function () {
            //             const value = input.value.trim();
            //             if (!value) {
            //                 errorDiv.textContent = input.name.replace("_", " ") + " is required!";
            //                 errorDiv.style.display = "block";
            //                 input.style.borderColor = "red";
            //             } else {
            //                 errorDiv.textContent = "";
            //                 errorDiv.style.display = "none";
            //                 input.style.borderColor = "#ccc";
            //             }
            //             updateFloatingLabel(input);
            //         });

            //         input.addEventListener("input", function () {
            //             const value = input.value.trim();

            //             if (input.id === "firstname" || input.id === "last_name") {
            //                 this.value = this.value.replace(/[^a-zA-Z\s]/g, "");
            //                 if (!/^[a-zA-Z\s]+$/.test(this.value)) {
            //                     errorDiv.textContent = "Only letters and spaces are allowed!";
            //                     errorDiv.style.display = "block";
            //                     input.style.borderColor = "red";
            //                 } else {
            //                     errorDiv.textContent = "";
            //                     errorDiv.style.display = "none";
            //                     input.style.borderColor = "#ccc";
            //                 }
            //             }
            //             updateFloatingLabel(input);
            //         });

            //         input.addEventListener("focus", function () {
            //             const label = input.nextElementSibling;
            //             label.style.top = "-1%";
            //             label.style.fontSize = "0.8rem";
            //             input.style.borderColor = "#ccc";

            //             if (errorDiv && errorDiv.textContent.trim() !== "") {
            //                 label.style.color = "red";
            //                 input.style.borderColor = "red";
            //             }
            //         });
            //     });
            // });
            document.addEventListener("DOMContentLoaded", function () {
                const form = document.querySelector("form[action='{{ route('user-register-post') }}']");
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
                        return true;
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
                        loginBtn.setAttribute("type", "submit");
                        form.submit();
                    } else {
                        loginBtn.setAttribute("type", "button");
                    }
                }

                inputFields.forEach(input => {
                    input.addEventListener("blur", () => validateInput(input));

                    input.addEventListener("input", function () {
                        const value = input.value.trim();
                        const errorDiv = document.getElementById(input.id + "_error");

                        // Validation for firstname and last_name (only letters and spaces allowed)
                        if (input.id === "firstname" || input.id === "last_name") {
                            this.value = this.value.replace(/[^a-zA-Z\s]/g, ""); // Remove invalid characters
                            if (!/^[a-zA-Z\s]+$/.test(this.value)) {
                                errorDiv.textContent = "Only letters and spaces are allowed!";
                                errorDiv.style.display = "block";
                                input.style.borderColor = "red";
                            } else {
                                errorDiv.textContent = "";
                                errorDiv.style.display = "none";
                                input.style.borderColor = "#ccc";
                            }
                        }

                        validateInput(input);
                        updateFloatingLabel(input);
                    });

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

                    // ✅ Enter key handling for form submission
                    input.addEventListener("keydown", function (event) {
                        if (event.key === "Enter") {
                            event.preventDefault(); 
                            validateFormAndSubmit();
                        }
                    });
                });

                loginBtn.addEventListener("click", function () {
                    validateFormAndSubmit();
                });

                inputFields.forEach(input => updateFloatingLabel(input));
            });

            $('#country').select2();
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>
    <script>
        $(document).ready(function () {
            var phoneInput = document.querySelector("#phone");
            var iti = window.intlTelInput(phoneInput, {
                separateDialCode: true, // Ensures the country code is separate
                initialCountry: "auto",
                geoIpLookup: function(callback) {
                    $.get("https://ipinfo.io?token=YOUR_TOKEN", function() {}, "jsonp").always(function(resp) {
                        var countryCode = (resp && resp.country) ? resp.country : "us";
                        callback(countryCode);
                    });
                },
                preferredCountries: ["us", "gb", "in"], // Preferred countries
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js"
            });
    
            // Update hidden input with country code when user selects a country
            phoneInput.addEventListener("countrychange", function () {
                var countryData = iti.getSelectedCountryData();
                $("#country_code").val(countryData.dialCode); // Set hidden input value 
            });
    
            // Ensure country code is set before form submission
            $("form").submit(function () {
                var countryData = iti.getSelectedCountryData();
                $("#country_code").val(countryData.dialCode);
            });
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
    </script>
    
@endsection