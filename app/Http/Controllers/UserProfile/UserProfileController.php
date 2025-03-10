<?php

namespace App\Http\Controllers\UserProfile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SEO;
use App\Models\ContactsCountryEnum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserProfileController extends Controller
{
    public function index(Request $request)
    {        
        $countaries = ContactsCountryEnum::orderBy('id')->get();
        $seoData = SEO::where('page','profile')->first();
        $user = Auth::user();
        return view('front-end.userprofile.userprofile')->with([            
            'countaries' => $countaries,
            'user' => $user,
            'seoData' => $seoData,
        ]);
    }
    public function store_user_profile(Request $request){
        // dd($request->all());
        if($request->ajax()){
            $user = User::find($request->user_id);
            $validator = Validator::make($request->all(), [
                'firstname' => 'required|regex:/^[a-zA-Z\s]+$/',
                'lastname' => 'required|regex:/^[a-zA-Z\s]+$/',
                'email' => 'required|email',
                'contact' => 'required|digits:10',
                'address_line1' => 'required|regex:/^[a-zA-Z0-9\s,.-]+$/',
                'city' => 'required|regex:/^[a-zA-Z\s]+$/',
                'postal' => 'required|digits_between:5,6',
                'company_name' => 'required',
                'company_website' => 'required|url',
            ], 
            $message = [                
                'firstname.required' => 'The First Name Is Required.',
                'firstname.regex' => 'The First Name should only contain letters and spaces.',
                'lastname.required' => 'The Last Name Is Required.',
                'lastname.regex' => 'The Last Name should only contain letters and spaces.',
                'email.required' => 'The Email Is Required.',
                'email.email' => 'Please enter a valid email address.',
                'contact.required' => 'Please Add Your Contact Number.',
                'contact.digits' => 'The Contact Number must be exactly 10 digits.',
                'address_line1.required' => 'Please Add Your Address.',
                'address_line1.regex' => 'The Address must contain only letters, numbers, spaces, commas, periods, or hyphens.',
                'city.required' => 'The City Is Required.',
                'city.regex' => 'The City name should only contain letters and spaces.',
                'postal.required' => 'The Postal Code Is Required.',
                'postal.digits_between' => 'The Postal Code must be 5 or 6 digits long.',
                'company_name.required' => 'The Company Name is required.',
                'company_website.required' => 'Please enter a valid URL for the company website.',
                'company_website.url' => 'Please enter a valid company website URL.',
            ]);
            $imageName = $request->old_photo;
            if ($request->profile_pic) {
                $imageName = time().'.'.$request->profile_pic->extension();  
                $request->profile_pic->move(public_path('assets/images/faces'), $imageName);
            }
            if ($validator->fails()){
                return response()->json(['error'=>$validator->getMessageBag()->toArray()]);
            } else{
                if($user){
                    $user->update([
                        "name" => $request->firstname. ' '. $request->lastname,
                        'profile_pic' => $imageName,
                        "email" => $request->email,
                        "country_code" => $request->country_code,
                        "contact_number" => $request->contact,
                        "company_website" => $request->company_website,
                        "company_name" => $request->company_name,
                        "country" => $request->country,
                        "address_line1" => $request->address_line1,
                        "address_line2" => $request->address_line2,
                        "city" => $request->city,
                        "postal_code" => $request->postal
                    ]);
                    
                    $user->save();
                }

                return response()->json([
                    'success' => 'User Profile updated successfully!',
                    'title' => 'User',
                    'type' => 'update',
                    'data' => $user
                ]);
            }
        }
    }
}
