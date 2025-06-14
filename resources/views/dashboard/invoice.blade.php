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
                            <th>Order ID</th>
                            <th>Payment Amount</th>
                            <th>Payment Date</th>
                            <th>Payment Type</th>
                            <th>Next Due Date</th>
                            <th>Action</th>
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
                                    <td> {{ $inv->order->id ?? 'N/A' }} </td>
                                    @php
                                        $total = $inv->total; 
                                        $total = number_format($total, 2);
                                        if($inv->discount > 0){
                                            $total = $inv->total;
                                        } 
                                    @endphp
                                    <td> {{ $inv->order->product->currency ?? 'Rs.' }} {{ $total ?? '' }}</td>

                                    <td> {{ $inv->created_at }} </td>
                                    <td>
                                        @if ($inv->pricing->pricing_type == 'recurring')
                                            {{ $inv->pricing->billing_cycle ?? '' }}
                                        @else
                                            {{ $inv->pricing->pricing_type ?? '' }}
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $createdAt = \Carbon\Carbon::parse($inv->created_at);
                                            $nextDueDate = '';

                                            if ($inv->pricing->pricing_type == 'recurring') {
                                                $billingCycle = $inv->pricing->billing_cycle;

                                                switch ($billingCycle) {
                                                    case 'monthly':
                                                        $nextDueDate = $createdAt->copy()->addMonth()->format('Y-m-d');
                                                        break;
                                                    case 'yearly':
                                                        $nextDueDate = $createdAt->copy()->addYear()->format('Y-m-d');
                                                        break;
                                                    case 'weekly':
                                                        $nextDueDate = $createdAt->copy()->addWeek()->format('Y-m-d');
                                                        break;
                                                    case 'quarterly':
                                                        $nextDueDate = $createdAt->copy()->addMonths(3)->format('Y-m-d');
                                                        break;
                                                    case 'custom':
                                                        $customDays = $inv->pricing->custom_cycle_days ?? 0;
                                                        $nextDueDate = $createdAt->copy()->addDays($customDays)->format('Y-m-d');
                                                        break;
                                                    default:
                                                        $nextDueDate = $createdAt->copy()->addDays(30)->format('Y-m-d');
                                                }
                                            } else {
                                                $nextDueDate = '-';
                                            }
                                        @endphp
                                        {{ $nextDueDate }}
                                    </td>

                                    <td> <a href="{{ route('invoice-preview', $inv->id) }}" target="_blank"
                                            class="btn btn-primary">Preview</a> </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Invoice Number</th>
                            <th>Order ID</th>
                            <th>Payment Amount</th>
                            <th>Payment Date</th>
                            <th>Payment Type</th>
                            <th>Next Due Date</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
