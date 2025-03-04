@extends('front-end.common.master')@section('meta')
@section('styles')
    <link rel="stylesheet" href="{{ asset('front-end/css/home-page.css') }}">
@endsection
@section('meta')
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
@section('content')
<div class="container">
    <div class="row">
        <div class="col-xl-8 col-lg-7">
            <div class="wsus__product_details_img">
                <img  src="{{ asset('public/storage/items_files/' . $item->thumbnail_image) }}"
                    alt="product" class="img-fluod w-100">
            </div>

            <div class="wsus__product_details_text">
                <ul class="nav nav-pills" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                            aria-selected="true"><i class="fal fa-layer-group" aria-hidden="true"></i>
                            Description</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
                            aria-selected="false" tabindex="-1"><i class="far fa-comments" aria-hidden="true"></i>
                            Comments (0)</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact"
                            aria-selected="false" tabindex="-1"><i class="far fa-star" aria-hidden="true"></i>
                            Review (0)</button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button onclick="addWishlist(13)"><i class="far fa-heart" aria-hidden="true"></i>
                            Wishlist</button>
                    </li>

                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                        aria-labelledby="pills-home-tab" tabindex="0">
                        <div class="wsus__pro_description">
                           {!! $item->html_description !!}
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab"
                        tabindex="0">
                        <div class="wsus__pro_det_comment">
                            <h4>Comments</h4>
                        </div>
                        <div class="wsus__pagination">
                        </div>
                        <form class="wsus__comment_input_area" id="productCommentForm" method="POST">
                            <input type="hidden" name="_token" value="EiN2ctLecCH1L0Qwp9TuW50QIA6Dp95xQCR2MRCv">
                            <h3>Leave a Comment</h3>
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="wsus__comment_single_input">
                                        <fieldset>
                                            <legend>Comment*</legend>
                                            <textarea rows="7" name="comment" placeholder="Type here.."></textarea>
                                            <input type="hidden" name="product_id" value="13">
                                        </fieldset>
                                    </div>
                                    <button class="common_btn" id="submitBtn" type="submit">Submit Comment</button>
                                    <button class="common_btn d-none" id="showSpain" type="submit"><i
                                            class="fas fa-spinner fa-spin" aria-hidden="true"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab"
                        tabindex="0">
                        <div class="wsus__pro_det_review">
                            <h3>Reviews</h3>
                        </div>

                        <div class="wsus__pagination">
                        </div>

                        <form class="wsus__comment_input_area" id="productReviewForm" method="POST">
                            <input type="hidden" name="_token" value="EiN2ctLecCH1L0Qwp9TuW50QIA6Dp95xQCR2MRCv">
                            <h3>Write Your Reviews</h3>
                            <p>
                                <i class="fas fa-star s1" aria-hidden="true"></i>
                                <i class="fas fa-star s2" aria-hidden="true"></i>
                                <i class="fas fa-star s3" aria-hidden="true"></i>
                                <i class="fas fa-star s4" aria-hidden="true"></i>
                                <i class="fas fa-star s5" aria-hidden="true"></i>
                                <span class="total_star">(0.0)</span>
                            </p>
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="wsus__comment_single_input">
                                        <fieldset>
                                            <legend>comment*</legend>
                                            <textarea rows="7" name="review" placeholder="Type here.."></textarea>
                                            <input type="hidden" class="star" name="rating" value="">
                                            <input type="hidden" id="product_id" name="product_id" value="13">
                                            <input type="hidden" id="author_id" name="author_id" value="1">
                                        </fieldset>
                                    </div>

                                    <button class="common_btn" id="reviewSubmitBtn" type="submit">Submit
                                        Review</button>
                                    <button class="common_btn d-none" id="reviewShowSpain" type="submit"><i
                                            class="fas fa-spinner fa-spin" aria-hidden="true"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-5">
            <div class="wsus__sidebar pl_30 xs_pl_0" id="sticky_sidebar">
                <div class="wsus__sidebar_licence">
                    <div class="select_licance">
                        <select class="select_js" name="variant_id" id="variant_id" style="display: none;">
                            <option value="16">HD : 720 X 1280</option>
                            <option value="17">Full HD : 720 X 1280</option>
                        </select>
                        <div class="nice-select select_js" tabindex="0"><span class="current">HD : 720 X
                                1280</span>
                            <ul class="list">
                                <li data-value="16" class="option selected">HD : 720 X 1280</li>
                                <li data-value="17" class="option">Full HD : 720 X 1280</li>
                            </ul>
                        </div>
                    </div>
                    <h2>
                        <span>$</span> <strong id="price">49</strong>
                    </h2>
                    <input type="hidden" value="1" id="currency_rate">
                    <input type="hidden" value="49" id="image_price">

                    <input type="hidden" value="49" id="script_regular_price">
                    <input type="hidden" value="" id="script_extend_price">
                    <input type="hidden" value="video" id="product_type">
                    <input type="hidden" value="Construction service management software" id="product_name">
                    <input type="hidden" value="construction-service-management-software" id="slug">
                    <input type="hidden" value="React Native" id="category_name">
                    <input type="hidden" value="8" id="category_id">
                    <input type="hidden" value="uploads/custom-images/thumb_image-2023-09-21-12-51-19-3733.png"
                        id="product_image">
                    <input type="hidden" value="Abdullah Mamun" id="author_name">
                    <input type="hidden" value="1" id="author_id">
                    <ul class="button_area mt_50 d-flex flex-wrap mt-3">
                        <li><a class="live" target="__blank"
                                href="https://codecanyon.net/user/quomodotheme/portfolio">Live Preview</a></li>
                        <li><a class="common_btn" href="javascript:;" onclick="addToCard(13)">add to cart</a></li>
                    </ul>
                    <ul class="sell_rating mt_20 d-flex flex-wrap justify-content-between">
                        <li><i class="far fa-cart-arrow-down" aria-hidden="true"></i> 0</li>
                        <li><i class="far fa-comments" aria-hidden="true"></i> 0</li>
                        <li><i class="far fa-star" aria-hidden="true"></i> 0</li>
                    </ul>
                </div>

                <div class="wsus__sidebar_pro_info mt_30">
                    <h3>product Info</h3>
                    <ul>
                        <li><span>Released</span> September 21,2023</li>
                        <li><span>Updated</span> October 09,2023</li>
                        <li><span>File Type</span> video</li>
                        <li><span>High Resolution</span> Yes</li>
                        <li><span>Cross browser</span> Yes</li>
                        <li><span>Documentation</span> Yes</li>
                        <li><span>Responsive</span> Yes</li>
                        <li><span>Tags</span>
                            <p>
                                <a
                                    href="https://quomodothemes.website/alasmart/products?keyword=construction">Construction,</a>
                                <a href="https://quomodothemes.website/alasmart/products?keyword=service">service,</a>
                                <a href="https://quomodothemes.website/alasmart/products?keyword=php">PHP,</a>
                                <a href="https://quomodothemes.website/alasmart/products?keyword=laravel">Laravel,</a>
                            </p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')

@endsection
