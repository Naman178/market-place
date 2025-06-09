<?php

namespace App\Http\Controllers\User;

use App\helper\helper;
use App\Http\Controllers\Controller;
use App\Models\InvoiceModel;
use App\Models\Items;
use App\Models\Subscription;
use App\Models\SubscriptionRec;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;
use App\Mail\SendPassWordReset;
use App\Models\Transaction;
use App\Mail\SendInquiry;
use App\Mail\SendInquiryAdmin;
use App\Models\SEO;
use App\Models\WoocommerceOrderHistory;
use App\Models\Order;
use App\Models\Wallet;
use App\Models\UserCustomer;
use Symfony\Component\HttpFoundation\Response;
use Spatie\Permission\Models\Role;
use DB;
use App\Models\UserInquiry;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
class UserController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index','show']]);
        $this->middleware('permission:user-create', ['only' => ['edit','store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit','store']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
        $this->middleware('permission:user-tab-show', ['only' => ['index' , 'show' , 'edit' , 'store', 'destroy']]);
    }
    public function index()
    {
        $user = User::where('sys_state','!=','-1')->orderBy('id','desc')->get();
        return view('pages.user.user',compact('user'));
    }

    public function edit($id)
    {
        $user = User::with('roles')->where('id',$id)->first();
        $roles = Role::pluck('name','name')->all();
        return view('pages.user.edit',compact('user','roles'));
    }

    public function store(Request $request){
        if($request->ajax()){
            if($request->id == "0"){
                $existingUser = User::where('email', $request->email)->first();

                $emailRules = ['email']; 

                if ($existingUser && $existingUser->sys_state == -1) {
                    $emailRules = ['email'];
                }
                else{
                    $emailRules = ['email', Rule::unique('users')];
                }
                $validator = Validator::make($request->all(), [
                    'fname' => 'required',
                    'lname' => 'required',
                    'email' => $emailRules,
                    'password' => 'required|same:confirm_password|min:6',
                    'roles' => 'required',
                ]);
                if ($validator->passes()){
                    $name = $request->fname .' '.$request->lname;
                    $fname = $request->fname;
                    $lname = $request->lname;
                    $email = $request->email;
                    $password = Hash::make($request->password);
                    $status = $request->status;

                    $save_user = User::create(['name'=>$name , 'email'=>$email , 'fname'=> $fname , 'lname'=>$lname ,'status'=>$status ,'password'=>$password]);
                    $save_user->assignRole($request->roles);

                    $email = $request->email;

                    $mailData = [
                        'title' => 'Registration Successful !',
                        'email' => $request->email,
                        'password' => $request->password,
                        'url' => url('/login')
                    ];

                    Mail::to($email)->send(new SendEmail($mailData));
                    session()->flash('success', 'User created successfully!');
                    return response()->json([
                        'success' => 'User created successfully!',
                        'title' => 'User',
                        'type' => 'create',
                        'data' => $save_user
                    ], Response::HTTP_OK);
                }
                else{
                    return response()->json(['error'=>$validator->getMessageBag()->toArray()]);
                }
            }else{
                $validator = Validator::make($request->all(), [
                    'fname' => 'required',
                    'lname' => 'required',
                    'roles' => 'required'
                ]);
                if ($validator->passes()){
                    $user = User::find($request->id);

                    $fname = $request->fname;
                    $lname = $request->lname;
                    $status = $request->status;

                    $user->update(['fname'=> $fname , 'lname'=>$lname , 'status' => $status]);

                    DB::table('model_has_roles')->where('model_id',$request->id)->delete();
                    $user->assignRole($request->roles);
                    session()->flash('user_status_update', [
                        'user_id' => $user->id,
                        'status' => $request->status,
                    ]);
                    session()->flash('success', 'User Updated successfully!');
                    return response()->json([
                        'success' => 'User updated successfully!',
                        'title' => 'User',
                        'type' => 'update',
                        'data' => $user
                    ]);
                }
                else{
                    return response()->json(['error'=>$validator->getMessageBag()->toArray()]);
                }
            }
        }
    }

    public function remove($id)
    {
        try{
            $model = new User();
            helper::sysDelete($model,$id);
            return redirect()->back()
                ->with([
                    'success' => 'User deleted successfully!',
                    'title' => 'User'
                ]);
        }catch(Exception $e){
            return redirect()->back()
                ->with([
                    'error' => $e->getMessage(),
                    'title' => 'User'
                ]);
        }
    }

    public function sendResetPassword($email){
        
        $token = Str::random(64);

        $pass_reset = DB::table('password_resets')->where('email',$email)->first();

        if($pass_reset){
            DB::table('password_resets')->where('email',$email)
            ->update([
                'token' => bcrypt($token),
                'created_at' => Carbon::now()
            ]);
        }
        else{
            DB::table('password_resets')->insert([
                'email' => $email,
                'token' => bcrypt($token),
                'created_at' => Carbon::now()
            ]);
        }
       
        if ($this->sendResetEmail($email, $token)) {
            return redirect()->back()
                ->with([
                    'success' => 'A reset link has been sent to the email address.',
                    'title' => 'User'
                ]);
        } else {
            return redirect()->back()
                ->with([
                    'error' => 'A Network Error occurred. Please try again.',
                    'title' => 'User'
                ]);
        }
    }
    private function sendResetEmail($email, $token)
    {        

        $link = url('/password/reset/' . $token . '?email=' . urlencode($email));
        
        try {
            $mailData = [
                'title' => 'Hello!',
                'url' => $link
            ];
            Mail::to($email)->send(new SendPassWordReset($mailData));            
            return true;

        } catch (\Exception $e) {
            return false;
        }
    }

    public function contactUs(Request $request){
        if($request->ajax()){
            // $validator = Validator::make($request->all(), [
            //     'full_name' => 'required',
            //     'email' => 'required|email',
            //     'contact_number' => 'required|numeric',
            //     'website_url' => 'required|url',
            //     'message' => 'required',
            // ], [
            //     'full_name.required' => 'Full Name is required.',
            //     'email.required' => 'Email is required.',
            //     'email.email' => 'Please provide a valid email address.',
            //     'contact_number.required' => 'Contact Number is required.',
            //     'website_url.required' => 'Website URL is required.',
            //     'website_url.url' => 'Please provide a valid URL in the format: https://market-place-main.infinty-stage.com.',
            //     'message.required' => 'Message is required.',
            // ]);
            // if ($validator->fails()){
            //     return response()->json(['error'=>$validator->getMessageBag()->toArray()]);
            // }
            // else{
                $full_name = $request->full_name;
                $email = $request->email;
                $contact_number = $request->contact_number;
                $website_url = $request->website_url;
                $message = $request->message;
                $stack = $request->stack;

                $userinquiry = UserInquiry::create([
                    'full_name'=>$full_name, 
                    'email'=>$email , 
                    'contact_number'=> $contact_number , 
                    'website_url'=>$website_url,
                    'message'=>$message ,
                    'stack'=>$stack
                ]);

                $mailData = [
                    'title' => 'Thank You!',
                    'full_name' => $full_name,
                    'email' => $email,
                    'contact_number' => $contact_number,
                    'website_url' => $website_url,
                    'message' => $message,
                    'stack' => $stack,
                ];

                Mail::to($email)->send(new SendInquiry($mailData));

                Mail::to('info@infinitysoftech.co')->send(new SendInquiryAdmin($mailData));

                session()->flash('success', 'ThankYou For Your Inquiry We Will Contact You Soon !');
                return response()->json([
                    'success' => 'Inquiry added successfully!',
                    'title' => 'Inquiry',
                    'type' => 'Add',
                    'data' => $userinquiry
                ]);
            // }        
        }
    }
    public function userDashboard(){
        $user = auth()->user();
        $user_id = $user['id'];
        $wallet = Wallet::where('user_id',$user['id'])->first();
        $transactions = Transaction::where('user_id',$user['id'])->orderBy('id', 'desc')->get();
        $orders = Order::where('user_id',$user['id'])
            ->with(['product','key'])
            ->get();
        $order_history = WoocommerceOrderHistory::where('user_id',$user['id'])->orderBy('id', 'desc')->get();
        $woo_user = UserCustomer::where('register_under_user_id',$user['id'])->get();
        $allplan = Items::where('sys_state','!=','-1')->orderBy('id','asc')->get();
        $invoice = InvoiceModel::where('user_id',$user['id'])->get();
        $subscription = Subscription::where('user_id',$user['id'])->with('product')->get();

        return view('dashboard.user-dashboard',compact('orders','wallet','transactions','subscription','invoice','order_history','allplan','woo_user'));
    }
    public function user_price()
    {
        $data['items'] = Items::with(['features', 'tags', 'images', 'categorySubcategory', 'pricing'])->where('sys_state','!=','-1')->orderBy('id','desc')->get();
        $seoData = SEO::where('page','price')->first();
        return view('pages.Home.Price',compact('data','seoData'));
    }

    public function orders() {
        $orders = Order::with('subscription')
                    ->where('user_id', auth()->id())
                    ->orderBy('id', 'desc')
                    ->get();
        
        return view('dashboard.orders', compact('orders'));
    }

    public function downloads() {
        $orders = Order::where('user_id', auth()->id())->orderBy('id', 'desc')->get();
        return view('dashboard.downloads', compact('orders'));
    }

    public function support() {
        $wallet = Wallet::where('user_id',auth()->id())->orderBy('id', 'desc')->first();
        return view('dashboard.support',compact('wallet'));
    }

    public function transactions() {
        $transactions = Transaction::where('user_id', auth()->id())->orderBy('id', 'desc')->get();
        return view('dashboard.transactions', compact('transactions'));
    }

    public function invoice() {
        $invoice = InvoiceModel::where('user_id',auth()->id())->orderBy('id', 'desc')->get();
        return view('dashboard.invoice',compact('invoice'));
    }

    public function subscription() {
        $subscription = SubscriptionRec::orderBy('id', 'desc')->get();
        // $subscription = SubscriptionRec::where('user_id',auth()->id())->with('product')->get();
        return view('dashboard.subscription',compact('subscription'));
    }

    public function settings() {
        return view('dashboard.settings');
    }

}
