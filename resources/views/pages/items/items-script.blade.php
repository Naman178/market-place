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
            var featureWrapper = $(this).closest('.add-more-input').find('.image-input-wrapper');
            var order = featureWrapper.find('.input-row').length + 1;
            
            var newImageField = `<div class="row input-row image-input-row"  data-order="${order}"><div class="col-9"><label class="form-control filelabel mb-3 image-input-label"><input type="file" name="item_images[]" id="item_images"  class=" image-input form-control input-error"><span class="btn btn-outline-primary"><i class="i-File-Upload nav-icon font-weight-bold cust-icon"></i>Choose File</span><img id="item_images_prev" class="previewImgCls hidepreviewimg" src="" data-title="previewImgCls"><span class="title" id="item_images_title" data-title="title"></span></label></div><div class="col-3"><div class="remove-btn"><span class="close-icon" aria-hidden="true">&times;</span></div></div></div>`;
            featureWrapper.append(newImageField);
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
            var order = featureWrapper.find('.input-row').length + 1;

            var newFeatureFiled = `
                <div class="row input-row feature-input-row" data-order="${order}">
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
            var addMoreWrapper = removedRow.closest('.add-more-wrapper');
            removedRow.remove();
            addMoreWrapper.find('.input-row').each(function(index) {
                $(this).attr('data-order', index + 1);
            });
        });

        var subcategorySelect = $('.subcategory-select');
        var originalOptions = subcategorySelect.find('option:not([value=""])').clone();
        $(document).on('change', '#category_id', function(e) {
            var selectedCategory = $(this).val();
            subcategorySelect.find('option:not([value=""])').remove();
            originalOptions.filter(function() {
                return $(this).data('category') == selectedCategory || $(this).data('category') === undefined;
            }).appendTo(subcategorySelect);
            subcategorySelect.select2();
            subcategorySelect.val('').trigger('change.select2');
        });
        
        $(document).on('blur', '.price-input', function (e) {
            var gst = parseFloat($(document).find('#item_gst_percentage').val());
            var fixed_price = parseFloat($(document).find('#item_fixed_price').val());
            var sale_price = parseFloat($(document).find('#item_sale_price').val());

            if (!(isNaN(gst))) {
                if (isNaN(sale_price)) {
                    var gst_amount = (fixed_price * gst) / 100;
                    $(document).find('#gst_amount').html("GST Amount: <strong><span>" + gst_amount.toFixed(2) + "</span></strong>");
                } else {
                    var gst_amount = (fixed_price - sale_price) * (gst / (100 + gst));
                    $(document).find('#gst_amount').html("GST Amount: <strong><span>" + gst_amount.toFixed(2) + "</span></strong>");
                }
            }
        });
    }) ;
</script>
