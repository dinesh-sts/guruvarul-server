<?php

namespace App\Http\Controllers\admin\approvals;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Register;


class ApprovalPartnerExpectController extends Controller{

    public function partnerExpect(Request $request){
        $filter = $request->input('filter');

        $query = Register::where('part_expect','!=','NULL')->select('id','firstname','lastname','matri_id','part_expect','part_expect_approve','status');

        if ($filter === 'approved') {
            $query->where('part_expect_approve', 'APPROVED'); 
        } 
        if ($filter === 'unapproved') {
            $query->where('part_expect_approve', 'UNAPPROVED'); 
        }
        if ($filter === 'pending') {
            $query->where('part_expect_approve', 'PENDING'); 
        }

        $part_expect = $query->orderBy('id', 'DESC')->get();

        $part_expectCount = Register::where('part_expect','!=','NULL')->count();
        $part_expectApprovedCount =Register::where('part_expect_approve',"APPROVED")->count();
        $part_expectUnapprovedCount =Register::where('part_expect_approve',"UNAPPROVED")->count();
        $part_expectPendingCount =Register::where('part_expect_approve',"PENDING")->count();

        return view('admin.approvals.partExpect',compact('part_expectPendingCount','part_expectUnapprovedCount','part_expectApprovedCount','part_expectCount','part_expect'));
    }

    public function partnerExpectDelete(Request $request,$id){
        
        $data = Register::findOrFail($id);
        $data->part_expect = Null;
        $data->part_expect_approve = Null;
        $data->save();

        return redirect()->route('admin.partnerExpectList')->with('message','Partner Expecation Deleted Sucessfully');
    }

    public function partnerExpectStatus(Request $request){
     
        $selectedIds = $request->input('selected');

        if($request->action == "approve"){
            Register::whereIn('id', $selectedIds)->update(['part_expect_approve' => 'APPROVED']);
            return redirect()->back()->with('message','Approved Sucessfully');
        }

        if($request->action == "unapprove"){
            Register::whereIn('id', $selectedIds)->update(['part_expect_approve' => 'UNAPPROVED']);
            return redirect()->back()->with('message','Unapproved Sucessfully');
        }

        if($request->action == "pending"){
            Register::whereIn('id', $selectedIds)->update(['part_expect_approve' => 'PENDING']);
            return redirect()->back()->with('message','Pending Sucessfully');
        }

        if($request->action == "delete"){
           $part_expect = Register::whereIn('id',$selectedIds)->get();
         
            $updateDetails = [
                'part_expect' => Null,
                'part_expect_approve' => Null
            ];
            Register::whereIn('id', $selectedIds)->update($updateDetails);

            return redirect()->back()->with('message','Data Deleted Sucessfully');
        }
    }
}
