@extends('layouts.master')
@php
    use App\Models\Settings;
    $site = Settings::where('key','site_setting')->first();
@endphp
@section('title')
    <title>{{$site["value"]["site_name"] ?? "Infinity"}} | Roles</title>
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
        <h4><a href="{{route('dashboard')}}" class="text-uppercase">{{$site["value"]["site_name"] ?? "Infinity"}}</a> | Role </h4>
    </div>
    <div class="col-sm-12 col-md-6">
        @can('role-create')
            <a href="{{ route('roles.create') }}" class="btn btn-primary btn-sm" style="float: right !important;">Create Role</a>
        @endcan
    </div>
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
                                <th>Role Name</th>
                                <th>Permissions</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $key => $role)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>
                                    @if(!empty($role['permission']))
                                        @foreach($role['permission'] as $data)
                                            <label class="badge badge-success">{{ $data->name }}</label>
                                        @endforeach
                                    @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="_dot _inline-dot"></span>
                                            <span class="_dot _inline-dot"></span>
                                            <span class="_dot _inline-dot"></span>
                                        </button>
                                        <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 34px, 0px);">
                                            @can('role-edit')
                                                <a class="dropdown-item" href="{{ route('roles.edit',$role->id) }}"><i class="nav-icon i-Pen-2 font-weight-bold" aria-hidden="true"> </i> Edit</a>
                                            @endcan
                                            @can('role-delete')
                                                {{-- <form action="{{ route('roles.destroy',$role->id) }}" method="Post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item"><i class="nav-icon i-Close-Window font-weight-bold" aria-hidden="true"> </i> Delete</button>
                                                </form> --}}
                                                <a href="javascript:void(0);"  class="dropdown-item delete-role-btn"  data-url="{{ route('roles.destroy',$role->id) }}"> <i class="nav-icon i-Close-Window font-weight-bold" aria-hidden="true"></i> Delete </a>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Role Name</th>
                                <th>Permissions</th>
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
    <script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
@endsection
@section('bottom-js')
<script type="text/javascript">
     $(document).ready(function() {
        $('.delete-role-btn').click(function(event) {
            event.preventDefault();
            var submitURL = $(this).data("url");
            
            Swal.fire({
                title: 'Are you sure you want to delete this role?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4caf50',
                cancelButtonColor: '#f44336',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: submitURL,
                        type: 'POST',  
                        data: { _method: 'DELETE' }, 
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        success: function(response) {
                           if (response.success) {
                                toastr.info(response.message || 'Role deleted successfully');

                                // Optional: delay before redirecting
                                setTimeout(() => {
                                    window.location.href = response.redirect;
                                }, 1500);
                            } else {
                                toastr.error(response.message || 'Something went wrong');
                            }
                        },
                        error: function (xhr) {
                            toastr.error('Server error occurred');
                        },
                    });
                }
            });
        });
    });
</script>
@endsection
