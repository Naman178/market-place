@extends('front-end.common.master')@section('meta')
<title>Market Place | {{ $seoData->title ?? 'Default Title' }} - {{ $seoData->description ?? 'Default Description' }}
</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="{{ $seoData->description ?? 'Default description' }}">
<meta name="keywords" content="{{ $seoData->keywords ?? 'default, keywords' }}">
<meta property="og:title" content="{{ $seoData->title ?? 'Default Title' }}">
<meta property="og:description" content="{{ $seoData->description ?? 'Default description' }}">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:type" content="website">
@endsection
@section('styles')
<link rel="stylesheet" href="{{ asset('front-end/css/register.css') }}">
<style>
    .cust-page-padding {
        /* padding: 2rem 10rem 5rem; */
    }

    h1.feature_heading {
        margin-top: 0;
    }

    .terms-and-condition h1,
    .privacy-policy h1,
    .cancellation-and-refund-policy h1,
    .about-us h1 {
        margin-bottom: 50px;
    }

    .feature_heading {
        font-style: normal;
        font-weight: 600;
        font-size: 40px;
        line-height: 52px;
        color: #182433;
        margin: 80px 0 85px;
    }

    #faqAccordian .card {
        border: none;
        border-bottom: 1px solid #007ac1;
    }

    .accordion>.card:not(:last-of-type) {
        border-bottom: 0;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
    }

    #faqAccordian .card-header {
        background: transparent;
        border: none;
        padding: 25px 0;
    }

    .faq-link {
        font-style: normal;
        font-weight: 400;
        font-size: 16px;
        line-height: 25px;
        color: #000000;
        margin-top: 18.96px;
        margin-bottom: 23.91px;
        transition: all 0.3s ease 0s;
        padding-left: 30px;
    }

    .faq-link::before {
        content: '';
        background: url(public/storage/homepage/faqdot.svg);
        position: absolute;
        width: 19px;
        height: 19px;
        left: 5px;
        filter: invert(33%) sepia(80%) saturate(745%) hue-rotate(190deg) brightness(90%) contrast(85%);
        top: 35px;
        transition: 0.2s ease;
    }

    .faq-link::after {
        content: '';
        background: url(public/storage/homepage/down-arrow.svg);
        position: absolute;
        width: 10px;
        height: 14px;
        right: 24px;
        top: 31px;
    }

    .accordion {
        width: 100%;
        margin: auto;
    }

    .accordion-item {
        border-radius: 5px;
        margin-bottom: 8px;
    }

    .accordion-header {
        padding: 15px;
        font-size: 1.1em;
        cursor: pointer;
        display: flex;
        margin-left: 15px;
        justify-content: space-between;
        align-items: center;
    }

    .accordion-body {
        padding: 15px;
        display: none;
    }

    .accordion-body.show {
        display: block;
    }

    .collapsed.faq-link::after {
        transform: rotate(180deg);
    }

    @media (max-width: 991px) {
        .register-container .title h3{
            font-size: 30px;
            line-height: 30.2px;
        }
        .faq {
            margin-top: 50px;
        }
    }
</style>
@endsection
@section('content')
{{-- <div class="cust-page-padding">
        <div class="container">  
            <div class="row justify-content-center"> 
                <div class="terms-and-condition cust-page-padding">          
                    <h1 class="text-center feature_heading">FAQ</h1>
                    @foreach ($term_conditions as $term_condition)
                        <h4>{{ $term_condition->title ?? '' }}</h4>        
                        <p>{{ $term_condition->description ?? '' }}</p>
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div> --}}
<div class="cust-page-padding">
    <div class="faq">
        <div class="container  register-container">
            <div class="title">
                <h3><span class="txt-black">Frequently Asked </span><span class="color-blue underline-text"> Questions</span></h3>
            </div> 
            {{-- <div class="d-flex flex-wrap">
                <div class="faq-heading-row">
                    <div class="faq-button_n_text d-lg-block d-none">
                        <p>Have more questions?</p>
                        <a href="{{ Route('contact-us') }}"
                            class="pink_blue_grad_button d-inline-flex align-items-center mx-auto online_sell_btn">Contact
                            Us &nbsp; <img src="{{ asset('storage/Logo_Settings/right_arrow.svg') }}"
                                alt="arrow"></a>
                    </div>
                </div>
                <div class="faq-faq-row w-100">

                    <div class="accordion" id="faqAccordian">
                        @foreach ($FAQs as $key => $FAQ)
                        <div class="card">
                            <div class="accordion-item">
                                <div class="accordion-header faq-link {{ $loop->first ? 'collapsed' : '' }}" onclick="toggleAccordion(this)">
                                    {{ $FAQ->question ?? '' }}
                                </div>
                                <div class="accordion-body {{ $loop->first ? 'show' : '' }}">
                                    <p>{{ $FAQ->answer ?? '' }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    
                    </div>
                </div>
            </div> --}}
            <div class="features integration faq-section">
                <div class="container">
                    <div class="faq">
                        @foreach ($FAQs as $key => $FAQ)
                        <div class="faq-item">
                            <div class="faq-question">
                                {{ $FAQ->question ?? '' }}
                                <span class="faq-icon"></span>
                            </div>
                            <div class="faq-answer">
                                <p>{!! $FAQ->answer ?? '' !!}</p>
                            </div>
                        </div>
                        <hr>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
//  function toggleAccordion(header) {
//     const body = header.nextElementSibling;
//     if (body && body.classList) {
//         body.classList.toggle("show");
//         header.classList.toggle("collapsed");
//     } else {
//         console.error("Accordion structure issue: 'accordion-body' not found for this header.");
//     }
// }
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

</script>
@endsection
