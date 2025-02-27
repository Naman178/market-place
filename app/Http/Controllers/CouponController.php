<?php

namespace App\Http\Controllers;

use App\helper\helper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Items;
use App\Models\ItemsCategorySubcategory;
use App\Models\SubCategory;
use Exception;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:coupon-list|coupon-create|coupon-edit|coupon-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:coupon-create', ['only' => ['edit', 'store']]);
        $this->middleware('permission:coupon-edit', ['only' => ['edit', 'store']]);
        $this->middleware('permission:coupon-delete', ['only' => ['destroy']]);
        $this->middleware('permission:coupon-tab-show', ['only' => ['index', 'show', 'edit', 'store', 'destroy']]);
    }

    public function index()
    {
        $coupons = Coupon::all();
        return view('pages.coupon.coupon', compact('coupons'));
    }

    public function edit($id)
    {
        if ($id == 'new') {
            $coupon = Coupon::where('id', $id)->first();
            return view('pages.coupon.edit', compact('coupon'));
        } else {
            $coupon = Coupon::where('id', $id)->first();
            $applicableSelectionIds = is_array($coupon->applicable_selection)
                ? $coupon->applicable_selection
                : json_decode($coupon->applicable_selection, true);

            $applicableSelections = [];
            if ($coupon->applicable_type == 'category') {
                $applicableSelections = Category::whereIn('id', $applicableSelectionIds)->pluck('name', 'id');
            } elseif ($coupon->applicable_type == 'sub-category') {
                $applicableSelections = SubCategory::whereIn('category_id', $applicableSelectionIds)->pluck('name', 'category_id');
            } elseif ($coupon->applicable_type == 'product') {
                $applicableSelections = Items::whereIn('id', $applicableSelectionIds)->pluck('name', 'id');
            }
            return view('pages.coupon.edit', compact('coupon','applicableSelections'));
        }
    }

    public function store(Request $request)
    {
        $rules = [
            'discount_type' => 'required|in:flat,percentage',
            'discount_value' => 'required|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'valid_from' => 'required|date',
            'valid_until' => 'required|date|after_or_equal:valid_from',
            'min_cart_amount' => 'required|numeric|min:0',
            'applicable_type' => 'required|in:all,category,sub-category,product',
            'applicable_selection' => 'nullable|array',
            'applicable_for' => 'required|in:one-time,recurring,both',
            'limit_per_user' => 'nullable|integer|min:1',
            'total_redemptions' => 'nullable|integer|min:1',
        ];

        // Apply `coupon_code` validation only when creating a new coupon
        if ($request->id == 'new') {
            $rules['coupon_code'] = 'required|unique:coupons|max:255';
        }

        $request->validate($rules);

        $couponData = [
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'max_discount' => $request->max_discount,
            'valid_from' => $request->valid_from,
            'valid_until' => $request->valid_until,
            'min_cart_amount' => $request->min_cart_amount,
            'applicable_type' => $request->applicable_type,
            'applicable_selection' => is_array($request->applicable_selection) ? $request->applicable_selection : explode(',', $request->applicable_selection),
            'applicable_for' => $request->applicable_for,
            'limit_per_user' => $request->limit_per_user,
            'total_redemptions' => $request->total_redemptions,
            'status' => $request->status,
            'auto_apply' => $request->auto_applycheckbox == 'on' ? 'yes' : 'no',
        ];

        // Only set coupon_code if creating a new coupon
        if ($request->id == 'new') {
            $couponData['coupon_code'] = $request->coupon_code;
        }

        $coupon = Coupon::updateOrCreate(['id' => $request->id], $couponData);

        return response()->json([
            'success' => true,
        ]);
    }

    public function remove($id)
    {
        try{
            $coupon = Coupon::where('id',$id)->first();
            $coupon->delete();
            return redirect()->back()
                ->with([
                    'success' => trans('custom.coupon_delete_success'),
                    'title' => trans('custom.coupons_title')
                ]);
        }catch(Exception $e){
            return redirect()->back()
                ->with([
                    'error' => $e->getMessage(),
                    'title' => trans('custom.coupons_title')
                ]);
        }
    }

    public function getApplicableData(Request $request)
    {
        if ($request->type == 'category') {
            $data = Category::select('id', 'name')->get();
        } elseif ($request->type == 'sub-category') {
            $data = SubCategory::select('category_id as id', 'name')->get();
        } elseif ($request->type == 'product') {
            $data = Items::select('id', 'name')->get();
        }
        return response()->json(['success' => true, 'data' => $data]);
    }
}
