<?php

namespace App\Http\Controllers\admin\approvals;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Register;
use Illuminate\Support\Facades\Storage;

class ApprovalPhoto6Controller extends Controller{

    public function photo6(Request $request){
        $filter = $request->input('filter');

        $query = Register::where('photo6','!=','NULL')->select('id','firstname','lastname','matri_id','photo6','photo6_approve','status');

        if ($filter === 'approved') {
            $query->where('photo6_approve', 'APPROVED'); 
        } 
        if ($filter === 'unapproved') {
            $query->where('photo6_approve', 'UNAPPROVED'); 
        }
        if ($filter === 'pending') {
            $query->where('photo6_approve', 'PENDING'); 
        }
        $photo = $query->orderByDesc('id')->get();

        $photo6Count = Register::where('photo6','!=','NULL')->count();
        $photo6ApprovedCount =Register::where('photo6_approve',"APPROVED")->count();
        $photo6UnapprovedCount =Register::where('photo6_approve',"UNAPPROVED")->count();
        $photo6PendingCount =Register::where('photo6_approve',"PENDING")->count();

        return view('admin.approvals.photo6List',compact('photo6PendingCount','photo6UnapprovedCount','photo6Count','photo6ApprovedCount','photo'));
    }

    // Single delete
    public function photo6Delete(Request $request,$id){

        $data = Register::findOrFail($id);
        Storage::disk('public')->delete('userImages/' . $data->photo6);
        $data->photo6 = Null;
        $data->photo6_approve = Null;
        $data->save();

        return redirect()->route('admin.photo6List')->with('message','Photo Deleted Sucessfully');
    }

    // Multiple action bar
    public function photo6Status(Request $request){
     
        $selectedIds = $request->input('selected');

        if($request->action == "approve"){
            Register::whereIn('id', $selectedIds)->update(['photo6_approve' => 'APPROVED']);
            return redirect()->back()->with('message','All Status Approved Sucessfully');
        }

        if($request->action == "unapprove"){
            Register::whereIn('id', $selectedIds)->update(['photo6_approve' => 'UNAPPROVED']);
            return redirect()->back()->with('message','All Status UnApproved Sucessfully');
        }

        if($request->action == "pending"){
            Register::whereIn('id', $selectedIds)->update(['photo6_approve' => 'PENDING']);
            return redirect()->back()->with('message','Pending Sucessfully');
        }

        if($request->action == "delete"){
           $images = Register::whereIn('id',$selectedIds)->get();
            foreach ($images as $image) {
                Storage::disk('public')->delete('userImages/' . $image->hor_photo);
            }
            $updateDetails = [
                'photo6' => Null,
                'photo6_approve' => Null
            ];
            Register::whereIn('id', $selectedIds)->update($updateDetails);

            return redirect()->back()->with('message','Data Deleted Sucessfully');
        }
    }
}
