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
        let selectedEmails = $("#emailSelect").val() || []; // Ensure it's always an array
        let manualEmail = $("#manualEmail").val().trim();
        let subject = $('#mailSubject').val().trim();

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
                'subject': subject
            },
            success: function(data) {
                console.log(data);
                location.reload();
            }
        })
    });
</script>