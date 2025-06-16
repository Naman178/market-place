<?php

namespace App\Http\Controllers\FrontEnd\HomePage;
use App\Http\Controllers\Controller;
use App\Mail\NewsletterMail;
use App\Models\Comments;
use App\Models\Newsletter;
use App\Models\Order;
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
use App\Models\ItemsImage;
use App\Models\Testimonials;
use App\Models\SocialMedia;
use App\Models\ItemsTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use Usamamuneerchaudhary\Commentify\Models\Comment;
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
        $Blogs = Blog::where('status', '1')->with('categoryname')->orderBy('blog_id', 'desc')->get();
        foreach ($Blogs as $blog) {
            $blog->category_name = Blog_category::where('category_id',$blog->category)->value('name');
            $blog->comments_count = Comments::where('post_id', $blog->blog_id)->count();
            $blog->shares_count = Share::where('blog_id', $blog->blog_id)->count();
        }
        $seoData = SEO::where('page', 'home')->first();
        $category = Category::where('sys_state','=','0')->orderBy('id','desc')->get();
        $subcategory = SubCategory::where('sys_state','=','0')->orderBy('id','desc')->get();
        $testimonials = Testimonials::orderBy('testimonials.id', 'desc')
                            ->get();
        $latestTestimonials = Testimonials::orderBy('testimonials.id', 'desc')
                            ->latest()
                            ->get();
        $socialmedia = SocialMedia::orderBy('social_media.id', 'desc')
                            ->get();  
        return view('front-end.home-page.home-page',compact('data','seoData','FAQs','Blogs','category','subcategory','testimonials','socialmedia','latestTestimonials'));
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
        return redirect()->back()->with('success', 'Successfully subscribed!');
        // return response()->json(['message' => 'Successfully subscribed!'], 200);
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
        $categories = Category::where('sys_state', '!=', '-1')->withCount(['Items as products_count' => function ($query) {
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
        $keyword = $request->input('keyword');
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
        if (!empty($keyword)) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('items__tbl.name', 'LIKE', "%$keyword%")
                      ->orWhere('items__tbl.html_description', 'LIKE', "%$keyword%") 
                      ->orWhereHas('tags', function ($query) use ($keyword) { 
                          $query->where('tag_name', 'LIKE', "%$keyword%");
                      })
                      ->orWhereHas('categorySubcategory.category', function ($query) use ($keyword) { 
                          $query->where('name', 'LIKE', "%$keyword%");
                      })
                      ->orWhereHas('categorySubcategory.subcategory', function ($query) use ($keyword) { 
                          $query->where('name', 'LIKE', "%$keyword%");
                      })
                      ->orWhereRaw('CAST(items_pricing__tbl.fixed_price AS CHAR) LIKE ?', ["%$keyword%"]); 
                });
            }
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
    // public function filterProducts(Request $request)
    // {
    //     $query = Items::with(['categorySubcategory', 'pricing', 'reviews', 'tags'])
    //         ->where('sys_state', '=', '0')
    //         ->leftJoin('items_pricing__tbl', function ($join) {
    //             $join->on('items__tbl.id', '=', 'items_pricing__tbl.item_id')
    //                 ->whereIn('items_pricing__tbl.pricing_type', ['one-time', 'recurring']);
    //         })
    //         ->select('items__tbl.*')
    //         ->selectRaw('MIN(items_pricing__tbl.fixed_price) as fixed_price')
    //         ->groupBy('items__tbl.id');

    //     // Detect if any filter is applied
    //     $filtersApplied = false;

    //     // Keyword Search
    //     if (!empty($request->keyword)) {
    //         $filtersApplied = true;
    //         $keyword = $request->keyword;

    //         $query->where(function ($q) use ($keyword) {
    //             $q->where('items__tbl.name', 'LIKE', "%$keyword%")
    //             ->orWhere('items__tbl.html_description', 'LIKE', "%$keyword%")
    //             ->orWhereHas('tags', function ($query) use ($keyword) {
    //                 $query->where('tag_name', 'LIKE', "%$keyword%");
    //             })
    //             ->orWhereHas('categorySubcategory.category', function ($query) use ($keyword) {
    //                 $query->where('name', 'LIKE', "%$keyword%");
    //             })
    //             ->orWhereHas('categorySubcategory.subcategory', function ($query) use ($keyword) {
    //                 $query->where('name', 'LIKE', "%$keyword%");
    //             })
    //             ->orWhereRaw('CAST(items_pricing__tbl.fixed_price AS CHAR) LIKE ?', ["%$keyword%"]);
    //         });
    //     }

    //     // Filter by categories
    //     if (!empty($request->categories)) {
    //         $filtersApplied = true;
    //         $subcategories = SubCategory::whereIn('category_id', $request->categories)
    //             ->where('sys_state', '=', '0')
    //             ->pluck('id');

    //         $query->whereHas('categorySubcategory', function ($q) use ($subcategories) {
    //             $q->whereIn('subcategory_id', $subcategories);
    //         })->orderBy('items__tbl.created_at', 'desc');
    //     }

    //     // Filter by subcategories
    //     if (!empty($request->subcategories)) {
    //         $filtersApplied = true;
    //         $query->whereHas('categorySubcategory', function ($q) use ($request) {
    //             $q->whereIn('subcategory_id', $request->subcategories);
    //         })->orderBy('items__tbl.created_at', 'desc');
    //     }

    //     // Filter by tags
    //     if (!empty($request->tags) && is_array($request->tags) && count(array_filter($request->tags)) > 0) {
    //         $filtersApplied = true;
    //         $query->whereHas('tags', function ($q) use ($request) {
    //             $q->whereIn('tag_name', $request->tags);
    //         })->orderBy('items__tbl.created_at', 'desc');
    //     }

    //     // Filter by price
    //     if ($request->has('price') && (int)$request->price > 0) {
    //         $filtersApplied = true;
    //         $query->havingRaw('CAST(fixed_price AS UNSIGNED) <= ?', [(int) $request->price])->orderBy('items__tbl.created_at', 'desc');
    //     }
    //     $sortOption = $request->input('sort_option');

    //     if ($sortOption == 1) {
    //         $query->orderBy('fixed_price', 'asc'); // Low to High
    //     } elseif ($sortOption == 2) {
    //         $query->orderBy('fixed_price', 'desc'); // High to Low
    //     } else {
    //         $query->orderBy('items__tbl.created_at', 'asc'); // Default
    //     }


    //     // If no filters applied, optionally return empty or all products:
    //     if (!$filtersApplied) {
    //         $id = $request->item_id;
    //         $subcategories = SubCategory::where('category_id', $id)
    //             ->where('sys_state', '=', '0')
    //             ->get();

    //         $categories = Category::where('sys_state', '!=', '-1')
    //             ->withCount(['subcategories as countsubcategory' => function ($query) {
    //                 $query->where('sys_state', '=', '0');
    //             }])
    //             ->get();

    //         if ($subcategories) {
    //             $item = Items::with(['categorySubcategory', 'pricing', 'order', 'tags'])
    //                 ->whereHas('categorySubcategory', function ($query) use ($subcategories) {
    //                     $query->whereIn('subcategory_id', $subcategories->pluck('id'));
    //                 })
    //                 ->where('sys_state', '=', '0')
    //                 ->orderBy('id', 'desc')
    //                 ->get();
    //         } else {
    //             $item = Items::with(['categorySubcategory', 'pricing', 'order', 'tags'])
    //                 ->whereHas('categorySubcategory', function ($query) use ($id) {
    //                     $query->where('subcategory_id', $id);
    //                 })
    //                 ->where('sys_state', '=', '0')
    //                 ->orderBy('id', 'desc')
    //                 ->get();
    //         }
    //         return response()->json($item);
    //     }

    //     $filteredProducts = $query->get();

    //     return response()->json($filteredProducts);
    // }
    public function filterProducts(Request $request)
    {
        $orderCountSubquery = Order::select(DB::raw('COUNT(*) as order_count'))->whereColumn('product_id', 'items__tbl.id');

        $query = Items::with(['categorySubcategory', 'pricing', 'reviews', 'tags'])
            ->where('sys_state', '=', '0')
            ->leftJoin('items_pricing__tbl', function ($join) {
                $join->on('items__tbl.id', '=', 'items_pricing__tbl.item_id')
                    ->whereIn('items_pricing__tbl.pricing_type', ['one-time', 'recurring']);
            })
            ->select('items__tbl.*')
            ->selectRaw('MIN(items_pricing__tbl.fixed_price) as fixed_price')
            ->selectSub($orderCountSubquery, 'order_count') // ✅ get order count manually
            ->where('items__tbl.sys_state', '=', '0')
            ->groupBy('items__tbl.id');

        // Detect if any filter is applied
        $filtersApplied = false;
        $sortOption = $request->input('sort_option');
        if ($sortOption == 1) {
            $filtersApplied = true;
            $query->orderBy('fixed_price', 'asc'); // Low to High
        } elseif ($sortOption == 2) {
            $filtersApplied = true;
            $query->orderBy('fixed_price', 'desc'); // High to Low
        } else {
            $filtersApplied = true;
            $query->orderBy('items__tbl.created_at', 'asc'); // Default
        }

        // Keyword Search
        if (!empty($request->keyword)) {
            $filtersApplied = true;
            $keyword = $request->keyword;

            $query->where(function ($q) use ($keyword) {
                $q->where('items__tbl.name', 'LIKE', "%$keyword%")
                ->orWhere('items__tbl.html_description', 'LIKE', "%$keyword%")
                ->orWhereHas('tags', function ($query) use ($keyword) {
                    $query->where('tag_name', 'LIKE', "%$keyword%");
                })
                ->orWhereHas('categorySubcategory.category', function ($query) use ($keyword) {
                    $query->where('name', 'LIKE', "%$keyword%");
                })
                ->orWhereHas('categorySubcategory.subcategory', function ($query) use ($keyword) {
                    $query->where('name', 'LIKE', "%$keyword%");
                })
                ->orWhereRaw('CAST(items_pricing__tbl.fixed_price AS CHAR) LIKE ?', ["%$keyword%"]);
            });
        }

        // Filter by categories
        if (!empty($request->categories)) {
            $filtersApplied = true;
            $subcategories = SubCategory::whereIn('category_id', $request->categories)
                ->where('sys_state', '=', '0')
                ->pluck('id');

            $query->whereHas('categorySubcategory', function ($q) use ($subcategories) {
                $q->whereIn('subcategory_id', $subcategories);
            })->orderBy('items__tbl.created_at', 'desc');
        }

        // Filter by subcategories
        if (!empty($request->subcategories)) {
            $filtersApplied = true;
            $query->whereHas('categorySubcategory', function ($q) use ($request) {
                $q->whereIn('subcategory_id', $request->subcategories);
            })->orderBy('items__tbl.created_at', 'desc');
        }

        // Filter by tags
        if (!empty($request->tags) && is_array($request->tags) && count(array_filter($request->tags)) > 0) {
            $filtersApplied = true;
            $query->whereHas('tags', function ($q) use ($request) {
                $q->whereIn('tag_name', $request->tags);
            })->orderBy('items__tbl.created_at', 'desc');
        }

        // Filter by price
        if ($request->has('price') && (int)$request->price > 0) {
            $filtersApplied = true;
            $query->havingRaw('CAST(fixed_price AS UNSIGNED) <= ?', [(int) $request->price])->orderBy('items__tbl.created_at', 'desc');
        }

        if ($sortOption == 1) {
            $query->orderBy('fixed_price', 'asc'); // Low to High
        } elseif ($sortOption == 2) {
            $query->orderBy('fixed_price', 'desc'); // High to Low
        } else {
            $query->orderBy('items__tbl.created_at', 'asc'); // Default
        }


        // If no filters applied, optionally return empty or all products:
        if (!$filtersApplied) {
            $id = $request->item_id;
            $subcategories = SubCategory::where('category_id', $id)
                ->where('sys_state', '=', '0')
                ->get();

            $categories = Category::where('sys_state', '!=', '-1')
                ->withCount(['subcategories as countsubcategory' => function ($query) {
                    $query->where('sys_state', '=', '0');
                }])
                ->get();

            if ($subcategories) {
                $item = Items::with(['categorySubcategory', 'pricing', 'order', 'tags'])
                    ->whereHas('categorySubcategory', function ($query) use ($subcategories) {
                        $query->whereIn('subcategory_id', $subcategories->pluck('id'));
                    })
                    ->where('sys_state', '=', '0')
                    ->orderBy('id', 'desc')
                    ->get();
            } else {
                $item = Items::with(['categorySubcategory', 'pricing', 'order', 'tags'])
                    ->whereHas('categorySubcategory', function ($query) use ($id) {
                        $query->where('subcategory_id', $id);
                    })
                    ->where('sys_state', '=', '0')
                    ->orderBy('id', 'desc')
                    ->get();
            }
            return response()->json($item);
        }

        $filteredProducts = $query->get();

        return response()->json($filteredProducts);
    }
    public function show($category, $slug)
    {
        $subcategory = SubCategory::where('slug', $slug)->value('id');
        $category = Category::where('id', $subcategory)->first();
        $slugCategory = Category::where('slug', $slug)->first();

        if ($slugCategory) {
            $id = $slugCategory->id;
        } else {
            $id = $category->id;
        }
        $category_name = Category::where('id', $id)->value('name');

        $allsubcategories = SubCategory::where('category_id', $id)
            ->where('sys_state', '=', '0')
            ->withCount(['items as countsubcategory' => function ($query) {
                $query->where('sys_state', '=', '0');
            }])
            ->get();

        $subcategories = SubCategory::where('category_id', $id)
            ->where('sys_state', '=', '0')
            ->get();

        $categories = Category::where('sys_state', '!=', '-1')
            ->withCount(['subcategories as countsubcategory' => function ($query) {
                $query->where('sys_state', '=', '0');
            }])
            ->get();

        if ($subcategories) {
            $item = Items::with(['categorySubcategory', 'pricing', 'order', 'tags'])
                ->whereHas('categorySubcategory', function ($query) use ($subcategories) {
                    $query->whereIn('subcategory_id', $subcategories->pluck('id'));
                })
                ->where('sys_state', '=', '0')
                ->orderBy('id', 'desc')
                ->get();
        } else {
            $item = Items::with(['categorySubcategory', 'pricing', 'order', 'tags'])
                ->whereHas('categorySubcategory', function ($query) use ($id) {
                    $query->where('subcategory_id', $id);
                })
                ->where('sys_state', '=', '0')
                ->orderBy('id', 'desc')
                ->get();
        }

        // Collect all unique tag IDs from items
        $tagIds = $item->pluck('tags')->flatten()->pluck('id')->unique();
        $tags = ItemsTag::whereIn('id', $tagIds)->get()->unique('tag_name');

        return view('front-end.product.product', compact('id', 'item', 'categories', 'allsubcategories', 'category_name', 'tags'));
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
        // $userCommentsCount = Comments::where('user_id', Auth::id())->where('item_id', $id)
        // ->count();

        // $comments = Comments::where('user_id', Auth::id())->where('item_id', $id)
        // ->with('user') 
        // ->get();
        $orderitem = Order::where('product_id', $id)->where('user_id', Auth::id())->first();
        $userCommentsCount = Comment::where('item_id', $id)->where('parent_id', null)->count(); 
        $post = Post::first();
        $userReviewsCount = Reviews::where('user_id', Auth::id())->where('item_id', $id)
            ->where('sys_state', '=', '0')->count();

        $reviews = Reviews::where('item_id', $id)
            ->with('user')->where('sys_state', '=', '0')->orderBy('id', 'desc')
            ->get();
        $pricingData = ItemsPricing::where('item_id', $id)->get(); 
        $featureData = ItemsFeature::where('item_id', $id)->get();
        $imagesData = ItemsImage::where('item_id', $id)->get();
        
        $filteredFeatures = [];

        foreach ($pricingData as $pricing) {
            $matchingFeatures = $featureData->filter(function($feature) use ($pricing) {
                return $feature->sub_id == $pricing->sub_id;
            });

            if ($matchingFeatures->isNotEmpty()) {
                $filteredFeatures[$pricing->sub_id] = $matchingFeatures;
            }
        }
        $images = [];

        foreach ($imagesData as $image) {
            $key = $image->sub_id ?? ''; 

            if (!isset($images[$key])) {
                $images[$key] = collect();
            }

            $images[$key]->push($image);
        }
        return view('front-end.product.buy_now', compact('pricingData','item', 'userCommentsCount', 'post', 'userReviewsCount', 'reviews', 'filteredFeatures', 'orderitem', 'images'));
    }
    public function commentupdate(Request $request, $id)
    {
        $comment = Comments::findOrFail($id);
    
        // Ensure only the owner can edit
        if (Auth::id() !== $comment->user_id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }
    
        $comment->description = $request->description;
        $comment->is_edited = true;
        $comment->save();
    
        return response()->json([
            'success' => true,
            'username' => $comment->user->name // Return the username
        ]);
    }
    

    public function reviewsupdate(Request $request, $id)
    {
        $review = Reviews::findOrFail($id);

        // Ensure only the owner can edit
        if (Auth::id() !== $review->user_id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $review->review = $request->review;
        $review->rating = $request->rating;
        $review->is_edited = true;
        $review->save();

        return response()->json([ 'success' => true,
        'username' => $review->user->name]);
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

    public function wishlistindex()
    {
        $user = auth()->user();
        $wishlists = Wishlist::where('user_id', $user->id)->with('plan', 'pricing')->orderBy('id', 'desc')->get();
        return view('front-end.wishlist.wishlist', compact('wishlists'));
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
            return response()->json(['error' => true, 'message' => 'Item already in Wishlist']);    
        } else {
            // Add to wishlist
            Wishlist::create([
                'user_id' => $user->id,
                'product_id' => $request->item_id
            ]);
            return response()->json(['success' => true, 'message' => 'Added to Wishlist']);
        }
    }

    public function removeToWishlist(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'redirect' => route('user-login'), 'message' => 'You need to be logged in to remove from Wishlist.']);
        }

        $user = auth()->user();
        $wishlist = Wishlist::where('user_id', $user->id)
                    ->where('product_id', $request->item_id)
                    ->first();

        if ($wishlist) {
            $wishlist->delete();
            return response()->json(['success' => true, 'message' => 'Removed from Wishlist']);
        } else {
            return response()->json(['error' => true, 'message' => 'Item not in Wishlist']);
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
