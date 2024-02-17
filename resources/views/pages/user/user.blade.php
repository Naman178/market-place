@extends('layouts.master')
@php
    use App\Models\Settings;
    $site = Settings::where('key','site_setting')->first();
@endphp
@section('title')
    <title>{{$site["value"]["site_name"] ?? "Infinity"}} | User</title>
@endsection
@section('page-css')
    <link rel="stylesheet" href="{{asset('assets/styles/vendor/datatables.min.css')}}">
    <style>
        .custom-content {
            margin: auto;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }
    </style>
@endsection
@section('main-content')
<div class="breadcrumb">
    <div class="col-sm-12 col-md-6">
        <h4><a href="{{route('dashboard')}}" class="text-uppercase">{{$site["value"]["site_name"] ?? "Infinity"}}</a> | User </h4>
    </div>
    @can('user-create')
        <div class="col-sm-12 col-md-6">
            <a href="{{route('user-edit','new')}}" class="btn btn-primary btn-sm" style="float: right !important;">Create User</a>
        </div>
    @endcan
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="row mb-4">
    <div class="col-md-12 mb-4">
        <div class="card text-left">
            <div class="card-body">
                <h4 class="card-title mb-3">Users</h4>
                <div class="table-responsive">
                    <table id="zero_configuration_table" class="display table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Date Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                         <tbody>
                            @foreach($user as $key => $list)
                            <tr>
                                <td>{{$list->id}}</td>
                                <td>{{$list->fname}}</td>
                                <td>{{$list->lname}}</td>
                                <td>{{$list->email}}</td>
                                <td>
                                @if(!empty($list->getRoleNames()))
                                    @foreach($list->getRoleNames() as $role)
                                    <label class="badge badge-success">{{ $role }}</label>
                                    @endforeach
                                @endif
                                </td>
                                <td>{{Helper::dateFormatForView($list->created_at)}}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-primary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="_dot _inline-dot"></span>
                                        <span class="_dot _inline-dot"></span>
                                        <span class="_dot _inline-dot"></span>
                                    </button>
                                    <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 34px, 0px);">
                                    @can('user-edit')
                                        <a class="dropdown-item" href="{{route('user-edit',$list->id)}}"><i class="nav-icon i-Pen-2 font-weight-bold" aria-hidden="true"> </i> Edit</a>
                                    @endcan
                                    @can('user-delete')
                                        <a class="dropdown-item" href="{{route('user-delete',$list->id)}}"><i class="nav-icon i-Close-Window font-weight-bold" aria-hidden="true"> </i> Delete</a>
                                    @endcan
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Role</th>
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
@endsection
@section('bottom-js')
<script type="text/javascript">
</script>
@endsection
