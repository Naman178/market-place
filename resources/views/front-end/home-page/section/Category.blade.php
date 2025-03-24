<!-- category section start -->
<div class="category">
    <div class="container">
        {{-- <img class="mt-65" src="front-end/images/Group 1000002949.png" alt="not found"> --}}
        <div class="d-flex" style="align-items: center;">
            <div>
                <h1>Shop By Category</h1>
                <img class="vector2_img" src="front-end/images/Vector 2.png" alt="not found">
            </div>
            <div class="arrow-container w-70" style="margin-top: 0px;">
                {{-- <a href="javascript:void(0)" role="button" data-slide="prev" id="categroy-left-arrow-btn"><span
                        class="arrow left-arrow"></span></a>
                <a href="javascript:void(0)" role="button" data-slide="next" id="category-right-arrow-btn"><span
                        class="arrow right-arrow"></span></a> --}}
            </div>
        </div>

        {{-- <div id="categoryCarousel" class="category-slider">
            @foreach ($category as $item)
                <a href="{{ route('category.list', ['category' => $item->id]) }}">
                    <div class="category-slide" style="cursor: pointer;">
                        <div style="position: absolute; top:0; z-index:1;">
                            <p class="category_p mt-4 ml-20" style="color: white; font-weight:500;">{{$item->name}}</p>
                        </div>
                        <div class="item" style="background-color: #FFFFFF; width:447px; margin-right:25px; margin-bottom:65px; border:3px solid #fff; height:400px; position: relative;">
                            <div class="">
                                <div>
                                    <img src="{{ asset('public/storage/category_images/' . $item->image) }}" alt="" style="width: 100%; height:395px;">
                                </div>
                            </div>
                            <div style="display: flex; justify-content:space-between; align-items:center; position: absolute; top:0; bottom:0; width:100%;">
                                <a href="#" class="category_know" style="width:100%; text-align:center;">
                                    <span style="background-color:#007ac1; color:white; padding:10px;">Know More</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
            </div>
        </div> --}}
        <div class="social_media pb_10">
            <div class="container text-center category-slider pb_30">
                @foreach ($category as $item)
                    <div class="col-xl-6" style="width: 100%; display: inline-block;">
                        <a href="{{ route('product.list', ['categoryOrSubcategory' => $item->id]) }}" tabindex="0">
                        <div class="wsus__categories_item_2">
                            <div class="icon">
                                <img src="{{ asset('public/storage/category_images/' . $item->image) }}" alt="category" class="img-fluid w-100">
                            </div>
                            <h3>{{$item->name}}</h3>
                        </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- category section end -->
