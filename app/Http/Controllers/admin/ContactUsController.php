<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contactus;


class ContactUsController extends Controller{

    public function contactusData(Request $request){
        $contacts = Contactus::all();
        return view('admin.contactUsData.contactUs',compact('contacts'));
    }

    public function contactDataStatus(Request $request){
        $selectedIds = $request->input('selected');

        if($request->action == "delete"){
            Contactus::whereIn('id', $selectedIds)->delete();
            return redirect()->back()->with('message','Data Deleted Sucessfully');
        }
    }
    public function contactDataDelete(Request $request,$id)
    {
        $data = Contactus::findOrFail($id);
        $data->delete();
        return redirect()->route('admin.contactusData')->with('message','Data Deleted Sucessfully');
    }
}
