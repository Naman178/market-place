@extends('front-end.common.master')
@push('page-css')
<link rel="stylesheet" href="{{ asset('front-end/css/home-page.css') }}">
@endpush
@include('front-end.common.header')
@include('front-end.home-page.section.items-grid')
@include('front-end.common.footer')