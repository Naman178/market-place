<?php

namespace App\Http\Controllers\PrivacyPolicy;

use App\Http\Controllers\Controller;
use App\Models\PrivacyPolicy;
use App\Models\SEO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;
use DB;

class PrivacyPolicyController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:privacy-policy-list|privacy-policy-create|privacy-policy-edit|privacy-policy-delete', ['only' => ['index','show']]);
        $this->middleware('permission:privacy-policy-create', ['only' => ['edit','store']]);
        $this->middleware('permission:privacy-policy-edit', ['only' => ['edit','store']]);
        $this->middleware('permission:privacy-policy-delete', ['only' => ['destroy']]);
        $this->middleware('permission:privacy-policy-tab-show', ['only' => ['index' , 'show' , 'edit' , 'store', 'destroy']]);
    }
    public function index()
    {
        $privacy_policy = PrivacyPolicy::orderBy('privacy_policy.id', 'asc')
                            ->get();
        return view('pages.privacy-policy.privacy-policy',compact('privacy_policy'));
    }

    public function edit($id)
    {
        $privacy_policy = PrivacyPolicy::where('id',$id)->first();

        return view('pages.privacy-policy.edit',compact('privacy_policy'));
    }

    public function store(Request $request){
        if($request->ajax()){
            $validator = $this->validateRequest($request);
            if ($validator->passes()){
                if($request->scid == "0"){
                    $save_privacy_policy = PrivacyPolicy::create([
                        'title' => $request->title,
                        'description' => $request->description,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);

                    session()->flash('success', trans('custom.privacy_policy_create_success'));
                    return response()->json([
                        'success' => trans('custom.privacy_policy_create_success'),
                        'title' => trans('custom.privacy_policy_title'),
                        'type' => 'create',
                        'data' => $save_privacy_policy
                    ], Response::HTTP_OK);
                }else{
                    $privacy_policy = PrivacyPolicy::find($request->scid);

                    $privacy_policy->update([
                        'title' => $request->title,
                        'description' => $request->description,
                        'updated_at' => Carbon::now(),
                    ]);

                    session()->flash('success', trans('custom.privacy_policy_update_success'));
                    return response()->json([
                        'success' => trans('custom.privacy_policy_update_success'),
                        'title' => trans('custom.privacy_policy_title'),
                        'type' => 'update',
                        'data' => $privacy_policy
                    ]);
                }
            }else{
                return response()->json(['error'=>$validator->getMessageBag()->toArray()]);
            }
        }
    }

    private function validateRequest(Request $request)
    {
        $rules = [
            'title' => 'required',
            // 'description' => 'required',
        ];
        return Validator::make($request->all(), $rules);
    }
 

    public function remove($id)
    {
        DB::table("privacy_policy")->where('id',$id)->delete();
        return redirect()->back()
        ->with([
            'success' => trans('custom.privacy_policy_delete_success'),
            'title' => trans('custom.privacy_policy_title')
        ]);
    }

    public function user_index()
    {
        $privacy_policies = PrivacyPolicy::get();
        $seoData = SEO::where('page','privacy policy')->first();
        return view('pages.Home.PrivacyPolicy',compact('privacy_policies','seoData'));
    }
}
