<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgetPasswordRequest;
use App\Http\Requests\passwordrequest;
use App\Models\AdminUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AdminLoginController extends Controller{

    public function index(){
        if(Auth::guard('admin')->user() != null){
            return redirect()->route('admin.dashboard');
        }
        return view('admin.index');
    }

    public function login(Request $request){
        if(Auth::guard('admin')->attempt(['uname'=> $request['email'], 'password'=>$request['pswd']])){
            return redirect()->route('admin.dashboard');
        }else{
            return redirect()->route('admin.login')->with('message', 'Unauthorized.Please login with username and password.');
        }
    }

    public function logout(){
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login')->with('message','Logout Successfully');
    }

    public function changeAdminPassword(){
        return view('admin.changepassword');
    }

    public function changeAdminPasswordStore(passwordrequest $request){

        if(env('DEMO_MODE') == 'On'){
            return redirect()->route('admin.changeAdminPassword')->with('message', 'Disabled In Demo');
        }
        if(Auth::guard('admin')->user() != null){
            $user = Auth::guard('admin')->user();

            if (Hash::check($request->old_password, $user->password)) {
                $data = AdminUser::findOrFail(1);
                $data->password = Hash::make($request['new_password']);
                $data->save();

                return redirect()->route('admin.changeAdminPassword')->with('message', 'Password changed successfully.');
            } else {
                return redirect()->route('admin.changeAdminPassword')->with('message', 'Old password is incorrect.');
            }
        }else{
            return view('admin.index');
        }
    }

    public function forgotAdminPassword(){
        return view('admin.forgetPassword');
    }

    public function forgotAdminPasswordStore(Request $request){
        
        if(env('DEMO_MODE') == 'On'){
            return redirect()->back()->with('message', 'Disabled In Demo');
        }

        $checkemail = AdminUser::where('email',$request->email)->first();

        if($checkemail != null){
            $token = Str::random(64);

            $check = DB::table('password_reset_tokens')->insert([
                'email' => $request->email, 
                'token' => $token,
                'created_at' => Carbon::now()
            ]);

            Mail::send('admin.email.forgetAdminPassword', ['token' => $token], function($message) use($request){
                $message->to($request->email);
                $message->subject('Reset Password');
            });

            return back()->with('message', 'Reset Password Email Send Successfully, Plaese Check Email.');
            
        }else{
            return back()->with('message', 'Email Id Is Not Found');
        }    
    }
    
    public function adminProfileUpdate(){
        $admin = AdminUser::findOrFail(1);
        return view('admin.profileupdate',compact('admin'));
    }

    public function adminProfileUpdatePost(Request $request){
        if(env('DEMO_MODE') == 'On'){
            return redirect()->back()->with('message', 'Disabled In Demo');
        }
        $data = AdminUser::findOrFail(1);

        $request->validate([
            'email' => 'required',
            'uname' => 'required'
        ]);

        if($request->uname != $data->uname){
            Mail::send('admin.email.changedUsername', ['username' => $request->uname], function($message) use($request){
                $message->to($request->email);
                $message->subject('Admin Username Changed');
            });
        }

        $data->email = $request->email;
        $data->uname = $request->uname;
        $data->save();
        
        return redirect()->route('admin.adminProfileUpdate')->with('message','Profile Updated Successfully');
    }

    public function resetPassword($token) { 
        $updatePassword = DB::table('password_reset_tokens')->where(['token' => $token])->first();

        if ($updatePassword != null) {
            $difference = Carbon::now()->diffInSeconds($updatePassword->created_at);
            if ($difference > 1800) {
                DB::table('password_reset_tokens')->where(['token'=> $token])->delete();
                return redirect()->back()->with('message', 'Token Expired!');
            }else{
                return view('admin.forgetPasswordLink', ['token' => $token]);
            }
        }
        return redirect()->route('admin.forgotAdminPassword')->with('message', 'Token is not generate,Please resend Email');
    }
 
    public function resetPasswordStore(ForgetPasswordRequest $request)
    {
        if (env("DEMO_MODE") == "On"){
            return redirect()->route('admin.login')->with('message', 'Admin password can not change in demo');
        }
        $user = AdminUser::where('email', $request->email)->update(['password' => Hash::make($request['password'])]);

        DB::table('password_reset_tokens')->where(['token'=> $request->token])->delete();

        return redirect()->route('admin.login')->with('message', 'Your password has been changed!');
        
    }

   
}
