<?php

namespace App\Http\Controllers\Stripe;

use App\Http\Controllers\Controller;
use App\Models\InvoiceModel;
use App\Models\Subscription;
use App\Models\SubscriptionRec;
use Illuminate\Http\Request;
use Stripe;
use Stripe\Customer;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Order;
use App\Models\Items;
use App\Models\Wallet;
use App\Models\Key;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Mail\SendThankyou;
use Illuminate\Support\Facades\Mail;
use App\Models\ContactsCountryEnum;
use App\Models\CouponUsages;

class StripePaymentController extends Controller
{
    public function stripePost(Request $request)
    {
        // dd($request->all());
        $input = $request->all();
        $product_id = $input['product_id'];
        $amount = $input['amount'];
        $plan_name = $input['plan_name'];
        $discount = $input['is_discount_applied'];
        $subtotal = $input['subtotal'];
        $gst = $input['gst'];
        $discountvalue = $input['discount_value'] ?? '';
        $coupon_code = $input['final_coupon_code'] ?? '';
        $plan_type = $input['plan_type'] ?? 'one_time';
        $currency = $input['currency'];
        $quantity = $input['final_quantity'];
        $trial_period_days = $input['trial_period_days'] ?? 0;

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $user = auth()->user();
        $isocode = ContactsCountryEnum::where('name', $user['country'])->pluck('ISOname')->first();

        $existingCustomer = \Stripe\Customer::all([
            'email' => $user['email'],
            'limit' => 1,
        ]);

        if ($existingCustomer->count() > 0) {
            $customer_id = $existingCustomer->data[0]->id;
        } else {
            $customer = \Stripe\Customer::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'address' => [
                    'line1' => $user['address_line_1'],
                    'line2' => $user['address_line_2'],
                    'city' => $user['city'],
                    'postal_code' => $user['zip'],
                    'country' => $isocode,
                ],
            ]);
            $customer_id = $customer->id;
        }

        if ($plan_type === 'recurring') {
            // **Step 1: Create a Product (if not exists)**
            $product = \Stripe\Product::create([
                'name' => $plan_name,
                'type' => 'service',
            ]);

            // **Step 2: Create a Price for the Subscription**
            $price = \Stripe\Price::create([
                'unit_amount' => $amount,
                'currency' => $currency,
                'recurring' => ['interval' => 'month'],
                'product' => $product->id,
            ]);

            // **Step 3: Create Subscription**
            $subscription = \Stripe\Subscription::create([
                'customer' => $customer_id,
                'items' => [['price' => $price->id]],
                'payment_behavior' => 'default_incomplete',
                'metadata' => [
                    'product_id' => $product_id,
                    'user_id' => $user['id'],
                    'plan_name' => $plan_name,
                    'quantity' => $quantity,
                    'order_id' => $product_id,
                ],
                'trial_period_days' => $trial_period_days,
                'expand' => ['latest_invoice.payment_intent'],
            ]);

            $paymentIntent = $subscription->latest_invoice->payment_intent;

        } else {
            // **One-time payment**
            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => $amount,
                'currency' => $currency,
                'customer' => $customer_id,
                'payment_method_types' => ['card'],
                'description' => 'Payment For the Skyfinity Quick Checkout Wallet',
            ]);
        }

        $paymentMethod = \Stripe\PaymentMethod::create([
            'type' => 'card',
            'card' => [
                'token' => $request->stripeToken,
            ],
        ]);
        $return_url_params = [
            'product_id' => $product_id,
            'subtotal' => $subtotal,
            'gst' => $gst,
            'amount' => $amount,
            'discount' => $discount,
            'coupon_code' => $coupon_code,
            'discountvalue' => $discountvalue,
            'plan_type' => $plan_type,
            'quantity' => $quantity
        ];
        if ($plan_type === 'recurring') {
            $return_url_params['subscription_id'] = $subscription->id;
        }
        if (!$trial_period_days && $paymentIntent) {
            // Confirm payment if no trial period
            $stripe_payment = $paymentIntent->confirm([
                'payment_method' => $paymentMethod->id ?? null,
                'return_url' => route('stripe-payment-3d', $return_url_params),
            ]);
        
            if ($stripe_payment->status === 'requires_action') {
                $authenticationUrl = $paymentIntent->next_action->redirect_to_url->url;

                echo "<script>window.location.href = '$authenticationUrl';</script>";
                exit;
            }
        
            return redirect()->route('user-dashboard')->with('success', 'Subscription confirmed and active!');
        }
        // If trial period is set, redirect to the success page without confirming the payment
        return redirect()->route('user-dashboard')->with('success', 'Subscription created with trial period!');        

        // $stripe_payment = $paymentIntent->confirm([
        //     'payment_method' => $paymentMethod->id,
        //     'return_url' => route('stripe-payment-3d', $return_url_params),
        // ]);

        // if ($paymentIntent->status === 'requires_action') {
        //     $authenticationUrl = $paymentIntent->next_action->redirect_to_url->url;

        //     echo "<script>window.location.href = '$authenticationUrl';</script>";
        //     exit;
        // }
    }

    public function stripeAfterPayment(Request $request){

        $user = auth()->user();
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $product_id = $_GET['product_id'];
        $amount = $_GET['amount'];
        $old_amount = $amount;
        $coupon_code = $_GET['coupon_code'];
        $discountvalue = $_GET['discountvalue'];
        $subtotal = $_GET['subtotal'];
        $gst_percentage = $_GET['gst'];
        $quantity = $_GET['quantity'] ?? 1;
        $plan_type = $_GET['plan_type'] ?? 'one_time';

        // $discount = $_GET['discount'];
        // if($discount == 'yes'){
        //     $plan = Plan::where('id',$product_id)->first();
        //     $amount = $plan->yearly_price;
        // }

        $paymentIntentId = $_GET['payment_intent'];

        $stripe_payment = \Stripe\PaymentIntent::retrieve($paymentIntentId);

        $stripe_payment_id = $stripe_payment->id;
        $stripe_payment_method = $stripe_payment['payment_method'];
        $stripe_payment_status = $stripe_payment->status;
        if ($stripe_payment_status === 'succeeded') {

            // $plan = Plan::where('id',$product_id)->first();
            $per_order_amount = 1;

            $tran = Transaction::create([
                'user_id' => $user['id'],
                'product_id' => $product_id,
                'payment_status' => $stripe_payment_status,
                'payment_amount' => $old_amount,
                'razorpay_payment_id' => $stripe_payment_id,
                'payment_method' => $stripe_payment_method,
                'transaction_id' => $stripe_payment_id
            ]);

            $transaction_id = $tran->id;

            // $existingOrder = Order::where('user_id', $user['id'])->first();
            // if ($existingOrder) {
            //     $order_id = $existingOrder->id;

            //     $wallet = Wallet::where('user_id', $user['id'])->first();
            //     $update_order = Order::where('id', $order_id)->first();

            //     $wallet_amount = $wallet->wallet_amount;
            //     $total_order = $wallet->total_order;
            //     $remaining_order = $wallet->remaining_order;

            //     $new_total_order = intval($amount/$per_order_amount);

            //     $update_wallet_amount = $amount + $wallet_amount;
            //     $update_total_order = $total_order + $new_total_order;
            //     $update_remaining_order = $remaining_order + $new_total_order;

            //     $wallet->update([
            //         'product_id' => $product_id,
            //         'wallet_amount' => $update_wallet_amount,
            //         'total_order' => $update_total_order,
            //         'remaining_order' => $update_remaining_order,
            //     ]);

            //     $update_order->update([
            //         'product_id'=> $product_id,
            //     ]);
            // }
            // else{
                // add data to order id
                $order = Order::create([
                    'product_id'=> $product_id,
                    'user_id' => $user['id'],
                    'payment_status' => $stripe_payment_status,
                    'payment_amount' => $amount,
                    'razorpay_payment_id' => $stripe_payment_id,
                    'payment_method' => $stripe_payment_method,
                    'transaction_id' => $transaction_id
                ]);

                if($coupon_code != '' && $discountvalue != ''){
                    $usage = CouponUsages::create([
                        'coupon_id'=>$coupon_code,
                        'user_id'=>$user['id'],
                        'order_id'=>$order->id,
                        'discount_value'=>$discountvalue,
                    ]);
                }

                $order_id = $order->id;

                $total_order = intval($amount/$per_order_amount);

                $wallet = Wallet::create([
                    'user_id' => $user['id'],
                    'product_id' => $product_id,
                    'wallet_amount' => $amount,
                    'total_order' => $total_order,
                    'remaining_order' => $total_order,
                ]);
                // add data to wallet
                $keyIds = [];
                for ($i = 0; $i < $quantity; $i++) {
                    // Key generation and add data to the key table.
                    $key = Str::random(50);
                    $currentDateTime = Carbon::now();
                    $oneYearLater = $currentDateTime->addYear();
                
                    $keytbl = Key::create([
                        'key' => $key,
                        'user_id' => $user['id'],
                        'order_id' => $order_id,
                        'product_id' => $product_id,
                        'created_at' => Carbon::now(),
                        'expire_at' => $oneYearLater
                    ]);
                    $keyIds[] = $keytbl->id;
                }
                $keyIdsString = implode(',', $keyIds);
                // dd(2,$order , $keytbl);
            // }

            $wallet_mail = Wallet::where('user_id', $user['id'])->first();
            $order_mail = Order::where('user_id', $user['id'])->first();

            $mailData = [
                'title' => 'Thank You for Topping Up and Placing Your Order!',
                'name' => $user['name'],
                'order_id' => $order_mail->id,
                'total_order' => $wallet_mail->total_order,
                'remaining_order' => $wallet_mail->remaining_order,
                'wallet_amount' => $wallet_mail->wallet_amount,
            ];
            if ($plan_type === 'recurring') {
                $subscription_id = $_GET['subscription_id'] ?? null;
                if ($subscription_id) {
                    Subscription::create([
                        'user_id' => $user['id'],
                        'subscription_id' => $subscription_id,
                        'product_id' => $product_id,
                        'status' => 'active',
                        'key_id' => $keyIdsString
                    ]);
                }
            }

            $today = now();
            $invoicesRes = InvoiceModel::whereDate("created_at", $today->toDateString())->count();
            $temp_inv_num = $invoicesRes + 1;
            $formatted_temp_inv_num = str_pad($temp_inv_num, 2, "0", STR_PAD_LEFT);
            $temp_date = date("d") . date("m") . date("y");
            $invoiceNo ="INV" . $temp_date . $formatted_temp_inv_num;

            $invoice = InvoiceModel::create([
                'orderid' => $order_id,
                'user_id' => $user['id'],
                'transaction_id' => $transaction_id,
                'invoice_number' => $invoiceNo,
                'subtotal' => $subtotal,
                'gst_percentage' => $gst_percentage,
                'discount_type' => 'percentage',
                'discount' => $discountvalue,
                'applied_coupon' => $coupon_code,
                'total' => $old_amount / 100,
                'payment_method' => "Stripe",
                'payment_status' => $stripe_payment_status,
                'product_id' => $product_id,
                'quantity' => $quantity
            ]);
            if($plan_type === 'recurring'){
                $subscription_rec = SubscriptionRec::create([
                    'user_id' => $user['id'],
                    'product_id' => $product_id,
                    'order_id' => $order_id,
                    'invoice_id' => $invoice->id,
                    'key_id' => $keyIdsString,
                    'status' => 'active',
                ]);
            }
            // Mail::to($user['email'])->send(new SendThankyou($mailData));
            $request->session()->forget('cart');
            $request->session()->forget('product_id');
            $request->session()->forget('amount');

            session()->flash('success', 'Payment Successfull!');
            return redirect()->route('invoice-preview', ['id' => $invoice->id]);
        }
        elseif($stripe_payment_status === 'requires_payment_method'){

            $tran = Transaction::create([
                'user_id' => $user['id'],
                'product_id' => $product_id,
                'payment_status' => $stripe_payment_status,
                'payment_amount' => $old_amount,
                'razorpay_payment_id' => $stripe_payment_id,
                'payment_method' => $stripe_payment_method,
                'transaction_id' => $stripe_payment_id
            ]);

            session()->flash('success', 'Payment Failed');
            return redirect()->route('user-dashboard');
        }
        elseif($stripe_payment_status === 'failed'){

            $tran = Transaction::create([
                'user_id' => $user['id'],
                'product_id' => $product_id,
                'payment_status' => $stripe_payment_status,
                'payment_amount' => $old_amount,
                'razorpay_payment_id' => $stripe_payment_id,
                'payment_method' => $stripe_payment_method,
                'transaction_id' => $stripe_payment_id
            ]);

            session()->flash('success', 'Payment Failed');
            return redirect()->route('user-dashboard');
        }
        else{

            $tran = Transaction::create([
                'user_id' => $user['id'],
                'product_id' => $product_id,
                'payment_status' => $stripe_payment_status,
                'payment_amount' => $old_amount,
                'razorpay_payment_id' => $stripe_payment_id,
                'payment_method' => $stripe_payment_method,
                'transaction_id' => $stripe_payment_id
            ]);

            session()->flash('success', 'Payment Failed');
            return redirect()->route('user-dashboard');
        }
    }
    // public function handleWebhook(Request $request)
    // {
    //     \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

    //     $payload = $request->all();
    //     $event = $payload['type'] ?? '';

    //     if ($event === 'invoice.payment_succeeded') {
    //         $invoice = $payload['data']['object'];
    //         $subscription_id = $invoice['subscription'];
    //         $user = Subscription::where('subscription_id', $subscription_id)->first();

    //         if ($user) {
    //             $this->generateInvoice(
    //                 $user,
    //                 $invoice['id'],
    //                 $invoice['lines']['data'][0]['metadata']['order_id'] ?? null,
    //                 $invoice['subtotal'] / 100,
    //                 18, // Assume 18% GST
    //                 $invoice['discounts'][0]['coupon']['percent_off'] ?? 0,
    //                 $invoice['discounts'][0]['coupon']['id'] ?? '',
    //                 $invoice['total'] / 100,
    //                 $invoice['status']
    //             );
    //         }
    //     }

    //     return response()->json(['status' => 'success']);
    // }
    public function handleWebhook(Request $request)
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $payload = $request->all();
        $eventType = $payload['type'] ?? '';
    
        if ($eventType === 'invoice.payment_succeeded') {
            $invoice = $payload['data']['object'];
            $subscription_id = $invoice['subscription'] ?? null;
    
            if (!$subscription_id) {
                \Log::warning('Stripe Webhook: Subscription ID missing in invoice');
                return response()->json(['status' => 'no_subscription'], 400);
            }
    
            $user = Subscription::where('subscription_id', $subscription_id)->first();

            if ($user) {
                $lines = $invoice['lines']['data'][0] ?? [];
                $metadata = $lines['metadata'] ?? [];
                
                $product_id = $metadata['product_id'] ?? null;
                $plan_name = $metadata['plan_name'] ?? null;
                $quantity = $metadata['quantity'] ?? 1;
            
                $stripe_payment_id = $invoice['payment_intent'] ?? null;
                $stripe_payment_method = $invoice['payment_settings']['payment_method_options']['card']['brand'] ?? 'stripe';
                $stripe_payment_status = $invoice['status'];
                $amount_paid = $invoice['total'] / 100;
            
                // ✅ Save transaction
                $tran = Transaction::create([
                    'user_id' => $user->user_id,
                    'product_id' => $product_id,
                    'payment_status' => $stripe_payment_status,
                    'payment_amount' => $amount_paid,
                    'razorpay_payment_id' => $stripe_payment_id,
                    'payment_method' => $stripe_payment_method,
                    'transaction_id' => $stripe_payment_id,
                ]);
            
                // ✅ Create Order
                $order = Order::create([
                    'product_id'=> $product_id,
                    'user_id' => $user['id'],
                    'payment_status' => $stripe_payment_status,
                    'payment_amount' => $amount_paid,
                    'razorpay_payment_id' => $stripe_payment_id,
                    'payment_method' => $stripe_payment_method,
                    'transaction_id' => $tran->id,
                ]);
                
            
                // ✅ Optional: Generate Invoice
                $this->generateInvoice(
                    $user,
                    $invoice['id'],
                    $order->id,
                    $invoice['subtotal'] / 100,
                    18,
                    $invoice['discounts'][0]['coupon']['percent_off'] ?? 0,
                    $invoice['discounts'][0]['coupon']['id'] ?? '',
                    $amount_paid,
                    $stripe_payment_status
                );
            }else {
                \Log::warning("Stripe Webhook: No user found for subscription ID $subscription_id");
            }
        }

        return response()->json(['status' => 'success']);
    }

    private function generateInvoice($user, $transaction_id, $order_id, $subtotal, $gst_percentage, $discountvalue, $coupon_code, $total_amount, $status)
    {
        $today = now();
        $invoicesRes = InvoiceModel::whereDate("created_at", $today->toDateString())->count();
        $temp_inv_num = str_pad($invoicesRes + 1, 2, "0", STR_PAD_LEFT);
        $temp_date = date("d") . date("m") . date("y");
        $invoiceNo = "INV" . $temp_date . $temp_inv_num;

        return InvoiceModel::create([
            'orderid' => $order_id,
            'user_id' => $user->id,
            'transaction_id' => $transaction_id,
            'invoice_number' => $invoiceNo,
            'subtotal' => $subtotal,
            'gst_percentage' => $gst_percentage,
            'discount_type' => 'percentage',
            'discount' => $discountvalue,
            'applied_coupon' => $coupon_code,
            'total' => $total_amount / 100,
            'payment_method' => "Stripe",
            'payment_status' => $status,
        ]);
    }
    public function cancelSubscription($id)
    {
        try {
            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            $subscription = SubscriptionRec::find($id);
            if($subscription){
                $subscription->update(['status' => 'cancel']);
                $stripeSubscription = Subscription::where('key_id',$subscription->key_id)->first();
                if($stripeSubscription){
                    $subscriptionStripe = \Stripe\Subscription::retrieve($stripeSubscription->subscription_id);
                    if (!empty($subscriptionStripe) && isset($subscriptionStripe->id) && $subscriptionStripe->status !== 'canceled') {
                        $subscriptionStripe->cancel();
                    }
                }
            } 

            $userSubscription = Subscription::where('key_id', $subscription->key_id)->first();
            if ($userSubscription) {
                $userSubscription->update(['status' => 'canceled']);
            }
            
            $key_id = $subscription->key_id;
            if ($key_id) {
                $key = Key::find($key_id);
                if ($key) {
                    $key->update([
                        'expire_at' => now(),
                        'sys_state' => '1',
                    ]);
                }
            }
            return redirect()->back()->with('success', 'Subscription canceled successfully.');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with('error', 'Error canceling subscription: ' . $e->getMessage());
        }
    }
}
