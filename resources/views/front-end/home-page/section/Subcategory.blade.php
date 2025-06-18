<!-- subcategory section start -->
<div class="category">
    <div class="container">
        {{-- <img class="mt-65" src="front-end/images/Group 1000002949.png" alt="not found"> --}}
        <div class="d-flex" style="align-items: center;">
            <div class="subcategory">
                <h2>Shop By <span class="underline"> Category</span></h2>
                {{-- <img class="vector2_img" src="front-end/images/Vector 2.png" alt="not found"> --}}
            </div>
            <div class="arrow-container w-70" style="margin-top: 0px;">
                {{-- <a href="javascript:void(0)" role="button" data-slide="prev" id="subcategroy-left-arrow-btn"><span
                        class="arrow left-arrow"></span></a>
                <a href="javascript:void(0)" role="button" data-slide="next" id="subcategroy-right-arrow-btn"><span
                        class="arrow right-arrow"></span></a> --}}
            </div>
        </div>

        {{-- <div id="subcategoryCarousel" class="subcategory-slider">
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
                        <div style="display: flex; justify-content:space-between; align-items:center; position: absolute; top:0; bottom:0; width:100%;">
                            <a href="#" class="subcategory_know" style="width:100%; text-align:center;">
                                <span style="background-color:#007ac1; color:white; padding:10px;">Know More</span>
                            </a>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div> --}}
       <div class="social_media pb_10">
            <div class="container text-center pb_30">
                <div class="row justify-content-center">
                    @foreach ($subcategory as $item)
                        <div class="col-lg-2 col-md-4 col-sm-6 mb-4">
                            <a href="{{ route('product.list.show', ['subcategory' => Str::slug($item->name ?? '')]) }}">
                                <div class="wsus__categories_item_2">
                                    <div class="icon">
                                        <img src="{{ asset('storage/sub_category_images/' . $item->image) }}" alt="Sub category" class="img-fluid w-100">
                                    </div>
                                    <h3>{{ $item->name }}</h3>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="d-flex justify-content-end">
                    @if (!empty($subcategory))
                        <a href="{{ route('product.list.show', ['subcategory' => Str::slug($item->name ?? '')]) }}" class="blue_common_btn"> 
                            <svg viewBox="0 0 100 100" preserveAspectRatio="none">
                            <polyline points="99,1 99,99 1,99 1,1 99,1" class="bg-line"></polyline>
                            <polyline points="99,1 99,99 1,99 1,1 99,1" class="hl-line"></polyline>
                            </svg><span>View All </span></a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<!-- subcategory section end -->
