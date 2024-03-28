<div class="container items-container">
    <div class="title">
        <h3><span class="txt-black">Our</span> <span class="color-blue underline-text">Plans</span></h3>
    </div>
    <div class="row">
        @foreach ($data['items'] as $key => $item)
            @if ($item && $item->features && $item->pricing)
                <div class="col bg-blue">
                    <div class="item-wrapper">
                        <div class="header">
                            <div class="thumb-img">
                                <img src="@if (!empty($item->thumbnail_image)) {{ asset('storage/items_files/' . $item->thumbnail_image) }} @endif" alt="{{ $item->name }}">
                            </div>
                            <div class="item-name txt-white">
                                <h3>{{ $item->name }}</h3>
                            </div>
                        </div>
                        <div class="description">
                            <p class="txt-white">{{ $item->description }}</p>
                        </div>
                        <div class="price">
                            <h2>&#8377; {{ (int) $item->pricing->fixed_price }} <span class="duration">/monthly</span></h2>
                        </div>
                        <div class="feature txt-white">
                            <p class="title">What's included</p>
                            <ul>
                                @foreach($item->features as $feature)
                                    @if ($feature)
                                        <li>{{ $feature->key_feature }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                        <div class="btn">
                            <a href="{{ route("checkout", ["id" => base64_encode($item->id)]) }}" target="_blank" rel="noopener noreferrer">Get started</a>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>

