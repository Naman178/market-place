<?php

namespace App\Http\Controllers\FrontEnd\Auth;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Mail;
use Validator;
use Illuminate\Support\Str;
use Stripe\Stripe;
use Stripe\Charge;
class RegisterController extends Controller
{
    public function index()
    {
        return view('front-end.auth.register');
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
        $user->contact_number = $request->contact_number;
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
        return redirect('/login')->with('success', 'Registration successful. You can now login.');
    }

    public function userCreateCheckout(Request $request){
        if($request->ajax()){
         if(!Auth::user()->id){
            $validator = Validator::make($request->all(), [
                'firstname' => 'required|regex:/^[a-zA-Z\s]+$/',
                'lastname' => 'required|regex:/^[a-zA-Z\s]+$/',
                'email' => 'required|email|unique:users',
                'country_code' => 'required',
                'contact' => 'required|digits:10',
                'country' => 'required',
                'address_line_one' => 'required|regex:/^[a-zA-Z0-9\s,.-]+$/',
                'city' => 'required|regex:/^[a-zA-Z\s]+$/',
                'postal' => 'required|digits_between:5,6',
                'company_name' => 'required|regex:/^[a-zA-Z\s]+$/',
                'company_website' => 'required|url',
            ], 
            $message = [                
                'firstname.required' => 'The First Name Is Required.',
                'firstname.regex' => 'The First Name should only contain letters and spaces.',
                'lastname.required' => 'The Last Name Is Required.',
                'lastname.regex' => 'The Last Name should only contain letters and spaces.',
                'email.required' => 'The Email Is Required.',
                'email.email' => 'Please enter a valid email address.',
                'email.unique' => 'The email has already been taken.',
                'country_code.required' => 'Please Select Any One Country Code.',
                'contact.required' => 'Please Add Your Contact Number.',
                'contact.digits' => 'The Contact Number must be exactly 10 digits.',
                'country.required' => 'Please Select Any One Country.',
                'address_line_one.required' => 'Please Add Your Address.',
                'address_line_one.regex' => 'The Address must contain only letters, numbers, spaces, commas, periods, or hyphens.',
                'city.required' => 'The City Is Required.',
                'city.regex' => 'The City name should only contain letters and spaces.',
                'postal.required' => 'The Postal Code Is Required.',
                'postal.digits_between' => 'The Postal Code must be 5 or 6 digits long.',
                'company_name.required' => 'The Company Name is required.',
                'company_name.regex' => 'The Company Name should only contain letters and spaces.',
                'company_website.required' => 'Please enter a valid URL for the company website.',
                'company_website.url' => 'Please enter a valid company website URL.',
            ]);
            if ($validator->passes()){
               
                $name = $request->firstname .' '.$request->lastname;
                $fname = $request->firstname;
                $lname = $request->lastname;
                $email = $request->email;
                $country_code = $request->country_code;
                $contact = $request->contact;
                $mobile = '+'.$country_code.$contact;
                $company_name = $request->company_name;
                $company_website = $request->company_website;
                $country = $request->country;
                $address_line_one = $request->address_line_one;
                $address_line_two = $request->address_line_two;
                $city = $request->city;
                $postal = $request->postal;
                $gst = $request->gst;
                $pass = Str::random(10);
                $password = Hash::make($pass);

                $save_user = User::create([
                    'name'=>$name,
                    'email'=>$email,
                    'fname'=> $fname,
                    'lname'=>$lname,
                    'country_code'=>$country_code,
                    'contact'=>$contact, 
                    'password'=>$password,
                    'company_name' => $company_name,
                    'company_website' => $company_website,
                    'country' => $country,
                    'address_line_1' => $address_line_one,
                    'address_line_2' => $address_line_two,
                    'city' => $city,
                    'zip' => $postal,
                    'gstin' => $gst,
                ]);
                
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
                            
                                // Set your secret key
                                \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                            
                                // Get payment token from Stripe.js
                                $token = $request->stripeToken;
                                try {
                            
                                    // Create a customer in Stripe
                                  $customer = \Stripe\Customer::create([
                                        'name' => $request->name,
                                        'email' => $request->email,
                                         'address' => [
                                            'line1' => $request->address_line_one,
                                            'line2' => $request->address_line_two,
                                            'city' => $request->city,
                                            'postal_code' => $request->postal,
                                            'country' => $request->country,
                                        ],
                                    ]);
                                      $customer_id = $customer->id;
                                    // $customer = \Stripe\Customer::retrieve($customer_id);
                                    // $customer->source = $token;
                                    // $customer->save();
                            
                                    // $stripe_payment = Charge::create ([
                                    //     "amount" => $request->amount * 100,
                                    //     "currency" => "AED",            
                                    //     'customer' => $customer_id,
                                    //     "description" => "Payment For the Skyfinity Quick Checkout Wallet" 
                                    // ]);   
                                $paymentIntent = \Stripe\PaymentIntent::create([
                                    'amount' => $request->amount * 100,
                                    'currency' => "INR",
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
            
                                    
                                    // Payment successful
                                    return response()->json([
                                        "success" => true,
                                        "message" => "Payment has been successfully processed.",
                                    ]);
                                } catch (\Stripe\Exception\CardException $e) {
                                    // Handle card errors
                                    return response()->json([
                                        "error" => "Card error: " . $e->getMessage(),
                                    ]);
                                } catch (\Stripe\Exception\RateLimitException $e) {
                                    // Too many requests made to the API too quickly
                                    return response()->json([
                                        "error" => "Too many requests: " . $e->getMessage(),
                                    ]);
                                } catch (\Stripe\Exception\InvalidRequestException $e) {
                                    // Invalid parameters were supplied to Stripe's API
                                    return response()->json([
                                        "error" => "Invalid request: " . $e->getMessage(),
                                    ]);
                                } catch (\Exception $e) {
                                    // Payment failed
                                    return response()->json([
                                        "error" => "An error occurred: " . $e->getMessage(),
                                    ]);
                                }
                            }
                if (Auth::attempt($customCredentials)) {
                    $save_user->assignRole('User');
                    return response()->json([
                        'success' => 'User Created Successfully!',
                        'title' => 'User',
                        'type' => 'Creation',
                        'data' => $save_user,
                        'user' => $cust
                    ]);
                }
                else{
                    return response()->json(['error'=> 'Error in login in user' ]);
                }      
            }
            else{
                return response()->json(['error'=>$validator->getMessageBag()->toArray()]);
            }
            
         }
         else{
                if($request->ajax()){
                    $validator = Validator::make($request->all(), [
                        'firstname' => 'required|regex:/^[a-zA-Z\s]+$/',
                        'lastname' => 'required|regex:/^[a-zA-Z\s]+$/',
                        'email' => 'required|email',
                        'country_code' => 'required',
                        'contact' => 'required|digits:10',
                        'country' => 'required',
                        'address_line_one' => 'required|regex:/^[a-zA-Z0-9\s,.-]+$/',
                        'city' => 'required|regex:/^[a-zA-Z\s]+$/',
                        'postal' => 'required|digits_between:5,6',
                        'company_name' => 'required|regex:/^[a-zA-Z\s]+$/',
                        'company_website' => 'required|url',
                    ], 
                    $message = [                
                        'firstname.required' => 'The First Name Is Required.',
                        'firstname.regex' => 'The First Name should only contain letters and spaces.',
                        'lastname.required' => 'The Last Name Is Required.',
                        'lastname.regex' => 'The Last Name should only contain letters and spaces.',
                        'email.required' => 'The Email Is Required.',
                        'email.email' => 'Please enter a valid email address.',
                        'country_code.required' => 'Please Select Any One Country Code.',
                        'contact.required' => 'Please Add Your Contact Number.',
                        'contact.digits' => 'The Contact Number must be exactly 10 digits.',
                        'country.required' => 'Please Select Any One Country.',
                        'address_line_one.required' => 'Please Add Your Address.',
                        'address_line_one.regex' => 'The Address must contain only letters, numbers, spaces, commas, periods, or hyphens.',
                        'city.required' => 'The City Is Required.',
                        'city.regex' => 'The City name should only contain letters and spaces.',
                        'postal.required' => 'The Postal Code Is Required.',
                        'postal.digits_between' => 'The Postal Code must be 5 or 6 digits long.',
                        'company_name.required' => 'The Company Name is required.',
                        'company_name.regex' => 'The Company Name should only contain letters and spaces.',
                        'company_website.required' => 'Please enter a valid URL for the company website.',
                        'company_website.url' => 'Please enter a valid company website URL.',
                    ]);
                    
                    if ($validator->passes()){
                        $user = User::find(Auth::user()->id);
                        if($user){
                            $user->update([
                                "name" => $request->firstname . ' '. $request->lastname,
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
                        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                    
                        // Get payment token from Stripe.js
                        $token = $request->stripeToken;
                        try {
                            // Create a customer in Stripe
                            $customer = \Stripe\Customer::create([
                                'name' => $request->name,
                                'email' => $request->email,
                                    'address' => [
                                    'line1' => $request->address_line_one,
                                    'line2' => $request->address_line_two,
                                    'city' => $request->city,
                                    'postal_code' => $request->postal,
                                    'country' => $request->country,
                                ],
                            ]);
                            $customer_id = $customer->id;
                            // $customer = \Stripe\Customer::retrieve($customer_id);
                            // $customer->source = $token;
                            // $customer->save();
                    
                            // $stripe_payment = Charge::create ([
                            //     "amount" => $request->amount * 100,
                            //     "currency" => "AED",            
                            //     'customer' => $customer_id,
                            //     "description" => "Payment For the Skyfinity Quick Checkout Wallet" 
                            // ]);   
                            $paymentIntent = \Stripe\PaymentIntent::create([
                                'amount' => $request->amount * 100,
                                'currency' => "INR",
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

                            // Payment successful
                            return response()->json([
                                "success" => true,
                                "message" => "Payment has been successfully processed.",
                            ]);
                                
                        } catch (\Exception $e) {
                            // Payment failed
                            return response()->json([
                                "error" => $e->getMessage(),
                            ]);
                        }
                    }
                else{
                        return response()->json(['error'=>$validator->getMessageBag()->toArray()]);
                    }
                }
            }
        }        
    }
    
    public function postRegistration(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users', // Check for unique email
            'country_code' => 'required|string',
            'contact_number' => 'required|string',
            'company_name' => 'required|string|max:255',
            'company_website' => 'nullable|url|max:255',
            'country' => 'required|string',
            'address_line1' => 'required|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed', // Add confirmation rule if applicable
        ]);
        $name = $request->first_name .' '.$request->last_name;
        $fname = $request->first_name;
        $lname = $request->last_name;
        $email = $request->email;
        $country_code = $request->country_code;
        $contact = $request->contact;
        $mobile = '+'.$country_code.$contact;
        $company_name = $request->company_name;
        $company_website = $request->company_website;
        $country = $request->country;
        $address_line_one = $request->address_line_one;
        $address_line_two = $request->address_line_two;
        $city = $request->city;
        $postal = $request->postal;
        $gst = $request->gst;
        
        $password = Hash::make($request['password']);
        
        $save_user = User::create([
            'name'=>$name , 
            'email'=>$email , 
            'fname'=> $fname , 
            'lname'=>$lname , 
            'country_code'=>$country_code, 
            'contact'=>$contact , 
            'company_name'=>$company_name, 
            'company_website'=>$company_website,
            'country'=>$country,
            'address_line_1'=>$address_line_one,
            'address_line_2'=>$address_line_two,
            'city'=>$city,
            'zip'=>$postal,
            'gstin'=>$gst,
            'password'=>$password
        ]);
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
        //             'contact' => $mobile,
        //         ]);
        //         $razorpay_customer_id = $razorpay_customer['id'];
        //     }
            
        //     $cust = User::find($save_user->id);
        //     $cust->update([
        //         'razorpay_customer_id' => $razorpay_customer_id
        //     ]);
        // }
        
        $save_user->assignRole('User');

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
        return redirect('user-login')->withSuccess('Great! You have Successfully loggedin');

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect("/")->withSuccess('Great! You have Successfully loggedin');
        }
    }
}
