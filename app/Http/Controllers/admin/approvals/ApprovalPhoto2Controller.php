<?php

namespace App\Http\Controllers\admin\approvals;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Register;
use Illuminate\Support\Facades\Storage;


class ApprovalPhoto2Controller extends Controller{

    public function photo2(Request $request){
        $filter = $request->input('filter');

        $query = Register::where('photo2','!=','NULL')->select('id','firstname','lastname','matri_id','photo2','photo2_approve','status');

        if ($filter === 'approved') {
            $query->where('photo2_approve', 'APPROVED'); 
        } 
        if ($filter === 'unapproved') {
            $query->where('photo2_approve', 'UNAPPROVED'); 
        }
        if ($filter === 'pending') {
            $query->where('photo2_approve', 'PENDING'); 
        }

        $photo = $query->orderByDesc('id')->get();
        $photo2Count = Register::where('photo2','!=','NULL')->count(); 
        $photo2ApprovedCount =Register::where('photo2_approve',"APPROVED")->count();
        $photo2UnapprovedCount =Register::where('photo2_approve',"UNAPPROVED")->count();
        $photo2PendingCount =Register::where('photo2_approve',"PENDING")->count();

        return view('admin.approvals.photo2List',compact('photo2UnapprovedCount','photo2ApprovedCount','photo2Count','photo2PendingCount','photo'));
    }

    // Single delete
    public function photo2Delete(Request $request,$id){

        $data = Register::findOrFail($id);
        Storage::disk('public')->delete('userImages/' . $data->photo2);
        $data->photo2 = Null;
        $data->photo2_approve = Null;
        $data->save();

        return redirect()->route('admin.photo2List')->with('message','Photo Deleted Sucessfully');
    }


    // Multiple action bar
    public function photo2Status(Request $request){
     
        $selectedIds = $request->input('selected');
        if($request->action == "approve"){
            Register::whereIn('id', $selectedIds)->update(['photo2_approve' => 'APPROVED']);
            return redirect()->back()->with('message','Approved Sucessfully');
        }

        if($request->action == "unapprove"){
            Register::whereIn('id', $selectedIds)->update(['photo2_approve' => 'UNAPPROVED']);
            return redirect()->back()->with('message','Unapproved Sucessfully');
        }

        if($request->action == "pending"){
            Register::whereIn('id', $selectedIds)->update(['photo2_approve' => 'PENDING']);
            return redirect()->back()->with('message','Pending Sucessfully');
        }

        if($request->action == "delete"){
           $images = Register::whereIn('id',$selectedIds)->get();
            foreach ($images as $image) {
                Storage::disk('public')->delete('userImages/' . $image->hor_photo);
            }
            $updateDetails = [
                'photo2' => Null,
                'photo2_approve' => Null
            ];
            Register::whereIn('id', $selectedIds)->update($updateDetails);

            return redirect()->back()->with('message','Data Deleted Sucessfully');
        }
    }
}
