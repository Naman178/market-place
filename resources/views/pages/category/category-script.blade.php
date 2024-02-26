<script>
    $(document).ready(function() {
        $(".category-status-dropdown").on("change", function() {
            let categoryId = $(this).data("id");
            let status = $(this).val();
            let dropdown = $(this);

            Swal.fire({
                title: `Are You Want To ${status == 1 ? "Inactivate" : "Activate"} This Category?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4caf50',
                cancelButtonColor: '#f44336',
                confirmButtonText: 'Yes'
            }).then(({
                isConfirmed
            }) => {
                if (isConfirmed) {

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    })
                    $.ajax({
                        method: "POST",
                        url: $(this).data("url"),
                        data: {
                            id: categoryId,
                            status: status
                        },
                        success: ({
                            data
                        }) => {
                            // if (data.sys_state === "1") {
                            //     dropdown.siblings(".status-bagde").addClass(
                            //         "badge-danger");
                            //     dropdown.siblings(".status-bagde").removeClass(
                            //         "badge-success");
                            //     dropdown.siblings(".status-bagde").text("Inactive");
                            // } else if (data.sys_state === "0") {
                            //     dropdown.siblings(".status-bagde").addClass(
                            //         "badge-success");
                            //     dropdown.siblings(".status-bagde").removeClass(
                            //         "badge-danger");
                            //     dropdown.siblings(".status-bagde").text("Active");
                            // }
                            window.location.reload();
                        }
                    });
                }
            });
        })
    })
</script>
