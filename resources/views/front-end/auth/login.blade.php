@extends('front-end.common.master')
@section('title', 'Login')
@section('styles')
   <link rel="stylesheet" href="{{ asset('front-end/css/register.css') }}">
@endsection
@section('content')
<div class="container pt-5 pb-5 register-container">
    <div class="title">
        <h3><span class="txt-black">Login</h3>
    </div>
    <form action="#" method="POST">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="row  border p-3 pt-4 pb-4 border-radius-1">
                    <a href="{{ url('/user-login/google') }}" class="btn btn-google">Continue with Google</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
@section('scripts')
@endsection
