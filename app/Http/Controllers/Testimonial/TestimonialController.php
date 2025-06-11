<?php

namespace App\Http\Controllers\Testimonial;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonials;
use App\Models\SEO;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;
use DB;

class TestimonialController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:Testimonial-list|Testimonial-create|Testimonial-edit|Testimonial-delete', ['only' => ['index','show']]);
        $this->middleware('permission:Testimonial-create', ['only' => ['edit','store']]);
        $this->middleware('permission:Testimonial-edit', ['only' => ['edit','store']]);
        $this->middleware('permission:Testimonial-delete', ['only' => ['destroy']]);
        $this->middleware('permission:Testimonial-tab-show', ['only' => ['index' , 'show' , 'edit' , 'store', 'destroy']]);
    }
    public function index()
    {
        $testimonial = Testimonials::orderBy('testimonials.id', 'desc')
                            ->get();
        return view('pages.Testimonial.Testimonial',compact('testimonial'));
    }

    public function edit($id)
    {
        $testimonial = Testimonials::where('id',$id)->first();

        return view('pages.Testimonial.edit',compact('testimonial'));
    }

    public function store(Request $request){
        if($request->ajax()){
            $validator = $this->validateRequest($request);
            if ($validator->passes()){
                if($request->scid == "0"){
                    
                    // Handle file upload
                   
                    if ($request->hasFile('image')) {
                        $originalImageName = $request->file('image')->getClientOriginalName();

                        $destinationPath = public_path('storage/images/');

                        $request->file('image')->move($destinationPath, $originalImageName);
                    }
                    $save_Testimonial = Testimonials::create([
                        'name' => $request->name,
                        'message' => $request->message,
                        'image' => $originalImageName ?? null,
                        'designation' => $request->designation,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);

                    session()->flash('success', trans('custom.Testimonial_create_success'));
                    return response()->json([
                        'success' => trans('custom.Testimonial_create_success'),
                        'title' => trans('custom.Testimonial_title'),
                        'type' => 'create',
                        'data' => $save_Testimonial
                    ], Response::HTTP_OK);
                }else{
                    $Testimonial = Testimonials::where('id',$request->scid);

                    if ($request->hasFile('image')) {
                        $originalImageName = $request->file('image')->getClientOriginalName();
                        $destinationPath = public_path('storage/images/');
                    
                        $request->file('image')->move($destinationPath, $originalImageName);
                    } else {
                        $originalImageName = $request->old_image;  
                    }
                    $Testimonial->update([
                        'name' => $request->name,
                        'message' => $request->message,
                        'designation' => $request->designation,
                        'image' => $originalImageName,
                        'updated_at' => Carbon::now(),
                    ]);

                    session()->flash('success', trans('custom.Testimonial_update_success'));
                    return response()->json([
                        'success' => trans('custom.Testimonial_update_success'),
                        'title' => trans('custom.Testimonial_title'),
                        'type' => 'update',
                        'data' => $Testimonial
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
            'name' => 'required|string|max:255',
            // 'description' => 'required|string',
            // 'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'designation' => 'required|string|max:255',
            'message' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    // Strip HTML tags and check if empty or only whitespace
                    if (trim(strip_tags($value)) === '') {
                        $fail('The Message is required.');
                    }
                }
            ],
        ];
        if ($request->scid == "0") {
            $rules['image'] = 'required|image|mimes:jpeg,png,jpg,gif|max:2048';
        }
        return Validator::make($request->all(), $rules);
    }
 

    public function remove($id)
    {
        DB::table("testimonials")->where('id',$id)->delete();
        return redirect()->back()
        ->with([
            'success' => trans('custom.Testimonial_delete_success'),
            'title' => trans('custom.Testimonial_title')
        ]);
    }
}
