<?php

namespace App\Http\Controllers\Reviews;

use App\helper\helper;
use App\Http\Controllers\Controller;
use App\Models\Reviews;
use App\Models\Items;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class ReviewsController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:reviews-list|reviews-create|reviews-edit|reviews-delete', ['only' => ['index','show']]);
        $this->middleware('permission:reviews-create', ['only' => ['edit','store']]);
        $this->middleware('permission:reviews-edit', ['only' => ['edit','store']]);
        $this->middleware('permission:reviews-delete', ['only' => ['destroy']]);
        $this->middleware('permission:reviews-tab-show', ['only' => ['index' , 'show' , 'edit' , 'store', 'destroy']]);
    }
    public function items_list()
    {
        $items = Items::where('sys_state','!=','-1')->orderBy('id','desc')->get();
        return view('pages.reviews.items',compact('items'));
    }

    public function showReviews($id)
    {
        $item = Items::findOrFail($id);
        $reviews = $item->reviews()->where('sys_state','!=','-1');
        
        $reviews = $reviews->get();
        
        return view('pages.reviews.reviews', compact('reviews'));
    }

    public function remove($id)
    {
        try{
            $model = new Reviews();
            helper::sysDelete($model,$id);
            return redirect()->back()
                ->with([
                    'success' => trans('custom.reviews_delete_success'),
                    'title' => trans('custom.review_title')
                ]);
        }catch(Exception $e){
            return redirect()->back()
                ->with([
                    'error' => $e->getMessage(),
                    'title' => trans('custom.review_title')
                ]);
        }
    }

    public function changeStatus(Request $request, $id){
        $review = Reviews::find($id);
        $review->update([
            "status" => $request->status
        ]);

        return response()->json([
            "success" => true,
            "data" => $review
        ]);
    }
}
