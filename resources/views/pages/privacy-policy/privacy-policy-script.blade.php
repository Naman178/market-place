<script>
    $('.privacy-policy-delete-btn').click(function(event) {
        event.preventDefault();
        var submitURL = $(this).attr("data-url");
        Swal.fire({
            title: 'Are you sure you want to delete this privacy policy?',
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
</script>
