<?php

namespace App\Http\Controllers\SubCategory;

use App\helper\helper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class SubCategoryController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:sub-category-list|sub-category-create|sub-category-edit|sub-category-delete', ['only' => ['index','show']]);
        $this->middleware('permission:sub-category-create', ['only' => ['edit','store']]);
        $this->middleware('permission:sub-category-edit', ['only' => ['edit','store']]);
        $this->middleware('permission:sub-category-delete', ['only' => ['destroy']]);
        $this->middleware('permission:sub-category-tab-show', ['only' => ['index' , 'show' , 'edit' , 'store', 'destroy']]);
    }
    public function index()
    {
        $sub_categories = SubCategory::join('categories__tbl', 'sub_categories__tbl.category_id', '=', 'categories__tbl.id')->select('sub_categories__tbl.*', 'categories__tbl.name as category_name')
                            ->where('sub_categories__tbl.sys_state', '!=', '-1')
                            ->orderBy('sub_categories__tbl.id', 'desc')
                            ->get();
        return view('pages.sub-category.sub-category',compact('sub_categories'));
    }

    public function edit($id)
    {
        $sub_category = SubCategory::where('id',$id)->first();
        $categories = Category::where('sys_state', '0')->pluck('name', 'id')->all();

        return view('pages.sub-category.edit',compact('sub_category','categories'));
    }

    public function store(Request $request){
        if($request->ajax()){
            $validator = $this->validateRequest($request);
            if ($validator->passes()){
                if($request->scid == "0"){
                    $image = $this->uploadImage($request->image);

                    $save_sub_category = SubCategory::create([
                        'category_id' => $request->parent_category_id,
                        'name' => $request->name,
                        'image' => $image,
                        'sys_state' => $request->status,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);

                    session()->flash('success', trans('custom.sub_category_create_success'));
                    return response()->json([
                        'success' => trans('custom.sub_category_create_success'),
                        'title' => trans('custom.sub_category_title'),
                        'type' => 'create',
                        'data' => $save_sub_category
                    ], Response::HTTP_OK);
                }else{
                    $sub_category = SubCategory::find($request->scid);
                    $image = $request->hasFile('image') ? $this->uploadImage($request->image) : $request->old_image;

                    $sub_category->update([
                        'category_id' => $request->parent_category_id,
                        'name' => $request->name,
                        'image' => $image,
                        'sys_state' => $request->status,
                        'updated_at' => Carbon::now(),
                    ]);

                    session()->flash('success', trans('custom.sub_category_update_success'));
                    return response()->json([
                        'success' => trans('custom.sub_category_update_success'),
                        'title' => trans('custom.sub_category_title'),
                        'type' => 'update',
                        'data' => $sub_category
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

        if ($request->scid == "0") {
            $rules['parent_category_id'] = 'required';
            $rules['image'] = 'required';
        }

        return Validator::make($request->all(), $rules);
    }

    private function uploadImage($file)
    {
        $image = $file ? uniqid() . '_' . trim($file->getClientOriginalName()) : '';
        $image ? $file->move(public_path('storage/sub_category_images/'), $image) : '';

        return $image;
    }

    public function remove($id)
    {
        try{
            $model = new SubCategory();
            helper::sysDelete($model,$id);
            return redirect()->back()
                ->with([
                    'success' => trans('custom.sub_category_delete_success'),
                    'title' => trans('custom.sub_category_title')
                ]);
        }catch(Exception $e){
            return redirect()->back()
                ->with([
                    'error' => $e->getMessage(),
                    'title' => trans('custom.sub_category_title')
                ]);
        }
    }

    public function changeStatus(Request $request, $id){
        $category = SubCategory::find($id);
        $category->update([
            "sys_state" => $request->status
        ]);

        return response()->json([
            "success" => true,
            "data" => $category
        ]);
    }
}
