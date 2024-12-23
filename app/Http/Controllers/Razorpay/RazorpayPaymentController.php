<?php

namespace App\Http\Controllers\Razorpay;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Session;
use Exception;
use GeoIp2\Database\Reader;
use App\Models\Transaction;
use App\Models\Order;
use App\Models\Items;
use App\Models\Wallet;
use App\Models\Key;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Mail\SendThankyou;
use Illuminate\Support\Facades\Mail;

class RazorpayPaymentController extends Controller
{
    public function store(Request $request)
    {
        $input = $request->all();
        $product_id = $input['product_id'];
        
        $plan =Items::where('id',$product_id)->first();
        $per_order_amount = $plan->monthly_price;

        $razorpay_payment_id = $input['razorpay_payment_id'];
        $user = auth()->user();
        
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        
        $payment = $api->payment->fetch($input['razorpay_payment_id']);
        if(count($input)  && !empty($input['razorpay_payment_id'])) {
            try {
                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount'=>$payment['amount']));
                
                $payment_status = $response['status'];
                $payment_amount = $response['amount'] / 100;
                $payment_method = $response['method'];
                $transaction_id = $response['acquirer_data']->toArray();
                
                // Add data to transaction tbale
                $tran = Transaction::create([
                    'user_id' => $user['id'],
                    'product_id' => $product_id,
                    'payment_status' => $payment_status,
                    'payment_amount' => $payment_amount,
                    'razorpay_payment_id' => $razorpay_payment_id,
                    'payment_method' => $payment_method,
                    'transaction_id' => $transaction_id
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

                    $new_total_order = intval($payment_amount/$per_order_amount);

                    $update_wallet_amount = $payment_amount + $wallet_amount;
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
                        'payment_status' => $payment_status,
                        'payment_amount' => $payment_amount,
                        'razorpay_payment_id' => $razorpay_payment_id,
                        'payment_method' => $payment_method,
                        'transaction_id' => $transaction_id
                    ]);
                    
                    $order_id = $order->id;

                    $total_order = intval($payment_amount/$per_order_amount);

                    $wallet = Wallet::create([
                        'user_id' => $user['id'],
                        'product_id' => $product_id,
                        'wallet_amount' => $payment_amount,
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

            } catch (Exception $e) {
                return  $e->getMessage();
                session()->flash('error', $e->getMessage());
                return redirect()->back();
            }
        }
        $request->session()->forget('cart');
        session()->flash('success', 'Payment Successfull!');        
        return redirect()->route('thankyou')->with( [
            'order_id' => $order_id,
        ]);
        
    }
    public function freePlanSave(Request $request){
        $input = $request->all();
        $user = auth()->user();

        $product_id = $input['product_id'];
        
        $plan =Items::where('id',$product_id)->first();
        $per_order_amount = $plan->monthly_price;
        
        $existingOrder = Order::where('user_id', $user['id'])->first();
        if($existingOrder){
            return response()->json([
                'error' => 'Since you already have an existing plan, please select a different plan. The free plan is not available for selection.',
                'title' => 'Alredy Have Plan',
                'type' => 'Failure'                
            ]);
        }
        if (!$existingOrder) {
            // add data to order id
            $order = Order::create([
                'product_id'=> $product_id,
                'user_id' => $user['id'],
                'payment_status' => '',
                'payment_amount' => '0',
                'razorpay_payment_id' => '',
                'payment_method' => '',
                'transaction_id' => ''
            ]);
            
            $order_id = $order->id;
            $payment_amount = 350;
            $total_order = intval($payment_amount/$per_order_amount);

            $wallet = Wallet::create([
                'user_id' => $user['id'],
                'product_id' => $product_id,
                'wallet_amount' => $payment_amount,
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
        if($request->ajax()){
            return response()->json([
                'success' => 'free plan plan acttivated succcessfully.',
                'title' => 'Free Plan Activatd',
                'type' => 'Success',
                'order_id' => $order_id,
            ]);
        }
        else{            
            session()->flash('success', 'Payment Successfull!');        
            return redirect()->route('thankyou')->with([
                'order_id' => $order_id,
            ]);
        }
    }
}
