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
        <h3><span class="txt-black">Sign</span><span class="color-blue underline-text"> Up</span></h3>
    </div>
    <form action="{{ route('user-register-post') }}" method="POST">
       @csrf
       <input type="hidden" name="recaptcha" id="recaptcha">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="row  border p-3 pt-4 pb-4 border-radius-1">
                    {{-- <div class="col-md-6">
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" required>
                             @error('first_name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div> --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" name="firstname" id="firstname" class="form-control" placeholder=""/>
                            <label for="firstname" class="floating-label">First Name</label>
                            <div class="error" id="firstname_error"></div>
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
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control"  id="email" name="email" required>
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
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
                            <label for="contact_number">Contact Number</label>
                            <input type="text" class="form-control" id="contact_number" name="contact_number">
                           @error('contact_number')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="company_name">Company Name</label>
                            <input type="text" class="form-control" id="company_name" name="company_name">
                             @error('company_name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="company_website">Company Website</label>
                            <input type="url" class="form-control" id="company_website" name="company_website">
                             @error('company_website')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
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
                            <label for="address_line1">Address Line 1</label>
                            <input type="text" class="form-control" id="address_line1" name="address_line1">
                            @error('address_line1')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="address_line2">Address Line 2</label>
                            <input type="text" class="form-control" id="address_line2" name="address_line2">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" class="form-control" id="city" name="city">
                         @error('city')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="postal_code">Zip / Postal Code</label>
                            <input type="text" class="form-control" id="postal_code" name="postal_code">
                            @error('postal_code')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            @error('password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                            @error('password_confirmation')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
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
                grecaptcha.execute('{{ config('services.recaptcha.sitekey') }}', {action: 'singup'}).then(function(token) {
                if (token) {
                    document.getElementById('recaptcha').value = token;
                    document.getElementById('recaptcha1').value = token;
                }
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
                        label.style.top = "-1%";
                        label.style.fontSize = "0.8rem";
                        label.style.color = "#70657b";
                    } else if (input.value.trim() === "") {
                        label.style.top = "35%";
                        label.style.fontSize = "1rem";
                        label.style.color = "red";
                    } else {
                        label.style.top = "50%";
                        label.style.fontSize = "1rem";
                        label.style.color = "#70657b";
                    }
                }

                // Initialize labels on page load
                inputFields.forEach(input => {
                    updateFloatingLabel(input);

                    // Blur event: Check if empty & show error
                    input.addEventListener("blur", function () {
                        const errorDiv = document.getElementById(input.id + "_error");
                        if (!input.value.trim()) {
                            errorDiv.textContent = input.name.replace("_", " ") + " is required!";
                            errorDiv.style.display = "block";
                            input.style.borderColor = "red";
                        } else {
                            errorDiv.style.display = "none";
                            input.style.borderColor = "#ccc";
                        }
                        updateFloatingLabel(input);
                    });

                    // Focus event: Float label
                    input.addEventListener("focus", function () {
                        const label = input.nextElementSibling;
                        label.style.top = "-1%";
                        label.style.fontSize = "0.8rem";
                        if (input.value.trim() !== "") {
                            label.style.color = "#70657b";
                            input.style.borderColor = "#70657b";
                        } else{
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