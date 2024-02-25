@extends('layouts.master')
@php
    use App\Models\Settings;
    $site = Settings::where('key','site_setting')->first();
@endphp
@section('title')
    <title>{{$site["value"]["site_name"] ?? "Infinity"}} | {{ trans('custom.sub_category_title') }}</title>
@endsection
@section('page-css')
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">
    <link href=" https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.min.css " rel="stylesheet">
    <style>
        .custom-content {
            margin: auto;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .image-prev{
            height: 100px;
            width: 100px;
            position: relative;
        }
        .image-prev img{
            position: absolute;
            height: 100%;
            width: 100%;
            object-fit: cover;
        }

        .dropdown-item{
            cursor: pointer;
        }
    </style>
@endsection
@section('main-content')
<div class="breadcrumb">
    <div class="col-sm-12 col-md-6">
        <h4><a href="{{route('dashboard')}}" class="text-uppercase">{{$site["value"]["site_name"] ?? "Infinity"}}</a> | {{ trans('custom.sub_category_title') }} </h4>
    </div>
    @can('sub-category-create')
        <div class="col-sm-12 col-md-6">
            <a href="{{route('sub-category-edit','new')}}" class="btn btn-primary btn-sm" style="float: right !important;">Create {{ trans('custom.sub_category_title') }}</a>
        </div>
    @endcan
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="row mb-4">
    <div class="col-md-12 mb-4">
        <div class="card text-left">
            <div class="card-body">
                <h4 class="card-title mb-3">Sub Categories</h4>
                <div class="table-responsive">
                    <table id="zero_configuration_table" class="display table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Image</th>
                                <th>Date Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                         <tbody>
                            @php $count=1 @endphp
                            @foreach($sub_categories as $key => $list)
                            <tr>
                                <td>{{$count}}</td>
                                <td>{{$list->name}}</td>
                                <td>{{$list->category_name}}</td>
                                <td>
                                    <div class="image-prev">
                                        <img id="category_image_prev" src="@if(!empty($list->image)){{asset('storage/sub_category_images/'.$list->image)}}@endif">
                                    </div>
                                </td>
                                <td>{{Helper::dateFormatForView($list->created_at)}}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-primary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="_dot _inline-dot"></span>
                                        <span class="_dot _inline-dot"></span>
                                        <span class="_dot _inline-dot"></span>
                                    </button>
                                    <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 34px, 0px);">
                                    @can('sub-category-edit')
                                        <a class="dropdown-item" href="{{route('sub-category-edit',$list->id)}}"><i class="nav-icon i-Pen-2 font-weight-bold" aria-hidden="true"> </i> Edit</a>
                                    @endcan
                                    @can('sub-category-delete')
                                        <div class="dropdown-item delete-btn" data-id="{{$list->id}}"><i class="nav-icon i-Close-Window font-weight-bold" aria-hidden="true"> </i> Delete</div>
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
                                <th>Category</th>
                                <th>Image</th>
                                <th>Date Created</th>
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
    <script src="{{asset('assets/js/vendor/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/datatables.script.js')}}"></script>
    <script src=" https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.all.min.js "></script>
@endsection
@section('bottom-js')
    @include('pages.sub-category.script')
@endsection
