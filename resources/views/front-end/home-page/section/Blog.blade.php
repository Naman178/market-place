<!-- Integration section start -->
@php
    use Carbon\Carbon;
@endphp
<div class="int_bg blog">
    <div class="container">
        <img class="mt-65" src="front-end/images/Group 1000002961.png" alt="not found">
        <div class="d-flex">
            <div class="integration">
                <h1>Latest From Our <span>Blog</span></h1>
                <img class="vector2_img" src="front-end/images/Vector 10.png" alt="not found">
            </div>
            <div class="arrow-container w-70">
                <a href="javascript:void(0)" role="button" data-slide="prev" id="blog-left-arrow-btn"><span class="arrow left-arrow"></span></a>
                <a href="javascript:void(0)" role="button" data-slide="next" id="blog-right-arrow-btn"><span class="arrow right-arrow"></span></a>
            </div>
        </div>
        <div id="blogCarousel" >
            <div class="row blog-slider">
                @foreach ($Blogs as $blog)
                    <div class="col-4">
                        <div class="item">
                            <div class="mb-5">
                                <img class="blog_img match-height-item" src="{{ asset('storage/images/' . $blog->image) }}" alt="not found">
                            </div>
                            <a href="javascript:void(0)" class="blogcategoryBtn">{{ $blog->category_name }}</a>
                            <h3 class="mb-4" style="margin-top: 38px;">{{ $blog->title }}</h3>
                            <div class="d-flex">
                                <a href="{{ route('blog_details', ['blog_id' => $blog->blog_id]) }}" class="integration_know d-flex align-items-center">
                                    <span>Read More</span>
                                    <img class="know_arrow d-flex align-items-center" src="front-end/images/blue_arrow.png" alt="not found" style="margin-top: 1px;">
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<!-- Integration section end -->
