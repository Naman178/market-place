<script>
    $(document).ready(function() {
        $(".items-status-dropdown").on("change", function() {
            let itemId = $(this).data("id");
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
                            id: itemId,
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
    

        $('body').on('change', '.image-input', function(e) {
            var obj = $(this).closest('.input-file-col');
            obj.find('.error').text("");
            obj.find('.image-input-wrapper').removeClass('is-invalid');
            var imageInputWrapper = $(this).closest('.image-input-wrapper');
            var imgprevid = imageInputWrapper.find('.hidepreviewimg').attr('data-title');
            var prevtitle = imageInputWrapper.find('.title').attr('data-title');
            console.log(imgprevid);
            console.log(prevtitle);
            obj.find('.image-input-wrapper').find('.'+imgprevid).hide();
            var labelVal = $("#"+prevtitle).text();
            var oldfileName = $(this).val();
            fileName = e.target.value.split( '\\' ).pop();
            if (oldfileName == fileName) {return false;}
            var extension = fileName.split('.').pop();
            if ($.inArray(extension,['jpg','jpeg','png']) >= 0) {
                obj.find('.image-input-wrapper').find('.'+imgprevid).show();
                readURL(this,imgprevid, imageInputWrapper);
            }
            else{
                obj.find('.error').text("Please upload valid image");
                obj.find('.image-input-wrapper').addClass("is-invalid");
                obj.find('.image-input-wrapper').find('.title').text("");
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
        function readURL(input, previd, imageInputWrapper) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    imageInputWrapper.find('.' + previd).prop("src", e.target.result);
                    imageInputWrapper.find('.' + previd).hide();
                    imageInputWrapper.find('.' + previd).fadeIn(650);
                };
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

        /*  $('#tags').tagify(); */
        $('#add-feature').on('click', function () {
            var newContactField = '{!! Form::text("key_feature[]", null, array("placeholder" => "Enter key feature","class" => "form-control mb-3" , "id" => "key_feature")) !!}';
            $(this).closest('#item_form').find('.feature-input').append(newContactField);
        });

        $('#add-image').on('click', function () {
            var newContactField = '<label class="form-control mb-3 filelabel image-input-wrapper"><input type="file" name="item_images[]" class="image-input form-control input-error"><span class="btn btn-outline-primary"><i class="i-File-Upload nav-icon font-weight-bold cust-icon"></i>Choose File</span><img class="previewImgCls hidepreviewimg" src="" data-title="previewImgCls"><span class="title" data-title="title"></span></label>';
            $(this).closest('#item_form').find('.image-input-col').append(newContactField);
        });
}) 
</script>
