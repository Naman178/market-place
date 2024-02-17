<script>
    /* xero settings submit form event */
    $(document).on("click", ".settings_form", function(){
        $(".erp-form-submit").submit();
        $("#preloader").show();
    });

    /*xero settings submit ajax event */
    $(".erp-form-submit").submit(function (e){
        e.preventDefault();
        var obj = {};
        var $value = new FormData(this);
        $value.forEach((value, key) => obj[key] = value);
        var json = JSON.stringify(obj);
        $.ajax({
            url: "{{url('/settings/store')}}",
            type:"POST",
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: $value,
            dataType: 'json',
            processData: false,
            success:function(response){
                $("#preloader").hide();
                // toastr.info(response.success, response.title);
                location.href = "{{route('xero-connect')}}";
            }
        });
    });

     /* pdf settings submit form event */
     $(document).on("click", ".settings_form_pdf", function(){
        $(".erp-form-submit-pdf").submit();
        $("#preloader").show();
    });

    /*pdf settings submit ajax event */
    $(".erp-form-submit-pdf").submit(function (e){
        e.preventDefault();
        var obj = {};
        var $value = new FormData(this);
        $value.forEach((value, key) => obj[key] = value);
        var json = JSON.stringify(obj);
        $.ajax({
            url: "{{url('/settings/store')}}",
            type:"POST",
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: $value,
            dataType: 'json',
            processData: false,
            success:function(response){
                // toastr.info(response.success, response.title);
                location.reload();
            }
        });
    });

    /* header image preview on change  */
    $('body').on('change', 'input[name="header_image"]', function(e) {
        var imgprevid = $(this).siblings('.hidepreviewimg').attr('id');
        var prevtitle = $(this).siblings('.title').attr('id');

        $('#'+imgprevid).hide();
        var labelVal = $(".title").text();
        var oldfileName = $(this).val();
        fileName = e.target.value.split( '\\' ).pop();
        if (oldfileName == fileName) {return false;}
        var extension = fileName.split('.').pop();
        if ($.inArray(extension,['jpg','jpeg','png']) >= 0) {
            $('#'+imgprevid).show();
            readURL(this,imgprevid);
        }
        else{
            alert('please upload valid image');
            return true;
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

    /* signature of buyer image preview on change  */
    $('body').on('change', 'input[name="signature_of_buyer"]', function(e) {
        $("#prevSignBuyer").hide();
        var labelVal = $("#prevSignBuyertitle").text();
        var oldfileName = $(this).val();
        fileName = e.target.value.split( '\\' ).pop();
        if (oldfileName == fileName) {return false;}
        var extension = fileName.split('.').pop();
        if ($.inArray(extension,['jpg','jpeg','png']) >= 0) {
            $("#prevSignBuyer").show();
            readURL(this,'prevSignBuyer');
        }
        else{
            alert('please upload valid image');
            return true;
        }
        if(fileName){
            if (fileName.length > 50){
                $("#prevSignBuyertitle").text(fileName.slice(0,4)+'...'+extension);
            }
            else{
                $("#prevSignBuyertitle").text(fileName);
            }
        }
        else{
            $("#prevSignBuyertitle").text(labelVal);
        }
    });

     /* signature of seller image preview on change  */
     $('body').on('change', 'input[name="signature_of_seller"]', function(e) {
        $("#prevSignSeller").hide();
        var labelVal = $("#prevSignSellertitle").text();
        var oldfileName = $(this).val();
        fileName = e.target.value.split( '\\' ).pop();
        if (oldfileName == fileName) {return false;}
        var extension = fileName.split('.').pop();
        if ($.inArray(extension,['jpg','jpeg','png']) >= 0) {
            $("#prevSignSeller").show();
            readURL(this,'prevSignSeller');
        }
        else{
            alert('please upload valid image');
            return true;
        }
        if(fileName){
            if (fileName.length > 50){
                $("#prevSignSellertitle").text(fileName.slice(0,4)+'...'+extension);
            }
            else{
                $("#prevSignSellertitle").text(fileName);
            }
        }
        else{
            $("#prevSignSellertitle").text(labelVal);
        }
    });

    /* login register settings submit form event */
    $(document).on("click", ".settings_form_login_register", function(){
        $(".erp-form-submit-login-register").submit();
        $("#preloader").show();
    });

    /*login register settings submit ajax event */
    $(".erp-form-submit-login-register").submit(function (e){
        e.preventDefault();
        var obj = {};
        var $value = new FormData(this);
        $value.forEach((value, key) => obj[key] = value);
        var json = JSON.stringify(obj);
        $.ajax({
            url: "{{url('/settings/store')}}",
            type:"POST",
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: $value,
            dataType: 'json',
            processData: false,
            success:function(response){
                // toastr.info(response.success, response.title);
                location.reload();
            }
        });
    });

     /* login register image preview on change  */
     $('body').on('change', 'input[name="login_register_bg"]', function(e) {
        var imgprevid = $(this).siblings('.hidepreviewimg').attr('id');
        var prevtitle = $(this).siblings('.title').attr('id');

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
            alert('please upload valid image');
            return true;
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

    /* login register settings submit form event */
    $(document).on("click", ".settings_form_logo", function(){
        $(".erp-form-submit-logo").submit();
        $("#preloader").show();
    });

    /*login register settings submit ajax event */
    $(".erp-form-submit-logo").submit(function (e){
        e.preventDefault();
        var obj = {};
        var $value = new FormData(this);
        $value.forEach((value, key) => obj[key] = value);
        var json = JSON.stringify(obj);
        $.ajax({
            url: "{{url('/settings/store')}}",
            type:"POST",
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: $value,
            dataType: 'json',
            processData: false,
            success:function(response){
                // toastr.info(response.success, response.title);
                location.reload();
            }
        });
    });

     /* login register image preview on change  */
    $('body').on('change', 'input[name="logo_image"]', function(e) {
        var imgprevid = $(this).siblings('.hidepreviewimg').attr('id');
        var prevtitle = $(this).siblings('.title').attr('id');

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
            alert('please upload valid image');
            return true;
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

    $('body').on('change', 'input[name="site_favicon"]', function(e) {
        var imgprevid = $(this).siblings('.hidepreviewimg').attr('id');
        var prevtitle = $(this).siblings('.title').attr('id');

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
            alert('please upload valid image');
            return true;
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

    $(document).on("click", ".erp-pili-hideshow-submit", function(){
        $(".erp-pili-hideshow").submit();
        // $("#preloader").show();
    });

     $(".erp-pili-hideshow").submit(function (e){
        e.preventDefault();
        var $value = new FormData(this);
        $.ajax({
            url: "{{url('/settings/store')}}",
            type:"POST",
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: $value,
            dataType: 'json',
            processData: false,
            success:function(response){
                // $("#preloader").hide();
                location.reload();
            }
        });
    });

    $(document).on("click", ".erp-poli-hideshow-submit", function(){
        $(".erp-poli-hideshow").submit();
        // $("#preloader").show();
    });

     $(".erp-poli-hideshow").submit(function (e){
        e.preventDefault();
        var $value = new FormData(this);
        $.ajax({
            url: "{{url('/settings/store')}}",
            type:"POST",
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: $value,
            dataType: 'json',
            processData: false,
            success:function(response){
                // $("#preloader").hide();
                location.reload();
            }
        });
    });

    $(document).on("click", ".erp-con-hideshow-submit", function(){
        $(".erp-con-hideshow").submit();
        // $("#preloader").show();
    });

     $(".erp-con-hideshow").submit(function (e){
        e.preventDefault();
        var $value = new FormData(this);
        $.ajax({
            url: "{{url('/settings/store')}}",
            type:"POST",
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: $value,
            dataType: 'json',
            processData: false,
            success:function(response){
                // $("#preloader").hide();
                location.reload();
            }
        });
    });

    $(document).on("click", ".erp-inv-hideshow-submit", function(){
        $(".erp-inv-hideshow").submit();
        // $("#preloader").show();
    });

     $(".erp-inv-hideshow").submit(function (e){
        e.preventDefault();
        var $value = new FormData(this);
        $.ajax({
            url: "{{url('/settings/store')}}",
            type:"POST",
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: $value,
            dataType: 'json',
            processData: false,
            success:function(response){
                // $("#preloader").hide();
                location.reload();
            }
        });
    });

</script>
