<?php

namespace App\Console\Commands;

use App\Models\InvoiceModel;
use App\Models\Items;
use App\Models\Key;
use App\Models\Order;
use App\Models\SubscriptionRec;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CreateInvoice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:invoice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'generate recurring invoice';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command
     *
     * @return int
     */
    public function handle()
    {
        // $invoices = InvoiceModel::with(['product.pricing'])->whereNotNull('product_id')->get();
        $Subscriptions = SubscriptionRec::with(['invoice','product.pricing' ,'key'])->where('status','active')->get();
        foreach($Subscriptions as $sub){
            $expiry_date = Carbon::parse($sub->key->expire_at)->toDateString();
            $today = now()->toDateString();
            if($expiry_date === $today){
                $user_id = $sub->invoice->user_id;
                $product_id = $sub->invoice->product_id;
                $fianlTotal = $sub->invoice->total;
                $subtotal = $sub->invoice->subtotal;
                $gst = $sub->invoice->gst_percentage;
                $product_type = Items::with('pricing')->where('id' , $product_id)->first();
                $billing_cycle = $product_type->pricing->billing_cycle;

                $transaction = Transaction::create([
                    'user_id' => $user_id,
                    'product_id' => $product_id,
                    'payment_status' => 'pending paymenet',
                    'payment_amount' => $fianlTotal * 100, 
                    'razorpay_payment_id' => null,
                    'payment_method' => 'manually paid',
                    'transaction_id ' => null
                ]);

                $order = Order::create([
                    'product_id'=> $product_id,
                    'user_id' => $user_id,
                    'payment_status' => 'pending paymenet',
                    'payment_amount' => $fianlTotal * 100, 
                    'razorpay_payment_id' => null,
                    'payment_method' => 'manually paid',
                    'transaction_id' => $transaction->id,
                ]);

                $wallet = Wallet::create([
                    'user_id' => $user_id,
                    'product_id' => $product_id,
                    'wallet_amount' => $fianlTotal * 100,
                    'total_order' => $fianlTotal * 100,
                    'remaining_order' => $fianlTotal * 100,
                ]);

                $key = Str::random(50);
                $currentDateTime = Carbon::now();
                if ($billing_cycle === 'monthly') {
                    $currentDateTime->addMonth();
                } elseif ($billing_cycle === 'quarterly') {
                    $currentDateTime->addMonths(3);
                } elseif ($billing_cycle === 'semi-annually') {
                    $currentDateTime->addMonths(6);
                } elseif ($billing_cycle === 'annually') {
                    $currentDateTime->addYear();
                } else {
                    $currentDateTime->addYear();
                }
                $oneYearLater = $currentDateTime;

                if ($sub->key) { 
                    $sub->key->update([
                        'expire_at' => $currentDateTime,
                    ]);
                }

                $today = now();
                $invoicesRes = InvoiceModel::whereDate("created_at", $today->toDateString())->count();
                $temp_inv_num = $invoicesRes + 1;
                $formatted_temp_inv_num = str_pad($temp_inv_num, 2, "0", STR_PAD_LEFT);
                $temp_date = date("d") . date("m") . date("y");
                $invoiceNo ="INV" . $temp_date . $formatted_temp_inv_num;
                // $discountvalue = ($fianlTotal * $discount)/100;
                $invoice = InvoiceModel::create([
                    'orderid' => $order->id,
                    'user_id' => $user_id,
                    'transaction_id' => $transaction->id,
                    'invoice_number' => $invoiceNo,
                    'subtotal' => $subtotal,
                    'gst_percentage' => $gst ?? 18,
                    'discount_type' => 'percentage',
                    // 'discount' => ,
                    // 'applied_coupon' => $coupon_id,
                    'total' => $fianlTotal,
                    'payment_method' => "Manual Payment",
                    'payment_status' => 'succeeded',
                    'product_id' => $product_id
                ]);
            }
        }
        return 0;
    }
}
