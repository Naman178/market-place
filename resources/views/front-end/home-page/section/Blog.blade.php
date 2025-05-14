<!-- Integration section start -->
@php
    use Carbon\Carbon;
@endphp

<div class="int_bg blog mb-37">
    <div class="container">
        <p class="plugin-label">
            <span class="label-line"></span> Recent Posts
        </p>
        <div class="d_flex">
            <div class="integration">
                <h1>Latest From Our <span class="underline">Blog</span></h1>
                {{-- <img class="vector2_img" src="front-end/images/Vector 10.png" alt="not found"> --}}
            </div>
            <div class="arrow-container w-70">
                <a href="javascript:void(0)" role="button" data-slide="prev" id="blog-left-arrow-btn"><span class="arrow left-arrow"></span></a>
                <a href="javascript:void(0)" role="button" data-slide="next" id="blog-right-arrow-btn"><span class="arrow right-arrow"></span></a>
            </div>
        </div>
        <div id="blogCarousel" >
            <div class="row blog-slider">
                @foreach ($Blogs as $blog)
                    <div class="col-4 match-height-item">
                      <a href="{{ route('blog_details', ['category' => $blog->categoryname->name, 'slug' => Str::slug($blog->title)]) }}">
                        <img class="blog_img" src="{{ asset('storage/images/' . $blog->image) }}" alt="not found">
                        <div class="item">
                           <p class="badge">{{ $blog->categoryname->name ?? ''}}</p>
                            <h3 class="mb-4 mt-1">{{ $blog->title }}</h3>
                            <div class="blog_p">{!! $blog->short_description ?? '' !!}</div>
                            <div class="d-flex">
                                <a href="{{ route('blog_details', ['category' => $blog->categoryname->name, 'slug' => Str::slug($blog->title)]) }}" class="integration_know d-flex align-items-center">
                                    <span>Read More</span>
                                    <img class="know_arrow d-flex align-items-center" src="front-end/images/blue_arrow.png" alt="not found" style="margin-top: 1px;">
                                </a>
                            </div>
                        </div>
                        </a>
                    </div>
                @endforeach
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

// Call the function on page load and resize
document.addEventListener('DOMContentLoaded', () => {
    setEqualHeights('.blog-slider .item');
});

window.addEventListener('resize', () => {
    setEqualHeights('.blog-slider .item');
});
</script>
<!-- Integration section end -->
