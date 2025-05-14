<div class="features integration faq-section">
    <div class="container">
        <img class="question_img" src="{{ asset('front-end/images/question_mark.png') }}" alt="not found">
        <h1><span class="underline">FAQ</span></h1>
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
        <img class="second_question_img" src="{{ asset('front-end/images/second_question_mark.png') }}" alt="not found">
    </div>
</div>

<div class="api_section">
    <div class="container">
        <div class="highlighted-section">
            <img class="pattern_img" src="{{ asset('front-end/images/design.png') }}" alt="not found">
            <img class="pattern2_img" src="{{ asset('front-end/images/design.png') }}" alt="not found">
            <img src="{{ asset('front-end/images/Rectangle 28.png') }}" alt="not found" class="rectangle_img">
            <div class="banner">         
                <h1>It takes less than a minute to get started</h1>
                <li class="white_signup-wrapper mt-1">
                    <a class="white_signup_btn" href="{{route('user-login')}}">
                    <svg viewBox="0 0 100 100" preserveAspectRatio="none">
                        <polyline points="99,1 99,99 1,99 1,1 99,1" class="bg-line"></polyline>
                        <polyline points="99,1 99,99 1,99 1,1 99,1" class="hl-line"></polyline>
                        </svg>
                        <span>Get Your FREE API Key</span>
                    </a>
                  </li>                  
                {{-- <a href="#" class="button mt-2">Get Your FREE API Key</a> --}}
             </div>
             <img class="pattern3_img" src="{{ asset('front-end/images/design2.png') }}" alt="not found">
             <img class="pattern4_img" src="{{ asset('front-end/images/design2.png') }}" alt="not found">
        </div>
    </div>
</div>


{{-- <div class="tech">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-sm-12 col-12">
                <h1><span>Stay Updated with the Latest Innovations!</span></h1>
                <div class="latest">
                    <p class="integra_p testimonial-text">
                        Subscribe to our newsletter and be the first to receive updates on new features, exclusive offers, and expert insights.
                    </p>
                </div>
            </div>
            <div class="col-lg-5 col-sm-12 col-12 mt-13">
                <div class="row">
                    <div class="col-lg-8 col-sm-12 col-12">
                    <input type="text" class="email_text" value="" name="email" placeholder="Enter your email">
                    </div>
                    <div class="col-lg-4 col-sm-12 col-12 text-end">
                        <div class="sign_up_btn" data-route="{{route('newsletter')}}">
                           Sign Up
                        </div>
                        <li class="signup-wrapper"><a class="blue_common_btn sign_up_btn"data-route="{{route('newsletter-add')}}"> 
                            <svg viewBox="0 0 100 100" preserveAspectRatio="none">
                                <polyline points="99,1 99,99 1,99 1,1 99,1" class="bg-line"></polyline>
                                <polyline points="99,1 99,99 1,99 1,1 99,1" class="hl-line"></polyline>
                          </svg><span> Sign Up </span></a></li>
                    </div>
                    <span class="newsletter_success"></span>
                    <div class="tech_text">
                    <p class="integra_p testimonial-text small_text">By clicking Sign Up you're confirming that you agree with our Terms and Conditions.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}
