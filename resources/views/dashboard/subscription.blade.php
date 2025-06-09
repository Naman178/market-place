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
                            {{-- <th>Action</th> --}}
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
                                  {{-- @php
                                        // Use invoice created date if available, else fallback to subscription created_at
                                        $startDate = $sub->invoice->created_at ?? $sub->created_at;
                                        $createdAt = \Carbon\Carbon::parse($startDate);
                                        $nextDueDate = '-';

                                        if ($sub->pricing && $sub->pricing->pricing_type == 'recurring') {
                                            switch ($sub->pricing->billing_cycle) {
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
                                                    $customDays = $sub->pricing->custom_cycle_days ?? 0;
                                                    $nextDueDate = $createdAt->copy()->addDays($customDays)->format('Y-m-d');
                                                    break;
                                            }
                                        }
                                    @endphp

                                    <td>
                                        @if ($sub->status === 'active')
                                            <a href="{{ route('subscription.cancel', ['id' => $sub->id]) }}"
                                                class="btn btn-danger btn-sm subscription-action"
                                                data-action="cancel"
                                                data-url="{{ route('subscription.cancel', ['id' => $sub->id]) }}"
                                                data-start="{{ \Carbon\Carbon::parse($startDate)->format('Y-m-d') }}"
                                                data-end="{{ $nextDueDate }}">
                                                Stop
                                            </a>
                                        @else
                                            <a href="{{ route('subscription.reactivate', ['id' => $sub->id]) }}"
                                                class="btn btn-success btn-sm subscription-action"
                                                data-action="reactivate"
                                                data-url="{{ route('subscription.reactivate', ['id' => $sub->id]) }}">
                                                Re-Active
                                            </a>
                                        @endif
                                    </td> --}}
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
                            {{-- <th>Action</th> --}}
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
