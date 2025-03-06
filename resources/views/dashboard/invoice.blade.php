@extends('dashboard.dashboard_layout')
@section('content')

  <!-- Invoice -->
  <div class="tab-pane fade mb-5" id="invoice" role="tabpanel" aria-labelledby="list-settings-list">
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="wsus__profile_overview">
                <h4 class="mb-4">User Invoice</h4>
                <table class="display table table-striped table-bordered transacion_history_tbl data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Invoice Number</th>
                            <th>Payment Amount</th>
                            <th>Payment Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($invoice)
                            @foreach ($invoice as $key => $inv)
                                <tr>
                                    <td> {{ $key + 1 }} </td>
                                    <td>
                                        <a href="{{ route('invoice-preview', $inv->id) }}" target="_blank"
                                            class="text-primary">
                                            {{ $inv->invoice_number }}
                                        </a>
                                    </td>
                                    <td> Rs. {{ $inv->total ?? '' }}</td>
                                    <td> {{ $inv->created_at }} </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Invoice Number</th>
                            <th>Payment Amount</th>
                            <th>Payment Date</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
