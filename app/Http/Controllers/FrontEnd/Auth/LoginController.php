<?php

namespace App\Http\Controllers\FrontEnd\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        session(['url.intended' => url()->previous()]);
        return view('front-end.auth.login');
        //return Socialite::driver('google')->redirect();
    }
    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
   
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $intendedUrl = session()->get('url.intended');
    
            if ($intendedUrl) {
                return redirect()->intended($intendedUrl);
            } else {
                return redirect()->intended('/')->withSuccess('You have Successfully loggedin');
            }
        }
  
        return redirect("user-login")->withSuccess('Oppes! You have entered invalid credentials');
    }
    
    public function redirectToGoogle()
    {
        session(['url.intended' => url()->previous()]);
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Find or create a user in the database
            $user = User::where('email', $googleUser->email)->first();

            if ($user) {
                // If user exists, log them in
                Auth::login($user);
            } else {
                // If user doesn't exist, create a new user and log them in
                $newUser = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id, // Storing Google ID
                    'password' => bcrypt('123456dummy'), // Use a random password since it's not required for social login
                ]);

                Auth::login($newUser);
            }

            // Redirect to the desired page
            $intendedUrl = session()->get('url.intended');
    
            if ($intendedUrl) {
                return redirect()->intended($intendedUrl);
            } else {
                return redirect()->intended('/');
            }
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Failed to login using Google, please try again.');
        }
    }
}
