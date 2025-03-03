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
            <h4><a href="{{ route('dashboard') }}" class="text-uppercase">{{ $site['value']['site_name'] ?? 'Infinity' }}</a> | Orders  </h4>
        </div>
    </div>
    @can('invoice-list')
        <div class="separator-breadcrumb border-top"></div>
        <div class="row mb-4">
            <div class="col-md-12 mb-4">
                <div class="card text-left">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Orders</h4>
                        <div class="table-responsive">
                            <table id="zero_configuration_table" class="display table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Order id</th>
                                        <th>product</th>
                                        <th>payment_status</th>
                                        <th>Amount</th>
                                        <th>User</th>
                                        <th>Created at</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $count=1 @endphp
                                    @foreach ($order as $ord)
                                        <tr>
                                            <td>{{ $count }}</td>
                                            <td>{{ $ord->id }}</td>                                            
                                            <td>{{ $ord->product->name ?? 'N/A' }}</td>
                                            <td>{{ $ord->payment_status }}</td>
                                            <td>{{ $ord->payment_amount/100 }}</td>
                                            <td>{{ $ord->user->name }}</td>
                                            <td>{{ $ord->created_at }}</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-primary" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                    <span class="_dot _inline-dot"></span>
                                                    <span class="_dot _inline-dot"></span>
                                                    <span class="_dot _inline-dot"></span>
                                                </button>
                                                <div class="dropdown-menu">
                                                    @if ($ord->invoice)
                                                        <a class="dropdown-item" href="{{ route('invoice-preview', $ord->invoice->id) }}">
                                                            <i class="fa-regular fa-eye font-weight-bold"></i> View Invoice
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        @php $count++ @endphp
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Number</th>
                                        <th>Product</th>
                                        <th>Client</th>
                                        <th>Amount</th>
                                        <th>User</th>
                                        <th>Created at</th>
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