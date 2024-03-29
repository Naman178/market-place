<script>
    $(document).ready(function() {
        $('.select-input').select2();
        $(document).find(".items-status-dropdown").on("change", function() {
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

        $(document).on('change', '.image-input', function(e) {
            var obj = $(this).closest('.input-file-col');
            var imageInputWrapper = $(this).closest('.image-input-label');
            var imgprevid = imageInputWrapper.find('.previewImgCls').attr('data-title');
            var prevtitle = imageInputWrapper.find('.title').attr('data-title');
            var fileName = e.target.value.split('\\').pop();

            obj.find('.' + imgprevid).hide();

            if (fileName) {
                if (fileName.length > 50) {
                    imageInputWrapper.find('.' + prevtitle).text(fileName.slice(0, 4) + '...' + extension);
                } else {
                    imageInputWrapper.find('.' + prevtitle).text(fileName);
                }
            } else {
                var labelVal = imageInputWrapper.find('.' + prevtitle).text();
                imageInputWrapper.find('.' + prevtitle).text(labelVal);
            }

            var extension = fileName.split('.').pop();

            if ($.inArray(extension, ['jpg', 'jpeg', 'png']) >= 0) {
                readURL($(this), imgprevid, imageInputWrapper);
                obj.find('.' + imgprevid).each(function() {
                    if ($(this).attr('src') !== '') {
                        $(this).show();
                    }
                });
            } else {
                obj.find('.error').text("Please upload a valid image");
                imageInputWrapper.addClass("is-invalid");
                imageInputWrapper.find('.title').text("");
                return false;
            }
        });

        /* General function for image prev */
        function readURL(input, previd, imageInputWrapper) {
            if (input[0].files && input[0].files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    imageInputWrapper.find('.' + previd).prop("src", e.target.result);
                    imageInputWrapper.find('.' + previd).hide();
                    imageInputWrapper.find('.' + previd).fadeIn(650);
                };
                reader.readAsDataURL(input[0].files[0]);
            }
        }

        $(document).on('change', '.file-input', function(e) {
            var obj = $(this).closest('.input-file-col');
            var imageInputWrapper = obj.find('.file-input-label');
            var prevtitle = imageInputWrapper.find('.title').attr('data-title');
            var fileName = e.target.value.split('\\').pop();

            if (fileName) {
                if (fileName.length > 50) {
                    imageInputWrapper.find('.' + prevtitle).text(fileName.slice(0, 4) + '...' + extension);
                } else {
                    imageInputWrapper.find('.' + prevtitle).text(fileName);
                }
            } else {
                var labelVal = imageInputWrapper.find('.' + prevtitle).text();
                imageInputWrapper.find('.' + prevtitle).text(labelVal);
            }

            var extension = fileName.split('.').pop();

            if ($.inArray(extension, ['zip']) >= 0) {
                return true;
            } else {
                obj.find('.error').text("Please upload a valid file");
                imageInputWrapper.addClass("is-invalid");
                imageInputWrapper.find('.' + prevtitle).text("");
                return false;
            }
        });

        $(document).on('click', '#add-image', function(e) {
            var newImageField = '<div class="row input-row image-input-row"><div class="col-9"><label class="form-control filelabel mb-3 image-input-label"><input type="file" name="item_images[]" id="item_images"  class=" image-input form-control input-error"><span class="btn btn-outline-primary"><i class="i-File-Upload nav-icon font-weight-bold cust-icon"></i>Choose File</span><img id="item_images_prev" class="previewImgCls hidepreviewimg" src="" data-title="previewImgCls"><span class="title" id="item_images_title" data-title="title"></span></label></div><div class="col-3"><div class="remove-btn"><span class="close-icon" aria-hidden="true">&times;</span></div></div></div>';
            $(this).closest('#item_form').find('.image-input-wrapper').append(newImageField);
        });

        $(document).on('click', '.delete-btn', function(e) {
            e.preventDefault();
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

        $(document).on('click', '#add-feature', function(e) {
            var featureWrapper = $(this).closest('.add-more-input').find('.feature-input-wrapper');
            var newFeatureFiled = `
                <div class="row input-row feature-input-row">
                    <div class="col-9">
                        {!! Form::text('key_feature[]', null, array('placeholder' => 'Enter key feature','class' => 'form-control mb-3' , 'id' => 'key_feature')) !!}
                    </div>
                    <div class="col-3">
                        <div class="remove-btn">
                            <span class="close-icon" aria-hidden="true">&times;</span>
                        </div>
                    </div>
                </div>
            `;

            featureWrapper.append(newFeatureFiled);
        });

        $(document).on('click', '.remove-btn', function(e) {
            var removedRow = $(this).closest('.input-row');
            var featureWrapper = removedRow.closest('.feature-input-wrapper');
            removedRow.remove();
        });

        $(document).on('change', '#category_id', function(e) {
            var categoryId = $(this).val();
            if (categoryId) {
                $.ajax({
                    type: 'POST',
                    url: '{{ route("get-subcategory") }}',
                    data: {'category_id': categoryId, '_token': '{{ csrf_token() }}'},
                    dataType: 'json',
                    success: function (data) {
                        $('#subcategory_id').empty();

                        if (data.length > 0) {
                            $('#subcategory_id').append('<option value="">Select subcategory</option>');
                            $.each(data, function (key, value) {
                                $('#subcategory_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                            });
                        } else {
                            $('#subcategory_id').append('<option value="">No subcategories found</option>');
                        }

                        // Refresh Select2
                        $('#subcategory_id').select2('destroy').select2();
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            } else {
                $('#subcategory_id').empty();
                $('#subcategory_id').append('<option value="">Select subcategory</option>');
                $('#subcategory_id').select2('destroy').select2();
            }
        });

        if (window.location.href.indexOf('edit') !== -1) {
            $('#subcategory_id option.d-none').remove();
        }

        $(document).on('blur', '.price-input', function (e) {
            var gst = parseFloat($(document).find('#item_gst_percentage').val());
            var fixed_price = parseFloat($(document).find('#item_fixed_price').val());
            var sale_price = parseFloat($(document).find('#item_sale_price').val());
            if (!(isNaN(gst))) {
                if (!isNaN(sale_price)) {
                    var gst_amount = (sale_price * gst) / 100;
                    $(document).find('#gst_amount').html("GST Amount: <strong><span>" + gst_amount.toFixed(2) + "</span></strong>");
                }
            }
        });
    }) ;
</script>
