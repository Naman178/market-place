@extends('dashboard.dashboard_layout')
@section('content')

  <!-- transaction -->
  <div class="tab-pane fade mb-5" id="transaction" role="tabpanel" aria-labelledby="list-profile-list">
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="wsus__profile_overview">
                <h4 class="mb-4">Payment History</h4>
                <table class="display table table-striped table-bordered transacion_history_tbl data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Payment Status</th>
                            <th>Payment Amount</th>
                            <th>Payment Date</th>
                            <th>Plan</th>
                            <th>Payment Id</th>
                            <th>Payment Method</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($transactions)
                            @foreach ($transactions as $key => $tran)
                                <tr>
                                    <td> {{ $key + 1 }} </td>
                                    <td> {{ $tran->payment_status ? ($tran->payment_status == 'captured' ? 'Success' : $tran->payment_status) : '' }}
                                    </td>
                                    <td> {{ $tran->product->currency ?? 'Rs.' }}  {{ $tran->payment_amount ?? '' }}</td>
                                    <td> {{ Helper::dateFormatForView($tran->created_at) ?? '' }} </td>
                                    <td>{{ $tran->product->product_name ?? '' }}</td>
                                    <td> {{ $tran->razorpay_payment_id ?? '' }} </td>
                                    <td> {{ $tran->payment_method ?? '' }} </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Payment Status</th>
                            <th>Payment Amount</th>
                            <th>Payment Date</th>
                            <th>Plan</th>
                            <th>Payment Id</th>
                            <th>Payment Method</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
