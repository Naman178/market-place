<?php

namespace App\Http\Controllers\FrontEnd\Checkout;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use DB;
use Carbon\Carbon;
use App\Models\ContactsCountryEnum;
use App\Models\Items;
use App\Models\ItemsFeature;
use App\Models\ItemsImage;
use App\Models\ItemsPricing;
use App\Models\ItemsTag;
class CheckoutController extends Controller
{
    public function index($itemId)
    {
        $data = [];
        
        if ($itemId) {
            $item = Items::with(['features', 'tags', 'images', 'categorySubcategory', 'pricing'])
                         ->where('id', $itemId)
                         ->first();

            if (!$item) {
                abort(404);
            }

            $data['item'] = $item;
        }

        $data['countaries'] = ContactsCountryEnum::orderBy('id', 'asc')->get();
        return view('front-end.checkout.checkout', compact('data'));
    }
}