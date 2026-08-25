<?php

namespace App\Http\Controllers\admin\addProfileDetails;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EducationDetail;
use Illuminate\Database\QueryException;


class AddProfileEducationController extends Controller{

    public function education(Request $request){

        $filter = $request->input('filter');

        $query = EducationDetail::select('id','edu_name','status');

        if ($filter === 'approved') {
            $query->where('status', 'APPROVED'); 
        } 
        if ($filter === 'unapproved') {
            $query->where('status', 'UNAPPROVED'); 
        }

        $educationdetail = $query->orderByDesc('id')->get();
        $educationdetailCount = EducationDetail::count();
        $educationdetailApprovedCount = EducationDetail::where('status',"APPROVED")->count();
        $educationdetailUnapprovedCount = EducationDetail::where('status',"UNAPPROVED")->count();

        return view('admin.addProfileDetails.educationList',compact('educationdetailUnapprovedCount','educationdetailApprovedCount','educationdetailCount','educationdetail'));
    }

    public function educationStore(Request $request) {
        $data = new EducationDetail();
        $data->edu_name = $request->edu_name;

        if($request->status == "on"){
            $data->status = "APPROVED";
        }else{
            $data->status = "UNAPPROVED"; 
        }

        $data->save();
        return redirect()->route('admin.educationList')->with('message','Data Stored Sucessfully');
    }

    public function educationDelete(Request $request,$id){
        try{
            $data = EducationDetail::findOrFail($id);
            $data->delete();

            return redirect()->route('admin.educationList')->with('message','Data Deleted Sucessfully');

        } catch (QueryException $e) {
            return redirect()->back()->with('message', 'An error occurred while deleting the Education.');
        }
    }

    public function educationstatus(Request $request){
        try{
            $selectedIds = $request->input('selectedreligion');

            if($request->action == "approve"){
                EducationDetail::whereIn('id', $selectedIds)->update(['status' => 'APPROVED']);
                return redirect()->back()->with('message','Approved Sucessfully');
            }

            if($request->action == "unapprove"){
                EducationDetail::whereIn('id', $selectedIds)->update(['status' => 'UNAPPROVED']);
                return redirect()->back()->with('message','Unapproved Sucessfully');
            }

            if($request->action == "delete"){
                EducationDetail::whereIn('id', $selectedIds)->delete();
                return redirect()->back()->with('message','Data Deleted Sucessfully');
            }

            if($request->save != null){

                $id = $request->save;
                $data = EducationDetail::findOrFail($id);
                $data->edu_name = $request->edu_name;
                if($request->status == "on"){
                    $data->status = "APPROVED";
                }else{
                    $data->status = "UNAPPROVED"; 
                }

                $data->save();
                return redirect()->route('admin.educationList')->with('message','Data Updated Sucessfully');
            }
        } catch (QueryException $e) {
            return redirect()->back()->with('message', 'An error occurred while deleting the Education.');
        }
        
    }
}
