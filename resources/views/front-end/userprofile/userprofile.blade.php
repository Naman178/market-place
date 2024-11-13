@extends('front-end.common.master')
@section('meta')
<title>Market Place | {{ $seoData->title ?? 'Default Title' }} - {{ $seoData->description ?? 'Default Description' }}</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="{{ $seoData->description ?? 'Default description' }}">
<meta name="keywords" content="{{ $seoData->keywords ?? 'default, keywords' }}">
<meta property="og:title" content="{{ $seoData->title ?? 'Default Title' }}">
<meta property="og:description" content="{{ $seoData->description ?? 'Default description' }}">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:type" content="website">
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset('front-end/css/checkout.css') }}">
    <link rel="stylesheet" href="{{ asset('front-end/css/register.css') }}">
@endsection
@section('scripts')
    <script src="https://js.stripe.com/v3/"></script>
@endsection
@section('content')
    <div class="container checkout-container">
        <div class="checkout padding">
            <div class="container">
                <div class="row justify-content-center">
                    <!-- if user is already logged in -->
                    <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 col-12">

                        @php $name = optional($user)->name ? explode(" ", $user->name) : ['', ''];  @endphp
                        <div class="col-md-12 border p-4 card dark-blue-card">
                            <h4 class="mb-5 txt-white">Profile Details</h4>
                            <form method="POST" class="erp-profile-submit" id="profile_form"
                                data-url="{{ route('store-user-profile') }}">
                                @csrf
                                <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}">
                                <div class="row">
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label for="firstname">First Name</label>
                                            <input type="text" name="firstname" id="firstname" class="form-control"
                                                placeholder="Enter First Name" value="{{ $name[0] }}">
                                            <div class="error" id="firstname_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="lastname">Last Name</label>
                                            <input type="text" name="lastname" id="lastname" class="form-control"
                                                value="{{ $name[1] }}" placeholder="Enter Last Name">
                                            <div class="error" id="lastname_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="text" name="email" id="email" class="form-control"
                                                placeholder="Enter Email" value="{{ optional($user)->email }}">
                                            <div class="error" id="email_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="country_code">Country Code</label>
                                            <select name="country_code" id="country_code" class="form-control select-input"
                                                required="required">
                                                <option value="">Select country code</option>
                                                @foreach ($countaries as $countery)
                                                    <option value="{{ $countery->id }}"
                                                        {{ $user->country_code == $countery->id ? 'selected' : '' }}>
                                                        {{ $countery->country_code }}</option>
                                                @endforeach
                                            </select>
                                            <div class="error" id="country_code_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="contact">Contact Number</label>
                                            <input type="number" name="contact" id="contact" class="form-control"
                                                placeholder="Enter Contact Number"
                                                value="{{ optional($user)->contact_number }}">
                                            <div class="error" id="contact_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="company_name">Company Name</label>
                                            <input type="text" name="company_name" id="company_name" class="form-control"
                                                placeholder="Enter Company Name"
                                                value="{{ optional($user)->company_name }}">
                                            <div class="error" id="company_name_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="company_website">Company Website</label>
                                            <input type="text" name="company_website" id="company_website"
                                                class="form-control" placeholder="Enter Company Website"
                                                value="{{ optional($user)->company_website }}">
                                            <div class="error" id="company_website_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="company_name">Country</label>
                                            <select name="country" id="country" class="form-control select-input">
                                                <option value="0">Select Country</option>
                                                @foreach ($countaries as $countery)
                                                    <option value="{{ $countery->id }}"
                                                        data-country-code="{{ $countery->ISOname }}"
                                                        {{ $user->country == $countery->id ? 'selected' : '' }}>
                                                        {{ $countery->name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="error" id="country_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="address_line_one">Address Line 1</label>
                                            <input type="text" name="address_line_one" id="address_line_one"
                                                class="form-control" placeholder="Enter Address Line 1"
                                                value="{{ optional($user)->address_line1 }}">
                                            <div class="error" id="address_line_one_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="address_line_two">Address Line 2</label>
                                            <input type="text" name="address_line_two" id="address_line_two"
                                                class="form-control" placeholder="Enter Address Line 2"
                                                value="{{ optional($user)->address_line2 }}">
                                            <div class="error" id="address_line_two_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="city">City</label>
                                            <input type="text" name="city" id="city" class="form-control"
                                                placeholder="Enter City Name" value="{{ optional($user)->city }}">
                                            <div class="error" id="city_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="postal">Zip / Postal Code</label>
                                            <input type="text" name="postal" id="postal" class="form-control"
                                                placeholder="Enter Zip / Postal Code"
                                                value="{{ optional($user)->postal_code }}">
                                            <div class="error" id="postal_error"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <button type="button"
                                        class="btn btn-block pink-btn mt-3 erp-profile-form">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('front-end.userprofile.userprofilescript')
@section('scripts')
@endsection
