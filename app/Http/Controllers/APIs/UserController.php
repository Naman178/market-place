<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\UserCustomer;

class UserController extends Controller
{
    public function user(Request $request)
    {           
        $validatedData = $request->validate([
            'contact_number' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('user_customer__rec_tbl')->where(function ($query) use ($request) {
                    return $query->where('register_under_user_id', $request->register_under_user_id)->where('site_url', $request->site_url);
                })
            ],
            'register_under_user_id' => 'required',
            'site_url' => 'required',
        ]);

        $UserCustomer = new UserCustomer;
        $UserCustomer->contact_number = $request->contact_number;
        $UserCustomer->email = $request->email;
        $UserCustomer->register_under_user_id = $request->register_under_user_id;
        $UserCustomer->site_url = $request->site_url;
        $UserCustomer->save();

        return response()->json([
            'message' => 'User customer record created successfully',
            'data' => $UserCustomer
        ], 201);        
    }
}
