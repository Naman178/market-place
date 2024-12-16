<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Blog_category;
use App\Models\BlogContent;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;
use Auth;
use DB;


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
        $Blog = Blog::orderBy('blog.blog_id', 'asc')
                            ->get();
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
            
                    // Create the blog entry
                    $save_Blog = Blog::create([
                        'title' => $request->title,
                        'category' => $request->category,
                        'image' => $blog_originalImageName,
                        'short_description' => $request->short_description,
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
                                'content_description_1' => $section['description'] ?? null,
                                'content_description_2' => $section['description2'] ?? null,
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
                    if ($request->hasFile('blog_image')) {
                        $blog_originalImageName = $request->file('blog_image')->getClientOriginalName();
                        $destinationPath = public_path('storage/images/');
                        $request->file('blog_image')->move($destinationPath, $blog_originalImageName);
                    }
            
                    // Update the blog entry
                    $Blog->update([
                        'title' => $request->title,
                        'category' => $request->category,
                        'image' => $blog_originalImageName ?? $request->old_image,
                        'short_description' => $request->short_description,
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
                    if ($request->has('select_type')) {
                        // $contentSections = [];
            
                        // // Build content sections data
                        // foreach ($request->all() as $key => $value) {
                        //     if (strpos($key, 'select_type_') !== false) {
                        //         // Extract the section index from the key (e.g., select_type_1 -> 1)
                        //         $index = str_replace('select_type_', '', $key);
                                
                        //         // Store the selected type for each section
                        //         $contentSections[$index]['select_type'] = $value;
                        //     }
                        //     if (strpos($key, 'heading_') !== false && !empty($value)) {
                        //         $index = str_replace('heading_', '', $key);
                        //         $contentSections[$index]['heading'] = $value;
                        //     }
            
                        //     if (strpos($key, 'description_') !== false && !empty($value)) {
                        //         $index = str_replace('description_', '', $key);
                        //         $contentSections[$index]['description'] = $value;
                        //     }
            
                        //     if (strpos($key, 'description2_') !== false && !empty($value)) {
                        //         $index = str_replace('description2_', '', $key);
                        //         $contentSections[$index]['description2'] = $value;
                        //     }
            
                        //     if (strpos($key, 'image_') !== false) {
                        //         $index = str_replace('image_', '', $key);
                        //         if ($request->hasFile($key)) {
                        //             $file = $request->file($key);
                        //             $fileName = $file->getClientOriginalName();
                        //             $file->move(public_path('storage/images/'), $fileName);
                        //             $contentSections[$index]['image'] = $fileName;
                        //         } else {
                        //             // Retain the old image if no new one is uploaded
                        //             $oldImageKey = 'old_content_image_' . $index;
                        //             $contentSections[$index]['image'] = $request->input($oldImageKey);
                        //         }
                        //     }
                        // }
            
                        // // Step 4: Update Content Sections for the Blog in bulk
                        // $contentData = [];
                        // foreach ($contentSections as $section) {
                        //     $existingContent = BlogContent::where('blog_id', $Blog->blog_id)
                        //         ->first();
                        //     // Prepare data to insert or update
                        //     $contentDataItem = [
                        //         'blog_id' => $Blog->blog_id,
                        //         'content_type' => $section['select_type'] ?? null,
                        //         'content_heading' => $section['heading'] ?? null,
                        //         'content_description_1' => $section['description'] ?? null,
                        //         'content_description_2' => $section['description2'] ?? null,
                        //         'content_image' => $section['image'] ?? null,
                        //         'updated_at' => Carbon::now(),
                        //     ];
                        
                        //     // If content exists, update it
                        //     if ($existingContent) {
                        //         $existingContent->update($contentDataItem);
                        //     } else {
                        //         // If content doesn't exist, create a new entry
                        //         BlogContent::create($contentDataItem);
                        //     }
                        // }
                        $contentSections = [];

                        // Loop through the request data
                        foreach ($request->all() as $key => $value) {
                            // Check if the key matches the pattern 'heading_' followed by a number
                            if (preg_match('/^heading_(\d+)$/', $key, $matches)) {
                                $index = $matches[1]; // Extract the index from 'heading_0', 'heading_1', etc.

                                // Dynamically get the heading, description, and image for each index
                                $heading = $request->input('heading_' . $index); 
                                $description = $request->input('description_' . $index);
                                $image = $request->file('image_' . $index); // Handle the uploaded file
                                $oldImage = $request->input('old_content_image_' . $index); // Old image if exists

                                // Prepare data for this section
                                if ($heading || $description || $image || $oldImage) {
                                    $sectionData = [
                                        'content_heading' => $heading,
                                        'content_description_1' => $description,
                                        'content_image' => null, // Placeholder for image
                                        'content_description_2' => null, // If you have a second description field
                                        'updated_at' => Carbon::now(),
                                    ];

                                    // Handle image upload
                                    if ($image) {
                                        $imagePath = $image->store('images', 'public'); // Store the image
                                        $sectionData['content_image'] = $imagePath;
                                    } elseif ($oldImage) {
                                        $sectionData['content_image'] = $oldImage; // Use old image if no new one is uploaded
                                    }

                                    // Add the section data to the contentSections array
                                    $contentSections[] = $sectionData;
                                }
                            }
                        }
                        // Now you can use $contentSections to update or create entries in the BlogContent table
                        foreach ($contentSections as $sectionData) {
                            // Update or create logic (same as before)
                            $existingContent = BlogContent::where('blog_id', $Blog->blog_id)
                                                        ->first();
                                                        
                            if ($existingContent) {
                                $existingContent->update($sectionData);
                            } else {
                                
                                BlogContent::create($sectionData);
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
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'short_description' => 'string',
            'long_description' => 'string',
            'related_blog' => 'array', 
            'related_blog.*' => 'exists:blog,blog_id',
        ];
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

        $section = BlogContent::where('id', $sectionId)->first(); 

        if ($section) {
            $section->delete();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Section not found'], 404);
    }
}
