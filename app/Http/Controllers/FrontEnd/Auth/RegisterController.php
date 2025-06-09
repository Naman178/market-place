<?php

namespace App\Http\Controllers\FrontEnd\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Stripe\Stripe;
use App\Models\ContactsCountryEnum;
use App\Models\SEO;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Stripe\StripePaymentController;
use Stripe\Charge;
use Illuminate\Validation\Rule;
class RegisterController extends Controller
{
    public function index()
    {
        $countaries = ContactsCountryEnum::orderBy('id')->get();
        $seoData = SEO::where('page','sign up')->first();
        return view('front-end.auth.register',compact('seoData','countaries'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required|email|unique:users',
            'country_code' => 'required',
            'contact_number' => 'required',
            'company_name' => 'required',
            'company_website' => 'required|url',
            'country' => 'required',
            'address_line1' => 'required',
            'address_line2' => 'nullable',
            'city' => 'required',
            'postal_code' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = new User();
        $user->name = $request->fname." ".$request->lname;
        $user->fname = $request->fname;
        $user->lname = $request->lname;
        $user->email = $request->email;
        $user->country_code = $request->country_code;
        $user->contact_number = $request->contact_number_number;
        $user->company_name = $request->company_name;
        $user->company_website = $request->company_website;
        $user->country = $request->country;
        $user->address_line1 = $request->address_line1;
        $user->address_line2 = $request->address_line2;
        $user->city = $request->city;
        $user->postal_code = $request->postal_code;
        $user->password = Hash::make($request->password);
        $user->confirm_password = Hash::make($request->password);

        $user->save();

        // Redirect to dashboard or login page
        return redirect('/user-login')->with('success', 'Registration successful. You can now login.');
    }

    public function userCreateCheckout(Request $request){
        $data = $request->all();
         if (!Auth::check()) {
                $name = $request->firstname .' '.$request->lastname;
                $fname = $request->firstname;
                $lname = $request->lastname;
                $email = $request->email;
                $country_code = $request->country_code;
                $contact = $request->contact_number;
                $mobile = '+'.$country_code.$contact;
                $company_name = $request->company_name;
                $company_website = $request->company_website;
                $country = $request->country;
                $address_line_one = $request->address_line1;
                $address_line_two = $request->address_line2;
                $city = $request->city;
                $postal = $request->postal_code;
                $gst = $request->gst;
                $pass = Str::random(10);
                $password = Hash::make($pass);
                
                $response = Http::get('https://disposable.debounce.io', ['email' => $email]);
                $disposableData = $response->json();
                if (!empty($disposableData['disposable']) && $disposableData['disposable'] === 'true') {
                    return back()->withErrors(['email' => 'We are not accepting Disposable Email Addresses.']);
                }

                // 2. Reuse deleted user if sys_state == -1
                $existingUser = User::where('email', $email)->first();
                $isReactivating = false;

                $pass = Str::random(10);
                $password = Hash::make($pass);

                if ($existingUser && $existingUser->sys_state == -1) {
                    // Reactivate the user
                    $existingUser->update([
                        'sys_state' => 0, 
                        'password' => $password,
                        'name' => $request->firstname . ' ' . $request->lastname,
                        'fname' => $request->firstname,
                        'lname' => $request->lastname,
                        'country_code' => $request->country_code,
                        'contact_number' => $request->contact_number,
                        'company_name' => $request->company_name,
                        'company_website' => $request->company_website,
                        'country' => $request->country,
                        'address_line1' => $request->address_line1,
                        'address_line2' => $request->address_line2,
                        'city' => $request->city,
                        'postal_code' => $request->postal_code,
                        'gstin' => $request->gst,
                    ]);
                    $save_user = $existingUser;
                    $isReactivating = true;
                } elseif (!$existingUser) {
                        $save_user = User::create([
                            'name'=>$name,
                            'email'=>$email,
                            'fname'=> $fname,
                            'lname'=>$lname,
                            'country_code'=>$country_code,
                            'contact_number'=>$contact, 
                            'password'=>$password,
                            'company_name' => $company_name,
                            'company_website' => $company_website,
                            'country' => $country,
                            'address_line1' => $address_line_one,
                            'address_line2' => $address_line_two,
                            'city' => $city,
                            'postal_code' => $postal,
                            'gstin' => $gst,
                        ]);
                } else {
                    // If user exists and is not deleted, return error
                    return response()->json(['error' => 'Email is already in use. Please login instead.']);
                }
                
                $customCredentials = [
                    'email' => $email,
                    'password' => $pass,
                ];
                
                $mailData = [
                    'title' => 'Registration Successful !',
                    'email' => $email,
                    'password' => $pass,
                ];

               Mail::to($email)->send(new WelcomeEmail($save_user, $pass));
                if ($save_user) {
                            
                                // // Set your secret key
                                // \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                            
                                // // Get payment token from Stripe.js
                                // $token = $request->stripeToken;
                                // try {
                            
                                //     // Create a customer in Stripe
                                //   $customer = \Stripe\Customer::create([
                                //         'name' => $request->name,
                                //         'email' => $request->email,
                                //          'address' => [
                                //             'line1' => $request->address_line_one,
                                //             'line2' => $request->address_line_two,
                                //             'city' => $request->city,
                                //             'postal_code' => $request->postal_code,
                                //             'country' => $request->country,
                                //         ],
                                //     ]);
                                //       $customer_id = $customer->id;
                                //     // $customer = \Stripe\Customer::retrieve($customer_id);
                                //     // $customer->source = $token;
                                //     // $customer->save();
                            
                                //     // $stripe_payment = Charge::create ([
                                //     //     "amount" => $request->amount * 100,
                                //     //     "currency" => "AED",            
                                //     //     'customer' => $customer_id,
                                //     //     "description" => "Payment For the Skyfinity Quick Checkout Wallet" 
                                //     // ]);   
                                // $paymentIntent = \Stripe\PaymentIntent::create([
                                //     'amount' => $request->amount * 100,
                                //     'currency' => "INR",
                                //     'customer' => $customer_id,
                                //     'payment_method_types' => ['card'],
                                //     'description' => 'Payment For the Market Place Checkout Wallet',
                                // ]);
                                
                                // $paymentMethod = \Stripe\PaymentMethod::create([
                                //     'type' => 'card',
                                //     'card' => [
                                //         'token' => $request->stripeToken,
                                //     ],
                                // ]);
            
                                    
                                //     // Payment successful
                                //     return response()->json([
                                //         "success" => true,
                                //         "message" => "Payment has been successfully processed.",
                                //     ]);
                                // } catch (\Stripe\Exception\CardException $e) {
                                //     // Handle card errors
                                //     return response()->json([
                                //         "error" => "Card error: " . $e->getMessage(),
                                //     ]);
                                // } catch (\Stripe\Exception\RateLimitException $e) {
                                //     // Too many requests made to the API too quickly
                                //     return response()->json([
                                //         "error" => "Too many requests: " . $e->getMessage(),
                                //     ]);
                                // } catch (\Stripe\Exception\InvalidRequestException $e) {
                                //     // Invalid parameters were supplied to Stripe's API
                                //     return response()->json([
                                //         "error" => "Invalid request: " . $e->getMessage(),
                                //     ]);
                                // } catch (\Exception $e) {
                                //     // Payment failed
                                //     return response()->json([
                                //         "error" => "An error occurred: " . $e->getMessage(),
                                //     ]);
                                // }
                                $stripeController = new StripePaymentController();
                                $stripeRequest = new Request($request->all());

                                $paymentResponse = $stripeController->stripePost($stripeRequest);
                                $stripeResult = json_decode($paymentResponse->getContent(), true);

                                if (!empty($stripeResult['success']) && $stripeResult['success']) {
                                    if (Auth::attempt($customCredentials)) {
                                        $save_user->assignRole('User');

                                        if (isset($stripeResult['redirect_url'])) {
                                            return response()->json([
                                                'success' => true,
                                                'requires_action' => true,
                                                'redirect_url' => $stripeResult['redirect_url'],
                                            ]);
                                        }

                                        return response()->json([
                                            'success' => true,
                                            'message' => 'User created and payment successful!',
                                        ]);
                                    } else {
                                        return response()->json([
                                            'error' => 'User created but failed to log in.',
                                        ]);
                                    }
                                } 
                            }
                if (Auth::attempt($customCredentials)) {
                    $save_user->assignRole('User');
                    return response()->json([
                        'success' => 'User Created Successfully!',
                        'title' => 'User',
                        'type' => 'Creation',
                        'data' => $save_user,
                    ]);
                }
                else{
                    return response()->json(['error'=> 'Error in login in user' ]);
                }      
            }
         else{
              
                        $user = User::find(Auth::user()->id);
                        if($user){
                            $user->update([
                                "name" => $request->firstname . ' '. $request->lastname,
                                "email" => $request->email,
                                "country_code" => $request->country_code,
                                "contact_number" => $request->contact_number,
                                "company_website" => $request->company_website,
                                "company_name" => $request->company_name,
                                "country" => $request->country,
                                "address_line1" => $request->address_line1,
                                "address_line2" => $request->address_line2,
                                "city" => $request->city,
                                "postal_code" => $request->postal_code
                            ]);
                        }
        
                        // // Set your secret key
                        // \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                    
                        // // Get payment token from Stripe.js
                        // $token = $request->stripeToken;
                        // try {
                        //     // Create a customer in Stripe
                        //     $customer = \Stripe\Customer::create([
                        //         'name' => $request->name,
                        //         'email' => $request->email,
                        //             'address' => [
                        //             'line1' => $request->address_line_one,
                        //             'line2' => $request->address_line_two,
                        //             'city' => $request->city,
                        //             'postal_code' => $request->postal_code,
                        //             'country' => $request->country,
                        //         ],
                        //     ]);
                        //     $customer_id = $customer->id;
                        //     // $customer = \Stripe\Customer::retrieve($customer_id);
                        //     // $customer->source = $token;
                        //     // $customer->save();
                    
                        //     // $stripe_payment = Charge::create ([
                        //     //     "amount" => $request->amount * 100,
                        //     //     "currency" => "AED",            
                        //     //     'customer' => $customer_id,
                        //     //     "description" => "Payment For the Skyfinity Quick Checkout Wallet" 
                        //     // ]);   
                        //     $paymentIntent = \Stripe\PaymentIntent::create([
                        //         'amount' => $request->amount * 100,
                        //         'currency' => "INR",
                        //         'customer' => $customer_id,
                        //         'payment_method_types' => ['card'],
                        //         'description' => 'Payment For the Market Place Checkout Wallet',
                        //     ]);
                            
                        //     $paymentMethod = \Stripe\PaymentMethod::create([
                        //         'type' => 'card',
                        //         'card' => [
                        //             'token' => $request->stripeToken,
                        //         ],
                        //     ]);

                        //     // Payment successful
                        //     return response()->json([
                        //         "success" => true,
                        //         "message" => "Payment has been successfully processed.",
                        //     ]);
                         $stripeController = new StripePaymentController();

                        // Create a new Request instance with the Stripe data only (or use $request directly if it has the needed data)
                        $stripeRequest = new Request($request->all()); // Or only pass stripe-related data if you want

                        // Call the stripePost method
                        $paymentResponse = $stripeController->stripePost($stripeRequest);

                        // The response from stripePost is a Response object, get JSON content
                        $stripeResult = json_decode($paymentResponse->getContent(), true);

                        if (!empty($stripeResult['success']) && $stripeResult['success'] === true) {
                            return response()->json([
                                "success" => true,
                                "message" => "Payment has been successfully processed.",
                            ]);
                        } else {
                            return response()->json([
                                "error" => $stripeResult['message'] ?? 'Payment processing failed.',
                            ]);
                        }             
                        // } catch (\Exception $e) {
                        //     // Payment failed
                        //     return response()->json([
                        //         "error" => $e->getMessage(),
                        //     ]);
                        // }
                    }
            }
    
    public function postRegistration(Request $request)
    {
        // dd($request->all());
        // $request->validate([
        //     'firstname' => 'required|string|max:255',
        //     'last_name' => 'required|string|max:255',
        //     'email' => 'required|string|email|max:255|unique:users', // Check for unique email
        //     // 'country_code' => 'required|string',
        //     // 'company_name' => 'required|string|max:255',
        //     // 'company_website' => 'nullable|url|max:255',
        //     // 'address_line1' => 'required|string|max:255',
        //     // 'address_line2' => 'nullable|string|max:255',
        //     // 'city' => 'required|string|max:255',
        //     // 'postal_code' => 'required|string|max:20',
        //     'password' => 'required|string|min:8', // Add confirmation rule if applicable
        // ]);
        $response = Http::get('https://disposable.debounce.io', [
            'email' => $request->email,
        ]);
        $data = $response->json();
        if ($data['disposable'] === 'true') {
            return back()->withErrors(['email' => 'We are not accepting Disposable Email Address please use actual email address or signup with google, github, linkedIn.']);
        }
        $existingUser = User::where('email', $request->email)->first();
        $emailRules = ['required', 'email'];

        if (!$existingUser || $existingUser->sys_state != -1) {
            $emailRules[] = Rule::unique('users');
        }
        $request->validate([ 'email' => $emailRules]);
        $countryname = '';
        $countaries = ContactsCountryEnum::orderBy('id')->get();
        foreach($countaries as $country){
            if($country->country_code == $request->country_code){
                $countryname = $country->name;
            }
        }
        $name = $request->firstname .' '.$request->last_name;
        $fname = $request->firstname;
        $lname = $request->last_name;
        $email = $request->email;
        $subscribeToPromotions = $request->has('promotionsSubscriber') ? 1 : 0;
        // $country_code = $request->country_code;
        // $contact = $request->contact_number;
        // $mobile = '+'.$country_code.$contact;
        // $company_name = $request->company_name;
        // $company_website = $request->company_website;
        // $country = $countryname;
        // $address_line_one = $request->address_line1;
        // $address_line_two = $request->address_line2;
        // $city = $request->city;
        // $postal = $request->postal_code;
        // $gst = $request->gst;
        
        $password = Hash::make($request['password']);
        
        // $save_user = User::create([
        //     'name'=>$name , 
        //     'email'=>$email , 
        //     'fname'=> $fname , 
        //     'lname'=>$lname , 
        //     'country_code'=>$country_code, 
        //    'contact_number'=>$contact , 
        //     'company_name'=>$company_name, 
        //     'company_website'=>$company_website,
        //     'country'=>$country,
        //     'address_line1'=>$address_line_one,
        //     'address_line2'=>$address_line_two,
        //     'city'=>$city,
        //     'postal_code'=>$postal,
        //     'gstin'=>$gst,
        //     'password'=>$password,
        //     'subscribe_to_promotions'=>$subscribeToPromotions
        // ]);
        if ($existingUser && $existingUser->sys_state == -1) {
            // Reactivate soft-deleted user
            $existingUser->update([
                'sys_state' => 0,
                'name' => $name,
                'fname' => $fname,
                'lname' => $lname,
                'password' => $password,
                'subscribe_to_promotions' => $subscribeToPromotions,
            ]);
            $save_user = $existingUser;
        } elseif (!$existingUser) {
            // Create new user
            $save_user = User::create([
                'name' => $name,
                'email' => $email,
                'fname' => $fname,
                'lname' => $lname,
                'password' => $password,
                'subscribe_to_promotions' => $subscribeToPromotions,
            ]);
        } else {
            // Email already taken
            return back()->withErrors(['email' => 'Email is already in use. Please login instead.']);
        }
        
        // if($save_user){

        //     $razorpay_customer_id = '';
        //     $key_id = env('RAZORPAY_KEY');
        //     $secret = env('RAZORPAY_SECRET');

        //     $api = new Api($key_id, $secret);

        //     $perPage = 100; // Set the number of records to retrieve per page
        //     $currentPage = 1; // Start with the first page

        //     $allCustomers = [];
        //     do {
        //         $customers = $api->customer->all([
        //             'count' => $perPage,
        //             'skip' => ($currentPage - 1) * $perPage,
        //         ]);
            
        //         $allCustomers = array_merge($allCustomers, $customers->items);
            
        //         $currentPage++;
        //     } while ($customers->count >= $perPage);
            
        //     if (!empty($allCustomers)) {
        //         foreach($allCustomers as $cust){                        
        //             if($cust['email'] == $email && $cust['contact'] == $mobile){
        //                 $razorpay_customer_id = $cust['id'];
        //                 break;
        //             }
        //         }
        //     }
            
        //     if (empty($razorpay_customer_id)) {
        //         $razorpay_customer = $api->customer->create([
        //             'name' => $name,
        //             'email' => $email,
        //            'contact_number' => $mobile,
        //         ]);
        //         $razorpay_customer_id = $razorpay_customer['id'];
        //     }
            
        //     $cust = User::find($save_user->id);
        //     $cust->update([
        //         'razorpay_customer_id' => $razorpay_customer_id
        //     ]);
        // }
        if (!$save_user->hasRole('User')) {
            $save_user->assignRole('User');
        }

        $mailData = [
            'title' => 'Registration Successful !',
            'email' => $email,
            'password' => $request['password'],
        ];

        // Google Captcha Code
		$url = 'https://www.google.com/recaptcha/api/siteverify';
		$remoteip = $_SERVER['REMOTE_ADDR'];
		$data = [
			'secret' => config('services.recaptcha.secret'),
			'response' => $request->get('recaptcha'),
			'remoteip' => $remoteip
		];
		$options = [
			'http' => [
			'header' => "Content-type: application/x-www-form-urlencoded\r\n",
			'method' => 'POST',
			'content' => http_build_query($data)
			]
		];
		$context = stream_context_create($options);
		$result = file_get_contents($url, false, $context);
		$resultJson = json_decode($result);
		if ($resultJson->success != true) {
			return back()->withErrors(['captcha' => 'ReCaptcha Error']);
		}
		
		if ($resultJson->score < 0.3) {			
			return back()->withErrors(['captcha' => 'ReCaptcha Error']);
		}

        Mail::to($email)->send(new WelcomeEmail( $save_user, $password));
        Auth::login($save_user);
        return redirect('user-dashboard')->withSuccess('Great! You have Successfully loggedin');

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect("/")->withSuccess('Great! You have Successfully loggedin');
        }
    }
}
