<?php

namespace App\Http\Controllers\admin\settings;

use App\Http\Controllers\Controller;
use App\Models\SiteConfig;
use Illuminate\Http\Request;

class WhatsappButtonController extends Controller
{
    public function whatsappButtonSettings(){
        $siteconfig = SiteConfig::first();

        return view('admin.settings.whatsappSettings',compact('siteconfig'));
    }

    public function whatsappButtonSettingsUpdate(Request $request){
        $siteconfig = SiteConfig::first();

        $request->validate([
            'whatsapp_btn_text' => 'required',
            'whatsapp_no' => 'required',
            'whatsapp_btn_status' => 'required'
        ]);

        $siteconfig->whatsapp_btn_text = $request->whatsapp_btn_text;
        $siteconfig->whatsapp_no = $request->whatsapp_no;
        $siteconfig->whatsapp_btn_status = $request->whatsapp_btn_status;
        $siteconfig->save();

        return redirect()->route('admin.whatsappButtonSettings')->with('message', 'Data Updated Sucessfully');
    }
}
