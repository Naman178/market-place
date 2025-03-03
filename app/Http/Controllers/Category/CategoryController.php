<?php

namespace App\Http\Controllers\Category;

use App\helper\helper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;
class CategoryController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:category-list|category-create|category-edit|category-delete', ['only' => ['index','show']]);
        $this->middleware('permission:category-create', ['only' => ['edit','store']]);
        $this->middleware('permission:category-edit', ['only' => ['edit','store']]);
        $this->middleware('permission:category-delete', ['only' => ['destroy']]);
        $this->middleware('permission:category-tab-show', ['only' => ['index' , 'show' , 'edit' , 'store', 'destroy']]);
    }
    public function index()
    {
        $category = Category::where('sys_state','!=','-1')->orderBy('id','desc')->get();
        return view('pages.category.category',compact('category'));
    }

    public function edit($id)
    {
        $category = Category::where('id',$id)->first();
        return view('pages.category.edit',compact('category'));
    }

    public function store(Request $request){
        if($request->ajax()){
            $validator = $this->validateRequest($request);
            if ($validator->passes()){
                if($request->cid == "0"){
                    $image = $this->uploadImage($request->image);

                    $save_category = Category::create([
                        'name'=>$request->name,
                        'image'=>$image,
                        'sys_state'=>$request->status,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);

                    session()->flash('success', trans('custom.category_create_success'));
                    return response()->json([
                        'success' => trans('custom.category_create_success'),
                        'title' => trans('custom.category_title'),
                        'type' => 'create',
                        'data' => $save_category
                    ], Response::HTTP_OK);
                }else{
                    $category = Category::find($request->cid);
                    $image = $request->hasFile('image') ? $this->uploadImage($request->image) : $request->old_image;

                    $category->update([
                        'name'=>$request->name,
                        'image'=>$image,
                        'sys_state'=>$request->status,
                        'updated_at' => Carbon::now()
                    ]);

                    session()->flash('success', trans('custom.category_update_success'));
                    return response()->json([
                        'success' => trans('custom.category_update_success'),
                        'title' => trans('custom.category_title'),
                        'type' => 'update',
                        'data' => $category
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
            'status' => 'required',
        ];

        if ($request->cid == "0") {
            $rules['image'] = 'required';
        }

        return Validator::make($request->all(), $rules);
    }

    private function uploadImage($file)
    {
        $image = $file ? uniqid() . '_' . trim($file->getClientOriginalName()) : '';
        $image ? $file->move(public_path('storage/category_images/'), $image) : '';

        return $image;
    }

    public function remove($id)
    {
        try{
            $hasSubcategories = SubCategory::where('category_id', $id)->exists();

            if ($hasSubcategories) {
                return redirect()->back()
                    ->with([
                        'error' => trans('custom.category_has_subcategories_error'),
                        'title' => trans('custom.category_title')
                    ]);
            }

            $model = new Category();
            helper::sysDelete($model,$id);
            return redirect()->back()
                ->with([
                    'success' => trans('custom.category_delete_success'),
                    'title' => trans('custom.category_title')
                ]);
        }catch(Exception $e){
            return redirect()->back()
                ->with([
                    'error' => $e->getMessage(),
                    'title' => trans('custom.category_title')
                ]);
        }
    }

    public function changeStatus(Request $request, $id){
        $category = Category::find($id);
        $category->update([
            "sys_state" => $request->status
        ]);

        return response()->json([
            "success" => true,
            "data" => $category
        ]);
    }

    public function show($id){
        $subcategory = SubCategory::where('category_id',$id)->where('sys_state','=','0')->get();
        return view('front-end.category.category',compact('subcategory'));
    }
}
