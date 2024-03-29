<?php

namespace App\Http\Controllers\FrontEnd\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->ajax()){
            $user = User::find($request->user_id);
            if($user){
                $user->update([
                    "name" => $request->name,
                    "email" => $request->email,
                    "country_code" => $request->country_code,
                    "contact_number" => $request->contact,
                    "country_code" => $request->country_code,
                    "company_website" => $request->company_website,
                    "company_name" => $request->company_name,
                    "country" => $request->country,
                    "address_line1" => $request->address_line_one,
                    "address_line2" => $request->address_line_two,
                    "city" => $request->city,
                    "postal_code" => $request->postal
                ]);
            }

            return response()->json([
                "success" => true,
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
