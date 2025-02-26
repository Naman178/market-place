<div class="modal fade" id="my-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-2" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle-2">Contact Form</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>

<script>

    $(document).ready(function(){
        $('.my-select').each(function(){
            var data_key = $(this).data('my_select2');
            $(this).select2({
                placeholder: "---SELECT---",
                data: xui.select2[data_key]
            });
        });

        $('.erp-modal-button').click(function() {
            var url = $(this).attr('data-url');
            var submit_url = $(this).attr('data-submit-url');
            var entity = $(this).attr('data-entity');
            var entity_id = $(`input[name="${entity}"]`).val();
            var is_new = $(this).attr('data-is-new');
            var select_id = (is_new == "1") ? -1 : $(this).closest(".erp-select2").find('.my-select').val();
            var select_name = $(this).attr('data-name');
            if(select_name == 'dest_addr_id'){
                $('#exampleModalCenterTitle-2').text('Destination Address');
            }
            else if(select_name == 'from_addr_id'){
                $('#exampleModalCenterTitle-2').text('From Address');
            }


            $.ajax({
                url: url,
                type: 'GET',
                data: {entity_id,select_id},
                dataType: 'json',
                success: function(data) {
                    $('#my-modal .modal-body').html(data.modal);
                    $("#my-modal").attr("data-submit-url",submit_url);
                    $("#my-modal").attr("data-name",select_name);
                    $("#my-modal").attr("data-is-new",is_new);
                    $("#my-modal").attr("data-id",entity_id);
                    $('#my-modal').modal('toggle');
                }
            });
        });

        // form submit
        $(document).on("click","#my-modal button.submit-btn", function(e) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            e.preventDefault();
            var data = $(this).closest('form').serialize() + "&id=" + $("#my-modal").attr("data-id");

            $('#my-modal modal-body').html('');
            $('#my-modal').modal('hide');
            var submit_url = $("#my-modal").attr("data-submit-url");

            $.ajax({
                url: submit_url,
                type: 'POST',
                data: data,
                dataType: 'json',
                success: function(data) {
                    var data_name = $("#my-modal").attr("data-name");
                    var select$ = $(`.my-select[name="${data_name}"]`);
                    var data_key = select$.attr("data-my_select2");
                    var is_new = $("#my-modal").attr("data-is-new");
                    if(is_new == "0"){
                        $.each(xui.select2[data_key], function( key, val ) {
                            if(val.id == data.select.id){
                                val.text = data.select.text;
                            }
                        });
                    }else{
                        xui.select2[data_key].push(data.select);
                    }
                    select$.select2('destroy');
                    select$.html('');
                    select$.select2({
                        data: xui.select2[data_key],
                    });
                    select$.val(data.select.id);
                    select$.trigger('change');
                }
            });
        });

        var count = 0;
        $(document).on("click", "#addContact", function(){
            count++;
            var $html = `
            <div class="row row align-items-center contact_single_card">
            <div class="col-md-12">
            <div class="card ul-card__v-space">
                            <div class="card-header header-elements-inline">
                                <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0">
                                    <a data-toggle="collapse" class="text-default" href="#accordion-item-icon-right-1-`+count+`">New Contact</a>
                                </h6>
								<button type="button" id="remove_contact" name="add" class="btn btn-outline-primary btn-icon remove_contact s-acco-btn">
                            		<span class="ul-btn__icon"><i class="i-Close-Window font-weight-bold"></i></span>
                            		<span class="ul-btn__text">Remove</span>
                        		</button>
                            </div>
                        </div>
                        <div class="erp-contact collapse" id="accordion-item-icon-right-1-`+count+`" data-parent="#accordionRightIcon">
                            <div class="card-body">
                                <input type="hidden" class="erp-contact-id" name="cid" value="0" />
                                <div class="row z">
                                    <div class="col-md-4 form-group">
                                        <label for="orderDate">First Name</label>
                                        <input type="text" class="form-control erp-fname" name="fname" />
                                        <div class="error erp-fname-error"></div>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="orderDate">Last Name</label>
                                        <input type="text" class="form-control erp-lname" name="lname" >
                                        <div class="error erp-lname-error"></div>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="orderDate">Is Type</label>
                                        <select class="form-control erp-istype" name="istype">
                                            <option value="0">Person</option>
                                            <option value="1">Company</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="orderDate">Email</label>
                                        <input type="text" class="form-control erp-email" name="email">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="orderDate">Phone 1</label>
                                        <input type="text" class="form-control erp-phone1" name="phone1">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="orderDate">Phone 2</label>
                                        <input type="text" class="form-control erp-phone2" name="phone2">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="orderDate">Fax</label>
                                        <input type="text" class="form-control erp-fax" name="fax">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="orderDate">Address</label>
                                        <input type="text" class="form-control erp-address" name="address">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="orderDate">City</label>
                                        <input type="text" class="form-control erp-city" name="city">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="orderDate">State</label>
                                        <input type="text" class="form-control erp-state" name="state">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="orderDate">Postal Code</label>
                                        <input type="text" class="form-control erp-postal_code" name="postal_code">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="orderDate">Country</label>
                                        <input type="text" class="form-control erp-country" name="country">
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>

                        </div>`;
            $(".erp-contact-card").append($html);
        });

        $(document).on("click", ".erp-contact-form", function(){
            $(".erp-contact-submit").submit();
        });

        $("body").on("click",".remove_contact",function(){
            $(this).parents(".contact_single_card").remove();
        });

        $("body").on("click",".delete_contact",function(){
            $(this).parents(".contact_single_card").remove();
            $("#preloader").show();
            $(".erp-contact-submit").submit();
        });

        $(".erp-contact-submit").validate({
            rules: {
                name: {
                    required: true,
                    remote:{
                        url: $(".erp-contact-submit").attr("data-name-validate-url"),
                        type: "post",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            name: function() {
                                return $(".erp-name").val();
                            },
                            sid: function() {
                                return $(".erp-id").val();
                            }
                        }
                    }
                },
                'code': {
                    required: true,
                    remote:{
                        url: $(".erp-contact-submit").attr("data-code-validate-url"),
                        type: "post",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            code: function() {
                                return $(".erp-code").val();
                            },
                            sid: function() {
                                return $(".erp-id").val();
                            }
                        }
                    }
                }
            },
            messages: {
                name: {
                    required: "Name Is Required",
                    remote: "Name Must Be Unique"
                },
                code: {
                    required: "Code Is Required",
                    remote: "Code Must Be Unique"
                }
            },
            submitHandler: function(form){
                var form$ = $(".erp-contact-submit");
                $("#preloader").show();
                var contactArray = [];
                var submit_url = form$.attr("data-url");
                var data_id = form$.attr("data-id");
                var data_name = form$.attr("data-name");
                var data_code = form$.attr("data-code");

                $(".erp-contact").each(function(){
                    var $div = $(this);
                    var contactid = $div.find(".erp-contact-id").val();
                    // var title = $div.find(".erp-title").val();
                    // var ptitle = $div.find(".erp-p-title").val() ?? '';
                    var fname = $div.find(".erp-fname").val();
                    var pfname = $div.find(".erp-p-fname").val() ?? '';
                    var lname = $div.find(".erp-lname").val();
                    var plname = $div.find(".erp-p-lname").val() ?? '';
                    var istype = $div.find(".erp-istype").val();
                    var pistype = $div.find(".erp-p-istype").val() ?? '';
                    var email = $div.find(".erp-email").val();
                    var pemail = $div.find(".erp-p-email").val() ?? '';
                    var phone1 = $div.find(".erp-phone1").val();
                    var pphone1 = $div.find(".erp-p-phone1").val() ?? '';
                    var phone2 = $div.find(".erp-phone2").val();
                    var pphone2 = $div.find(".erp-p-phone2").val() ?? '';
                    var fax = $div.find(".erp-fax").val();
                    var pfax = $div.find(".erp-p-fax").val() ?? '';
                    var address = $div.find(".erp-address").val();
                    var paddress = $div.find(".erp-p-address").val() ?? '';
                    var city = $div.find(".erp-city").val();
                    var pcity = $div.find(".erp-p-city").val() ?? '';
                    var state = $div.find(".erp-state").val() ?? '';
                    var pstate = $div.find(".erp-p-state").val() ?? '';
                    var postal_code = $div.find(".erp-postal_code").val();
                    var ppostal_code = $div.find(".erp-p-postal_code").val() ?? '';
                    var country = $div.find(".erp-country").val();
                    var pcountry = $div.find(".erp-p-country").val() ?? '';
                    contactArray.push({contactid,fname,lname,istype,email,phone1,phone2,fax,address,city,state,postal_code,country,pfname,plname,pistype,pemail,pphone1,pphone2,pfax,paddress,pcity,pstate,ppostal_code,pcountry});
                });

                $.ajax({
                    url: submit_url,
                    type:"POST",
                    data:{
                        "_token": "{{ csrf_token() }}",
                        id: $(`.erp-id[name="${data_id}"]`).val(),
                        name: $(`.erp-name[name="${data_name}"]`).val(),
                        code: $(`.erp-code[name="${data_code}"]`).val(),
                        // ptitle: $(".erp-p-title").val(),
                        pfname: $(".erp-p-fname").val(),
                        plname: $(".erp-p-lname").val(),
                        pemail: $(".erp-p-email").val(),
                        contactArray: contactArray,
                    },
                    dataType: 'json',
                    success:function(response){
                        if(response.success){
                            // $('.erp-ptitle-error').text('');
                            $('.erp-pfname-error').text('');
                            $('.erp-plname-error').text('');
                            $('.erp-pemail-error').text('');
                            if($(`.erp-id[name=${data_id}`).val() == 0){
                                var url = window.location.href;
                                location.href = url.replace('new',response.data.id);
                            }else{
                                location.reload();
                            }
                        }
                        else if(response.error){
                            $("#preloader").hide();
                            // response.error['ptitle'] ? $('.erp-ptitle-error').text(response.error['ptitle']) : $('.erp-ptitle-error').text('');
                            response.error['pfname'] ? $('.erp-pfname-error').text(response.error['pfname']) : $('.erp-pfname-error').text('');
                            response.error['plname'] ? $('.erp-plname-error').text(response.error['plname']) : $('.erp-plname-error').text('');
                            response.error['pemail'] ? $('.erp-pemail-error').text(response.error['pemail']) : $('.erp-pemail-error').text('');
                        }
                    }
                });
            }
        });

        $(document).on("click", ".erp-user-form", function(){
            $(".erp-user-submit").submit();
            $("#preloader").show();
        });

        $(".erp-user-submit").submit(function (e){
            e.preventDefault();

            var submit_url = $(this).attr("data-url");
            var data_id = $(this).attr("data-id");
            var data_name = $(this).attr("data-name");
            var data_email = $(this).attr("data-email");
            var data_pass = $(this).attr("data-pass");

            $.ajax({
                url: submit_url,
                type:"POST",
                data:{
                    "_token": "{{ csrf_token() }}",
                    id: $('#erp-id').val(),
                    fname: $('#fname').val(),
                    lname: $('#lname').val(),
                    email: $('#email').val(),
                    roles: $('#roles').val(),
                    password: $('#password').val(),
                    confirm_password: $('#confirm_password').val(),
                    status: $('input[name="status"]:checked').val()
                },
                dataType: 'json',
                success:function(response){
                    if(response.success){
                        $('.error').text('');
                        // toastr.info(response.success, response.title);
                        if($(`.erp-id[name=${data_id}`).val() == 0){
                            var url = window.location.href;
                            location.href = url.replace('new',response.data.id);
                        }else{
                            location.reload();
                        }
                    }
                    else if(response.error){
                        $("#preloader").hide();
                        response.error['fname'] ? $('#fname_error').text(response.error['fname']) : $('#fname_error').text('');
                        response.error['fname'] ? $("#fname").addClass("is-invalid") : $("#fname").removeClass("is-invalid");
                        response.error['lname'] ? $('#lname_error').text(response.error['lname']) : $('#lname_error').text('');
                        response.error['fname'] ? $("#lname").addClass("is-invalid") : $("#lname").removeClass("is-invalid");
                        response.error['email'] ? $('#email_error').text(response.error['email']) : $('#email_error').text('');
                        response.error['fname'] ? $("#email").addClass("is-invalid") : $("#email").removeClass("is-invalid");
                        response.error['roles'] ? $('#roles_error').text(response.error['roles']) : $('#roles_error').text('');
                        response.error['fname'] ? $("#password").addClass("is-invalid") : $("#password").removeClass("is-invalid");
                        response.error['password'] ? $('#password_error').text(response.error['password']) : $('#password_error').text('');
                        response.error['confirm_password'] ? $('#confirm_password_error').text(response.error['confirm_password']) : $('#confirm_password_error').text('');
                    }

                }
            });
        });

        $(document).on("click", ".profile_settings_form", function(){
            $("#preloader").show();
            $(".profile_settings_submit").submit();
        });

        $(".profile_settings_submit").submit(function (e){
            e.preventDefault();
            var submit_url = $(this).attr("data-url");
            var data_id = $(this).attr("data-id");
            var data_name = $(this).attr("data-name");
            var data_email = $(this).attr("data-email");
            var data_pass = $(this).attr("data-pass");

            $.ajax({
                url: submit_url,
                type:"POST",
                data:{
                    "_token": "{{ csrf_token() }}",
                    id: $('#erp-id').val(),
                    fname: $('#fname').val(),
                    lname: $('#lname').val()
                },
                dataType: 'json',
                success:function(response){
                    if(response.success){
                        $('.error').text('');
                        toastr.info(response.success, response.title);
                        window.setTimeout(function(){
                            if($(`.erp-id[name=${data_id}`).val() == 0){
                                var url = window.location.href;
                                location.href = url.replace('new',response.data.id);
                            }else{
                                location.reload();
                            }
                        },3000)
                    }
                    else if(response.error){
                        $("#preloader").hide();
                        response.error['fname'] ? $('#fname_error').text(response.error['fname']) : $('#fname_error').text('');
                        response.error['lname'] ? $('#lname_error').text(response.error['lname']) : $('#lname_error').text('');
                        // response.error['password'] ? $('#password_error').text(response.error['password']) : $('#password_error').text('');
                        // response.error['confirm_password'] ? $('#confirm_password_error').text(response.error['confirm_password']) : $('#confirm_password_error').text('');
                    }

                }
            });
        });

        $(document).on('keyup', 'input[type="text"]:not(".price-input"),input[type="url"],textarea', function (e) {
            $(this).removeClass('is-invalid');
            $(this).closest(".form-group").find('.error').text("");
        });

        $(document).on('keyup', '.price-input', function (e) {
            $(this).removeClass('is-invalid');
            $(this).closest('.col-md-4').find('.error').text("");
        });

        $(document).on('change', 'input[type="file"]', function () {
            $(this).closest(".filelabel").removeClass('is-invalid');
            $(this).closest(".form-group").find('.error').text("");
        });
        $(document).on('change', 'select', function () {
            $(this).removeClass('is-invalid');
            $(this).closest(".form-group").find('.error').text("");
        });
        // For category
        $(document).on("click", ".erp-category-form", function (e) {
            e.preventDefault();
            var submitUrl = $('#category_form').attr("data-url");
            var data_id = $('#category_form').attr("data-id");
            var formData = new FormData($('#category_form')[0]);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Send AJAX request
            if (!$('.form-control').hasClass('is-invalid')) {
                $("#preloader").show();
                $.ajax({
                    url: submitUrl,
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function (response) {
                        $("#preloader").hide();
                        $('.input-error').removeClass('is-invalid');
                        if (response.success) {
                            $('.error').text('');
                            var redirectUrl = "{{ route('category-index') }}";
                            window.location.href = redirectUrl;
                        } else if (response.error) {
                            handleFormErrors(response.error);
                        }
                    },
                    error: function (error) {
                        console.error('Ajax request failed:', error);
                        $("#preloader").hide();
                    }
                });
            }
        });

        // For category
        $(document).on("click", ".erp-sub-category-form", function (e) {
            e.preventDefault();
            var submitUrl = $('#sub_category_form').attr("data-url");
            var data_id = $('#sub_category_form').attr("data-id");
            var formData = new FormData($('#sub_category_form')[0]);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if (!$('.form-control').hasClass('is-invalid')) {
                $("#preloader").show();
                $.ajax({
                    url: submitUrl,
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function (response) {
                        $("#preloader").hide();
                        $('.input-error').removeClass('is-invalid');
                        if (response.success) {
                            $('.error').text('');
                            var redirectUrl = "{{ route('sub-category-index') }}";
                            window.location.href = redirectUrl;
                        } else if (response.error) {
                            handleFormErrors(response.error);
                        }
                    },
                    error: function (error) {
                        console.error('Ajax request failed:', error);
                        $("#preloader").hide();
                    }
                });
            }

        });

        // For Term Condition
         $(document).on("click", ".erp-term-condition-form", function (e) {
            e.preventDefault();
            var submitUrl = $('#term_condition_form').attr("data-url");
            var data_id = $('#term_condition_form').attr("data-id");
            var formData = new FormData($('#term_condition_form')[0]);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if (!$('.form-control').hasClass('is-invalid')) {
                $("#preloader").show();
                $.ajax({
                    url: submitUrl,
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function (response) {
                        $("#preloader").hide();
                        $('.input-error').removeClass('is-invalid');
                        if (response.success) {
                            $('.error').text('');
                            var redirectUrl = "{{ route('term-condition-index') }}";
                            window.location.href = redirectUrl;
                        } else if (response.error) {
                            handleFormErrors(response.error);
                        }
                    },
                    error: function (error) {
                        console.error('Ajax request failed:', error);
                        $("#preloader").hide();
                    }
                });
            }

        });

        // For Privacy Policy
        $(document).on("click", ".erp-privacy-policy-form", function (e) {
            e.preventDefault();
            var submitUrl = $('#privacy_policy_form').attr("data-url");
            var data_id = $('#privacy_policy_form').attr("data-id");
            var formData = new FormData($('#privacy_policy_form')[0]);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if (!$('.form-control').hasClass('is-invalid')) {
                $("#preloader").show();
                $.ajax({
                    url: submitUrl,
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function (response) {
                        $("#preloader").hide();
                        $('.input-error').removeClass('is-invalid');
                        if (response.success) {
                            $('.error').text('');
                            var redirectUrl = "{{ route('privacy-policy-index') }}";
                            window.location.href = redirectUrl;
                        } else if (response.error) {
                            handleFormErrors(response.error);
                        }
                    },
                    error: function (error) {
                        console.error('Ajax request failed:', error);
                        $("#preloader").hide();
                    }
                });
            }

        });

        // For SEO
        $(document).on("click", ".erp-SEO-form", function (e) {
            e.preventDefault();
            var submitUrl = $('#SEO_form').attr("data-url");
            var data_id = $('#SEO_form').attr("data-id");
            var formData = new FormData($('#SEO_form')[0]);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if (!$('.form-control').hasClass('is-invalid')) {
                $("#preloader").show();
                $.ajax({
                    url: submitUrl,
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function (response) {
                        $("#preloader").hide();
                        $('.input-error').removeClass('is-invalid');
                        if (response.success) {
                            $('.error').text('');
                            var redirectUrl = "{{ route('SEO-index') }}";
                            window.location.href = redirectUrl;
                        } else if (response.error) {
                            handleFormErrors(response.error);
                        }
                    },
                    error: function (error) {
                        console.error('Ajax request failed:', error);
                        $("#preloader").hide();
                    }
                });
            }

        });

        // For FAQ
        $(document).on("click", ".erp-FAQ-form", function (e) {
            e.preventDefault();
            var submitUrl = $('#FAQ_form').attr("data-url");
            var data_id = $('#FAQ_form').attr("data-id");
            var formData = new FormData($('#FAQ_form')[0]);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if (!$('.form-control').hasClass('is-invalid')) {
                $("#preloader").show();
                $.ajax({
                    url: submitUrl,
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function (response) {
                        $("#preloader").hide();
                        $('.input-error').removeClass('is-invalid');
                        if (response.success) {
                            $('.error').text('');
                            var redirectUrl = "{{ route('FAQ-index') }}";
                            window.location.href = redirectUrl;
                        } else if (response.error) {
                            handleFormErrors(response.error);
                        }
                    },
                    error: function (error) {
                        console.error('Ajax request failed:', error);
                        $("#preloader").hide();
                    }
                });
            }

        });


        $(document).on("click", ".erp-item-form", function (e) {
            e.preventDefault();
            // tinymce.activeEditor.save();
            var submitUrl = $('#item_form').attr("data-url");
            var item_id = $('#item_id').val();
            var item_type = $('#item_type').val();
            var formData = new FormData($('#item_form')[0]);
            var formData1 = new FormData($('#item_form1')[0]);
            var formData2 = new FormData($('#item_form2')[0]);
            formData.append('item_type', item_type);
            formData1.forEach(function(value, key) {
                formData.append(key, value);
            });
            formData2.forEach(function(value, key) {
                formData.append(key, value);
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if (!$('.form-control').hasClass('is-invalid')) {
                $("#preloader").show();
                $.ajax({
                    url: submitUrl,
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function (response) {
                        $("#preloader").hide();
                        $('.input-error').removeClass('is-invalid');
                        if (response.success) {
                            $('.error').text('');
                            var redirectUrl = "{{ route('items-index') }}";
                            window.location.href = redirectUrl;
                        } else if (response.error) {
                            $('#name_error').text(response.error['name'] || '');
                            $('#preview_url_error').text(response.error['preview_url'] || '');
                            $('#item_thumbnail_error').text(response.error['item_thumbnail'] || '');
                            $('#zip_file_error').text(response.error['item_main_file'] || '');
                           /*  if(item_id!=0){
                                $('#item_thumbnail_error').text(response.error['old_thumbnail_image'] || '');
                                $('#zip_file_error').text(response.error['old_main_file'] || '');
                                $('#item_thumbnail_label').addClass(response.error['old_thumbnail_image']?'is-invalid':'');
                                $('#item_main_file_label').addClass(response.error['old_main_file']?'is-invalid':'');
                            } */
                            $('#description_error').text(response.error['html_description'] || '');
                            $('#feature_error').text(response.error['key_feature.0'] || '');
                            if(response.error['key_feature']){
                                $('#feature_error').text(response.error['key_feature'] || '');
                            }
                            $('#fixed_price_error').text(response.error['fixed_price'] || '');
                            $('#sale_price_error').text(response.error['sale_price'] || '');
                            $('#gst_percentage_error').text(response.error['gst_percentage'] || '');
                            $('#subcategories_error').text(response.error['subcategory_id'] || '');
                            $('#category_error').text(response.error['category_id'] || '');

                            $('#name').addClass(response.error['name']?'is-invalid':'');
                            $('#item_preview_url').addClass(response.error['preview_url']?'is-invalid':'');
                            $('#html_description').addClass(response.error['html_description']?'is-invalid':'');
                            $('#key_feature').addClass(response.error['key_feature.0']?'is-invalid':'');
                            $('#category_id').addClass(response.error['category_id']?'is-invalid':'');
                            $('#subcategory_id').addClass(response.error['subcategory_id']?'is-invalid':'');
                            $('#item_fixed_price').addClass(response.error['fixed_price']?'is-invalid':'');
                            $('#item_sale_price').addClass(response.error['sale_price']?'is-invalid':'');
                            $('#item_gst_percentage').addClass(response.error['gst_percentage']?'is-invalid':'');
                            $('#item_thumbnail_label').addClass(response.error['item_thumbnail']?'is-invalid':'');
                            $('#item_main_file_label').addClass(response.error['item_main_file']?'is-invalid':'');

                        }
                    },
                    error: function (error) {
                        console.error('Ajax request failed:', error);
                        $("#preloader").hide();
                    }
                });
            }
        });

        $(document).on('click', '#saverecurringcardbtn', function (e) {
            e.preventDefault();
            var submitUrl = $(this).closest('#item_form').attr("data-url");
            var item_id = $('#item_id').val();
            var formData = new FormData($(this).closest('#item_form')[0]);
            formData.append('item_id', item_id);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            if (!$('.form-control').hasClass('is-invalid')) {
                $('.error-message').remove();
                $("#preloader").show();
                $.ajax({
                    url: submitUrl,
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function (response) {
                        window.location.reload();
                    },
                    error: function (xhr) {
                        $("#preloader").hide();
                    }
                });
            }
        });

        $(document).on('click', '.removerecurringmaincardbtn', function() {
            var sub_id = $(this).data('subid');
            var item_id = $('#item_id').val();

            $.ajax({
                url: "{{ route('recurring.card.remove') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    item_id: item_id,
                    sub_id: sub_id
                },
                success: function(response) {
                    if (response.success) {
                        window.location.reload();
                    }
                }
            });
        });


        // For Blog Category
        $(document).on("click", ".erp-Blog_category-form", function (e) {
            e.preventDefault();
            var submitUrl = $('#Blog_category_form').attr("data-url");
            var data_id = $('#Blog_category_form').attr("data-id");
            var formData = new FormData($('#Blog_category_form')[0]);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if (!$('.form-control').hasClass('is-invalid')) {
                $("#preloader").show();
                $.ajax({
                    url: submitUrl,
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function (response) {
                        $("#preloader").hide();
                        $('.input-error').removeClass('is-invalid');
                        if (response.success) {
                            $('.error').text('');
                            var redirectUrl = "{{ route('Blog_category-index') }}";
                            window.location.href = redirectUrl;
                        } else if (response.error) {
                            handleFormErrors(response.error);
                        }
                    },
                    error: function (error) {
                        console.error('Ajax request failed:', error);
                        $("#preloader").hide();
                    }
                });
            }

        });
        // For Blog
        $(document).on("click", ".erp-Blog-form", function (e) {
            e.preventDefault();
            tinymce.triggerSave();
            var submitUrl = $('#Blog_form').attr("data-url");
            var data_id = $('#Blog_form').attr("data-id");
            var formData = new FormData($('#Blog_form')[0]);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            if (!$('.form-control').hasClass('is-invalid')) {
                $("#preloader").show();
                $.ajax({
                    url: submitUrl,
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function (response) {
                        $("#preloader").hide();
                        $('.input-error').removeClass('is-invalid');
                        if (response.success) {
                            $('.error').text('');
                            var redirectUrl = "{{ route('Blog-index') }}";
                            window.location.href = redirectUrl;
                        } else if (response.error) {
                            handleFormErrors(response.error);
                        }
                    },
                    error: function (error) {
                        console.error('Ajax request failed:', error);
                        $("#preloader").hide();
                    }
                });
            }

        });

        function handleFormErrors(errors) {
            $('#name_error').text(errors['name'] || '');
            $('#image_error').text(errors['image'] || '');
            $('#status_error').text(errors['status'] || '');
            $('#parent_category_error').text(errors['parent_category_id'] || '');
            $('#description_error').text(errors['description'] || '');

            $('#category_name').addClass(errors['name']?'is-invalid':'');
            $('#sub_category_name').addClass(errors['name']?'is-invalid':'');
            $('#parent_category').addClass(errors['parent_category_id']?'is-invalid':'');
            $('.image-input-wrapper').addClass(errors['image']?'is-invalid':'');
        }
    });

    document.getElementById('edit_content_type').addEventListener('change', function() {
        var contentType = this.value;

        // Hide all content options
        var contentOptions = document.querySelectorAll('.content-option');
        contentOptions.forEach(function(option) {
            option.style.display = 'none';
        });

        // Show the selected content option based on the selected value
        if (contentType === 'heading-description-image') {
            document.getElementById('content-option-1').style.display = 'block';
        } else if (contentType === 'heading-image-description') {
            document.getElementById('content-option-2').style.display = 'block';
        } else if (contentType === 'image-description-heading') {
            document.getElementById('content-option-3').style.display = 'block';
        } else if (contentType === 'heading-description-image-description') {
            document.getElementById('content-option-4').style.display = 'block';
        }
    });

</script>
