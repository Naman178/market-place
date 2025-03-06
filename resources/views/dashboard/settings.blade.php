@extends('dashboard.dashboard_layout')
@section('content')

 <!-- update password -->
 <div class="tab-pane fade mb-5" id="list-settings" role="tabpanel" aria-labelledby="list-settings-list">
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="wsus__profile_overview">
                <h4 class="mb-4">Update Password</h4>
                <form class="form-horizontal" method="POST" action="{{ route('changePasswordPost') }}">
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if ($errors)
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger">{{ $error }}</div>
                        @endforeach
                    @endif
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="fname">Current Password</label>
                            <input id="current-password" type="password" class="form-control"
                                name="current-password" placeholder="Enter Current Password" required>
                            @if ($errors->has('current-password'))
                                <div class="error" style="color:red;">
                                    {{ $errors->first('current-password') }}
                                </div>
                            @endif
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="lname">New Password</label>
                            <input id="new-password" type="password" class="form-control" name="new-password"
                                placeholder="Enter New Password" required>
                            @if ($errors->has('new-password'))
                                <div class="error" style="color:red;">
                                    {{ $errors->first('new-password') }}
                                </div>
                            @endif
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="lname">Confirm New Password</label>
                            <input id="new-password-confirm" type="password" class="form-control"
                                name="new-password_confirmation" placeholder="Re-Enter New Password" required>
                        </div>
                    </div>
                    <button type="submit" class="btn dark-blue-btn my-4"> Update Password</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
