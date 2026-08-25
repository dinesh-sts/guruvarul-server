<?php

namespace App\Http\Controllers\admin\settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiteConfig;
use Illuminate\Support\Facades\Storage;


class HomepageController extends Controller{

    public function homepageConfig(){
        $siteconfig = SiteConfig::first();
        if ($siteconfig == true) {
            return view('admin.settings.homePageSettings',compact('siteconfig'));
        }else{
            return view('admin.settings.homePageSettings');
        }
    }

    public function uploadBannerUpdate(Request $request){
        if(env('DEMO_MODE') == 'On'){
            return redirect()->back()->with('message', 'Disabled In Demo');
        }
        $siteconfig = SiteConfig::first();
        if ($siteconfig == true) {
            
            $data = SiteConfig::findOrFail(1);
            if ($request->has('banner1')) {
                if ($request->hasFile('banner1')) {
                    $file = $request->file('banner1');
                    $imageFileType = $file->extension();
                    $imageFilesize = $file->getSize();
                    $imageName = time().'.'.$imageFileType;  
            
                    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                        return redirect()->back()->with('message','Sorry, only JPG, JPEG, PNG & GIF files are allowed');
                    }elseif($imageFilesize > 2000000) {
                        return redirect()->back()->with('message','your file size is more than 2MB.');
                    }else{
                        Storage::disk('public')->delete('siteConfig/' . $data->banner1);
                        $filePath = 'siteConfig/' . $imageName;
                        $file->storeAs('public', $filePath);
                        $data->banner1 = $imageName;
                    }
                }
            }
            if ($request->has('banner2')) {
                if ($request->hasFile('banner2')) {
               
                    $file = $request->file('banner2');
                    $imageFileType = $file->extension();
                    $imageFilesize = $file->getSize();
                    $imageName = time().'.'.$imageFileType;  
                    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                        return redirect()->back()->with('message','Sorry, only JPG, JPEG, PNG & GIF files are allowed');
                    }elseif($imageFilesize > 2000000) {
                        return redirect()->back()->with('message','your file size is more than 2MB.');
                    }else{
                        Storage::disk('public')->delete('siteConfig/' . $data->banner2);
                        $filePath = 'siteConfig/' . $imageName;
                        $file->storeAs('public', $filePath);
                    
                        $data->banner2 = $imageName;
                    }
                }
            }
            if ($request->has('banner3')) {
                if ($request->hasFile('banner3')) {
               
                    $file = $request->file('banner3');
                    $imageFileType = $file->extension();
                    $imageFilesize = $file->getSize();
                    $imageName = time().'.'.$imageFileType;  
                    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                        return redirect()->back()->with('message','Sorry, only JPG, JPEG, PNG & GIF files are allowed');
                    }elseif($imageFilesize > 2000000) {
                        return redirect()->back()->with('message','your file size is more than 2MB.');
                    }else{
                        Storage::disk('public')->delete('siteConfig/' . $data->banner3);
                        $filePath = 'siteConfig/' . $imageName;
                        $file->storeAs('public', $filePath);
                    
                        $data->banner3 = $imageName;
                    }
                }
            }
            $data->save();
        }else{
            $data = new SiteConfig();
            if ($request->has('banner1')) {
                if ($request->hasFile('banner1')) {
               
                    $file = $request->file('banner1');
                    $imageFileType = $file->extension();
                    $imageFilesize = $file->getSize();
                    $imageName = time().'.'.$imageFileType;  
                    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                        return redirect()->back()->with('message','Sorry, only JPG, JPEG, PNG & GIF files are allowed');
                    }elseif($imageFilesize > 2000000) {
                        return redirect()->back()->with('message','your file size is more than 4MB.');
                    }else{
                        $filePath = 'siteConfig/' . $imageName;
                        $file->storeAs('public', $filePath);

                        $data->banner1 = $imageName;
                    }
                }
            }
            if ($request->has('banner2')) {
                if ($request->hasFile('banner2')) {
               
                    $file = $request->file('banner2');
                    $imageFileType = $file->extension();
                    $imageFilesize = $file->getSize();
                    $imageName = time().'.'.$imageFileType;  
                    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                        return redirect()->back()->with('message','Sorry, only JPG, JPEG, PNG & GIF files are allowed');
                    }elseif($imageFilesize > 2000000) {
                        return redirect()->back()->with('message','your file size is more than 4MB.');
                    }else{
                        $filePath = 'siteConfig/' . $imageName;
                        $file->storeAs('public', $filePath);     

                        $data->banner2 = $imageName;
                    }
                }
            }
            if ($request->has('banner3')) {
                if ($request->hasFile('banner3')) {
               
                    $file = $request->file('banner3');
                    $imageFileType = $file->extension();
                    $imageFilesize = $file->getSize();
                    $imageName = time().'.'.$imageFileType;  
                    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                        return redirect()->back()->with('message','Sorry, only JPG, JPEG, PNG & GIF files are allowed');
                    }elseif($imageFilesize > 2000000) {
                        return redirect()->back()->with('message','your file size is more than 4MB.');
                    }else{
                        $filePath = 'siteConfig/' . $imageName;
                        $file->storeAs('public', $filePath);

                        $data->banner3 = $imageName;
                    }
                }
            }
            $data->save();
        }
        return redirect()->route('admin.uploadBanner')->with('message', 'Data Updated Sucessfully');
    }

    public function homepageConfigUpdate(Request $request){
        if(env('DEMO_MODE') == 'On'){
            return redirect()->back()->with('message', 'Disabled In Demo');
        }
        $siteconfig = SiteConfig::first();
        if ($siteconfig == true) {
            $siteconfig->homepage_register = $request->homepage_register;
            $siteconfig->homepage_search = $request->homepage_search;
            $siteconfig->homepage_steps = $request->homepage_steps;
            $siteconfig->homepage_fbride = $request->homepage_fbride;
            $siteconfig->homepage_fgroom = $request->homepage_fgroom;
            $siteconfig->homepage_success_story = $request->homepage_success_story;
            $siteconfig->save();
        }
        return redirect()->route('admin.homepageConfig')->with('message', 'Data Updated Sucessfully');
    }
}
