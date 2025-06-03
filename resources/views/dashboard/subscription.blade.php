@extends('dashboard.dashboard_layout')
@section('content')
  <!-- Subscription -->
  <div class="tab-pane fade mb-5" id="subscription" role="tabpanel"aria-labelledby="list-settings-list">
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="wsus__profile_overview">
                <h4 class="mb-4">User Subscription</h4>
                <table class="display table table-striped table-bordered transacion_history_tbl data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Order ID</th>
                            <th>Invoice ID </th>
                            <th>Subscription start date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($subscription)
                            @foreach ($subscription as $key => $sub)
                                <tr>
                                    <td> {{ $key + 1 }} </td>
                                    <td> {{ $sub->product->name ?? '' }}</td>
                                    <td> {{ $sub->order_id ?? 'N/A' }} </td>
                                    <td> {{ $sub->invoice_id ?? 'N/A' }} </td>
                                    <td> {{ $sub->created_at }} </td>
                                    <td>{{ $sub->status }}</td>
                                    <td>
                                        @if ($sub->status === 'active')
                                            <a href="{{ route('subscription.cancel', ['id' => $sub->id]) }}"
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to cancel this subscription?');">
                                                Stop
                                            </a>
                                        @else
                                            <a href="{{ route('subscription.reactivate', ['id' => $sub->id]) }}"
                                                class="btn btn-success btn-sm"
                                                onclick="return confirm('Are you sure you want to reactivate this subscription?');">
                                                Re-Active
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Order ID</th>
                            <th>Invoice ID </th>
                            <th>Subscription start date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
