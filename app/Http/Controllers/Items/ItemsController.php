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

    public function edit($id,$id1=null)
    {
        if($id === 'new' && (is_null($id1) || $id1 === 'new')){
            $itemid = $id;
            $type = 'null';
            $item = Items::with(['features', 'tags', 'images', 'categorySubcategory', 'pricing'])->where('id', $id1)->first();
            $categories = Category::where('sys_state', '0')->pluck('name', 'id')->all();
            $subcategories = SubCategory::where('sys_state', '0')->get(['id', 'name', 'category_id']);
            if($id1 == null){
                $isshow = true;
            }else{
                if($id1 == 'new'){
                    $isshow = false;
                }
            }
        }elseif($id !=='new' && (is_null($id1) || $id1 === 'new')){
            $itemid = $id;
            $itemtype = ItemsPricing::where('item_id',$id)->first();
            $type = $itemtype->pricing_type;
            if($id1 == 'new'){
                $item = Items::with(['features', 'tags', 'images', 'categorySubcategory', 'pricing'])->where('id', $id1)->first();
            }else{
                $item = Items::with(['features', 'tags', 'images', 'categorySubcategory', 'pricing'])->where('id', $id)->first();
            }
            $categories = Category::where('sys_state', '0')->pluck('name', 'id')->all();
            $subcategories = SubCategory::where('sys_state', '0')->get(['id', 'name', 'category_id']);
            $isshow = false;
        }else{
            $itemid = $id;
            $itemtype = ItemsPricing::where('item_id',$id)->first();
            $type = $itemtype->pricing_type;
            $item = Items::with(['features', 'tags', 'images', 'categorySubcategory', 'pricing'])->where('id', $id)->first();
            $categories = Category::where('sys_state', '0')->pluck('name', 'id')->all();
            $subcategories = SubCategory::where('sys_state', '0')->get(['id', 'name', 'category_id']);
            $isshow = false;
        }
        return view('pages.items.edit',compact('item','categories','subcategories','itemid','isshow','type'));
    }

    public function store(Request $request) {
        if ($request->ajax()) {
            $validator = $this->validateRequest($request);

            if (!$validator->passes()) {
                return response()->json(['error' => $validator->getMessageBag()->toArray()]);
            }

            $isUpdate = $request->has('item_id') && $request->item_id != "0";
            $item = $isUpdate ? Items::find($request->item_id) : new Items();

            $thumbnail = $request->hasFile('item_thumbnail') ? $this->uploadFile($request->item_thumbnail) : ($isUpdate ? $item->thumbnail_image : null);
            $mainFile = $request->hasFile('item_main_file') ? $this->uploadFile($request->item_main_file) : ($isUpdate ? $item->main_file_zip : null);

            $item->fill([
                'name' => $request->name,
                'html_description' => $request->html_description,
                'thumbnail_image' => $thumbnail,
                'main_file_zip' => $mainFile,
                'preview_url' => $request->preview_url,
                'status' => '1',
                'sys_state' => '0',
                $isUpdate ? 'updated_at' : 'created_at' => Carbon::now(),
            ])->save();

            if ($isUpdate) {
                ItemsImage::where('item_id', $item->id)->delete();
            }

            $oldImages = $request->old_image ?? [];
            $newImages = $request->item_images ?? [];
            foreach (array_merge($oldImages, $newImages) as $image) {
                ItemsImage::create([
                    'item_id' => $item->id,
                    'image_path' => is_file($image) ? $this->uploadFile($image) : $image,
                    'updated_at' => Carbon::now(),
                ]);
            }

            if ($isUpdate) {
                ItemsFeature::where('item_id', $item->id)->delete();
            }

            foreach ($request->key_feature ?? [] as $feature) {
                ItemsFeature::create([
                    'item_id' => $item->id,
                    'key_feature' => $feature,
                    $isUpdate ? 'updated_at' : 'created_at' => Carbon::now(),
                ]);
            }

            if ($isUpdate) {
                ItemsTag::where('item_id', $item->id)->delete();
            }

            foreach ($request->tag ?? [] as $tag) {
                if (!empty($tag)) {
                    ItemsTag::create([
                        'item_id' => $item->id,
                        'tag_name' => $tag,
                        $isUpdate ? 'updated_at' : 'created_at' => Carbon::now(),
                    ]);
                }
            }

            if (isset($request->category_id) && isset($request->subcategory_id)) {
                ItemsCategorySubcategory::updateOrCreate(
                    ['item_id' => $item->id],
                    [
                        'category_id' => $request->category_id,
                        'subcategory_id' => $request->subcategory_id,
                        'updated_at' => Carbon::now(),
                    ]
                );
            }

            if($request->item_type == 'one-time'){
                if($request->licenseradio == 'lifetime'){
                    $validity = 'Lifetime';
                }else{
                    $validity = '';
                }
            }else{
                $validity = '';
            }
            ItemsPricing::updateOrCreate(
                ['item_id' => $item->id],
                [
                    'fixed_price' => $request->fixed_price,
                    'pricing_type' => $request->item_type,
                    'sale_price' => $request->sale_price,
                    'gst_percentage' => $request->gst_percentage,
                    'validity'=>$validity,
                    'billing_cycle'=>$request->itembillingcycle,
                    'custom_cycle_days'=>$request->itembillingcycle=='custom' ? $request->custombillingcycle : null,
                    'auto_renew' => $request->has('autorenewalcheckbox') ? '1' : '0',
                    'grace_period'=>$request->graceperiod,
                    'expiry_date' => ($request->item_type === 'one-time' && $request->licenseradio !== 'lifetime') ? $request->expiryDate : null,
                    $isUpdate ? 'updated_at' : 'created_at' => Carbon::now(),
                ]
            );

            session()->flash('success', $isUpdate ? trans('custom.items_update_success') : trans('custom.items_create_success'));

            return response()->json([
                'success' => $isUpdate ? trans('custom.items_update_success') : trans('custom.items_create_success'),
                'title' => trans('custom.item_title'),
                'type' => $isUpdate ? 'update' : 'create',
                'data' => $item,
            ], Response::HTTP_OK);
        }
    }


    public function itemtypestore(Request $request){
        $save_item = Items::create([
            'name' => '',
            'status' => '1',
            'sys_state' => '0',
            'created_at' => Carbon::now(),
        ]);

        if($request->item_type == 'one-time'){
            $validity = 'Lifetime';
        }else{
            $validity = '';
        }

        ItemsPricing::create([
            'item_id' => $save_item->id,
            'pricing_type'=>$request->item_type,
            'created_at' => Carbon::now(),
            'validity'=>$validity,
        ]);

        return redirect()->route('items-edit', ['id' => $save_item->id,'id1'=>'new'])
                     ->with('success', 'Item created successfully!');
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
            'sale_price' => 'required|numeric',
            'gst_percentage' => 'required|numeric'
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
