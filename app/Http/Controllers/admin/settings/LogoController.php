<?php

namespace App\Http\Controllers\admin\settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiteConfig;
use Illuminate\Support\Facades\Storage;


class LogoController extends Controller{

    public function uploadLogo(){
        $siteconfig = SiteConfig::first();
        if ($siteconfig == true) {
            return view('admin.settings.logo',compact('siteconfig'));
        }else{
            return view('admin.settings.logo');
        }
    }

    public function uploadLogoUpdate(Request $request){

        $siteconfig = SiteConfig::first();
        if ($siteconfig == true) {
            
            $data = SiteConfig::findOrFail(1);
            if ($request->has('header')) {
                if ($request->hasFile('web_logo_path')) {
                    $file = $request->file('web_logo_path');
                    $imageFileType = $file->extension();
                    $imageFilesize = $file->getSize();
                    $imageName = time().'.'.$imageFileType;  
            
                    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                        return redirect()->back()->with('message','Sorry, only JPG, JPEG, PNG & GIF files are allowed');
                    }elseif($imageFilesize > 1000000) {
                        return redirect()->back()->with('message','your file size is more than 1MB.');
                    }else{
                        Storage::disk('public')->delete('siteConfig/' . $data->web_logo_path);
                        $filePath = 'siteConfig/' . $imageName;
                        $file->storeAs('public', $filePath);
                        $data->web_logo_path = $imageName;
                    }
                }
            }
            if ($request->has('footer')) {
                if ($request->hasFile('web_logo_path2')) {
               
                    $file = $request->file('web_logo_path2');
                    $imageFileType = $file->extension();
                    $imageFilesize = $file->getSize();
                    $imageName = time().'.'.$imageFileType;  
                    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                        return redirect()->back()->with('message','Sorry, only JPG, JPEG, PNG & GIF files are allowed');
                    }elseif($imageFilesize > 1000000) {
                        return redirect()->back()->with('message','your file size is more than 1MB.');
                    }else{
                        Storage::disk('public')->delete('siteConfig/' . $data->web_logo_path2);
                        $filePath = 'siteConfig/' . $imageName;
                        $file->storeAs('public', $filePath);
                    
                        $data->web_logo_path2 = $imageName;
                    }
                }
            }
            if ($request->has('favicon')) {
                if ($request->hasFile('favicon')) {
               
                    $file = $request->file('favicon');
                    $imageFileType = $file->extension();
                    $imageFilesize = $file->getSize();
                    $imageName = time().'.'.$imageFileType;  
                    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                        return redirect()->back()->with('message','Sorry, only JPG, JPEG, PNG & GIF files are allowed');
                    }elseif($imageFilesize > 500000) {
                        return redirect()->back()->with('message','your file size is more than 500kb.');
                    }else{
                        Storage::disk('public')->delete('siteConfig/' . $data->favicon);
                        $filePath = 'siteConfig/' . $imageName;
                        $file->storeAs('public', $filePath);
                    
                        $data->favicon = $imageName;
                    }
                }
            }
            $data->save();
        }else{
            $data = new SiteConfig();
            if ($request->has('header')) {
                if ($request->hasFile('web_logo_path')) {
               
                    $file = $request->file('web_logo_path');
                    $imageFileType = $file->extension();
                    $imageFilesize = $file->getSize();
                    $imageName = time().'.'.$imageFileType;  
                    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                        return redirect()->back()->with('message','Sorry, only JPG, JPEG, PNG & GIF files are allowed');
                    }elseif($imageFilesize > 1000000) {
                        return redirect()->back()->with('message','your file size is more than 4MB.');
                    }else{
                        $filePath = 'siteConfig/' . $imageName;
                        $file->storeAs('public', $filePath);

                        $data->web_logo_path = $imageName;
                    }
                }
            }
            if ($request->has('footer')) {
                if ($request->hasFile('web_logo_path2')) {
               
                    $file = $request->file('web_logo_path2');
                    $imageFileType = $file->extension();
                    $imageFilesize = $file->getSize();
                    $imageName = time().'.'.$imageFileType;  
                    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                        return redirect()->back()->with('message','Sorry, only JPG, JPEG, PNG & GIF files are allowed');
                    }elseif($imageFilesize > 1000000) {
                        return redirect()->back()->with('message','your file size is more than 4MB.');
                    }else{
                        $filePath = 'siteConfig/' . $imageName;
                        $file->storeAs('public', $filePath);     
                        $data->web_logo_path2 = $imageName;
                    }
                }
            }
            if ($request->has('favicon')) {
                if ($request->hasFile('favicon')) {
               
                    $file = $request->file('favicon');
                    $imageFileType = $file->extension();
                    $imageFilesize = $file->getSize();
                    $imageName = time().'.'.$imageFileType;  
                    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                        return redirect()->back()->with('message','Sorry, only JPG, JPEG, PNG & GIF files are allowed');
                    }elseif($imageFilesize > 5000000) {
                        return redirect()->back()->with('message','your file size is more than 4MB.');
                    }else{
                        $filePath = 'siteConfig/' . $imageName;
                        $file->storeAs('public', $filePath);

                        $data->favicon = $imageName;
                    }
                }
            }
            $data->save();
        }
        return redirect()->route('admin.uploadLogo')->with('message', 'Data Updated Sucessfully');
    }

}
