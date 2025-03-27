@extends('front-end.common.master')
@php
    use App\Models\SEO;
    $seoData = SEO::where('page','contact us')->first();
@endphp
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
    <link rel="stylesheet" href="{{ asset('front-end/css/register.css') }}">
    <style>
        #message {
            height: 200px;
        }
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
        .footer-04 .form-control {
             padding: 14px 15px !important;
         }
    </style>
@endsection
@section('content')
    <div class="contact-us cust-page-padding">
        <div class="container  register-container">
            <div class="title">
                <h3><span class="txt-black">Contact  </span><span class="color-blue underline-text"> Us</span></h3>
            </div>            
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-8 col-md-12 col-sm-12 col-12">
                    <div class="card p-4 dark-blue-card mb-5">
                        {{-- <h1 class="mb-3 text-8 text-center text-white">Contact Us</h1> --}}
                        <form method="POST">                          
                            <div class="row">                               
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <input type="text" name="full_name" id="full_name" class="form-control" placeholder="">
                                    <label for="full_name" class="floating-label">Full Name</label>
                                    <div class="error" style="color:red;" id="full_name_error"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <input type="email" name="email" id="email" class="form-control" placeholder="">
                                    <label for="email" class="floating-label">Email</label>
                                    <div class="error" style="color:red;" id="email_error"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <input type="contact_number" name="contact_number" id="contact_number" class="form-control" placeholder="">
                                    <label for="contact_number" class="floating-label">Contact Number</label>
                                    <div class="error" style="color:red;" id="contact_number_error"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <input type="website_url" name="website_url" id="website_url" class="form-control" placeholder="">
                                    <label for="website_url" class="floating-label">Website URL</label>
                                    <div class="error" style="color:red;" id="website_url_error"></div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                    <textarea name="message" class="form-control" id="message" cols="30" rows="10"></textarea>
                                    <label for="message" class="floating-label">Message</label>
                                    <div class="error" style="color:red;" id="message_error"></div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                    <select name="stack" class="select2 form-control" id="stack">
                                        <option value="">What Tech Stack Is Your Website Built On ?</option>
                                        <option value="shopify">Shopify</option>
                                        <option value="woocommerce" selected>WooCommerce</option>
                                        <option value="magento">Magento</option>
                                        <option value="opencart">Opencart</option>
                                        <option value="other">Other</option>
                                        <option value="none">None - We Have Built Our Own Custom Website</option>
                                        <option value="not_sure">I am Not Sure</option>
                                    </select>
                                    <div class="error" style="color:red;" id="stack_error"></div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button type="button" class="blue_common_btn btn-block pink-btn mt-3 send-inquiry" id="submitBtn" >
                                        <svg viewBox="0 0 100 100" preserveAspectRatio="none">
                                            <polyline points="99,1 99,99 1,99 1,1 99,1" class="bg-line"></polyline>
                                            <polyline points="99,1 99,99 1,99 1,1 99,1" class="hl-line"></polyline>
                                        </svg>
                                        <span>Send Inquiry</span>
                                    </button>
                                    {{-- <button type="button" class="btn btn-block send-inquiry pink-btn mt-3" style="cursor: pointer;">Send Inquiry</button>                                     --}}
                                </div>
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
         $('.send-inquiry').click(function(e) {
            e.preventDefault();
            $('#preloader').show();
            let full_name = $('#full_name').val();
            let email = $('#email').val();
            let contact_number = $('#contact_number').val();
            let website_url = $('#website_url').val();
            let message = $('#message').val();
            let stack = $('#stack').val();
            $.ajax({
                url: "{{ route('contactUs-send') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    full_name: full_name,
                    email: email,
                    contact_number: contact_number,
                    website_url: website_url,
                    message: message,
                    stack: stack,
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.success);
                        location.reload();
                    } else if (response.error) {
                        // Show individual validation errors
                        $.each(response.error, function(key, value) {
                            toastr.error(value);
                        });
                    }
                }
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
        $('#stack').select2();
    </script>
@endsection