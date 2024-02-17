<?php

namespace App\Http\Controllers\ProfileSettings;

use App\helper\helper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;
use Symfony\Component\HttpFoundation\Response;
use Spatie\Permission\Models\Role;
use DB;
use Auth;
use Illuminate\Support\Arr;

class ProfileSettingsController extends Controller
{
    public function index($id)
    {
        $user = User::find($id);
        return view('pages.profile-settings.index',compact('user'));
    }
    public function store(Request $request){
        if($request->ajax()){
            $validator = Validator::make($request->all(), [
                'fname' => 'required',
                'lname' => 'required'
            ]);
            if ($validator->passes()){
                $user = User::find($request->id);

                $fname = $request->fname;
                $lname = $request->lname;

                $user->update(['fname'=> $fname , 'lname'=>$lname]);

                return response()->json([
                    'success' => 'User Profile updated successfully!',
                    'title' => 'User',
                    'type' => 'update',
                    'data' => $user
                ]);
            }
            else{
                return response()->json(['error'=>$validator->getMessageBag()->toArray()]);
            }
        }
    }

    public function showChangePasswordGet() {
        return view('auth.passwords.change-password');
    }

    public function changePasswordPost(Request $request) {
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            return redirect()->back()->with("error","Your current password does not matches with the password.");
        }

        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            return redirect()->back()->with("error","New Password cannot be same as your current password.");
        }

        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();

        return redirect()->back()->with("success","Password successfully changed!");
    }
}
