@extends('front-end.common.master')
@section('title')
    <title>Market Place | Contact Us</title>
    <style>
        #message{
            height:200px;
        }
    </style>
@endsection
@section('content')
    <div class="contact-us cust-page-padding">
        <div class="container">            
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-8 col-md-12 col-sm-12 col-12">
                    <div class="card p-4 dark-blue-card mb-5">
                        <h1 class="mb-3 text-8 text-center text-white">Contact Us</h1>
                        <form method="POST">                          
                            <div class="row">                               
                                <div class="col-md-6 form-group"">
                                    <label for="full_name">Full Name</label>
                                    <input type="text" name="full_name" id="full_name" class="form-control" placeholder="Enter Full Name">
                                    <div class="error" style="color:red;" id="full_name_error"></div>
                                </div>
                                <div class="col-md-6 form-group"">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="Enter Your Email">
                                    <div class="error" style="color:red;" id="email_error"></div>
                                </div>
                                <div class="col-md-6 form-group"">
                                    <label for="contact_number">Contact Number</label>
                                    <input type="contact_number" name="contact_number" id="contact_number" class="form-control" placeholder="Enter Contact Number">
                                    <div class="error" style="color:red;" id="contact_number_error"></div>
                                </div>
                                <div class="col-md-6 form-group"">
                                    <label for="website_url">Website URL</label>
                                    <input type="website_url" name="website_url" id="website_url" class="form-control" placeholder="Enter Website URL">
                                    <div class="error" style="color:red;" id="website_url_error"></div>
                                </div>
                                <div class="col-md-12 form-group"">
                                    <label for="message">Message</label>
                                    <textarea name="message" class="form-control" id="message" cols="30" rows="10"></textarea>
                                </div>
                                <div class="col-md-12 form-group"">
                                    <label for="stack">What Tech Stack Is Your Website Built On ?</label>
                                    <select name="stack" class="select2 form-control" id="stack">
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
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-block send-inquiry pink-btn mt-3">Send Inquiry</button>                                    
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
                        location.reload();
                        let user = response.user;
                    } else if (response.error) {
                        $("#preloader").hide();
                        response.error['full_name'] ? $('#full_name_error').text(response.error['full_name']) : $('#full_name_error').text('');
                        response.error['email'] ? $('#email_error').text(response.error['email']) : $('#email_error').text('');
                        response.error['contact_number'] ? $('#contact_number_error').text(response.error['contact_number']) : $('#contact_number_error').text('');                                 
                    }
                }
            });            
        });
    </script>
@endsection