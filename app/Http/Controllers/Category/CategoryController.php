<?php

namespace App\Http\Controllers\Category;

use App\helper\helper;
use App\Http\Controllers\Controller;
use App\Models\Category;
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

    public function show($id)
    {
        $category = Category::where('id',$id)->first();
        return view('pages.category.show',compact('category'));
    }

    public function edit($id)
    {
        $category = Category::where('id',$id)->first();
        return view('pages.category.edit',compact('category'));
    }

    public function store(Request $request){
        
        if($request->ajax()){
            if($request->cid == "0"){
                $validator = Validator::make($request->all(), [
                    'name' => 'required',
                    'image' => 'required',
                    'status' => 'required'
                ]);
                if ($validator->passes()){
                    $name = $request->name;
                    $status = $request->status;

                    if($request->hasFile('image'))
                    {
                        $image = $request->image ? uniqid() . '_' . trim($request->image->getClientOriginalName()) : '';
                        $image ? $request->file('image')->move(public_path('storage/category_images/'),$image) : '';
                    }

                    $save_category = Category::create(['name'=>$name , 'image'=>$image, 'sys_state'=>$status, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
                    
                    session()->flash('success', 'Category created successfully!');
                    return response()->json([
                        'success' => 'Category created successfully!',
                        'title' => 'Category',
                        'type' => 'create',
                        'data' => $save_category
                    ], Response::HTTP_OK);
                }
                else{
                    return response()->json(['error'=>$validator->getMessageBag()->toArray()]);
                }
            }else{
                $validator = Validator::make($request->all(), [
                    'name' => 'required',
                    'status' => 'required'
                ]);
                if ($validator->passes()){
                    $category = Category::find($request->cid);
                    $name = $request->name;
                    $status = $request->status;
                    if($request->hasFile('image'))
                    {
                        $image = $request->image ? uniqid() . '_' . trim($request->image->getClientOriginalName()) : '';
                        $image ? $request->file('image')->move(public_path('storage/category_images/'),$image) : '';
                    }
                    else{
                        $image = $request->old_image;
                    }

                    $category->update(['name'=>$name , 'image'=>$image, 'sys_state'=>$status, 'updated_at' => Carbon::now()]);
                   
                    session()->flash('success', 'Category Updated successfully!');
                    return response()->json([
                        'success' => 'Category updated successfully!',
                        'title' => 'Category',
                        'type' => 'update',
                        'data' => $category
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
            $model = new Category();
            helper::sysDelete($model,$id);
            return redirect()->back()
                ->with([
                    'success' => 'Category deleted successfully!',
                    'title' => 'Category'
                ]);
        }catch(Exception $e){
            return redirect()->back()
                ->with([
                    'error' => $e->getMessage(),
                    'title' => 'Category'
                ]);
        }
    }
}
