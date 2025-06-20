@extends('front-end.common.master')
@php 
 $site = \App\Models\Settings::where('key', 'site_setting')->first();
  $logoImage = $site['value']['logo_image'] ?? null;
    $ogImage = $logoImage 
        ? asset('storage/Logo_Settings/' . $logoImage) 
        : asset('front-end/images/infiniylogo.png');
@endphp
@section('styles')
<!-- Slick CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
<!-- Latest Font Awesome CDN -->
{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
@endsection
@section('meta')
@section('title'){{ $seoData->title ?? 'Home' }} @endsection
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content=" {{ $seoData->description ?? "Welcome to Market Place Main on Infinity Stage – your go-to platform for automated pricing solutions, seamless WooCommerce integration, and real-time gold price updates. Explore expert insights, trending topics, and innovative tools designed to enhance your eCommerce experience. Stay ahead with our curated content and smart pricing automation." }}">
<meta name="keywords" content="{{ $seoData->keywords ?? 'default, keywords' }}">
<meta property="og:title" content="{{ $seoData->title ?? 'Home' }}">
<meta property="og:description" content="{{ $seoData->description ?? 'Welcome to Market Place Main on Infinity Stage' }}">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:type" content="website">
<meta property="og:image:type" content="image/jpeg">
<meta property="og:image" content="{{ $ogImage }}">
@if ($site && $site['value']['logo_image'] && $site['value']['logo_image'] != null)
    <meta property="og:logo" content="{{ asset('storage/Logo_Settings/'.$site['value']['logo_image']) }}" />
@else
    <meta property="og:logo" content="{{ asset('front-end/images/infiniylogo.png') }}" />
@endif
@endsection
@section('content')
@include('front-end.home-page.section.hero_banner')
{{-- @if ($category->count()<=1) --}}
    @include('front-end.home-page.section.Subcategory')
{{-- @else
    @include('front-end.home-page.section.Category')
@endif --}}
@php
    use App\Models\Category;
    use App\Models\SubCategory;
    $category = Category::where('sys_state','=','0')->first();
    $subcategory = SubCategory::where('sys_state','=','0')->first();
@endphp
@include('front-end.home-page.section.plugins')
<div class="carousel-container">
    @include('front-end.home-page.section.Integration')
</div>
@include('front-end.home-page.section.Features')
@include('front-end.home-page.section.Support')
{{-- @include('front-end.home-page.section.items-grid') --}}
<div class="carousel-container">
    @include('front-end.home-page.section.Blog')
</div>
<div class="carousel-container">
@include('front-end.home-page.section.Our_Patients')
@include('front-end.home-page.section.social_media')
@include('front-end.home-page.section.FAQ')
</div>


@endsection
@section('scripts')
<!-- jQuery -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
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
        $('.blog-slider').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            arrows: false,
            autoplaySpeed: 2000,
            responsive: [
                {
                    breakpoint: 991,
                    settings: {
                        slidesToShow: 2,
                        dots: true,
                        arrows: false,
                    }
                },
                {
                    breakpoint: 767,
                    settings: {
                        slidesToShow: 1,
                        dots: true,
                        arrows: false,
                    }
                }
            ]
        });
    });
    $(document).ready(function(){
        $('#left-arrow-btn').on('click', function (event) {
            event.preventDefault(); 
            $('#integrationCarousel').slick('slickPrev');
        });

        $('#right-arrow-btn').on('click', function (event) {
            event.preventDefault(); 
            $('#integrationCarousel').slick('slickNext');
        });
        $('#categroy-left-arrow-btn').on('click', function (event) {
            event.preventDefault(); 
            $('#categoryCarousel').slick('slickPrev');
        });

        $('#category-right-arrow-btn').on('click', function (event) {
            event.preventDefault();
            $('#categoryCarousel').slick('slickNext');
        });

        $('#subcategroy-left-arrow-btn').on('click', function (event) {
            event.preventDefault();
            $('#subcategoryCarousel').slick('slickPrev');
        });

        $('#subcategroy-right-arrow-btn').on('click', function (event) {
            event.preventDefault(); 
            $('#subcategoryCarousel').slick('slickNext');
        });

        $('#blog-left-arrow-btn').click(function(event) {
            event.preventDefault(); 
            $('.blog-slider').slick('slickPrev');
        });

        $('#blog-right-arrow-btn').click(function(event) {
            event.preventDefault(); 
            $('.blog-slider').slick('slickNext');
        });

        $('.left-arrow').click(function(event) {
            event.preventDefault(); 
            $('#patientCarousel').carousel('prev');
        });

        $('.right-arrow').click(function(event) {
            event.preventDefault(); 
            $('#patientCarousel').carousel('next');
        });

        $('#patientCarousel').carousel({
            interval: false, // Disable auto-sliding
            wrap: true // Enable wrapping around from last to first slide
        });
        if ($(window).width() <= 320) {
            $('.arrow-container').show();
        }
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
                    breakpoint: 1199,
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

        $('#integrationCarousel').slick({
            infinite: true,
            slidesToShow: 3,
            slidesToScroll: 1,
            arrows: false,
            dots: false,
            autoplaySpeed: 2000,
            responsive: [
                {
                    breakpoint: 1405,
                    settings: {
                        slidesToShow: 2,
                    }
                },
                {
                    breakpoint: 991,
                    settings: {
                        slidesToShow: 2,
                        dots: true,
                        arrows: false,
                    }
                },
                {
                    breakpoint: 767,
                    settings: {
                        slidesToShow: 1,
                        dots: true,
                        arrows: false,
                    }
                }
            ]
        });

        // $('.category-slider').slick({
        //     slidesToShow: 3,
        //     slidesToScroll: 1,
        //     infinite: true,
        //     autoplay: false,
        //     autoplaySpeed: 3000,
        //     dots: false,
        //     arrows: false,
        //     prevArrow: '<button type="button" class="slick-prev" style="margin-left:-11px;">&#10094;</button>',
        //     nextArrow: '<button type="button" class="slick-next">&#10095;</button>',
        //     responsive: [
        //         {
        //             breakpoint: 1024,
        //             settings: {
        //                 slidesToShow: 2
        //             }
        //         },
        //         {
        //             breakpoint: 768,
        //             settings: {
        //                 slidesToShow: 1
        //             }
        //         }
        //     ]
        // });
        
        $('#category-slider').slick({
            infinite: true,
            slidesToShow: 4,
            slidesToScroll: 1,
            arrows: false,
            dots: true,
            autoplaySpeed: 2000,
            responsive: [
                {
                    breakpoint: 991,
                    settings: {
                        slidesToShow: 3,
                        dots: true,
                        arrows: false,
                    }
                },
                {
                    breakpoint: 767,
                    settings: {
                        slidesToShow: 1,
                        dots: true,
                        arrows: false,
                    }
                }
            ]
        });
        $('#subcategory-slider').slick({
            infinite: true,
            slidesToShow: 4,
            slidesToScroll: 1,
            arrows: false,
            dots: true,
            autoplaySpeed: 2000,
            responsive: [
                {
                    breakpoint: 1405,
                    settings: {
                        slidesToShow: 2,
                    }
                },
                {
                    breakpoint: 991,
                    settings: {
                        slidesToShow: 3,
                        dots: true,
                        arrows: false,
                    }
                },
                {
                    breakpoint: 767,
                    settings: {
                        slidesToShow: 1,
                        dots: true,
                        arrows: false,
                    }
                }
            ]
        });

        // $('.subcategory-slider').slick({
        //     slidesToShow: 3,
        //     slidesToScroll: 1,
        //     infinite: true,
        //     autoplay: false,
        //     autoplaySpeed: 3000,
        //     dots: false,
        //     arrows: false,
        //     prevArrow: '<button type="button" class="slick-prev" style="margin-left:-11px;">&#10094;</button>',
        //     nextArrow: '<button type="button" class="slick-next">&#10095;</button>',
        //     responsive: [
        //         {
        //             breakpoint: 1024,
        //             settings: {
        //                 slidesToShow: 2
        //             }
        //         },
        //         {
        //             breakpoint: 768,
        //             settings: {
        //                 slidesToShow: 1
        //             }
        //         }
        //     ]
        // });
    });

    // let currentIndex = 0;

    // const testimonials = [
    //     {
    //         text: 'Facilisis pretium viverra varius tempus ligula natoque fermentum dictumst scelerisque vehicula euismod sed nam sapien rhoncus tristique eros erat nullam class venenatis hendrerit montes ut vestibulum integer orci luctus primis fringilla sem bibendum donec fames congue suscipit sociis turpis.',
    //         name: 'Joe Root',
    //         role: 'Happy Client',
    //         image: '{{ asset("front-end/images/Group 5747.png") }}', // Add image for large display
    //     },
    //     {
    //         text: 'Congue parturient interdum penatibus sem lacus ultricies mi varius nisi dictum fusce volutpat sociosqu vehicula ac nullam curae malesuada gravida id natoque tristique convallis porta scelerisque quam class senectus nisl auctor fermentum montes hendrerit tempor orci.',
    //         name: 'Jane Doe',
    //         role: 'Satisfied Client',
    //         image: '{{ asset("front-end/images/Group 5748.png") }}',
    //     },
    //     {
    //         text: 'Laoreet per malesuada montes lorem tincidunt id natoque parturient suspendisse senectus a scelerisque sem quis a parturient et nam leo diam in amet elit et phasellus a vulputate. Pharetra neque euismod pharetra fringilla augue curae urna nisi purus parturient iaculis conubia a fringilla odio vestibulum dictum. Convallis ridiculus dictumst a nam urna.',
    //         name: 'John Smith',
    //         role: 'Grateful Client',
    //         image: '{{ asset("front-end/images/Group 5749.png") }}',
    //     },
    // ];
    // $(document).ready(function () {
    //     let testimonials = @json($testimonials); // Get testimonials from Laravel
    //     let latestTestimonials = @json($latestTestimonials);
    //     let currentIndex = 0;
    //     const imagesToShow = 3; 
    //     let latestselectedTestimonial = latestTestimonials[0];
    //     $(".patients .testimonial-text").fadeOut(200, function () {
    //             $(this).html(latestselectedTestimonial.message).fadeIn(200);
    //         });
    //     function updateVisibleThumbnails() {
    //         $(".thumbnail").each(function (index) {
    //             if ((index >= currentIndex && index < currentIndex + imagesToShow) || 
    //                 (currentIndex + imagesToShow > testimonials.length && index < (currentIndex + imagesToShow) % testimonials.length)) {
    //                 $(this).removeClass("hidden").addClass("visible");
    //             } else {
    //                 $(this).removeClass("visible").addClass("hidden");
    //             }
    //         });
    //     }

    //     function updateTestimonial(index) {
    //         let selectedTestimonial = testimonials[index];

    //         // Animate content change
    //         $(".patientsSlider").css({
    //             "position": "relative",
    //             "right": "-100%",
    //             "opacity": "0"
    //         }).animate({
    //             "right": "0",
    //             "opacity": "1"
    //         }, 500);

    //         // Change the large image
    //         $("#large-image").fadeOut(200, function () {
    //             $(this).attr("src", "storage/images/" + selectedTestimonial.image).fadeIn(200);
    //         });

    //         // Update testimonial text
    //         $(".patients .testimonial-text").fadeOut(200, function () {
    //             $(this).html(selectedTestimonial.message).fadeIn(200);
    //         });

    //         // Update name
    //         $(".patient-name").fadeOut(200, function () {
    //             $(this).text(selectedTestimonial.name).fadeIn(200);
    //         });

    //         // Update role/designation
    //         $(".patient-role").fadeOut(200, function () {
    //             $(this).text(selectedTestimonial.designation ?? "Happy Client").fadeIn(200);
    //         });

    //         // Highlight active thumbnail
    //         $(".thumbnail").removeClass("active");
    //         $(".thumbnail").eq(index).addClass("active");
    //     }

    //     // Thumbnail click event
    //     $(".thumbnail").click(function () {
    //         const clickedIndex = $(this).index();
    //         // Adjust the currentIndex so the clicked image is centered
    //         if (clickedIndex + 1 > currentIndex + imagesToShow) {
    //             currentIndex = clickedIndex - (imagesToShow - 1);
    //         } else {
    //             currentIndex = Math.max(0, clickedIndex);
    //         }
    //         updateVisibleThumbnails();
    //         updateTestimonial(clickedIndex);
    //     });
        
    //     // Next button functionality
    //     $(".next-btn").click(function () {
    //         currentIndex = (currentIndex + 1) % testimonials.length;
    //         updateVisibleThumbnails();
    //         updateTestimonial(currentIndex);
    //     });

    //     // Previous button functionality
    //     $(".prev-btn").click(function () {
    //         currentIndex = (currentIndex - 1 + testimonials.length) % testimonials.length;
    //         updateVisibleThumbnails();
    //         updateTestimonial(currentIndex);
    //     });

    //     // Initialize the first set of visible thumbnails
    //     updateVisibleThumbnails();
    // });
    
    $(document).ready(function () {
        let testimonials = @json($testimonials);
        let latestTestimonials = @json($latestTestimonials);
        let currentIndex = 0;
        const imagesToShow = 3;
        let latestselectedTestimonial = latestTestimonials[0];

        // Initialize with the latest testimonial
        if(latestselectedTestimonial){
            $(".patients .testimonial-text").html(latestselectedTestimonial.message || "");
        }

        function updateVisibleThumbnails() {
            $(".thumbnail").each(function (index) {
                if ((index >= currentIndex && index < currentIndex + imagesToShow) || 
                    (currentIndex + imagesToShow > testimonials.length && index < (currentIndex + imagesToShow) % testimonials.length)) {
                    $(this).removeClass("hidden").addClass("visible");
                } else {
                    $(this).removeClass("visible").addClass("hidden");
                }
            });
        }

        function updateTestimonial(index) {
            let selectedTestimonial = testimonials[index];

            // Animate elements moving up slowly
            $(".patientsSlider, #large-image, .patients .testimonial-text, .patient-name, .patient-role")
                .animate({ opacity: 0, top: "-40px" }, 500, function () {

                    // Update content after animation completes
                    $("#large-image").attr("src", "storage/images/" + selectedTestimonial.image);
                    $(".patients .testimonial-text").html(selectedTestimonial.message);
                    $(".patient-name").text(selectedTestimonial.name);
                    $(".patient-role").text(selectedTestimonial.designation ?? "Happy Client");

                    // Slide elements back down and fade in slowly
                    $(this).css({ top: "40px" }).animate({ opacity: 1, top: "0px" }, 500);
                });

            // Highlight active thumbnail
            $(".thumbnail").removeClass("active");
            $(".thumbnail").eq(index).addClass("active");
        }

        // Thumbnail click event
        $(".thumbnail").click(function () {
            const clickedIndex = $(this).index();
            if (clickedIndex + 1 > currentIndex + imagesToShow) {
                currentIndex = clickedIndex - (imagesToShow - 1);
            } else {
                currentIndex = Math.max(0, clickedIndex);
            }
            updateVisibleThumbnails();
            updateTestimonial(clickedIndex);
        });

        // Next button functionality
        $(".next-btn").click(function () {
            currentIndex = (currentIndex + 1) % testimonials.length;
            updateVisibleThumbnails();
            updateTestimonial(currentIndex);
        });

        // Previous button functionality
        $(".prev-btn").click(function () {
            currentIndex = (currentIndex - 1 + testimonials.length) % testimonials.length;
            updateVisibleThumbnails();
            updateTestimonial(currentIndex);
        });

        // Initialize the first set of visible thumbnails
        updateVisibleThumbnails();
    });
    // for FAQ
    window.onload = () => {
        const firstFaq = document.querySelector('.faq-item');
        if (firstFaq) {
            const firstQuestion = firstFaq.querySelector('.faq-question');
            const firstAnswer = firstFaq.querySelector('.faq-answer');
            const firstIcon = firstFaq.querySelector('.faq-icon');

            openFaq(firstQuestion, firstAnswer, firstIcon);
        }
    };

    document.querySelectorAll('.faq-question').forEach(question => {
        question.addEventListener('click', () => {
            const parent = question.closest('.faq-item');
            const answer = parent.querySelector('.faq-answer');
            const icon = question.querySelector('.faq-icon');

            // Check if already open
            const isOpen = answer.style.maxHeight && answer.style.maxHeight !== '0px';

            // Close all
            document.querySelectorAll('.faq-item').forEach(item => {
                const a = item.querySelector('.faq-answer');
                const i = item.querySelector('.faq-icon');
                const q = item.querySelector('.faq-question');

                a.style.maxHeight = null;
                a.classList.remove('open');
                i.classList.remove('rotate');
                q.classList.remove('active');
            });

            if (!isOpen) {
                openFaq(question, answer, icon);
            }
        });
    });

    function openFaq(question, answer, icon) {
        answer.style.maxHeight = answer.scrollHeight + 'px'; // ✅ This is correct
        answer.classList.add('open');
        icon.classList.add('rotate');
        question.classList.add('active');
    }


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
                    $('.newsletter_success').text("Successfully subscribed!").css({
                        "color": "green",
                        "margin-top": "10px",
                        "margin-left": "17px"
                    }).fadeIn();
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
                    $('.newsletter_success').text(errorMessage).css({
                        "color": "red",
                        "margin-top": "10px",
                        "margin-left": "17px"
                    }).fadeIn();
                    setTimeout(function() {
                        $('.newsletter_success').fadeOut();
                        $('.email_text').val('');
                    }, 5000);
                }
            });
        });
    });

</script>
@endsection
