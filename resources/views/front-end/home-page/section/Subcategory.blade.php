<!-- subcategory section start -->
<div class="category">
    <div class="container">
        <div class="d-flex title-box">
            <div>
                <p class="plugin-label">
                    <span class="label-line"></span> Curated for Developers
                </p>
                <h2>Categories That Deliver</h2>
            </div>
            <div class="arrow-container">
                <div class="d-flex justify-content-center">
                    <a  class="white_btn d-inline-block" href="{{ route('product.list.show') }}"><span>All Categories</span> <img class="know_arrow" src="https://market-place-main.infinty-stage.com/front-end/images/up-right-arrow-light.png" alt="Button Arrow"></a>
                </div>
            </div>
        </div>
       <div class="social_media pb_10">
            <div class="container text-center pb_30 pr-0 pl-0">
                <div class="row justify-content-center">
                    @foreach ($subcategory as $item)
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <a href="{{ route('product.list.show', ['subcategory' => Str::slug($item->name ?? '')]) }}">
                                <div class="wsus__categories_item_2">
                                    <h3>{{ $item->name }}</h3>
                                    <a href="#" class="wsus__categories_item_2_link">Newest</a>
                                    <div class="icon">
                                        <a  href="{{ route('product.list.show') }}"><img src="{{ asset('storage/sub_category_images/' . $item->image) }}" alt="Sub category" class="img-fluid w-100"></a>
                                    </div>    
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<!-- subcategory section end -->
