<?php

namespace App\Http\Controllers\admin\settings;

use App\Http\Controllers\Controller;
use App\Models\Sms;
use Illuminate\Http\Request;

class SMSController extends Controller{

    /*public function smsSettings(){
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
    }*/
	
	public function smsSettings()
    {
        $firebaseConfig = [
            'apiKey' => Sms::where('key', 'firebase_api_key')->first(),
            'authDomain' => Sms::where('key', 'firebase_auth_domain')->first(),
            'projectId' => Sms::where('key', 'firebase_project_id')->first(),
            'storageBucket' => Sms::where('key', 'firebase_storage_bucket')->first(),
            'messagingSenderId' => Sms::where('key', 'firebase_messaging_sender_id')->first(),
            'appId' => Sms::where('key', 'firebase_app_id')->first(),
            'measurementId' => Sms::where('key', 'firebase_measurement_id')->first(),
        ];
        $activeapi = Sms::where('key', 'activeapi')->first();

        return view('admin.settings.sms', compact('firebaseConfig', 'activeapi'));
    }

    public function smsSettingsUpdate(Request $request)
    {
        if ($request->activeapi == "firebase") {
            $keys = [
                'firebase_api_key' => $request->firebase_api_key,
                'firebase_auth_domain' => $request->firebase_auth_domain,
                'firebase_project_id' => $request->firebase_project_id,
                'firebase_storage_bucket' => $request->firebase_storage_bucket,
                'firebase_messaging_sender_id' => $request->firebase_messaging_sender_id,
                'firebase_app_id' => $request->firebase_app_id,
                'firebase_measurement_id' => $request->firebase_measurement_id,
            ];

            foreach ($keys as $key => $value) {
                $data = Sms::where('key', $key)->first();
                if ($data) {
                    $data->value = $value;
                    $data->save();
                }
            }
        }

        Sms::where('key', 'activeapi')->update(['value' => $request->activeapi]);

        return redirect()->route('admin.smsSettings')->with('message', 'Data Updated Successfully');
    }
}
