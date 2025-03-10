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
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $count=1 @endphp
                                    @foreach ($newsletter as $key => $list)
                                        <tr>
                                            <td>{{ $count }}</td>
                                            <td>{{ $list->email}}</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-primary" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                    <span class="_dot _inline-dot"></span>
                                                    <span class="_dot _inline-dot"></span>
                                                    <span class="_dot _inline-dot"></span>
                                                </button>
                                                <div class="dropdown-menu" x-placement="bottom-start"
                                                style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 34px, 0px);">
                                                    <a class="dropdown-item delete-newsetter-btn"
                                                        data-url="{{ route('newsletter-delete', $list->id) }}"><i
                                                            class="nav-icon  i-Close-Window font-weight-bold" aria-hidden="true"> </i>
                                                        Delete</a>
                                                </div>
                                            </td>
                                        </tr>
                                        @php $count++ @endphp
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Email</th>
                                        <th>Action</th>
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
    <script>
          $('.delete-newsetter-btn').click(function(event) {
                event.preventDefault();
                var submitURL = $(this).attr("data-url");
                Swal.fire({
                    title: 'Are you sure you want to delete this newsletter?',
                    //text: 'If you delete this, it will be gone forever.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#4caf50',
                    cancelButtonColor: '#f44336',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = submitURL;
                    }
                });
            });
    </script>
@endsection
