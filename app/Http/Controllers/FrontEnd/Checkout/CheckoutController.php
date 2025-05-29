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
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    // public function index(Request $request, string $id)
    // {
    //     $planId = base64_decode($id); 
    //     $pricingId = $request->query('pricing_id');
    //     $countaries = ContactsCountryEnum::orderBy('id')->get();
    //     $user = Auth::user();
    //     $plan = Items::with(["features", "images", "tags", "categorySubcategory", "pricing", "reviews"])->find($planId);
    
    //     if (!$plan) {
    //         return redirect()->route('home')->with('error', 'Plan not found.');
    //     }
    //     $categorySubcategory = $plan->categorySubcategory;
            
    //     if (!$categorySubcategory) {
    //         return redirect()->route('home')->with('error', 'Category and subcategory details not found.');
    //     }

    //     // Retrieve category name
    //     $category = Category::find($categorySubcategory->category_id);
    //     $categoryName = $category ? $category->name : 'Unknown Category';

    //     // Retrieve subcategory slug
    //     $subcategory = SubCategory::find($categorySubcategory->subcategory_id);
    //     $subcategorySlug = $subcategory ? $subcategory->slug : 'Unknown Slug';


    //     $selectedPricing = null;
    //     if ($pricingId) {
    //         $selectedPricing = ItemsPricing::where('id', $pricingId)->first();
    //     } else {
    //         $selectedPricing = $plan->pricing()->first();
    //     }
    //     $mergedPricing = [];
    //     $cart = session()->get('cart', []);
        
    //     if (isset($cart[$planId])) {
    //         $existingPricing = collect($cart[$planId]['pricing']);
    //         $newPricing = collect([$selectedPricing]);
    
    //         $mergedPricing = $existingPricing->merge($newPricing)->unique('id')->values()->toArray();

    //         $keyFeatures = $plan->features->pluck('key_feature')->toArray();
    //         $mergedPricing = array_map(function ($pricing) use ($keyFeatures) {
    //             return array_merge((array)$pricing, ['key_features' => $keyFeatures]);
    //         }, $mergedPricing);

    //         $cart[$planId]['pricing'] = $mergedPricing;
    //     } else {
    //         $keyFeatures = $plan->features->pluck('key_feature')->toArray();
    //         $mergedPricing = array_map(function ($pricing) use ($keyFeatures) {
    //             return array_merge((array)$pricing, ['key_features' => $keyFeatures]);
    //         }, $mergedPricing);
    //         $cart[$planId] = [
    //             'item' => $plan,
    //             'pricing' => [$selectedPricing]
    //         ];
    //     }
    //     // dd($mergedPricing);
    //     session()->put('cart', $cart);
    //     $couponCodes = Coupon::where('status', 'active')
    //         ->withCount('usage')
    //         ->get()
    //         ->filter(function ($coupon) {
    //             return $coupon->usage_count < $coupon->total_redemptions && $coupon->valid_until > now();
    //         });
    
    //     return view('front-end.checkout.checkout', compact('countaries', 'mergedPricing', 'plan', 'selectedPricing', 'user', 'couponCodes', 'cart','categoryName','subcategorySlug'));
    // }
   public function index(Request $request, string $id)
    {
        $planId = base64_decode($id);
        $pricingId = $request->query('pricing_id');

        $countaries = ContactsCountryEnum::orderBy('id')->get();
        $user = Auth::user();

        $plan = Items::with(['features', 'images', 'tags', 'categorySubcategory', 'pricing', 'reviews'])
            ->find($planId);

        if (!$plan) {
            return back()->with('error', 'Plan not found.');
        }

        $categorySubcategory = $plan->categorySubcategory;
        if (!$categorySubcategory) {
            return back()->with('error', 'Category and subcategory details not found.');
        }

        $category = Category::find($categorySubcategory->category_id);
        $subcategory = SubCategory::find($categorySubcategory->subcategory_id);
        $categoryName = $category ? $category->name : 'Unknown Category';
        $subcategorySlug = $subcategory ? $subcategory->slug : 'unknown-slug';

        // ❌ Prevent adding a second plan if one already exists
        if (session()->has('cart')) {
            $existingCart = session('cart');
            if ($existingCart['plan_id'] !== $plan->id) {
                return back()->with('error', 'You can only add one plan to the cart at a time.');
            }
        }

        $selectedPricing = $pricingId
            ? ItemsPricing::find($pricingId)
            : $plan->pricing()->first();

        if (!$selectedPricing) {
            return back()->with('error', 'Pricing information not found.');
        }

        // ✅ Store the plan in session
        $cart = [
            'plan_id' => $plan->id,
            'item' => $plan,
            'pricing' => $selectedPricing
        ];
        session()->put('cart', $cart);

        $couponCodes = Coupon::where('status', 'active')
            ->withCount('usage')
            ->get()
            ->filter(function ($coupon) {
                return $coupon->usage_count < $coupon->total_redemptions &&
                    $coupon->valid_until > now();
            });

        return view('front-end.checkout.checkout', compact(
            'countaries',
            'plan',
            'selectedPricing',
            'user',
            'couponCodes',
            'cart',
            'categoryName',
            'subcategorySlug'
        ));
    }




    // public function removeItem(Request $request)
    // {
    //     $planId = $request->input('plan_id');
    //     $pricingId = $request->input('pricing_id');

    //     $cart = session()->get('cart', []);

    //     if (isset($cart[$planId])) {
    //         $cart[$planId]['pricing'] = array_filter($cart[$planId]['pricing'], function ($pricing) use ($pricingId) {
    //             return $pricing['id'] != $pricingId;
    //         });

    //         if (empty($cart[$planId]['pricing'])) {
    //             unset($cart[$planId]);
    //         }

    //         session()->put('cart', $cart);

    //         return response()->json(['success' => true]);
    //     }

    //     return response()->json(['success' => false, 'message' => 'Item not found']);
    // }
   public function removeItem(Request $request)
    {
        session()->forget('cart');

        return response()->json([
            'success' => true,
            'message' => 'Item removed successfully.'
        ]);
    }


}
