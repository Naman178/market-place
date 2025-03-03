<?php

namespace App\Http\Controllers\Invoice;

use App\Http\Controllers\Controller;
use App\Models\ContactsCountryEnum;
use App\Models\InvoiceModel;
use App\Models\Items;
use App\Models\Key;
use App\Models\Order;
use App\Models\Settings;
use App\Models\User;
use Illuminate\Http\Request;
use PDF;

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
}
