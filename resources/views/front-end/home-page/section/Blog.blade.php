<!-- Integration section start -->
@php
    use Carbon\Carbon;
@endphp

<div class="int_bg blog mb-37">
    <div class="container">
        <p class="plugin-label">
            <span class="label-line"></span> Discover & Learn
        </p>
        <div class="d_flex blog_head">
            <div class="integration">
                <h2>Trends & Insights for Developers</h2>
            </div>
            <div class="arrow-container">
                <a href="javascript:void(0)" role="button" data-slide="prev" id="blog-left-arrow-btn"><img class="know_arrow" src="{{ asset('front-end/images/up-right-arrow-dark.png') }}" alt="Left Arrow"></a>
                <a href="javascript:void(0)" role="button" data-slide="next" id="blog-right-arrow-btn"><img class="know_arrow" src="{{ asset('front-end/images/up-right-arrow-dark.png') }}" alt="Right Arrow"></a>
            </div>
        </div>
        <div id="blogCarousel" >
            <div class="row blog-slider">
                @foreach ($Blogs as $blog)
                    <div class="match-height-item">
                        <a href="{{ route('blog_details', ['category' => Str::slug($blog->categoryname->name), 'slug' => Str::slug($blog->title)]) }}">
                            <img class="blog_img" src="{{ asset('storage/images/' . $blog->image) }}" alt="Blog Image">
                        </a>
                        <div class="item">
                            <div class="blog_badge">
                                <label class="blog_date"><i class="fa fa-calendar" aria-hidden="true"></i> 23 June 2025</label>
                                <p class="badge">{{ $blog->categoryname->name ?? ''}}</p>
                            </div>
                            <a class="blog_title" href="{{ route('blog_details', ['category' => Str::slug($blog->categoryname->name), 'slug' => Str::slug($blog->title)]) }}">
                                <h3 class="">{{ $blog->title }}</h3>
                            </a>
                            <div class="blog_p">{!! Str::words($blog->short_description ?? '', 18, '...') !!}</div>
                            <a href="{{ route('blog_details', ['category' => $blog->categoryname->name, 'slug' => Str::slug($blog->title)]) }}" class="read_more_btn">
                                <span class="text-line">
                                    <span class="text">Read More</span>
                                    <img class="know_arrow" src="{{ asset('front-end/images/up-right-arrow-dark.png') }}" alt="Arrow">
                                </span>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="more_blogs">
                <a  class="white_btn d-inline-block" href="https://market-place-main.infinty-stage.com/shop"><span>More Blogs</span> <img class="know_arrow" src="https://market-place-main.infinty-stage.com/front-end/images/up-right-arrow-light.png" alt="Button Arrow"></a>
            </div>
        </div>
    </div>
</div>
<script>
    function setEqualHeights(selector) {
    let maxHeight = 0;

    // Reset the height to auto for recalculation
    document.querySelectorAll(selector).forEach(item => {
        item.style.height = 'auto';
    });

    // Find the maximum height
    document.querySelectorAll(selector).forEach(item => {
        const height = item.offsetHeight;
        if (height > maxHeight) {
            maxHeight = height;
        }
    });

    // Apply the maximum height to all items
    document.querySelectorAll(selector).forEach(item => {
        item.style.height = `${maxHeight}px`;
    });
}

</script>
<!-- Integration section end -->
