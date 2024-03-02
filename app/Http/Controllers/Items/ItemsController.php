<?php

namespace App\Http\Controllers\Items;

use App\Http\Controllers\Controller;
use App\Models\Items;
use App\Models\Category;
use App\Models\ItemsCategorySubcategory;
use App\Models\SubCategory;
use App\Models\ItemsFeature;
use App\Models\ItemsImage;
use App\Models\ItemsPricing;
use App\Models\ItemsTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;

class ItemsController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:items-list|items-create|items-edit|items-delete', ['only' => ['index','show']]);
        $this->middleware('permission:items-create', ['only' => ['edit','store']]);
        $this->middleware('permission:items-edit', ['only' => ['edit','store']]);
        $this->middleware('permission:items-delete', ['only' => ['destroy']]);
        $this->middleware('permission:items-tab-show', ['only' => ['index' , 'show' , 'edit' , 'store', 'destroy']]);
    }
    public function index()
    {
        $items = Items::where('sys_state','!=','-1')->orderBy('id','desc')->get();
        return view('pages.items.items',compact('items'));
    }

    public function edit($id)
    {
        $item = Items::where('id',$id)->first();
        $categories = Category::where('sys_state', '0')->pluck('name', 'id')->all();
        $subcategories = SubCategory::where('sys_state', '0')->pluck('name', 'id')->all();
        return view('pages.items.edit',compact('item','categories','subcategories'));
    }

    public function store(Request $request){
        /* echo "<pre>";
        print_r($request->all());exit; */
        if($request->ajax()){
            $validator = $this->validateRequest($request);
            if ($validator->passes()){
                if($request->item_id == "0"){
                    $thumbnail = $this->uploadFile($request->item_thumbnail);
                    $mainFile = $this->uploadFile($request->item_main_file);

                    $save_item = Items::create([
                        'name' => $request->name,
                        'html_description' => $request->html_description,
                        'thumbnail_image' => $thumbnail,
                        'main_file_zip' => $mainFile,
                        'preview_url' => $request->preview_url,
                        'status' => '1',
                        'sys_state' => '0',
                        'created_at' => Carbon::now(),
                    ]);
                    if($save_item->id){
                        if(!empty($request->item_images)){
                            foreach ($request->item_images as $image) {
                                $itemImages = $this->uploadFile($image);
                                ItemsImage::create([
                                    'item_id' => $save_item->id,
                                    'image_path' => $itemImages,
                                    'created_at' => Carbon::now(),
                                ]);
                            }
                        }
                        if(!empty($request->key_feature)){
                            foreach ($request->key_feature as $feature) {
                                ItemsFeature::create([
                                    'item_id' => $save_item->id,
                                    'key_feature' =>$feature,
                                    'created_at' => Carbon::now(),
                                ]);
                            }
                        }

                        if(!empty($request->tag)){
                            foreach ($request->tag as $tag) {
                                ItemsTag::create([
                                    'item_id' => $save_item->id,
                                    'tag_name' =>$tag,
                                    'created_at' => Carbon::now(),
                                ]);
                            }
                        }

                        if(isset($request->category_id) && isset($request->subcategory_id)){
                            ItemsCategorySubcategory::create([
                                'item_id' => $save_item->id,
                                'category_id' =>$request->category_id,
                                'subcategory_id' =>$request->subcategory_id,
                                'created_at' => Carbon::now(),
                            ]);
                        }

                        ItemsPricing::create([
                            'item_id' => $save_item->id,
                            'fixed_price' =>$request->fixed_price,
                            'sale_price' =>$request->sale_price,
                            'gst_percentage' =>$request->gst_percentage,
                            'created_at' => Carbon::now(),
                        ]);
                    }else{
                        return response()->json(['error'=> trans('custom.items_create_fail')]);
                    }
                    session()->flash('success', trans('custom.sub_category_create_success'));
                    return response()->json([
                        'success' => trans('custom.sub_category_create_success'),
                        'title' => trans('custom.sub_category_title'),
                        'type' => 'create',
                        'data' => $save_item
                    ], Response::HTTP_OK);
                }else{
                    $sub_category = SubCategory::find($request->item_id);
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
            'fixed_price' => 'required',
            'category_id' => 'required',
            'subcategory_id' => 'required',
        ];
        
        return Validator::make($request->all(), $rules);
    }

    private function uploadFile($file)
    {
        $file_data = $file ? uniqid() . '_' . trim($file->getClientOriginalName()) : '';
        $file_data ? $file->move(public_path('storage/items_files/'), $file_data) : '';

        return $file_data;
    }

    public function changeStatus(Request $request, $id){
        $item = Items::find($id);
        $item->update([
            "status" => $request->status,
            "sys_state" => $request->status=='1'?'0':'1'
        ]);

        return response()->json([
            "success" => true,
            "data" => $item
        ]);
    }

}
