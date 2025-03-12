<?php

namespace App\Http\Controllers\FrontEnd\HomePage;
use App\Http\Controllers\Controller;
use App\Mail\NewsletterMail;
use App\Models\Comments;
use App\Models\Newsletter;
use App\Models\Settings;
use App\Models\Share;
use App\Models\Items;
use App\Models\SEO;
use App\Models\FAQ;
use App\Models\Blog;
use App\Models\ItemsFeature;
use App\Models\Blog_category;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Reviews;
use App\Models\Wishlist;
use App\Models\ItemsPricing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mail;
use Symfony\Component\HttpFoundation\Response;
use DB;
use Carbon\Carbon;

class HomePageController extends Controller
{
    public function index()
    {
        $data['items'] = Items::with(['features', 'tags', 'images', 'categorySubcategory', 'pricing'])->where('sys_state','!=','-1')->orderBy('id','desc')->get();
        $FAQs = FAQ::get();
        $Blogs = Blog::where('status', '1')->get();
        foreach ($Blogs as $blog) {
            $blog->category_name = Blog_category::where('category_id',$blog->category)->value('name');
            $blog->comments_count = Comments::where('blog_id', $blog->blog_id)->count();
            $blog->shares_count = Share::where('blog_id', $blog->blog_id)->count();
        }
        $seoData = SEO::where('page', 'home')->first();
        $category = Category::where('sys_state','=','0')->get();
        $subcategory = SubCategory::where('sys_state','=','0')->get();
    
        return view('front-end.home-page.home-page',compact('data','seoData','FAQs','Blogs','category','subcategory'));
    }
    public function newsletter(Request $request){
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'The email field cannot be empty.',
            'email.email' => 'Please provide a valid email address.',
        ]);
        $email = $request->email;
        $setting = Settings::first();
        $appName = $setting->value['site_name'] ?? 'Infinity Marketplace';

        Newsletter::create([
           'email' => $email,
        ]);
        Mail::to($email)->send(new NewsletterMail($email , $appName));
        return response()->json(['message' => 'Successfully subscribed!'], 200);
    }
    public function deletenewsletter(Request $request, $id){
        Newsletter::where('id', $id)->delete();
        return redirect()->back()
        ->with([
            'success' => trans('custom.Newsletter_delete_success'),
            'title' => trans('custom.Newsletter_title')
        ]);
    }
    public function Categoryshow($id){
        $subcategories = SubCategory::where('category_id', $id)->where('sys_state', '=', '0')->get();
        $categories = Category::where('sys_state', '!=', '-1')     ->withCount(['subcategories' => function ($query) {
            $query->where('sys_state', '=', '0');
        }])->get();
    
        $item = Items::with(['categorySubcategory', 'pricing'])
                  ->whereHas('categorySubcategory', function ($query) use ($subcategories) {
                      $query->whereIn('subcategory_id', $subcategories->pluck('id'));
                  })
                  ->where('sys_state', '=', '0')
                  ->get();
        return view('front-end.category.category',compact('item','categories'));
    }
    public function sortItems(Request $request)
    {
        $sortOption = $request->input('sort');
        $subcategories = SubCategory::where('category_id', $request->item_id)
            ->where('sys_state', '=', '0')
            ->pluck('id'); // Get only the IDs for efficient querying
    
            $query = Items::with(['categorySubcategory', 'pricing', 'reviews'])
            ->whereHas('categorySubcategory', function ($query) use ($subcategories) {
                $query->whereIn('subcategory_id', $subcategories);
            })
            ->where('sys_state', '=', '0')
            ->leftJoin('items_pricing__tbl', function ($join) {
                // Allow both 'one-time' and 'recurring' pricing types
                $join->on('items__tbl.id', '=', 'items_pricing__tbl.item_id')
                    ->whereIn('items_pricing__tbl.pricing_type', ['one-time', 'recurring']);
            })
            ->select('items__tbl.*')
            ->selectRaw('MIN(items_pricing__tbl.fixed_price) as fixed_price') // Get the first (lowest) recurring fixed price
            ->groupBy('items__tbl.id');
        if ($request->has('price')) {
            $price = (int) $request->price;  
            $query->havingRaw('CAST(fixed_price AS UNSIGNED) <= ?', [$price]);
        }
        // Sorting Logic
        if ($sortOption == 1) {
            $query->orderBy('fixed_price', 'asc'); // Low to High
        } elseif ($sortOption == 2) {
            $query->orderBy('fixed_price', 'desc'); // High to Low
        } else {
            $query->orderBy('items__tbl.created_at', 'asc');
        }
        $items = $query->get();
        return response()->json($items);
    }
    
    public function show($id){
        $subcategories = SubCategory::where('category_id', $id)->where('sys_state', '=', '0')->get();
        $categories = Category::where('sys_state', '!=', '-1')     ->withCount(['subcategories' => function ($query) {
            $query->where('sys_state', '=', '0');
        }])->get();
        if($subcategories){
            $item = Items::with(['categorySubcategory', 'pricing'])
                    ->whereHas('categorySubcategory', function ($query) use ($subcategories) {
                        $query->whereIn('subcategory_id', $subcategories->pluck('id'));
                    })
                    ->where('sys_state', '=', '0')
                    ->get();
        }
        else{
            $item = Items::with(['categorySubcategory', 'pricing'])
            ->whereHas('categorySubcategory', function ($query) use ($id) {
                $query->where('subcategory_id', $id);
            })
            ->where('sys_state', '=', '0')
            ->get();
        }
        return view('front-end.product.product',compact('item','categories'));
    }
    public function buynow($id)
    {
        $item = Items::with(['categorySubcategory', 'pricing'])
            ->where('id', $id) 
            ->where('sys_state', '0') 
            ->first();
        if (!$item) {
            return redirect()->back()->with('error', 'Item not found.');
        }
        $userCommentsCount = Comments::where('user_id', Auth::id())->where('item_id', $id)
        ->count();

        $comments = Comments::where('user_id', Auth::id())->where('item_id', $id)
        ->with('user') 
        ->get();

        $userReviewsCount = Reviews::where('user_id', Auth::id())->where('item_id', $id)
            ->count();

        $reviews = Reviews::where('user_id', Auth::id())->where('item_id', $id)
            ->with('user') 
            ->get();
        $pricingData = ItemsPricing::where('item_id', $id)->get(); 
        $featureData = ItemsFeature::where('item_id', $id)->get();
        
        // Initialize an array to hold the filtered feature data
        $filteredFeatures = [];
        
        // Loop through each pricing data to check for matching sub_id in feature data
        foreach ($pricingData as $pricing) {
            // Filter feature data where sub_id matches
            $matchingFeatures = $featureData->filter(function($feature) use ($pricing) {
                return $feature->sub_id == $pricing->sub_id;
            });
        
            // If matching features are found, add them to the filtered list
            if ($matchingFeatures->isNotEmpty()) {
                $filteredFeatures[$pricing->sub_id] = $matchingFeatures;
            }
        }
        return view('front-end.product.buy_now', compact('pricingData','item', 'userCommentsCount', 'comments', 'userReviewsCount', 'reviews', 'filteredFeatures'));
    }

    public function commentPost(Request $request)
    {
        if(!Auth::check()){
            return redirect()->route('user-login')->with('error', 'You need to be logged in to submit a comment.');
        }
        $data = $request->all();
        $comment = new Comments();
        $comment->item_id = $data['item_id'];
        $comment->user_id = $data['user_id'];
        $comment->description = $data['comment'];
        $comment->save();
        return redirect()->back()->with('success', 'Your comment has been posted.');
    }

    public function reviewPost(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('user-login')->with('error', 'You need to be logged in to submit a comment.');
        }
    
        $userId = Auth::id(); // Get logged-in user's ID
        $itemId = $request->item_id;
    
        // Check if the user already reviewed this item
        $existingReview = Reviews::where('user_id', $userId)
                                ->where('item_id', $itemId)
                                ->first();
    
        if ($existingReview) {
            return redirect()->back()->with('error', 'You have already reviewed this item.');
        }
    
        // If no review exists, create a new one
        $review = new Reviews();
        $review->item_id = $itemId;
        $review->user_id = $userId;
        $review->rating = $request->rating;
        $review->review = $request->review;
        $review->save();
    
        return redirect()->back()->with('success', 'Your review has been posted.');
    }
    
    public function addToWishlist(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'redirect' => route('user-login'), 'message' => 'You need to be logged in to add to Wishlist.']);
        }

        $user = auth()->user();
        $wishlist = Wishlist::where('user_id', $user->id)
                    ->where('product_id', $request->item_id)
                    ->first();

        if ($wishlist) {
            // Remove from wishlist if already added
            $wishlist->delete();
            return response()->json(['success' => true, 'message' => 'Removed from Wishlist']);
        } else {
            // Add to wishlist
            Wishlist::create([
                'user_id' => $user->id,
                'product_id' => $request->item_id
            ]);
            return response()->json(['success' => true, 'message' => 'Added to Wishlist']);
        }
    }

    public function getUserWishlist()
    {
        $user = auth()->user();

        // Fetch user's wishlist items
        $wishlistItems = Wishlist::where('user_id', $user->id)->pluck('product_id')->toArray();

        return response()->json(['success' => true, 'wishlistItems' => $wishlistItems]);
    }

}
