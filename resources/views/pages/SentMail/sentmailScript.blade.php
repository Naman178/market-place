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
    $(document).on('click', '.email-form-btn', function(e) {
        e.preventDefault();
        let selectedEmails = $("#emailSelect").val() || [];
        let manualEmail = $("#manualEmail").val().trim();
        let subject = $('#mailSubject').val().trim();
        let selectedAllUsers = $("#select_all").is(':checked');
        let selectedAllNewsletter = $("#select_all_newsletter").is(':checked');

        if (manualEmail) {
            selectedEmails = Array.isArray(selectedEmails) ? [...selectedEmails, manualEmail] : [manualEmail];
        }

        let template = $("input[name='template']:checked").val();
        let desc = window.descEditor.root.innerHTML;
        $.ajax({
            url: "{{ route('email-store') }}",
            type: 'POST',
            data: {
                '_token': "{{ csrf_token() }}",
                "desc": desc,
                'template': template,
                'email' : selectedEmails,
                'subject': subject,
                'all_users': selectedAllUsers ? 1 : 0,
                'all_newsletter': selectedAllNewsletter ? 1 : 0
            },
            success: function(data) {
                console.log(data);
                location.reload();
            }
        })
    });
</script>