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
    public function index(Request $request, string $id)
    {
        $planId = base64_decode($id); 
        $pricingId = $request->query('pricing_id');
        $countaries = ContactsCountryEnum::orderBy('id')->get();
        $user = Auth::user();
        $plan = Items::with(["features", "images", "tags", "categorySubcategory", "pricing", "reviews", "reviews"])->find($planId);
    
        if (!$plan) {
            return redirect()->route('home')->with('error', 'Plan not found.');
        }

        $selectedPricing = null;
        if ($pricingId) {
            $selectedPricing = ItemsPricing::where('id', $pricingId)->first();
        }else{
            $selectedPricing = $plan->pricing()->first();
        }
    
        $couponCodes = Coupon::where('status', 'active')
            ->withCount('usage')
            ->get()
            ->filter(function ($coupon) {
                return $coupon->usage_count < $coupon->total_redemptions && $coupon->valid_until > now();
            });
    
        return view('front-end.checkout.checkout', compact('countaries', 'plan', 'selectedPricing', 'user', 'couponCodes'));
    }
}
