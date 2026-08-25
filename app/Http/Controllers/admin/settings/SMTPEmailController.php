<?php

namespace App\Http\Controllers\admin\settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmailSetting;
use App\Models\Register;
use Illuminate\Support\Facades\Mail;


class SMTPEmailController extends Controller
{
    public function smtpSettings()
    {
        $email = EmailSetting::first();

        if ($email == true) {
            return view('admin.settings.smtpemail',compact('email'));
        }else{
            return view('admin.settings.smtpemail');
        }
    }

    public function smtpSettingsUpdate(Request $request)
    {
        $siteconfig = EmailSetting::first();
      
        if ($siteconfig == true) {
            $data = EmailSetting::findOrFail(1);
            if ($request->has('smtp')) {
                $data->host = $request->host;
                $data->email_password = $request->email_password;
                $data->port = $request->port;
                $data->email_name = $request->email_name;
                $data->enc_type = $request->enc_type;
                $data->email = $request->email;
            }
            $data->save();
            $path = base_path('.env');
            $envContent = file_get_contents($path);
        
            $variablesToUpdate = [
                'MAIL_HOST' => $request->host,
                'MAIL_PORT' => $request->port,
                'MAIL_USERNAME' => $request->email,
                'MAIL_PASSWORD' => $request->email_password,
                'MAIL_ENCRYPTION' => $request->enc_type,
                'MAIL_FROM_ADDRESS' => $request->email,
                'MAIL_FROM_NAME' => $request->email_name,
            ];
        
            foreach ($variablesToUpdate as $key => $value) {
                $envContent = preg_replace("/^$key=.*/m", "$key='".$value."'", $envContent);
                putenv("$key='".$value."'");
            }
        
            file_put_contents($path, $envContent);
               
        }else{
            $data = new EmailSetting();
            if ($request->has('smtp')) {
                $data->host = $request->host;
                $data->email_password = $request->email_password;
                $data->port = $request->port;
                $data->email_name = $request->email_name;
                $data->enc_type = $request->enc_type;
                $data->email = $request->email;
            }
            $data->save();
            $path = base_path('.env');
            $envContent = file_get_contents($path);
        
            $variablesToUpdate = [
                'MAIL_HOST' => $request->host,
                'MAIL_PORT' => $request->port,
                'MAIL_USERNAME' => $request->email,
                'MAIL_PASSWORD' => $request->email_password,
                'MAIL_ENCRYPTION' => $request->enc_type,
                'MAIL_FROM_ADDRESS' => $request->email,
                'MAIL_FROM_NAME' => $request->email_name,
            ];
        
            foreach ($variablesToUpdate as $key => $value) {
                $envContent = preg_replace("/^$key=.*/m", "$key=$value", $envContent);
                putenv("$key=$value");
            }
        
            file_put_contents($path, $envContent);
        }
        return redirect()->route('admin.smtpSettings')->with('message', 'Data Update Sucessfully');
    }
    public function mail(Request $request)
    {
        $emailTo = $request->emailto;
        $member = $request->member;
        
        $subject = $request->subject;
        $content = $request->content;

        if($emailTo == ['all'])
        {
            $emailTo = [];
            if($member == "All")
            {
                $register = Register::all();
                foreach($register as $item)
                {
                    //$emailTo[] = $item->email;
                    $emailTo = $item->email;
                    Mail::raw($content, function ($message) use ($emailTo, $subject) {
                        $message->to($emailTo)
                                ->subject($subject);
                    });
                }
            }
            if($member == "Active")
            {
                $register = Register::where('status',"Active")->get();
                foreach($register as $item)
                {
                    //$emailTo[] = $item->email;
                    $emailTo = $item->email;
                    Mail::raw($content, function ($message) use ($emailTo, $subject) {
                        $message->to($emailTo)
                                ->subject($subject);
                    });
                }
            }
            if($member == "Inactive")
            {
                $register = Register::where('status',"Inactive")->get();
                foreach($register as $item)
                {
                    //$emailTo[] = $item->email;
                    $emailTo = $item->email;
                    Mail::raw($content, function ($message) use ($emailTo, $subject) {
                        $message->to($emailTo)
                                ->subject($subject);
                    });
                }
            }
            if($member == "Paid")
            {
                $register = Register::where('status',"Paid")->get();
                foreach($register as $item)
                {
                    //$emailTo[] = $item->email;
                    $emailTo = $item->email;
                    Mail::raw($content, function ($message) use ($emailTo, $subject) {
                        $message->to($emailTo)
                                ->subject($subject);
                    });
                }
            }
            if($member == "Suspended")
            {
                $register = Register::where('status',"Suspended")->get();
                foreach($register as $item)
                {
                    //$emailTo[] = $item->email;
                    $emailTo = $item->email;
                    Mail::raw($content, function ($message) use ($emailTo, $subject) {
                        $message->to($emailTo)
                                ->subject($subject);
                    });
                }
            }
        }
        
        Mail::raw($content, function ($message) use ($emailTo, $subject) {
            $message->to($emailTo)
                    ->subject($subject);
        });
        
        
   
        return redirect()->back()->with('message','Email Sent SuccessFully');
    }

    public function testMail(Request $request)
    {
        $emailTo = $request->emailto;
        
        $subject = "Test";
        $content = "This is test email";
        
        Mail::raw($content, function ($message) use ($emailTo, $subject) {
            $message->to($emailTo)
                    ->subject($subject);
        });
   
        return redirect()->back()->with('message','Email Sent SuccessFully');
    }
}
