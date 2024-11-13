<?php

namespace App\Http\Controllers\FAQ;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FAQ;
use App\Models\SEO;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;
use DB;

class FAQController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:FAQ-list|FAQ-create|FAQ-edit|FAQ-delete', ['only' => ['index','show']]);
        $this->middleware('permission:FAQ-create', ['only' => ['edit','store']]);
        $this->middleware('permission:FAQ-edit', ['only' => ['edit','store']]);
        $this->middleware('permission:FAQ-delete', ['only' => ['destroy']]);
        $this->middleware('permission:FAQ-tab-show', ['only' => ['index' , 'show' , 'edit' , 'store', 'destroy']]);
    }
    public function index()
    {
        $FAQ = FAQ::orderBy('faq.id', 'desc')
                            ->get();
        return view('pages.FAQ.FAQ',compact('FAQ'));
    }

    public function edit($id)
    {
        $FAQ = FAQ::where('id',$id)->first();

        return view('pages.FAQ.edit',compact('FAQ'));
    }

    public function store(Request $request){
        if($request->ajax()){
            $validator = $this->validateRequest($request);
            if ($validator->passes()){
                if($request->scid == "0"){
                    $save_FAQ = FAQ::create([
                        'question' => $request->question,
                        'answer' => $request->answer,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);

                    session()->flash('success', trans('custom.FAQ_create_success'));
                    return response()->json([
                        'success' => trans('custom.FAQ_create_success'),
                        'title' => trans('custom.FAQ_title'),
                        'type' => 'create',
                        'data' => $save_FAQ
                    ], Response::HTTP_OK);
                }else{
                    $FAQ = FAQ::find($request->scid);

                    $FAQ->update([
                        'question' => $request->question,
                        'answer' => $request->answer,
                        'updated_at' => Carbon::now(),
                    ]);

                    session()->flash('success', trans('custom.FAQ_update_success'));
                    return response()->json([
                        'success' => trans('custom.FAQ_update_success'),
                        'title' => trans('custom.FAQ_title'),
                        'type' => 'update',
                        'data' => $FAQ
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
            'question' => 'required',
            'answer' => 'required',
        ];
        return Validator::make($request->all(), $rules);
    }
 

    public function remove($id)
    {
        DB::table("faq")->where('id',$id)->delete();
        return redirect()->back()
        ->with([
            'success' => trans('custom.FAQ_delete_success'),
            'title' => trans('custom.FAQ_title')
        ]);
    }

    public function user_index()
    {
        $FAQs = FAQ::get();
        $seoData = SEO::where('page','faq')->first();
        return view('pages.Home.FAQ',compact('FAQs','seoData'));
    }
}
