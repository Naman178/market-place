<?php

namespace App\Http\Controllers\FrontEnd\Checkout;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactsCountryEnum;
use App\Models\Coupon;
use App\Models\Items;
use App\Models\ItemsFeature;
use App\Models\ItemsImage;
use App\Models\ItemsPricing;
use App\Models\ItemsTag;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index(string $id)
    {
        $planId = base64_decode($id);
        $countaries = ContactsCountryEnum::orderBy('id')->get();
        $plan = Items::with(["features", "images", "tags", "categorySubcategory", "pricing", "reviews", "reviews"])->find($planId);
        $user = Auth::user();
        $couponCodes = Coupon::where('status','active')->get();
        return view('front-end.checkout.checkout', compact('countaries', 'plan', 'user', 'couponCodes'));
    }
}
