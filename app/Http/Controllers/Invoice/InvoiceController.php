<?php

namespace App\Http\Controllers\Invoice;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ContactsCountryEnum;
use App\Models\Coupon;
use App\Models\CouponUsages;
use App\Models\InvoiceModel;
use App\Models\Items;
use App\Models\ItemsCategorySubcategory;
use App\Models\Key;
use App\Models\Order;
use App\Models\Settings;
use App\Models\SubCategory;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use PDF;
use Illuminate\Support\Str;
use Carbon\Carbon;

class InvoiceController extends Controller
{
    public function preview($id)
    {
        $setting = Settings::first();
        $invoice = InvoiceModel::find($id);
        $order = Order::find($invoice->orderid);
        $product = Items::find($order->product_id);
        $user = User::find($invoice->user_id);
        $country = ContactsCountryEnum::find($user->country_code);
        $key = Key::where('order_id',$order->id)->first();
        $validity = \Carbon\Carbon::parse($key->created_at)->format('d M Y') . ' - ' .  \Carbon\Carbon::parse($key->expire_at)->format('d M Y');
        
        return view('front-end.invoice.invoice-preview', compact('invoice' , 'setting','user','country','product','validity'));
    }
    public function downloadPdf($id)
    {
        $setting = Settings::first();
        $invoice = InvoiceModel::find($id);
        $order = Order::find($invoice->orderid);
        $product = Items::find($order->product_id);
        $user = User::find($invoice->user_id);
        $country = ContactsCountryEnum::find($user->country_code);
        $key = Key::where('order_id', $order->id)->first();
        $validity = \Carbon\Carbon::parse($key->created_at)->format('d M Y') . ' - ' . \Carbon\Carbon::parse($key->expire_at)->format('d M Y');

        $pdf = PDF::loadView('front-end.invoice.download-invoice', compact('invoice', 'setting', 'user', 'country', 'product', 'validity'))
        ->setOptions(['defaultFont' => 'sans-serif' , 'isHtml5ParserEnabled' => true])
        ->setPaper("A4", "portrait");

        return $pdf->stream('invoice-' . $invoice->invoice_number . '.pdf');
    }
    public function index()
    {
        $invoices = InvoiceModel::with(['order.product'])->get();
        return view('pages.Invoice.invoice',compact('invoices'));
    }
    public function viewOrder()
    {
        $invoices = InvoiceModel::with(['order.product'])->get();
        $order = Order::with(['product'])->get();
        return view('pages.Invoice.order',compact('invoices','order'));
    }
    public function edit($id)
    {
        $users = User::role('user')->get(); 
        $category = Category::whereIn('sys_state', [0, 1])->get();
        return view('pages.Invoice.createinvoice' ,compact('users' , 'category'));
    }
    public function fetchSubcategories(Request $request)
    {
        $subcategories = SubCategory::where('category_id', $request->category_id)->get();
        return response()->json(['subcategories' => $subcategories]);
    }
    public function fetchProducts(Request $request)
    {
        $cat_id = $request->category_id;
        $subcat_id = $request->sub_category_id;
        $productEntries = ItemsCategorySubcategory::where('category_id', $cat_id)->where('subcategory_id', $subcat_id)->get();

        $products = [];

        foreach ($productEntries as $entry) {
            $item = Items::with('pricing')->find($entry->item_id);
            // dd($item->)
            if ($item) {
                $products[] = [
                    'id' => $item->id,
                    'name' => $item->name,
                    'price' => $item->pricing->fixed_price ?? null,
                    'gst' => $item->pricing->gst_percentage ?? null,
                    'pricing_type' => $item->pricing->pricing_type ?? null,
                ];
            }
        }
        return response()->json(['products' => $products]);
    }

    public function fetchcoupon(Request $request)
    {
        $request->validate([
            'userid' => ['required', 'not_in:0'],
        ], [
            'userid.not_in' => 'User is required to apply coupon',
            'userid.required' => 'User selection is required.',
        ]);
        $product_id = $request->product_id;
        $item = Items::with('pricing')->find($product_id);
        $coupon_type = $item->pricing->pricing_type;
        $coupon = Coupon::whereIn('applicable_for',[$coupon_type , 'both'])->get();
        
        return response()->json(['coupon' => $coupon]);
    }
    public function store(Request $request)
    {
        $user_id = $request->userid;
        $categoryid = $request->categoryid;
        $sub_category_id = $request->sub_category_id;
        $product_id = $request->product_id;
        $coupon_id = $request->coupon_id;
        $subtotal = $request->subtotal;
        $gst = $request->gst;
        $discount = $request->discount;
        $fianlTotal = $request->fianlTotal;

        $request->validate([
            'userid' => ['required', 'not_in:0'], // Ensure user_id is not 0
        ], [
            'userid.not_in' => 'Please select a valid user.', // Custom error message
            'userid.required' => 'User selection is required.',
        ]);
        //create entry in Transaction table
        $transaction = Transaction::create([
            'user_id' => $user_id,
            'product_id' => $product_id,
            'payment_status' => 'succeeded',
            'payment_amount' => $fianlTotal * 100, //store in cent for other entry that's why amount * 100 
            'razorpay_payment_id' => null,
            'payment_method' => 'manually paid',
            'transaction_id' => null
        ]);


        //create order
        $order = Order::create([
            'product_id'=> $product_id,
            'user_id' => $user_id,
            'payment_status' => 'succeeded',
            'payment_amount' => $fianlTotal * 100, //store in cent for other entry that's why amount * 100 
            'razorpay_payment_id' => null,
            'payment_method' => 'manually paid',
            'transaction_id' => $transaction->id,
        ]);

        // create entry in coupon if applied
        if($coupon_id !== '0'){
            $discountvalue = ($fianlTotal * $discount)/100;
            $coupon = CouponUsages::create([ 
                'coupon_id'=>$coupon_id,
                'user_id'=>$user_id,
                'order_id'=>$order->id,
                'discount_value'=>$discountvalue,
            ]);
        }

        //create entry in wallet
        $wallet = Wallet::create([
            'user_id' => $user_id,
            'product_id' => $product_id,
            'wallet_amount' => $fianlTotal * 100,
            'total_order' => $fianlTotal * 100,
            'remaining_order' => $fianlTotal * 100,
        ]);

        $key = Str::random(50);
        $currentDateTime = Carbon::now();
        $oneYearLater = $currentDateTime->addYear();

        $keytbl =  Key::create([
            'key'=> $key,
            'user_id' => $user_id,
            'order_id' => $order->id,
            'product_id' => $product_id,
            'creared_at' => Carbon::now(),
            'expire_at' => $oneYearLater
        ]);

        //generate invoice number
        $today = now();
        $invoicesRes = InvoiceModel::whereDate("created_at", $today->toDateString())->count();
        $temp_inv_num = $invoicesRes + 1;
        $formatted_temp_inv_num = str_pad($temp_inv_num, 2, "0", STR_PAD_LEFT);
        $temp_date = date("d") . date("m") . date("y");
        $invoiceNo ="INV" . $temp_date . $formatted_temp_inv_num;
        $discountvalue = ($fianlTotal * $discount)/100;
        $invoice = InvoiceModel::create([
            'orderid' => $order->id,
            'user_id' => $user_id,
            'transaction_id' => $transaction->id,
            'invoice_number' => $invoiceNo,
            'subtotal' => $subtotal,
            'gst_percentage' => $gst,
            'discount_type' => 'percentage',
            'discount' => $discountvalue,
            'applied_coupon' => $coupon_id,
            'total' => $fianlTotal,
            'payment_method' => "Stripe",
            'payment_status' => 'succeeded',
        ]);
        return response()->json(['success' => true, 'invoice_id' => $invoice->id,'redirect_url' => route('invoice-preview', ['id' => $invoice->id])]);
    }
}
