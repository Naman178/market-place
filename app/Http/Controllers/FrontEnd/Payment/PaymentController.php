<?php

namespace App\Http\Controllers\FrontEnd\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Stripe\Stripe;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\PaymentIntent;
use Stripe\StripeClient;
use App\Models\Order;
use App\Models\Transaction;
class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->ajax()){
            $user = User::find($request->user_id);
            $product_id = $request->product_id;
            $amount = $request->amount;
            $user_id = $user->id;
            if($user){
                $user->update([
                    "name" => $request->name,
                    "email" => $request->email,
                    "country_code" => $request->country_code,
                    "contact_number" => $request->contact,
                    "country_code" => $request->country_code,
                    "company_website" => $request->company_website,
                    "company_name" => $request->company_name,
                    "country" => $request->country,
                    "address_line1" => $request->address_line_one,
                    "address_line2" => $request->address_line_two,
                    "city" => $request->city,
                    "postal_code" => $request->postal
                ]);
            }

            // Set your secret key
            Stripe::setApiKey(env('STRIPE_SECRET'));
            $token = $request->stripeToken;

            $existingCustomer = Customer::all(['email' => $user->email]);

            if(count($existingCustomer->data) > 0){
                $customer_id = $existingCustomer->data[0]->id;
            }
            else{
                $customer = Customer::create([
                    'name' => $user->name,
                    'email' => $user->email,
                ]);
                $customer_id = $customer->id;
            }
            try {
                $paymentIntent = PaymentIntent::create([
                    'amount' => $request->amount,
                    'currency' => 'INR',
                    'description' => 'Test Payment',
                    'customer' => $customer_id,
                    'payment_method_data' => [
                        'type' => 'card',
                        'card' => [
                            'token' => $token,
                        ],
                    ],
                    'confirmation_method' => 'automatic',
                    'confirm' => true,
                    'return_url' => route("payment-status", compact("product_id", "amount", "user_id")),
                ]);

                // $order = Order::create([
                //     "user_id" => $user_id,
                //     "plan_id" => $plan_id,
                //     "order_number" => 'MP_' . "U$user_id" . "P$plan_id". "_" .date('YmdHis')
                // ]);

                // $transaction = Transaction::create([
                //     "user_id" => $user_id,
                //     "order_id" => $order->id,
                //     "amount" => ($amount) / 100,
                //     "status" => true,
                // ]);

                return response()->json([
                    "success" => true,
                    "data" => $paymentIntent
                ]);
            } catch (\Exception $e) {
                // Payment failed
                return response()->json([
                    "error" => $e->getMessage(),
                ]);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function paymentStatus(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $paymentIntentId = $_GET['payment_intent'];
        // $user = User::find($request->user_id);
        $stripe_payment = \Stripe\PaymentIntent::retrieve($paymentIntentId);
        $stripe_payment_id = $stripe_payment->id;
        $stripe_payment_method = $stripe_payment['payment_method'];
        $stripe_payment_status = $stripe_payment->status;

        $user_id = $request->user_id;
        $product_id = $request->product_id;
        $amount = $request->amount;

        if($stripe_payment_status == "succeeded"){
            $order = Order::create([
                "user_id" => $user_id,
                "product_id" => $product_id,
                "order_number" => 'MP_' . "U$user_id" . "P$product_id". "_" .date('YmdHis')
            ]);

            $transaction = Transaction::create([
                "user_id" => $user_id,
                "order_id" => $order->id,
                "amount" => ($amount) / 100,
                "status" => true,
            ]);
        }else{
            $transaction = Transaction::create([
                "user_id" => $user_id,
                "order_id" => $order->id,
                "amount" => ($amount) / 100,
                "status" => false,
            ]);
        }

       return view("front-end.checkout.payment-status");
    }
}
