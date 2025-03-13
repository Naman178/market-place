<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Artisan;

class SettingsController extends Controller
{
    public function index(){
        $user_id = auth()->user()->id;
        $site = Settings::where('key','site_setting')->first();
        $login_register = Settings::where('key','login_register_settings')->first();
        $stripe_setting = Settings::where('key','stripe_setting')->first();
        $smtp_setting = Settings::where('key','smtp_setting')->first();
        return view('pages.settings.index',compact('login_register' ,"stripe_setting","smtp_setting", "site"));
    }
    public function updateEnvValue($key, $value)
    {
        $envFile = base_path('.env');
        $contents = file_get_contents($envFile);

        // Check if the key exists
        if (strpos($contents, "{$key}=") !== false) {
            // Replace the existing key with the new value
            $contents = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $contents);
        } else {
            // If key doesn't exist, append it to the end
            $contents .= "\n{$key}={$value}\n";
        }

        file_put_contents($envFile, $contents);
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
            $finalArr['address_1'] = $request->address1;
            $finalArr['address_2'] = $request->address2;
            $finalArr['city'] = $request->city;
            $finalArr['state'] = $request->state;
            $finalArr['country'] = $request->country;
            $finalArr['gst'] = $request->gst;
            $finalArr['pin'] = $request->pin;
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
        elseif($request->key == 'stripe_setting'){
            $settings = Settings::where('key','stripe_setting')->first();
            $finalArr = [];
            $finalArr['stripe_key'] = $request->stripe_key;
            $finalArr['stripe_secret'] = $request->stripe_secret;

            if ($request->has('stripe_key')) {
                $this->updateEnvValue('STRIPE_KEY', $request->stripe_key);
            }
        
            if ($request->has('stripe_secret')) {
                $this->updateEnvValue('STRIPE_SECRET', $request->stripe_secret);
            }
            
            // Clear Laravel config cache to reflect changes
            // Artisan::call('config:clear');
            // Artisan::call('cache:clear'); 

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
        elseif($request->key == 'smtp_setting'){
            $settings = Settings::where('key','smtp_setting')->first();
            $finalArr = [];
            $finalArr['mail_mailer'] = $request->mail_mailer;
            $finalArr['mail_host'] = $request->mail_host;
            $finalArr['mail_port'] = $request->mail_port;
            $finalArr['mail_username'] = $request->mail_username;
            $finalArr['mail_pass'] = $request->mail_pass;
            $finalArr['mail_encryption'] = $request->mail_encryption;
            $finalArr['mail_sender'] = $request->mail_sender;
            $finalArr['mail_app'] = $request->mail_app;

            if ($request->has('mail_mailer')) {
                $this->updateEnvValue('MAIL_MAILER', $request->mail_mailer);
            }
        
            if ($request->has('mail_host')) {
                $this->updateEnvValue('MAIL_HOST', $request->mail_host);
            }
            if ($request->has('mail_port')) {
                $this->updateEnvValue('MAIL_PORT', $request->mail_port);
            }
        
            if ($request->has('mail_username')) {
                $this->updateEnvValue('MAIL_USERNAME', $request->mail_username);
            }
            if ($request->has('mail_pass')) {
                $this->updateEnvValue('MAIL_PASSWORD', $request->mail_pass);
            }
        
            if ($request->has('mail_encryption')) {
                $this->updateEnvValue('MAIL_ENCRYPTION', $request->mail_encryption);
            }
            if ($request->has('mail_sender')) {
                $this->updateEnvValue('MAIL_FROM_ADDRESS', $request->mail_sender);
            }
        
            if ($request->has('mail_app')) {
                $this->updateEnvValue('MAIL_FROM_NAME', $request->mail_app);
            }
            
            // Clear Laravel config cache to reflect changes
            // Artisan::call('config:clear');
            // Artisan::call('cache:clear'); 

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
