 
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        var successMessage = localStorage.getItem('successMessage');
        if (successMessage) {
            toastr.success(successMessage); // Show toastr notification
            localStorage.removeItem('successMessage'); // Clear message after displaying
        }
    });

$(document).on("click", ".erp-profile-form", function(e) {
    e.preventDefault();
    var submitUrl = $('#profile_form').data("url");
    var formData = new FormData($('#profile_form')[0]);
    // console.log(FormData);

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
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
        $('#profile_pic_error').text(errors.profile_pic ? errors.profile_pic : '');
    }


    if (!$('.form-control').hasClass('is-invalid')) {
        $("#preloader").show();
        $.ajax({
            url: submitUrl,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                $("#preloader").hide();
                $('.input-error').removeClass('is-invalid');
                if (response.success) {
                    localStorage.setItem('successMessage', response.success);
                    window.location.href = "{{ route('profile') }}";
                    // toastr.success(response.success);
                } else if (response.error) {
                    $.each(response.error, function(key, value) {
                        toastr.error(value);
                    });
                    handleErrorMessages(response.error); // Ensure this function handles validation errors correctly
                }
            },
            error: function(error) {
                console.error('Ajax request failed:', error);
                $("#preloader").hide();
            }
        });
    }
});


</script>