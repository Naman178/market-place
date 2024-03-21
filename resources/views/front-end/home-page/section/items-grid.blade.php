<div class="container items-container">
    <div class="title">
        <h3><span class="txt-black">Our</span> <span class="color-blue underline-text">Plans</span></h3>
    </div>
    <div class="row">
        @foreach ($data['items'] as $key => $list)
            <div class="col bg-blue">
                <div class="item-wrapper">
                    <div class="header">
                        <div class="thumb-img">
                            <img src="@if (!empty($list->thumbnail_image)) {{ asset('storage/items_files/' . $list->thumbnail_image) }} @endif" alt="{{ $list->name }}">
                        </div>
                        <div class="item-name txt-white">
                            <h3>{{ $list->name }}</h3>
                        </div>
                    </div>
                    <div class="description">
                        <p class="txt-white">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
                    </div>
                    <div class="price">
                        <h2>&#8377; {{ (int) $list->pricing->fixed_price }} <span class="duration">/monthly</span></h2>
                    </div>
                    <div class="feature txt-white">
                        <p class="title">What's included</p>
                        <ul>
                            @foreach($list->features as $feature)
                                <li>{{ $feature->key_feature }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="btn">
                        <a href="{{ $list->preview_url }}" target="_blank" rel="noopener noreferrer">Get started</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>