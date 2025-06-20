@extends('layouts.master')
@php
    use App\Models\Settings;
    $site = Settings::where('key', 'site_setting')->first();
@endphp
@section('title')
    <title>{{ $site['value']['site_name'] ?? 'Infinity' }} | {{ trans('custom.items_title') }}</title>
@endsection
@section('page-css')
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/datatables.min.css') }}">
    <link href=" https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.min.css " rel="stylesheet">
    <style>
        .custom-content {
            margin: auto;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .image-prev {
            height: auto;
            width: 100px;
            position: relative;
        }

        /* .image-prev img {
            position: absolute;
            height: 100%;
            width: 100%;
            object-fit: cover;
        } */

        .dropdown-item {
            cursor: pointer;
        }
    </style>
@endsection
@section('main-content')
    <div class="breadcrumb">
        <div class="col-sm-12 col-md-6">
            <h4><a href="{{ route('dashboard') }}" class="text-uppercase">{{ $site['value']['site_name'] ?? 'Infinity' }}</a>
                | {{ trans('custom.items_title') }} </h4>
        </div>
        @can('items-create')
            <div class="col-sm-12 col-md-6">
                <a href="{{ route('items-edit', 'new') }}" class="btn btn-primary btn-sm"
                    style="float: right !important;">Create {{ trans('custom.item_title') }}</a>
            </div>
        @endcan
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row mb-4">
        <div class="col-md-12 mb-4">
            <div class="card text-left">
                <div class="card-body">
                    <h4 class="card-title mb-3">{{ trans('custom.items_title') }}</h4>
                    <div class="table-responsive">
                        <table id="zero_configuration_table" class="display table table-striped table-bordered"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Item Type</th>
                                    <th>Thumbnail</th>
                                    <th>Date Created</th>
                                    <th>Sales</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $count = 1; @endphp
                                @foreach ($items as $key => $list)
                                    <tr>
                                        <td>{{ $count }}</td>
                                        <td>{{ $list->name }}</td>
                                        <td>{{ $list->pricing->pricing_type }}</td>
                                        <td>
                                            <div class="image-prev">
                                                <img id="items_image_prev" class="rounded-lg"
                                                    src="@if (!empty($list->thumbnail_image)) {{ asset('storage/items_files/' . $list->thumbnail_image) }} @endif">
                                            </div>
                                        </td>
                                        <td>{{ Helper::dateFormatForView($list->created_at) }}</td>
                                        <td>{{ $list->order->count() ?? 0 }}</td>
                                        <td>
                                            <span class="badge {{ $list->status == 1 ? 'badge-success' : 'badge-danger' }} status-bagde mb-2">{{ $list->status == 1 ? 'Active' : 'Inactive' }}</span>
                                            <select class="form-control items-status-dropdown"
                                                data-url="{{ route('items-status', ['id' => $list->id]) }}">
                                                <option value="1" {{ $list->status == 1 ? 'selected' : null }}>
                                                    Active</option>
                                                <option value="0" {{ $list->status == 0 ? 'selected' : null }}>
                                                    Inactive</option>
                                            </select>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-primary" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                                <span class="_dot _inline-dot"></span>
                                                <span class="_dot _inline-dot"></span>
                                                <span class="_dot _inline-dot"></span>
                                            </button>
                                            <div class="dropdown-menu" x-placement="bottom-start"
                                                style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 34px, 0px);">
                                                @can('items-edit')
                                                    <a class="dropdown-item" href="{{ route('items-edit', $list->id) }}"><i
                                                            class="nav-icon i-Pen-2 font-weight-bold" aria-hidden="true"> </i>
                                                        Edit</a>
                                                @endcan
                                                @can('items-delete')
                                                    <div class="dropdown-item delete-btn"
                                                        data-url="{{ route('items-delete', $list->id) }}"><i
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
                                    <th>Name</th>
                                    <th>Item Type</th>
                                    <th>Thumbnail</th>
                                    <th>Date Created</th>
                                    <th>Sales</th>
                                    <th>Status</th>
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
@endsection
@section('bottom-js')
    @include('pages.items.items-script')
@endsection
