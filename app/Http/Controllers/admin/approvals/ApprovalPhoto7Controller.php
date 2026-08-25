<?php

namespace App\Http\Controllers\admin\approvals;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Register;
use Illuminate\Support\Facades\Storage;


class ApprovalPhoto7Controller extends Controller{
    public function photo7(Request $request){
        $filter = $request->input('filter');

        $query = Register::where('photo7','!=','NULL')->select('id','firstname','lastname','matri_id','photo7','photo7_approve','status');

        if ($filter === 'approved') {
            $query->where('photo7_approve', 'APPROVED'); 
        } 
        if ($filter === 'unapproved') {
            $query->where('photo7_approve', 'UNAPPROVED'); 
        }
        if ($filter === 'pending') {
            $query->where('photo7_approve', 'PENDING'); 
        }
        $photo = $query->orderByDesc('id')->get();

        $photo7Count = Register::where('photo7','!=','NULL')->count();
        $photo7ApprovedCount =Register::where('photo7_approve',"APPROVED")->count();
        $photo7UnapprovedCount =Register::where('photo7_approve',"UNAPPROVED")->count();
        $photo7PendingCount =Register::where('photo7_approve',"PENDING")->count();

        return view('admin.approvals.photo7List',compact('photo7PendingCount','photo7UnapprovedCount','photo7ApprovedCount','photo7Count','photo'));
    }

    // Single delete
    public function photo7Delete(Request $request,$id){

        $data = Register::findOrFail($id);
        Storage::disk('public')->delete('userImages/' . $data->photo7);
        $data->photo7 = Null;
        $data->photo7_approve = Null;
        $data->save();

        return redirect()->route('admin.photo7List')->with('message','Photo Deleted Sucessfully');
    }

    // Multiple action bar
    public function photo7Status(Request $request){
     
        $selectedIds = $request->input('selected');

        if($request->action == "approve"){
            Register::whereIn('id', $selectedIds)->update(['photo7_approve' => 'APPROVED']);
            return redirect()->back()->with('message','Approved Sucessfully');
        }

        if($request->action == "unapprove"){
            Register::whereIn('id', $selectedIds)->update(['photo7_approve' => 'UNAPPROVED']);
            return redirect()->back()->with('message','Unapproved Sucessfully');
        }

        if($request->action == "pending"){
            Register::whereIn('id', $selectedIds)->update(['photo7_approve' => 'PENDING']);
            return redirect()->back()->with('message','Pending Sucessfully');
        }

        if($request->action == "delete")
        {
           $images = Register::whereIn('id',$selectedIds)->get();
            foreach ($images as $image) {
                Storage::disk('public')->delete('userImages/' . $image->hor_photo);
            }
            $updateDetails = [
                'photo7' => Null,
                'photo7_approve' => Null
            ];
            Register::whereIn('id', $selectedIds)->update($updateDetails);

            return redirect()->back()->with('message','Data Deleted Sucessfully');
        }
    }
}
