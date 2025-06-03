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
        $input_interval = strtolower($input['billing_cycle'] ?? 'month');

        switch ($input_interval) {
            case 'monthly':
                $plan_interval = 'month';
                break;
            case 'yearly':
                $plan_interval = 'year';
                break;
            case 'weekly':
                $plan_interval = 'week';
                break;
            case 'quarterly':
                $plan_interval = 'month';
                break;
            default:
                $plan_interval = 'month';
        }

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        if (auth()->check()) {
            $user = auth()->user();
        } else {
            $user = User::latest()->first();
        }

        $isocode = ContactsCountryEnum::where('name', $user['country'])->pluck('ISOname')->first();

        $existingCustomer = \Stripe\Customer::all([
            'email' => $user['email'],
            'limit' => 1,
        ]);

        if ($existingCustomer->count() > 0) {
            $customer_id = $existingCustomer->data[0]->id;
            $existingSubscriptions = \Stripe\Subscription::all([
                'customer' => $customer_id,
                'limit' => 1,
                'status' => 'active',
            ]);
            if($trial_period_days <= 0){
            // If an active subscription exists, delete it
            if (!empty($existingSubscriptions->data)) {
                $subscription_id = $existingSubscriptions->data[0]->id;
                \Stripe\Subscription::retrieve($subscription_id)->cancel(); 
            }
            \Stripe\Customer::retrieve($customer_id)->delete();
        }
        } 
            sleep(2);

            // Create a new customer
            $newCustomer = \Stripe\Customer::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'address' => [
                    'line1' => $user['address_line_1'] ?? $user['address_line1'],
                    'line2' => $user['address_line_2'] ?? $user['address_line2'],
                    'city' => $user['city'],
                    'postal_code' => $user['zip'],
                    'country' => $isocode,
                ],
            ]);
            $customer_id = $newCustomer->id;

        // if ($plan_type === 'recurring') {
        //     // **Step 1: Create a Product (if not exists)**
        //     $product = \Stripe\Product::create([
        //         'name' => $plan_name,
        //         'type' => 'service',
        //     ]);

        //     // **Step 2: Create a Price for the Subscription**
        //     $price = \Stripe\Price::create([
        //         'unit_amount' => $amount,
        //         'currency' => $currency,
        //         'recurring' => ['interval' => $plan_interval],
        //         'product' => $product->id,
        //     ]);

        //     // **Step 3: Create Subscription**
        //     $subscription = \Stripe\Subscription::create([
        //         'customer' => $customer_id,
        //         'items' => [['price' => $price->id]],
        //         'payment_behavior' => 'default_incomplete',
        //         'metadata' => [
        //             'product_id' => $product_id,
        //             'user_id' => $user['id'],
        //             'plan_name' => $plan_name,
        //             'quantity' => $quantity,
        //             'order_id' => $product_id,
        //             'currency' => $currency,
        //         ],
        //         'trial_period_days' => $trial_period_days,
        //         'expand' => ['latest_invoice.payment_intent'],
        //     ]);

        //     $paymentIntent = $subscription->latest_invoice->payment_intent;

        // } 
        if ($plan_type === 'recurring') {
            for ($i = 0; $i < $quantity; $i++) {
                // Step 1: Create a Product (if not exists)
                $product = \Stripe\Product::create([
                    'name' => $plan_name,
                    'type' => 'service',
                ]);

                // Step 2: Create a Price for the Subscription
                $price = \Stripe\Price::create([
                    'unit_amount' => $amount,
                    'currency' => $currency,
                    'recurring' => ['interval' => $plan_interval],
                    'product' => $product->id,
                ]);

                // Step 3: Create Subscription
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
                        'currency' => $currency,
                    ],
                    'trial_period_days' => $trial_period_days,
                    'expand' => ['latest_invoice.payment_intent'],
                ]);

                $paymentIntent = $subscription->latest_invoice->payment_intent;
            }
        }
        else {
            // **One-time payment**
            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => $amount,
                'currency' => $currency,
                'customer' => $customer_id,
                'payment_method_types' => ['card'],
                'description' => 'Payment For the Market Place Checkout Wallet',
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
            'quantity' => $quantity,
            'currency' => $currency,
        ];
        if ($plan_type === 'recurring') {
            $return_url_params['subscription_id'] = $subscription->id;
        }
        
        if (auth()->check()) {
        if (!$trial_period_days > 0 && $paymentIntent) {
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
          }
          }
        else{
            if (!$trial_period_days > 0 && $paymentIntent) {
                $stripePayment = $paymentIntent->confirm([
                    'payment_method' => $paymentMethod,
                    'return_url' => route('stripe-payment-3d', ['user_id' => $user->id] + $return_url_params),
                ]);

                if ($stripePayment->status === 'requires_action') {
                    return response()->json([
                        'success' => true,
                        'requires_action' => true,
                        'redirect_url' => [
                            'url' => $paymentIntent->next_action->redirect_to_url->url
                        ]
                    ]);
                }
            }
        }
        if (!auth()->check() && $user->id) {
            auth()->loginUsingId($user->id);
        }
        if ($trial_period_days > 0) {
            // Create transaction with trial status
            $stripe_payment_id = 'trial_' . uniqid();
            $stripe_payment_method = 'trial';
            $stripe_payment_status = 'trialing';
            $amount_paid = 0;

            $tran = Transaction::create([
                'user_id' => $user->id,
                'product_id' => $product_id,
                'payment_status' => $stripe_payment_status,
                'payment_amount' => $amount_paid,
                'razorpay_payment_id' => $stripe_payment_id,
                'payment_method' => $stripe_payment_method,
                'transaction_id' => $stripe_payment_id,
                'currency' => $currency
            ]);

            // For each quantity, create a trial order + key
            for ($i = 0; $i < $quantity; $i++) {
                $order = Order::create([
                    'product_id' => $product_id,
                    'user_id' => $user->id,
                    'payment_status' => $stripe_payment_status,
                    'payment_amount' => $amount_paid,
                    'razorpay_payment_id' => $stripe_payment_id,
                    'payment_method' => $stripe_payment_method,
                    'transaction_id' => $tran->id,
                    'currency' => $currency
                ]);

                // Generate a license/key for each order
                $key = Str::random(50);
                $expireDate = now()->addDays($trial_period_days);

                Key::create([
                    'key' => $key,
                    'user_id' => $user->id,
                    'order_id' => $order->id,
                    'product_id' => $product_id,
                    'created_at' => now(),
                    'expire_at' => $expireDate
                ]);
            }

            // Optionally, create CouponUsages if coupon applied during trial
            if ($coupon_code != '' && $discountvalue != '') {
                CouponUsages::create([
                    'coupon_id' => $coupon_code,
                    'user_id' => $user->id,
                    'order_id' => $order->id,
                    'discount_value' => $discountvalue,
                ]);
            }

            // You can also generate invoice or other post-order logic here
            $this->generateInvoice(
                $user,
                $stripe_payment_id,
                $order->id,
                0,  
                0,  
                0,  
                '', 
                0,  
                $stripe_payment_status,
                $product_id,
                $quantity,
            );
            if (auth()->check()) {
                return redirect()->route('user-dashboard')->with('success', 'Subscription created with trial period!');
            }
            else{
                return redirect()->route('user-login')->with('success', 'Subscription confirmed and active!');
            }
        }

        // If trial period is set, redirect to the success page without confirming the payment
        // return redirect()->route('user-dashboard')->with('success', 'Subscription created with trial period!');        

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

        if (auth()->check()) {
            $user = auth()->user();
        } 
        if (!auth()->check() && $request->user_id) {
            auth()->loginUsingId($request->user_id);
        }

        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $product_id = $_GET['product_id'];
        $amount = $_GET['amount'];
        $currency = $_GET['currency'];
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
                'transaction_id' => $stripe_payment_id,
                'currency' => $currency
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
            //     $order = Order::create([
            //         'product_id'=> $product_id,
            //         'user_id' => $user['id'],
            //         'payment_status' => $stripe_payment_status,
            //         'payment_amount' => $amount,
            //         'razorpay_payment_id' => $stripe_payment_id,
            //         'payment_method' => $stripe_payment_method,
            //         'transaction_id' => $transaction_id,
            //         'currency' => $currency
            //     ]);

            //     if($coupon_code != '' && $discountvalue != ''){
            //         $usage = CouponUsages::create([
            //             'coupon_id'=>$coupon_code,
            //             'user_id'=>$user['id'],
            //             'order_id'=>$order->id,
            //             'discount_value'=>$discountvalue,
            //         ]);
            //     }


            //     $total_order = intval($amount/$per_order_amount);

            //     $wallet = Wallet::create([
            //         'user_id' => $user['id'],
            //         'product_id' => $product_id,
            //         'wallet_amount' => $amount,
            //         'total_order' => $total_order,
            //         'remaining_order' => $total_order,
            //     ]);
            //     $order_id = $order->id;
            //     // add data to wallet
            //     $keyIds = [];
            //     for ($i = 0; $i < $quantity; $i++) {
            //         // Key generation and add data to the key table.
            //         $key = Str::random(50);
            //         $currentDateTime = Carbon::now();
            //         $oneYearLater = $currentDateTime->addYear();
                
            //         $keytbl = Key::create([
            //             'key' => $key,
            //             'user_id' => $user['id'],
            //             'order_id' => $order_id,
            //             'product_id' => $product_id,
            //             'created_at' => Carbon::now(),
            //             'expire_at' => $oneYearLater
            //         ]);
            //         $keyIds[] = $keytbl->id;
            //     }
            //     $keyIdsString = implode(',', $keyIds);
            //     // dd(2,$order , $keytbl);
            // // }

            // $wallet_mail = Wallet::where('user_id', $user['id'])->first();
            // $order_mail = Order::where('user_id', $user['id'])->first();

            // $mailData = [
            //     'title' => 'Thank You for Topping Up and Placing Your Order!',
            //     'name' => $user['name'],
            //     'order_id' => $order_mail->id,
            //     'total_order' => $wallet_mail->total_order,
            //     'remaining_order' => $wallet_mail->remaining_order,
            //     'wallet_amount' => $wallet_mail->wallet_amount,
            // ];
            // if ($plan_type === 'recurring') {
            //     $subscription_id = $_GET['subscription_id'] ?? null;
            //     if ($subscription_id) {
            //         Subscription::create([
            //             'user_id' => $user['id'],
            //             'subscription_id' => $subscription_id,
            //             'product_id' => $product_id,
            //             'status' => 'active',
            //             'key_id' => $keyIdsString
            //         ]);
            //     }
            // }

            // $today = now();
            // $invoicesRes = InvoiceModel::whereDate("created_at", $today->toDateString())->count();
            // $temp_inv_num = $invoicesRes + 1;
            // $formatted_temp_inv_num = str_pad($temp_inv_num, 2, "0", STR_PAD_LEFT);
            // $temp_date = date("d") . date("m") . date("y");
            // $invoiceNo ="INV" . $temp_date . $formatted_temp_inv_num;

            // $invoice = InvoiceModel::create([
            //     'orderid' => $order_id,
            //     'user_id' => $user['id'],
            //     'transaction_id' => $transaction_id,
            //     'invoice_number' => $invoiceNo,
            //     'subtotal' => $subtotal,
            //     'gst_percentage' => $gst_percentage,
            //     'discount_type' => 'percentage',
            //     'discount' => $discountvalue,
            //     'applied_coupon' => $coupon_code,
            //     'total' => $old_amount / 100,
            //     'payment_method' => "Stripe",
            //     'payment_status' => $stripe_payment_status,
            //     'product_id' => $product_id,
            //     'quantity' => $quantity
            // ]);
            // if($plan_type === 'recurring'){
            //     $subscription_rec = SubscriptionRec::create([
            //         'user_id' => $user['id'],
            //         'product_id' => $product_id,
            //         'order_id' => $order_id,
            //         'invoice_id' => $invoice->id,
            //         'key_id' => $keyIdsString,
            //         'status' => 'active',
            //     ]);
            // }
            // Mail::to($user['email'])->send(new SendThankyou($mailData));

            // $request->session()->forget('cart');
            // $request->session()->forget('product_id');
            // $request->session()->forget('amount');

            // session()->flash('success', 'Payment Successfull!');
            // if (auth()->check()) {
            // return redirect()->route('invoice-preview', ['id' => $invoice->id]);
            //  }
            // else{
            //     return redirect()->route('user-login')->with('success', 'Subscription confirmed and active!');
            // }
            $order_ids = [];
            $key_ids = [];

            for ($i = 0; $i < $quantity; $i++) {
                // 1. Create Order
                $order = Order::create([
                    'product_id' => $product_id,
                    'user_id' =>  $user['id'],
                    'payment_status' => $stripe_payment_status,
                    'payment_amount' => $amount / $quantity,
                    'razorpay_payment_id' => $stripe_payment_id,
                    'payment_method' => $stripe_payment_method,
                    'transaction_id' => $transaction_id,
                    'currency' => $currency
                ]);
                $order_ids[] = $order->id;

                // 2. Create Key
                $key = Str::random(50);
                $expireDate = now()->addYear();
                $keytbl = Key::create([
                    'key' => $key,
                    'user_id' =>  $user['id'],
                    'order_id' => $order->id,
                    'product_id' => $product_id,
                    'created_at' => now(),
                    'expire_at' => $expireDate
                ]);
                $key_ids[] = $keytbl->id;

                // 3. Subscription per order (if recurring)
                if ($plan_type === 'recurring') {
                    $subscription_id = $_GET['subscription_id'] ?? null;
                    if ($subscription_id) {
                        Subscription::create([
                            'user_id' => $user['id'],
                            'subscription_id' => $subscription_id,
                            'product_id' => $product_id,
                            'status' => 'active',
                            'key_id' => $keytbl->id,
                            'order_id' => $order->id
                        ]);
                    }
                }

                // 4. Coupon usage
                if ($coupon_code && $discountvalue) {
                    CouponUsages::create([
                        'coupon_id' => $coupon_code,
                        'user_id' =>  $user['id'],
                        'order_id' => $order->id,
                        'discount_value' => $discountvalue,
                    ]);
                }
            }

            // ✅ 5. Create ONE Invoice AFTER the loop
            $invoiceNo = 'INV' . now()->format('dmy') . str_pad(1, 2, '0', STR_PAD_LEFT);
            $invoice = InvoiceModel::create([
                'orderid' => implode(',', $order_ids),
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

            // ✅ 6. Create SubscriptionRec only once (optional - based on how you use it)
            if ($plan_type === 'recurring') {
                foreach ($order_ids as $idx => $order_id) {
                    SubscriptionRec::create([
                        'user_id' => $user['id'],
                        'product_id' => $product_id,
                        'order_id' => $order_id,
                        'invoice_id' => $invoice->id,
                        'key_id' => $key_ids[$idx],
                        'status' => 'active',
                    ]);
                }
            }
            // Create or update wallet for total amount and quantity
            $wallet = Wallet::updateOrCreate(
                ['user_id' => $user['id'], 'product_id' => $product_id],
                [
                    'wallet_amount' => $amount,
                    'total_order' => $quantity,
                    'remaining_order' => $quantity,
                ]
            );

            // Clear cart session, etc.
            $request->session()->forget('cart');
            $request->session()->forget('product_id');
            $request->session()->forget('amount');

            session()->flash('success', 'Payment successful and subscriptions/orders created!');

            return redirect()->route('user-dashboard');
        }
        elseif($stripe_payment_status === 'requires_payment_method'){

            $tran = Transaction::create([
                'user_id' => $user['id'],
                'product_id' => $product_id,
                'payment_status' => $stripe_payment_status,
                'payment_amount' => $old_amount,
                'razorpay_payment_id' => $stripe_payment_id,
                'payment_method' => $stripe_payment_method,
                'transaction_id' => $stripe_payment_id,
                'currency' => $currency
            ]);

            session()->flash('success', 'Payment Failed');
            if (auth()->check()) {
            return redirect()->route('user-dashboard');
             }
            else{
                return redirect()->route('user-login')->with('success', 'Subscription confirmed and active!');
            }

        }
        elseif($stripe_payment_status === 'failed'){

            $tran = Transaction::create([
                'user_id' => $user['id'],
                'product_id' => $product_id,
                'payment_status' => $stripe_payment_status,
                'payment_amount' => $old_amount,
                'razorpay_payment_id' => $stripe_payment_id,
                'payment_method' => $stripe_payment_method,
                'transaction_id' => $stripe_payment_id,
                'currency' => $currency
            ]);

            session()->flash('success', 'Payment Failed');
            if (auth()->check()) {
            return redirect()->route('user-dashboard');
             }
            else{
                return redirect()->route('user-login')->with('success', 'Subscription confirmed and active!');
            }
        }
        else{

            $tran = Transaction::create([
                'user_id' => $user['id'],
                'product_id' => $product_id,
                'payment_status' => $stripe_payment_status,
                'payment_amount' => $old_amount,
                'razorpay_payment_id' => $stripe_payment_id,
                'payment_method' => $stripe_payment_method,
                'transaction_id' => $stripe_payment_id,
                'currency' => $currency
            ]);

            session()->flash('success', 'Payment Failed');
            if (auth()->check()) {
            return redirect()->route('user-dashboard');
            }
            else{
                return redirect()->route('user-login')->with('success', 'Subscription confirmed and active!');
            }
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
    // public function handleWebhook(Request $request)
    // {
    //     \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

    //     $payload = $request->all();
    //     $eventType = $payload['type'] ?? '';
    
    //     if ($eventType === 'invoice.payment_succeeded') {
    //         $invoice = $payload['data']['object'];
    //         $subscription_id = $invoice['subscription'] ?? null;
    
    //         if (!$subscription_id) {
    //             \Log::warning('Stripe Webhook: Subscription ID missing in invoice');
    //             return response()->json(['status' => 'no_subscription'], 400);
    //         }
    
    //         $user = Subscription::where('subscription_id', $subscription_id)->first();

    //         if ($user) {
    //             $lines = $invoice['lines']['data'][0] ?? [];
    //             $metadata = $lines['metadata'] ?? [];
                
    //             $product_id = $metadata['product_id'] ?? null;
    //             $plan_name = $metadata['plan_name'] ?? null;
    //             $quantity = $metadata['quantity'] ?? 1;
    //             $currency = $metadata['currency'] ?? 'INR';
            
    //             $stripe_payment_id = $invoice['payment_intent'] ?? null;
    //             $stripe_payment_method = $invoice['payment_settings']['payment_method_options']['card']['brand'] ?? 'stripe';
    //             $stripe_payment_status = $invoice['status'];
    //             $amount_paid = $invoice['total'] / 100;
            
    //             // ✅ Save transaction
    //             if(!empty($product_id)){
    //             $tran = Transaction::create([
    //                 'user_id' => $user->user_id,
    //                 'product_id' => $product_id,
    //                 'payment_status' => $stripe_payment_status,
    //                 'payment_amount' => $amount_paid,
    //                 'razorpay_payment_id' => $stripe_payment_id,
    //                 'payment_method' => $stripe_payment_method,
    //                 'transaction_id' => $stripe_payment_id,
    //                 'currency' => $currency
    //             ]);
            
    //             // ✅ Create Order
    //             $order = Order::create([
    //                 'product_id'=> $product_id,
    //                 'user_id' => $user['id'],
    //                 'payment_status' => $stripe_payment_status,
    //                 'payment_amount' => $amount_paid,
    //                 'razorpay_payment_id' => $stripe_payment_id,
    //                 'payment_method' => $stripe_payment_method,
    //                 'transaction_id' => $tran->id,
    //                 'currency' => $currency
    //             ]);
    //             }
            
    //             // ✅ Optional: Generate Invoice
    //             $this->generateInvoice(
    //                 $user,
    //                 $invoice['id'],
    //                 $order->id,
    //                 $invoice['subtotal'] / 100,
    //                 18,
    //                 $invoice['discounts'][0]['coupon']['percent_off'] ?? 0,
    //                 $invoice['discounts'][0]['coupon']['id'] ?? '',
    //                 $amount_paid,
    //                 $stripe_payment_status
    //             );
    //         }else {
    //             \Log::warning("Stripe Webhook: No user found for subscription ID $subscription_id");
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

            // Find the user/subscription record
            $subscription = Subscription::where('subscription_id', $subscription_id)->first();

            if ($subscription) {
                $user = $subscription->user;

                $lines = $invoice['lines']['data'][0] ?? [];
                $metadata = $lines['metadata'] ?? [];

                $product_id = $metadata['product_id'] ?? null;
                $plan_name = $metadata['plan_name'] ?? null;
                $quantity = $metadata['quantity'] ?? 1;
                $currency = $metadata['currency'] ?? 'INR';

                $stripe_payment_id = $invoice['payment_intent'] ?? null;
                $stripe_payment_method = $invoice['payment_settings']['payment_method_options']['card']['brand'] ?? 'stripe';
                $stripe_payment_status = $invoice['status'];
                $amount_paid = $invoice['total'] / 100;

                // ✅ FIND existing trial transaction & order
                $trialTransaction = Transaction::where('user_id', $user->id)
                    ->where('product_id', $product_id)
                    ->where('payment_status', 'trialing')
                    ->first();

                $trialOrder = Order::where('user_id', $user->id)
                    ->where('product_id', $product_id)
                    ->where('payment_status', 'trialing')
                    ->first();

                if ($trialTransaction && $trialOrder) {
                    $trialTransaction->update([
                        'payment_status' => $stripe_payment_status,
                        'payment_amount' => $amount_paid,
                        'razorpay_payment_id' => $stripe_payment_id,
                        'payment_method' => $stripe_payment_method,
                        'transaction_id' => $stripe_payment_id,
                        'currency' => $currency,
                    ]);

                    $trialOrder->update([
                        'payment_status' => $stripe_payment_status,
                        'payment_amount' => $amount_paid,
                        'razorpay_payment_id' => $stripe_payment_id,
                        'payment_method' => $stripe_payment_method,
                        'currency' => $currency,
                    ]);

                    // ✅ OPTIONAL: Generate Invoice
                    $this->generateInvoice(
                        $user,
                        $invoice['id'],
                        $trialOrder->id,
                        $invoice['subtotal'] / 100,
                        18,
                        $invoice['discounts'][0]['coupon']['percent_off'] ?? 0,
                        $invoice['discounts'][0]['coupon']['id'] ?? '',
                        $amount_paid,
                        $stripe_payment_status,
                        $product_id,
                        $quantity
                    );
                } else {
                    $tran = Transaction::create([
                        'user_id' => $user->id,
                        'product_id' => $product_id,
                        'payment_status' => $stripe_payment_status,
                        'payment_amount' => $amount_paid,
                        'razorpay_payment_id' => $stripe_payment_id,
                        'payment_method' => $stripe_payment_method,
                        'transaction_id' => $stripe_payment_id,
                        'currency' => $currency
                    ]);

                    $order = Order::create([
                        'product_id'=> $product_id,
                        'user_id' => $user->id,
                        'payment_status' => $stripe_payment_status,
                        'payment_amount' => $amount_paid,
                        'razorpay_payment_id' => $stripe_payment_id,
                        'payment_method' => $stripe_payment_method,
                        'transaction_id' => $tran->id,
                        'currency' => $currency
                    ]);

                    // Optional invoice
                    $this->generateInvoice(
                        $user,
                        $invoice['id'],
                        $order->id,
                        $invoice['subtotal'] / 100,
                        18,
                        $invoice['discounts'][0]['coupon']['percent_off'] ?? 0,
                        $invoice['discounts'][0]['coupon']['id'] ?? '',
                        $amount_paid,
                        $stripe_payment_status,
                        $product_id,
                        $quantity
                    );
                }
            } else {
                \Log::warning("Stripe Webhook: No subscription record found for ID $subscription_id");
            }
        }

        return response()->json(['status' => 'success']);
    }

    private function generateInvoice($user, $transaction_id, $order_id, $subtotal, $gst_percentage, $discountvalue, $coupon_code, $total_amount, $status, $product_id = null, $quantity = null)
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
            'product_id' => $product_id,
            'quantity' => $quantity,
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
            // dd($e->getMessage());
            return redirect()->back()->with('error', 'Error canceling subscription: ' . $e->getMessage());
        }
    }
    public function reactivateSubscription($id)
    {
        try {
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

            // Retrieve subscription record
            $subscription = SubscriptionRec::find($id);
            if (!$subscription || $subscription->status !== 'cancel') {
                return redirect()->back()->with('error', 'Subscription not found or already active.');
            }

            // Find Stripe subscription
            $stripeSubscription = Subscription::where('key_id', $subscription->key_id)->first();
            if (!$stripeSubscription) {
                return redirect()->back()->with('error', 'Stripe subscription record not found.');
            }

            // Retrieve Stripe subscription details
            $subscriptionStripe = \Stripe\Subscription::retrieve($stripeSubscription->subscription_id);
            if (empty($subscriptionStripe) || !isset($subscriptionStripe->id)) {
                return redirect()->back()->with('error', 'Invalid Stripe subscription ID.');
            }

            if ($subscriptionStripe->status === 'canceled') {
                // Get customer ID from the canceled subscription
                $customerId = $subscriptionStripe->customer;

                // Fetch customer's payment methods
                $paymentMethods = \Stripe\PaymentMethod::all([
                    'customer' => $customerId,
                    'type' => 'card',
                ]);

                if (count($paymentMethods->data) === 0) {
                    throw new \Exception('Customer has no attached payment methods. Please add a payment method first.');
                }

                // Use the first available payment method
                $defaultPaymentMethodId = $paymentMethods->data[0]->id;

                // Create a new subscription with default payment method
                $newSubscription = Subscription::create([
                    'customer' => $customerId,
                    'items' => [
                        ['price' => $subscriptionStripe->items->data[0]->price->id]
                    ],
                    'default_payment_method' => $defaultPaymentMethodId,
                ]);

                // Update the database with new subscription details
                $stripeSubscription->update([
                    'subscription_id' => $newSubscription->id,
                    'status' => 'active'
                ]);
            } else {
                // Reactivate an active subscription scheduled for cancellation
                \Stripe\Subscription::update($subscriptionStripe->id, [
                    'cancel_at_period_end' => false
                ]);
                $stripeSubscription->update(['status' => 'active']);
            }

            // Update local database records
            $subscription->update(['status' => 'active']);
            $userSubscription = Subscription::where('key_id', $subscription->key_id)->first();
            if ($userSubscription) {
                $userSubscription->update(['status' => 'active']);
            }

            // Restore key expiration date and system state
            $key_id = $subscription->key_id;
            if ($key_id) {
                $key = Key::find($key_id);
                if ($key) {
                    $key->update([
                        'expire_at' => now()->addDays(30),
                        'sys_state' => '0',
                    ]);
                }
            }

            return redirect()->back()->with('success', 'Subscription reactivated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error reactivating subscription: ' . $e->getMessage());
        }
    }


}
