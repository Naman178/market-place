@extends('front-end.common.master')
@section('title', 'Sign Up')
@section('styles')
   <link rel="stylesheet" href="{{ asset('front-end/css/register.css') }}">
@endsection
@section('content')
<div class="container pt-5 pb-5 register-container">
    <div class="title">
        <h3><span class="txt-black">Sign</span><span class="color-blue underline-text"> Up</span></h3>
    </div>
    <form action="{{ route('user-register-post') }}" method="POST">
        @csrf
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="row  border p-3 pt-4 pb-4 border-radius-1">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control"  id="email" name="email" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="country_code">Country Code</label>
                            <input type="text" class="form-control" id="country_code" name="country_code">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="contact_number">Contact Number</label>
                            <input type="text" class="form-control" id="contact_number" name="contact_number">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="company_name">Company Name</label>
                            <input type="text" class="form-control" id="company_name" name="company_name">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="company_website">Company Website</label>
                            <input type="url" class="form-control" id="company_website" name="company_website">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="country">Country</label>
                            <input type="text" class="form-control" id="country" name="country">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="address_line1">Address Line 1</label>
                            <input type="text" class="form-control" id="address_line1" name="address_line1">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="address_line2">Address Line 2</label>
                            <input type="text" class="form-control" id="address_line2" name="address_line2">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" class="form-control" id="city" name="city">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="postal_code">Zip / Postal Code</label>
                            <input type="text" class="form-control" id="postal_code" name="postal_code">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="confirm_password">Confirm Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        </div>
                    </div>
                    <div class="col-md-12 pt-3">
                        <div class="form-group">
                            <button type="submit" class="form-control" class="btn">Register</button>
                            <p class="text-center d-block text-white mt-3">Already an Account ..? <a href="{{ url('user-login') }}"> Login </a> </p>       
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </form>
</div>
@endsection
@section('scripts')
@endsection