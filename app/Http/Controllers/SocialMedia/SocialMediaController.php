<?php

namespace App\Http\Controllers\SocialMedia;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SocialMedia;
use App\Models\SEO;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;
use DB;


class SocialMediaController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:SocialMedia-list|SocialMedia-create|SocialMedia-edit|SocialMedia-delete', ['only' => ['index','show']]);
        $this->middleware('permission:SocialMedia-create', ['only' => ['edit','store']]);
        $this->middleware('permission:SocialMedia-edit', ['only' => ['edit','store']]);
        $this->middleware('permission:SocialMedia-delete', ['only' => ['destroy']]);
        $this->middleware('permission:SocialMedia-tab-show', ['only' => ['index' , 'show' , 'edit' , 'store', 'destroy']]);
    }
    public function index()
    {
        $socialmedia = SocialMedia::orderBy('social_media.id', 'asc')
                            ->get();
        return view('pages.SocialMedia.SocialMedia',compact('socialmedia'));
    }

    public function edit($id)
    {
        $socialmedia = SocialMedia::where('id',$id)->first();

        return view('pages.SocialMedia.edit',compact('socialmedia'));
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
                    $save_SocialMedia = SocialMedia::create([
                        'name' => $request->name,
                        'link' => $request->link,
                        'image' => $originalImageName ?? null,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);

                    session()->flash('success', trans('custom.SocialMedia_create_success'));
                    return response()->json([
                        'success' => trans('custom.SocialMedia_create_success'),
                        'title' => trans('custom.SocialMedia_title'),
                        'type' => 'create',
                        'data' => $save_SocialMedia
                    ], Response::HTTP_OK);
                }else{
                    $SocialMedia = SocialMedia::where('id',$request->scid);

                    if ($request->hasFile('image')) {
                        $originalImageName = $request->file('image')->getClientOriginalName();
                        $destinationPath = public_path('storage/images/');
                    
                        $request->file('image')->move($destinationPath, $originalImageName);
                    } else {
                        $originalImageName = $request->old_image;  
                    }
                    $SocialMedia->update([
                        'name' => $request->name, 
                        'link' => $request->link,
                        'image' => $originalImageName,
                        'updated_at' => Carbon::now(),
                    ]);

                    session()->flash('success', trans('custom.SocialMedia_update_success'));
                    return response()->json([
                        'success' => trans('custom.SocialMedia_update_success'),
                        'title' => trans('custom.SocialMedia_title'),
                        'type' => 'update',
                        'data' => $SocialMedia
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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'link' => 'required|string|max:255',
        ];
        return Validator::make($request->all(), $rules);
    }
 

    public function remove($id)
    {
        DB::table("social_media")->where('id',$id)->delete();
        return redirect()->back()
        ->with([
            'success' => trans('custom.SocialMedia_delete_success'),
            'title' => trans('custom.SocialMedia_title')
        ]);
    }
}
