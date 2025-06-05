@extends('front-end.common.master')
@php
    use App\Models\SEO;
    $seoData = SEO::where('page','contact us')->first();
    $site = \App\Models\Settings::where('key', 'site_setting')->first();
    
    $logoImage = $site['value']['logo_image'] ?? null;
    $ogImage = $logoImage 
        ? asset('storage/Logo_Settings/' . $logoImage) 
        : asset('front-end/images/infiniylogo.png');
@endphp
 @section('title')
    {{ $seoData->title ?? 'Contact Us' }}
@endsection

@section('meta')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- SEO Meta --}}
    <meta name="description" content="{{ $seoData->description ?? 'Contact Market Place for expert assistance, pricing automation inquiries, or integration support. Reach out today to enhance your eCommerce experience.' }}">
    <meta name="keywords" content="{{ $seoData->keywords ?? 'contact, support, help, pricing, integration' }}">

    {{-- Open Graph Meta --}}
    <meta property="og:title" content="{{ $seoData->title ?? 'Contact Us' }}">
    <meta property="og:description" content="{{ $seoData->description ?? 'Contact Market Place for expert assistance and support.' }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">

    {{-- Twitter Meta --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seoData->title ?? 'Contact Us' }}">
    <meta name="twitter:description" content="{{ $seoData->description ?? 'Contact Market Place for expert assistance and support.' }}">
    <meta name="twitter:image" content="{{ $ogImage }}">
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
         .contact-us .container{
            width: 100% !important;
            max-width: 100% !important;
         }
         .underline::after{
            bottom: -45px !important;
        }
    </style>
@endsection
@section('content')
    <div class="contact-us pt-5 pb-5 cust-page-padding">
        <div class="container  register-container">
            <div class="title">
                <h3><span class="txt-black">Contact  </span><span class="color-blue underline"> Us</span></h3>
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
$(document).ready(function () {
    // Initialize select2
    $('#stack').select2();

    const inputFields = $(".form-control").not('#stack'); // exclude select2 input for validation here
    const form = $("#contactForm");
    const submitBtn = $("#submitBtn");

    function updateFloatingLabel(input) {
        const label = $(input).next('label');
        const errorDiv = $("#" + input.id + "_error");

        if ($(input).val().trim() !== "") {
            label.css({ top: "-1%", fontSize: "0.8rem", color: "#70657b" });
            $(input).css("border-color", "#ccc");
        } else if (errorDiv.text().trim() !== "") {
            label.css({ top: input.id === "message" ? "45%" : "35%", fontSize: "1rem", color: "red" });
            $(input).css("border-color", "red");
        } else {
            label.css({ top: "50%", fontSize: "1rem", color: "#70657b" });
            $(input).css("border-color", "#ccc");
        }
    }

    function validateInput(input) {
        const errorDiv = $("#" + input.id + "_error");
        const value = $(input).val().trim();

        if (!value) {
            errorDiv.text(input.name.replace("_", " ") + " is required!").show();
            $(input).css("border-color", "red");
            updateFloatingLabel(input);
            return false;
        }

        if (input.type === "email" && !/^\S+@\S+\.\S+$/.test(value)) {
            errorDiv.text("Please enter a valid email address!").show();
            $(input).css("border-color", "red");
            updateFloatingLabel(input);
            return false;
        }

        if (input.id === "full_name" && !/^[a-zA-Z\s]+$/.test(value)) {
            errorDiv.text("Only letters and spaces are allowed!").show();
            $(input).css("border-color", "red");
            updateFloatingLabel(input);
            return false;
        }

        if (input.id === "contact_number" && !/^\d{10}$/.test(value)) {
            errorDiv.text("Contact number must be exactly 10 digits!").show();
            $(input).css("border-color", "red");
            updateFloatingLabel(input);
            return false;
        }

        if (input.id === "website_url") {
            const urlPattern = /^(https?:\/\/)?([a-zA-Z0-9.-]+)\.([a-z.]{2,6})(\/[^\s]*)?$/;
            if (!urlPattern.test(value)) {
                errorDiv.text("Please enter a valid URL!").show();
                $(input).css("border-color", "red");
                updateFloatingLabel(input);
                return false;
            }
        }

        errorDiv.text("").hide();
        $(input).css("border-color", "#ccc");
        updateFloatingLabel(input);
        return true;
    }

    // Attach event listeners to inputs
    inputFields.each(function () {
        updateFloatingLabel(this);

        $(this).on("blur input", () => validateInput(this));

        $(this).on("focus", () => {
            const label = $(this).next('label');
            const errorDiv = $("#" + this.id + "_error");

            label.css({ top: "-1%", fontSize: "0.8rem", color: "#70657b" });
            $(this).css("border-color", "#ccc");

            if (errorDiv.text().trim() !== "") {
                label.css("color", "red");
                $(this).css("border-color", "red");
            }
        });
    });

    // Validate select2 dropdown
    function validateStack() {
        const stackSelect = $('#stack');
        const stackError = $('#stack_error');

        if (!stackSelect.val()) {
            stackError.text("Please select your tech stack!").show();
            stackSelect.next('.select2-container').find('.select2-selection').css('border-color', 'red');
            return false;
        } else {
            stackError.text("").hide();
            stackSelect.next('.select2-container').find('.select2-selection').css('border-color', '#ccc');
            return true;
        }
    }

    $('#stack').on('change', validateStack);

    submitBtn.on("click", function (e) {
        e.preventDefault();

        let formIsValid = true;

        // Validate all inputs
        inputFields.each(function () {
            if (!validateInput(this)) formIsValid = false;
        });

        // Validate stack
        if (!validateStack()) formIsValid = false;

        if (!formIsValid) {
            // Scroll to first error message visible
            let firstError = $(".error:visible").first();
            if (firstError.length) {
                firstError[0].scrollIntoView({ behavior: "smooth", block: "center" });
            }
            return;
        }

        // If valid, send AJAX
        sendAjaxRequest();
    });

    function sendAjaxRequest() {
        $('#preloader').show();

        $.ajax({
            url: "{{ route('contactUs-send') }}",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                full_name: $('#full_name').val(),
                email: $('#email').val(),
                contact_number: $('#contact_number').val(),
                website_url: $('#website_url').val(),
                message: $('#message').val(),
                stack: $('#stack').val(),
            },
            dataType: 'json',
            success: function (response) {
                $('#preloader').hide();
                if (response.success) {
                    toastr.success(response.success);
                    setTimeout(() => location.reload(), 1500);
                } else if (response.error) {
                    $.each(response.error, function (key, value) {
                        toastr.error(value);
                    });
                }
            },
            error: function () {
                $('#preloader').hide();
                toastr.error("An error occurred. Please try again.");
            }
        });
    }
});
    </script>
@endsection