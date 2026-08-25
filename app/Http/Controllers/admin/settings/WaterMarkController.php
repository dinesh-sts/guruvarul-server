<?php

namespace App\Http\Controllers\admin\settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Redirect;
use App\Models\SiteConfig;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Log;

class WaterMarkController extends Controller
{
    public function watermark()
    {
        $siteconfig = SiteConfig::first();
        if ($siteconfig == true) {
            return view('admin.settings.watermark',compact('siteconfig'));
        }else{
            return view('admin.settings.watermark');
        }
    }

    public function watermarkupdate(Request $request)
    {
        $siteconfig = SiteConfig::first();
        if ($siteconfig == true) {
            
            $data = SiteConfig::findOrFail(1);
                if ($request->hasFile('watermark')) {
                    $file = $request->file('watermark');
                    $imageFileType = $file->extension();
                    $imageFilesize = $file->getSize();
                    $imageName = time().'.'.$imageFileType;  
            
                    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                        return redirect()->back()->with('message','Sorry, only JPG, JPEG, PNG & GIF files are allowed');
                    }elseif($imageFilesize > 500000) {
                        return redirect()->back()->with('message','your file size is more than 500kb.');
                    }else{
                        Storage::disk('public')->delete('SiteConfig/' . $data->watermark);
                        $filePath = 'SiteConfig/' . $imageName;
                        $file->storeAs('public', $filePath);
                        $data->watermark = $imageName;
                    }
                }
            $data->save();
        }else{
            $data = new SiteConfig();
                if ($request->hasFile('watermark')) {
               
                    $file = $request->file('watermark');
                    $imageFileType = $file->extension();
                    $imageFilesize = $file->getSize();
                    $imageName = time().'.'.$imageFileType;  
                    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                        return redirect()->back()->with('message','Sorry, only JPG, JPEG, PNG & GIF files are allowed');
                    }elseif($imageFilesize > 500000) {
                        return redirect()->back()->with('message','your file size is more than 500kb.');
                    }else{
                        $filePath = 'SiteConfig/' . $imageName;
                        $file->storeAs('public', $filePath);

                        $data->watermark = $imageName;
                    }
                }
            $data->save();
        }
        return redirect()->route('setting.watermark')->with('message', 'Data Update Sucessfully');
    }
}
