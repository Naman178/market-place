<!-- subcategory section start -->
<div class="int_bg">
    <div class="container">
        {{-- <img class="mt-65" src="front-end/images/Group 1000002949.png" alt="not found"> --}}
        <div class="d-flex" style="align-items: center;">
            <div class="subcategory">
                <h1><span>Subcategory</span></h1>
                <img class="vector2_img" src="front-end/images/Vector 2.png" alt="not found" style="margin-left: 1px;">
            </div>
            <div class="arrow-container w-70" style="margin-top: 0px;">
                <a href="javascript:void(0)" role="button" data-slide="prev" id="subcategroy-left-arrow-btn"><span
                        class="arrow left-arrow"></span></a>
                <a href="javascript:void(0)" role="button" data-slide="next" id="subcategroy-right-arrow-btn"><span
                        class="arrow right-arrow"></span></a>
            </div>
        </div>

        <div id="subcategoryCarousel" class="subcategory-slider">
            @foreach ($subcategory as $item)
            <a href="{{ route('product.list', ['subcategory' => $item->id]) }}">
                <div class="subcategory-slide" style="cursor: pointer;">
                    <div style="position: absolute; top:0; z-index:1;">
                        <h1 class="subcategory_p mt-4 ml-20" style="color: white; font-weight:500;">{{$item->name}}</h1>
                    </div>
                    <div class="item" style="background-color: #FFFFFF; width:447px; margin-right:25px; margin-bottom:65px; border:3px solid #fff; height:400px; position: relative;">
                        <div class="">
                            <div>
                                <img src="{{ asset('public/storage/sub_category_images/' . $item->image) }}" alt="" style="width: 100%; height:395px;">
                            </div>
                        </div>
                        {{-- <div style="display: flex; justify-content:space-between; align-items:center; position: absolute; top:0; bottom:0; width:100%;">
                            <a href="#" class="subcategory_know" style="width:100%; text-align:center;">
                                <span style="background-color:#007ac1; color:white; padding:10px;">Know More</span>
                            </a>
                        </div> --}}
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</div>
<!-- subcategory section end -->
