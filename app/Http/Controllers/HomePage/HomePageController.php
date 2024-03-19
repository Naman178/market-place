<?php

namespace App\Http\Controllers\HomePage;
use App\Http\Controllers\Controller;
use App\Models\Items;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use DB;
use Carbon\Carbon;

class HomePageController extends Controller
{
    public function index()
    {
        $data['items'] = Items::with(['features', 'tags', 'images', 'categorySubcategory', 'pricing'])->where('sys_state','!=','-1')->orderBy('id','desc')->get();
        return view('front-end.home-page.home-page',compact('data'));
    }
}