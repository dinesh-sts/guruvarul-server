<?php

namespace App\Http\Controllers\admin\approvals;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Register;
use Illuminate\Support\Facades\Storage;


class ApprovalPhoto3Controller extends Controller{

    public function photo3(Request $request){

        $filter = $request->input('filter');

        $query = Register::where('photo3','!=','NULL')->select('id','firstname','lastname','matri_id','photo3','photo3_approve','status');

        if ($filter === 'approved') {
            $query->where('photo3_approve', 'APPROVED'); 
        } 

        if ($filter === 'unapproved') {
            $query->where('photo3_approve', 'UNAPPROVED'); 
        }

        if ($filter === 'pending') {
            $query->where('photo3_approve', 'PENDING'); 
        }

        $photo = $query->orderByDesc('id')->get();

        $photo3Count = Register::where('photo3','!=','NULL')->count();  
        $photo3ApprovedCount =Register::where('photo3_approve',"APPROVED")->count();
        $photo3UnapprovedCount =Register::where('photo3_approve',"UNAPPROVED")->count();
        $photo3PendingCount =Register::where('photo3_approve',"PENDING")->count();

        return view('admin.approvals.photo3List',compact('photo3Count','photo3ApprovedCount','photo3UnapprovedCount','photo3PendingCount','photo'));
    }

    public function photo3Delete(Request $request,$id){

        $data = Register::findOrFail($id);
        Storage::disk('public')->delete('userImages/' . $data->photo3);
        $data->photo3 = Null;
        $data->photo3_approve = Null;
        $data->save();

        return redirect()->route('admin.photo3List')->with('message','Photo Deleted Sucessfully');
    }

    public function photo3Status(Request $request){
     
        $selectedIds = $request->input('selected');
        if($request->action == "approve"){
            Register::whereIn('id', $selectedIds)->update(['photo3_approve' => 'APPROVED']);
            return redirect()->back()->with('message','Approved Sucessfully');
        }

        if($request->action == "unapprove"){
            Register::whereIn('id', $selectedIds)->update(['photo3_approve' => 'UNAPPROVED']);
            return redirect()->back()->with('message','Unapproved Sucessfully');
        }

        if($request->action == "pending"){
            Register::whereIn('id', $selectedIds)->update(['photo3_approve' => 'PENDING']);
            return redirect()->back()->with('message','Pending Sucessfully');
        }

        if($request->action == "delete")
        {
           $images = Register::whereIn('id',$selectedIds)->get();
            foreach ($images as $image) {
                Storage::disk('public')->delete('userImages/' . $image->hor_photo);
            }
            $updateDetails = [
                'photo3' => Null,
                'photo3_approve' => Null
            ];
            Register::whereIn('id', $selectedIds)->update($updateDetails);

            return redirect()->back()->with('message','Data Deleted Sucessfully');
        }
    }
}
