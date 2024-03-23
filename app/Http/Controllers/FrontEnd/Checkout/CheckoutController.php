<?php

namespace App\Http\Controllers\FrontEnd\Checkout;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use DB;
use Carbon\Carbon;
use App\Models\ContactsCountryEnum;

class CheckoutController extends Controller
{
    public function index()
    {
        $countaries = ContactsCountryEnum::orderBy('id','asc')->get();
        return view('front-end.checkout.checkout',compact('countaries'));
    }
}