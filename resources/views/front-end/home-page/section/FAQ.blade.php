<div class="features integration faq-section">
    <div class="container">
        <img class="question_img" src="{{ asset('front-end/images/question_mark.png') }}" alt="not found">
        <h1><span>FAQ</span></h1>
        <img class="vector2_img" src="front-end/images/Vector 9.png" alt="not found">
        <div class="faq">
            @foreach ($FAQs as $key => $FAQ)
            <div class="faq-item">
                <div class="faq-question">
                    {{ $FAQ->question ?? '' }}
                    <span class="faq-icon"></span>
                </div>
                <div class="faq-answer">
                    <p>{{ $FAQ->answer ?? '' }}</p>
                </div>
            </div>
            <hr>
            @endforeach
        </div>
        <img class="second_question_img" src="{{ asset('front-end/images/second_question_mark.png') }}" alt="not found">
    </div>
</div>

<div class="faq-section api_section">
    <div class="container">
        <div class="highlighted-section">
            <img class="pattern_img" src="{{ asset('front-end/images/design.png') }}" alt="not found">
            <img class="pattern2_img" src="{{ asset('front-end/images/design.png') }}" alt="not found">
            <img src="{{ asset('front-end/images/Rectangle 28.png') }}" alt="not found">
            <div class="banner">         
                <h1>It takes less than a minute to get started</h1>
                <a href="#" class="button mt-2">Get Your FREE API Key</a>
             </div>
             <img class="pattern3_img" src="{{ asset('front-end/images/design2.png') }}" alt="not found">
             <img class="pattern4_img" src="{{ asset('front-end/images/design2.png') }}" alt="not found">
        </div>
    </div>
</div>


<div class="tech">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-sm-12 col-12">
                <h1><span>Stay in the tech loop.</span></h1>
                <div>
                    <p class="integra_p testimonial-text">
                        Eget mi justo justo velit nam vestibulum a maecenas facilisis sem consectetur ad at hac
                        himenaeos nisl gravida nulla augue.
                    </p>
                </div>
            </div>
            <div class="col-lg-5 col-sm-12 col-12 mt-13">
                <div class="row">
                    <div class="col-lg-9 col-sm-12 col-12">
                    <input type="text" class="email_text" value="" name="email" placeholder="Enter your email">
                    </div>
                    <div class="col-lg-3 col-sm-12 col-12 mt-2 text-end">
                        <div class="sign_up_btn" data-route="{{route('newsletter')}}">
                           Sign Up
                        </div>
                    </div>
                    <span class="newsletter_success"></span>
                    <p class="integra_p testimonial-text small_text">By clicking Sign Up you're confirming that you agree with our Terms and Conditions.</p>
                </div>
            </div>
        </div>
    </div>
</div>
