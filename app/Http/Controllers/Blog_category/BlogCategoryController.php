<?php

namespace App\Http\Controllers\Blog_category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog_category;
use App\Models\SEO;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;
use DB;

class BlogCategoryController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:Blog_category-list|Blog_category-create|Blog_category-edit|Blog_category-delete', ['only' => ['index','show']]);
        $this->middleware('permission:Blog_category-create', ['only' => ['edit','store']]);
        $this->middleware('permission:Blog_category-edit', ['only' => ['edit','store']]);
        $this->middleware('permission:Blog_category-delete', ['only' => ['destroy']]);
        $this->middleware('permission:Blog_category-tab-show', ['only' => ['index' , 'show' , 'edit' , 'store', 'destroy']]);
    }
    public function index()
    {
        $Blog_category = Blog_category::orderBy('blog_category.category_id', 'asc')
                            ->get();
        return view('pages.BlogCategory.Blog_category',compact('Blog_category'));
    }

    public function edit($id)
    {
        $Blog_category = Blog_category::where('category_id',$id)->first();

        return view('pages.BlogCategory.edit',compact('Blog_category'));
    }

    public function store(Request $request){
        if($request->ajax()){
            $validator = $this->validateRequest($request);
            if ($validator->passes()){
                if($request->scid == "0"){
                    
                    // Handle file upload
                   
                    if ($request->hasFile('image')) {
                        $originalImageName = $request->file('image')->getClientOriginalName();

                        $destinationPath = public_path('storage/images/');

                        $request->file('image')->move($destinationPath, $originalImageName);
                    }
                    $save_Blog_category = Blog_category::create([
                        'name' => $request->name,
                        'description' => $request->description,
                        'image' => $originalImageName ?? null,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);

                    session()->flash('success', trans('custom.Blog_category_create_success'));
                    return response()->json([
                        'success' => trans('custom.Blog_category_create_success'),
                        'title' => trans('custom.Blog_category_title'),
                        'type' => 'create',
                        'data' => $save_Blog_category
                    ], Response::HTTP_OK);
                }else{
                    $Blog_category = Blog_category::where('category_id',$request->scid);

                    if ($request->hasFile('image')) {
                        $originalImageName = $request->file('image')->getClientOriginalName();
                        $destinationPath = public_path('storage/images/');
                    
                        $request->file('image')->move($destinationPath, $originalImageName);
                    } else {
                        $originalImageName = $request->old_image;  
                    }
                    $Blog_category->update([
                        'name' => $request->name,
                        'description' => $request->description,
                        'image' => $originalImageName,
                        'updated_at' => Carbon::now(),
                    ]);

                    session()->flash('success', trans('custom.Blog_category_update_success'));
                    return response()->json([
                        'success' => trans('custom.Blog_category_update_success'),
                        'title' => trans('custom.Blog_category_title'),
                        'type' => 'update',
                        'data' => $Blog_category
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
            'name' => 'required|string|max:255',
            // 'description' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
             'description' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (trim(strip_tags($value)) === '') {
                        $fail('The description field is required.');
                    }
                },
            ],
        ];
        return Validator::make($request->all(), $rules);
    }
 

    public function remove($id)
    {
        DB::table("blog_category")->where('category_id',$id)->delete();
        return redirect()->back()
        ->with([
            'success' => trans('custom.Blog_category_delete_success'),
            'title' => trans('custom.Blog_category_title')
        ]);
    }
}
