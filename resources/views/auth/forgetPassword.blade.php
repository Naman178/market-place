@extends('front-end.common.master')
@section('title')
{{ $seoData->title ?? 'Fortgot Password' }}
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
        .underline::after{
            bottom: -45px !important;
        }
    </style>
@endsection
@section('content')
<div class="forgot_password cust-page-padding">
    <div class="cotainer register-container pt-5 pb-5">
        <div class="title text-center">
            <h3><span class="txt-black">Forgot</span> <span class="color-blue underline"> Password</span></h3>
        </div>
        <div class=" d-flex justify-content-center">
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

    function updateFloatingLabel(input) {
        const label = input.nextElementSibling;
        const errorDiv = document.getElementById(input.id + "_error");

        const hasError = errorDiv && errorDiv.textContent.trim() !== "";

        // Custom disposable email error check
        const isDisposableEmailError =
            input.id === "email" &&
            document.getElementById("email_error_message") &&
            document.getElementById("email_error_message").textContent.includes("Disposable Email");

        if (isDisposableEmailError) {
            label.style.top = "22px";
            label.style.fontSize = "14px";
            label.style.color = "red";
            input.style.borderColor = "red";
        } else if (input.value.trim() !== "") {
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
        let hasInteracted = false;

        updateFloatingLabel(input); // initial load

        input.addEventListener("focus", function () {
            const label = input.nextElementSibling;
            label.style.top = "-1%";
            label.style.fontSize = "14px";
            input.style.borderColor = "#ccc";

            if (!hasInteracted || input.value.trim() !== "") {
                label.style.color = "#70657b";
            } else if (errorDiv && errorDiv.textContent.trim() !== "") {
                label.style.color = "red";
                input.style.borderColor = "red";
            }

            hasInteracted = true;
        });

        input.addEventListener("blur", function () {
            hasInteracted = true;
            const value = input.value.trim();
            const labelText = input.labels?.[0]?.textContent || input.name.replace(/_/g, " ");

            if (!value) {
                errorDiv.textContent = `${labelText} is required!`;
                errorDiv.style.display = "block";
                input.style.borderColor = "red";
            } else if (input.type === "email" && !/^\S+@\S+\.\S+$/.test(value)) {
                errorDiv.textContent = "Please enter a valid email address!";
                errorDiv.style.display = "block";
                input.style.borderColor = "red";
            } else {
                errorDiv.textContent = "";
                errorDiv.style.display = "none";
                input.style.borderColor = "#ccc";
            }

            updateFloatingLabel(input);
        });

        input.addEventListener("input", function () {
            const value = input.value.trim();
            const labelText = input.labels?.[0]?.textContent || input.name.replace(/_/g, " ");

            if (hasInteracted) {
                if (!value) {
                    errorDiv.textContent = `${labelText} is required!`;
                    errorDiv.style.display = "block";
                    input.style.borderColor = "red";
                } else if (input.type === "email" && !/^\S+@\S+\.\S+$/.test(value)) {
                    errorDiv.textContent = "Please enter a valid email address!";
                    errorDiv.style.display = "block";
                    input.style.borderColor = "red";
                } else {
                    errorDiv.textContent = "";
                    errorDiv.style.display = "none";
                    input.style.borderColor = "#ccc";
                }
            }

            updateFloatingLabel(input);
        });
    });
});       
  $('#country').select2();
  $('#country_code').select2();
</script>
@endsection