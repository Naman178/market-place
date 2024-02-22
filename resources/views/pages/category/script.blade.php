<script>
    $('body').on('change', 'input[name="image"]', function(e) {
        var imgprevid = $(this).closest('.input-file-col').find('.hidepreviewimg').attr('id');
        var prevtitle = $(this).closest('.input-file-col').find('.title').attr('id');
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
</script>