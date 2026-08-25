<?php

namespace App\Http\Controllers\admin\addProfileDetails;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Religion;
use Illuminate\Database\QueryException;

class AddProfileReligionController extends Controller{

    public function religion(Request $request){
        $filter = $request->input('filter');

        $query = Religion::select('id','religion_name','status');

        if ($filter === 'approved') {
            $query->where('status', 'APPROVED'); 
        } 

        if ($filter === 'unapproved') {
            $query->where('status', 'UNAPPROVED'); 
        }

        $religion = $query->orderByDesc('id')->get();
        $religionCount = Religion::count();
        $religionApprovedCount = Religion::where('status','APPROVED')->count();
        $religionUnapprovedCount = Religion::where('status','UNAPPROVED')->count();

        return view('admin.addProfileDetails.religionList',compact('religionCount','religionApprovedCount','religionUnapprovedCount','religion'));
    }

    public function religionStore(Request $request){

        $data = new Religion();
        $data->religion_name = $request->religion_name;

        if($request->status == "on"){
            $data->status = "APPROVED";
        }else{
            $data->status = "UNAPPROVED"; 
        }
        $data->save();
        return redirect()->route('admin.religionList')->with('message','Data Store Sucessfully');
    }

    public function religionDelete(Request $request,$id){
        try{

            $data = Religion::findOrFail($id);
            $data->delete();
            return redirect()->route('admin.religionList')->with('message','Data Delete Sucessfully');

        } catch (QueryException $e) {
            return redirect()->back()->with('message', 'An error occurred while deleting the religion.');
        }
    }

    // Religion status update for multiple select
    public function religionStatus(Request $request){
        try{
            $selectedIds = $request->input('selectedreligion');

            if($request->action == "approve"){
                Religion::whereIn('id', $selectedIds)->update(['status' => 'APPROVED']);
                return redirect()->back()->with('message','Approved Sucessfully');
            }

            if($request->action == "unapprove"){
                Religion::whereIn('id', $selectedIds)->update(['status' => 'UNAPPROVED']);
                return redirect()->back()->with('message','Unapproved Sucessfully');
            }

            if($request->action == "delete"){
                Religion::whereIn('id', $selectedIds)->delete();
                return redirect()->back()->with('message','Deleted Sucessfully');
            }

            if($request->save != null){

                $id = $request->save;
                $data = Religion::findOrFail($id);
                $data->religion_name = $request->religion_name;
                if($request->status == "on"){
                    $data->status = "APPROVED";
                }else{
                    $data->status = "UNAPPROVED"; 
                }
                $data->save();

                return redirect()->route('admin.religionList')->with('message','Data Updated Sucessfully');
            }
        } catch (QueryException $e) {
            return redirect()->back()->with('message', 'An error occurred while deleting the religion.');
        }
    }
}
