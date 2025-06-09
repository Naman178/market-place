<script>
    window.descEditor = new Quill('#desc', {
        theme: 'snow'
    });
    $(document).on('click', '.email-form-preview', function(e) {
        $('#preloader').show();
        e.preventDefault();
        let selectedEmails = $("#emailSelect").val() || [];
        let manualEmail = $("#manualEmail").val().trim(); 
        if (manualEmail) {
            selectedEmails  = manualEmail
        }
        let subject = $('#mailSubject').val();

        let template = $("input[name='template']:checked").val();
        let desc = window.descEditor.root.innerHTML;
        $.ajax({
            url: "{{ route('email-preview') }}",
            type: 'POST',
            data: {
                '_token': "{{ csrf_token() }}",
                "desc": desc,
                'template': template,
                'email' : selectedEmails,
                'subject': subject
            },
            success: function(data) {
                $('#preloader').hide();
                $('#preview-container').html(data);
                $('#preview-modal').modal('show');
            }
        });
    });
    // $(document).on('click', '.email-form-btn', function(e) {
    //     e.preventDefault();
    //     let selectedEmails = $("#emailSelect").val() || [];
    //     let manualEmail = $("#manualEmail").val().trim();
    //     let subject = $('#mailSubject').val().trim();
    //     let selectedAllUsers = $("#select_all").is(':checked');
    //     let selectedAllNewsletter = $("#select_all_newsletter").is(':checked');

    //     if (manualEmail) {
    //         selectedEmails = Array.isArray(selectedEmails) ? [...selectedEmails, manualEmail] : [manualEmail];
    //     }

    //     let template = $("input[name='template']:checked").val();
    //     let desc = window.descEditor.root.innerHTML;
    //     $.ajax({
    //         url: "{{ route('email-store') }}",
    //         type: 'POST',
    //         data: {
    //             '_token': "{{ csrf_token() }}",
    //             "desc": desc,
    //             'template': template,
    //             'email' : selectedEmails,
    //             'subject': subject,
    //             'all_users': selectedAllUsers ? 1 : 0,
    //             'all_newsletter': selectedAllNewsletter ? 1 : 0
    //         },
    //         success: function(data) {
    //             console.log(data);
    //             location.reload();
    //         }
    //     })
    // });
   function handleFormErrors(errors) {
        $('.error').remove();
        $('.is-invalid').removeClass('is-invalid');

        if (errors['email']) {
            $('#emailSelect').addClass('is-invalid');
            $('#emailSelect').next('.select2-container').after(`<div class="error text-danger">${errors['email'][0]}</div>`);
        }

        if (errors['manualEmail']) {
            $('#manualEmail').addClass('is-invalid');
            $('#manualEmail').after(`<div class="error text-danger">${errors['manualEmail'][0]}</div>`);
        }

        if (errors['subject']) {
            $('#mailSubject').addClass('is-invalid');
            $('#mailSubject').after(`<div class="error text-danger">${errors['subject'][0]}</div>`);
        }

        if (errors['template']) {
            $("input[name='template']").last().after(`<div class="error text-danger">${errors['template'][0]}</div>`);
        }

        if (errors['desc']) {
            $('#maildesc').after(`<div class="error text-danger">${errors['desc'][0]}</div>`);
        }

    }

    // Remove error when user changes input
    $(document).on('input change', '#manualEmail, #mailSubject', function () {
        $(this).removeClass('is-invalid');
        $(this).next('.error').remove();
    });

    // For select2 (emailSelect)
    $('#emailSelect').on('change', function () {
        $(this).removeClass('is-invalid');
        $(this).next('.select2-container').next('.error').remove();
    });

    descEditor.on('text-change', function () {
        const content = descEditor.root.innerHTML.trim();
        if (content !== '') {
            $('#maildesc').next('.error').remove();
        }
    });


    $(document).on('click', '.email-form-btn', function(e) {
        e.preventDefault();

        let selectedEmails = $("#emailSelect").val() || [];
        let manualEmail = $("#manualEmail").val().trim();
        let subject = $('#mailSubject').val().trim();
        let selectedAllUsers = $("#select_all").is(':checked');
        let selectedAllNewsletter = $("#select_all_newsletter").is(':checked');
        let template = $("input[name='template']:checked").val();
        let desc = window.descEditor.root.innerHTML;

        if (manualEmail) {
            selectedEmails.push(manualEmail);
        }

        // Clear errors before AJAX
        $('.error').remove();
        $('.is-invalid').removeClass('is-invalid');

        $.ajax({
            url: "{{ route('email-store') }}",
            type: 'POST',
            data: {
                '_token': "{{ csrf_token() }}",
                'desc': desc,
                'template': template,
                'email': selectedEmails,
                'manualEmail': manualEmail,
                'subject': subject,
                'emailOption': $("input[name='emailOption']:checked").val(),
                'all_users': selectedAllUsers ? 1 : 0,
                'all_newsletter': selectedAllNewsletter ? 1 : 0
            },
            success: function(response) {
                console.log(response);
                if(response.error) {
                    handleFormErrors(response.error);
                }
                else if(response.success) {
                  location.reload();
                }
            },
            error: function(error) {
                console.error('Ajax request failed:', error);
            }
        });
    });

</script>