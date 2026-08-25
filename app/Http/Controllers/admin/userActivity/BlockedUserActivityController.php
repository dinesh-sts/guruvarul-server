<?php

namespace App\Http\Controllers\admin\userActivity;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Register;
use App\Models\BlockProfile;


class BlockedUserActivityController extends Controller{

    public function blockedActivity(Request $request){
        $blockedactivity = [];
        $items = BlockProfile::select('id','block_by','block_to','block_date')->orderBy('created_at','desc')->get();
        
        foreach($items as $data){
            $sender = Register::where('matri_id',$data->block_by)->first();
            $receiver = Register::where('matri_id',$data->block_to)->first();
            $blockedactivity[] = [
                'sender' => $sender, 
                'receiver' => $receiver, 
                'data' => $data,
            ];
        }

        return view('admin.userActivity.blockedActivity',compact('blockedactivity'));
    }

    public function blockedActivityDelete(Request $request,$id){ 

        $data = BlockProfile::findOrFail($id);
        $data->delete();
        return redirect()->route('admin.blockedActivity')->with('message','Data Deleted Sucessfully');

    }

    public function blockedActivityStatus(Request $request){

        $selectedIds = $request->input('selected');

        if($request->action == "delete"){
            $blockedactivity = BlockProfile::whereIn('id',$selectedIds)->delete();

            return redirect()->back()->with('message','Data Deleted Sucessfully');
        }
    }

}
