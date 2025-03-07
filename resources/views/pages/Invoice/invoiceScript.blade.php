<script>
    
    $(document).ready(function() {
        //change in subcategories dropdown
        $('#category').change(function() {
            var category_id = $(this).val();
            if (category_id != 0) {
                $.ajax({
                    url: "{{ route('fetch.subcategories') }}",
                    type: "GET",
                    data: { category_id: category_id },
                    success: function(response) {
                        $('#sub_category').empty().append('<option value="0">Select sub category</option>');
                        $('#product').empty().append('<option value="0">Select product</option>');
                        $.each(response.subcategories, function(key, value) {
                            $('#sub_category').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            } else {
                $('#sub_category').empty().append('<option value="0">Select sub category</option>');
            }
        });
        
        // Fetch products when subcategory changes
        $('#sub_category').change(function() {
            var category_id = $('#category').val();
            var sub_category_id = $(this).val();
            $('#product').empty().append('<option value="0">Select product</option>');

            if (category_id != 0 && sub_category_id != 0) {
                $.ajax({
                    url: "{{ route('fetch.products') }}",
                    type: "GET",
                    data: { category_id: category_id, sub_category_id: sub_category_id },
                    success: function(response) {
                        $('#coupon').empty().append('<option value="0">Select product first</option>');
                        $.each(response.products, function(key, value) {
                            $('#product').append('<option value="' + value.id + '" data-type="' + value.pricing_type + '" data-price="' + value.price + '" data-gst="' + value.gst + '">' + value.name + '</option>');
                        });
                    }
                });
            }
        });

        // Fetch coupon available for product
        $('#product').change(function() {
            var product_id = $(this).val();
            let userError = $('#user_error').text("");
            $('#coupon').empty().append('<option value="0">Select product first</option>');
            $('#discount').val(0).data('manual', "false");
            let user_id = $('#user_select').find(':selected').val();
            if (product_id != 0) {
                $.ajax({
                    url: "{{ route('fetch.coupon') }}",
                    type: "GET",
                    data: { 
                        product_id: product_id,
                        userid: user_id,
                     },
                    success: function(response) {
                        $.each(response.coupon, function(key, value) {
                            $('#coupon').append('<option value="' + value.id + '" data-coupon_type="' + value.discount_type + '" data-discount="' + value.discount_value + '">' + value.coupon_code + '</option>');
                        });
                    },
                    error: function (xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            if (errors.userid) {
                                userError.text(errors.userid[0]);
                                setTimeout(() => {
                                    userError.text("");
                                }, 3000);
                            }
                        } else {
                            console.log(xhr);
                        }
                    }
                });
            }
        });
    });

    function dynamicCalculation() {
        let selectedProduct = $('#product').find(':selected');
        let price = parseFloat(selectedProduct.data('price')) || 0;
        let gst = parseFloat(selectedProduct.data('gst')) || 0;

        let coupon = $('#coupon').find(':selected');
        let discount_type = coupon.data('coupon_type');
        let discount_pr = parseFloat(coupon.data('discount')) || 0;

        // Check if discount was manually changed je
        let discountInput = $('#discount');
        if (discountInput.data('manual') === "false") {
            discountInput.val(discount_pr);
        }

        let final_discount = parseFloat(discountInput.val()) || 0;

        let gstAmount = (price * gst) / 100;
        let total = price + gstAmount;

        if (discount_type === 'percentage' || discount_type == undefined) {
            total -= (total * final_discount) / 100;
        } else if (discount_type === 'flat') {
            total -= final_discount;
        }

        $('#subtotal').val(price.toFixed(2));
        $('#gst').val(gst.toFixed(2));
        $('#total').val(total.toFixed(2));
    }

    $('#discount').on('input', function () {
        $(this).data('manual', "true");
    });

    $('#coupon').on('change', function () {
        $('#discount').data('manual', "false");
    });

    $('#product').on('change',function(){
        setTimeout(function () {
            dynamicCalculation();
        }, 1000);
    })

    $(document).on('click','.erp-invoice-form',function(e){
        e.preventDefault();
        let userError = $('#user_error').text("");
        var submitUrl = $('#invoice_form').attr("data-url");
        let user_id = $('#user_select').find(':selected').val();
        let category_id = $('#category').find(':selected').val();
        let sub_category_id = $('#sub_category').find(':selected').val();
        let product_id = $('#product').find(':selected').val();
        let coupon_id = $('#coupon').find(':selected').val();

        let subtotal = $('#subtotal').val();
        let gst = $('#gst').val();
        let discount = $('#discount').val();
        let fianlTotal = $('#total').val();

        $.ajax({
            url: submitUrl,
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                userid: user_id,
                categoryid: category_id,
                sub_category_id: sub_category_id,
                product_id: product_id,
                coupon_id: coupon_id,
                subtotal:subtotal,
                gst: gst,
                discount: discount,
                fianlTotal: fianlTotal
            },
            success: function(response){
                console.log(response)
                if (response.invoice_id) {
                    window.location.href = response.redirect_url;
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    if (errors.userid) {
                        userError.text(errors.userid[0]);
                        setTimeout(() => {
                            userError.text("");
                        }, 3000);
                    }
                } else {
                    console.log(xhr);
                }
            }
        });
    });
</script>