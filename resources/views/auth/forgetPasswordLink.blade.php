@extends('front-end.common.master')
@section('title')
 Market Place | {{ $seoData->title ?? 'Reset Password' }}
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
                                
                                <input type="email" id="email_address" class="form-control" name="email" placeholder="">
                                <label for="email_address" class="floating-label">E-Mail Address</label>
                                @if ($errors->has('email'))
                                    <span class="error">{{ $errors->first('email') }}</span>
                                @endif
                                <div class="error" id="email_address_error"></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">  
                                
                                <input type="password" id="password" class="form-control" name="password"  placeholder="">
                                <label for="password" class="floating-label">Password</label>
                                <button type="button" class="toggle-button" data-toggle="password-field-3" aria-label="Toggle Password Visibility">
                                    <!-- Eye icon SVG -->
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="eye-icon" viewBox="0 0 24 24">
                                        <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                                        <path fill-rule="evenodd"
                                            d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                                @if ($errors->has('password'))
                                    <span class="error">{{ $errors->first('password') }}</span>
                                @endif
                                <div class="error" id="password_error"></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">  
                                
                                <input type="password" id="password-confirm" class="form-control" name="password_confirmation"  placeholder="">
                                <label for="password-confirm" class="floating-label">Confirm Password</label>
                                <button type="button" class="toggle-button" data-toggle="password-field-4" aria-label="Toggle Password Visibility">
                                    <!-- Eye icon SVG -->
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="eye-icon" viewBox="0 0 24 24">
                                        <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                                        <path fill-rule="evenodd"
                                            d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
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
        const form = document.querySelector("form[action='{{ route('reset-password-post') }}']");
        const inputFields = document.querySelectorAll(".form-control");

        // Helper to get label text or fallback to input name
        function getLabelText(input) {
            return (input.labels && input.labels.length > 0) ? input.labels[0].textContent : input.name.replace(/_/g, " ");
        }

        // Validation function for one input, returns true if valid, false if invalid
        function validateInput(input) {
            const errorDiv = document.getElementById(input.id + "_error");
            const value = input.value.trim();
            const labelText = getLabelText(input);
            let valid = true;

            if (!value) {
            errorDiv.textContent = `${labelText} is required!`;
            valid = false;
            } else if (input.type === "email" && !/^\S+@\S+\.\S+$/.test(value)) {
            errorDiv.textContent = "Please enter a valid email address!";
            valid = false;
            } else if (input.id === "password-confirm") {
            // Confirm password check
            const password = document.getElementById("password").value.trim();
            if (value !== password) {
                errorDiv.textContent = "Passwords do not match!";
                valid = false;
            } else {
                errorDiv.textContent = "";
            }
            } else {
            errorDiv.textContent = "";
            }

            if (!valid) {
            errorDiv.style.display = "block";
            input.style.borderColor = "red";
            } else {
            errorDiv.style.display = "none";
            input.style.borderColor = "#ccc";
            }

            updateFloatingLabel(input);
            return valid;
        }

        // Floating label update as you had it
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
        }

        // Existing event listeners on inputs (blur, input, focus)
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
        });

        // Submit event handler - validate all and prevent submission if invalid
        form.addEventListener("submit", function (e) {
            let formIsValid = true;
            inputFields.forEach(input => {
            if (!validateInput(input)) {
                formIsValid = false;
            }
            });
            if (!formIsValid) {
            e.preventDefault(); // Prevent form submission
            }
        });

        // Initialize floating labels on load
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