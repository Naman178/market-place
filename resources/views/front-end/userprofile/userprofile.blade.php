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
    <link rel="stylesheet" href="{{ asset('front-end/css/checkout.css') }}">
    <link rel="stylesheet" href="{{ asset('front-end/css/register.css') }}">
    <style>
        .text-danger{
            color:red;
        }
        .form-control {
             padding: 11px 15px !important;
         }
    </style>
@endsection
@section('scripts')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
                 const inputFields = document.querySelectorAll(".form-control");
                 
                 // Function to handle floating label
                 function updateFloatingLabel(input) {
                     const label = input.nextElementSibling; // Get the corresponding label
                     if (input.value.trim() !== "") {
                         label.style.top = "-1%";
                         label.style.fontSize = "0.8rem";
                         label.style.color = "#70657b";
                     } else {
                         label.style.top = "35%";
                         label.style.fontSize = "1rem";
                         label.style.color = "red";
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
@section('content')
    <div class="container">
        <div class="checkout padding">
            <div class="container  register-container">
                <div class="title">
                    <h3><span class="txt-black">Profile   </span><span class="color-blue underline-text"> Details</span></h3>
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
                                            <input type="text" name="firstname" id="firstname" class="form-control"
                                                placeholder="" value="{{ $name[0] }}">
                                            <label for="firstname" class="floating-label">First Name</label>
                                            <div class="error" id="firstname_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="lastname" id="lastname" class="form-control"
                                                value="{{ $name[1] }}" placeholder="">
                                            <label for="lastname" class="floating-label">Last Name</label>
                                            <div class="error" id="lastname_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="text" name="email" id="email" class="form-control"
                                                placeholder="" value="{{ optional($user)->email }}">
                                                <label for="email" class="floating-label">Email</label>
                                            <div class="error" id="email_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
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
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select name="country_code" id="country_code" class="form-control select-input"
                                                required="required">
                                                <option value="">Select country code</option>
                                                @foreach ($countaries as $countery)
                                                    <option value="{{ $countery->id }}"
                                                        {{ $user->country_code == $countery->id ? 'selected' : '' }}>
                                                        {{ $countery->country_code }}</option>
                                                @endforeach
                                            </select>
                                            <div class="error" id="country_code_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <input type="number" name="contact" id="contact" class="form-control"
                                                placeholder=""
                                                value="{{ optional($user)->contact_number }}">
                                            <label for="contact" class="floating-label">Contact Number</label>
                                            <div class="error" id="contact_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="company_name" id="company_name" class="form-control"
                                                placeholder=""
                                                value="{{ optional($user)->company_name }}">
                                                <label for="company_name" class="floating-label">Company Name</label>
                                            <div class="error" id="company_name_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="company_website" id="company_website"
                                                class="form-control" placeholder=""
                                                value="{{ optional($user)->company_website }}">
                                                <label for="company_website" class="floating-label">Company Website</label>
                                            <div class="error" id="company_website_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <select name="country" id="country" class="form-control select-input">
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
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="text" name="address_line1" id="address_line_one"
                                                class="form-control" placeholder=""
                                                value="{{ optional($user)->address_line1 }}">
                                                <label for="address_line_one" class="floating-label">Address Line 1</label>
                                            <div class="error" id="address_line_one_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="text" name="address_line2" id="address_line_two"
                                                class="form-control" placeholder=""
                                                value="{{ optional($user)->address_line2 }}">
                                                <label for="address_line_two" class="floating-label">Address Line 2</label>
                                            <div class="error" id="address_line_two_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="city" id="city" class="form-control"
                                                placeholder="" value="{{ optional($user)->city }}">
                                                <label for="city" class="floating-label">City</label>
                                            <div class="error" id="city_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="postal" id="postal" class="form-control"
                                                placeholder=""
                                                value="{{ optional($user)->postal_code }}">
                                                <label for="postal" class="floating-label">Zip / Postal Code</label>
                                            <div class="error" id="postal_error"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <button type="button"
                                        class="btn btn-block pink-btn mt-3 erp-profile-form">Submit</button>
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
