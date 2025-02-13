@extends('layouts.master')
@php
    use App\Models\Settings;
    $site = Settings::where('key', 'site_setting')->first();
@endphp
@section('title')
    <title>{{ $site['value']['site_name'] ?? 'Infinity' }} | {{ trans('custom.Blog_title') }}</title>
@endsection
@section('page-css')
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/datatables.min.css') }}">
    <link href=" https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.min.css " rel="stylesheet">
    <style>
        .dropdown-item {
            cursor: pointer;
        }

    </style>
@endsection
@section('main-content')
    <div class="breadcrumb">
        <div class="col-sm-12 col-md-6">
            <h4><a href="{{ route('dashboard') }}" class="text-uppercase">{{ $site['value']['site_name'] ?? 'Infinity' }}</a> | Newsletter  </h4>
        </div>
    </div>
    @can('newsletter-list')
        <div class="separator-breadcrumb border-top"></div>
        <div class="row mb-4">
            <div class="col-md-12 mb-4">
                <div class="card text-left">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Newsletter</h4>
                        <div class="table-responsive">
                            <table id="zero_configuration_table" class="display table table-striped table-bordered"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $count=1 @endphp
                                    @foreach ($newsletter as $key => $list)
                                        <tr>
                                            <td>{{ $count }}</td>
                                            <td>{{ $list->email}}</td>
                                        </tr>
                                        @php $count++ @endphp
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <h1><b>You don't have permission to view this page</b></h1>
    @endcan
   
@endsection
@section('page-js')
    <script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatables.script.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
@endsection
@section('bottom-js')
    @include('pages.Blog.Blog-script')
@endsection
