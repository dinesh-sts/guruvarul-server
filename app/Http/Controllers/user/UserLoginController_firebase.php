<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Http\Requests\passwordrequest;
use Illuminate\Http\Request;
use App\Models\Register;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail; 
use App\Http\Requests\UserForgetPassword;
use App\Models\SiteConfig;
use App\Models\Sms;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;

class UserLoginController extends Controller
{
    public function changePassword()
    {
        return view('user.changePassword');
    }

    public function checkChangePassword(passwordrequest $request)
    {
        if(Auth::guard('user')->user() != null)
        {
            $user = Auth::guard('user')->user();

            if (Hash::check($request->old_password, $user->password)) {
                $data = Register::findOrFail($user->id);
                $data->password = Hash::make($request['new_password']);
                $data->save();

                return redirect()->route('user.changePassword')->with('message', 'Password changed successfully.');
            } else {
                return redirect()->route('user.changePassword')->with('message', 'Old password is incorrect.');
            }
        }else{
            return redirect()->back();
        }
    }

    public function login()
    {
        $siteconfig = SiteConfig::select('loginWithOTP')->first();

        $url = Crypt::decryptString("eyJpdiI6ImQvQXIwWUVpaSt3NWZhTjV6T29kR2c9PSIsInZhbHVlIjoiREJpdElVbEN4aEx0SFVuYm13NHN1TS9NeU5Ha3VNV0UvSU1UVkh2MTRocUFvMDNSTmNJaWoxaW8vOVdHVTJQRkFtSUtJYlNHcTZXTUh4bkQ1SStiZWc9PSIsIm1hYyI6Ijk1ZDgzYWM5YjI4N2Y0ZTNjYWY3ZmI0YTRmMmNlNzBmNjFkOWI3OWVjODhkZWJmNDI3ZGVlYTVmOWRmZjUzNjYiLCJ0YWciOiIifQ==");

        $data['url'] = $_SERVER['SERVER_NAME'];
        $data['product_user_verify'] = env("APP_VERIFY_KEY");
        $postdata = json_encode($data);

        $ch = curl_init($url); 
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        $result = curl_exec($ch);
        curl_close($ch);

        $json = json_decode($result, true);
    
        if($json['status'] == "0" && env('DEMO_MODE') != 'On') {            
            return redirect()->route('home')->send();
        }

        return view('user.login',compact('siteconfig'));
        
    }

    public function logincheck(Request $request)
    {
        
        // if(Auth::guard('user')->attempt(['email'=>$request['username'],'password'=>$request['password']]))
        // {
        //     if(Auth::guard('user')->user()->status == "Inactive")
        //     {   
        //         return redirect()->route('user.logout')->with('message', 'Profile is not approved yet.');
        //     }elseif(Auth::guard('user')->user()->status == "Suspended")
        //     {
        //         return redirect()->route('user.logout')->with('message', 'Profile is deleted.');
        //     }else{
        //         return redirect()->route('user.dashboard')->with('message', 'Login successFully.');
        //     }
        // }
        if(Auth::guard('user')->attempt(['email'=>$request['username'],'password'=>$request['password']]))
        {
            $user = Auth::guard('user')->user();

            if ($user->status == "Inactive") {
                return redirect()->route('user.logout')->with('message', 'Profile is not approved yet.');
            } elseif ($user->status == "Suspended") {
                return redirect()->route('user.logout')->with('message', 'Profile is deleted.');
            } else {
                if ($user->cpass_status != 'Yes') {
                    $user->cpass_status = 'Yes';
                    $user->save();
                }

                return redirect()->route('user.dashboard')->with('message', 'Login successFully.');
            }
        }

        elseif(Auth::guard('user')->attempt(['mobile'=>$request['username'],'password'=>$request['password']]))
        {
            if(Auth::guard('user')->user()->status == "Inactive")
            {   
                return redirect()->route('user.logout')->with('message', 'Profile is not approved yet.');
            }elseif(Auth::guard('user')->user()->status == "Suspended")
            {
                return redirect()->route('user.logout')->with('message', 'Profile is deleted.');
            }else{
                return redirect()->route('user.dashboard')->with('message', 'Login successFully.');
            }
        }
        elseif(Auth::guard('user')->attempt(['matri_id'=>$request['username'],'password'=>$request['password']]))
        {
            if(Auth::guard('user')->user()->status == "Inactive")
            {   
                return redirect()->route('user.logout')->with('message', 'Profile is not approved yet.');
            }elseif(Auth::guard('user')->user()->status == "Suspended")
            {
                return redirect()->route('user.logout')->with('message', 'Profile is deleted.');
            }else{
                return redirect()->route('user.dashboard')->with('message', 'Login successFully.');
            }
        }else{
            return redirect()->route('user.login')->with('message', 'Login not successful.');
        }
    }
    
    public function loginWithOtp()
    {
        //return view('user.loginWithOtp');
	return view('user.firebase_otp');
    }

    /*public function firebaseLogin(Request $request)
    {
        $user = User::where('mobile', ltrim($request->phone, '+'))->first();

        if ($user) {
            Auth::guard('user')->login($user);
            return redirect()->route('user.dashboard');
        }

        return redirect()->route('user.loginWithOtp')->with('error', 'User not found');
    }*/

/*public function firebaseLogin(Request $request)
{
    $phone = preg_replace('/[^0-9]/', '', $request->phone); // remove non-digits

    $user = User::where('mobile', $phone)->first();

    if ($user) {
        Auth::guard('user')->login($user);
        return response()->json(['status' => 'success', 'redirect' => route('user.dashboard')]);
    }

    return response()->json(['status' => 'error', 'message' => 'User not found']);
}*/

public function firebaseLogin(Request $request)
{
    \Log::info('Firebase login attempt', ['phone' => $request->phone]);

    if (!$request->has('phone')) {
        return response()->json([
            'status' => 'error',
            'message' => 'Phone number is required'
        ], 400);
    }

    $phone = preg_replace('/[^0-9]/', '', $request->phone);
    \Log::info('Normalized phone', ['normalized' => $phone]);

    $user = Register::where('mobile', $phone)->first();

    if ($user) {
        Auth::guard('user')->login($user);

        return response()->json([
            'status' => 'success',
            'redirect' => route('user.dashboard')
        ]);
    }

    \Log::warning('User not found for phone', ['phone' => $phone]);
    return response()->json([
        'status' => 'error',
        'message' => 'User not found'
    ], 404);
}


    public function generateOtp(Request $request)
    {
        $user = Register::where('mobile', $request->mobile)->first();
        if($user != "")
        {

            $otp = rand(1234, 9999);
            session::put('user_id',$user->mobile);
            session::put('otp',$otp);
            $mobile = $user->mobile;
            $api = $this->smsapi($otp,$mobile);
            //dd($api);
            return redirect()->route('user.mobileVerification')->with('success',  "OTP has been sent on your Mobile no."); 
        }else{
            return redirect()->back()->with('message','Please enter correct mobile no.');
        }
    }
    public function smsapi($otp ,$mobile)
    { 
        $key = Sms::where('key','fast2smsKey')->first();
        $route = Sms::where('key','fast2smsRoute')->first();
        $activeapi = Sms::where('key','activeapi')->first();
        if($activeapi->value == "fast2sms")
        {
            if(isset($key->value) && isset($route->value))
            {
               
                $url = Http::get("https://www.fast2sms.com/dev/bulkV2?authorization=".$key->value."&route=".$route->value."&variables_values=".$otp."&flash=0&numbers=".$mobile."&schedule_time="); 
                
            }
        }elseif($activeapi->value == "msg91")
        {
            $url = "";
        }else{
            $url = "";
        }
      
    }

    public function regenerateOtp(Request $request)
    {
        $mobile = session('user_id');
        Session::forget('otp');
        $user = Register::where('mobile', $mobile)->first();

        if($user != ""){
            $otp = rand(1234, 9999);
            session::put('user_id',$user->mobile);
            session::put('otp',$otp);
            return redirect()->route('user.mobileVerification')->with('message', "OTP has been sent on your Mobile no.");

        }else{
            return redirect()->back()->with('message','Please enter correct mobile no.');
        }
    }

    public function mobileVerification()
    {
        return view('user.loginOtpVerify');
    }

    public function loginOtpVerify(Request $request)
    {
        $otp = session('otp');
        $mobile = session('user_id');
        if($request->otp == $otp)
        {
            $user_id = Register::where('mobile',$mobile)->first();
            
            if($user_id != "")
            {
                $user = Register::FindOrFail($user_id->id);
                $user->mobile_verify = "Yes";
                $user->save();
                if($user)
                {
                    Auth::guard('user')->login($user_id);
                    Session::forget('otp');
                    Session::forget('user_id');
                    return redirect()->route('user.dashboard')->with('message','Login successfully');
                }
            }else{
                
                return redirect()->back()->with('message', 'Please enter correct OTP.');
            }
        }
            return redirect()->back()->with('message', 'Please enter correct OTP.');
        
    }

    public function logout(Request $request)
    {
        Register::where('matri_id', Auth::guard('user')->user()->matri_id)->update(['last_login' => Carbon::now()]);
        Auth::guard('user')->logout();
        return redirect()->route('user.login')->with('message','Logout securely.');
    }

    public function forgotPassword()
    {
        return view('user.forgotPassword');
    }

    public function forgotPasswordPost(Request $request)
    {
        $checkemail = Register::where('email',$request->username)->first();
        if($checkemail != null){
            
            $token = Str::random(64);

            $check = DB::table('password_reset_tokens')->insert([
                'email' => $request->username, 
                'token' => $token,
                'created_at' => Carbon::now()
            ]);
            Mail::send('user.email.forgetpassword', ['token' => $token], function($message) use($request){
                $message->to($request->username);
                $message->subject('Reset Password');
            });
            return back()->with('message', 'Reset password link sent on your email id.');
        }else{
            return back()->with('message', 'Please enter registered email id.');
        }    
    }

    public function resetpassword($token) { 
        $updatePassword = DB::table('password_reset_tokens')->where(['token' => $token])->first();
      
        if ($updatePassword != null) {
            $difference = Carbon::now()->diffInSeconds($updatePassword->created_at);
            if ($difference > 1800) {
                DB::table('password_reset_tokens')->where(['token'=> $token])->delete();
                return redirect()->back()->with('message', 'Token Expired!');
            }else{
                return view('user.userforgetpswgeneratelink', ['token' => $token]);
            }
        }
        return redirect()->route('user.forgotPassword')->with('message', 'Problem sending reset password link.');
    }
 
    public function postresetpassword(UserForgetPassword $request)
    {
       $user =  DB::table('password_reset_tokens')->where(['token'=> $request->token])->first();
        $user = Register::where('email', $user->email)->update(['password' => Hash::make($request['password'])]);

        DB::table('password_reset_tokens')->where(['token'=> $request->token])->delete();

        return redirect()->route('user.login')->with('message', 'Your password has been changed.');
    }
    
    
}
