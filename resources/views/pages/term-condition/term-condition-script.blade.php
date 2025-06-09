<script>
    $('.term-condition-delete-btn').click(function(event) {
        event.preventDefault();
        var submitURL = $(this).attr("data-url");
        Swal.fire({
            title: 'Are you sure you want to delete this term & condition?',
            //text: 'If you delete this, it will be gone forever.',
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
    $(document).ready(function () {
        var quill = new Quill('#quill_editor', {
            theme: 'snow',
            placeholder: 'Write something...',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, false] }],
                    ['bold', 'italic', 'underline'],
                    ['blockquote', 'code-block'],
                    [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                    [{ 'indent': '-1' }, { 'indent': '+1' }],
                    [{ 'align': [] }],
                    ['clean']
                ]
            }
        });

        quill.on('text-change', function () {
            const content = quill.root.innerHTML;
            $('#description').val(content);

            // Remove validation error if user modifies content
            if (content.trim() !== '') {
                $('#description_error').text('');
                $('#description').removeClass('is-invalid');
            }
        });
    });
</script>
