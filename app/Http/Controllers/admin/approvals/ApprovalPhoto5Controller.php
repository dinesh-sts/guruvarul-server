<?php

namespace App\Http\Controllers\admin\approvals;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Register;
use Illuminate\Support\Facades\Storage;

class ApprovalPhoto5Controller extends Controller{

    public function photo5(Request $request){

        $filter = $request->input('filter');

        $query = Register::where('photo5','!=','NULL')->select('id','firstname','lastname','matri_id','photo5','photo5_approve','status');

        if ($filter === 'approved') {
            $query->where('photo5_approve', 'APPROVED'); 
        } 
        if ($filter === 'unapproved') {
            $query->where('photo5_approve', 'UNAPPROVED'); 
        }
        if ($filter === 'pending') {
            $query->where('photo5_approve', 'PENDING'); 
        }
        $photo = $query->orderBy('id', 'DESC')->get();

        $photo5Count = Register::where('photo5','!=','NULL')->count();

        $photo5ApprovedCount =Register::where('photo5_approve',"APPROVED")->count();
        $photo5UnapprovedCount =Register::where('photo5_approve',"UNAPPROVED")->count();
        $photo5PendingCount =Register::where('photo5_approve',"PENDING")->count();

        return view('admin.approvals.photo5List',compact('photo5PendingCount','photo5UnapprovedCount','photo5Count','photo5ApprovedCount','photo'));
    }


    // Single delete
    public function photo5Delete(Request $request,$id){

        $data = Register::findOrFail($id);

        Storage::disk('public')->delete('userImages/' . $data->photo5);
        $data->photo5 = Null;
        $data->photo5_approve = Null;
        $data->save();

        return redirect()->route('admin.photo5List')->with('message','Photo Deleted Sucessfully');
    }


    //Multiple action bar
    public function photo5Status(Request $request){
     
        $selectedIds = $request->input('selected');

        if($request->action == "approve"){
            Register::whereIn('id', $selectedIds)->update(['photo5_approve' => 'APPROVED']);
            return redirect()->back()->with('message','Approved Sucessfully');
        }

        if($request->action == "unapprove"){
            Register::whereIn('id', $selectedIds)->update(['photo5_approve' => 'UNAPPROVED']);
            return redirect()->back()->with('message','Unapproved Sucessfully');
        }

        if($request->action == "pending"){
            Register::whereIn('id', $selectedIds)->update(['photo5_approve' => 'PENDING']);
            return redirect()->back()->with('message','Pending Sucessfully');
        }

        if($request->action == "delete"){
           $images = Register::whereIn('id',$selectedIds)->get();
            foreach ($images as $image) {
                Storage::disk('public')->delete('userImages/' . $image->hor_photo);
            }
            $updateDetails = [
                'photo5' => Null,
                'photo5_approve' => Null
            ];
            Register::whereIn('id', $selectedIds)->update($updateDetails);

            return redirect()->back()->with('message','Data Deleted Sucessfully');
        }
    }
}
