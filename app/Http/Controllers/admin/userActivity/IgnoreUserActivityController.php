<?php

namespace App\Http\Controllers\admin\userActivity;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Register;
use App\Models\Ignore;


class IgnoreUserActivityController extends Controller{

    public function ignoredActivity(Request $request){

        $ignoredactivity = [];
        $items = Ignore::select('id','ignore_by','ignore_to','ignore_date')->orderBy('created_at','desc')->get();
        
        foreach($items as $data){
            $sender = Register::where('matri_id',$data->ignore_by)->first();
            $receiver = Register::where('matri_id',$data->ignore_to)->first();
            $ignoredactivity[] = [
                'sender' => $sender, 
                'receiver' => $receiver, 
                'data' => $data,
            ];
        }
        
        return view('admin.userActivity.ignoredActivity',compact('ignoredactivity'));
    }

    public function ignoredActivityDelete(Request $request,$id){ 
        $data = Ignore::findOrFail($id);
        $data->delete();
        return redirect()->route('useractivity.ignoredactivity')->with('message','Data Deleted Sucessfully');
    }

    public function ignoredActivityStatus(Request $request){
        $selectedIds = $request->input('selected');
        if($request->action == "delete"){
            $viewedactivity = Ignore::whereIn('id',$selectedIds)->delete();

            return redirect()->back()->with('message','Data Deleted Sucessfully');
        }
    }

}
