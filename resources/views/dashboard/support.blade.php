@extends('dashboard.dashboard_layout')
@section('content')

<!-- support -->
<div class="tab-pane fade mb-5" id="list-support" role="tabpanel" aria-labelledby="list-support-list">
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="wsus__profile_overview">
                <h4 class="mb-4">Support</h4>
                @if ($wallet)
                    @if ($wallet->product_id && $wallet->product_id == 1)
                        <p>Need Support? Contact us at <a
                                href="mailto:support@skyfinity.co.in">support@skyfinity.co.in</a> for
                            assistance.
                        </p>
                    @elseif($wallet->product_id && $wallet->product_id == 2)
                        <p>Feel free to reach out to us via email at <a href="mailto:support@skyfinity.co.in">
                                support@skyfinity.co.in </a> or give us a call at <a href="tel:+916359389818">
                                +91-6359389818 </a> . Our dedicated support team is ready to assist you.</p>
                        <p>Please note that the estimated waiting time for support is approximately 30 minutes.
                        </p>
                    @elseif(($wallet->product_id && $wallet->product_id == 3) || ($wallet->product_id && $wallet->product_id == 6))
                        <p>Feel free to reach out to us via email at <a href="mailto:support@skyfinity.co.in">
                                support@skyfinity.co.in </a> or give us a call at <a href="tel:+916359389818">
                                +91-6359389818 </a> . Our dedicated support team is ready to assist you.</p>
                        <p>We are here to assist you promptly and provide immediate support without any waiting
                            time.</p>
                    @endif
                @else
                    <p class="d-inline-block mr-4">Please Topup Your Wallte For Suppot</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
