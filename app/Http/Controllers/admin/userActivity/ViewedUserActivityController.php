<?php

namespace App\Http\Controllers\admin\userActivity;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Register;
use App\Models\WhoViewedMyProfiles;


class ViewedUserActivityController extends Controller{

    public function viewedActivity(Request $request){

        $viewedactivity = [];
        $items = WhoViewedMyProfiles::select('id','my_id','viewed_member_id','viewed_date')->orderBy('created_at','desc')->get();
        
        foreach($items as $data){
            $sender = Register::where('matri_id',$data->my_id)->first();
            $receiver = Register::where('matri_id',$data->viewed_member_id)->first();
            $viewedactivity[] = [
                'sender' => $sender, 
                'receiver' => $receiver, 
                'data' => $data,
            ];
        }
        return view('admin.userActivity.viewedActivity',compact('viewedactivity'));
    }

    public function viewedActivityDelete(Request $request,$id){ 
        $data = WhoViewedMyProfiles::findOrFail($id);
        $data->delete();
        return redirect()->route('admin.viewedActivity')->with('message','Viewed Deleted Sucessfully');
    }

    public function viewedActivityStatus(Request $request){

        $selectedIds = $request->input('selected');
        if($request->action == "delete"){
            $viewedactivity = WhoViewedMyProfiles::whereIn('id',$selectedIds)->delete();

            return redirect()->back()->with('message','Data Deleted Sucessfully');
        }
    }
}
