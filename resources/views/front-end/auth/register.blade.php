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
   </style>
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
            <div class="col-md-6">
                <div class="row  border p-3 pt-4 pb-4 border-radius-1">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" name="firstname" id="firstname" class="form-control" placeholder=""/>
                            <label for="firstname" class="floating-label">First Name</label>
                            <div class="error" id="firstname_error"></div>
                            @error('first_name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>   
                    <div class="col-md-6">
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
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="email" class="form-control" id="email" name="email" required>
                            <label for="email" class="floating-label">Email</label>
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <div class="error" id="email_error"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <select name="country_code" id="country_code" class="form-control select-input"
                                required="required">
                                <option value="">Select country code</option>
                                @foreach ($countaries as $countery)
                                    <option value="{{ $countery->id }}">
                                        {{ $countery->country_code }}</option>
                                @endforeach
                            </select>
                           @error('country_code')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" id="contact_number" name="contact_number">
                            <label for="contact_number" class="floating-label">Contact Number</label>
                            @error('contact_number')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <div class="error" id="contact_number_error"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
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
                    </div>
                    <div class="col-md-6">
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
                    </div>
                    <div class="col-md-6">
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
                            <input type="password" class="form-control" id="password" name="password" required>
                            <label for="password" class="floating-label">Password</label>
                            @error('password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <div class="error" id="password_error"></div>
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
                            <button type="submit" class="btn btn-block pink-btn mt-3">Register</button>
                          <p class="text-center d-block text-white mt-3">Already an Account ..? <a href="{{ url('user-login') }}"> Login </a> </p>       
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
            // const firstnameInput = document.getElementById("firstname");
            // const firstnameError = document.getElementById("firstname_error");

            // firstnameInput.addEventListener("blur", () => {
            //     if (!firstnameInput.value.trim()) {
            //     firstnameError.textContent = "First Name is required!";
            //     firstnameError.style.display = "block"; 
            //     } else {
            //     firstnameError.style.display = "none"; 
            //     }
            // });
            // const floatingLabel = document.querySelector(".floating-label");

            // window.addEventListener("DOMContentLoaded", () => {
            //     if (firstnameInput.value.trim() !== "") {
            //     floatingLabel.style.top = "50%";
            //     floatingLabel.style.fontSize = "0.8rem";
            //     }
            // });

            // firstnameInput.addEventListener("focus", () => {
            //     floatingLabel.style.top = "-1%";
            //     floatingLabel.style.fontSize = "0.8rem";
            // });

            // firstnameInput.addEventListener("blur", () => {
            //     if (!firstnameInput.value.trim()) {
            //     floatingLabel.style.top = "35%";
            //     floatingLabel.style.fontSize = "1rem";
            //     floatingLabel.style.color = "red";
            //     firstnameInput.style.borderColor = "red";
            //     }
            //     else {  
            //     floatingLabel.style.color = "#70657b";
            //     firstnameInput.style.borderColor = "#ccc";
            //     }
            // });
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