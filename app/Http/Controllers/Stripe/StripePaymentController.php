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
use Stripe\Exception\CardException;
use Stripe\Exception\ApiErrorException;
use Stripe\Exception\InvalidRequestException;

class StripePaymentController extends Controller
{
    // public function stripePost(Request $request)
    // {
    //     try {
    //     // dd($request->all());
    //     $input = $request->all();
    //     $product_id = $input['product_id'];
    //     $amount = $input['amount'];
    //     $plan_name = $input['plan_name'];
    //     $discount = $input['is_discount_applied'];
    //     $subtotal = $input['subtotal'];
    //     $gst = $input['gst'];
    //     $discountvalue = $input['discount_value'] ?? '';
    //     $coupon_code = $input['final_coupon_code'] ?? '';
    //     $plan_type = $input['plan_type'] ?? 'one_time';
    //     $currency = $input['currency'];
    //     $quantity = $input['final_quantity'];
    //     $trial_period_days = $input['trial_period_days'] ?? 0;
    //     $input_interval = strtolower($input['billing_cycle'] ?? 'month');

    //     switch ($input_interval) {
    //         case 'monthly':
    //             $plan_interval = 'month';
    //             break;
    //         case 'yearly':
    //             $plan_interval = 'year';
    //             break;
    //         case 'weekly':
    //             $plan_interval = 'week';
    //             break;
    //         case 'quarterly':
    //             $plan_interval = 'month';
    //             break;
    //         default:
    //             $plan_interval = 'month';
    //     }

    //     \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

    //     if (auth()->check()) {
    //         $user = auth()->user();
    //     } else {
    //         $user = User::latest()->first();
    //     }

    //     $isocode = ContactsCountryEnum::where('name', $user['country'])->pluck('ISOname')->first();

    //     $existingCustomer = \Stripe\Customer::all([
    //         'email' => $user['email'],
    //         'limit' => 1,
    //     ]);

    //     // if ($existingCustomer->count() > 0) {
    //     //     $customer_id = $existingCustomer->data[0]->id;
    //     //     $existingSubscriptions = \Stripe\Subscription::all([
    //     //         'customer' => $customer_id,
    //     //         'limit' => 1,
    //     //         'status' => 'active',
    //     //     ]);
    //     // //     if($trial_period_days <= 0){
    //     // //     // If an active subscription exists, delete it
    //     // //     if (!empty($existingSubscriptions->data)) {
    //     // //         $subscription_id = $existingSubscriptions->data[0]->id;
    //     // //         \Stripe\Subscription::retrieve($subscription_id)->cancel(); 
    //     // //     }
    //     // //     \Stripe\Customer::retrieve($customer_id)->delete();
    //     // // }
    //     // } 
    //     //     sleep(2);

    //     //     // Create a new customer
    //     //     $newCustomer = \Stripe\Customer::create([
    //     //         'name' => $user['name'],
    //     //         'email' => $user['email'],
    //     //         'address' => [
    //     //             'line1' => $user['address_line_1'] ?? $user['address_line1'],
    //     //             'line2' => $user['address_line_2'] ?? $user['address_line2'],
    //     //             'city' => $user['city'],
    //     //             'postal_code' => $user['zip'],
    //     //             'country' => $isocode,
    //     //         ],
    //     //     ]);
    //     //     $customer_id = $newCustomer->id;
    //     if ($existingCustomer->count() > 0) {
    //         // Use the existing Stripe customer
    //         $customer_id = $existingCustomer->data[0]->id;

    //         // Optional: check and cancel existing subscriptions
    //         $existingSubscriptions = \Stripe\Subscription::all([
    //             'customer' => $customer_id,
    //             'limit' => 1,
    //             'status' => 'active',
    //         ]);

    //         // You can delete subscription/customer if needed here based on trial logic
    //     } else {
    //         // Create a new customer only if one doesn't exist
    //         $newCustomer = \Stripe\Customer::create([
    //             'name' => $user['name'],
    //             'email' => $user['email'],
    //             'address' => [
    //                 'line1' => $user['address_line_1'] ?? $user['address_line1'] ?? '',
    //                 'line2' => $user['address_line_2'] ?? $user['address_line2'] ?? '',
    //                 'city' => $user['city'] ?? '',
    //                 'postal_code' => $user['zip'] ?? '',
    //                 'country' => $isocode ?? 'US',
    //             ],
    //         ]);
    //         $customer_id = $newCustomer->id;
    //     }

    //     // if ($plan_type === 'recurring') {
    //     //     // **Step 1: Create a Product (if not exists)**
    //     //     $product = \Stripe\Product::create([
    //     //         'name' => $plan_name,
    //     //         'type' => 'service',
    //     //     ]);

    //     //     // **Step 2: Create a Price for the Subscription**
    //     //     $price = \Stripe\Price::create([
    //     //         'unit_amount' => $amount,
    //     //         'currency' => $currency,
    //     //         'recurring' => ['interval' => $plan_interval],
    //     //         'product' => $product->id,
    //     //     ]);

    //     //     // **Step 3: Create Subscription**
    //     //     $subscription = \Stripe\Subscription::create([
    //     //         'customer' => $customer_id,
    //     //         'items' => [['price' => $price->id]],
    //     //         'payment_behavior' => 'default_incomplete',
    //     //         'metadata' => [
    //     //             'product_id' => $product_id,
    //     //             'user_id' => $user['id'],
    //     //             'plan_name' => $plan_name,
    //     //             'quantity' => $quantity,
    //     //             'order_id' => $product_id,
    //     //             'currency' => $currency,
    //     //         ],
    //     //         'trial_period_days' => $trial_period_days,
    //     //         'expand' => ['latest_invoice.payment_intent'],
    //     //     ]);

    //     //     $paymentIntent = $subscription->latest_invoice->payment_intent;

    //     // } 
    //     if ($plan_type === 'recurring') {
    //         for ($i = 0; $i < $quantity; $i++) {
    //             // Step 1: Create a Product (if not exists)
    //             $product = \Stripe\Product::create([
    //                 'name' => $plan_name,
    //                 'type' => 'service',
    //             ]);

    //             // Step 2: Create a Price for the Subscription
    //             $price = \Stripe\Price::create([
    //                 'unit_amount' => $amount,
    //                 'currency' => $currency,
    //                 'recurring' => ['interval' => $plan_interval],
    //                 'product' => $product->id,
    //             ]);

    //             // Step 3: Create Subscription
    //             $subscription = \Stripe\Subscription::create([
    //                 'customer' => $customer_id,
    //                 'items' => [['price' => $price->id]],
    //                 'payment_behavior' => $trial_period_days > 0 ? 'allow_incomplete' : 'default_incomplete',
    //                 'metadata' => [
    //                     'product_id' => $product_id,
    //                     'user_id' => $user['id'],
    //                     'plan_name' => $plan_name,
    //                     'quantity' => $quantity,
    //                     'order_id' => $product_id,
    //                     'currency' => $currency,
    //                 ],
    //                 'trial_period_days' => $trial_period_days,
    //                 'expand' => ['latest_invoice.payment_intent'],
    //             ]);

    //             $paymentIntent = $subscription->latest_invoice->payment_intent;
    //         }
    //     }
    //     else {
    //         // **One-time payment**
    //         $paymentIntent = \Stripe\PaymentIntent::create([
    //             'amount' => $amount,
    //             'currency' => $currency,
    //             'customer' => $customer_id,
    //             'payment_method_types' => ['card'],
    //             'description' => 'Payment For the Market Place Checkout Wallet',
    //         ]);
    //     }
    //     if($request->stripeToken == null){
    //         return redirect()->back()->with('error', 'You have used a Stripe test card. Please use a valid card to proceed.');
    //     }
    //     else{
    //         $paymentMethod = \Stripe\PaymentMethod::create([
    //             'type' => 'card',
    //             'card' => [
    //                 'token' => $request->stripeToken,
    //             ],
    //         ]);
    //     }
    //     $return_url_params = [
    //         'product_id' => $product_id,
    //         'subtotal' => $subtotal,
    //         'gst' => $gst,
    //         'amount' => $amount,
    //         'discount' => $discount,
    //         'coupon_code' => $coupon_code,
    //         'discountvalue' => $discountvalue,
    //         'plan_type' => $plan_type,
    //         'quantity' => $quantity,
    //         'currency' => $currency,
    //     ];
    //     if ($plan_type === 'recurring') {
    //         $return_url_params['subscription_id'] = $subscription->id;
    //     }
        
    //     if (auth()->check()) {
    //     if (!$trial_period_days > 0 && $paymentIntent) {
    //             // Confirm payment if no trial period
    //             $stripe_payment = $paymentIntent->confirm([
    //                 'payment_method' => $paymentMethod->id ?? null,
    //                 'return_url' => route('stripe-payment-3d', $return_url_params),
    //             ]);
    //         if ($stripe_payment->status === 'requires_action') {
    //             $authenticationUrl = $paymentIntent->next_action->redirect_to_url->url;

    //             echo "<script>window.location.href = '$authenticationUrl';</script>";
    //             exit;
    //         }
    //       }
    //       }
    //     else{
    //         if (!$trial_period_days > 0 && $paymentIntent) {
    //             $stripePayment = $paymentIntent->confirm([
    //                 'payment_method' => $paymentMethod,
    //                 'return_url' => route('stripe-payment-3d', ['user_id' => $user->id] + $return_url_params),
    //             ]);

    //             if ($stripePayment->status === 'requires_action') {
    //                 return response()->json([
    //                     'success' => true,
    //                     'requires_action' => true,
    //                     'redirect_url' => [
    //                         'url' => $paymentIntent->next_action->redirect_to_url->url
    //                     ]
    //                 ]);
    //             }
    //         }
    //     }
    //     if (!auth()->check() && $user->id) {
    //         auth()->loginUsingId($user->id);
    //     }
    //     if ($trial_period_days > 0) {
    //         // Create transaction with trial status
    //         $stripe_payment_id = 'trial_' . uniqid();
    //         $stripe_payment_method = 'trial';
    //         $stripe_payment_status = 'trialing';
    //         $amount_paid = 0;

    //         $tran = Transaction::create([
    //             'user_id' => $user->id,
    //             'product_id' => $product_id,
    //             'payment_status' => $stripe_payment_status,
    //             'payment_amount' => $amount_paid,
    //             'razorpay_payment_id' => $stripe_payment_id,
    //             'payment_method' => $stripe_payment_method,
    //             'transaction_id' => $stripe_payment_id,
    //             'currency' => $currency
    //         ]);

    //         // For each quantity, create a trial order + key
    //         for ($i = 0; $i < $quantity; $i++) {
    //             $order = Order::create([
    //                 'product_id' => $product_id,
    //                 'user_id' => $user->id,
    //                 'payment_status' => $stripe_payment_status,
    //                 'payment_amount' => $amount_paid,
    //                 'razorpay_payment_id' => $stripe_payment_id,
    //                 'payment_method' => $stripe_payment_method,
    //                 'transaction_id' => $tran->id,
    //                 'currency' => $currency
    //             ]);

    //             // Generate a license/key for each order
    //             $key = Str::random(50);
    //             $expireDate = now()->addDays($trial_period_days);

    //             Key::create([
    //                 'key' => $key,
    //                 'user_id' => $user->id,
    //                 'order_id' => $order->id,
    //                 'product_id' => $product_id,
    //                 'created_at' => now(),
    //                 'expire_at' => $expireDate
    //             ]);
    //         }

    //         // Optionally, create CouponUsages if coupon applied during trial
    //         if ($coupon_code != '' && $discountvalue != '') {
    //             CouponUsages::create([
    //                 'coupon_id' => $coupon_code,
    //                 'user_id' => $user->id,
    //                 'order_id' => $order->id,
    //                 'discount_value' => $discountvalue,
    //             ]);
    //         }

    //         // You can also generate invoice or other post-order logic here
    //         $this->generateInvoice(
    //             $user,
    //             $stripe_payment_id,
    //             $order->id,
    //             0,  
    //             0,  
    //             0,  
    //             '', 
    //             0,  
    //             $stripe_payment_status,
    //             $product_id,
    //             $quantity,
    //         );
    //         if (auth()->check()) {
    //             return redirect()->route('user-dashboard')->with('success', 'Subscription created with trial period!');
    //         }
    //         else{
    //             return redirect()->route('user-login')->with('success', 'Subscription confirmed and active!');
    //         }
    //     }
    //    }   catch (CardException $e) {
    //         // Stripe-specific card error
    //         $message = $e->getError()->message;

    //         // Check for the specific test card error
    //         if (str_contains(strtolower($message), 'test')) {
    //             return back()->with('error', 'You have used a Stripe test card. Please use a valid card to proceed.');
    //         }

    //         return back()->with('error', $message);

    //     } catch (InvalidRequestException $e) {
    //         // Example: test key used in live mode, or test card in live mode
    //         if (str_contains(strtolower($e->getMessage()), 'test')) {
    //             return back()->with('error', 'You have used a Stripe test card. Please use a valid card to proceed.');
    //         }

    //         return back()->with('error', $e->getMessage());

    //     } catch (\Exception $e) {
    //         // General error fallback
    //         return back()->with('error', 'An unexpected error occurred. Please try again.');
    //     }
    //     // If trial period is set, redirect to the success page without confirming the payment
    //     // return redirect()->route('user-dashboard')->with('success', 'Subscription created with trial period!');        

    //     // $stripe_payment = $paymentIntent->confirm([
    //     //     'payment_method' => $paymentMethod->id,
    //     //     'return_url' => route('stripe-payment-3d', $return_url_params),
    //     // ]);

    //     // if ($paymentIntent->status === 'requires_action') {
    //     //     $authenticationUrl = $paymentIntent->next_action->redirect_to_url->url;

    //     //     echo "<script>window.location.href = '$authenticationUrl';</script>";
    //     //     exit;
    //     // }
    // }

    public function stripePost(Request $request)
    {
        try {
            if (!$request->stripeToken) {
                return redirect()->back()->with('error', 'Stripe token is missing. Please try again.');
            }
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
            $billing_cycle = $input['billing_cycle'];
            $product_type = $input['product_type'];
            $quantity = $input['final_quantity'];
            $trial_period_days = $input['trial_period_days'] ?? 0;
            $input_interval = strtolower($input['billing_cycle'] ?? 'month');

            $plan_interval = match ($input_interval) {
                'monthly' => 'month',
                'yearly' => 'year',
                'weekly' => 'week',
                'quarterly' => 'month',
                default => 'month',
            };

            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

            $user = auth()->check() ? auth()->user() : User::latest()->first();
            $isocode = ContactsCountryEnum::where('name', $user['country'])->pluck('ISOname')->first();

            // Get or create Stripe customer
            $existingCustomer = \Stripe\Customer::all([
                'email' => $user['email'],
                'limit' => 1,
            ]);

            if ($existingCustomer->count() > 0) {
                $customer_id = $existingCustomer->data[0]->id;
            } else {
                $newCustomer = \Stripe\Customer::create([
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'address' => [
                        'line1' => $user['address_line_1'] ?? $user['address_line1'] ?? '',
                        'line2' => $user['address_line_2'] ?? $user['address_line2'] ?? '',
                        'city' => $user['city'] ?? '',
                        'postal_code' => $user['zip'] ?? '',
                        'country' => $isocode ?? 'US',
                    ],
                ]);
                $customer_id = $newCustomer->id;
            }
          

            // Initialize return URL params
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
                'billing_cycle' => $billing_cycle,
                'product_type' => $product_type,
            ];

            // Handle recurring subscription
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
                        'payment_behavior' => $trial_period_days > 0 ? 'allow_incomplete' : 'default_incomplete',
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
                'billing_cycle' => $billing_cycle,
                'product_type' => $product_type,
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

            // Handle trial-based logic
            if ($trial_period_days > 0) {
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
                    'currency' => $currency,
                    'billing_cycle' => $billing_cycle,
                    'product_type' => $product_type,
                ]);

                for ($i = 0; $i < $quantity; $i++) {
                    $order = Order::create([
                        'product_id' => $product_id,
                        'user_id' => $user->id,
                        'payment_status' => $stripe_payment_status,
                        'payment_amount' => $amount_paid,
                        'razorpay_payment_id' => $stripe_payment_id,
                        'payment_method' => $stripe_payment_method,
                        'transaction_id' => $tran->id,
                        'currency' => $currency,
                        'billing_cycle' => $billing_cycle,
                        'product_type' => $product_type,
                    ]);

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

                if ($coupon_code && $discountvalue) {
                    CouponUsages::create([
                        'coupon_id' => $coupon_code,
                        'user_id' => $user->id,
                        'order_id' => $order->id ?? null,
                        'discount_value' => $discountvalue,
                    ]);
                }

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
                    $quantity
                );

                return auth()->check()
                    ? redirect()->route('user-dashboard')->with('success', 'Subscription created with trial period!')
                    : redirect()->route('user-login')->with('success', 'Subscription confirmed and active!');
            }

            // Ensure the user is logged in
            if (!auth()->check() && $user->id) {
                auth()->loginUsingId($user->id);
            }

            return redirect()->route('user-dashboard')->with('success', 'Payment successful!');
       
          } catch (\Stripe\Exception\CardException $e) {
            return redirect()->back()->with('error', $e->getError()->message);
        } catch (\Stripe\Exception\RateLimitException $e) {
            return redirect()->back()->with('error', 'Too many requests to the Stripe API.');
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            return redirect()->back()->with('error', 'Invalid payment request. Please try again.');
        } catch (\Stripe\Exception\AuthenticationException $e) {
            return redirect()->back()->with('error', 'Authentication with Stripe failed.');
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            return redirect()->back()->with('error', 'Network error. Please try again.');
        } catch (\Stripe\Exception\ApiErrorException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
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
        $subscription_id = $_GET['subscription_id'] ?? null;
        $billing_cycle = $_GET['billing_cycle'] ?? null;
        $product_type = $_GET['product_type'] ?? null;

        if ($subscription_id) {
            try {
                $subscription = \Stripe\Subscription::retrieve($subscription_id);
                $invoice = \Stripe\Invoice::retrieve($subscription->latest_invoice);
                $stripe_payment = \Stripe\PaymentIntent::retrieve($invoice->payment_intent);
            } catch (\Exception $e) {
                return redirect()->route('user-dashboard')->with('error', 'Unable to retrieve subscription payment status. ' . $e->getMessage());
            }
        } else {
            $paymentIntentId = $_GET['payment_intent'] ?? null;
            if (!$paymentIntentId) {
                return redirect()->route('user-dashboard')->with('error', 'Missing payment intent ID.');
            }

            try {
                $stripe_payment = \Stripe\PaymentIntent::retrieve($paymentIntentId);
            } catch (\Exception $e) {
                return redirect()->route('user-dashboard')->with('error', 'Unable to retrieve payment status. ' . $e->getMessage());
            }
        }

        $stripe_payment_id = $stripe_payment->id;
        $stripe_payment_method = $stripe_payment['payment_method'] ?? null;
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
                'currency' => $currency,
                'billing_cycle' => $billing_cycle,
                'product_type' => $product_type,
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
                    'currency' => $currency,
                    'billing_cycle' => $billing_cycle,
                    'product_type' => $product_type,
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
        elseif (in_array($stripe_payment_status, [
            'requires_payment_method',
            'requires_confirmation',
            'requires_action',
            'canceled',
            'processing',
            'failed',
        ])) {
            Transaction::create([
                'user_id' => $user->id,
                'product_id' => $product_id,
                'payment_status' => $stripe_payment_status,
                'payment_amount' => $old_amount,
                'razorpay_payment_id' => $stripe_payment_id,
                'payment_method' => $stripe_payment_method,
                'transaction_id' => $stripe_payment_id,
                'currency' => $currency
            ]);

            return redirect()->route('user-dashboard')
            ->with('error', 'Payment failed or incomplete. Stripe returned status: ' . $stripe_payment_status);
        }
        else {
            return redirect()->route('user-dashboard')
                ->with('error', 'Unknown Stripe payment status: ' . $stripe_payment_status);
        }
        // elseif($stripe_payment_status === 'requires_payment_method'){

        //     $tran = Transaction::create([
        //         'user_id' => $user['id'],
        //         'product_id' => $product_id,
        //         'payment_status' => $stripe_payment_status,
        //         'payment_amount' => $old_amount,
        //         'razorpay_payment_id' => $stripe_payment_id,
        //         'payment_method' => $stripe_payment_method,
        //         'transaction_id' => $stripe_payment_id,
        //         'currency' => $currency
        //     ]);

        //     session()->flash('success', 'Payment Failed');
        //     if (auth()->check()) {
        //     return redirect()->route('user-dashboard');
        //      }
        //     else{
        //         return redirect()->route('user-login')->with('success', 'Subscription confirmed and active!');
        //     }

        // }
        // elseif($stripe_payment_status === 'failed'){

        //     $tran = Transaction::create([
        //         'user_id' => $user['id'],
        //         'product_id' => $product_id,
        //         'payment_status' => $stripe_payment_status,
        //         'payment_amount' => $old_amount,
        //         'razorpay_payment_id' => $stripe_payment_id,
        //         'payment_method' => $stripe_payment_method,
        //         'transaction_id' => $stripe_payment_id,
        //         'currency' => $currency
        //     ]);

        //     session()->flash('success', 'Payment Failed');
        //     if (auth()->check()) {
        //     return redirect()->route('user-dashboard');
        //      }
        //     else{
        //         return redirect()->route('user-login')->with('success', 'Subscription confirmed and active!');
        //     }
        // }
        // else{

        //     $tran = Transaction::create([
        //         'user_id' => $user['id'],
        //         'product_id' => $product_id,
        //         'payment_status' => $stripe_payment_status,
        //         'payment_amount' => $old_amount,
        //         'razorpay_payment_id' => $stripe_payment_id,
        //         'payment_method' => $stripe_payment_method,
        //         'transaction_id' => $stripe_payment_id,
        //         'currency' => $currency
        //     ]);

        //     session()->flash('success', 'Payment Failed');
        //     if (auth()->check()) {
        //     return redirect()->route('user-dashboard');
        //     }
        //     else{
        //         return redirect()->route('user-login')->with('success', 'Subscription confirmed and active!');
        //     }
        // }
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

    //         // Find the user/subscription record
    //         $subscription = Subscription::where('subscription_id', $subscription_id)->first();

    //         if ($subscription) {
    //             $user = $subscription->user;

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

    //             // ✅ FIND existing trial transaction & order
    //             $trialTransaction = Transaction::where('user_id', $user->id)
    //                 ->where('product_id', $product_id)
    //                 ->where('payment_status', 'trialing')
    //                 ->first();

    //             $trialOrder = Order::where('user_id', $user->id)
    //                 ->where('product_id', $product_id)
    //                 ->where('payment_status', 'trialing')
    //                 ->first();

    //             if ($trialTransaction && $trialOrder) {
    //                 $trialTransaction->update([
    //                     'payment_status' => $stripe_payment_status,
    //                     'payment_amount' => $amount_paid,
    //                     'razorpay_payment_id' => $stripe_payment_id,
    //                     'payment_method' => $stripe_payment_method,
    //                     'transaction_id' => $stripe_payment_id,
    //                     'currency' => $currency,
    //                 ]);

    //                 $trialOrder->update([
    //                     'payment_status' => $stripe_payment_status,
    //                     'payment_amount' => $amount_paid,
    //                     'razorpay_payment_id' => $stripe_payment_id,
    //                     'payment_method' => $stripe_payment_method,
    //                     'currency' => $currency,
    //                 ]);

    //                 // ✅ OPTIONAL: Generate Invoice
    //                 $this->generateInvoice(
    //                     $user,
    //                     $invoice['id'],
    //                     $trialOrder->id,
    //                     $invoice['subtotal'] / 100,
    //                     18,
    //                     $invoice['discounts'][0]['coupon']['percent_off'] ?? 0,
    //                     $invoice['discounts'][0]['coupon']['id'] ?? '',
    //                     $amount_paid,
    //                     $stripe_payment_status,
    //                     $product_id,
    //                     $quantity
    //                 );
    //             } else {
    //                 $tran = Transaction::create([
    //                     'user_id' => $user->id,
    //                     'product_id' => $product_id,
    //                     'payment_status' => $stripe_payment_status,
    //                     'payment_amount' => $amount_paid,
    //                     'razorpay_payment_id' => $stripe_payment_id,
    //                     'payment_method' => $stripe_payment_method,
    //                     'transaction_id' => $stripe_payment_id,
    //                     'currency' => $currency
    //                 ]);

    //                 $order = Order::create([
    //                     'product_id'=> $product_id,
    //                     'user_id' => $user->id,
    //                     'payment_status' => $stripe_payment_status,
    //                     'payment_amount' => $amount_paid,
    //                     'razorpay_payment_id' => $stripe_payment_id,
    //                     'payment_method' => $stripe_payment_method,
    //                     'transaction_id' => $tran->id,
    //                     'currency' => $currency
    //                 ]);

    //                 // Optional invoice
    //                 $this->generateInvoice(
    //                     $user,
    //                     $invoice['id'],
    //                     $order->id,
    //                     $invoice['subtotal'] / 100,
    //                     18,
    //                     $invoice['discounts'][0]['coupon']['percent_off'] ?? 0,
    //                     $invoice['discounts'][0]['coupon']['id'] ?? '',
    //                     $amount_paid,
    //                     $stripe_payment_status,
    //                     $product_id,
    //                     $quantity
    //                 );
    //             }
    //         } else {
    //             \Log::warning("Stripe Webhook: No subscription record found for ID $subscription_id");
    //         }
    //     }

    //     return response()->json(['status' => 'success']);
    // }
    public function handleWebhook(Request $request)
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        
        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sig_header,
                env('STRIPE_WEBHOOK_SECRET')
            );
        } catch (\Exception $e) {
            \Log::error('Stripe webhook verification failed: '.$e->getMessage());
            return response()->json(['error' => 'Invalid signature'], 403);
        }

        $eventType = $event->type;
        $data = $event->data->object;

        // Handle trial ending and first payment
        if ($eventType === 'invoice.payment_succeeded') {
            $subscriptionId = $data->subscription;
            $invoiceId = $data->id;
            $paymentIntentId = $data->payment_intent;
            $amountPaid = $data->amount_paid / 100;
            $currency = strtoupper($data->currency);
            $status = $data->status;

            // Get subscription details
            try {
                $subscription = \Stripe\Subscription::retrieve($subscriptionId);
                $customerId = $subscription->customer;
                $productId = $subscription->metadata->product_id ?? null;
                $userId = $subscription->metadata->user_id ?? null;
                $quantity = $subscription->metadata->quantity ?? 1;
                $planAmount = $subscription->items->data[0]->plan->amount / 100; // Get plan price (1180.00)

                // Find the user
                $user = User::find($userId);
                if (!$user) {
                    \Log::error("User not found for subscription: $subscriptionId");
                    return response()->json(['status' => 'user_not_found'], 404);
                }

                // Check if this is the first payment after trial
                $isTrialEnding = $subscription->status === 'active' && 
                                $subscription->billing_cycle_anchor && 
                                $subscription->billing_cycle_anchor > time() - 86400; // Within last day

                // Find existing trial records
                $trialTransaction = Transaction::where('user_id', $userId)
                    ->where('product_id', $productId)
                    ->where('payment_status', 'trialing')
                    ->first();

                $trialOrder = Order::where('user_id', $userId)
                    ->where('product_id', $productId)
                    ->where('payment_status', 'trialing')
                    ->first();

                if ($isTrialEnding && $trialTransaction && $trialOrder) {
                    // Update trial transaction (from 0.00 to 1180.00)
                    $trialTransaction->update([
                        'payment_status' => 'paid',
                        'payment_amount' => $planAmount, // Update to full plan price
                        'razorpay_payment_id' => $paymentIntentId,
                        'payment_method' => 'card',
                        'transaction_id' => $paymentIntentId,
                        'currency' => $currency,
                        'updated_at' => now()
                    ]);

                    // Update trial order (from 0.00 to 1180.00)
                    $trialOrder->update([
                        'payment_status' => 'paid',
                        'payment_amount' => $planAmount, // Update to full plan price
                        'razorpay_payment_id' => $paymentIntentId,
                        'payment_method' => 'card',
                        'currency' => $currency,
                        'updated_at' => now()
                    ]);

                    // Update license key expiration
                    Key::where('order_id', $trialOrder->id)
                        ->update([
                            'expire_at' => now()->addMonths(1), // Extend by billing period
                            'sys_state' => 0 // Mark as active
                        ]);

                    // Generate proper invoice with actual payment amount
                    $this->updateInvoiceAfterTrial(
                        $user,
                        $invoiceId,
                        $trialOrder->id,
                        $planAmount, // Full amount (1180.00)
                        $data->tax / 100,
                        $data->discount ? $data->discount->coupon->percent_off ?? 0 : 0,
                        $data->discount ? $data->discount->coupon->id ?? '' : '',
                        $productId,
                        $quantity
                    );

                    \Log::info("Successfully converted trial to paid subscription for user $userId (Amount: $planAmount)");
                } else {
                    // Handle regular payment (not trial conversion)
                    $this->handleRegularPayment($user, $data, $productId, $quantity);
                }

            } catch (\Exception $e) {
                \Log::error("Error processing Stripe webhook: ".$e->getMessage());
                return response()->json(['error' => 'Processing failed'], 500);
            }
        }

        return response()->json(['status' => 'success']);
    }

    protected function updateInvoiceAfterTrial($user, $invoiceId, $orderId, $amount, $tax, $discount, $couponCode, $productId, $quantity)
    {
        // First try to find existing invoice
        $invoice = InvoiceModel::where('invoice_id', $invoiceId)->first();
        
        if ($invoice) {
            // Update existing invoice
            $invoice->update([
                'subtotal' => $amount,
                'tax_amount' => $tax,
                'discount' => $discount,
                'coupon_code' => $couponCode,
                'total_amount' => $amount + $tax - $discount,
                'status' => 'paid',
                'updated_at' => now()
            ]);
        } else {
            // Create new invoice if not found
            $this->generateInvoice(
                $user,
                $invoiceId,
                $orderId,
                $amount,
                $tax,
                $discount,
                $couponCode,
                $amount + $tax - $discount,
                'paid',
                $productId,
                $quantity
            );
        }
    }

    protected function handleRegularPayment($user, $invoice, $productId, $quantity)
    {
        $tran = Transaction::create([
            'user_id' => $user->id,
            'product_id' => $productId,
            'payment_status' => 'paid',
            'payment_amount' => $invoice->amount_paid / 100,
            'razorpay_payment_id' => $invoice->payment_intent,
            'payment_method' => 'card',
            'transaction_id' => $invoice->payment_intent,
            'currency' => strtoupper($invoice->currency)
        ]);

        $order = Order::create([
            'product_id' => $productId,
            'user_id' => $user->id,
            'payment_status' => 'paid',
            'payment_amount' => $invoice->amount_paid / 100,
            'razorpay_payment_id' => $invoice->payment_intent,
            'payment_method' => 'card',
            'transaction_id' => $tran->id,
            'currency' => strtoupper($invoice->currency)
        ]);

        // Generate invoice
        $this->generateInvoice(
            $user,
            $invoice->id,
            $order->id,
            $invoice->subtotal / 100,
            $invoice->tax / 100,
            $invoice->discount ? $invoice->discount->coupon->percent_off ?? 0 : 0,
            $invoice->discount ? $invoice->discount->coupon->id ?? '' : '',
            $invoice->amount_paid / 100,
            'paid',
            $productId,
            $quantity
        );
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
    public function cancelAutoPay($id)
    {
        try {
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

            // Retrieve the subscription record from the local database
            $subscription = SubscriptionRec::find($id);
            if (!$subscription) {
                return redirect()->back()->with('error', 'Subscription not found.');
            }

            // Retrieve the Stripe subscription details
            $stripeSubscription = Subscription::where('key_id', $subscription->key_id)->first();
            if (!$stripeSubscription || empty($stripeSubscription->subscription_id)) {
                return redirect()->back()->with('error', 'Stripe subscription not found.');
            }

            // Fetch subscription details from Stripe
            $subscriptionStripe = \Stripe\Subscription::retrieve($stripeSubscription->subscription_id);
            if (!$subscriptionStripe || empty($subscriptionStripe->id)) {
                return redirect()->back()->with('error', 'Stripe subscription not found.');
            }

            // **Turn off auto-renewal instead of canceling immediately**
            $updatedSubscription = \Stripe\Subscription::update(
                $stripeSubscription->subscription_id,
                ['cancel_at_period_end' => true]
            );

            // Update local subscription status to reflect renewal off
            $subscription->update(['status' => 'renewal_off']);

            return redirect()->back()->with('success', 'AutoPay stopped successfully. Subscription will remain active until the current billing cycle ends.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error stopping AutoPay: ' . $e->getMessage());
        }
    }

    public function deactivate($keyId)
    {
        try {
            $key = Key::findOrFail($keyId);

            // Mark the key as expired
            $key->update([
                'expire_at' => now(),
                'sys_state' => 1,
            ]);
            return redirect()->back()->with('success' , 'Product deactivated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error deactivating product: ' . $e->getMessage());
        }
    }
    // public function reactivateSubscription($id)
    // {
    //     try {
    //         \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

    //         $subscription = SubscriptionRec::find($id);
    //         if (!$subscription) {
    //             return redirect()->back()->with('error', 'Subscription not found.');
    //         }

    //         $stripeSubscription = Subscription::where('key_id', $subscription->key_id)->first();
    //         if (!$stripeSubscription || empty($stripeSubscription->subscription_id)) {
    //             return redirect()->back()->with('error', 'Stripe subscription not found.');
    //         }

    //         $subscriptionStripe = \Stripe\Subscription::retrieve($stripeSubscription->subscription_id);
    //         if (!$subscriptionStripe || empty($subscriptionStripe->customer)) {
    //             return redirect()->back()->with('error', 'Stripe customer ID is missing.');
    //         }

    //         $paymentMethods = \Stripe\PaymentMethod::all([
    //             'customer' => $subscriptionStripe->customer,
    //             'type' => 'card'
    //         ]);

    //         if (empty($paymentMethods->data)) {
    //             return redirect()->back()->with('error', 'No payment method found for this customer.');
    //         }

    //         $defaultPaymentMethod = $paymentMethods->data[0]->id;
    //         Customer::update(
    //             $subscriptionStripe->customer,
    //             ['invoice_settings' => ['default_payment_method' => $defaultPaymentMethod]]
    //         );

    //         if (empty($subscriptionStripe->items->data[0]->price->id)) {
    //             return redirect()->back()->with('error', 'Missing Stripe price ID.');
    //         }

    //         $newSubscription = \Stripe\Subscription::create([
    //             'customer' => $subscriptionStripe->customer,
    //             'items' => [['price' => $subscriptionStripe->items->data[0]->price->id]],
    //             'default_payment_method' => $defaultPaymentMethod,
    //             'payment_behavior' => 'allow_incomplete',
    //             'expand' => ['latest_invoice.payment_intent']
    //         ]);

    //         if (isset($newSubscription->latest_invoice) && isset($newSubscription->latest_invoice->id)) {
    //             $invoice = \Stripe\Invoice::retrieve($newSubscription->latest_invoice->id);
    //             if ($invoice->status === 'draft') {
    //                 $invoice->finalizeInvoice();
    //             }
    //         }

            // $subscription->update([
            //     'status' => 'active',
            //     'subscription_id' => $newSubscription->id,
            // ]);

            // $userSubscription = Subscription::where('key_id', $subscription->key_id)->first();
            // if ($userSubscription) {
            //     $userSubscription->update([
            //         'status' => 'active',
            //         'subscription_id' => $newSubscription->id,
            //     ]);
            // }

            // $key_id = $subscription->key_id;
            // if ($key_id) {
            //     $key = Key::find($key_id);
            //     if ($key) {
            //         $key->update([
            //             'expire_at' => now()->addMonth(),
            //             'sys_state' => '0',
            //         ]);
            //     }
            // }

            // return redirect()->back()->with('success', 'Subscription reactivated and product activated successfully.');
    //     } catch (\Exception $e) {
    //         return redirect()->back()->with('error', 'Error reactivating subscription: ' . $e->getMessage());
    //     }
    // }
    public function reactivateSubscription($id, Request $request)
    {
        try {
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

            $subscriptionRec = SubscriptionRec::findOrFail($id);
            $user = auth()->user();
            $key = Key::findOrFail($subscriptionRec->key_id);
            $order = Order::findOrFail($subscriptionRec->order_id);
            $product_id = $order->product_id;
            $amount = $order->payment_amount * 100; 
            $currency = $order->currency;
            $quantity = $order->quantity;

            // Create payment method from token
            $paymentMethod = \Stripe\PaymentMethod::create([
                'type' => 'card',
                'card' => [
                    'token' => $request->input('stripeToken'),
                ],
            ]);

           $oldStripeSubscription = \Stripe\Subscription::retrieve($subscriptionRec->subscription_id);

            if (!$oldStripeSubscription) {
                return response()->json(['success' => false, 'message' => 'Original subscription not found on Stripe.']);
            }

            // Extract existing price ID from subscription items (assume first item)
            $existingPriceId = $oldStripeSubscription->items->data[0]->price->id;

            // Create new subscription
            $newSubscription = \Stripe\Subscription::create([
                'customer' => $user->stripe_customer_id ?? '',
                'items' => [['price' => $existingPriceId]],
                'payment_behavior' => 'default_incomplete',
                'expand' => ['latest_invoice.payment_intent'],
                'metadata' => [
                    'user_id' => $user->id,
                    'reactivated_subscription' => $subscriptionRec->id,
                ],
            ]);

            $paymentIntent = $newSubscription->latest_invoice->payment_intent;

            if ($paymentIntent->status === 'requires_action') {
                $authenticationUrl = $paymentIntent->next_action->redirect_to_url->url;
                echo "<script>window.location.href = '$authenticationUrl';</script>";
                exit;
            }

            // Confirm payment
            $confirmedPayment = $paymentIntent->confirm([
                'payment_method' => $paymentMethod->id,
                'return_url' => route('stripe-payment-3d', ['user_id' => $user->id]),
            ]);

            if ($confirmedPayment->status === 'succeeded') {
                // Update Transaction
                $transaction = Transaction::where('id', $order->transaction_id)->first();
                if ($transaction) {
                    $transaction->update([
                        'payment_status' => 'succeeded',
                        'payment_amount' => $amount,
                        'payment_method' => $paymentMethod->id,
                        'razorpay_payment_id' => $confirmedPayment->id,
                        'transaction_id' => $confirmedPayment->id,
                    ]);
                }

                // Update SubscriptionRec
                $subscriptionRec->update([
                    'status' => 'active',
                    'subscription_id' => $newSubscription->id,
                ]);

                // Update Order
                $order->update([
                    'payment_status' => 'succeeded',
                    'razorpay_payment_id' => $confirmedPayment->id,
                    'payment_method' => $paymentMethod->id,
                    'transaction_id' => $transaction->id ?? null,
                    'payment_amount' => $amount / 100,
                ]);

                // Update Key expiry
                $key->update([
                    'expire_at' => now()->addYear(),
                    'sys_state' => '0',
                ]);

                // Create new invoice
                $invoiceNo = 'INV' . now()->format('dmy') . str_pad(rand(1, 99), 2, '0', STR_PAD_LEFT);
                InvoiceModel::create([
                    'orderid' => $order->id,
                    'user_id' => $user->id,
                    'transaction_id' => $transaction->id ?? null,
                    'invoice_number' => $invoiceNo,
                    'subtotal' => $amount / 100,
                    'gst_percentage' => 0,
                    'discount_type' => 'percentage',
                    'discount' => 0,
                    'applied_coupon' => '',
                    'total' => $amount / 100,
                    'payment_method' => "Stripe",
                    'payment_status' => 'succeeded',
                    'product_id' => $product_id,
                    'quantity' => $quantity,
                ]);

                session()->flash('success', 'Subscription reactivated and invoice generated!');
                return redirect()->route('user-dashboard');
            } else {
                return back()->with('error', 'Payment failed. Please try again.');
            }

        } catch (\Exception $e) {
            return back()->with('error', 'Error reactivating subscription: ' . $e->getMessage());
        }
    }


}
