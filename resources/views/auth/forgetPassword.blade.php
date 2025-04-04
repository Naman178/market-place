@extends('front-end.common.master')
@section('title')
    <title>Skyfinity Quick Checkout | Login</title>
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
    </style>
@endsection
@section('content')
<div class="forgot_password cust-page-padding">
    <div class="cotainer register-container pt-5 pb-5">
        <div class="title text-center">
            <h3><span class="txt-black">Forgot</span><span class="color-blue underline-text"> Password</span></h3>
        </div>
        <div class="row justify-content-center">
            <div class="col-xl-3 col-lg-8 col-md-12 col-sm-12 col-12">
                <div class="card p-4 dark-blue-card mb-5">                    
                    {{-- <h1 class="mb-3 text-8 text-center text-white">Forgot Password</h1>                     --}}
                    @if (Session::has('message'))
                        <p class="text-white"> {{ Session::get('message') }} </p>                    
                    @endif
                    <form action="{{ route('forget-password-post') }}" method="POST">
                        @csrf
                        <div class="col-md-12">
                            <div class="form-group">  
                            <input type="email" id="email" class="form-control" placeholder="" name="email" required value="{{ old('email') }}">
                                
                            <label for="email_address"  class="floating-label">E-Mail Address</label>
                          
                            @error('email')
                                <div class="text-danger" id="email_error_message">{{ $message }}</div>
                            @enderror
                            <div class="error" id="email_error"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="blue_common_btn btn btn-block pink-btn" id="login-btn">
                                <svg viewBox="0 0 100 100" preserveAspectRatio="none">
                                    <polyline points="99,1 99,99 1,99 1,1 99,1" class="bg-line"></polyline>
                                    <polyline points="99,1 99,99 1,99 1,1 99,1" class="hl-line"></polyline>
                                </svg>
                                <span class="ml-3">Send Password Reset Link</span>
                            </button>
                            {{-- <button type="submit" class="btn btn-block pink-btn mt-3" id="login-btn" style="cursor: pointer;">Send Password Reset Link</button> --}}
                            <p class="text-center d-block text-white"><a class="a_color" href="{{ url('user-login') }}">Back to Login </a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const inputFields = document.querySelectorAll(".form-control");
    // Function to handle floating label
    function updateFloatingLabel(input) {
        const label = input.nextElementSibling; // Get the label
        const errorMessage = document.getElementById(input.id + "_error_message");

        if (input.value.trim() !== "" || (errorMessage && errorMessage.textContent.trim() !== "")) {
            label.style.top = input.id === "email" ? "18%" : "50%"; // Email: 18%, Others: 50%
            label.style.fontSize = "1rem";
            label.style.color = "#70657b";
        } else {
            label.style.top = "50%";
            label.style.fontSize = "1rem";
            label.style.color = "#70657b";
        }
    }

    function handleBlur(input) {
        const label = input.nextElementSibling;
        if (input.value.trim() === "") {
            label.style.color = "red";
            label.style.top = input.id === "email" ? "18%" : "35%"; // Email stays 18% on error, others at 35%
        }
    }

    // Initialize labels on page load
    inputFields.forEach(input => {
        updateFloatingLabel(input);
        const label = input.nextElementSibling;

        input.addEventListener("blur", function () {
            const errorDiv = document.getElementById(input.id + "_error");
            const errorMessage = document.getElementById(input.id + "_error_message");

            if (!input.value.trim()) {
                if (errorDiv) {
                    errorDiv.textContent = input.name.replace("_", " ") + " is required!";
                    errorDiv.style.display = "block";
                }
                input.style.borderColor = "red";
                label.style.top = input.id === "email" ? "18%" : "35%";
                label.style.fontSize = "1rem";
                label.style.color = "red";
            } else {
                if (errorDiv) {
                    errorDiv.style.display = "none";
                }
                input.style.borderColor = "#ccc";
                label.style.color = "#70657b";
            }

            // If Laravel error message exists, keep the label at 18%
            if (errorMessage && errorMessage.textContent.trim() !== "") {
                label.style.top = "18%";
            }
        });

        input.addEventListener("focus", function () {
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