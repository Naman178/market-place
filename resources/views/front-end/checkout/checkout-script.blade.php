
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- Toastr JS (Toast notifications) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>
<script>
        // $('#country').select2();
        // $('#country_code').select2();
       $(function() {  
           /* Stripe Payment Code */    
           var $form = $(".require-validation");     
           $('form.require-validation').bind('submit', function(e) {
            console.log('form submitted');
            
               var $form = $(".require-validation"),
               inputSelector = ['input[type=email]', 'input[type=password]', 'input[type=text]', 'input[type=file]', 'textarea'].join(', '),
               $inputs = $form.find('.required').find(inputSelector),
               $errorMessage = $form.find('div.error'),
               valid = true;
            //    $errorMessage.addClass('hide');
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
                // if (!validateExpiration(card_exp_month, card_exp_year)) {
                //     valid = false;
                // }
                if (!validateCardNumber()) valid = false;
                if (!validateExpiration()) valid = false;
                if (!validateCVC()) valid = false;
                if (!valid) {
                    e.preventDefault();
                    return;
                }
               if (!$form.data('cc-on-file')) {
                   e.preventDefault();
                   Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                   // Create Stripe Token with address details
                   Stripe.card.createToken({
                       number: card_number,
                       cvc: card_cvc,
                       exp_month: card_exp_month,
                       exp_year: card_exp_year,
                       name: name_on_card,
                   }, stripeResponseHandler);
               }
           });      
           /*  Stripe Response Handler */
           function stripeResponseHandler(status, response) {
               $("#preloader").show();
               if (response.error) {
                   $('#stripe_payment_error').text(response.error.message || 'Stripe token generation failed. Please check your card details.');
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

        function updateFloatingLabel(input) {
            const label = input.nextElementSibling;
            const errorDiv = document.getElementById(input.id + "_error");
            const hasError = errorDiv && errorDiv.textContent.trim() !== "";

            if (input.value.trim() !== "") {
                label.style.top = "-1%";
                label.style.fontSize = "14px";
                label.style.color = "#70657b";
            } else if (hasError) {
                label.style.top = "35%";
                label.style.fontSize = "14px";
                label.style.color = "red";
            } else {
                label.style.fontSize = "14px";
                label.style.color = "#70657b";
                label.style.top = "50%";
            }
        }

        inputFields.forEach(input => {
            const errorDiv = document.getElementById(input.id + "_error");
            const label = input.nextElementSibling;
            let hasInteracted = false;

            updateFloatingLabel(input);
            
            input.addEventListener("focus", function () {
                label.style.top = "-1%";
                label.style.fontSize = "14px";

                if (!hasInteracted || input.value.trim() !== "") {
                    label.style.color = "#70657b";
                    input.style.borderColor = "#ccc";
                } else if (errorDiv && errorDiv.textContent.trim() !== "") {
                    label.style.color = "red";
                    input.style.borderColor = "red";
                }

                hasInteracted = true;
            });

            input.addEventListener("blur", function () {
                hasInteracted = true;
                const value = input.value.trim();
                const labelText = (input.labels && input.labels.length > 0) ? input.labels[0].textContent : input.name.replace(/_/g, " ");

                // Reset label color first
                label.style.color = "#70657b";

                if (!value) {
                    errorDiv.textContent = `${labelText} is required!`;
                    errorDiv.style.display = "block";
                    input.style.borderColor = "red";
                    label.style.color = "red";
                } else {
                    // Validation for specific fields
                    if (["firstname", "lastname", "company_name", "city"].includes(input.id)) {
                        if (!/^[a-zA-Z\s]+$/.test(value)) {
                            errorDiv.textContent = `${labelText} should only contain letters and spaces.`;
                            errorDiv.style.display = "block";
                            input.style.borderColor = "red";
                            label.style.color = "red";
                            return;
                        } else if (value.length < 2 && (input.id === "firstname" || input.id === "lastname")) {
                            errorDiv.textContent = `${labelText} must be at least 2 characters.`;
                            errorDiv.style.display = "block";
                            input.style.borderColor = "red";
                            label.style.color = "red";
                            return;
                        }
                    }

                    if (input.id === "email" && !/^\S+@\S+\.\S+$/.test(value)) {
                        errorDiv.textContent = "Please enter a valid email address!";
                        errorDiv.style.display = "block";
                        input.style.borderColor = "red";
                        label.style.color = "red";
                        return;
                    }

                    if (input.id === "contact") {
                        if (!/^\d{10}$/.test(value)) {
                            errorDiv.textContent = "The Contact Number must be exactly 10 digits.";
                            errorDiv.style.display = "block";
                            input.style.borderColor = "red";
                            label.style.color = "red";
                            return;
                        }
                    }

                    if (input.id === "postal") {
                        if (!/^\d{5,6}$/.test(value)) {
                            errorDiv.textContent = "The Postal Code must be 5 or 6 digits long.";
                            errorDiv.style.display = "block";
                            input.style.borderColor = "red";
                            label.style.color = "red";
                            return;
                        }
                    }

                    if (input.id === "address_line_one") {
                        if (!/^[a-zA-Z0-9\s,.\-]+$/.test(value)) {
                            errorDiv.textContent = "The Address must contain only letters, numbers, spaces, commas, periods, or hyphens.";
                            errorDiv.style.display = "block";
                            input.style.borderColor = "red";
                            label.style.color = "red";
                            return;
                        }
                    }

                    if (input.id === "company_website") {
                        try {
                            new URL(value);
                        } catch (_) {
                            errorDiv.textContent = "Please enter a valid company website URL.";
                            errorDiv.style.display = "block";
                            input.style.borderColor = "red";
                            label.style.color = "red";
                            return;
                        }
                    }

                    errorDiv.textContent = "";
                    errorDiv.style.display = "none";
                    input.style.borderColor = "#ccc";
                    label.style.color = "#70657b";
                }

                updateFloatingLabel(input);
            });

            input.addEventListener("input", function () {
                const value = input.value.trim();
                const labelText = (input.labels && input.labels.length > 0) ? input.labels[0].textContent : input.name.replace(/_/g, " ");

                if (hasInteracted) {
                    // Reset label color first
                    label.style.color = "#70657b";

                    if (!value) {
                        errorDiv.textContent = `${labelText} is required!`;
                        errorDiv.style.display = "block";
                        input.style.borderColor = "red";
                        label.style.color = "red";
                    } else {
                        if (["firstname", "lastname", "company_name", "city"].includes(input.id)) {
                            if (!/^[a-zA-Z\s]+$/.test(value)) {
                                errorDiv.textContent = `${labelText} should only contain letters and spaces.`;
                                errorDiv.style.display = "block";
                                input.style.borderColor = "red";
                                label.style.color = "red";
                                return;
                            } else if (value.length < 2 && (input.id === "firstname" || input.id === "lastname")) {
                                errorDiv.textContent = `${labelText} must be at least 2 characters.`;
                                errorDiv.style.display = "block";
                                input.style.borderColor = "red";
                                label.style.color = "red";
                                return;
                            }
                        }

                        if (input.id === "email" && !/^\S+@\S+\.\S+$/.test(value)) {
                            errorDiv.textContent = "Please enter a valid email address!";
                            errorDiv.style.display = "block";
                            input.style.borderColor = "red";
                            label.style.color = "red";
                            return;
                        }

                        if (input.id === "contact") {
                            if (!/^\d{10}$/.test(value)) {
                                errorDiv.textContent = "The Contact Number must be exactly 10 digits.";
                                errorDiv.style.display = "block";
                                input.style.borderColor = "red";
                                label.style.color = "red";
                                return;
                            }
                        }

                        if (input.id === "postal") {
                            if (!/^\d{5,6}$/.test(value)) {
                                errorDiv.textContent = "The Postal Code must be 5 or 6 digits long.";
                                errorDiv.style.display = "block";
                                input.style.borderColor = "red";
                                label.style.color = "red";
                                return;
                            }
                        }

                        if (input.id === "address_line_one") {
                            if (!/^[a-zA-Z0-9\s,.\-]+$/.test(value)) {
                                errorDiv.textContent = "The Address must contain only letters, numbers, spaces, commas, periods, or hyphens.";
                                errorDiv.style.display = "block";
                                input.style.borderColor = "red";
                                label.style.color = "red";
                                return;
                            }
                        }

                        if (input.id === "company_website") {
                            try {
                                new URL(value);
                            } catch (_) {
                                errorDiv.textContent = "Please enter a valid company website URL.";
                                errorDiv.style.display = "block";
                                input.style.borderColor = "red";
                                label.style.color = "red";
                                return;
                            }
                        }

                        errorDiv.textContent = "";
                        errorDiv.style.display = "none";
                        input.style.borderColor = "#ccc";
                        label.style.color = "#70657b";
                    }
                }

                updateFloatingLabel(input);
            });
        });

        // Special handling for "name_on_card" input separately
        const nameOnCardInput = document.getElementById("name_on_card");
        const nameOnCardError = document.getElementById("name_on_card_error");

        if (nameOnCardInput) {
            nameOnCardInput.addEventListener("input", function () {
                this.value = this.value.replace(/[^a-zA-Z\s]/g, "");

                if (!/^[a-zA-Z\s]+$/.test(this.value)) {
                    nameOnCardError.textContent = "Only letters and spaces are allowed!";
                    nameOnCardError.style.display = "block";
                    this.style.borderColor = "red";
                } else {
                    nameOnCardError.textContent = "";
                    nameOnCardError.style.display = "none";
                    this.style.borderColor = "#ccc";
                }
            });
        }
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
        let subTotalClean = subTotalRaw.toString().replace(/,/g, '');
        let subTotal = parseFloat(subTotalClean);
        console.log(subTotal, 'subTotal');

        let quantity = parseInt($("#quantity").val()) || 1;

        if (!isNaN(quantity)) {
            setTimeout(function () {
                continueCalculation(quantity, subTotal);
            }, 1000);

            // Format subtotal to INR with 2 decimals
            let formattedAmount = "INR " + subTotal.toFixed(2);

            // Update the UI
            $("#items-count").text(quantity + " Items");
            $("#formatted-subtotal").text(formattedAmount);
        } else {
            console.error("Quantity is undefined or invalid.");
        }
    }

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

    function continueCalculation(quantity, subTotal) {
        let currency = $("#currency_code").val();

        // Calculate subtotal and format it
        let finalTotal = quantity * subTotal;
        let formattedSubtotal = finalTotal.toFixed(2);
        $("#subtotal_amount").text(currency + ' ' + formattedSubtotal);
        $('.finaltotals').text(currency + ' ' + formattedSubtotal);

        // GST calculation
        let gstPr = parseFloat($('#gst_amount').data('pr')) || 0;
        let gstAmount = (gstPr / 100) * finalTotal;
        let formattedGst = gstAmount.toFixed(2);
        finalTotal += gstAmount;
        

        // Discount logic
        let discountInput = $('#server_discount').val();
        let discount = parseFloat(discountInput);
        let discountType = $('#discount_coupon_type').data('type');
        let discountAmount = 0;
        

        // Apply discount only if valid
        if (!isNaN(discount) && discount > 0 && (discountType === 'flat' || discountType === 'percentage')) {
            if (discountType === 'flat') {
                discountAmount = discount;
            } else if (discountType === 'percentage') {
                discountAmount = (discount / 100) * finalTotal;
            }
            finalTotal -= discountAmount;
        }
        console.log(finalTotal,'finalTotal1');
        
        // Format amounts
        let formattedDiscount = discountAmount.toFixed(2);
        let formattedFinal = finalTotal.toFixed(2);

        // Display updated values
        $("#gst_amount").text(currency + ' ' + formattedGst);
        $("#final_total").text(currency + ' ' + formattedFinal);
        $(".final_total").text(currency + ' ' + formattedFinal);
        $("#discount_amount").text(currency + ' ' + formattedDiscount);
        $("#discount_value").val(formattedDiscount);
        $(".final_btn_text").text(formattedFinal);
        $("#final_quantity").val(quantity);
        $("#amount").val((finalTotal * 100).toFixed(0));
    }

    function isCardExpired(month, year) {
        const expMonth = parseInt(month, 10);
        const expYear = parseInt('20' + year, 10);

        const today = new Date();
        const currentMonth = today.getMonth() + 1;
        const currentYear = today.getFullYear();

        return expYear < currentYear || (expYear === currentYear && expMonth < currentMonth);
    }
   function validateExpiration() {
        const monthVal = $('#card_exp_month').val().trim();
        const yearVal = $('#card_exp_year').val().trim();
        const monthError = $('#card_exp_month_error');
        const yearError = $('#card_exp_year_error');

        monthError.hide();
        yearError.hide();

        let valid = true;

        let parsedMonth = parseInt(monthVal, 10);
        let parsedYear = parseInt(yearVal, 10);

        // Month Validation
        if (!monthVal || isNaN(parsedMonth) || parsedMonth < 1 || parsedMonth > 12) {
            monthError.text('Invalid month (01-12)').show();
            valid = false;
        }

        // Year Format Validation
        if (!yearVal || isNaN(parsedYear) || yearVal.length !== 2) {
            yearError.text('Year must be 2 digits').show();
            valid = false;
            return valid; // ⛔ stop here — don't check expiry
        }

        // If both inputs valid → check expiry
        if (!isNaN(parsedMonth) && !isNaN(parsedYear)) {
            if (isCardExpired(parsedMonth, parsedYear)) {
                yearError.text('Card has expired').show();
                valid = false;
            }
        }

        return valid;
    }


    function validateCVC() {
        const cvcInput = document.getElementById('card_cvc');
        const cvcError = document.getElementById('card_cvc_error');

        const cvcVal = cvcInput.value.trim();
        cvcError.style.display = 'none';

        if (cvcVal.length !== 3 || isNaN(cvcVal)) {
            cvcError.textContent = 'CVC must be 3 digits';
            cvcError.style.display = 'block';
            return false;
        }

        return true;
    }

    function validateCardNumber() {
        const cardInput = document.getElementById('card_number');
        const cardError = document.getElementById('card_number_error');

        const cardVal = cardInput.value.replace(/\D/g, '');
        cardError.style.display = 'none';

        if (cardVal.length !== 16) {
            cardError.textContent = 'Card number must be 16 digits';
            cardError.style.display = 'block';
            return false;
        }

        return true;
    }

document.addEventListener('DOMContentLoaded', function () {
    const cardNumberInput = document.getElementById('card_number');
    const cardNumberError = document.getElementById('card_number_error');

    const monthInput = document.getElementById('card_exp_month');
    const monthError = document.getElementById('card_exp_month_error');

    const yearInput = document.getElementById('card_exp_year');
    const yearError = document.getElementById('card_exp_year_error');

    const cvcInput = document.getElementById('card_cvc');
    const cvcError = document.getElementById('card_cvc_error');

    const stripeToken = document.getElementById('stripeToken');

    // Card Number Formatting and Validation
    cardNumberInput.addEventListener('input', function (e) {
        let value = e.target.value.replace(/\D/g, '');
        value = value.replace(/(\d{4})(?=\d)/g, '$1 ');
        e.target.value = value.substring(0, 19); // Max 16 digits + 3 spaces

        if (value.replace(/\D/g, '').length === 16) {
            cardNumberError.style.display = 'none';
        } else {
            cardNumberError.textContent = 'Please enter 16 digits';
            cardNumberError.style.display = 'block';
        }
    });

    // Month input: allow only 2 digits and validate
    monthInput.addEventListener('input', function (e) {
        e.target.value = e.target.value.replace(/\D/g, '').substring(0, 2);
        validateExpiration();
    });

    // Year input: allow only 2 digits and validate
    yearInput.addEventListener('input', function (e) {
        e.target.value = e.target.value.replace(/\D/g, '').substring(0, 2);
        validateExpiration();
    });

    // Revalidate on blur
    monthInput.addEventListener('blur', validateExpiration);
    yearInput.addEventListener('blur', validateExpiration);


    // CVC input: allow only 3 digits
    cvcInput.addEventListener('input', function (e) {
        let value = e.target.value.replace(/\D/g, '').substring(0, 3);
        e.target.value = value;

        if (value.length === 3) {
            cvcError.style.display = 'none';
        } else {
            cvcError.textContent = 'CVC must be 3 digits';
            cvcError.style.display = 'block';
        }
    });

   document.querySelector('form').addEventListener('submit', function(e) {
        let isValid = true;

        const cardNumber = cardNumberInput.value.replace(/\D/g, '');
        const cvcVal = cvcInput.value.trim();

        if (cardNumber.length !== 16) {
            cardNumberError.textContent = 'Please enter 16 digits';
            cardNumberError.style.display = 'block';
            isValid = false;
        }

        if (!validateExpiration()) {
            isValid = false;
        }
        if (!validateCardNumber()) valid = false;
        if (!validateCVC()) valid = false;
        if (!stripeToken.value) {
            isValid = false;
        }

        if (cvcVal.length !== 3) {
            cvcError.textContent = 'CVC must be 3 digits';
            cvcError.style.display = 'block';
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
        }
    });
});
  $(document).ready(function () {
        var phoneInput = document.querySelector("#contact_number");

        // Initialize intl-tel-input
        var iti = window.intlTelInput(phoneInput, {
            separateDialCode: true,
            preferredCountries: ["us", "gb", "in"], // Set preferred countries
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js"
        });

        // Retrieve stored country ISO code
        var userISOCode = $("#country").val(); // e.g., "US"

        // Set the pre-selected country based on ISO code
        if (userISOCode) {
            iti.setCountry(userISOCode.toLowerCase()); // Convert to lowercase for intlTelInput
        }

        // Listen for country changes and store both ISO code and dial code
        phoneInput.addEventListener("countrychange", function () {
            var countryData = iti.getSelectedCountryData();
            $("#country_code").val(countryData.dialCode);  // ✅ Save dial code (e.g., "1")
            $("#country").val(countryData.iso2.toUpperCase());  // ✅ Save ISO code (e.g., "US")
        });

        // Ensure both country_code & country are stored before form submission
        $("form").submit(function () {
            var countryData = iti.getSelectedCountryData();
            $("#country_code").val(countryData.dialCode);
            $("#country").val(countryData.iso2.toUpperCase());
        });
    });
</script>