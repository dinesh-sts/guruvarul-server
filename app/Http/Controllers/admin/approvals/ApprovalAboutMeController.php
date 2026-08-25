<?php

namespace App\Http\Controllers\admin\approvals;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Register;

class ApprovalAboutMeController extends Controller{

    public function aboutMe(Request $request){

        $filter = $request->input('filter');

        $query = Register::where('profile_text','!=','NULL')->select('id','firstname','lastname','matri_id','profile_text','profile_text_approve','status');

        if ($filter === 'approved') {
            $query->where('profile_text_approve', 'APPROVED'); 
        } 
        if ($filter === 'unapproved') {
            $query->where('profile_text_approve', 'UNAPPROVED'); 
        }
        if ($filter === 'pending') {
            $query->where('profile_text_approve', 'PENDING'); 
        }

        $aboutme = $query->orderByDesc('id')->get();
        $aboutmeCount = Register::where('profile_text','!=','NULL')->count();
        $aboutmeApprovedCount =Register::where('profile_text_approve',"APPROVED")->count();
        $aboutmeUnapprovedCount =Register::where('profile_text_approve',"UNAPPROVED")->count();
        $aboutmePendingCount =Register::where('profile_text_approve',"PENDING")->count();

        return view('admin.approvals.aboutMe',compact('aboutmePendingCount','aboutmeUnapprovedCount','aboutmeApprovedCount','aboutmeCount','aboutme'));
    }

    public function aboutMeDelete(Request $request,$id){
        $data = Register::findOrFail($id);
        $data->profile_text = Null;
        $data->profile_text_approve = Null;
        $data->save();

        return redirect()->route('admin.aboutMeList')->with('message','About Me Deleted Sucessfully');
    }

    public function aboutMeStatus(Request $request){
     
        $selectedIds = $request->input('selected');
        if($request->action == "approve")
        {
            Register::whereIn('id', $selectedIds)->update(['profile_text_approve' => 'APPROVED']);
            return redirect()->back()->with('message','Approved Sucessfully');
        }

        if($request->action == "unapprove")
        {
            Register::whereIn('id', $selectedIds)->update(['profile_text_approve' => 'UNAPPROVED']);
            return redirect()->back()->with('message','Unapproved Sucessfully');
        }

        if($request->action == "pending")
        {
            Register::whereIn('id', $selectedIds)->update(['profile_text_approve' => 'PENDING']);
            return redirect()->back()->with('message','Pending Sucessfully');
        }

        if($request->action == "delete")
        {
           $aboutme = Register::whereIn('id',$selectedIds)->get();
         
            $updateDetails = [
                'profile_text' => Null,
                'profile_text_approve' => Null
            ];
            Register::whereIn('id', $selectedIds)->update($updateDetails);

            return redirect()->back()->with('message','Data Deleted Sucessfully');
        }
    }
}
