@php $name = optional($user)->name ? explode(" ", $user->name) : ['', ''];  @endphp
<div class="col-md-12 p-4 card cart-doted-border">
    <p class="mb-0 mt-3 position-relative" >
        @auth
           <!--  Billing Details of {{ Auth::user()->name }} -->
        @else
            Already Have an Account ?...Please <a href="{{ url('/user-login') }}"> Login</a> or Register Below</p>
            <div class="d-flex">
                <a href="{{ url('/user-login/google') }}" class="google-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 48 48"><path fill="#ffc107" d="M43.611 20.083H42V20H24v8h11.303c-1.649 4.657-6.08 8-11.303 8c-6.627 0-12-5.373-12-12s5.373-12 12-12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4C12.955 4 4 12.955 4 24s8.955 20 20 20s20-8.955 20-20c0-1.341-.138-2.65-.389-3.917"/><path fill="#ff3d00" d="m6.306 14.691l6.571 4.819C14.655 15.108 18.961 12 24 12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4C16.318 4 9.656 8.337 6.306 14.691"/><path fill="#4caf50" d="M24 44c5.166 0 9.86-1.977 13.409-5.192l-6.19-5.238A11.91 11.91 0 0 1 24 36c-5.202 0-9.619-3.317-11.283-7.946l-6.522 5.025C9.505 39.556 16.227 44 24 44"/><path fill="#1976d2" d="M43.611 20.083H42V20H24v8h11.303a12.04 12.04 0 0 1-4.087 5.571l.003-.002l6.19 5.238C36.971 39.205 44 34 44 24c0-1.341-.138-2.65-.389-3.917"/></svg>
                    <span>
                        Continue with Google
                    </span>
                </a>
            </div>
        @endauth
    <div class="mb-5 cart-item-border text-center">Billing Details</div>
    <div class="row mt-2">
         <!-- First Name -->
        <div class="col-md-6">
            <div class="form-group">
                <input type="text" name="firstname" id="firstname" class="form-control" placeholder=" " value="{{ $name[0] }}" />
                <label for="firstname" class="floating-label">First Name</label>
                <div class="error" id="firstname_error"></div>
            </div>
        </div>

        <!-- Last Name -->
        <div class="col-md-6">
            <div class="form-group">
                <input type="text" name="lastname" id="lastname" class="form-control" placeholder=" " value="{{ $name[1] }}" />
                <label for="lastname" class="floating-label">Last Name</label>
                <div class="error" id="lastname_error"></div>
            </div>
        </div>

        <!-- Email -->
        <div class="col-md-6">
            <div class="form-group">
                <input type="text" name="email" id="email" class="form-control" placeholder=" " value="{{ optional($user)->email }}" />
                <label for="email" class="floating-label">Email</label>
                <div class="error" id="email_error"></div>
            </div>
        </div>
        
        <!-- Country Code -->
        <div class="col-md-6">
            <div class="form-group">
                <select name="country_code" id="country_code" class="form-control select-input" required="required">
                    <option value="">Select country code</option>
                    @foreach($countaries as $countery)
                        <option value="{{ $countery->id }}" {{ optional($user)->country == $countery->id ? 'selected' : '' }}>{{ $countery->country_code }}</option>
                    @endforeach
                </select>
                <div class="error" id="country_code_error"></div>
            </div>
        </div>

        <!-- Contact Number -->
        <div class="col-md-6">
            <div class="form-group">
                <input type="number" name="contact" id="contact" class="form-control" placeholder=" " value="{{ optional($user)->contact_number }}" />
                <label for="contact" class="floating-label">Contact Number</label>
                <div class="error" id="contact_error"></div>
            </div>
        </div>

        <!-- Company Name -->
        <div class="col-md-6">
            <div class="form-group">
                <input type="text" name="company_name" id="company_name" class="form-control" placeholder=" " value="{{ optional($user)->company_name }}" />
                <label for="company_name" class="floating-label">Company Name</label>
                <div class="error" id="company_name_error"></div>
            </div>
        </div>

        <!-- Company Website -->
        <div class="col-md-6">
            <div class="form-group">
                <input type="text" name="company_website" id="company_website" class="form-control" placeholder=" " value="{{ optional($user)->company_website }}" />
                <label for="company_website" class="floating-label">Company Website</label>
                <div class="error" id="company_website_error"></div>
            </div>
        </div>

        <!-- Address Line 1 -->
        <div class="col-md-12">
            <div class="form-group">
                <input type="text" name="address_line_one" id="address_line_one" class="form-control" placeholder=" " value="{{ optional($user)->address_line1 }}" />
                <label for="address_line_one" class="floating-label">Address Line 1</label>
                <div class="error" id="address_line_one_error"></div>
            </div>
        </div>

        <!-- Address Line 2 -->
        <div class="col-md-12">
            <div class="form-group">
                <input type="text" name="address_line_two" id="address_line_two" class="form-control" placeholder=" " value="{{ optional($user)->address_line2 }}" />
                <label for="address_line_two" class="floating-label">Address Line 2</label>
                <div class="error" id="address_line_two_error"></div>
            </div>
        </div>
        
        <!-- Country -->
        <div class="col-md-6">
            <div class="form-group">
                <select name="country" id="country" class="form-control select-input">
                    <option value="0">Select Country</option>
                    @foreach($countaries as $countery)
                        <option value="{{ $countery->id }}" data-country-code="{{ $countery->ISOname }}" {{ optional($user)->country == $countery->id ? 'selected' : '' }}>{{ $countery->name }}</option>
                    @endforeach
                </select>
                <div class="error" id="country_error"></div>
            </div>
        </div>

        <!-- City -->
        <div class="col-md-6">
            <div class="form-group">
                <input type="text" name="city" id="city" class="form-control" placeholder=" " value="{{ optional($user)->city }}" />
                <label for="city" class="floating-label">City</label>
                <div class="error" id="city_error"></div>
            </div>
        </div>

        <!-- Postal Code -->
        <div class="col-md-6">
            <div class="form-group">
                <input type="text" name="postal" id="postal" class="form-control" placeholder=" " value="{{ optional($user)->postal_code }}" />
                <label for="postal" class="floating-label">Zip / Postal Code</label>
                <div class="error" id="postal_error"></div>
            </div>
        </div>
    </div>
</div>
