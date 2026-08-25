<?php

namespace App\Http\Controllers\admin\approvals;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Register;
use Illuminate\Support\Facades\Storage;


class ApprovalPhoto4Controller extends Controller{

    public function photo4(Request $request){

        $filter = $request->input('filter');

        $query = Register::where('photo4','!=','NULL')->select('id','firstname','lastname','matri_id','photo4','photo4_approve','status');

        if ($filter === 'approved') {
            $query->where('photo4_approve', 'APPROVED'); 
        } 
        if ($filter === 'unapproved') {
            $query->where('photo4_approve', 'UNAPPROVED'); 
        }
        if ($filter === 'pending') {
            $query->where('photo4_approve', 'PENDING'); 
        }
        $photo = $query->orderByDesc('id')->get();

        $photo4Count = Register::where('photo4','!=','NULL')->count();  
        $photo4ApprovedCount =Register::where('photo4_approve',"APPROVED")->count();
        $photo4UnapprovedCount =Register::where('photo4_approve',"UNAPPROVED")->count();
        $photo4PendingCount =Register::where('photo4_approve',"PENDING")->count();

        return view('admin.approvals.photo4List',compact('photo4PendingCount','photo4UnapprovedCount','photo4Count','photo4ApprovedCount','photo'));
    }

    public function photo4Delete(Request $request,$id){

        $data = Register::findOrFail($id);
        Storage::disk('public')->delete('userImages/' . $data->photo4);
        $data->photo4 = Null;
        $data->photo4_approve = Null;
        $data->save();

        return redirect()->route('admin.photo4List')->with('message','Photo Deleted Sucessfully');
    }


    //Multiple action bar
    public function photo4Status(Request $request){
     
        $selectedIds = $request->input('selected');
        if($request->action == "approve")
        {
            Register::whereIn('id', $selectedIds)->update(['photo4_approve' => 'APPROVED']);
            return redirect()->back()->with('message','Approved Sucessfully');
        }

        if($request->action == "unapprove")
        {
            Register::whereIn('id', $selectedIds)->update(['photo4_approve' => 'UNAPPROVED']);
            return redirect()->back()->with('message','Unapproved Sucessfully');
        }

        if($request->action == "pending")
        {
            Register::whereIn('id', $selectedIds)->update(['photo4_approve' => 'PENDING']);
            return redirect()->back()->with('message','Pending Sucessfully');
        }

        if($request->action == "delete")
        {
           $images = Register::whereIn('id',$selectedIds)->get();
            foreach ($images as $image) {
                Storage::disk('public')->delete('userImages/' . $image->hor_photo);
            }
            $updateDetails = [
                'photo4' => Null,
                'photo4_approve' => Null
            ];
            Register::whereIn('id', $selectedIds)->update($updateDetails);

            return redirect()->back()->with('message','Data Deleted Sucessfully');
        }
    }
}
