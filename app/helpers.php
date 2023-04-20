<?php

use App\Models\Settings;
use Illuminate\Support\Facades\Storage;

if (! function_exists('settings')) {
    function settings($key) {
        $setting = Settings::where('key', $key)->first();

        return $setting?->value;
    }
}

if (! function_exists('update_settings')) {
    function update_settings($key, $value) {
        $setting = Settings::where('key', $key)->first();

        if($setting){
            $setting->value = $value;
            $setting->save();
        }
    }
}

if (! function_exists('site_logo')) {
    function site_logo() {
        return asset('img/logo.svg');
        // $file = settings('logo');

        // return asset('storage/'.$file);

        // if (Storage::disk('do')->exists($file)) {
        //    return Storage::disk('do')->url($file);
        // }

        // return asset('storage/' . $file);
    }
}

if(! function_exists('parse_json_result')){
    function parse_json_result($content)
    {
        $json = json_encode($content);
        $decode = json_decode($json);
        $data =  json_decode(str_replace("\\\"", "\"", $decode), true);

        return $data;
    }
}

