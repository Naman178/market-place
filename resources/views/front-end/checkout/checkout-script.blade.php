
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- Toastr JS (Toast notifications) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
        $('#country').select2();
        $('#country_code').select2();
       $(function() {  
           /* Stripe Payment Code */    
           var $form = $(".require-validation");     
           $('form.require-validation').bind('submit', function(e) {
               var $form = $(".require-validation"),
               inputSelector = ['input[type=email]', 'input[type=password]', 'input[type=text]', 'input[type=file]', 'textarea'].join(', '),
               $inputs = $form.find('.required').find(inputSelector),
               $errorMessage = $form.find('div.error'),
               valid = true;
               $errorMessage.addClass('hide');
               let name_on_card = $('#name_on_card').val();
               let card_number = $('#card_number').val();
               let card_cvc = $('#card_cvc').val();
               let card_exp_month = $('#card_exp_month').val();
               let card_exp_year = $('#card_exp_year').val();
           
               $('.has-error').removeClass('has-error');
               $inputs.each(function(i, el) {
               var $input = $(el);
               if ($input.val() === '') {
                   $input.parent().addClass('has-error');
                   $errorMessage.removeClass('hide');
                   e.preventDefault();
               }
               });            
               if (!$form.data('cc-on-file')) {               
                   e.preventDefault();
                   Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                   document.getElementById('country').addEventListener('change', function() {
                       let selectedOption = this.options[this.selectedIndex];
                       let countryCode = selectedOption.getAttribute('data-country-code');
                       // You can store the countryCode in a hidden input or use it directly in the Stripe API call
                       console.log('Selected country code:', countryCode);
                   });
           
                   // Create Stripe Token with address details
                   Stripe.card.createToken({
                       number: card_number,
                       cvc: card_cvc,
                       exp_month: card_exp_month,
                       exp_year: card_exp_year,
                       name: name_on_card, // Include the name on the card
                       address_line1: $('#address_line_one').val(), // Add address line 1
                       address_line2: $('#address_line_two').val(), // Add address line 2
                       address_city: $('#city').val(), // Add city
                       address_state: $('#state').val(), // Add state if you have it
                       address_zip: $('#postal').val(), // Add postal code
                       address_country: $('#country').find(':selected').data('country-code')
                   }, stripeResponseHandler);
               }
           });      
           /*  Stripe Response Handler */
           function stripeResponseHandler(status, response) {
               $("#preloader").show();
               if (response.error) {
                   $('#stripe_payment_error').text(response.error.message);
                   $("#preloader").hide();
               } else {       
                   $("#preloader").show();    
                   $('#stripe_payment_error').text('');
                   var token = response['id'];
                   $form.find('input[type=text]').empty();
                   $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                   $form.get(0).submit();
               }
           }
       });
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

   </script>
   {{-- <script>
       $(document).ready(function() {
           $('#proceed_to_pay_btn').click(function(e) {
               e.preventDefault();
       
               let name_on_card = $('#name_on_card').val();
               let card_number = $('#card_number').val();
               let card_cvc = $('#card_cvc').val();
               let card_exp_month = $('#card_exp_month').val();
               let card_exp_year = $('#card_exp_year').val();
               
               // Set Stripe Publishable Key
               let publishableKey = $('.require-validation').data('stripe-publishable-key');
               if (!publishableKey) {
                   console.error('Stripe publishable key is missing!');
                   $('#stripe_payment_error').text('Payment could not be processed. Please try again.');
                   return;
               }
       
               Stripe.setPublishableKey(publishableKey);
       
               // Validate inputs
               if (!card_number || !card_cvc || !card_exp_month || !card_exp_year) {
                   $('#stripe_payment_error').text('Please fill in all the card details.');
                   return;
               }
               document.getElementById('country').addEventListener('change', function() {
                   let selectedOption = this.options[this.selectedIndex];
                   let countryCode = selectedOption.getAttribute('data-country-code');
                   // You can store the countryCode in a hidden input or use it directly in the Stripe API call
                   console.log('Selected country code:', countryCode);
               });
       
               // Create Stripe Token with address details
               Stripe.card.createToken({
                   number: card_number,
                   cvc: card_cvc,
                   exp_month: card_exp_month,
                   exp_year: card_exp_year,
                   name: name_on_card, // Include the name on the card
                   address_line1: $('#address_line_one').val(), // Add address line 1
                   address_line2: $('#address_line_two').val(), // Add address line 2
                   address_city: $('#city').val(), // Add city
                   address_state: $('#state').val(), // Add state if you have it
                   address_zip: $('#postal').val(), // Add postal code
                   address_country: $('#country').find(':selected').data('country-code')
               }, stripeResponseHandlernew);
           });
       });
   
       function stripeResponseHandlernew(status, response) {
           var $form = $(".require-validation");
           if (response.error) {
               $('#stripe_payment_error').text(response.error.message);
               console.error(response.error.message);
           } else {
               $('#stripe_payment_error').text('');
               var token = response['id'];
               console.log('Token created: ', token);
   
               $form.find('input[type=text]').empty();
               $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
   
               // After creating the card token, submit the form via AJAX
               $('#preloader').show();
   
               let formData = {
                   "_token": "{{ csrf_token() }}",
                   firstname: $('#firstname').val(),
                   lastname: $('#lastname').val(),
                   email: $('#email').val(),
                   country_code: $('#country_code').val(),
                   contact: $('#contact').val(),
                   company_name: $('#company_name').val(),
                   company_website: $('#company_website').val(),
                   country: $('#country').val(),
                   address_line_one: $('#address_line_one').val(),
                   address_line_two: $('#address_line_two').val(),
                   city: $('#city').val(),
                   postal: $('#postal').val(),
                   gst: $('#gst').val(),
                   amount: $("#amount").val(),
                   stripeToken: token
               };
   
               $.ajax({
                   url: "{{ route('stripe-payment-store') }}",
                   type: "POST",
                   data: formData,
                   dataType: 'json',
                   success: function(response) {
                       $('#preloader').hide();
                       console.log('Checkout:', response.success);
                       if (response.success) {
                        //    window.location.href = '{{ route("thankyou") }}';
                       } else if (response.error) {
                           console.error('Checkout error:', response.error);
                           handleErrorMessages(response.error);
                       }
                   },
                   error: function(xhr, status, error) {
                       $('#preloader').hide();
                       console.error('AJAX error:', status, error);
                       $('#stripe_payment_error').text('An error occurred during payment. Please try again.');
                   }
               });
           }
       }
   
       function handleErrorMessages(errors) {
           $('#firstname_error').text(errors.firstname ? errors.firstname : '');
           $('#lastname_error').text(errors.lastname ? errors.lastname : '');
           $('#email_error').text(errors.email ? errors.email : '');
           $('#contact_error').text(errors.contact ? errors.contact : '');
           $('#company_name_error').text(errors.company_name ? errors.company_name : '');
           $('#company_website_error').text(errors.company_website ? errors.company_website : '');
           $('#city_error').text(errors.city ? errors.city : '');
           $('#postal_error').text(errors.postal ? errors.postal : '');
           $('#address_line_one_error').text(errors.address_line_one ? errors.address_line_one : '');
       }
   

</script> --}}
