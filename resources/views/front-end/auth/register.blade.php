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
   </style>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.css" />
@endsection
@section('content')
<div class="container pt-5 pb-5 register-container">
    <div class="title">
        <h3><span class="txt-black">Sign</span><span class="color-blue underline-text"> Up</span></h3>
    </div>
    <form action="{{ route('user-register-post') }}" method="POST">
       @csrf
       <input type="hidden" name="recaptcha" id="recaptcha">
        <div class="row justify-content-center">
            <d<div class="col-xl-3 col-lg-8 col-md-12 col-sm-12 col-12">
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
                            <input type="text" name="firstname" id="firstname" class="form-control" placeholder="" required/>
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
                            <input type="text" class="form-control" id="last_name" name="last_name"  placeholder="" required>
                            <label for="firstname" class="floating-label">Last Name</label>
                            @error('last_name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <div class="error" id="last_name_error"></div>
                        </div>
                    </div>
                    <div class="">
                        <div class="form-group">
                            <input type="email" class="form-control" id="email" name="email" required>
                            <label for="email" class="floating-label">Email</label>
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <div class="error" id="email_error"></div>
                        </div>
                    </div>
                    <div class="">
                        <div class="form-group mb-1">
                            <input type="password" class="form-control" id="password" name="password" required>
                            <label for="password" class="floating-label">Password</label>
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
                            <button type="submit" class="blue_common_btn btn btn-block pink-btn" id="login-btn">
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
    </script>
    
@endsection