@extends('front-end.common.master')
@section('styles')
<link rel="stylesheet" href="{{ asset('front-end/css/home-page.css') }}">

<!-- Scoped Bootstrap CSS -->
<link rel="stylesheet" href="{{ asset('front-end/css/scoped-bootstrap.css') }}">
<!-- Slick CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
<!-- Latest Font Awesome CDN -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endsection
@section('meta')
<title>Market Place | {{ $seoData->title ?? 'Default Title' }} - {{ $seoData->description ?? 'Default Description' }}</title>
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
<div class="blog_details" style="background-color: #b1b1b11f;">
    <div class="container blog_padding">
        <div class="row">
            <div class="col-md-8 border-right blog-main-card">
                <h2 class="text-capitalize">{{ $blog->title }} </h2>
                <p>{!! $blog->short_description !!} </p>
                <div class="row mb-4">
                    <div class="col-md-10">
                        Post by: <strong>{{ $blog->uploaded_by }} </strong> |
                        {{ \Carbon\Carbon::parse($blog->created_at)->format('F d, Y') }}
                    </div>
                    <div class="col-md-2 d-flex justify-content-end align-items-center">
                        <a href="#" class="social-share mx-2" data-platform="facebook" data-blog-id="{{ $blog->blog_id }}" data-user-id="{{ Auth::id() }}">
                            <img class="facebook_img" src="{{ asset('storage/Logo_Settings/footer_facebook.png') }}" alt="facebook">
                        </a>
                        <a href="#" class="social-share" data-platform="twitter" data-blog-id="{{ $blog->blog_id }}" data-user-id="{{ Auth::id() }}">
                            <img class="facebook_img" src="{{ asset('storage/Logo_Settings/twitter.png') }}" alt="twitter">
                        </a>
                    </div>

                </div>
                <div class="mb-5">
                    <img class="blog_detail_img match-height-item" src="{{ asset('storage/images/' . $blog->image) }}" alt="not found">
                </div>
                <div>
                    <p>{!! $blog->long_description !!} </p>
                </div>
                @foreach ($Blogcontents as $content)
                    <h2 class="text-capitalize">{{ $content->content_heading }} </h2>
                    <img class="blog_detail_img match-height-item" src="{{ asset('storage/images/' . $content->content_image) }}" alt="not found">
                    <p>{!! $content->content_description_1 !!} </p>
                    <p>{!! $content->content_description_2 !!} </p>
                @endforeach
            </div>
            <div class="col-md-4 ">
                @if ($blog->related_blogs)
                    <div class="related_blogs sticky">
                        <ul style="padding: 10px 17px 27px 18px; background: white; margin-top:0px; color: #4d4d4d; font-family: 'Work Sans';">
                            <li class="mt-2">  <h3>Related Blogs</h3></li>
                            @foreach ($blog->related_blogs as $relatedBlogId)
                                @php
                                    $relatedBlog = \App\Models\Blog::find($relatedBlogId);
                                @endphp
                                @if ($relatedBlog)
                                    <li class="border-bottom mt-4">
                                       <a href="{{ route('blog_details', ['category' => $relatedBlog->categoryname->name, 'slug' => Str::slug($relatedBlog->title)]) }}">
                                            <img class="related_blog_img match-height-item mb-2" src="{{ asset('storage/images/' . $relatedBlog->image) }}" alt="not found">
                                            <span class="related_blog_title text-capitalize" style="text-align: start; font-weight: 600; font-size: 14px; color: #4d4d4d; font-family: 'Work Sans';"> {{ $relatedBlog->title }}</span>
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            <div class="col-md-8" style="padding-right: 0px; padding-left:0px;">
                <h1 class="card-title" style="margin-top:15px; margin-bottom:15px; font-size:1.5rem;">Comments</h1>
            </div>
            <div class="col-md-8" style="background-color:#ffffff;">
                {{-- <div class="comment border-primary mb-2 mt-4" style="background-color: #f6f6f6;">
                    <div class="card-body" style="padding-top:15px;">
                        <form class="comment-form" action="{{route('blog-comment-post', $blog->blog_id)}}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="comment">Comment</label>
                                <textarea class="form-control tinymce-textarea" name="comment" id="comment" rows="3"></textarea>
                                <div id="quill-editor" style="height: 200px; background-color: white;"></div>
                                <input type="hidden" name="comment" id="quill-content">
                            </div>
                            <button type="submit" class="pink-blue-grad-button d-inline-block border-0">Submit</button>
                        </form>
                    </div>
                </div> --}}
                {{-- <livewire:comments :post="$post"/> --}}
                @if ($post) 
                    <livewire:comments :model="$post" />  
                @endif

            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.tiny.cloud/1/8ohuouqsfj9dcnrapjxg1t1aqvftbsfowsu6tnil1fw8yk2i/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    //  tinymce.init({
    //     selector: 'textarea',
    //     menubar: false,
    //     plugins: 'advlist autolink lists link image charmap print preview anchor',
    //     toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | bullist numlist outdent indent | link image',
    //     height: 200
    // });

    var quill = new Quill('#quill-editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline', 'strike'],
                ['blockquote', 'code-block'],
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'script': 'sub'}, { 'script': 'super' }],
                [{ 'indent': '-1'}, { 'indent': '+1' }],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'font': [] }],
                [{ 'align': [] }]
            ]
        },
        placeholder: 'Write your comment here...',
    });

    document.querySelector(".comment-form").addEventListener("submit", function(event) {
        let quillContent = quill.root.innerHTML.trim(); 
        if (quillContent === "<p><br></p>" || quillContent === "") { 
            toastr.error("Comment field is required!"); 
            event.preventDefault(); 
            return;
        }
        document.getElementById('quill-content').value = quillContent;
    });

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.social-share').forEach(function(element) {
            element.addEventListener('click', function(event) {
                event.preventDefault();
                var platform = this.getAttribute('data-platform');
                var blogId = this.getAttribute('data-blog-id');
                var userId = this.getAttribute('data-user-id');
                var url;

                // Send AJAX request to store share data
                fetch('{{ route("share.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        platform: platform,
                        blog_id: blogId,
                        user_id: userId
                    })
                }).then(response => {
                    return response.json();
                }).then(data => {
                    console.log('Share data stored successfully:', data);
                }).catch(error => {
                    console.error('Error storing share data:', error);
                });

                // Open the respective social media sharing or login page
                if (platform === 'facebook') {
                    // Direct share URL
                    url = `https://www.facebook.com/sharer/sharer.php?u={{ urlencode (route('blog_details', ['category' => $blog->categoryname->name, 'slug' => Str::slug($blog->title)])) }}`;

                    // Open Facebook sharing or login page
                    window.open(url, '_blank').focus();
                    window.open('https://www.facebook.com/', '_blank');
                } else if (platform === 'twitter') {
                    // Direct share URL
                    url = `https://twitter.com/intent/tweet?url={{ urlencode (route('blog_details', ['category' => $blog->categoryname->name, 'slug' => Str::slug($blog->title)])) }}&text={{ urlencode($blog->title) }}`;

                    // Open Twitter sharing or login page
                    window.open(url, '_blank').focus();
                    window.open('https://x.com/i/flow/login', '_blank');
                }
            });
        });
    });

</script>
@endsection
