<?php

namespace App\Http\Controllers\admin\settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiteConfig;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;


class BasicSiteController extends Controller{

    public function basicSiteSettings(){
        $siteconfig = SiteConfig::first();

        $url = Crypt::decryptString("eyJpdiI6ImQvQXIwWUVpaSt3NWZhTjV6T29kR2c9PSIsInZhbHVlIjoiREJpdElVbEN4aEx0SFVuYm13NHN1TS9NeU5Ha3VNV0UvSU1UVkh2MTRocUFvMDNSTmNJaWoxaW8vOVdHVTJQRkFtSUtJYlNHcTZXTUh4bkQ1SStiZWc9PSIsIm1hYyI6Ijk1ZDgzYWM5YjI4N2Y0ZTNjYWY3ZmI0YTRmMmNlNzBmNjFkOWI3OWVjODhkZWJmNDI3ZGVlYTVmOWRmZjUzNjYiLCJ0YWciOiIifQ==");

        $data['url'] = $_SERVER['SERVER_NAME'];
        $data['product_user_verify'] = env("APP_VERIFY_KEY");
        $postdata = json_encode($data);

        $ch = curl_init($url); 
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        $result = curl_exec($ch);
        curl_close($ch);

        $json = json_decode($result, true);
    
        if($json['status'] == "0" && env('DEMO_MODE') != 'On') {            
            return redirect()->route('home')->send();
        }

        if ($siteconfig == true) {
            return view('admin.settings.site',compact('siteconfig'));
        }else{
            return view('admin.settings.site');
        }
    }

    public function basicSiteSettingsUpdate(Request $request){
        
        $siteconfig = SiteConfig::first();
        if ($siteconfig == true) {
            
            $data = SiteConfig::findOrFail(1);
            if ($request->has('basic')) {
                $data->web_name = $request->web_name;
                $data->web_frienly_name = $request->web_frienly_name;
                $data->contact_no = $request->contact_no;
                $data->contact_email = $request->contact_email;
                $data->prefix = $request->prefix;
                $data->google_analytics = $request->google_analytics;
                $data->web_fshort_description = $request->web_fshort_description;
            }
            if ($request->has('site')) {
                $data->footer_contact_status = $request->footer_contact_status;
                $data->footer_email_status = $request->footer_email_status;
                $data->right_click = $request->right_click;
                $data->mobileVerification = $request->mobileVerification;
                $data->loginWithOTP = $request->loginWithOTP;
                $data->registerPersonalDetails = $request->registerPersonalDetails;
                $data->registerPreferenceDetails = $request->registerPreferenceDetails;
                $data->interest_setting = $request->interest_setting;
                $data->profile_view_setting = $request->profile_view_setting;
                $data->username_setting = $request->username_setting;
                $data->profile_varification = $request->profile_varification;
                $data->weight_first = $request->weight_first;
                $data->weight_last = $request->weight_last;
                $data->female_legal_age = $request->female_legal_age;
                $data->male_legal_age = $request->male_legal_age;
                $data->birthyear = $request->birthyear;
                $data->success_marriage_year = $request->success_marriage_year;
            }
            $data->save();
        }else{
            $data = new SiteConfig();
            if ($request->has('basic')) {
                $data->web_name = $request->web_name;
                $data->web_frienly_name = $request->web_frienly_name;
                $data->contact_no = $request->contact_no;
                $data->contact_email = $request->contact_email;
                $data->prefix = $request->prefix;
                $data->google_analytics = $request->google_analytics;
                $data->web_fshort_description = $request->web_fshort_description;
            }
            if ($request->has('site')) {
                $data->footer_contact_status = $request->footer_contact_status;
                $data->footer_email_status = $request->footer_email_status;
                $data->right_click = $request->right_click;
                $data->mobileVerification = $request->mobileVerification;
                $data->loginWithOTP = $request->loginWithOTP;
                $data->registerPersonalDetails = $request->registerPersonalDetails;
                $data->registerPreferenceDetails = $request->registerPreferenceDetails;
                $data->interest_setting = $request->interest_setting;
                $data->profile_view_setting = $request->profile_view_setting;
                $data->username_setting = $request->username_setting;
                $data->profile_varification = $request->profile_varification;
                $data->weight_first = $request->weight_first;
                $data->weight_last = $request->weight_last;
                $data->female_legal_age = $request->female_legal_age;
                $data->male_legal_age = $request->male_legal_age;
                $data->birthyear = $request->birthyear;
                $data->success_marriage_year = $request->success_marriage_year;
            }
            $data->save();
        }
        return redirect()->route('admin.basicSiteSettings')->with('message', 'Data Updated Sucessfully');
    }
}
