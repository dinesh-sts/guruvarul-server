<?php

namespace App\Http\Controllers\admin\settings;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Storage;

class PaymentMethodController extends Controller{

    public function paymentMethods(){

        $razorpay = PaymentMethod::findOrFail(2);
        $payumoney = PaymentMethod::findOrFail(3);
        return view('admin.settings.payment',compact('razorpay','payumoney'));
    }

    public function paymentMethodsUpdate(Request $request){
        if ($request->has('razorpay')) {
            $data = PaymentMethod::findOrFail(2);
            $data->razorpay_key = $request->razorpay_key;
            $data->razorpay_secret = $request->razorpay_secret;
            $data->status = $request->status;
        }

        if ($request->has('payumoney')) {
            $data = PaymentMethod::findOrFail(3);
            $data->merchant_key = $request->merchant_key;
            $data->salt = $request->salt;
            $data->status = $request->status;
        }
        

        $data->save(); 
        return redirect()->route('admin.paymentMethods')->with('message', 'Data Updated Sucessfully');
    }

    public function manualPaymentMethod(){
        $manualPaymentMethod = PaymentMethod::findOrFail(4);
        return view('admin.settings.manualPaymentMethod',compact('manualPaymentMethod'));
    }

    public function manualPaymentMethodUpdate(Request $request){

        $manualPaymentMethod = PaymentMethod::findOrFail(4);

        if ($request->hasFile('qr_code')) {
            $file = $request->file('qr_code');
            $imageFileType = $file->extension();
            $imageFilesize = $file->getSize();
            $imageName = time().'.'.$imageFileType;  
    
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                return redirect()->back()->with('message','Sorry, only JPG, JPEG, PNG & GIF files are allowed');
            }elseif($imageFilesize > 1000000) {
                return redirect()->back()->with('message','your file size is more than 1MB.');
            }else{
                Storage::disk('public')->delete('manualPaymentImg/' . $manualPaymentMethod->qr_code);
                $filePath = 'manualPaymentImg/' . $imageName;
                $file->storeAs('public', $filePath);
                $manualPaymentMethod->qr_code = $imageName;
            }
        }
        $manualPaymentMethod->pay_name = $request->pay_name;
        $manualPaymentMethod->manual_payment_message = $request->manual_payment_message;
        $manualPaymentMethod->status = $request->status;
        $manualPaymentMethod->save();

        return redirect()->route('admin.manualPaymentMethod')->with('message', 'Data Updated Sucessfully');
    }
}
