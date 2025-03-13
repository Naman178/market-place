<?php

namespace App\Http\Controllers\FrontEnd\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Models\SEO;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        session(['url.intended' => url()->previous()]);
        $seoData = SEO::where('page','login')->first();
        return view('front-end.auth.login', compact('seoData'));
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
                if($intendedUrl == "https://market-place-main.infinty-stage.com/"){
                     return redirect()->route('user-dashboard')->withSuccess('You have Successfully loggedin');
                }
                else{
                    return redirect()->intended($intendedUrl);
                }
            } else if (Auth::user()->name('Super Admin')) { 
                return $intendedUrl ? redirect()->intended($intendedUrl) : redirect()->intended('/dashboard')->withSuccess('You have Successfully logged in as Super Admin');
            }
            else {
                return redirect()->route('user-dashboard')->withSuccess('You have Successfully loggedin');
            }
        }
  
        return redirect("user-login")->withSuccess('Oppes! You have entered invalid credentials');
    }
    
    public function redirectToGoogle()
    {
        $previousUrl = url()->previous();

        if (str_contains($previousUrl, 'checkout')) {
            session(['url.intended' => $previousUrl]);
        } else {
            session(['url.intended' => url('/user-dashboard')]);
        }
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
                return redirect()->intended('/user-dashboard');
            }
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Failed to login using Google, please try again.');
        }
    }

    public function redirectToGitHub()
    {
        return Socialite::driver('github')->redirect();
    }
    public function handleGitHubCallback()
    {
        try {
            $githubUser = Socialite::driver('github')->user();

            // Find or create user
            $user = User::updateOrCreate(
                ['email' => $githubUser->email],
                [
                    'name' => $githubUser->name ?? $githubUser->nickname,
                    'email' => $githubUser->email,
                    'password' => 'admin@123',
                ]
            );

            // Log in the user
            Auth::login($user);

            return redirect('/');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect('/login')->with('error', 'Authentication failed.');
        }
    }
    public function redirectToLinkdin()
    {
        return Socialite::driver('linkedin-openid')
        ->scopes(['openid', 'profile', 'email'])
        ->redirect();
    }
    public function handleLinkdinCallback(){
        // dd(request()->all());
        try {
            $linkedinUser = Socialite::driver('linkedin-openid')->user();
            $user = User::updateOrCreate(
                ['email' => $linkedinUser->email],
                [
                    'name' => $linkedinUser->name,
                    'email' => $linkedinUser->email,
                    // 'avatar' => $linkedinUser->avatar,
                    // 'linkedin_token' => $linkedinUser->token,
                ]
            );
            // dd($linkedinUser);
            Auth::login($user);
            return redirect('/');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect('/login')->with('error', 'Authentication failed.');
        }
    }
}
