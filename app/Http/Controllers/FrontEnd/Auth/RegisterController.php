<?php

namespace App\Http\Controllers\FrontEnd\Auth;

use App\Http\Controllers\Controller;
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
            $validator = Validator::make($request->all(), [
                'firstname' => 'required',
                'lastname' => 'required',
                'email' => 'required|email|unique:users',
                'country_code' => 'required',
                'contact' => 'required',
                'country' => 'required',
                'address_line_one' => 'required',
                'city' => 'required',
                'postal' => 'required',
                'company_name' => 'required',
                'company_website' => 'required'
            ],
            $message = [                
                'firstname.required' => 'The First Name Is Required.',
                'lastname.required' => 'The Lsat Name Is Required.',
                'email.required' => 'The Email Is Required.',
                'country_code.required' => 'The Country Code Is Required.',
                'contact.required' => 'The Contact Number Is Required.',
                'country.required' => 'The Country Is Required.',
                'address_line_one.required' => 'The Address Line One Is Required.',
                'city.required' => 'The City Is Required.',
                'postal.required' => 'The Postal Code Is Required.',
                'company_name.required' => 'The Company Name is required.',
                'company_website.required' => 'The Company Website is required.',
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
    }
    
    public function postRegistration(Request $request)
    {
        $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required|email|unique:users',
            'contact' => 'required',
            'password' => 'required|min:6|same:confirm_password',
        ]);
        
        $name = $request['fname'] .' '.$request['lname'];
        $fname = $request['fname'];
        $lname = $request['lname'];
        $email = $request['email'];
        $country_code = $request['country_code'];
        $contact = $request['contact'];
        $mobile = '+'.$country_code.$contact;
        $company_name = $request['company_name'];
        $company_website = $request['company_website'];
        $country = $request['country'];
        $address_line_one = $request['address_line_one'];
        $address_line_two = $request['address_line_two'];
        $city = $request['city'];
        $postal = $request['postal'];
        $gst = $request['gst'];
        
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

        Mail::to($email)->send(new WelcomeEmail($mailData));


        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect("user-dashboard")->withSuccess('Great! You have Successfully loggedin');
        }
    }
}
