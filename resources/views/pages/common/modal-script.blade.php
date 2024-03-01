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

        $(document).on('keyup', 'input[type="text"]', function (e) {
            $(this).removeClass('is-invalid');
            $(this).closest(".form-group").find('.error').text("");
        });
        $(document).on('change', 'input[type="file"], select', function () {
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

        $(document).on("click", ".erp-item-form", function (e) {
            e.preventDefault();
            var submitUrl = $('#item_form').attr("data-url");
            var data_id = $('#item_form').attr("data-id");
            var formData = new FormData($('#item_form')[0]);

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
            
            $('#category_name').addClass(errors['name']?'is-invalid':'');
            $('#sub_category_name').addClass(errors['name']?'is-invalid':'');
            $('#parent_category').addClass(errors['parent_category_id']?'is-invalid':'');
            $('.image-input-wrapper').addClass(errors['image']?'is-invalid':'');
        }
    });
</script>
