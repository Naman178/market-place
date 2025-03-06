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
        $plan = Items::with(["features", "images", "tags", "categorySubcategory", "pricing", "reviews"])->find($planId);
    
        if (!$plan) {
            return redirect()->route('home')->with('error', 'Plan not found.');
        }

        $selectedPricing = null;
        if ($pricingId) {
            $selectedPricing = ItemsPricing::where('id', $pricingId)->first();
        } else {
            $selectedPricing = $plan->pricing()->first();
        }
        $mergedPricing = [];
        $cart = session()->get('cart', []);
        if (isset($cart[$planId])) {
            $existingPricing = collect($cart[$planId]['pricing']);
            $newPricing = collect([$selectedPricing]);
    
            $mergedPricing = $existingPricing->merge($newPricing)->unique('id')->values()->toArray();
            
            $cart[$planId]['pricing'] = $mergedPricing;
        } else {
            $cart[$planId] = [
                'item' => $plan,
                'pricing' => [$selectedPricing]
            ];
        }
        session()->put('cart', $cart);
        $couponCodes = Coupon::where('status', 'active')
            ->withCount('usage')
            ->get()
            ->filter(function ($coupon) {
                return $coupon->usage_count < $coupon->total_redemptions && $coupon->valid_until > now();
            });
    
        return view('front-end.checkout.checkout', compact('countaries', 'mergedPricing', 'plan', 'selectedPricing', 'user', 'couponCodes', 'cart'));
    }

    public function removeItem(Request $request)
    {
        $planId = $request->input('plan_id');
        $pricingId = $request->input('pricing_id');

        $cart = session()->get('cart', []);

        if (isset($cart[$planId])) {
            $cart[$planId]['pricing'] = array_filter($cart[$planId]['pricing'], function ($pricing) use ($pricingId) {
                return $pricing['id'] != $pricingId;
            });

            if (empty($cart[$planId]['pricing'])) {
                unset($cart[$planId]);
            }

            session()->put('cart', $cart);

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Item not found']);
    }

}
