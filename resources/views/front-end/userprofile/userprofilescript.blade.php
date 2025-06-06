 
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        var successMessage = localStorage.getItem('successMessage');
        if (successMessage) {
            toastr.success(successMessage); // Show toastr notification
            localStorage.removeItem('successMessage'); // Clear message after displaying
        }
    });

// $(document).on("click", ".erp-profile-form", function(e) {
//     e.preventDefault();
//     var submitUrl = $('#profile_form').data("url");
//     var formData = new FormData($('#profile_form')[0]);
//     // console.log(FormData);

//     $.ajaxSetup({
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         }
//     });
    
//     function handleErrorMessages(errors) {
//         $('#firstname_error').text(errors.firstname ? errors.firstname : '');
//         $('#lastname_error').text(errors.lastname ? errors.lastname : '');
//         $('#email_error').text(errors.email ? errors.email : '');
//         $('#contact_error').text(errors.contact ? errors.contact : '');
//         $('#company_name_error').text(errors.company_name ? errors.company_name : '');
//         $('#company_website_error').text(errors.company_website ? errors.company_website : '');
//         $('#city_error').text(errors.city ? errors.city : '');
//         $('#postal_error').text(errors.postal ? errors.postal : '');
//         $('#address_line_one_error').text(errors.address_line_one ? errors.address_line_one : '');
//         $('#profile_pic_error').text(errors.profile_pic ? errors.profile_pic : '');
//     }


//     if (!$('.form-control').hasClass('is-invalid')) {
//         $("#preloader").show();
//         $.ajax({
//             url: submitUrl,
//             type: "POST",
//             data: formData,
//             contentType: false,
//             processData: false,
//             dataType: 'json',
//             success: function(response) {
//                 $("#preloader").hide();
//                 $('.input-error').removeClass('is-invalid');
//                 if (response.success) {
//                     localStorage.setItem('successMessage', response.success);
//                     window.location.href = "{{ route('profile') }}";
//                     // toastr.success(response.success);
//                 } else if (response.error) {
//                     $.each(response.error, function(key, value) {
//                         toastr.error(value);
//                     });
//                     handleErrorMessages(response.error); // Ensure this function handles validation errors correctly
//                 }
//             },
//             error: function(error) {
//                 console.error('Ajax request failed:', error);
//                 $("#preloader").hide();
//             }
//         });
//     }
// });


// JavaScript/jQuery code to validate ERP Profile Form

//   $(document).ready(function () {
//     const form = $('#profile_form');
//     const submitBtn = $('.erp-profile-form');
//     const inputFields = form.find('.form-control').not('#profile_pic');

//     function updateFloatingLabel(input) {
//         const label = $(input).next('label');
//         const errorDiv = $('#' + input.id + '_error');

//         if ($(input).val().trim() !== '') {
//             label.css({ top: '-1%', fontSize: '0.8rem', color: '#70657b' });
//             $(input).css('border-color', '#ccc');
//         } else if (errorDiv.text().trim() !== '') {
//             label.css({ top: '35%', fontSize: '1rem', color: 'red' });
//             $(input).css('border-color', 'red');
//         } else {
//             label.css({ top: '50%', fontSize: '1rem', color: '#70657b' });
//             $(input).css('border-color', '#ccc');
//         }
//     }

//     function validateInput(input) {
//         const errorDiv = $('#' + input.id + '_error');
//         const value = $(input).val().trim();
//         const name = input.name.replace(/_/g, ' ');

//         if (!value) {
//             errorDiv.text(`${name} is required!`).show();
//             $(input).css('border-color', 'red');
//             updateFloatingLabel(input);
//             return false;
//         }

//         if (input.type === 'email' && !/^\S+@\S+\.\S+$/.test(value)) {
//             errorDiv.text('Please enter a valid email address!').show();
//             $(input).css('border-color', 'red');
//             updateFloatingLabel(input);
//             return false;
//         }

//         if (input.id === 'firstname' && !/^[a-zA-Z\s]+$/.test(value)) {
//             errorDiv.text('Only letters and spaces are allowed!').show();
//             $(input).css('border-color', 'red');
//             updateFloatingLabel(input);
//             return false;
//         }

//         if (input.id === 'contact' && !/^\d{10}$/.test(value)) {
//             errorDiv.text('Contact number must be 10 digits!').show();
//             $(input).css('border-color', 'red');
//             updateFloatingLabel(input);
//             return false;
//         }

//         errorDiv.text('').hide();
//         $(input).css('border-color', '#ccc');
//         updateFloatingLabel(input);
//         return true;
//     }

//     inputFields.each(function () {
//         updateFloatingLabel(this);
//         $(this).on('blur input', () => validateInput(this));

//         $(this).on('focus', function () {
//             const label = $(this).next('label');
//             const errorDiv = $('#' + this.id + '_error');
//             label.css({ top: '-1%', fontSize: '0.8rem', color: '#70657b' });
//             $(this).css('border-color', '#ccc');
//             if (errorDiv.text().trim() !== '') {
//                 label.css('color', 'red');
//                 $(this).css('border-color', 'red');
//             }
//         });
//     });

//     function sendAjaxRequest(formData, url) {
//         $('#preloader').show();
//         $.ajax({
//             url: url,
//             type: 'POST',
//             data: formData,
//             processData: false,
//             contentType: false,
//             success: function (response) {
//                 $('#preloader').hide();
//                 if (response.success) {
//                     toastr.success(response.success);
//                     setTimeout(() => location.reload(), 1500);
//                 } else if (response.error) {
//                     $.each(response.error, function (key, value) {
//                         $(`#${key}_error`).text(value).show();
//                         $(`#${key}`).css('border-color', 'red');
//                         $(`#${key}`).next('label').css({ color: 'red' });
//                     });
//                 }
//             },
//             error: function () {
//                 $('#preloader').hide();
//                 toastr.error('An error occurred. Please try again.');
//             }
//         });
//     }

//     submitBtn.on('click', function (e) {
//         e.preventDefault();
//         let formIsValid = true;

//         inputFields.each(function () {
//             if (!validateInput(this)) formIsValid = false;
//         });

//         if (!formIsValid) {
//             let firstError = $('.error:visible').first();
//             if (firstError.length) {
//                 firstError[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
//             }
//             return;
//         }

//         const formData = new FormData(form[0]);
//         const url = form.data('url');
//         sendAjaxRequest(formData, url);
//     });
// });

</script>