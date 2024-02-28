<script>
    $(document).ready(function() {
        $(".items-status-dropdown").on("change", function() {
            let categoryId = $(this).data("id");
            let status = $(this).val();
            let dropdown = $(this);

            Swal.fire({
                title: `Are You Want To ${status == 1 ? "Activate" : "Inactivate"} This Item?`,
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

    $('body').on('change', 'input[name="image"]', function(e) {
        $('#image_error').text("");
        $('.image-input-wrapper').removeClass('is-invalid');
        var imgprevid = $(this).siblings('.hidepreviewimg').attr('id');
        var prevtitle = $(this).siblings('.title').attr('id');
        console.log(imgprevid);
        console.log(prevtitle);
        $('#'+imgprevid).hide();
        var labelVal = $("#"+prevtitle).text();
        var oldfileName = $(this).val();
        fileName = e.target.value.split( '\\' ).pop();
        if (oldfileName == fileName) {return false;}
        var extension = fileName.split('.').pop();
        if ($.inArray(extension,['jpg','jpeg','png']) >= 0) {
            $('#'+imgprevid).show();
            readURL(this,imgprevid);
        }
        else{
            $('#image_error').text("Please upload valid image");
            $('.image-input-wrapper').addClass("is-invalid");
            $('.title').text("");
            return false;
        }
        if(fileName){
            if (fileName.length > 50){
                $("#"+prevtitle).text(fileName.slice(0,4)+'...'+extension);
            }
            else{
                $("#"+prevtitle).text(fileName);
            }
        }
        else{
            $("#"+prevtitle).text(labelVal);
        }

    });
    /* General function for image prev */
    function readURL(input,previd) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#'+previd).prop("src", e.target.result);
                $('#'+previd).hide();
                $('#'+previd).fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $('.delete-btn').click(function(event) {
        event.preventDefault();
        var submitURL = $(this).attr("data-url");
        Swal.fire({
            title: 'Are you sure you want to delete this item?',
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

    /* $('.tagBox').tagging(); */
    /* tinymce.init({
        selector: 'textarea#html_description', 
        height: 300,
        plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table paste code help wordcount'
        ],
        toolbar: 'undo redo | formatselect | ' +
            'bold italic backcolor | alignleft aligncenter ' +
            'alignright alignjustify | bullist numlist outdent indent | ' +
            'removeformat | help',
        content_css: '//www.tiny.cloud/css/codepen.min.css'
    }); */
</script>
