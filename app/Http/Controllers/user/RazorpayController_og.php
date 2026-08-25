<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\MembershipPlan;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\Register;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Razorpay\Api\Api;

class RazorpayController extends Controller
{
    public function razorpayResponse(){  
        return view('user.razorpayResponse');
        
    }
    public function razorpayResponseStore(Request $request) {

        $payment_id = $request->razorpay_payment_id;
        $plan_id = $request->plan_id;

        if($payment_id == NULL || $plan_id == NULL){
            return redirect()->route('user.razorpayResponse')->with('failed','payment not completed');
        }

        $paymentmembership = MembershipPlan::where('id',$plan_id)->first();
        // Assuming the response contains necessary data
        $authuser = Auth::guard('user')->user();
        $formattedFutureDate = Carbon::today()->addDays($paymentmembership->plan_duration)->format("d-m-y");

        $payment = new Payment();
        $payment->pmatri_id = $authuser->matri_id ;
        $payment->pname = "$authuser->firstname"." "."$authuser->lastname";
        $payment->paymode = 'Online';
        $payment->pactive_dt = Carbon::today()->format("d-m-y");
        $payment->p_plan = $paymentmembership->plan_name;
        $payment->plan_duration = $paymentmembership->plan_duration;
        $payment->profile = $paymentmembership->profile;
        $payment->chat = $paymentmembership->chat;
        $payment->p_no_contacts = $paymentmembership->plan_contacts;
        $payment->plan_currency = $paymentmembership->currency;
        $payment->p_amount = $paymentmembership->plan_amount;
        $payment->pay_id = $payment_id;
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

    }
   
}
