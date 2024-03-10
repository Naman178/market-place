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
use App\helper\helper;
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
        $item = Items::with(['features', 'tags', 'images', 'categorySubcategory', 'pricing'])->where('id', $id)->first();
        $categories = Category::where('sys_state', '0')->pluck('name', 'id')->all();
        $subcategories = SubCategory::where('sys_state', '0')->get(['id', 'name', 'category_id']);
        return view('pages.items.edit',compact('item','categories','subcategories'));
    }

    public function store(Request $request){
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
                        // IMAGES
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

                        // FEATURES
                        if(!empty($request->key_feature)){
                            foreach ($request->key_feature as $feature) {
                                ItemsFeature::create([
                                    'item_id' => $save_item->id,
                                    'key_feature' =>$feature,
                                    'created_at' => Carbon::now(),
                                ]);
                            }
                        }

                        // TAGS
                        if(!empty($request->tag)){
                            foreach ($request->tag as $tag) {
                                ItemsTag::create([
                                    'item_id' => $save_item->id,
                                    'tag_name' =>$tag,
                                    'created_at' => Carbon::now(),
                                ]);
                            }
                        }

                        // CATEGORY AND SUBCATEGORY
                        if(isset($request->category_id) && isset($request->subcategory_id)){
                            ItemsCategorySubcategory::create([
                                'item_id' => $save_item->id,
                                'category_id' =>$request->category_id,
                                'subcategory_id' =>$request->subcategory_id,
                                'created_at' => Carbon::now(),
                            ]);
                        }

                        // PRICING
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
                    session()->flash('success', trans('custom.items_create_success'));
                    return response()->json([
                        'success' => trans('custom.items_create_success'),
                        'title' => trans('custom.item_title'),
                        'type' => 'create',
                        'data' => $save_item
                    ], Response::HTTP_OK);
                }else{
                    $item = Items::find($request->item_id);

                    $thumbnail = $request->hasFile('item_thumbnail') ? $this->uploadFile($request->item_thumbnail) : $request->old_thumbnail_image;
                    $mainFile = $request->hasFile('item_main_file') ? $this->uploadFile($request->item_main_file) : $request->old_main_file;

                    $item->update([
                        'name' => $request->name,
                        'html_description' => $request->html_description,
                        'thumbnail_image' => $thumbnail,
                        'main_file_zip' => $mainFile,
                        'preview_url' => $request->preview_url,
                        'status' => $request->status,
                        'sys_state' => '0',
                        'updated_at' => Carbon::now(),
                    ]);
                    if ($item->id) {
                        $item->tags()->delete();
                        $item->features()->delete();
                        $item->images()->delete();

                        // IMAGES
                        $oldImages = $request->old_image ?? [];
                        $newImages = $request->item_images ?? [];

                        $mergedImages = [];
                        $uniqueIndices = array_unique(array_merge(array_keys($oldImages), array_keys($newImages)));

                        foreach ($uniqueIndices as $index) {
                            if (isset($newImages[$index])) {
                                $itemImages = $newImages[$index] ? $this->uploadFile($newImages[$index]) : null;
                            } elseif (isset($oldImages[$index])) {
                                $itemImages = $oldImages[$index];
                            } else {
                                continue;
                            }

                            $mergedImages[] = [
                                'item_id' => $item->id,
                                'image_path' => $itemImages,
                                'updated_at' => Carbon::now(),
                            ];
                        }

                        foreach ($mergedImages as $imageData) {
                            ItemsImage::create($imageData);
                        }

                        // FEATURES
                        if (!empty($request->key_feature)) {
                            foreach ($request->key_feature as $feature) {
                                ItemsFeature::create([
                                    'item_id' => $item->id,
                                    'key_feature' =>$feature,
                                    'updated_at' => Carbon::now(),
                                ]);
                            }
                        }

                        // TAGS
                        if(!empty($request->tag)){
                            foreach ($request->tag as $tag) {
                                if($tag != ''){
                                    ItemsTag::create([
                                        'item_id' => $item->id,
                                        'tag_name' =>$tag,
                                        'updated_at' => Carbon::now(),
                                    ]);
                                }
                            }
                        }

                        // CATEGORY AND SUBCATEGORY
                        if (isset($request->category_id) && isset($request->subcategory_id)) {
                            $existingCategorySubcategory = ItemsCategorySubcategory::where('item_id', $item->id)->first();
                        
                            if ($existingCategorySubcategory) {
                                $existingCategorySubcategory->update([
                                    'category_id' => $request->category_id,
                                    'subcategory_id' => $request->subcategory_id,
                                    'updated_at' => Carbon::now(),
                                ]);
                            }
                        }

                        // PRICING
                        $existingPricing = ItemsPricing::where('item_id', $item->id)->first();
                        if ($existingPricing) {
                            $existingPricing->update([
                                'fixed_price' => $request->fixed_price,
                                'sale_price' => $request->sale_price,
                                'gst_percentage' => $request->gst_percentage,
                                'updated_at' => Carbon::now(),
                            ]);
                        }
                    }
                    session()->flash('success', trans('custom.items_update_success'));
                    return response()->json([
                        'success' => trans('custom.items_update_success'),
                        'title' => trans('custom.item_title'),
                        'type' => 'update',
                        'data' => $item
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
            'preview_url' => 'required',
            'html_description' => 'required',
            'key_feature' => 'required|array',
            'key_feature.*' => 'required_without_all: key_feature',
            'category_id' => 'required',
            'subcategory_id' => 'required',
            'fixed_price' => 'required|numeric',
            'sale_price' => 'numeric|nullable',
            'gst_percentage' => 'numeric|nullable'            
        ];

        if ($request->item_id == "0") {
            $rules['item_thumbnail'] = 'required';
            $rules['item_main_file'] = 'required';
        }

        $customMessages = [
            'key_feature.*.required_without_all' => 'At least one feature is required.',
            'html_description.required' => 'The description field is required.',
            'category_id.required' => 'The category field is required.',
            'subcategory_id.required' => 'The subcategory field is required.'
        ];
        
        return Validator::make($request->all(), $rules, $customMessages);
    }

    private function uploadFile($file)
    {
        $file_data = $file ? uniqid() . '_' . trim($file->getClientOriginalName()) : '';
        $file_data ? $file->move(public_path('storage/items_files/'), $file_data) : '';

        return $file_data;
    }

    public function remove($id)
    {
        try{
            $model = new Items();
            helper::sysDelete($model,$id);
            return redirect()->back()
                ->with([
                    'success' => trans('custom.items_delete_success'),
                    'title' => trans('custom.items_title')
                ]);
        }catch(Exception $e){
            return redirect()->back()
                ->with([
                    'error' => $e->getMessage(),
                    'title' => trans('custom.items_title')
                ]);
        }
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

    public function getSubCategory(Request $request){
        $subcategories = SubCategory::where('sys_state', '0')->where('category_id', $request->category_id)->get(['id', 'name', 'category_id']);
        return response()->json($subcategories);
    }
}
