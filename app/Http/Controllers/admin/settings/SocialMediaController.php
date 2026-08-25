<?php

namespace App\Http\Controllers\admin\settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiteConfig;


class SocialMediaController extends Controller{

    public function socialMediaLinks(){
        $siteconfig = SiteConfig::first();
        if ($siteconfig == true) {
            return view('admin.settings.social',compact('siteconfig'));
        }else{
            return view('admin.settings.social');
        }
    }

    public function socialMediaLinksUpdate(Request $request){
        $siteconfig = SiteConfig::first();
        if ($siteconfig == true) {
            $data = SiteConfig::findOrFail(1);
            $data->facebook = $request->facebook;
            $data->facebook_status = $request->facebook_status;
            $data->instagram = $request->instagram;
            $data->instagram_status = $request->instagram_status;
            $data->twitter = $request->twitter;
            $data->twitter_status = $request->twitter_status;
            $data->linkedin = $request->linkedin;
            $data->linkedin_status = $request->linkedin_status;
            $data->youtube = $request->youtube;
            $data->youtube_status = $request->youtube_status;
            $data->pinterest = $request->pinterest;
            $data->pinterest_status = $request->pinterest_status;
            $data->save();
        }else{
            $data = new SiteConfig();
            $data->facebook = $request->facebook;
            $data->facebook_status = $request->facebook_status;
            $data->instagram = $request->instagram;
            $data->instagram_status = $request->instagram_status;
            $data->twitter = $request->twitter;
            $data->twitter_status = $request->twitter_status;
            $data->linkedin = $request->linkedin;
            $data->linkedin_status = $request->linkedin_status;
            $data->youtube = $request->youtube;
            $data->youtube_status = $request->youtube_status;
            $data->pinterest = $request->pinterest;
            $data->pinterest_status = $request->pinterest_status;
            $data->save();
        }
        return redirect()->route('admin.socialMediaLinks')->with('message', 'Data Updated Sucessfully');
    }
}
