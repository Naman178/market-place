@extends('dashboard.dashboard_layout')
@section('content')
<!-- downloads -->
<div class="tab-pane fade mb-5" id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="wsus__profile_overview">
                <h4 class="mb-4">Downloads</h4>
                @if ($orders->count() > 0)
                    <table class="display table table-striped table-bordered dataTable data-table"
                        style="width:100%" role="grid" aria-describedby="zero_configuration_table_info">
                        <thead>
                            <tr role="row">
                                <th>Order Id</th>
                                <th>Product Key</th>
                                <th>Product Name</th>
                                <th>Product File</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr role="row">
                                    <td>#{{ $order->id ?? '' }}</td>
                                    <td>{{ $order->key->key ?? '' }}</td>
                                    <td>{{ $order->product->name ?? '' }}</td>
                                    <td>
                                        {{-- <a href="{{ asset('storage/plan/' . $order->product->created_by . '/' . $order->product->id . '/' . $order->product->main_file) }}"
                                            download="{{ $order->product->name ?? '' }}">Download</a> --}}
                                          <a href="{{ url('/download/' . $order->product->main_file_zip . '?name=' . urlencode($order->product->name ?? 'download')) }}"
                                            download="{{ $order->product->name ?? 'download' }}.zip">
                                            Download
                                        </a>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr role="row">
                                <th>Order Id</th>
                                <th>Product Key</th>
                                <th>Product Name</th>
                                <th>Product File</th>
                            </tr>
                        </tfoot>
                    </table>
                @else
                    <p class="d-inline-block mr-4">No Downloads Found</p>
                    {{-- <a href="{{ url('/') }}" class="btn-dark-blue d-inline-block"><i
                            class="nav-icon i-Left" aria-hidden="true"> </i> &nbsp; Browse Products</a> --}}
                        <a href="{{ url('/') }}"class="btn btn-linkedin blue_common_btn"> 
                            <svg viewBox="0 0 100 100" preserveAspectRatio="none">
                            <polyline points="99,1 99,99 1,99 1,1 99,1" class="bg-line"></polyline>
                            <polyline points="99,1 99,99 1,99 1,1 99,1" class="hl-line"></polyline>
                        </svg><span>Browse Products</span></a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
