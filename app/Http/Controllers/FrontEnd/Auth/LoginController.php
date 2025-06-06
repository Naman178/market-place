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
        if (Auth::check()) {
            return redirect()->route('user-dashboard');
        }

        session(['url.intended' => url()->previous()]);
        $seoData = SEO::where('page','login')->first();
        return view('front-end.auth.login', compact('seoData'));
        //return Socialite::driver('google')->redirect();
    }
    public function postLogin(Request $request)
    {
        // $request->validate([
        //     'email' => 'required',
        //     'password' => 'required',
        // ]);
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $intendedUrl = session()->get('url.intended');
            if (Auth::user() && Auth::user()->name === 'Super Admin') {
                return redirect()->route('dashboard')->withSuccess('You have successfully logged in as Super Admin');
            }
            if ($intendedUrl) {
                if($intendedUrl == "https://market-place-main.infinty-stage.com/"){
                     return redirect()->route('user-dashboard')->withSuccess('You have Successfully loggedin');
                }
                else{
                    return redirect()->intended($intendedUrl);
                }
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

            // Find the user in the database
            $user = User::where('email', $googleUser->email)->first();
        
            if ($user) {
                // Update profile picture if needed
                if (empty($user->profile_pic)) {
                    $user->update([
                        'profile_pic' => $googleUser->avatar . '?sz=200',
                    ]);
                }
                Auth::login($user);
            } else {
                // Create a new user and store Google profile picture
                $newUser = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'profile_pic' => $googleUser->avatar . '?sz=200', // Store high-resolution image
                    'password' => bcrypt('123456dummy'), // Dummy password
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
            return redirect()->route('user-login')->with('error', 'Failed to login using Google, please try again.');
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
                    'password' => bcrypt('admin@123'), // Dummy password
                ]
            );
            if (empty($user->profile_pic)) {
                $user->update(['profile_pic' => $githubUser->avatar]);
            }
            // Log in the user
            Auth::login($user);
    
            return redirect('/');
        } catch (\Exception $e) {
            return redirect('/user-login')->with('error', 'GitHub authentication failed.');
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
                    'name' => $linkedinUser->name ?? $linkedinUser->nickname,
                    'email' => $linkedinUser->email,
                ]
            );
            if (empty($user->profile_pic)) {
                $user->update(['profile_pic' => $linkedinUser->avatar ?? null]);
            }
            // dd($linkedinUser);
            Auth::login($user);
            return redirect('/');
        } catch (\Exception $e) {
            return redirect('/user-login')->with('error', 'LinkedIn authentication failed.');
        }
    }
}
