<?php

namespace App\Http\Controllers\FrontEnd\Checkout;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactsCountryEnum;
use App\Models\Items;

class CheckoutController extends Controller
{
    public function index(string $id)
    {
        $planId = base64_decode($id);

        $countaries = ContactsCountryEnum::orderBy('id')
            ->get();

        $plan = Items::with(["features", "images", "tags", "categorySubcategory", "pricing", "reviews", "reviews"])->find($planId);

        return view('front-end.checkout.checkout', compact('countaries', 'plan'));
    }
}

