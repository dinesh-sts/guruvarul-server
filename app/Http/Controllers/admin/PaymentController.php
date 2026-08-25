<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiteConfig;
use App\Models\Payment;

class PaymentController extends Controller{

    public function payment(){
        $payments = Payment::orderByDesc('id')->get();
        return view('admin.payments.allPayments',compact('payments'));
    }

    public function invoice(Request $request,$id){
        $siteConfig = SiteConfig::first();
        $payment= Payment::where('id',$id)->first();
        return view('admin.payments.invoice',compact('payment','siteConfig'));
    }
}
