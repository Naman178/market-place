<script>
    $('#applicable_type').on('change', function() {
        var selectedType = $(this).val();
        if (selectedType === '') {
            $('#applicable_type_error').text('Please select applicable products.');
            $('#applicable_selection_container').hide();
            $('#applicable_selection').html('');
        } else {
            $('#applicable_type_error').text('');
            if (selectedType === 'category' || selectedType === 'sub-category' || selectedType === 'product') {
                fetchApplicableData(selectedType);
            } else {
                $('#applicable_selection_container').hide();
                $('#applicable_selection').html('');
            }
        }
    });

    $('#applicable_for').on('change', function() {
        var selectedVal = $(this).val();
        if (selectedVal === '') {
            $('#applicable_for_error').text('Please select applicable for.');
        }
    });

    $('#discount_type').on('change', function() {
        var selectedVal = $(this).val();
        if (selectedVal === '') {
            $('#discount_type_error').text('Please select discount type.');
        }
    });

    $('.erp-coupon-form').on('click', function(e) {
        e.preventDefault();

        $('.error').text('');

        var formData = new FormData($('#coupon_form')[0]);
        formData.append('_token', '{{ csrf_token() }}');

        $.ajax({
            url: "{{ route('coupons.store') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    var redirectUrl = "{{ route('coupon-index') }}";
                    window.location.href = redirectUrl;
                }
            },
            error: function(xhr) {
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    $.each(xhr.responseJSON.errors, function(key, value) {
                        $('#' + key + '_error').text(value[0]);
                    });
                }
            }
        });
    });

    function fetchApplicableData(type) {
        $.ajax({
            url: "{{ route('get.applicable.data') }}",
            type: 'GET',
            data: {
                type: type
            },
            success: function(response) {
                if (response.success) {
                    var options = '';
                    response.data.forEach(function(item) {
                        options += `<option value="${item.id}">${item.name}</option>`;
                    });
                    $('#applicable_selection').html(options);
                    $('#applicable_selection_container').show();
                    $('#applicable_selection').select2();
                } else {
                    alert('No data found for the selected type.');
                }
            },
            error: function() {
                alert('Something went wrong. Please try again.');
            }
        });
    }

    $(document).on('click', '.delete-btn', function(e) {
        e.preventDefault();
        var submitURL = $(this).attr("data-url");
        Swal.fire({
            title: 'Are you sure you want to delete this item?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#4caf50',
            cancelButtonColor: '#f44336',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = submitURL;
            }
        });
    });
</script>
