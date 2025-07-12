 
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        var successMessage = localStorage.getItem('successMessage');
        if (successMessage) {
            toastr.success(successMessage); // Show toastr notification
            localStorage.removeItem('successMessage'); // Clear message after displaying
        }
    });

</script>