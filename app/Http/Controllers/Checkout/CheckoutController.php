<?php

namespace App\Http\Controllers\Checkout;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use DB;
use Carbon\Carbon;

class CheckoutController extends Controller
{
    public function index()
    {
        return view('front-end.checkout.checkout');
    }
}