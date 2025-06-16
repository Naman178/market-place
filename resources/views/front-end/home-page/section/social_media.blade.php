<div class="gray_bg p-4 mb-0">
    <div class="container text-center social_media_slider">
        @foreach ($socialmedia as $social_media)
            <a href="{{ $social_media->link }}"><img class="mr-7" src="{{ asset('front-end/images/'.$social_media->image) }}" alt="not found"></a>   
        @endforeach
    </div>
</div>
