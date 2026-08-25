<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmailSetting;
use App\Models\Register;


class MailController extends Controller{

    public function sendMail(){ 

        $email = EmailSetting::first();
        $status = Register::all();
        return view('admin.sendEmailToMember.mailCreate',compact('status'));

    }

    public function emailFetch(Request $request){
        if($request->memberstatus == "All"){
            $data['email'] = Register::get(["email","id"]);
        }else{
            $data['email'] = Register::where("status", $request->memberstatus)
            ->get(["email","id"]);
        }
        return response()->json($data);
    }

}
