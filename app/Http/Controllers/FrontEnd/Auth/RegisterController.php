<?php

namespace App\Http\Controllers\FrontEnd\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        return view('front-end.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required|email|unique:users',
            'country_code' => 'required',
            'contact_number' => 'required',
            'company_name' => 'required',
            'company_website' => 'required|url',
            'country' => 'required',
            'address_line1' => 'required',
            'address_line2' => 'nullable',
            'city' => 'required',
            'postal_code' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = new User();
        $user->name = $request->fname." ".$request->lname;
        $user->fname = $request->fname;
        $user->lname = $request->lname;
        $user->email = $request->email;
        $user->country_code = $request->country_code;
        $user->contact_number = $request->contact_number;
        $user->company_name = $request->company_name;
        $user->company_website = $request->company_website;
        $user->country = $request->country;
        $user->address_line1 = $request->address_line1;
        $user->address_line2 = $request->address_line2;
        $user->city = $request->city;
        $user->postal_code = $request->postal_code;
        $user->password = Hash::make($request->password);
        $user->confirm_password = Hash::make($request->password);

        $user->save();

        // Redirect to dashboard or login page
        return redirect('/login')->with('success', 'Registration successful. You can now login.');
    }
}
