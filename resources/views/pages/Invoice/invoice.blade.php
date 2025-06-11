@extends('layouts.master')
@php
    use App\Models\Settings;
    $site = Settings::where('key', 'site_setting')->first();
@endphp
@section('title')
    <title>{{ $site['value']['site_name'] ?? 'Infinity' }} | Invoice</title>
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
            <h4><a href="{{ route('dashboard') }}" class="text-uppercase">{{ $site['value']['site_name'] ?? 'Infinity' }}</a> | Invoice  </h4>
        </div>
        @can('invoice-create')
            <div class="col-sm-12 col-md-6">
                <a href="{{ route('invoice-edit', 'new') }}"  class="btn btn-primary btn-sm"
                    style="float: right !important;">Create Invoice</a>
            </div>
        @endcan
    </div>
    @can('invoice-list')
        <div class="separator-breadcrumb border-top"></div>
        <div class="row mb-4">
            <div class="col-md-12 mb-4">
                <div class="card text-left">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Invoice</h4>
                        <div class="table-responsive">
                            <table id="zero_configuration_table" class="display table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Number</th>
                                        <th>product</th>
                                        <th>Client</th>
                                        <th>Amount</th>
                                        <th>Created at</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $count=1 @endphp
                                    @foreach ($invoices as $invoice)
                                        <tr>
                                            <td>{{ $count }}</td>
                                            <td>
                                                <a href="{{ route('invoice-preview', $invoice->id) }}" target="_blank" class="text-primary">
                                                    {{ $invoice->invoice_number }}
                                                </a>
                                            </td>                                            
                                            <td>{{ $invoice->order && $invoice->order->product ? $invoice->order->product->name : 'N/A' }}</td>
                                            <td>{{ $invoice->user ? $invoice->user->name : 'N/A' }}</td>
                                            <td>{{ ceil($invoice->total) ?? $invoice->total }}</td>
                                            <td>{{ $invoice->created_at }}</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-primary" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                    <span class="_dot _inline-dot"></span>
                                                    <span class="_dot _inline-dot"></span>
                                                    <span class="_dot _inline-dot"></span>
                                                </button>
                                                <div class="dropdown-menu" x-placement="bottom-start"
                                                    style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 34px, 0px);">
                                                    <a class="dropdown-item" href="{{ route('invoice-preview', $invoice->id) }}"><i
                                                            class="fa-regular fa-eye font-weight-bold" aria-hidden="true"> </i>
                                                        View</a>

                                                        <a class="dropdown-item" href="{{ route('invoice.download', $invoice->id) }}"><i
                                                            class="fa-regular fa-eye font-weight-bold" aria-hidden="true"> </i>
                                                        Download</a>
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
@section('page-js')
    <script src="{{ asset('assets/js/vendor/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatables.script.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
@endsection