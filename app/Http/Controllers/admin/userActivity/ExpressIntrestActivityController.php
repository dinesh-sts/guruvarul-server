<?php

namespace App\Http\Controllers\admin\userActivity;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Register;
use App\Models\Expressinterest;

class ExpressIntrestActivityController extends Controller{

    public function expressActivity(Request $request){

        $expressactivity = [];
        $query = Expressinterest::select('id','ei_sender','ei_receiver','ei_sent_date','receiver_response');
        $items = $query->orderBy('created_at','desc')->get();

        foreach($items as $data){
            $sender = Register::where('matri_id',$data->ei_sender)->first();
            $receiver = Register::where('matri_id',$data->ei_receiver)->first();
            $expressactivity[] = [
                'sender' => $sender, 
                'receiver' => $receiver, 
                'data' => $data,
            ];
        }

        return view('admin.userActivity.expressInterestActivity',compact('expressactivity'));

    }

    public function expressActivityDelete(Request $request,$id){ 
        $data = Expressinterest::findOrFail($id);
        $data->delete();
        return redirect()->route('admin.expressActivity')->with('message','Express Interest Deleted Sucessfully');
    }

    public function expressActivityStatus(Request $request){
        $selectedIds = $request->input('selected');

        if($request->action == "delete"){

            $expressactivity = Expressinterest::whereIn('id',$selectedIds)->delete();
            return redirect()->back()->with('message','Data Deleted Sucessfully');
        }
    }

}
