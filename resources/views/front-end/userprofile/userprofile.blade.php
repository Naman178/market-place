@extends('front-end.common.master')
@php 
 $site = \App\Models\Settings::where('key', 'site_setting')->first();
 
$logoImage = $site['value']['logo_image'] ?? null;
$ogImage = $logoImage 
    ? asset('storage/Logo_Settings/' . $logoImage) 
    : asset('front-end/images/infiniylogo.png');
@endphp
@section('meta')
@section('title'){{ $seoData->title ?? 'User Profile'}} @endsection

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

{{-- SEO Meta --}}
<meta name="description" content="{{ $seoData->description ?? 'View and update your user profile on Market Place Main. Manage your information, settings, and more in one place.' }}">
<meta name="keywords" content="{{ $seoData->keywords ?? 'user profile, account settings, Market Place Main' }}">

{{-- Open Graph Meta --}}
<meta property="og:title" content="{{ $seoData->title ?? 'User Profile - Market Place Main' }}">
<meta property="og:description" content="{{ $seoData->description ?? 'Access and manage your profile on Market Place Main with ease.' }}">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:type" content="website">
<meta property="og:image" content="{{ $ogImage }}">

{{-- Twitter Meta --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $seoData->title ?? 'User Profile - Market Place Main' }}">
<meta name="twitter:description" content="{{ $seoData->description ?? 'Access and manage your profile on Market Place Main with ease.' }}">
<meta name="twitter:image" content="{{ $ogImage }}">
@if ($site && $site['value']['logo_image'] && $site['value']['logo_image'] != null)
    <meta property="og:logo" content="{{ asset('storage/Logo_Settings/'.$site['value']['logo_image']) }}" />
@else
    <meta property="og:logo" content="{{ asset('front-end/images/infiniylogo.png') }}" />
@endif
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset('front-end/css/checkout.css') }}">
    <link rel="stylesheet" href="{{ asset('front-end/css/register.css') }}">
    <style>
        .text-danger{
            color:red;
        }
        .form-control {
             padding: 11px 15px !important;
         }
         /* Ensure dropdown and input are correctly aligned */
        .iti {
            width: 100% !important;
        }

        /* Proper spacing for country dropdown */
        .iti--separate-dial-code .iti__selected-flag {
            background-color: #ffffff !important; /* Light gray background */
            padding: 10px;
            border-radius: 5px 0 0 5px;
            /* border: 1px solid #ced4da; */
            height: 100%;
            display: flex;
            align-items: center;
        }
        
        .iti--separate-dial-code .iti__selected-flag:hover{
            background-color: rgba(0, 0, 0, 0.05) !important; 
        }

        /* Prevent overlapping input */
        .iti--allow-dropdown input {
            padding-left: 100px !important;
        }

        /* Align phone number input field */
        .iti input {
            height: 45px !important;
            border-radius: 5px !important;
        }
        #profile_pic_title{
            font-size: 12px;
            margin-bottom: 2px;
            overflow: auto;
        }
    </style>
    
    <style>
        .filelabel {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            height: auto;
            gap: 10px;
            cursor: pointer;
        }
        
        .filelabel input[type="file"] {
            display: none;
        }
        
        .btn-outline-primary {
            background-color: #007AC1;
            color: white !important;
            padding: 8px 12px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        
        .btn-outline-primary:hover {
            background-color: #292B46;
        }
        
       .image-input-wrapper {
            padding: 10px;
            min-height: 100px;
            position: relative;
        }

        .previewImgCls {
            width: 120px;
            height: 75px;
            object-fit: contain;
            display: none;
        }

        
        .hidepreviewimg {
            display: none;
        }
    
        .file-name {
            font-size: 14px;
            color: #333;
        }
        .underline::after{
            bottom: -45px !important;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.css" />
@endsection
@section('scripts')
    <script src="https://js.stripe.com/v3/"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>
    <script>
       document.addEventListener("DOMContentLoaded", function () {
            const inputFields = document.querySelectorAll(".custom-css");

            function updateFloatingLabel(input) {
                const label = input.nextElementSibling;
                const errorDiv = document.getElementById(input.id + "_error");
                const hasError = errorDiv && errorDiv.textContent.trim() !== "";

                if (!label) return;

               if (input.value.trim() !== "") {
                    label.style.top = "-1%";
                    label.style.fontSize = "14px";
                    label.style.color = "#70657b";
                    input.style.borderColor = "#ccc";
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
            }

            inputFields.forEach(input => {
                const errorDiv = document.getElementById(input.id + "_error");

                // Initialize floating label
                updateFloatingLabel(input);

                // Blur: validate input and show/hide error
                input.addEventListener("blur", function () {
                    if (!input.value.trim()) {
                        if (errorDiv) {
                            errorDiv.textContent = input.name.replace("_", " ") + " is required!";
                            errorDiv.style.display = "block";
                        }
                        input.style.borderColor = "red";
                    } else {
                        if (errorDiv) {
                            errorDiv.textContent = "";
                            errorDiv.style.display = "none";
                        }
                        input.style.borderColor = "#ccc";
                    }
                    updateFloatingLabel(input);
                });

                // Focus: show floating label
                input.addEventListener("focus", function () {
                    const label = input.nextElementSibling;
                    if (!label) return;

                    label.style.top = "-1%";
                    label.style.fontSize = "0.8rem";

                    if (input.value.trim() !== "") {
                        label.style.color = "#70657b";
                        input.style.borderColor = "#70657b";
                    } else {
                        const hasError = errorDiv && errorDiv.textContent.trim() !== "";
                        label.style.color = hasError ? "red" : "#70657b";
                        input.style.borderColor = hasError ? "red" : "#ccc";
                    }
                });
            });
            function validateInput(input) {
                const errorDiv = document.getElementById(input.id + "_error");
                if (!input.value.trim()) {
                    errorDiv.textContent = input.name.replace(/_/g, " ") + " is required!";
                    input.classList.add('is-invalid');
                    return false;
                } else {
                    errorDiv.textContent = "";
                    input.classList.remove('is-invalid');
                    return true;
                }
            }
            document.querySelectorAll('.custom-css').forEach(input => {
                input.addEventListener('blur', () => validateInput(input));
            });

            $(document).on("click", ".erp-profile-form", function(e) {
                e.preventDefault(); // Prevent any default action or form submit

                // Trigger blur on all inputs to validate all
                $(".custom-css").each(function() {
                    this.dispatchEvent(new Event('blur'));
                });

                // If any invalid inputs exist, stop submission
                if ($('.custom-css.is-invalid').length > 0) {
                    return; // Stop AJAX submit if errors exist
                }

                var submitUrl = $('#profile_form').data("url");
                var formData = new FormData($('#profile_form')[0]);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $("#preloader").show();

                $.ajax({
                    url: submitUrl,
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {
                        $("#preloader").hide();
                        $('.input-error').removeClass('is-invalid');

                        if (response.success) {
                            localStorage.setItem('successMessage', response.success);
                            window.location.href = "{{ route('profile') }}";  // Redirect only if success
                        } else if (response.error) {
                            // Show server-side validation errors, no redirect
                            handleErrorMessages(response.error);
                            $.each(response.error, function(key, value) {
                                toastr.error(value);
                            });
                            // Do NOT reload or redirect here — stay on page
                        }
                    },
                    error: function(error) {
                        console.error('Ajax request failed:', error);
                        $("#preloader").hide();
                    }
                });
            });


            function handleErrorMessages(errors) {
                $('#firstname_error').text(errors.firstname || '');
                $('#lastname_error').text(errors.lastname || '');
                $('#email_error').text(errors.email || '');
                $('#contact_error').text(errors.contact || '');
                $('#company_name_error').text(errors.company_name || '');
                $('#company_website_error').text(errors.company_website || '');
                $('#city_error').text(errors.city || '');
                $('#postal_error').text(errors.postal || '');
                $('#address_line_one_error').text(errors.address_line_one || '');
                $('#profile_pic_error').text(errors.profile_pic || '');
            }
        });
        //  $('#country').select2();
        //  $('#country_code').select2();
    </script>
    
    <script>
        $(document).ready(function () {
            var phoneInput = document.querySelector("#contact");
    
            // Initialize intl-tel-input
            var iti = window.intlTelInput(phoneInput, {
                separateDialCode: true,
                preferredCountries: ["us", "gb", "in"], // Set preferred countries
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js"
            });
    
            // Retrieve stored country ISO code
            var userISOCode = $("#country_name").val(); // e.g., "US"
    
            // Set the pre-selected country based on ISO code
            if (userISOCode) {
                iti.setCountry(userISOCode.toLowerCase()); // Convert to lowercase for intlTelInput
            }
    
            // Listen for country changes and store both ISO code and dial code
            phoneInput.addEventListener("countrychange", function () {
                var countryData = iti.getSelectedCountryData();
                $("#country_code").val(countryData.dialCode);  // ✅ Save dial code (e.g., "1")
                $("#country_name").val(countryData.iso2.toUpperCase());  // ✅ Save ISO code (e.g., "US")
            });
    
            // Ensure both country_code & country_name are stored before form submission
            $("form").submit(function () {
                var countryData = iti.getSelectedCountryData();
                $("#country_code").val(countryData.dialCode);
                $("#country_name").val(countryData.iso2.toUpperCase());
            });
        });
    </script>
    
    <script>
        function previewImage(event) {
            const preview = document.getElementById('preview');
            const fileInput = event.target;
            const file = fileInput.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';

                    // Add class to expand wrapper
                    fileInput.closest('.image-input-wrapper').classList.add('show-preview');
                };
                reader.readAsDataURL(file);
            }
        }

    </script>
    
    
    
@endsection
@section('content')
    <div class="container">
        <div class="checkout  pt-5 padding">
            <div class="container  register-container">
                <div class="title">
                    <h3><span class="txt-black">Profile   </span><span class="color-blue underline"> Details</span></h3>
                </div>   
                <div class="row justify-content-center">
                    <!-- if user is already logged in -->
                    <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 col-12">

                        @php $name = optional($user)->name ? explode(" ", $user->name) : ['', ''];  @endphp
                        <div class="col-md-12 border p-4 card">
                            {{-- <h4 class="mb-5 txt-white">Profile Details</h4> --}}
                            <form method="POST" class="erp-profile-submit" id="profile_form" enctype="multipart/form-data"
                                data-url="{{ route('store-user-profile') }}">
                                @csrf
                                <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}">
                                <input type="hidden" name="old_photo" value="{{ $user->profile_pic }}">         
                                <div class="row">
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <input type="text" name="firstname" id="firstname" class="form-control custom-css"
                                                placeholder="" value="{{ $name[0] }}">
                                            <label for="firstname" class="floating-label">First Name</label>
                                            <div class="error" id="firstname_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="lastname" id="lastname" class="form-control custom-css"
                                                value="{{ $name[1] ?? '' }}" placeholder="">
                                            <label for="lastname" class="floating-label">Last Name</label>
                                            <div class="error" id="lastname_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="text" name="email" id="email" class="form-control custom-css"
                                                placeholder="" value="{{ optional($user)->email }}">
                                                <label for="email" class="floating-label">Email</label>
                                            <div class="error" id="email_error"></div>
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-12">
                                        <label for="category_image">Image</label>
                                        <label class="form-control filelabel image-input-wrapper">
                                            <input type="file" name="profile_pic" id="profile_pic" class="form-control input-error image-input" onchange="previewImage(event)">
                                            <span class="btn btn-outline-primary">
                                                <i class="i-File-Upload nav-icon font-weight-bold cust-icon"></i>Choose File
                                            </span>
                                            <img id="preview" class="previewImgCls hidepreviewimg" 
                                                src="@if(!empty($user->profile_pic)){{asset('assets/images/faces/'.$user->profile_pic)}}@endif" 
                                                style="{{$user->profile_pic ? 'display:block;' : 'display:none;'}}">
                                            <span class="title" id="profile_pic_title">{{ $user->profile_pic ?? '' }}</span>
                                            <span id="file_name" class="file-name"></span>
                                        </label>   
                                    </div>--}}
                                    {{-- <label for="category_image">Image</label> --}}
                                    <label class="form-control filelabel image-input-wrapper" style="margin: -4px 14px 14px 17px;">
                                        <input type="hidden" name="old_image" value="@if(!empty($user->profile_pic)){{$user->profile_pic}}@endif">
                                        <input type="file" name="profile_pic" id="profile_pic" class="form-control input-error image-input" onchange="previewImage(event)">
                                        <span class="btn btn-outline-primary">
                                            <i class="i-File-Upload nav-icon font-weight-bold cust-icon"></i>Choose File
                                        </span>
                                        {{-- <img id="preview" class="previewImgCls hidepreviewimg" 
                                            src="@if(!empty($user->profile_pic)){{ asset('assets/images/faces/'.$user->profile_pic) }}@else{{ asset('assets/images/faces/default.png') }}@endif"
                                            style="@if(!empty($user->profile_pic)) display:block; @else display:none; @endif"> --}}
                                            @php
                                                $profilePic = filter_var($user->profile_pic, FILTER_VALIDATE_URL)
                                                            ? $user->profile_pic
                                                            : asset('assets/images/faces/' . $user->profile_pic);
                                            @endphp
                                            <img id="preview" class="previewImgCls hidepreviewimg" src="{{ $profilePic }}" alt="profile"  style="@if(!empty($user->profile_pic)) display:block; @else display:none; @endif">
                                        <span class="title" id="profile_pic_title">{{ $user->profile_pic ?? '' }}</span>
                                        <span id="file_name" class="file-name"></span>
                                    </label>
                                    {{-- <div class="col-md-12">
                                        <div class="form-group">
                                            <input  type="file" name="profile_pic" id="profile_pic" class="form-control"
                                                placeholder="">
                                            <div class="error" id="profile_pic_error"></div>
                                        </div>
                                        @if ($user->profile_pic)
                                            <img class="mb-3" src="{{asset('assets/images/faces/' . $user->profile_pic) }}" alt="photo" width="100" height="100">
                                        @else
                                            <img class="mb-3" src="{{asset('assets/images/faces/1.png') }}" alt="photo" width="100" height="100">
                                        @endif
                                        @if ($errors->has('profile_pic'))
                                            <div class="text-red-500 text-sm">{{ $errors->first('profile_pic') }}</div>
                                        @endif
                                    </div> --}}
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {{-- <select name="country_code" id="country_code" class="form-control select-input"
                                                required="required">
                                                <option value="">Select country code</option>
                                                @foreach ($countaries as $countery)
                                                    <option value="{{ $countery->id }}"
                                                        {{ $user->country_code == $countery->id ? 'selected' : '' }}>
                                                        {{ $countery->country_code }}</option>
                                                @endforeach
                                            </select> --}}
                                            <input type="tel" id="contact" name="contact" class="form-control" value="{{ optional($user)->contact_number }}">
                                            <input type="hidden" name="country_code" id="country_code" value="{{ $user->country_code }}">
                                            {{-- <input type="hidden" name="country_code_name" id="country_code_name" value="{{ $dialCode }}"> --}}
                                            <input type="hidden" name="country_name" id="country_name" value="{{$isoName}}">
                                            @error('country_code')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                            <div class="error" id="country_code_error"></div>
                                        </div>
                                    </div>                           
                                    {{-- <div class="col-md-8">
                                        <div class="form-group">
                                            <input type="number" name="contact" id="contact" class="form-control"
                                                placeholder="" 
                                                value="{{ optional($user)->contact_number }}">
                                            <label for="contact" class="floating-label">Contact Number</label>
                                            <div class="error" id="contact_error"></div>
                                        </div>
                                    </div> --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="company_name" id="company_name" class="form-control custom-css"
                                                placeholder=""
                                                value="{{ optional($user)->company_name }}">
                                                <label for="company_name" class="floating-label">Company Name</label>
                                            <div class="error" id="company_name_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="company_website" id="company_website"
                                                class="form-control custom-css" placeholder=""
                                                value="{{ optional($user)->company_website }}">
                                                <label for="company_website" class="floating-label">Company Website</label>
                                            <div class="error" id="company_website_error"></div>
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-12">
                                        <div class="form-group">
                                            <select name="country" id="country" class="form-control custom-css select-input">
                                                <option value="0">Select Country</option>
                                                @foreach ($countaries as $countery)
                                                    <option value="{{ $countery->id }}"
                                                        data-country-code="{{ $countery->ISOname }}"
                                                        {{ $user->country == $countery->id ? 'selected' : '' }}>
                                                        {{ $countery->name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="error" id="country_error"></div>
                                        </div>
                                    </div> --}}
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="text" name="address_line1" id="address_line_one"
                                                class="form-control custom-css" placeholder=""
                                                value="{{ optional($user)->address_line1 }}">
                                                <label for="address_line_one" class="floating-label">Address Line 1</label>
                                            <div class="error" id="address_line_one_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="text" name="address_line2" id="address_line_two"
                                                class="form-control custom-css" placeholder=""
                                                value="{{ optional($user)->address_line2 }}">
                                                <label for="address_line_two" class="floating-label">Address Line 2</label>
                                            <div class="error" id="address_line_two_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="city" id="city" class="form-control custom-css"
                                                placeholder="" value="{{ optional($user)->city }}">
                                                <label for="city" class="floating-label">City</label>
                                            <div class="error" id="city_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="postal" id="postal" class="form-control custom-css"
                                                placeholder=""
                                                value="{{ optional($user)->postal_code }}">
                                                <label for="postal" class="floating-label">Zip / Postal Code</label>
                                            <div class="error" id="postal_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button type="button" class="blue_common_btn btn btn-block pink-btn mt-3 erp-profile-form">
                                          <svg viewBox="0 0 100 100" preserveAspectRatio="none">
                                              <polyline points="99,1 99,99 1,99 1,1 99,1" class="bg-line"></polyline>
                                              <polyline points="99,1 99,99 1,99 1,1 99,1" class="hl-line"></polyline>
                                          </svg>
                                          <span>Submit</span>
                                      </button>
                                          {{-- <button type="button"
                                              class="btn btn-block pink-btn mt-3 erp-profile-form" style="cursor: pointer;">Submit</button> --}}
                                      </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('front-end.userprofile.userprofilescript')
@section('scripts')
@endsection
