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
                                        <option value="" selected>What Tech Stack Is Your Website Built On ?</option>
                                        <option value="shopify">Shopify</option>
                                        <option value="woocommerce">WooCommerce</option>
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
        //  $('.send-inquiry').click(function(e) {
        //     e.preventDefault();
        //     $('#preloader').show();
        //     let full_name = $('#full_name').val();
        //     let email = $('#email').val();
        //     let contact_number = $('#contact_number').val();
        //     let website_url = $('#website_url').val();
        //     let message = $('#message').val();
        //     let stack = $('#stack').val();
        //     $.ajax({
        //         url: "{{ route('contactUs-send') }}",
        //         type: "POST",
        //         data: {
        //             "_token": "{{ csrf_token() }}",
        //             full_name: full_name,
        //             email: email,
        //             contact_number: contact_number,
        //             website_url: website_url,
        //             message: message,
        //             stack: stack,
        //         },
        //         dataType: 'json',
        //         success: function(response) {
        //             if (response.success) {
        //                 toastr.success(response.success);
        //                 location.reload();
        //             } else if (response.error) {
        //                 // Show individual validation errors
        //                 $.each(response.error, function(key, value) {
        //                     toastr.error(value);
        //                 });
        //             }
        //         }
        //     });            
        // });
        // document.addEventListener("DOMContentLoaded", function () {
        //     const inputFields = document.querySelectorAll(".form-control");

        //     function updateFloatingLabel(input) {
        //         const label = input.nextElementSibling;
        //         const errorDiv = document.getElementById(input.id + "_error");

        //         if (input.value.trim() !== "") {
        //             label.style.top = "-1%";
        //             label.style.fontSize = "0.8rem";
        //             label.style.color = "#70657b";
        //             input.style.borderColor = "#ccc";
        //         } else if (errorDiv && errorDiv.textContent.trim() !== "") {
        //             label.style.top = input.id === "message" ? "45%" : "35%";
        //             label.style.fontSize = "1rem";
        //             label.style.color = "red";
        //             input.style.borderColor = "red";
        //         } else {
        //             label.style.top = "50%";
        //             label.style.fontSize = "1rem";
        //             label.style.color = "#70657b";
        //             input.style.borderColor = "#ccc";
        //         }
        //     }

        //     inputFields.forEach(input => {
        //         const errorDiv = document.getElementById(input.id + "_error");

        //         updateFloatingLabel(input);

        //         input.addEventListener("blur", function () {
        //             const value = input.value.trim();
        //             if (!value) {
        //                 errorDiv.textContent = input.name.replace("_", " ") + " is required!";
        //                 errorDiv.style.display = "block";
        //                 input.style.borderColor = "red";
        //             } else if (input.type === "email" && !/^\S+@\S+\.\S+$/.test(value)) {
        //                 errorDiv.textContent = "Please enter a valid email address!";
        //                 errorDiv.style.display = "block";
        //                 input.style.borderColor = "red";
        //             } else {
        //                 errorDiv.textContent = "";
        //                 errorDiv.style.display = "none";
        //                 input.style.borderColor = "#ccc";
        //             }
        //             updateFloatingLabel(input);
        //         });

        //         input.addEventListener("input", function () {
        //             const value = input.value.trim();

        //             if (input.id === "full_name") {
        //                 this.value = this.value.replace(/[^a-zA-Z\s]/g, "");
        //                 if (!/^[a-zA-Z\s]+$/.test(this.value)) {
        //                     errorDiv.textContent = "Only letters and spaces are allowed!";
        //                     errorDiv.style.display = "block";
        //                     input.style.borderColor = "red";
        //                 } else {
        //                     errorDiv.textContent = "";
        //                     errorDiv.style.display = "none";
        //                     input.style.borderColor = "#ccc";
        //                 }
        //             }
        //             if(input.id === "email") {
        //                 if (!/^\S+@\S+\.\S+$/.test(this.value)) {
        //                     errorDiv.textContent = "Please enter a valid email address!";
        //                     errorDiv.style.display = "block";
        //                     input.style.borderColor = "red";
        //                 } else {
        //                     errorDiv.textContent = "";
        //                     errorDiv.style.display = "none";
        //                     input.style.borderColor = "#ccc";
        //                 }
        //             }

        //             if (input.id === "contact_number") {
        //                 this.value = this.value.replace(/[^0-9]/g, "");
        //                 if (this.value.length > 10) {
        //                     this.value = this.value.slice(0, 10); // Limits to only 10 digits
        //                 }
        //                 if (!/^\d{10}$/.test(this.value)) {
        //                     errorDiv.textContent = "Contact number must be exactly 10 digits!";
        //                     errorDiv.style.display = "block";
        //                     input.style.borderColor = "red";
        //                 } else {
        //                     errorDiv.textContent = "";
        //                     errorDiv.style.display = "none";
        //                     input.style.borderColor = "#ccc";
        //                 }
        //             }
        //             if (input.id === "website_url") {
        //                 const urlPattern = /^(https?:\/\/)?([a-zA-Z0-9.-]+)\.([a-z.]{2,6})(\/[^\s]*)?$/;
        //                 if (!urlPattern.test(this.value)) {
        //                     errorDiv.textContent = "Please enter a valid URL!";
        //                     errorDiv.style.display = "block";
        //                     input.style.borderColor = "red";
        //                 } else {
        //                     errorDiv.textContent = "";
        //                     errorDiv.style.display = "none";
        //                     input.style.borderColor = "#ccc";
        //                 }
        //             }

        //             updateFloatingLabel(input);
        //         });

        //         input.addEventListener("focus", function () {
        //             const label = input.nextElementSibling;
        //             label.style.top = "-1%";
        //             label.style.fontSize = "0.8rem";
        //             input.style.borderColor = "#ccc";

        //             if (errorDiv && errorDiv.textContent.trim() !== "") {
        //                 label.style.color = "red";
        //                 input.style.borderColor = "red";
        //             }
        //         });
        //     });
        // });
        // $('#stack').select2();
        $(document).ready(function () {
            // Function to update floating label style
            function updateFloatingLabel(input) {
                if (!input) return;
                const label = document.querySelector(`label[for="${input.id}"]`);
                const errorDiv = document.getElementById(input.id + "_error");
                if (!label) return;

                if (input.value.trim() !== "") {
                // Input has value
                label.style.top = "-1%";
                label.style.fontSize = "0.8rem";
                label.style.color = errorDiv && errorDiv.textContent.trim() !== "" ? "red" : "#70657b";
                input.style.borderColor = errorDiv && errorDiv.textContent.trim() !== "" ? "red" : "#ccc";
                } else {
                // Input empty
                label.style.top = errorDiv && errorDiv.textContent.trim() !== "" ? (input.id === "message" ? "45%" : "35%") : "50%";
                label.style.fontSize = errorDiv && errorDiv.textContent.trim() !== "" ? "1rem" : "1rem";
                label.style.color = errorDiv && errorDiv.textContent.trim() !== "" ? "red" : "#70657b";
                input.style.borderColor = errorDiv && errorDiv.textContent.trim() !== "" ? "red" : "#ccc";
                }
            }
            $('#stack').on('change', function () {
                const value = $(this).val();

                if (value && value.length > 0) {
                $('#stack_error').text('').hide();
                $(this).next('.select2-container').find('.select2-selection').css('border-color', '#ccc');
                }
            });

            // Validation functions per input
            function validateInput(input) {
               if (!input) { // only check if input exists
                    return false;
                }
                const value = (input.value || "").trim();
                const errorDiv = document.getElementById(input.id + "_error");
                let errorMessage = "";

                switch (input.id) {
                    case "full_name":
                        if (!value) errorMessage = "Full name is required!";
                        else if (!/^[a-zA-Z\s]+$/.test(value)) errorMessage = "Only letters and spaces are allowed!";
                        break;

                    case "email":
                        if (!value) errorMessage = "Email is required!";
                        else if (!/^\S+@\S+\.\S+$/.test(value)) errorMessage = "Please enter a valid email address!";
                        break;

                    case "contact_number":
                        if (!value) errorMessage = "Contact number is required!";
                        else if (!/^\d{10}$/.test(value)) errorMessage = "Contact number must be exactly 10 digits!";
                        break;

                    case "website_url":
                        if (!value) errorMessage = "Website URL is required!";
                        else {
                            const urlPattern = /^(https?:\/\/)?([a-zA-Z0-9.-]+)\.([a-z.]{2,6})(\/[^\s]*)?$/;
                            if (!urlPattern.test(value)) errorMessage = "Please enter a valid URL!";
                        }
                        break;

                    case "message":
                        if (!value) errorMessage = "Message is required!";
                        break;

                    case "stack":
                        if (!value) errorMessage = "Please select your tech stack!";
                        break;
                }

                if (errorDiv) {
                    if (errorMessage) {
                        errorDiv.textContent = errorMessage;
                        errorDiv.style.display = "block";
                        input.style.borderColor = "red";
                    } else {
                        errorDiv.textContent = "";
                        errorDiv.style.display = "none";
                        input.style.borderColor = "#ccc";
                    }
                } else {
                    if (errorMessage) {
                        input.style.borderColor = "red";
                    } else {
                        input.style.borderColor = "#ccc";
                    }
                }

                updateFloatingLabel(input);
                return errorMessage === "";
            }


            // Attach events to inputs for live validation and floating label update
            $(".form-control").each(function () {
                const input = this;
                const errorDiv = document.getElementById(input.id + "_error");

                // Clean input values on typing (specific for certain fields)
                input.addEventListener("input", function () {
                if (input.id === "full_name") {
                    this.value = this.value.replace(/[^a-zA-Z\s]/g, "");
                }
                if (input.id === "contact_number") {
                    this.value = this.value.replace(/[^0-9]/g, "");
                    if (this.value.length > 10) this.value = this.value.slice(0, 10);
                }
                validateInput(input);
                });

                input.addEventListener("blur", function () {
                validateInput(input);
                });

                input.addEventListener("focus", function () {
                const label = document.querySelector(`label[for="${input.id}"]`);
                if (!label) return;
                label.style.top = "-1%";
                label.style.fontSize = "0.8rem";

                if (errorDiv && errorDiv.textContent.trim() !== "") {
                    label.style.color = "red";
                    input.style.borderColor = "red";
                } else {
                    label.style.color = "#70657b";
                    input.style.borderColor = "#ccc";
                }
                });
                

                // Initial update for floating label on page load
                updateFloatingLabel(input);
            });

            // Initialize select2
            $('#stack').select2();

            // Handle submit button click
            $(".send-inquiry").click(function (e) {
                e.preventDefault();
                let isValid = true;

                // Clear previous errors
                $(".error").text("").hide();
                $(".form-control").css("border-color", "#ccc");

                // Validate all inputs on submit
                $(".form-control").each(function () {
                if (!validateInput(this)) isValid = false;
                });

                // Also validate select2 (stack)
                const stackVal = $("#stack").val();
                if (!stackVal) {
                $("#stack_error").text("Please select your tech stack!").css("display", "block");
                $("#stack").next('.select2-container').find('.select2-selection').css("border-color", "red");
                isValid = false;
                } else {
                $("#stack_error").text("").hide();
                $("#stack").next('.select2-container').find('.select2-selection').css("border-color", "#ccc");
                }

                if (!isValid) return;

                // Show preloader
                $("#preloader").show();

                // Gather data
                const formData = {
                "_token": "{{ csrf_token() }}",
                full_name: $("#full_name").val().trim(),
                email: $("#email").val().trim(),
                contact_number: $("#contact_number").val().trim(),
                website_url: $("#website_url").val().trim(),
                message: $("#message").val().trim(),
                stack: stackVal,
                };

                // Ajax POST request
                $.ajax({
                url: "{{ route('contactUs-send') }}",
                type: "POST",
                data: formData,
                dataType: 'json',
                success: function (response) {
                    $("#preloader").hide();
                    if (response.success) {
                    toastr.success(response.success);
                    $("#contactForm")[0].reset();

                    // Reset floating labels after reset
                    $(".form-control").each(function () {
                        updateFloatingLabel(this);
                    });
                    $("#stack").val(null).trigger('change'); // Reset select2

                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                    } else if (response.error) {
                    $.each(response.error, function (key, value) {
                        toastr.error(value);
                    });
                    }
                },
                error: function () {
                    $("#preloader").hide();
                    toastr.error("Something went wrong. Please try again later.");
                }
                });
            });
        });

    </script>
@endsection