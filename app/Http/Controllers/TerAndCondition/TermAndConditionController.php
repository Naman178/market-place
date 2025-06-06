<?php

namespace App\Http\Controllers\TerAndCondition;

use App\Http\Controllers\Controller;
use App\Models\TermCondition;
use App\Models\SEO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;
use DB;
class TermAndConditionController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:term-condition-list|term-condition-create|term-condition-edit|term-condition-delete', ['only' => ['index','show']]);
        $this->middleware('permission:term-condition-create', ['only' => ['edit','store']]);
        $this->middleware('permission:term-condition-edit', ['only' => ['edit','store']]);
        $this->middleware('permission:term-condition-delete', ['only' => ['destroy']]);
        $this->middleware('permission:term-condition-tab-show', ['only' => ['index' , 'show' , 'edit' , 'store', 'destroy']]);
    }
    public function index()
    {
        $term_condition = TermCondition::orderBy('term_and_condition.id', 'asc')
                            ->get();
        return view('pages.term-condition.term-condition',compact('term_condition'));
    }

    public function edit($id)
    {
        $term_condition = TermCondition::where('id',$id)->first();

        return view('pages.term-condition.edit',compact('term_condition'));
    }

    public function store(Request $request){
        if($request->ajax()){
            $validator = $this->validateRequest($request);
            if ($validator->passes()){
                if($request->scid == "0"){
                    $save_term_condition = TermCondition::create([
                        'title' => $request->title,
                        'description' => $request->description,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);

                    session()->flash('success', trans('custom.term_condition_create_success'));
                    return response()->json([
                        'success' => trans('custom.term_condition_create_success'),
                        'title' => trans('custom.term_condition_title'),
                        'type' => 'create',
                        'data' => $save_term_condition
                    ], Response::HTTP_OK);
                }else{
                    $term_condition = TermCondition::find($request->scid);

                    $term_condition->update([
                        'title' => $request->title,
                        'description' => $request->description,
                        'updated_at' => Carbon::now(),
                    ]);

                    session()->flash('success', trans('custom.term_condition_update_success'));
                    return response()->json([
                        'success' => trans('custom.term_condition_update_success'),
                        'title' => trans('custom.term_condition_title'),
                        'type' => 'update',
                        'data' => $term_condition
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
            'name' => 'required',
            'description' => 'required',
        ];
        return Validator::make($request->all(), $rules);
    }
 

    public function remove($id)
    {
        DB::table("term_and_condition")->where('id',$id)->delete();
        return redirect()->back()
        ->with([
            'success' => trans('custom.term_condition_delete_success'),
            'title' => trans('custom.term_condition_title')
        ]);
    }

    public function user_index()
    {
        $term_conditions = TermCondition::get();
        $seoData = SEO::where('page','term and condition')->first();
        return view('pages.Home.TermsAndCondition',compact('term_conditions','seoData'));
    }
}
