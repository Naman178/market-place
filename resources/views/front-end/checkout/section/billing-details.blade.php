<div class="col-md-12 border p-4 card dark-blue-card">
    <p class="txt-white mb-0">
        @auth
            Billing Details of {{ Auth::user()->name }} 
        @else
            Already Have an Account ?...Please <a href="{{ url('/user-login') }}"> Login</a> or Register Below</p>
        @endauth
    <h4 class="mb-5 txt-white">Billing Details</h4>
    <div class="row">
        <div class="col-md-6">
        <div class="form-group">
            <label for="firstname">First Name</label>
            <input type="text" name="firstname" id="firstname" class="form-control" placeholder="Enter First Name">
            <div class="error" id="firstname_error"></div>
        </div>
        </div>
        <div class="col-md-6">
        <div class="form-group">
            <label for="lastname">Last Name</label>
            <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Enter Last Name">
            <div class="error" id="lastname_error"></div>
        </div>
        </div>
        <div class="col-md-12">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" name="email" id="email" class="form-control" placeholder="Enter Email">
            <div class="error" id="email_error"></div>
        </div>
        </div>
        <div class="col-md-4">
        <div class="form-group">
            <label for="country_code">Country Code</label>
            <select name="country_code" id="country_code" class="form-control select-input" required="required">
                <option value="">Select country code</option>
            </select>
        </div>
        </div>
        <div class="col-md-8">
        <div class="form-group">
            <label for="contact">Contact Number</label>
            <input type="number" name="contact" id="contact" class="form-control" placeholder="Enter Contact Number">
            <div class="error" id="contact_error"></div>
        </div>
        </div>
        <div class="col-md-6">
        <div class="form-group">
            <label for="company_name">Company Name</label>
            <input type="text" name="company_name" id="company_name" class="form-control" placeholder="Enter Company Name">
            <div class="error" id="company_name_error"></div>
        </div>
        </div>
        <div class="col-md-6">
        <div class="form-group">
            <label for="company_website">Company Website</label>
            <input type="text" name="company_website" id="company_website" class="form-control" placeholder="Enter Company Website">
            <div class="error" id="company_website_error"></div>
        </div>
        </div>
        <div class="col-md-12">
        <div class="form-group">
            <label for="company_name">Country</label>
            <select name="country" id="country" class="form-control select-input">
                <option value="0">Select Country</option>
                @foreach($data['countaries'] as $countery)
                    <option value="{{ $countery->id }}">{{ $countery->name }}</option>
                @endforeach
            </select>
            <div class="error" id="country_error"></div>
        </div>
        </div>
        <div class="col-md-12">
        <div class="form-group">
            <label for="address_line_one">Address Line 1</label>
            <input type="text" name="address_line_one" id="address_line_one" class="form-control" placeholder="Enter Address Line 1">
            <div class="error" id="address_line_one_error"></div>
        </div>
        </div>
        <div class="col-md-12">
        <div class="form-group">
            <label for="address_line_two">Address Line 2</label>
            <input type="text" name="address_line_two" id="address_line_two" class="form-control" placeholder="Enter Address Line 2">
            <div class="error" id="address_line_two_error"></div>
        </div>
        </div>
        <div class="col-md-6">
        <div class="form-group">
            <label for="city">City</label>
            <input type="text" name="city" id="city" class="form-control" placeholder="Enter City Name">
            <div class="error" id="city_error"></div>
        </div>
        </div>
        <div class="col-md-6">
        <div class="form-group">
            <label for="postal">Zip / Postal Code</label>
            <input type="text" name="postal" id="postal" class="form-control" placeholder="Enter Zip / Postal Code">
            <div class="error" id="postal_error"></div>
        </div>
        </div>
    </div>
</div>