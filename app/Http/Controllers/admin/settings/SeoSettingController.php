<?php

namespace App\Http\Controllers\admin\settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiteConfig;

class SeoSettingController extends Controller{

    public function seoSettings(){
        $siteconfig = SiteConfig::first();
        if ($siteconfig == true) {
            return view('admin.settings.seosetting',compact('siteconfig'));
        }else{
            return view('admin.settings.seosetting');
        }
    }

    public function seoSettingsUpdate(Request $request){
        $siteconfig = SiteConfig::first();
        if ($siteconfig == true) {
            
            $data = SiteConfig::findOrFail(1);
                $data->title = $request->title;
                $data->keyword = $request->keyword;
                $data->description = $request->description;
                $data->save();
        }else{
            $data = new SiteConfig();
            $data->title = $request->title;
            $data->keyword = $request->keyword;
            $data->description = $request->description;
            $data->save();
        }
        return redirect()->route('admin.seoSettings')->with('message', 'Data Updated Sucessfully');
    }
}
