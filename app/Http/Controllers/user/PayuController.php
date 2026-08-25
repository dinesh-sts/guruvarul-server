<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\MembershipPlan;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\Register;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PayuController extends Controller{

    public function payUMoneyView(Request $request,$membership)
    {
        
        $id = Auth::guard('user')->user();
        $firstname=$id->firstname;
        $lastname=$id->lastname;
        $email=$id->email;
        $userId = $id->id;
        
        $membership = MembershipPlan::findOrFail($membership);

        $payumoney = PaymentMethod::findOrFail(3);

        $productinfo = $membership->plan_name;
        $amount = $membership->plan_amount;
        $planId = $membership->id;
        
        $MERCHANT_KEY = $payumoney->merchant_key; // LIVE MERCHANT KEY
        $SALT = $payumoney->salt; // LIVE SALT

        //$PAYU_BASE_URL = "https://test.payu.in"; // TEST

        $PAYU_BASE_URL = "https://secure.payu.in"; // PRODUCATION
        $name = $firstname." ". $lastname;
        $email = $email;
        $successURL = route('pay.u.success');
        $failURL = route('pay.u.cancel');
        
        $action = '';
        $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
        $posted = array();
        $posted = array(
            'key' => $MERCHANT_KEY,
            'txnid' => $txnid,
            'amount' => $amount,
            'firstname' => $name,
            'email' => $email,
            'productinfo' => $productinfo,
            'udf1' => $userId,
            'udf2' => $planId,
            'surl' => $successURL,
            'furl' => $failURL,
            'service_provider' => 'payu_paisa',
        );

        if(empty($posted['txnid'])) {
            $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
        } 
        else{
            $txnid = $posted['txnid'];
        }

        $hash = '';
        $hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
        
        if(empty($posted['hash']) && sizeof($posted) > 0) {
            $hashVarsSeq = explode('|', $hashSequence);
            $hash_string = '';  
            foreach($hashVarsSeq as $hash_var) {
                $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
                $hash_string .= '|';
            }
            $hash_string .= $SALT;

            $hash = strtolower(hash('sha512', $hash_string));
            $action = $PAYU_BASE_URL . '/_payment';
        } 
        elseif(!empty($posted['hash'])) 
        {
            $hash = $posted['hash'];
            $action = $PAYU_BASE_URL . '/_payment';
        }

        return view('user.payumoneyForm',compact('action','hash','MERCHANT_KEY','txnid','successURL','failURL','name','email','amount','productinfo','userId','planId'));
    }

    public function payUSuccess(Request $request)
    {

        $id = $request->udf1;
        if($id != NULL ){
            $user = Auth::guard('user')->loginUsingId($id);
        }
      

        $payment_id = $request->payment_id;
        $plan_id = $request->udf2;

        if( $request->status == NULL || $request->status == 'Failure'){

            return redirect()->route('user.paymentFailed');
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

        
        return redirect()->route('user.paymentSuccess');
    }

    public function payUCancel(Request $request)
    {
        $id = $request->udf1;
        if($id != NULL ){
            $user = Auth::guard('user')->loginUsingId($id);
        }
        return redirect()->route('user.paymentFailed');
    }
}
