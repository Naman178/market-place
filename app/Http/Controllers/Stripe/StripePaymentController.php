<?php

namespace App\Http\Controllers\Stripe;

use App\Http\Controllers\Controller;
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

class StripePaymentController extends Controller
{
    public function stripePost(Request $request)
    {        
        $input = $request->all();
        $product_id = $input['product_id'];
        $amount = 0;
        $discount = $input['is_discount_applied'];
        $amount = $input['amount'];

        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $user = auth()->user();
        $isocode = ContactsCountryEnum::where('name',$user['country'])->pluck('ISOname')->first();
        $existingCustomer = Customer::all([
            'email' => $user['email'],
            'limit' => 1,
        ]);

        if ($existingCustomer->count() > 0) {
            $customer_id = $existingCustomer->data[0]->id;
        } else {
            $customer = Customer::create([
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
        
        $currency = $input['currency'];
        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => $amount * 100,
            'currency' => $currency,
            'customer' => $customer_id,
            'payment_method_types' => ['card'],
            'description' => 'Payment For the Skyfinity Quick Checkout Wallet',
        ]);
        
        $paymentMethod = \Stripe\PaymentMethod::create([
            'type' => 'card',
            'card' => [
                'token' => $request->stripeToken,
            ],
        ]);

        $stripe_payment = $paymentIntent->confirm([
            'payment_method' => $paymentMethod->id,
            'return_url' => route('stripe-payment-3d',['product_id' => $product_id, 'amount' => $amount, 'discount' => $discount]),
        ]);

        // if ($paymentIntent->status === 'requires_action') {
        //     $authenticationUrl = $paymentIntent->next_action->redirect_to_url->url;
            
        //     echo "<script>window.open('$authenticationUrl');</script>";
        //     exit;
        // }     
        if ($paymentIntent->status === 'requires_action') {
            $authenticationUrl = $paymentIntent->next_action->redirect_to_url->url;

            echo "<script>window.location.href = '$authenticationUrl';</script>";
            exit;
        }
    }
    public function stripeAfterPayment(Request $request){
        
        $user = auth()->user();
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $product_id = $_GET['product_id'];
        $amount = $_GET['amount'];
        $old_amount = $amount;
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

            $existingOrder = Order::where('user_id', $user['id'])->first();
            if ($existingOrder) {
                $order_id = $existingOrder->id;

                $wallet = Wallet::where('user_id', $user['id'])->first();
                $update_order = Order::where('id', $order_id)->first();

                $wallet_amount = $wallet->wallet_amount;
                $total_order = $wallet->total_order;
                $remaining_order = $wallet->remaining_order;

                $new_total_order = intval($amount/$per_order_amount);

                $update_wallet_amount = $amount + $wallet_amount;
                $update_total_order = $total_order + $new_total_order;
                $update_remaining_order = $remaining_order + $new_total_order;

                $wallet->update([
                    'product_id' => $product_id,
                    'wallet_amount' => $update_wallet_amount,
                    'total_order' => $update_total_order,
                    'remaining_order' => $update_remaining_order,
                ]);

                $update_order->update([
                    'product_id'=> $product_id,
                ]);

            }
            else{
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

                // key generation and add data to the key table.
                $key = Str::random(50);
                $currentDateTime = Carbon::now();
                $oneYearLater = $currentDateTime->addYear();

                $keytbl =  Key::create([
                    'key'=> $key,
                    'user_id' => $user['id'],
                    'order_id' => $order_id,    
                    'product_id' => $product_id,
                    'creared_at' => Carbon::now(),
                    'expire_at' => $oneYearLater
                ]);
            }

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

            Mail::to($user['email'])->send(new SendThankyou($mailData));

            $request->session()->forget('cart');
            $request->session()->forget('product_id');
            $request->session()->forget('amount');

            session()->flash('success', 'Payment Successfull!');
            return redirect()->route('thankyou')->with([
                'order_id' => $order_id,
            ]);
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
}
