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
    </style>
@endsection
@section('content')

<div class="forgot_password cust-page-padding">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-8 col-md-12 col-sm-12 col-12">
                <div class="card p-4 dark-blue-card">                    
                    <h1 class="mb-3 text-8 text-center text-white">Reset Password</h1>                    
                    <div class="card-body">
                        <form action="{{ route('reset-password-post') }}" method="POST">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="col-md-12">
                                <div class="form-group">  
                                
                                <input type="text" id="email_address" class="form-control" name="email" required placeholder="">
                                <label for="email_address" class="floating-label">E-Mail Address</label>
                                @if ($errors->has('email'))
                                    <span class="error">{{ $errors->first('email') }}</span>
                                @endif
                                <div class="error" id="email_address_error"></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">  
                                
                                <input type="password" id="password" class="form-control" name="password" required  placeholder="">
                                <label for="password" class="floating-label">Password</label>
                                @if ($errors->has('password'))
                                    <span class="error">{{ $errors->first('password') }}</span>
                                @endif
                                <div class="error" id="password_error"></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">  
                                
                                <input type="password" id="password-confirm" class="form-control" name="password_confirmation" required  placeholder="">
                                <label for="password-confirm" class="floating-label">Confirm Password</label>
                                @if ($errors->has('password_confirmation'))
                                    <span class="error">{{ $errors->first('password_confirmation') }}</span>
                                @endif
                                <div class="error" id="password-confirm_error"></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="blue_common_btn btn btn-block pink-btn" id="login-btn">
                                    <svg viewBox="0 0 100 100" preserveAspectRatio="none">
                                        <polyline points="99,1 99,99 1,99 1,1 99,1" class="bg-line"></polyline>
                                        <polyline points="99,1 99,99 1,99 1,1 99,1" class="hl-line"></polyline>
                                    </svg>
                                    <span class="ml-3">Reset Password</span>
                                </button>
                                {{-- <button type="submit" class="btn btn-block pink-btn mt-3" id="login-btn">Reset Password</button> --}}
                            </div>
                        </form>
                        
                    </div>
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