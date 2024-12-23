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
            <h4><a href="{{ route('dashboard') }}" class="text-uppercase">{{ $site['value']['site_name'] ?? 'Infinity' }}</a>
                | {{ trans('custom.Blog_title') }} </h4>
        </div>
        @can('Blog-create')
            <div class="col-sm-12 col-md-6">
                <a href="{{ route('Blog-edit', 'new') }}" class="btn btn-primary btn-sm"
                    style="float: right !important;">Create {{ trans('custom.Blog_title') }}</a>
            </div>
        @endcan
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row mb-4">
        <div class="col-md-12 mb-4">
            <div class="card text-left">
                <div class="card-body">
                    <h4 class="card-title mb-3">Blog</h4>
                    <div class="table-responsive">
                        <table id="zero_configuration_table" class="display table table-striped table-bordered"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Image</th>
                                    <th>Status</th>
                                    <th>Short Description</th>
                                    <th>Long Description</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $count=1 @endphp
                                @foreach ($Blog as $key => $list)
                                    <tr>
                                        <td>{{ $count }}</td>
                                        <td>{{ $list->title }}</td>
                                        <td>
                                            <img src="{{ asset('storage/images/' .$list->image) }}" alt="not found" width="100px">
                                        </td>   
                                        <td>
                                            <label class="switch mr-4">
                                                <input type="checkbox" @if ($list->status == 1) checked @endif onclick="confirmStatusChange({{ $list->blog_id }} , {{ $list->status }})">
                                                <span class="slider round"></span>
                                            </label>
                                        
                                            @if ($list->status == 1)
                                                Published
                                            @else
                                                Not Published
                                            @endif
                                        </td>
                                        <td>{{ $list->short_description }}</td>  
                                        <td>{{ $list->long_description }}</td>                                   
                                        <td>{{ \Carbon\Carbon::parse($list->created_at)->format('d-m-Y') }}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-primary" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                                <span class="_dot _inline-dot"></span>
                                                <span class="_dot _inline-dot"></span>
                                                <span class="_dot _inline-dot"></span>
                                            </button>
                                            <div class="dropdown-menu" x-placement="bottom-start"
                                                style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 34px, 0px);">
                                                @can('Blog-edit')
                                                    <a class="dropdown-item"
                                                        href="{{ route('Blog-edit', $list->blog_id) }}"><i
                                                            class="nav-icon i-Pen-2 font-weight-bold" aria-hidden="true"> </i>
                                                        Edit</a>
                                                @endcan
                                                @can('Blog-delete')
                                                    <div class="dropdown-item Blog-delete-btn"
                                                        data-url="{{ route('Blog-delete', $list->blog_id) }}"><i
                                                            class="nav-icon i-Close-Window font-weight-bold" aria-hidden="true">
                                                        </i> Delete</div>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                    @php $count++ @endphp
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Image</th>
                                    <th>Status</th>
                                    <th>Short Description</th>
                                    <th>Long Description</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
