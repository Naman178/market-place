@php $name = optional($user)->name ? explode(" ", $user->name) : ['', ''];  @endphp
<div class="col-md-12 border p-4 card dark-blue-card">
    <p class="txt-white mb-0">
        @auth
            Billing Details of {{ Auth::user()->name }}
        @else
            Already Have an Account ?...Please <a href="{{ url('/user-login') }}"> Login</a> or Register Below</p>
            <div style="display: flex;">
                <a href="{{ url('/user-login/google') }}" class="google-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 48 48"><path fill="#ffc107" d="M43.611 20.083H42V20H24v8h11.303c-1.649 4.657-6.08 8-11.303 8c-6.627 0-12-5.373-12-12s5.373-12 12-12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4C12.955 4 4 12.955 4 24s8.955 20 20 20s20-8.955 20-20c0-1.341-.138-2.65-.389-3.917"/><path fill="#ff3d00" d="m6.306 14.691l6.571 4.819C14.655 15.108 18.961 12 24 12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4C16.318 4 9.656 8.337 6.306 14.691"/><path fill="#4caf50" d="M24 44c5.166 0 9.86-1.977 13.409-5.192l-6.19-5.238A11.91 11.91 0 0 1 24 36c-5.202 0-9.619-3.317-11.283-7.946l-6.522 5.025C9.505 39.556 16.227 44 24 44"/><path fill="#1976d2" d="M43.611 20.083H42V20H24v8h11.303a12.04 12.04 0 0 1-4.087 5.571l.003-.002l6.19 5.238C36.971 39.205 44 34 44 24c0-1.341-.138-2.65-.389-3.917"/></svg>
                    <span>
                        Continue with Google
                    </span>
                </a>
            </div>
        @endauth
    <h4 class="mb-5 txt-white">Billing Details</h4>
    <div class="row">
        <div class="col-md-6">
            <input type="hidden" name="" id="user_id" value="{{ optional($user)->id }}">
        <div class="form-group">
            <label for="firstname">First Name</label>
            <input type="text" name="firstname" id="firstname" class="form-control" placeholder="Enter First Name" value="{{ $name[0] }}">
            <div class="error" id="firstname_error"></div>
        </div>
        </div>
        <div class="col-md-6">
        <div class="form-group">
            <label for="lastname">Last Name</label>
            <input type="text" name="lastname" id="lastname" class="form-control" value="{{ $name[1] }}" placeholder="Enter Last Name">
            <div class="error" id="lastname_error"></div>
        </div>
        </div>
        <div class="col-md-12">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" name="email" id="email" class="form-control" placeholder="Enter Email" value="{{ optional($user)->email }}">
            <div class="error" id="email_error"></div>
        </div>
        </div>
        <div class="col-md-4">
        <div class="form-group">
            <label for="country_code">Country Code</label>
            <select name="country_code" id="country_code" class="form-control select-input" required="required">
                <option value="">Select country code</option>
                @foreach($countaries as $countery)
                    <option value="{{ $countery->id }}" {{ optional($user)->country == $countery->id ? 'selected' : '' }}>{{ $countery->country_code }}</option>
                @endforeach
            </select>
        </div>
        </div>
        <div class="col-md-8">
        <div class="form-group">
            <label for="contact">Contact Number</label>
            <input type="number" name="contact" id="contact" class="form-control" placeholder="Enter Contact Number" value="{{ optional($user)->contact_number }}">
            <div class="error" id="contact_error"></div>
        </div>
        </div>
        <div class="col-md-6">
        <div class="form-group">
            <label for="company_name">Company Name</label>
            <input type="text" name="company_name" id="company_name" class="form-control" placeholder="Enter Company Name" value="{{ optional($user)->company_name }}">
            <div class="error" id="company_name_error"></div>
        </div>
        </div>
        <div class="col-md-6">
        <div class="form-group">
            <label for="company_website">Company Website</label>
            <input type="text" name="company_website" id="company_website" class="form-control" placeholder="Enter Company Website" value="{{ optional($user)->company_website }}">
            <div class="error" id="company_website_error"></div>
        </div>
        </div>
        <div class="col-md-12">
        <div class="form-group">
            <label for="company_name">Country</label>
            <select name="country" id="country" class="form-control select-input">
                <option value="0">Select Country</option>
                @foreach($countaries as $countery)
                    <option value="{{ $countery->id }}" {{ optional($user)->country == $countery->id ? 'selected' : '' }}>{{ $countery->name }}</option>
                @endforeach
            </select>
            <div class="error" id="country_error"></div>
        </div>
        </div>
        <div class="col-md-12">
        <div class="form-group">
            <label for="address_line_one">Address Line 1</label>
            <input type="text" name="address_line_one" id="address_line_one" class="form-control" placeholder="Enter Address Line 1" value="{{ optional($user)->address_line1 }}">
            <div class="error" id="address_line_one_error"></div>
        </div>
        </div>
        <div class="col-md-12">
        <div class="form-group">
            <label for="address_line_two">Address Line 2</label>
            <input type="text" name="address_line_two" id="address_line_two" class="form-control" placeholder="Enter Address Line 2" value="{{ optional($user)->address_line2 }}">
            <div class="error" id="address_line_two_error"></div>
        </div>
        </div>
        <div class="col-md-6">
        <div class="form-group">
            <label for="city">City</label>
            <input type="text" name="city" id="city" class="form-control" placeholder="Enter City Name" value="{{ optional($user)->city }}">
            <div class="error" id="city_error"></div>
        </div>
        </div>
        <div class="col-md-6">
        <div class="form-group">
            <label for="postal">Zip / Postal Code</label>
            <input type="text" name="postal" id="postal" class="form-control" placeholder="Enter Zip / Postal Code" value="{{ optional($user)->postal_code }}">
            <div class="error" id="postal_error"></div>
        </div>
        </div>
    </div>
</div>
