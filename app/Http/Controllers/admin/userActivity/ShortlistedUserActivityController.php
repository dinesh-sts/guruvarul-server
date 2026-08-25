<?php

namespace App\Http\Controllers\admin\userActivity;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Register;
use App\Models\Shortlist;


class ShortlistedUserActivityController extends Controller{
    
    public function shortlistedActivity(Request $request){
        $shortlistedactivity = [];
        $items = Shortlist::select('id','from_id','to_id','add_date')->orderBy('created_at','desc')->get();
        
        foreach($items as $data){
            $sender = Register::where('matri_id',$data->from_id)->first();
            $receiver = Register::where('matri_id',$data->to_id)->first();
            $shortlistedactivity[] = [
                'sender' => $sender, 
                'receiver' => $receiver, 
                'data' => $data,
            ];
        }
        return view('admin.userActivity.shortlistedActivity',compact('shortlistedactivity'));
    }

    public function shortlistedActivityDelete(Request $request,$id){ 
        $data = Shortlist::findOrFail($id);
        $data->delete();
        return redirect()->route('admin.viewedActivity')->with('message','Shortlisted Deleted Sucessfully');
    }

    public function shortlistedActivityStatus(Request $request){

        $selectedIds = $request->input('selected');
        
        if($request->action == "delete"){
            $viewedactivity = Shortlist::whereIn('id',$selectedIds)->delete();

            return redirect()->back()->with('message','Data Deleted Sucessfully');
        }
    }

}
