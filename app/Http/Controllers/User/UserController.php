<?php

namespace App\Http\Controllers\User;

use App\helper\helper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;
use App\Mail\SendPassWordReset;
use Symfony\Component\HttpFoundation\Response;
use Spatie\Permission\Models\Role;
use DB;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Carbon\Carbon;

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
                $validator = Validator::make($request->all(), [
                    'fname' => 'required',
                    'lname' => 'required',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required|same:confirm_password|min:6',
                    'roles' => 'required'
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
}
