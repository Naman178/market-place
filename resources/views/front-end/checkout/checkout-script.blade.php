
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
                if (!validateExpiration(card_exp_month, card_exp_year)) {
                    valid = false;
                }
                if (!valid) {
                    e.preventDefault();
                    return;
                }
               if (!$form.data('cc-on-file')) {
                   e.preventDefault();
                   Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                //    document.getElementById('country').addEventListener('change', function() {
                //        let selectedOption = this.options[this.selectedIndex];
                //        let countryCode = selectedOption.getAttribute('data-country-code');
                //        // You can store the countryCode in a hidden input or use it directly in the Stripe API call
                //        console.log('Selected country code:', countryCode);
                //    });
           
                   // Create Stripe Token with address details
                   Stripe.card.createToken({
                       number: card_number,
                       cvc: card_cvc,
                       exp_month: card_exp_month,
                       exp_year: card_exp_year,
                       name: name_on_card, // Include the name on the card
                    //    address_line1: $('#address_line_1').val(), // Add address line 1
                    //    address_line2: $('#address_line_2').val(), // Add address line 2
                    //    address_city: $('#city').val(), // Add city
                    //    address_state: $('#state').val(), // Add state if you have it
                    //    address_zip: $('#postal_code').val(), // Add postal code
                    //    address_country: $('#country').find(':selected').data('country-code')
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
        console.log("Raw subtotal:", subTotalRaw);

        let subTotalClean = subTotalRaw.toString().replace(/,/g, '');
        let subTotal = parseInt(subTotalClean);

        console.log("Parsed subtotal:", subTotal); 

        let quantity = parseInt($("#quantity").val()) || 1;

        console.log(quantity, subTotal);

        if (!isNaN(quantity)) {
            setTimeout(function() {
                continueCalculation(quantity, subTotal);
            }, 1000);
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
    // document.addEventListener('DOMContentLoaded', function() {
    //     // Helper function to check if card is expired
    //     function isCardExpired(month, year) {
    //         const currentDate = new Date();
    //         const currentYear = currentDate.getFullYear() % 100;
    //         const currentMonth = currentDate.getMonth() + 1;
            
    //         const inputMonth = parseInt(month, 10);
    //         const inputYear = parseInt(year, 10);
            
    //         if (inputYear < currentYear) return true;
    //         if (inputYear === currentYear && inputMonth < currentMonth) return true;
    //         return false;
    //     }

    //     // Enhanced expiration date validation
    //     function validateExpiration() {
    //         const monthInput = document.getElementById('card_exp_month');
    //         const yearInput = document.getElementById('card_exp_year');
    //         const monthError = document.getElementById('card_exp_month_error');
    //         const yearError = document.getElementById('card_exp_year_error');
            
    //         // Reset errors
    //         monthError.style.display = 'none';
    //         yearError.style.display = 'none';
            
    //         let isValid = true;
            
    //         // Validate month format and range
    //         if (monthInput.value) {
    //             if (monthInput.value.length !== 2) {
    //                 monthError.textContent = 'Month must be 2 digits';
    //                 monthError.style.display = 'block';
    //                 isValid = false;
    //             } else if (parseInt(monthInput.value) < 1 || parseInt(monthInput.value) > 12) {
    //                 monthError.textContent = 'Invalid month (01-12)';
    //                 monthError.style.display = 'block';
    //                 isValid = false;
    //             }
    //         }
            
    //         // Validate year format
    //         if (yearInput.value && yearInput.value.length !== 2) {
    //             yearError.textContent = 'Year must be 2 digits';
    //             yearError.style.display = 'block';
    //             isValid = false;
    //         }
            
    //         // Only check expiration if both fields are complete
    //         if (monthInput.value.length === 2 && yearInput.value.length === 2) {
    //             if (isCardExpired(monthInput.value, yearInput.value)) {
    //                 yearError.textContent = 'Card has expired';
    //                 yearError.style.display = 'block';
    //                 isValid = false;
    //             }
    //         }
            
    //         return isValid;
    //     }

    //     // Month validation with immediate feedback
    //     const monthInput = document.getElementById('card_exp_month');
    //     monthInput.addEventListener('input', function(e) {
    //         let value = e.target.value.replace(/\D/g, '');
    //         if (value.length > 2) value = value.substring(0, 2);
    //         e.target.value = value;
            
    //         // Validate after each input
    //         validateExpiration();
    //     });

    //     // Year validation with immediate feedback
    //     const yearInput = document.getElementById('card_exp_year');
    //     yearInput.addEventListener('input', function(e) {
    //         let value = e.target.value.replace(/\D/g, '');
    //         if (value.length > 2) value = value.substring(0, 2);
    //         e.target.value = value;
            
    //         // Validate after each input
    //         validateExpiration();
    //     });

    //     // Card number formatting (keep existing implementation)
    //     const cardNumberInput = document.getElementById('card_number');
    //     cardNumberInput.addEventListener('input', function(e) {
    //         let value = e.target.value.replace(/\D/g, '');
    //         value = value.replace(/(\d{4})(?=\d)/g, '$1 ');
    //         if (value.length > 19) value = value.substring(0, 19);
    //         e.target.value = value;
    //     });

    //     // CVC validation (keep existing implementation)
    //     const cvcInput = document.getElementById('card_cvc');
    //     cvcInput.addEventListener('input', function(e) {
    //         let value = e.target.value.replace(/\D/g, '');
    //         if (value.length > 3) value = value.substring(0, 3);
    //         e.target.value = value;
    //     });

    //     // Enhanced form submission
    //     document.querySelector('form').addEventListener('submit', function(e) {
    //         let isValid = true;
            
    //         // Card number validation
    //         const cardNumber = cardNumberInput.value.replace(/\D/g, '');
    //         if (cardNumber.length !== 16) {
    //             document.getElementById('card_number_error').textContent = 'Card number must be 16 digits';
    //             document.getElementById('card_number_error').style.display = 'block';
    //             isValid = false;
    //         }
            
    //         // Expiration date validation
    //         if (!validateExpiration()) {
    //             isValid = false;
    //         }
            
    //         // CVC validation
    //         if (!cvcInput.value || cvcInput.value.length !== 3) {
    //             document.getElementById('card_cvc_error').textContent = 'CVC must be 3 digits';
    //             document.getElementById('card_cvc_error').style.display = 'block';
    //             isValid = false;
    //         }
            
    //         if (!isValid) {
    //             e.preventDefault();
    //         }
    //     });

    //     // Validate immediately when page loads if fields have values
    //     validateExpiration();
    // });
    function isCardExpired(month, year) {
        const expMonth = parseInt(month, 10);
        const expYear = parseInt('20' + year, 10); // Convert "25" -> 2025

        const today = new Date();
        const currentMonth = today.getMonth() + 1; // Jan = 0
        const currentYear = today.getFullYear();

        // Expired if year < current year, or year === current and month < current
        return (expYear < currentYear) || (expYear === currentYear && expMonth < currentMonth);
    }

    function validateExpiration() {
        const monthInput = document.getElementById('card_exp_month');
        const yearInput = document.getElementById('card_exp_year');
        const monthError = document.getElementById('card_exp_month_error');
        const yearError = document.getElementById('card_exp_year_error');

        const monthVal = monthInput.value.trim();
        const yearVal = yearInput.value.trim();

        monthError.style.display = 'none';
        yearError.style.display = 'none';

        let isValid = true;

        const parsedMonth = parseInt(monthVal, 10);
        const parsedYear = parseInt(yearVal, 10);

        // Month check
        if (monthVal.length !== 2 || isNaN(parsedMonth) || parsedMonth < 1 || parsedMonth > 12) {
            monthError.textContent = 'Invalid month (01-12)';
            monthError.style.display = 'block';
            isValid = false;
        }

        // Year check
        if (yearVal.length !== 2 || isNaN(parsedYear)) {
            yearError.textContent = 'Year must be 2 digits';
            yearError.style.display = 'block';
            isValid = false;
        }

        // Expiry check only if month/year format is valid
        if (!isNaN(parsedMonth) && !isNaN(parsedYear) && parsedMonth >= 1 && parsedMonth <= 12 && yearVal.length === 2) {
            if (isCardExpired(monthVal, yearVal)) {
                yearError.textContent = 'Card has expired';
                yearError.style.display = 'block';
                isValid = false;
            }
        }

        return isValid;
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

    document.addEventListener('click', () => {
        const monthInput = document.getElementById('card_exp_month');
        const yearInput = document.getElementById('card_exp_year');
        const yearError = document.getElementById('card_exp_year_error');

        if (isCardExpired(monthInput.value.trim(), yearInput.value.trim())) {
            yearError.textContent = 'Card has expired';
            yearError.style.display = 'block';
        }
    });

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