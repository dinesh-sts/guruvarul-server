<?php

namespace App\Http\Controllers\admin\approvals;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Register;
use Illuminate\Support\Facades\Storage;


class ApprovalPhoto8Controller extends Controller{

    public function photo8(Request $request){

        $filter = $request->input('filter');

        $query = Register::where('photo8','!=','NULL')->select('id','firstname','lastname','matri_id','photo8','photo8_approve','status');

        if ($filter === 'approved') {
            $query->where('photo8_approve', 'APPROVED'); 
        } 
        if ($filter === 'unapproved') {
            $query->where('photo8_approve', 'UNAPPROVED'); 
        }
        if ($filter === 'pending') {
            $query->where('photo8_approve', 'PENDING'); 
        }

        $photo = $query->orderByDesc('id')->get();
        $photo8Count = Register::where('photo8','!=','NULL')->count();
        $photo8ApprovedCount =Register::where('photo8_approve',"APPROVED")->count();
        $photo8UnapprovedCount =Register::where('photo8_approve',"UNAPPROVED")->count();
        $photo8PendingCount =Register::where('photo8_approve',"PENDING")->count();

        return view('admin.approvals.photo8List',compact('photo8PendingCount','photo8UnapprovedCount','photo8ApprovedCount','photo8Count','photo'));
    }

    // Single delete
    public function photo8Delete(Request $request,$id){
        $data = Register::findOrFail($id);
        Storage::disk('public')->delete('userImages/' . $data->photo8);
        $data->photo8 = Null;
        $data->photo8_approve = Null;
        $data->save();

        return redirect()->route('admin.photo8List')->with('message','Photo Deleted Sucessfully');
    }

    // Multiple action bar
    public function photo8status(Request $request){
     
        $selectedIds = $request->input('selected');
        if($request->action == "approve"){
            Register::whereIn('id', $selectedIds)->update(['photo8_approve' => 'APPROVED']);
            return redirect()->back()->with('message','Approved Sucessfully');
        }

        if($request->action == "unapprove"){
            Register::whereIn('id', $selectedIds)->update(['photo8_approve' => 'UNAPPROVED']);
            return redirect()->back()->with('message','Unapproved Sucessfully');
        }

        if($request->action == "pending"){
            Register::whereIn('id', $selectedIds)->update(['photo8_approve' => 'PENDING']);
            return redirect()->back()->with('message','Pending Sucessfully');
        }

        if($request->action == "delete"){
           $images = Register::whereIn('id',$selectedIds)->get();
            foreach ($images as $image) {
                Storage::disk('public')->delete('userImages/' . $image->hor_photo);
            }
            $updateDetails = [
                'photo8' => Null,
                'photo8_approve' => Null
            ];
            Register::whereIn('id', $selectedIds)->update($updateDetails);

            return redirect()->back()->with('message','Data Deleted Sucessfully');
        }
    }
}
