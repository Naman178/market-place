
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
<script>
    $(document).ready(function() {
    $('#proceed_to_pay_btn').click(function(e) {
        e.preventDefault();
        toastr.warning('You need to log in first to proceed with payment.');
    });
});
</script>
<script>
    
    $(document).ready(function () {
        let quantity = 1;

        $("#increment").click(function () {
            quantity++;
            $("#quantity").text(quantity);
            $("#decrement").prop("disabled", quantity === 1);
        });

        $("#decrement").click(function () {
            if (quantity > 1) {
                quantity--;
                $("#quantity").text(quantity);
                $("#decrement").prop("disabled", quantity === 1);
            }
        });
        
    });

    function dynamicCalculation() {
        let subTotalRaw = $("#subtotal_amount").data('amount'); 

        if (typeof subTotalRaw === 'undefined' || subTotalRaw === null) {
            console.error("Subtotal amount is missing!");
            return;
        }

        let subTotal = parseInt(subTotalRaw); // Convert directly if it's numeric

        let quantity = parseInt($("#quantity").val()) || 1;

        
        if (!isNaN(quantity)) {
            setTimeout(function() {
                continueCalculation(quantity, subTotal);
            }, 1000)
            $("#items-count").text(quantity + " Items");
        } else {
            console.error("Quantity is undefined or invalid.");
        }
    }
    // function addQuantityOption() {
    //     const quantitySelect = document.getElementById("quantity");
    //     const currentOptions = quantitySelect.options.length; // Get the current number of options
    //     const newOptionValue = currentOptions + 1; // Calculate the new value for the next option

    //     // Create a new <option> element
    //     const newOption = document.createElement("option");
    //     newOption.value = newOptionValue;
    //     newOption.textContent = newOptionValue;

    //     // Add the new option to the <select> element
    //     quantitySelect.appendChild(newOption);
    // }
   

    const addToWishlistRoute = "{{ route('wishlist.add') }}";
    function saveForLater(planId) {
        // Fetch the CSRF token from the meta tag
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Send a POST request to the wishlist add route
        fetch(addToWishlistRoute, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                item_id: planId,
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to save for later.');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                toastr.success(data.message);
            } else {
                toastr.error(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            toastr.error(data.message);
        });
    }
    // function continueCalculation(quantity, subTotal) {
    //     let finalTotal = quantity * subTotal;
    //     let subTotalText = $("#subtotal_amount").text('INR ' + finalTotal);

    //     let gstPr = $('#gst_amount').data('pr');
    //     let gstAmount = (gstPr / 100) * finalTotal;
    //     finalTotal += gstAmount;

    //     let discount = $('#discount_coupon_type').val();
    //     let discountType = $('#discount_coupon_type').data('type');
    //     let discountAmount = 0;
    //     if (discountType === 'flat') {
    //         discountAmount = discount;
    //         finalTotal -= discount; 
    //     } else if (discountType === 'percentage') {
    //         discountAmount = (discount / 100) * finalTotal;
    //         finalTotal -= (discount / 100) * finalTotal;
    //     }

    //     let gst_text = $("#gst_amount").text('INR ' + gstAmount);
    //     let final_text = $("#final_total").text('INR ' + finalTotal);
    //     let finaltext = $(".final_total").text('INR ' + finalTotal);
    //     let discount_amount = $("#discount_amount").text('INR ' + discountAmount);
    //     let discount_value = $("#discount_value").val(discountAmount);
    //     let final_text_btn = $(".final_btn_text").text(finalTotal);
    //     let final_quantity = $("#final_quantity").val(quantity);
    //     let amount = $("#amount").val(finalTotal * 100 );
    // }
    function continueCalculation(quantity, subTotal) {
        let currency = $("#currency_code").val();

        let finalTotal = quantity * subTotal;
        $("#subtotal_amount").text(currency + ' ' + finalTotal);
        $('.finaltotals').text(currency + ' ' + finalTotal);

        let gstPr = $('#gst_amount').data('pr');
        let gstAmount = (gstPr / 100) * finalTotal;
        finalTotal += gstAmount;

        let discount = $('#discount_coupon_type').val();
        let discountType = $('#discount_coupon_type').data('type');
        let discountAmount = 0;

        if (discountType === 'flat') {
            discountAmount = discount;
            finalTotal -= discount; 
        } else if (discountType === 'percentage') {
            discountAmount = (discount / 100) * finalTotal;
            finalTotal -= (discount / 100) * finalTotal;
        }

        $("#gst_amount").text(currency + ' ' + gstAmount);
        $("#final_total").text(currency + ' ' + finalTotal);
        $(".final_total").text(currency + ' ' + finalTotal);
        $("#discount_amount").text(currency + ' ' + discountAmount);
        $("#discount_value").val(discountAmount);
        $(".final_btn_text").text(finalTotal);
        $("#final_quantity").val(quantity);
        $("#amount").val(finalTotal * 100);
    }

</script>