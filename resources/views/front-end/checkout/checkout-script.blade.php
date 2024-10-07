<script>
    $(document).on("click", '#proceed_to_pay_btn', function (e) {
        console.log("test");

        e.preventDefault();
        const url = $(this).data("url");
        console.log(url);
        $.ajax({
            type: "POST",
            url: url,
            data: {
                _token: "{{ csrf_token() }}",
                user_id: $("#user_id").val(),
                name: `${$("#firstname").val()} ${$("#lastname").val()}`,
                email: $("#email").val(),
                country_code: $("#country_code").val(),
                contact: $("#contact").val(),
                company_website: $("#company_website").val(),
                company_name: $("#company_name").val(),
                country: $("#country").val(),
                address_line_one: $("#address_line_one").val(),
                address_line_two: $("#address_line_two").val(),
                city: $("#city").val(),
                postal: $("#postal").val(),
                amount: $("#amount").val(),
                stripeToken: $("#stripeToken").val(),
            },
            success: (data) => {
                window.location.href = '{{ route("thankyou") }}';
            },
        });
    });
</script>
