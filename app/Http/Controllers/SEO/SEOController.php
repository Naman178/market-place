<?php

namespace App\Http\Controllers\SEO;

use App\Http\Controllers\Controller;
use App\Models\SEO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;
use DB;
class SEOController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:SEO-list|SEO-create|SEO-edit|SEO-delete', ['only' => ['index','show']]);
        $this->middleware('permission:SEO-create', ['only' => ['edit','store']]);
        $this->middleware('permission:SEO-edit', ['only' => ['edit','store']]);
        $this->middleware('permission:SEO-delete', ['only' => ['destroy']]);
        $this->middleware('permission:SEO-tab-show', ['only' => ['index' , 'show' , 'edit' , 'store', 'destroy']]);
    }
    public function index()
    {
        $SEO = SEO::orderBy('seo.id', 'asc')
                            ->get();
        return view('pages.SEO.SEO',compact('SEO'));
    }

    public function edit($id)
    {
        $SEO = SEO::where('id',$id)->first();

        return view('pages.SEO.edit',compact('SEO'));
    }

    public function store(Request $request){
        if($request->ajax()){
            $validator = $this->validateRequest($request);
            if ($validator->passes()){
                if($request->scid == "0"){
                    $save_SEO = SEO::create([
                        'page' => $request->page,
                        'title' => $request->title,
                        'description' => $request->description,
                        'keyword' => $request->keyword,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);

                    session()->flash('success', trans('custom.SEO_create_success'));
                    return response()->json([
                        'success' => trans('custom.SEO_create_success'),
                        'title' => trans('custom.SEO_title'),
                        'type' => 'create',
                        'data' => $save_SEO
                    ], Response::HTTP_OK);
                }else{
                    $SEO = SEO::find($request->scid);

                    $SEO->update([
                        'page' => $request->page,
                        'title' => $request->title,
                        'description' => $request->description,
                        'keyword' => $request->keyword,
                        'updated_at' => Carbon::now(),
                    ]);

                    session()->flash('success', trans('custom.SEO_update_success'));
                    return response()->json([
                        'success' => trans('custom.SEO_update_success'),
                        'title' => trans('custom.SEO_title'),
                        'type' => 'update',
                        'data' => $SEO
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
            'page' => 'required',
            'description' => 'required',
            'keyword'   => 'required',
        ];
        return Validator::make($request->all(), $rules);
    }
 

    public function remove($id)
    {
        DB::table("seo")->where('id',$id)->delete();
        return redirect()->back()
        ->with([
            'success' => trans('custom.SEO_delete_success'),
            'title' => trans('custom.SEO_title')
        ]);
    }

}
