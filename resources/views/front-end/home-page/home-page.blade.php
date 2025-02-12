@extends('front-end.common.master')
@section('styles')
<link rel="stylesheet" href="{{ asset('front-end/css/home-page.css') }}">
<!-- Scoped Bootstrap CSS -->
<link rel="stylesheet" href="{{ asset('front-end/css/scoped-bootstrap.css') }}">
<!-- Slick CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
<!-- Latest Font Awesome CDN -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
@endsection
@section('meta')
<title>Market Place | {{ $seoData->title ?? 'Default Title' }} - {{ $seoData->description ?? 'Default Description' }}</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="{{ $seoData->description ?? 'Default description' }}">
<meta name="keywords" content="{{ $seoData->keywords ?? 'default, keywords' }}">
<meta property="og:title" content="{{ $seoData->title ?? 'Default Title' }}">
<meta property="og:description" content="{{ $seoData->description ?? 'Default description' }}">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:type" content="website">
@endsection
@section('content')
@include('front-end.home-page.section.hero_banner')
@include('front-end.home-page.section.plugins')
<div class="carousel-container">
    @include('front-end.home-page.section.Integration')
</div>
@include('front-end.home-page.section.Features')
@include('front-end.home-page.section.Support')
@include('front-end.home-page.section.items-grid')
<div class="carousel-container">
    @include('front-end.home-page.section.Blog')
</div>
@include('front-end.home-page.section.social_media')
<div class="carousel-container">
@include('front-end.home-page.section.Our_Patients')
@include('front-end.home-page.section.FAQ')
</div>


@endsection
@section('scripts')
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- Slick JS -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script>
     $('.slider').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        infinite: true,
        arrows: true,
        autoplay: true,
        autoplaySpeed: 3000,
    });

    $('.plans-slider').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        infinite: true,
        arrows: true,
        autoplay: true,
        autoplaySpeed: 3000,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });
    $(document).ready(function(){
        $('.left-arrow').click(function() {
            $('#integrationCarousel').carousel('prev');
        });

        $('.right-arrow').click(function() {
            $('#integrationCarousel').carousel('next');
        });

        $('.left-arrow').click(function() {
            $('#blogCarousel').carousel('prev');
        });

        $('.right-arrow').click(function() {
            $('#blogCarousel').carousel('next');
        });

        $('.left-arrow').click(function() {
            $('#patientCarousel').carousel('prev');
        });

        $('.right-arrow').click(function() {
            $('#patientCarousel').carousel('next');
        });

        $('#patientCarousel').carousel({
            interval: false, // Disable auto-sliding
            wrap: true // Enable wrapping around from last to first slide
        });
        
    });
    // for Social media
    $(document).ready(function () {
        $('.social_media_slider').slick({
            infinite: true,
            slidesToShow: 6, 
            slidesToScroll: 1, 
            arrows: false, 
            dots: false,
            autoplay: true, 
            autoplaySpeed: 2000, 
            responsive: [
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                    }
                },
                {
                    breakpoint: 480, 
                    settings: {
                        slidesToShow: 1,
                    }
                }
            ]
        });
    });
    // For patient
    document.addEventListener('DOMContentLoaded', function () {
        const thumbnails = document.querySelectorAll('.thumbnail');
        const testimonialText = document.querySelector('.testimonial-text');
        const patientName = document.querySelector('.patient-name');
        const patientRole = document.querySelector('.patient-role');
        const largeImage = document.getElementById('large-image');

        const testimonials = [
            {
                text: 'Laoreet per malesuada montes lorem tincidunt id natoque parturient suspendisse senectus a scelerisque sem quis a parturient et nam leo diam in amet elit et phasellus a vulputate. Pharetra neque euismod pharetra fringilla augue curae urna nisi purus parturient iaculis conubia a fringilla odio vestibulum dictum. Convallis ridiculus dictumst a nam urna.',
                name: 'Joe Root',
                role: 'Happy Patient',
                image: '{{ asset("front-end/images/Group 5747.png") }}', // Add image for large display
            },
            {
                text: 'Laoreet per malesuada montes lorem tincidunt id natoque parturient suspendisse senectus a scelerisque sem quis a parturient et nam leo diam in amet elit et phasellus a vulputate. Pharetra neque euismod pharetra fringilla augue curae urna nisi purus parturient iaculis conubia a fringilla odio vestibulum dictum. Convallis ridiculus dictumst a nam urna.',
                name: 'Jane Doe',
                role: 'Satisfied Patient',
                image: '{{ asset("front-end/images/Group 5748.png") }}',
            },
            {
                text: 'Laoreet per malesuada montes lorem tincidunt id natoque parturient suspendisse senectus a scelerisque sem quis a parturient et nam leo diam in amet elit et phasellus a vulputate. Pharetra neque euismod pharetra fringilla augue curae urna nisi purus parturient iaculis conubia a fringilla odio vestibulum dictum. Convallis ridiculus dictumst a nam urna.',
                name: 'John Smith',
                role: 'Grateful Patient',
                image: '{{ asset("front-end/images/Group 5749.png") }}',
            },
        ];

        thumbnails.forEach((thumbnail, index) => {
            thumbnail.addEventListener('click', () => {
                // Update active thumbnail
                document.querySelector('.thumbnail.active').classList.remove('active');
                thumbnail.classList.add('active');

                // Update testimonial content
                const testimonial = testimonials[index];
                testimonialText.textContent = testimonial.text;
                patientName.textContent = testimonial.name;
                patientRole.textContent = testimonial.role;

                // Update the large image
                largeImage.src = testimonial.image;
            });
        });

        // Add slider buttons functionality
        const prevBtn = document.querySelector('.prev-btn');
        const nextBtn = document.querySelector('.next-btn');
        let currentIndex = 0;

        function updateSlider(index) {
            document.querySelector('.thumbnail.active').classList.remove('active');
            thumbnails[index].classList.add('active');

            const testimonial = testimonials[index];
            testimonialText.textContent = testimonial.text;
            patientName.textContent = testimonial.name;
            patientRole.textContent = testimonial.role;

            // Update the large image
            largeImage.src = testimonial.image;
        }

        prevBtn.addEventListener('click', () => {
            currentIndex = (currentIndex === 0) ? testimonials.length - 1 : currentIndex - 1;
            updateSlider(currentIndex);
        });

        nextBtn.addEventListener('click', () => {
            currentIndex = (currentIndex === testimonials.length - 1) ? 0 : currentIndex + 1;
            updateSlider(currentIndex);
        });
    });

    // for FAQ
    window.onload = () => {
        const firstFaq = document.querySelector('.faq-item');
        if (firstFaq) {
            const firstQuestion = firstFaq.querySelector('.faq-question');
            const firstAnswer = firstFaq.querySelector('.faq-answer');
            const firstIcon = firstFaq.querySelector('.faq-icon');

            // Set the first FAQ as open
            firstAnswer.classList.add('open');
            firstIcon.classList.add('rotate');
            firstQuestion.classList.add('active');
        }
    };

    // Event listener for FAQ questions
    document.querySelectorAll('.faq-question').forEach(question => {
        question.addEventListener('click', () => {
            // Close all other FAQs
            document.querySelectorAll('.faq-item').forEach(item => {
                const answer = item.querySelector('.faq-answer');
                const icon = item.querySelector('.faq-icon');
                const itemQuestion = item.querySelector('.faq-question');

                if (itemQuestion !== question) {
                    answer.classList.remove('open');
                    icon.classList.remove('rotate');
                    itemQuestion.classList.remove('active');
                }
            });

            // Toggle open/close for the current FAQ
            const parent = question.parentElement;
            const answer = parent.querySelector('.faq-answer');
            const icon = question.querySelector('.faq-icon');

            answer.classList.toggle('open');
            icon.classList.toggle('rotate');
            question.classList.toggle('active');
        });
    });

    //newsletter
    $(document).ready(function(){
        $('.sign_up_btn').on('click',function(){
            let email = $('.email_text').val();
            let submit_url = $(this).attr('data-route');
            console.log(submit_url);
            $.ajax({
                url: submit_url,
                type: "POST",
                data: { 
                    "_token": "{{ csrf_token() }}",
                    email: email
                },
                success: function(response) {
                    $('.email_text').val('');
                    $('.newsletter_success').text("Successfully subscribed!").css({"color": "green"}).fadeIn();
                    setTimeout(function() {
                        $('.newsletter_success').fadeOut();
                    }, 5000);
                },
                error: function(xhr, status, error) {
                   
                    let errorMessage = "This email is already subscribed try another email id";

                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        if (errors.email) {
                            errorMessage = errors.email[0]
                        }
                    }
                    
                    $('.newsletter_success').text(errorMessage).css("color", "red").fadeIn();
                    setTimeout(function() {
                        $('.newsletter_success').fadeOut();
                        $('.email_text').val('');
                    }, 5000);
                }
            });
        })
    });

</script>
@endsection
