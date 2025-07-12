<div class="features integration faq-section">
    <div class="container">
        <h2>FAQ</h2>
        <div class="faq">
            @foreach ($FAQs as $key => $FAQ)
            <div class="faq-item">
                <div class="faq-question">
                    {{ $FAQ->question ?? '' }}
                    <span class="faq-icon"></span>
                </div>
                <div class="faq-answer">
                    {!! $FAQ->answer ?? '' !!}
                </div>
            </div>
            <hr>
            @endforeach
        </div>
    </div>
    
    <div class="highlighted-section">
    <!-- Left patterns -->
    <img class="pattern pattern-left pattern-top" src="{{ asset('front-end/images/design.png') }}" alt="Pattern Left Top">
    <img class="pattern pattern-left pattern-bottom" src="{{ asset('front-end/images/design.png') }}" alt="Pattern Left Bottom">

    <!-- Right patterns -->
    <img class="pattern pattern-right pattern-top" src="{{ asset('front-end/images/design.png') }}" alt="Pattern Right Top">
    <img class="pattern pattern-right pattern-bottom" src="{{ asset('front-end/images/design.png') }}" alt="Pattern Right Bottom">
    
    <!-- Banner Content -->
    <div class="banner">
        <h2>Start Building Smarter Today</h2>
        <p>Join thousands of developers and creators using our tools to ship faster and grow their businesses.</p>
        <li class="white_signup-wrapper">
            <a  class="white_btn d-inline-block today" href="{{ route('user-login') }}"><span>Explore the Marketplace</span> <img class="know_arrow" src="https://market-place-main.infinty-stage.com/front-end/images/up-right-arrow-dark.png" alt="Button Arrow"></a>
        </li>
    </div>
</div>
</div>

