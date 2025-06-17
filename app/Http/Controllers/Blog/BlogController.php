<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Blog_category;
use App\Models\BlogContent;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Comments;
use App\Models\Share;
use App\Models\SEO;
use App\Models\Post;
use Carbon\Carbon;
use Auth;
use DB;
use Illuminate\Support\Str;


class BlogController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:Blog-list|Blog-create|Blog-edit|Blog-delete', ['only' => ['index','show']]);
        $this->middleware('permission:Blog-create', ['only' => ['edit','store']]);
        $this->middleware('permission:Blog-edit', ['only' => ['edit','store']]);
        $this->middleware('permission:Blog-delete', ['only' => ['destroy']]);
        $this->middleware('permission:Blog-tab-show', ['only' => ['index' , 'show' , 'edit' , 'store', 'destroy']]);
    }
    public function index()
    {
        $Blog = Blog::orderBy('blog.blog_id', 'asc')->get();
        return view('pages.Blog.Blog',compact('Blog'));
    }

    public function edit($id)
    {
        $Blog = Blog::where('blog_id',$id)->first();
        $BlogContents = BlogContent::orderBy('id')->where('blog_id',$id)->get();  
        $categories = Blog_category::orderBy('category_id')->get();  
        $Blog_list = Blog::where('blog_id','!=',$id)->get();    
        return view('pages.Blog.edit',compact('Blog','categories','Blog_list','BlogContents'));
    }

    public function store(Request $request){
        if($request->ajax()){
            $validator = $this->validateRequest($request);
            if ($validator->passes()) {
                if ($request->scid == "0") {
                    $blog_originalImageName = null;
                    // Handle the blog image upload
                    if ($request->hasFile('blog_image')) {
                        $blog_originalImageName = $request->file('blog_image')->getClientOriginalName();
                        $destinationPath = public_path('storage/images/');
                        $request->file('blog_image')->move($destinationPath, $blog_originalImageName);
                    }

                    $originalTitle = $request->title;
                    $title = $originalTitle;
                    $counter = 1;

                    while (Blog::where('title', $title)->exists()) {
                        $title = $originalTitle . '-' . $counter;
                        $counter++;
                    }
                    $slug = Str::slug($title);
                    // Create blog
                    $save_Blog = Blog::create([
                        'title' => $title, 
                        'slug' => $slug, 
                        'category' => $request->category,
                        'image' => $blog_originalImageName,
                        'short_description' => $request->shortdescription,
                        'long_description' => $request->long_description,
                        'uploaded_by' => Auth::user()->name,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
            
                    // Step 2: Handle Related Blogs
                    if (!empty($request->related_blog)) {
                        $relatedBlogs = is_array($request->related_blog) 
                                        ? $request->related_blog 
                                        : [$request->related_blog];
                        $save_Blog->update([
                            'related_blogs' => json_encode($relatedBlogs),
                        ]);
                    }
            
                    // Step 3: Handle Content Sections in bulk
                    if ($request->has('select-type')) {
                        $contentSections = [];
            
                        // Loop through content sections and build the content data
                        foreach ($request->all() as $key => $value) {

                            if (strpos($key, 'select_type_') !== false) {
                                // Extract the section index from the key (e.g., select_type_1 -> 1)
                                $index = str_replace('select_type_', '', $key);
                                
                                // Store the selected type for each section
                                $contentSections[$index]['select_type'] = $value;
                            }
                            if (strpos($key, 'heading_') !== false && !empty($value)) {
                                $index = str_replace('heading_', '', $key);
                                $contentSections[$index]['heading'] = $value;
                            }
            
                            if (strpos($key, 'description_') !== false && !empty($value)) {
                                $index = str_replace('description_', '', $key);
                                $contentSections[$index]['description'] = $value;
                            }
            
                            if (strpos($key, 'description2_') !== false && !empty($value)) {
                                $index = str_replace('description2_', '', $key);
                                $contentSections[$index]['description2'] = $value;
                            }
            
                            if (strpos($key, 'image_') !== false) {
                                $index = str_replace('image_', '', $key);
                                if ($request->hasFile($key)) {
                                    $file = $request->file($key);
                                    $fileName = $file->getClientOriginalName();
                                    $file->move(public_path('storage/images/'), $fileName);
                                    $contentSections[$index]['image'] = $fileName;
                                }
                            }
                        }
                        // Step 4: Save Content Sections for the Blog in bulk
                        $contentData = [];
                        foreach ($contentSections as $section) {
                            $contentData[] = [
                                'blog_id' => $save_Blog->blog_id,
                                'content_type' => $section['select_type'] ?? null,
                                'content_heading' => $section['heading'] ?? null,
                                'content_descriptipn_1' => $section['description'] ?? null,
                                'content_descriptipn_2' => $section['description2'] ?? null,
                                'content_image' => $section['image'] ?? null,
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now(),
                            ];
                        }
            
                        // Insert content data in bulk
                        BlogContent::insert($contentData);
                    }
            
                    // Flash success message
                    session()->flash('success', trans('custom.Blog_create_success'));
            
                    // Return success response with blog data
                    return response()->json([
                        'success' => trans('custom.Blog_create_success'),
                        'title' => trans('custom.Blog_title'),
                        'type' => 'create',
                        'data' => $save_Blog
                    ], Response::HTTP_OK);
                } else {
                    // Handle the update part if $request->scid != 0
                    $Blog = Blog::find($request->scid);
            
                    if (!$Blog) {
                        return response()->json([
                            'error' => 'Blog not found'
                        ], 404);
                    }
            
                    // Handle image upload for updating the blog
                    $blog_originalImageName = null;
                    // if ($request->hasFile('blog_image')) {
                    //     $blog_originalImageName = $request->file('blog_image')->getClientOriginalName();
                    //     $destinationPath = public_path('storage/images/');
                    //     $request->file('blog_image')->move($destinationPath, $blog_originalImageName);
                    // }
                    if ($request->hasFile('blog_image')) {
                        $blog_originalImageName = $request->file('blog_image')->getClientOriginalName();
                        $destinationPath = public_path('storage/images/');
                        $request->file('blog_image')->move($destinationPath, $blog_originalImageName);
                    } else {
                        $blog_originalImageName = $Blog->image; 
                    }
                    $slug = Str::slug($request->title);
                    // Update the blog entry
                    $Blog->update([
                        'title' => $request->title,
                        'slug' => $slug, 
                        'category' => $request->category,
                        'image' => $blog_originalImageName,
                        'short_description' => $request->shortdescription,
                        'long_description' => $request->long_description,
                        'uploaded_by' => Auth::user()->name,
                        'updated_at' => Carbon::now(),
                    ]);
            
                    // Step 2: Handle Related Blogs for update
                    $relatedBlogs = [];
                    if (!empty($request->related_blog)) {
                        $relatedBlogs = is_array($request->related_blog)
                                        ? $request->related_blog
                                        : [$request->related_blog];
                    }
            
                    $Blog->update([
                        'related_blogs' => json_encode($relatedBlogs),
                    ]);
            
                    // Step 3: Handle Content Sections for update
                    foreach ($request->all() as $key => $value) {
                        // Match keys like 'heading_0', 'heading_1', etc.
                        if (preg_match('/^heading_(\d+)$/', $key, $matches)) {
                            $index = $matches[1]; 
                            $content_type = $request->input('select_type.' . $index); 
                            $newcontent_type = $request->input('select_type_' . $index); 
                            $oldcontent_type = $request->input('old_content_type_' . $index); 
                            $heading = $request->input('heading_' . $index);
                            $description = $request->input('description_' . $index);
                            $description2 = $request->input('description2_' . $index);
                            $image = $request->file('image_' . $index); 
                            $oldImage = $request->input('old_content_image_' . $index);
                            $content_id = $request->input('content_id_' . $index); 

                            if (empty($content_type)) {
                                $content_type = $oldcontent_type;
                            }
                    
                            if (!empty($newcontent_type)) {
                                $content_type = $newcontent_type;
                            }
                    
                            if ($heading || $description || $image || $oldImage) {
                                $sectionData = [
                                    'id' => $content_id,
                                    'blog_id' => $request->scid,
                                    'content_type' => $content_type,
                                    'content_heading' => $heading,
                                    'content_descriptipn_1' => $description,
                                    'content_descriptipn_2' => $description2 ?? null,
                                    'content_image' => null,
                                    'updated_at' => Carbon::now(),
                                ];
                    
                                if ($image) {
                                    $fileName = $image->getClientOriginalName();
                                    $image->move(public_path('storage/images/'), $fileName);
                                    $sectionData['content_image'] = $fileName; 
                                } elseif ($oldImage) {
                                    $sectionData['content_image'] = $oldImage;
                                }
                    
                                $contentSections[] = $sectionData;
                            }
                        }
                    }
                    if (!empty($contentSections)) {
                    foreach ($contentSections as $sectionData) {
                        if (!empty($sectionData['id'])) {
                            $existingContent = BlogContent::where('blog_id', $request->scid)
                                                          ->where('id', $sectionData['id'])
                                                          ->first();
                    
                            if ($existingContent) {
                                $existingContent->update([
                                    'content_type' => $sectionData['content_type'],
                                    'content_heading' => $sectionData['content_heading'],
                                    'content_descriptipn_1' => $sectionData['content_descriptipn_1'],
                                    'content_descriptipn_2' => $sectionData['content_descriptipn_2'],
                                    'content_image' => $sectionData['content_image'],
                                    'updated_at' => Carbon::now(),
                                ]);
                            }
                        } else {
                            BlogContent::create([
                                'blog_id' => $sectionData['blog_id'],
                                'content_type' => $sectionData['content_type'],
                                'content_heading' => $sectionData['content_heading'],
                                'content_descriptipn_1' => $sectionData['content_descriptipn_1'],
                                'content_descriptipn_2' => $sectionData['content_descriptipn_2'],
                                'content_image' => $sectionData['content_image'],
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now(),
                            ]);
                        }
                    }
                }
                    // Flash success message
                    session()->flash('success', trans('custom.Blog_update_success'));
            
                    // Return success response with blog data
                    return response()->json([
                        'success' => trans('custom.Blog_update_success'),
                        'title' => trans('custom.Blog_title'),
                        'type' => 'update',
                        'data' => $Blog
                    ]);
                }
            }
            else{
                return response()->json(['error'=>$validator->getMessageBag()->toArray()]);
            }
        }
    }

    private function validateRequest(Request $request)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            // 'blog_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'shortdescription' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (trim(strip_tags($value)) === '') {
                        $fail('The short description field is required.');
                    }
                },
            ],
            'long_description' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (trim(strip_tags($value)) === '') {
                        $fail('The long description field is required.');
                    }
                },
            ],
        ];
        if ($request->scid == "0") {
            $rules['blog_image'] = 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048';
        }
        return Validator::make($request->all(), $rules);
    }
 

    public function remove($id)
    {
        DB::table("blog")->where('blog_id',$id)->delete();
        return redirect()->back()
        ->with([
            'success' => trans('custom.Blog_delete_success'),
            'title' => trans('custom.Blog_title')
        ]);
    }
    public function updateStatus(Request $request)
    {
        $request->validate([
            'id' => 'integer|exists:blog,blog_id',
            'status' => 'boolean', 
        ]);
    
        $blog = Blog::findOrFail($request->id);
    
        $blog->status = $request->status === '1' ? '0' : '1';
        $blog->save();
    
        return response()->json(['success' => true, 'message' => 'Blog status updated successfully.']);
    }

    public function deleteSection(Request $request)
    {
    
        $sectionId = $request->input('section_id');
        $blog_id = $request->input('blog_id');

        $section = BlogContent::where('id', $sectionId)->where('blog_id',$blog_id)->first(); 

        if ($section) {
            $section->delete();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Section not found'], 404);
    }
    public function blogDetails($category, $slug)
    {
        $blog = Blog::where('status', '1')->where('slug', $slug)->first();
        $blog_id = $blog->blog_id;
        if (!is_null($blog->related_blogs)) {
            $blog->related_blogs = json_decode($blog->related_blogs); 
        }
        $post = Post::firstOrCreate(
            ['id' => $blog_id],
            [
                'title' => $blog->title ?? 'Untitled',
                'content' => $blog->content ?? 'text',
            ]
        );
        $post->load('comments.user');
        $Blogcontents = BlogContent::where('blog_id', $blog_id)->get();
        $Blog_category = Blog_category::get();
        $seoData = SEO::where('page', 'home')->first();
        return view('front-end.Blog.blog_details',compact('seoData','blog','post','Blogcontents','Blog_category'));
    }

    public function blogIndex(Request $request)
    {
        $Blogs = Blog::where('status', '1')->with('categoryname')->orderBy('blog_id', 'desc')->paginate(9);
        $Blog_category = Blog_category::get();
        $seoData = SEO::where('page', 'home')->first();
        return view('front-end.Blog.blog',compact('Blogs','Blog_category','seoData'));
    }

    public function postComment(Request $request, $blog_id)
    {
        $request->validate([
            'comment' => 'required|string',
        ]);
      
        if (!Auth::check()) {
            return redirect()->route('user-login')->with('error', 'You need to be logged in to submit a comment.');
        }
    
        $comment = new Comments();
        $comment->blog_id = $blog_id;
        $comment->user_id = Auth::id();
        $comment->description = $request->input('comment');
        $comment->save();
        return redirect()->back()->with('success', 'Your comment has been posted.');
    }
    public function sharedatastore(Request $request){

        $share = new Share();
        $share->platfrom_name = $request->platform;
        $share->blog_id = $request->blog_id;
        $share->user_id = $request->user_id;
        $share->save();

        return response()->json(['success' => true, 'message' => 'Share data stored successfully']);
    }
    
}
