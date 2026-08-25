<?php

namespace App\Http\Controllers\admin\addProfileDetails;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subcast;
use Illuminate\Database\QueryException;


class AddProfileSubCasteController extends Controller{

    public function subcaste(Request $request){

        $filter = $request->input('filter');

        $query = Subcast::select('id','sub_caste_name','status');

        if ($filter === 'approved') {
            $query->where('status', 'APPROVED'); 
        } 
        if ($filter === 'unapproved') {
            $query->where('status', 'UNAPPROVED'); 
        }

        $subcaste = $query->orderBy('id', 'DESC')->get();
        $subcasteCount = Subcast::count();
        $subcasteApprovedCount = Subcast::where('status',"APPROVED")->count();
        $subcasteUnapprovedCount = Subcast::where('status',"UNAPPROVED")->count();

        return view('admin.addProfileDetails.subcasteList',compact('subcasteCount','subcasteApprovedCount','subcasteUnapprovedCount','subcaste'));
    }

    public function subcasteStore(Request $request){

        $data = new Subcast();
        $data->sub_caste_name = $request->sub_caste_name;

        if($request->status == "on"){
            $data->status = "APPROVED";
        }else{
            $data->status = "UNAPPROVED"; 
        }
        $data->save();

        return redirect()->route('admin.subcasteList')->with('message','Data Stored Sucessfully');
    }

    public function subcasteDelete($id){
        try{
            $data = Subcast::findOrFail($id);
            $data->delete();
            return redirect()->route('admin.subcasteList')->with('message','Data Deleted Sucessfully');

        } catch (QueryException $e) {
            return redirect()->back()->with('message', 'An error occurred while deleting the subcaste.');
        }
    }

    public function subcasteStatus(Request $request){

        try{
            $selectedIds = $request->input('selected');

            if($request->action == "approve"){
                Subcast::whereIn('id', $selectedIds)->update(['status' => 'APPROVED']);
                return redirect()->back()->with('message','Approved Sucessfully');
            }

            if($request->action == "unapprove"){
                Subcast::whereIn('id', $selectedIds)->update(['status' => 'UNAPPROVED']);
                return redirect()->back()->with('message','Unapproved Sucessfully');
            }

            if($request->action == "delete"){
                Subcast::whereIn('id', $selectedIds)->delete();
                return redirect()->back()->with('message','Data Deleted Sucessfully');
            }

            if($request->save != null){

                $id = $request->save;
                $data = Subcast::findOrFail($id);
                $data->sub_caste_name = $request->sub_caste_name;

                if($request->status == "on"){
                    $data->status = "APPROVED";
                }else{
                    $data->status = "UNAPPROVED"; 
                }

                $data->save();
                return redirect()->route('admin.subcasteList')->with('message','Data Updated Sucessfully');
            }
        } catch (QueryException $e) {
            return redirect()->back()->with('message', 'An error occurred while deleting the subcaste.');
        }
    }
}
