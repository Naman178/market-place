<script>
   document.addEventListener('DOMContentLoaded', function () {
        const trialBtn = document.getElementById('trial_button');
        const modal = document.getElementById('trialChoiceModal');
        const closeModal = document.getElementById('close_modal');
        const chooseTrial = document.getElementById('choose_trial');
        const choosePay = document.getElementById('choose_without_trial');
        const trialPeriodInput = document.getElementById('trial_period_days');
        const changeOptionBtn = document.getElementById('change_option_button');

        trialPeriodInput.value = "0";

        // Show modal when trial button is clicked (only if not yet submitted)
        if (trialBtn) {
            trialBtn.addEventListener('click', function (e) {
                if (trialBtn.getAttribute('type') !== 'submit') {
                    e.preventDefault(); 
                    modal.style.display = 'block';
                }
            });
        }

        // "Change Option" button opens modal again
        changeOptionBtn.addEventListener('click', function () {
            modal.style.display = 'block';
        });

        // Close modal
        closeModal.addEventListener('click', function () {
            modal.style.display = 'none';
        });

        // Handle "Start Free Trial"
        chooseTrial.addEventListener('click', function () {
            trialPeriodInput.value = "{{ $plan->trial_days }}"; 
            const trialDays = trialPeriodInput.value;
            changeButtonToSubmit(trialBtn, `Free Trial for <span class="final_btn_text">${trialDays}</span> Days`);
            modal.style.display = 'none';
            changeOptionBtn.style.display = 'inline-flex'; // show the change button
        });

        // Handle "Proceed to Pay"
        choosePay.addEventListener('click', function () {
            trialPeriodInput.value = "0"; 
            const finalTotal = "{{ number_format((int) $final_total) }}";
            const currency = "{{ $plan->currency ?? 'INR' }}";
            changeButtonToSubmit(trialBtn, `Proceed To Pay <span class="final_btn_text">${finalTotal}</span> ${currency}`);
            modal.style.display = 'none';
            changeOptionBtn.style.display = 'inline-flex'; // show the change button
        });

        // Utility function to change button type and label
        function changeButtonToSubmit(button, labelHtml) {
            if (!button) return;
            button.setAttribute('type', 'submit'); 
            button.innerHTML = `
                <svg viewBox="0 0 100 100" preserveAspectRatio="none">
                    <polyline points="99,1 99,99 1,99 1,1 99,1" class="bg-line"></polyline>
                    <polyline points="99,1 99,99 1,99 1,1 99,1" class="hl-line"></polyline>
                </svg>
                <span>${labelHtml}</span>
            `;
        }
    });


    $(document).ready(function() {
        var itemId = "{{ $plan->id }}";
        console.log("{{ $plan->pricing->fixed_price}}")
        var storeid = localStorage.getItem("itemId");
        var itemPrice =parseFloat("{{$totalSubtotal ?? $selectedPricing->sale_price }}") || 0;
        var gst = Math.round(
            parseFloat("{{$totalGST ?? ( $selectedPricing->gst_percentage) / 100 * ($selectedPricing['sale_price'] ?? $selectedPricing->sale_price) }}") || 0
        );
        if (itemId != storeid) {
            localStorage.removeItem("selectedCouponId");
            localStorage.removeItem("selectedCouponCode");
            localStorage.removeItem("selectedtotal");
            localStorage.removeItem("selecteddiscount");
            localStorage.removeItem("itemId");
        }

        let selectedCouponId = localStorage.getItem("selectedCouponId");
        let selectedCouponCode = localStorage.getItem("selectedCouponCode");
        // let selectedtotal = localStorage.getItem("selectedtotal");
        let selectedtotal = (itemPrice + gst).toFixed(2);
        let selecteddiscount = localStorage.getItem("selecteddiscount");
        $("#discount_amount").text("INR " + selecteddiscount);
        
        if (selectedCouponId) {
            let final_total = selectedtotal - selecteddiscount;
            console.log(itemPrice , gst , selecteddiscount, selectedtotal, final_total);
            let formattedTotal = new Intl.NumberFormat('en-IN').format(final_total);
            $('#final_total').text("INR " + formattedTotal);
            $(".pink-blue-grad-button.d-inline-block.border-0.proced_to_pay_btn").text("Proceed To Pay " + formattedTotal + " INR");
            $('[name="amount"]').val(selectedtotal * 100);
            $('[name="discount_value"]').val(selecteddiscount);
            $('[name="final_coupon_code"]').val(selectedCouponId);
            let selectedBtn = $('.coupon-btn[data-coupon-id="' + selectedCouponId + '"]');
            applyCouponStyle(selectedBtn);
            selectedBtn.text("Remove").addClass("remove-btn").prop("disabled", false);
            showAppliedCouponSection(selectedCouponCode);
        }

        let autoApplyCouponId = "{{ isset($autoApplyCoupon) ? $autoApplyCoupon->id : '' }}";
        let autoApplyCouponCode = "{{ isset($autoApplyCoupon) ? $autoApplyCoupon->coupon_code : '' }}";
        if (!selectedCouponId && autoApplyCouponId) {
            // No coupon selected, apply auto-apply coupon
            let $autoApplyBtn = $(".coupon-btn[data-coupon-id='" + autoApplyCouponId + "']");
            validateAndApplyCoupon(autoApplyCouponId, autoApplyCouponCode, $autoApplyBtn);
        } else if (selectedCouponId) {
            // Restore previous coupon selection
            let $selectedBtn = $('.coupon-btn[data-coupon-id="' + selectedCouponId + '"]');
            applyCouponStyle($selectedBtn);
            $selectedBtn.text("Remove").addClass("remove-btn").prop("disabled", false);
            showAppliedCouponSection(selectedCouponCode);
        }

        $(".coupon-btn").on("click", function() {
            let couponId = $(this).data("coupon-id");
            let couponCode = $(this).data("coupon-code");

            if ($(this).hasClass("remove-btn")) {
                removeCoupon();
            } else {
                // applyCoupon(couponId, couponCode, $(this));
                validateAndApplyCoupon(couponId, couponCode, $(this));
            }
        });

        $(".remove-applied-coupon").on("click", function() {
            removeCoupon();
        });

        function validateAndApplyCoupon(couponId, couponCode, button) {
            var itemId = "{{ $plan->id }}";
            $.ajax({
                url: "{{ route('apply.coupon') }}",
                type: "POST",
                data: {
                    coupon_id: couponId,
                    couponCode: couponCode,
                    itemId: itemId,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.success) {
                        let formattedTotal = new Intl.NumberFormat('en-IN').format(response.total);
                        let total = response.total;
                        let discount = response.discount;
                        if(discount > 0){
                            $(".discount_row").removeClass("d-none");
                            $("#discount_amount").text("INR " + new Intl.NumberFormat('en-IN').format(discount));
                        }
                        applyCoupon(couponId, couponCode, button, total, discount,response.discount_type);
                        $('#final_total').text("INR " + formattedTotal);
                        $(".pink-blue-grad-button.d-inline-block.border-0.proced_to_pay_btn").text(
                            "Proceed To Pay " + formattedTotal + " INR");
                        $('[name="amount"]').val(response.total * 100);
                        $('[name="discount_value"]').val(response.discount);
                        $('[name="final_coupon_code"]').val(couponId);
                        $(".coupon-error").text("");
                    } else if (response.error) {
                        $(".coupon-error").text(response.error);
                    }
                },
                error: function(xhr) {
                    let errorMessage = xhr.responseJSON && xhr.responseJSON.error ? xhr.responseJSON
                        .error : "An error occurred.";
                    $(".coupon-error").text(errorMessage);
                }
            });
        }

        function applyCoupon(couponId, couponCode, button, total, discount,type) {

            var itemId = "{{ $plan->id }}";
            localStorage.setItem("selectedCouponId", couponId);
            localStorage.setItem("selectedCouponCode", couponCode);
            localStorage.setItem("selectedtotal", total);
            localStorage.setItem("selecteddiscount", discount);
            localStorage.setItem("itemId", itemId);
            localStorage.setItem("discount_type", type);

            window.location.reload();
            $(".coupon-btn").text("Apply").removeClass("remove-btn").prop("disabled", true).each(function() {
                removeCouponStyle($(this));
            });
            $(".discount_row").removeClass("d-none");

            button.text("Remove").addClass("remove-btn").prop("disabled", false);
            applyCouponStyle(button);
            showAppliedCouponSection(couponCode);
        }

        function removeCoupon() {
            localStorage.removeItem("selectedCouponId");
            localStorage.removeItem("selectedCouponCode");
            localStorage.removeItem("selectedtotal");
            localStorage.removeItem("selecteddiscount");
            localStorage.removeItem("itemId");

            $(".coupon-btn").text("Apply").removeClass("remove-btn").prop("disabled", false).each(function() {
                removeCouponStyle($(this));
            });

            hideAppliedCouponSection();

            // Calculate the total price including GST
            let fixedPrice = parseFloat("{{ $plan->pricing->sale_price }}");
            let gstPercentage = parseFloat("{{ $plan->pricing->gst_percentage }}");
            let quantity = $('#quantity').text();
            // console.log(quantity);
            fixedPrice = fixedPrice * quantity;
            let totalWithGst = fixedPrice + (fixedPrice * gstPercentage / 100);
            let roundedAmount = Math.round(totalWithGst);

            // Format the total
            let formattedTotal = new Intl.NumberFormat('en-IN').format(roundedAmount);

            // Update the UI with the new final total
            $('#final_total').text("INR " + formattedTotal);
            $(".pink-blue-grad-button.d-inline-block.border-0.proced_to_pay_btn").text(
                "Proceed To Pay INR " + formattedTotal
            );

            $('[name="amount"]').val(roundedAmount * 100);
            $('[name="discount_value"]').val(0);
            $('[name="final_coupon_code"]').val('');

            $(".discount_row").addClass("d-none");
            $("#discount_amount").text("");

            $(".coupon-error").text("");
        }

        function applyCouponStyle(button) {
            let topCard = button.closest(".card.mt-4");
            let innerCard = button.closest(".card");

            innerCard.css({
                "background": "#88c0e1",
                "color": "#066299"
            });
            topCard.css({
                "background": "#066299",
                "color": "white"
            });
        }

        function removeCouponStyle(button) {
            let topCard = button.closest(".card.mt-4");
            let innerCard = button.closest(".card");

            topCard.css({
                "background": "",
                "color": ""
            });
            innerCard.css({
                "background": "",
                "color": ""
            });
        }

        function showAppliedCouponSection(couponCode) {
            $(".apply-coupon-code-container").show();
            // $(".discount_row").show();
            $(".discount_row").removeClass("d-none");
            $(".applied-coupon-code").text(couponCode);
        }

        function hideAppliedCouponSection() {
            $(".apply-coupon-code-container").hide();
        }

        // if (!selectedCouponCode) {
            $('#coupon_code_apply_btn').on('click', function() {
                console.log('btn clicked');
                let couponCode = $('#coupon_code').val().trim();
                if (couponCode === "") {
                    $('#coupon_code_error').text('Coupon code is required!').css('color', 'red');
                } else {
                    var itemId = "{{ $plan->id }}";
                    $.ajax({
                        url: "{{ route('apply.coupon') }}",
                        type: "POST",
                        data: {
                            couponCode: couponCode,
                            itemId: itemId,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.success) {
                                let formattedTotal = new Intl.NumberFormat('en-IN').format(
                                    response.total);
                                let total = response.total;
                                let discount = response.discount;

                                $('#final_total').text("INR " + formattedTotal);
                                $(".pink-blue-grad-button.d-inline-block.border-0.proced_to_pay_btn")
                                    .text(
                                        "Proceed To Pay " + formattedTotal + " INR");
                                $('[name="amount"]').val(response.total * 100);
                                $('[name="discount_value"]').val(response.discount);
                                $('[name="final_coupon_code"]').val(response.id);
                                showAppliedCouponSection(couponCode);
                                let $select = null;
                                let couponId = response.id;

                                $('.coupon-container .card').each(function() {
                                    let $btn = $(this).find('#topapplybtn');
                                    let id = $btn.data('coupon-code').toLowerCase();
                                    couponCode = couponCode.toLowerCase();

                                    if (couponCode == id) {
                                        $select = $btn;
                                    }
                                });
                                applyCouponStyle($select);
                                applyCoupon(couponId, couponCode, $select,total, discount);

                                $(".coupon-error").text("");
                                $("#coupon_code").val("");
                            } else if (response.error) {
                                setTimeout(function() {
                                    window.location.reload();
                                }, 1000);
                                $(".coupon-error").text(response.error);
                            }
                        },
                        error: function(xhr) {
                            setTimeout(function() {
                                window.location.reload();
                            }, 1000);
                            let errorMessage = xhr.responseJSON && xhr.responseJSON.error ?
                                xhr.responseJSON
                                .error : "An error occurred.";
                            $(".coupon-error").text(errorMessage);
                        }
                    });
                }
            });
        // }
        
        $(".remove-item").on("click", function () {
            let planId = $(this).data("plan-id");
            let pricingId = $(this).data("pricing-id");

            $.ajax({
                url: "{{ route('cart.remove') }}",
                type: "POST",
                data: {
                    plan_id: planId,
                    pricing_id: pricingId,
                    _token: "{{ csrf_token() }}"
                },
                success: function (response) {
                    if (response.success) {
                        $("#cart-container-" + planId + "-" + pricingId).fadeOut(300, function () {
                            $(this).remove();
                            location.reload();
                            recalculateTotals();
                        });
                    } else {
                        toastr.error("Error removing item");
                    }
                },
                error: function () {
                    toastr.error("Failed to remove item. Try again.");
                }
            });
        });

        function recalculateTotals() {
            let newSubtotal = 0;
            let newGST = 0;
            let newDiscount = parseFloat(localStorage.getItem("selecteddiscount")) || 0;

            $(".cart-item").each(function () {
                let price = parseFloat($(this).find(".new-price").text().replace("₹", "").trim()) || 0;
                let gstPercent = parseFloat($(this).data("gst-percentage")) || 0;
                
                let gstAmount = Math.round((gstPercent / 100) * price);

                newSubtotal += price;
                newGST += gstAmount;
            });

            let finalTotal = newSubtotal + newGST - newDiscount;

            // 🏷️ Update HTML with new values
            $("#subtotal_amount").text("INR " + newSubtotal.toLocaleString("en-IN"));
            $("#gst_amount").text("INR " + newGST.toLocaleString("en-IN"));
            $("#discount_amount").text("INR " + newDiscount.toLocaleString("en-IN"));
            $("#final_total").text("INR " + finalTotal.toLocaleString("en-IN"));

            console.log("Updated Totals:", newSubtotal, newGST, newDiscount, finalTotal);
        }
    });
</script>
