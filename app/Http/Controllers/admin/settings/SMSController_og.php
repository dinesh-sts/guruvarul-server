<?php

namespace App\Http\Controllers\admin\settings;

use App\Http\Controllers\Controller;
use App\Models\Sms;
use Illuminate\Http\Request;

class SMSController extends Controller{

    public function smsSettings(){
        $key = Sms::where('key','fast2smsKey')->first();
        $route = Sms::where('key','fast2smsRoute')->first();
        $activeapi = Sms::where('key','activeapi')->first();
        return view('admin.settings.sms',compact('key','route','activeapi'));
       
    }

    public function smsSettingsUpdate(Request $request){   
        if($request->activeapi == "msg91"){
           $route = null;
           $key= null;
        }else{
            $route = $request->route;
            $key= $request->key;
        }
        $data = Sms::FindOrFail(1);
        $data->value = $key;
        $data->save();

        $data = Sms::FindOrFail(2);
        $data->value = $route;
        $data->save();

        $data = Sms::FindOrFail(3);
        $data->value = $request->activeapi;
        $data->save();
        return redirect()->route('admin.smsSettings')->with('message', 'Data Updated Sucessfully');
    }
}
