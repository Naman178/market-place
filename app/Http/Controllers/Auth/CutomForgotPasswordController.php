<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use DB; 
use Carbon\Carbon; 
use App\Models\User; 
use Mail; 
use Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class CutomForgotPasswordController extends Controller
{
    /**
    * Write code on Method
    *
    * @return response()
    */
    public function showForgetPasswordForm()
    {
        return view('auth.forgetPassword');
    }

    /**
    * Write code on Method
    *
    * @return response()
    */
    public function submitForgetPasswordForm(Request $request)
    {
       
        $response = Http::get('https://disposable.debounce.io', [
            'email' => $request->email,
        ]);
        $data = $response->json();
        if ($data['disposable'] === 'true') {
            return back()->withErrors(['email' => 'We are not accepting Disposable Email Address please use actual email address or signup with google, github, linkedIn']);
        }

        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $request->email, 
            'token' => $token, 
            'created_at' => Carbon::now()
        ]);

        Mail::send('Email.forgetPassword', ['token' => $token], function($message) use($request){
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        session()->flash('success', 'We have e-mailed your password reset link!');
        
        return back();
    }

    /**
    * Write code on Method
    *
    * @return response()
    */
    public function showResetPasswordForm($token) { 
        return view('auth.forgetPasswordLink', ['token' => $token]);
    }
    /**
    * Write code on Method
    *
    * @return response()
    */
    public function submitResetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);
  
        $updatePassword = DB::table('password_resets') ->where([
            'email' => $request->email, 
            'token' => $request->token
        ])->first();
  
        if(!$updatePassword){
            return back()->withInput()->with('error', 'Invalid token!');
        }
  
        $user = User::where('email', $request->email)->update(['password' => Hash::make($request->password)]);
 
        DB::table('password_resets')->where(['email'=> $request->email])->delete();
        
        session()->flash('success', 'Password Updated Successfully!');

        return redirect('/user-login');
    }
}
