<script>
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
            $('#category_image_title').text("");
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
        var id = $(this).attr("data-id");
        Swal.fire({
            title: 'Are you sure you want to delete this category?',
            //text: 'If you delete this, it will be gone forever.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#4caf50',
            cancelButtonColor: '#f44336',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route('category-delete', '') }}/" + id;
            }
        });
    });
</script>