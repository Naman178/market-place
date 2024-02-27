<?php

namespace App\Http\Controllers\Items;

use App\Http\Controllers\Controller;
use App\Models\Items;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\ItemsFeature;
use App\Models\ItemsImage;
use App\Models\ItemsPricing;
use App\Models\ItemsTag;
use Illuminate\Http\Request;
use Mockery\Matcher\Subset;

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
}
