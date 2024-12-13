<?php

namespace App\Http\Controllers\FrontEnd\HomePage;
use App\Http\Controllers\Controller;
use App\Models\Items;
use App\Models\SEO;
use App\Models\FAQ;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use DB;
use Carbon\Carbon;

class HomePageController extends Controller
{
    public function index()
    {
        $data['items'] = Items::with(['features', 'tags', 'images', 'categorySubcategory', 'pricing'])->where('sys_state','!=','-1')->orderBy('id','desc')->get();
        $FAQs = FAQ::get();
        $seoData = SEO::where('page', 'home')->first();
        return view('front-end.home-page.home-page',compact('data','seoData','FAQs'));
    }
}