@extends('dashboard.dashboard_layout')
@section('content')
@php
    $user = auth()->user();
@endphp
  <!-- dashboard -->
  <div class="tab-pane fade active show mb-5" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="wsus__profile_overview">
                <h3>About Me</h3>
                <p>Hello, I’m {{ $user->name ?? '' }}</p>

                <p><span>Joined:</span> {{ $user->created_at->format('M d, Y') ?? '' }}</p>
                <p>Not {{ $user->name ?? '' }} ? <a class="text-black font-weight-bold"
                        href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">logout</a>
                </p>
                <div>
                    <p>From your account dashboard you can view your recent orders,manage and download the key and
                        files , and edit your password and account details.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
