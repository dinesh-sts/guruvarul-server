<?php

namespace App\Http\Controllers\admin\settings;

use App\Http\Controllers\Controller;
use App\Models\Sms;
use Illuminate\Http\Request;

class SMSController extends Controller
{
    // public function smsSettings()
    // {
    //     $activeapi = Sms::where('key', 'activeapi')->value('value');

    //     // Load keys dynamically based on active API
    //     $config = [];
    //     if ($activeapi == 'firebase') {
    //         $config = $this->getFirebaseConfig();
    //     } elseif ($activeapi == 'fast2sms') {
    //         $config = $this->getFast2SmsConfig();
    //     }

    //     return view('admin.settings.sms', compact('config', 'activeapi'));
    // }

    public function smsSettings()
    {
        $activeapi = \DB::table('sms')->where('key', 'activeapi')->first();
        $route = \DB::table('sms')->where('key', 'fast2smsRoute')->first();
        $key = \DB::table('sms')->where('key', 'fast2smsKey')->first();

        return view('admin.settings.sms', compact('activeapi', 'route', 'key'));
    }

    // public function smsSettingsUpdate(Request $request)
    // {
    //     $activeapi = $request->activeapi;

    //     // Save the active API
    //     Sms::where('key', 'activeapi')->update(['value' => $activeapi]);

    //     // Save keys for the selected API
    //     if ($activeapi == 'firebase') {
    //         $this->saveFirebaseKeys($request);
    //     } elseif ($activeapi == 'fast2sms') {
    //         $this->saveFast2SmsKeys($request);
    //     }

    //     return redirect()->route('admin.smsSettings')->with('message', 'Data Updated Successfully');
    // }
    public function smsSettingsUpdate(Request $request)
    {
        $data = $request->only(['activeapi', 'route', 'key']);

        // Update active API
        \DB::table('sms')->updateOrInsert(
            ['key' => 'activeapi'],
            ['value' => $data['activeapi'], 'updated_at' => now()]
        );

        // Update route if available
        if (!empty($data['route'])) {
            \DB::table('sms')->updateOrInsert(
                ['key' => 'fast2smsRoute'],
                ['value' => $data['route'], 'updated_at' => now()]
            );
        }

        // Update API Key if available
        if (!empty($data['key'])) {
            \DB::table('sms')->updateOrInsert(
                ['key' => 'fast2smsKey'],
                ['value' => $data['key'], 'updated_at' => now()]
            );
        }

        return back()->with('message', 'SMS Settings updated successfully!');
    }


    // -------------------- Private Helper Functions --------------------

    private function getFirebaseConfig()
    {
        return [
            'apiKey' => Sms::where('key', 'firebase_api_key')->value('value'),
            'authDomain' => Sms::where('key', 'firebase_auth_domain')->value('value'),
            'projectId' => Sms::where('key', 'firebase_project_id')->value('value'),
            'storageBucket' => Sms::where('key', 'firebase_storage_bucket')->value('value'),
            'messagingSenderId' => Sms::where('key', 'firebase_messaging_sender_id')->value('value'),
            'appId' => Sms::where('key', 'firebase_app_id')->value('value'),
            'measurementId' => Sms::where('key', 'firebase_measurement_id')->value('value'),
        ];
    }

    private function getFast2SmsConfig()
    {
        return [
            'key' => Sms::where('key', 'fast2smsKey')->value('value'),
            'route' => Sms::where('key', 'fast2smsRoute')->value('value'),
        ];
    }

    private function saveFirebaseKeys($request)
    {
        $keys = [
            'firebase_api_key',
            'firebase_auth_domain',
            'firebase_project_id',
            'firebase_storage_bucket',
            'firebase_messaging_sender_id',
            'firebase_app_id',
            'firebase_measurement_id'
        ];

        foreach ($keys as $key) {
            Sms::where('key', $key)->update(['value' => $request->$key]);
        }
    }

    private function saveFast2SmsKeys($request)
    {
        Sms::where('key', 'fast2smsKey')->update(['value' => $request->fast2smsKey]);
        Sms::where('key', 'fast2smsRoute')->update(['value' => $request->fast2smsRoute]);
    }
}
