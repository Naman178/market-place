@extends('front-end.common.master')
@section('title', 'Home')
@section('styles')
<link rel="stylesheet" href="{{ asset('front-end/css/home-page.css') }}">
@endsection
@section('content')
@include('front-end.home-page.section.items-grid')
@endsection