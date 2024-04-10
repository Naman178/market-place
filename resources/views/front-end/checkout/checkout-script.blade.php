<script>
    $(document).ready(function(){
        let stripeKey = "{{ env('STRIPE_KEY') }}";
        $('#card_number').mask('0000 0000 0000 0000');
        $('#card_cvc').mask('000');
        $('#card_exp_month').mask('00');
        $('#card_exp_year').mask('00');

        $.validator.addMethod("checkExpirationDate", function(value, element) {
            var enteredMonth = parseInt($("#card_exp_month").val());
            var enteredYear = parseInt($("#card_exp_year").val());
            var currentYear = new Date().getFullYear() % 100;

            // Check if entered year is in the past
            if (enteredYear < currentYear || (enteredYear === currentYear && enteredMonth < new Date().getMonth() + 1)) {
                return false;
            }
            return true;
        }, "Please enter a valid expiration date");

        $("#payment-form").validate({
            rules: {
                name_on_card: {
                    required: true,
                },
                card_number: {
                    required: true,
                    minlength: 19,
                    maxlength: 19,
                },
                card_exp_month: {
                    required: true,
                    minlength: 1,
                    maxlength: 2,
                    range: [1, 12],
                    checkExpirationDate: true
                },
                card_exp_year: {
                    required: true,
                    minlength: 2,
                    maxlength: 2,
                    checkExpirationDate: true
                },
                card_cvc: {
                    required: true,
                    minlength: 3,
                    maxlength: 3,
                }
            },
            messages: {
                name_on_card: {
                    required: "Please enter your name",
                },
                card_number: {
                    required: "Please enter your card number",
                    minlength: "Please enter a valid card number",
                    maxlength: "Please enter a valid card number",
                },
                card_exp_month: {
                    required: "Please enter your card expiration month",
                    minlength: "Please enter a valid expiration month",
                    maxlength: "Please enter a valid expiration month",
                },
                card_exp_year: {
                    required: "Please enter your card expiration year",
                    minlength: "Please enter a valid expiration year",
                    maxlength: "Please enter a valid expiration year",
                },
                card_cvc: {
                    required: "Please enter your card CVC",
                    minlength: "Please enter a valid CVC",
                    maxlength: "Please enter a valid CVC",
                }
            },
            errorPlacement: function (error, element) {
                return true;
            },
            highlight: function(element) {
                $(element).addClass('error-border');
            },
            unhighlight: function(element) {
                $(element).removeClass('error-border');
            },
        });

        $("#card_exp_month, #card_exp_year").on('input', function() {
            $("#payment-form").validate().element($(this));
        });

        $(document).on("click", '#proceed_to_pay_btn', async function (e) {
            if ($("#payment-form").valid()) {
                $(this).prop('disabled', true);
                $(this).css("background-color", "rgb(245, 245, 245)");
                $(this).html('<div class="loader" role="status" aria-hidden="true"></div>');
                const url = $(this).data("url");
                let name = $('#name_on_card').val();
                let cardNumber = $('#card_number').val();
                let cardCvc = $('#card_cvc').val();
                let cardExpMonth = $('#card_exp_month').val();
                let cardExpYear = $('#card_exp_year').val();
                Stripe.setPublishableKey(stripeKey);
                await Stripe.createToken({
                    number: cardNumber,
                    cvc: cardCvc,
                    exp_month: cardExpMonth,
                    exp_year: cardExpYear,
                    name: name,
                }, function(status, response){
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
                            product_id: $("#product_id").val(),
                            stripeToken: response.id,
                        },
                        success: ({ data }) => {
                            // window.location.href = '{{ route("dashboard") }}';
                            window.location.href = data.next_action.redirect_to_url.url;
                        },
                    });
                });
            }
        });
    })
</script>

{{-- <script>
    $(document).ready(function(){
        let stripeKey = "{{ env('STRIPE_KEY') }}";
        const stripe = Stripe(stripeKey);
        let cardElement = stripe.elements().create('card');
        cardElement.mount('#card-element');
        $(document).on("click", '#proceed_to_pay_btn', async function (e) {
            e.preventDefault();
            const url = $(this).data("url");
            let name = $('#name_on_card').val();
            let resp = await stripe.createToken(cardElement);
            if(resp.error){
                console.log(error);
            }
            else {
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
                    stripeToken: resp.token.id,
                },
                success: (data) => {
                    // window.location.href = '{{ route("dashboard") }}';
                },
            });
            }
        });
    })
</script> --}}
