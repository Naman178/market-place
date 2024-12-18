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
                <a href="#blogCarousel" role="button" data-slide="prev"><span class="arrow left-arrow"></span></a>
                <a href="#blogCarousel" role="button" data-slide="next"><span class="arrow right-arrow"></span></a>
            </div>
        </div>

        <div id="blogCarousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                @php
                    $chunks = $Blogs->chunk(3);
                    $active = true; 
                @endphp
        
                @foreach ($chunks as $chunk)
                    <div class="carousel-item {{ $active ? 'active' : '' }}">
                        <div class="row">
                            @foreach ($chunk as $blog)
                                <div class="col-4 match-height-item">
                                    <div class="item">
                                        <div class="mb-5">
                                            <img class="blog_img match-height-item" src="{{ asset('storage/images/' . $blog->image) }}" alt="not found">
                                        </div>
                                        <h3 class="mb-4">{{ $blog->title }}</h3>
                                        <p class="mb-4">{!! $blog->short_description !!}</p>
                                        <div class="d-flex mb-4">
                                            <span> 
                                                Post by: <strong>{{ $blog->uploaded_by }} </strong> | 
                                                {{ \Carbon\Carbon::parse($blog->created_at)->format('F d, Y') }}<br>
                                                <i class='far fa-comment-alt'></i> {{ $blog->comments_count }} Comments 
                                                <i class="fa fa-share-alt" aria-hidden="true"></i> {{ $blog->shares_count }} Shares
                                            </span>
                                        </div>
                                        <div class="d-flex">
                                            <a href="{{ route('blog_details', ['blog_id' => $blog->blog_id]) }}" class="integration_know">
                                                Read More
                                                <span>
                                                    <img class="know_arrow" src="front-end/images/blue_arrow.png" alt="not found">
                                                </span>
                                            </a>                                            
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @php $active = false; @endphp
                @endforeach
            </div>
        </div>
    </div>
</div>
<!-- Integration section end -->
