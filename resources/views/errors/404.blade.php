@extends('front-end.common.master')

@section('title', '404 Page Not Found')

@section('styles')
<style>
    .error-page {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 150px 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .error-content {
        max-width: 600px;
    }

    .error-title {
        font-size: 36px;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .error-message {
        font-size: 16px;
        color: #555;
        margin-bottom: 30px;
    }

    .search-box {
        margin-bottom: 30px;
    }

    .search-box input {
        width: 100%;
        padding: 10px 15px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 16px;
    }

    .helpful-links a {
        display: block;
        margin-bottom: 12px;
        color: #3f57ff;
        font-weight: 500;
        text-decoration: none;
    }

    .helpful-links a:hover {
        text-decoration: underline;
    }

    .error-image {
        max-width: 400px;
    }

    .error-image img {
        width: 100%;
        height: auto;
        object-fit: contain;
    }

    @media (max-width: 768px) {
        .error-page {
            flex-direction: column;
            text-align: center;
        }

        .error-image {
            margin-top: 40px;
        }
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="error-page">
        <div class="error-content">
            <div class="error-title">We lost that page…</div>
            <div class="error-message">Sorry, the page you are looking for doesn't exist or has been moved. Here are some helpful links:</div>

            <div class="search-box">
                <input type="text" placeholder="Search our site" />
            </div>

            <div class="helpful-links">
                <a href="{{route('blog-index')}}">Documentation →</a>
                <a href="{{route('blog-index')}}">Our blog →</a>
                <a href="{{route('product.list.show')}}">Our Products →</a>
            </div>
        </div>

        <div class="error-image">
            <img src="https://market-place-main.infinty-stage.com/storage/sub_category_images/6855390d68dfd_avada.png" alt="404 Crystal">
        </div>
    </div>
</div>
@endsection
