<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Register;
use App\Models\BlockProfile;
use App\Models\Ignore;
use App\Models\Payment;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\SiteConfig;
use App\Models\WhoViewedMyProfiles;
use Illuminate\Support\Facades\DB;

class UserDashboardController extends Controller
{
    public function userDashboard()
    {
        $log_inid = Auth::guard('user')->user();
            $siteconfig = SiteConfig::first();
            $blockuser = BlockProfile::where('block_by', $log_inid->matri_id)
        ->orWhere('block_to', $log_inid->matri_id)
            ->pluck('block_to')
            ->merge(BlockProfile::where('block_to', $log_inid->matri_id)
            ->orWhere('block_by', $log_inid->matri_id)
            ->pluck('block_by'))
            ->unique()
            ->toArray();
            $membershipplan = Payment::where('pmatri_id',$log_inid->matri_id)->OrderBy('created_at', 'desc')->first();
            $ignore = Ignore::where('ignore_by', $log_inid->matri_id)->WhereNot('ignore_to',$log_inid->matri_id)->pluck('ignore_to')->toArray();
            $recentlyjoin = Register::whereNotIn('matri_id',$blockuser)->whereNotIn('matri_id',$ignore)->whereNot('matri_id',$log_inid->matri_id)->WhereNot('matri_id',$log_inid->matri_id)->whereNot('gender',$log_inid->gender)->whereNotIn('status',['Inactive','Suspended'])->whereBetween('created_at',[Carbon::now()->subMonth(3), Carbon::now()])->with('hei','rel','cast','occ','citi','country')->orderBy('created_at', 'desc')->limit(4)->get();
            $featured = Register::whereNotIn('matri_id',$blockuser)->whereNotIn('matri_id',$ignore)->whereNot('matri_id',$log_inid->matri_id)->WhereNot('matri_id',$log_inid->matri_id)->whereNot('gender',$log_inid->gender)->whereNotIn('status',['Inactive','Suspended'])->where('fstatus','featured')->with('hei','rel','cast','occ','citi','country')->orderBy('created_at', 'desc')->limit(4)->get();
            $viewprofile = WhoViewedMyProfiles::where('viewed_member_id',$log_inid->matri_id)->WhereNot('my_id',$log_inid->matri_id)->pluck('my_id')->toArray();
            $profileview = Register::whereNotIn('matri_id',$blockuser)->whereNotIn('matri_id',$ignore)->whereNot('matri_id',$log_inid->matri_id)->whereNot('gender',$log_inid->gender)->whereNotIn('status',['Inactive','Suspended'])->whereIn('matri_id',$viewprofile)->with('hei','rel','cast','occ','citi','country')->orderBy('created_at', 'desc')->limit(4)->get();
    
            $profileCompleteness = $log_inid->profileCompletenessPercentage();
    
            return view('user.userDashboard',compact('recentlyjoin','membershipplan','profileview','featured','siteconfig','profileCompleteness'));
       
        
    }

    public function varify()
    {
        $log_inid = Auth::guard('user')->user();
      
        $token = Str::random(64);
        DB::table('password_reset_tokens')->insert([
           'email' => $log_inid->email, 
           'token' => $token,
           'created_at' => Carbon::now()
       ]);

       Mail::send('user.email.verifyEmail', ['token' => $token], function($message) use($log_inid){
           $message->to($log_inid->email);
           $message->subject('Verify Your Email Account');
       });
        return redirect()->back()->with('message',"Email verification link sent on your registered email id.");
    }

    public function varifyemailaccount($token)
    {
        $site_configvarify = SiteConfig::first();
        $updatePassword = DB::table('password_reset_tokens')->where(['token' => $token])->first();
        if ($updatePassword != null) {
            $difference = Carbon::now()->diffInSeconds($updatePassword->created_at);
            if ($difference > 900) {
                DB::table('password_reset_tokens')->where(['token'=> $token])->delete();
                return redirect()->back()->with('message', 'Token Expired!');
            }else{
                if($site_configvarify->profile_varification == "manual_approve")
                {
                    $register = Register::where('email',$updatePassword->email)->first();
                    $data = Register::FindOrFail($register->id);
                    $data->cpass_status = "Yes";
                    $data->save();
                     DB::table('password_reset_tokens')->where(['token'=> $token])->delete();
                    return redirect()->route('user.dashboard')->with('message', 'Email successfully verified.');
                }else{
                    $register = Register::where('email',$updatePassword->email)->first();
                    $data = Register::FindOrFail($register->id);
                    $data->cpass_status = "Yes";
                    $data->status = "Active";
                    $data->save();
                     DB::table('password_reset_tokens')->where(['token'=> $token])->delete();
                    return redirect()->route('user.dashboard')->with('message', 'Email successfully verified.');
                }
            }
        }
        return redirect()->route('user.dashboard')->with('message', 'Problem in email verification link or email is already verified.');
    }

}
