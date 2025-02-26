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
            var newImageField = '<div class="row input-row image-input-row"><div class="col-11"><label class="form-control filelabel mb-3 image-input-label"><input type="file" name="item_images[]" id="item_images"  class=" image-input form-control input-error"><span class="btn btn-outline-primary"><i class="i-File-Upload nav-icon font-weight-bold cust-icon"></i>Choose File</span><img id="item_images_prev" class="previewImgCls hidepreviewimg" src="" data-title="previewImgCls"><span class="title" id="item_images_title" data-title="title"></span></label></div><div class="col-1"><div class="btn btn-outline-primary remove-btn">Delete</div></div></div>';
            $val = $(this).data('id');
            if($val == 'recurring'){
                $(this).closest('.card').find('.image-input-wrapper').append(newImageField);
            }else{
                $(this).closest('#item_form').find('.image-input-wrapper').append(newImageField);
            }
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
                    <div class="col-11">
                        {!! Form::text('key_feature[]', null, array('placeholder' => 'Enter key feature','class' => 'form-control mb-3' , 'id' => 'key_feature')) !!}
                    </div>
                    <div class="col-1">
                        <div class="btn btn-outline-primary remove-btn">
                            Delete
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
            // var gst = parseFloat($(this).closest('#item_form').find('#item_gst_percentage').val());
            // var fixed_price = parseFloat($(this).closest('#item_form').find('#item_fixed_price').val());
            // var sale_price = parseFloat($(this).closest('#item_form').find('#item_sale_price').val());
            // if (!(isNaN(gst))) {
            //     if (!isNaN(sale_price)) {
            //         var gst_amount = (sale_price * gst) / 100;
            //         $(this).closest('#item_form').find('#gst_amount').html("GST Amount: <strong><span>" + gst_amount.toFixed(2) + "</span></strong>");
            //     }
            // }

            var gst = parseFloat($(this).closest('.card').find('#item_gst_percentage').val());
            var fixed_price = parseFloat($(this).closest('.card').find('#item_fixed_price').val());
            var sale_price = parseFloat($(this).closest('.card').find('#item_sale_price').val());
            if (!(isNaN(gst))) {
                if (!isNaN(sale_price)) {
                    var gst_amount = (sale_price * gst) / 100;
                    $(this).closest('.card').find('#gst_amount').html("GST Amount: <strong><span>" + gst_amount.toFixed(2) + "</span></strong>");
                }
            }
        });

        $(document).on('click','#addrecurringcardbtn',function(e){
            $val = $('#addrecurringcardoption .card').length;
            var html = `
                <div class="card mb-3">
                    <div class="card-body">
                        <form class="erp-item-submit" id="item_form" data-url="{{route('items-subitem-store')}}" data-id="uid" data-name="name" data-email="email" data-pass="password">
                            <input type="hidden" name="sub_id" value=${$val}>
                            <div class="col-md-12 form-group add-more-input">
                                <div class="row">
                                    <div class="col-6">
                                        <h5 for="key_feature_label">Features</h5>
                                    </div>
                                    <div class="col-6 text-right">
                                    <button type="button" class="btn btn-outline-primary" id="add-feature">Add Feature</button>
                                    </div>
                                </div>
                                <div class="add-more-wrapper feature-input-wrapper">
                                    <div class="row input-row feature-input-row" data-order='1'>
                                        <div class="col-9">
                                            {!! Form::text('key_feature[]', null, array('placeholder' => 'Enter key feature','class' => 'form-control mb-3' , 'id' => 'key_feature')) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="error" style="color:red;" id="feature_error"></div>
                            </div>

                            <div class="col-md-12 form-group input-file-col add-more-input">
                                <div class="row">
                                    <div class="col-6">
                                        <h5>Images</h5>
                                    </div>
                                    <div class="col-6 text-right">
                                        <button type="button" class="btn btn-outline-primary" id="add-image">Add Image</button>
                                    </div>
                                </div>
                                <div class="add-more-wrapper image-input-wrapper">
                                    <div class="row input-row image-input-row" data-order='1'>
                                        <div class="col-9">
                                            <label class="form-control filelabel mb-3 image-input-label">
                                                <input type="file" name="item_images[]" id="item_images"  class=" image-input form-control input-error">
                                                <span class="btn btn-outline-primary"><i class="i-File-Upload nav-icon font-weight-bold cust-icon"></i>Choose File</span>
                                                <img id="item_images_prev" class="previewImgCls hidepreviewimg" src="" data-title="previewImgCls">
                                                <span class="title" id="item_images_title" data-title="title"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 form-group billingcyclecontainer" id="billingcyclecontainer">
                                <h5>Billing Cycle</h5>
                                <select name="itembillingcycle" id="itembillingcycle" class="form-control itembillingcycle select2" style="width: 100%;">
                                    <option value="monthly">Monthly</option>
                                    <option value="quarterly">Quarterly</option>
                                    <option value="yearly">Yearly</option>
                                    <option value="custom">Custom</option>
                                </select>
                            </div>

                            <div class="col-md-12 form-group customBillingCycleContainer" id="customBillingCycleContainer" style="display:none;">
                                <h5>Custom Billing Cycle</h5>
                                <input type="text" name="custombillingcycle" id="custombillingcycle" placeholder="Enter Custom Billing Cycle" class="form-control custombillingcycle">
                            </div>

                            <div class="col-md-12 col-12 form-group autorenewalcontainer" id="autorenewalcontainer">
                                <h5>Auto Renewal</h5>
                                <label class="switch switch-primary me-3">
                                    <input type="checkbox" checked="" name="autorenewalcheckbox" id="autorenewalcheckbox">
                                    <span class="slider"></span>
                                </label>
                            </div>

                            <div class="col-md-12 col-12 form-group graceperiodcontianer" id="graceperiodcontianer">
                                <h5>Grace Period</h5>
                                <input type="text" name="graceperiod" id="graceperiod" class="form-control">
                            </div>

                            <div class="col-md-12 form-group">
                                <h5>Pricing</h5>
                                <div class="row">
                                    <div class="col-md-4">
                                        {!! Form::text('fixed_price', null, array('placeholder' => 'Enter fixed price','class' => 'form-control price-input input-error' , 'id' => 'item_fixed_price')) !!}
                                        <div class="error" style="color:red;" id="fixed_price_error"></div>
                                    </div>
                                    <div class="col-md-4">
                                        {!! Form::text('sale_price', null, array('placeholder' => 'Enter sale price','class' => 'form-control price-input input-error' , 'id' => 'item_sale_price')) !!}
                                        <div class="error" style="color:red;" id="sale_price_error"></div>
                                    </div>
                                    <div class="col-md-4">
                                        {!! Form::text('gst_percentage', null, array('placeholder' => 'Enter GST %','class' => 'form-control price-input input-error' , 'id' => 'item_gst_percentage')) !!}
                                        <div class="error" style="color:red;" id="gst_percentage_error"></div>
                                        <div class="gst-amount" id="gst_amount"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 form-group text-right">
                                <button type="button" class="btn btn-outline-primary removerecurringcardbtn" id="removerecurringcardbtn">Remove card</button>
                                <button type="submit" class="btn btn-outline-primary saverecurringcardbtn" id="saverecurringcardbtn">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            `;
            $('#addrecurringcardoption').append(html);
        });

        $(document).on('click','#removerecurringcardbtn',function(){
            $(this).closest('.card').remove()
        });

        $(document).on('change','#item_type',function () {
            $.ajax({
                url: "{{ route('update.item.pricing') }}",
                type: 'POST',
                data: {
                    item_id: $('#item_id').val(),
                    pricing_type: $(this).val(),
                    _token: '{{ csrf_token() }}'
                },
                success: function () {
                    window.location.reload();
                },
            });
        });
    }) ;
</script>
