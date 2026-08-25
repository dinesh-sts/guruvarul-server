<?php


namespace App\Http\Controllers\admin\settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiteConfig;

class AppearanceController extends Controller
{
    public function themeColorChange(){
        $siteConfig = SiteConfig::first();
        return view('admin.settings.themeColorChange',compact('siteConfig'));
    }

    public function themeColorChangeUpdate(Request $request){
        if(env('DEMO_MODE') == 'On'){
            return redirect()->back()->with('message', 'Disabled In Demo');
        }
        $siteConfig = SiteConfig::first();
        if($request->has('update')){
            $siteConfig->colorPrimary = $request->colorPrimary;
            $siteConfig->colorSecondary = $request->colorSecondary; 
            $siteConfig->colorPrimaryHover = $request->colorPrimaryHover;
            $siteConfig->colorSecondaryHover = $request->colorSecondaryHover; 
        }
        if($request->has('reset')){
            $siteConfig->colorPrimary = "#ff0081"; 
            $siteConfig->colorSecondary = "#233350"; 
            $siteConfig->colorPrimaryHover = "#e20575"; 
            $siteConfig->colorSecondaryHover = "#2f446a"; 
        }
        $siteConfig->save();

        return redirect()->back()->with('message','Color updated successfully.');
    }
}
