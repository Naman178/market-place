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
                        <div class="col-md-12">
                            <div class="form-group">
                            <input id="current-password" type="password" class="form-control"
                                name="current-password" placeholder="" >
                                <label for="fname" class="floating-label">Current Password</label>
                                 <button type="button" class="toggle-button" data-toggle="password" aria-label="Toggle Password Visibility">

                                    <!-- Eye icon SVG -->
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="eye-icon" viewBox="0 0 24 24">
                                        <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                                        <path fill-rule="evenodd"
                                            d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            @if ($errors->has('current-password'))
                                <div class="error" style="color:red;">
                                    {{ $errors->first('current-password') }}
                                </div>
                            @endif
                            <div class="error" id="current-password_error"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                            <input id="new-password" type="password" class="form-control" name="new-password"
                                placeholder="" >
                                <label for="lname" class="floating-label">New Password</label>
                                  <button type="button" class="toggle-button" data-toggle="password-new" aria-label="Toggle Password Visibility">

                                    <!-- Eye icon SVG -->
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="eye-icon" viewBox="0 0 24 24">
                                        <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                                        <path fill-rule="evenodd"
                                            d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            @if ($errors->has('new-password'))
                                <div class="error" style="color:red;">
                                    {{ $errors->first('new-password') }}
                                </div>
                            @endif
                            <div class="error" id="new-password_error"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                            <input id="new-password-confirm" type="password" class="form-control"
                                name="new-password_confirmation" placeholder="" >
                                
                            <label for="lname" class="floating-label">Confirm New Password</label>
                              <button type="button" class="toggle-button" data-toggle="password-confirm" aria-label="Toggle Password Visibility">

                                    <!-- Eye icon SVG -->
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="eye-icon" viewBox="0 0 24 24">
                                        <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                                        <path fill-rule="evenodd"
                                            d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            @if ($errors->has('new-password_confirmation'))
                                <div class="error" style="color:red;">
                                    {{ $errors->first('new-password_confirmation') }}
                                </div>
                            @endif
                            <div class="error" id="new-password-confirm_error"></div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="blue_common_btn btn">
                        <svg viewBox="0 0 100 100" preserveAspectRatio="none">
                            <polyline points="99,1 99,99 1,99 1,1 99,1" class="bg-line"></polyline>
                            <polyline points="99,1 99,99 1,99 1,1 99,1" class="hl-line"></polyline>
                        </svg>
                        <span>Update Password</span>
                    </button>
                    {{-- <button type="submit" class="btn read_btn my-4" style="cursor: pointer;"> Update Password</button> --}}
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
