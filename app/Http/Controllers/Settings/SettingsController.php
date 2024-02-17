<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class SettingsController extends Controller
{
    public function index(){
        $user_id = auth()->user()->id;
        $site = Settings::where('key','site_setting')->first();
        $login_register = Settings::where('key','login_register_settings')->first();
        return view('pages.settings.index',compact('login_register' , "site"));
    }

    public function store(Request $request){
        // dd($request->all());
        if($request->key == 'site_setting'){
            $settings = Settings::where('key','site_setting')->first();

            $header_image = '';
            $signature_of_buyer = '';
            $signature_of_seller = '';

            if($request->hasFile('logo_image'))
            {
                $logo_image = $request->logo_image ? uniqid() . '_' . trim($request->logo_image->getClientOriginalName()) : '';
                $logo_image ? $request->file('logo_image')->move(public_path('storage/Logo_Settings/'),$logo_image) : '';
            }
            else{
                $logo_image = $request->logo_image_same;
            }

            if($request->hasFile('site_favicon'))
            {
                $site_favicon = $request->site_favicon ? uniqid() . '_' . trim($request->site_favicon->getClientOriginalName()) : '';
                $site_favicon ? $request->file('site_favicon')->move(public_path('storage/Logo_Settings/'),$site_favicon) : '';
            }
            else{
                $site_favicon = $request->favicon;
            }

            $finalArr = [];
            $finalArr['site_name'] = $request->site_name;
            $finalArr['logo_image'] = $logo_image;
            $finalArr['site_favicon'] = $site_favicon;

            if(!$settings){
                $setting = new Settings();
                $setting->key = $request->key;
                $setting->value = $finalArr ?? '';
                $setting->save();
            }else{
                Settings::where('id',$settings->id)
                ->update([
                    "key" => $request->key,
                    'value' => $finalArr ?? '',
                ]);
            }
            session()->flash('success', 'General Settings Saved Successfully!');
            return response()->json([
                'success' => 'General Settings Saved Successfully!',
                'title' => 'General Settings'
            ]);
        }
        elseif($request->key == 'login_register_settings'){
            $settings = Settings::where('key','login_register_settings')->first();

            $login_register_bg = '';

            if($request->hasFile('login_register_bg'))
            {
                $login_register_bg = $request->login_register_bg ? uniqid() . '_' . trim($request->login_register_bg->getClientOriginalName()) : '';
                $login_register_bg ? $request->file('login_register_bg')->move(public_path('storage/Login_Register_Settings/'),$login_register_bg) : '';
            }
            else{
                $login_register_bg = $request->login_register_bg_same;
            }

            $finalArr = [];

            $finalArr['login_register_bg'] = $login_register_bg;

            if(!$settings){
                $setting = new Settings();
                $setting->key = $request->key;
                $setting->value = $finalArr ?? '';
                $setting->save();
            }else{
                Settings::where('id',$settings->id)
                ->update([
                    'value' => $finalArr ?? '',
                ]);
            }
            session()->flash('success', 'Login Register Settings Saved Successfully!');
            return response()->json([
                'success' => 'Login Register Settings Saved Successfully!',
                'title' => 'Login Register Settings'
            ]);
        }
    }
}
