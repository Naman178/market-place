$(document).ready(function(){
    $(document).on('click','#accordion_coupon_code', function(){
        $(document).find('#accordion_coupon_code_form').slideToggle();
    });

    $('.select-input').select2();
});