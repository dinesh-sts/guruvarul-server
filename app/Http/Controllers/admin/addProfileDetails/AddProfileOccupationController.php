<?php

namespace App\Http\Controllers\admin\addProfileDetails;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Occupation;
use Illuminate\Database\QueryException;


class AddProfileOccupationController extends Controller{

    public function occupation(Request $request){
        $filter = $request->input('filter');

        $query = Occupation::select('id','ocp_name','status');

        if ($filter === 'approved') {
            $query->where('status', 'APPROVED'); 
        } 
        if ($filter === 'unapproved') {
            $query->where('status', 'UNAPPROVED'); 
        }

        $occupation = $query->orderByDesc('id')->get();
        $occupationCount = Occupation::count();
        $occupationApprovedCount = Occupation::where('status',"APPROVED")->count();
        $occupationUnapprovedCount = Occupation::where('status',"UNAPPROVED")->count();

        return view('admin.addProfileDetails.occupationList',compact('occupationCount','occupationApprovedCount','occupationUnapprovedCount','occupation'));
    }

    public function occupationStore(Request $request){

        $data = new Occupation();
        $data->ocp_name = $request->ocp_name;
        if($request->status == "on"){
            $data->status = "APPROVED";
        } else{
            $data->status = "UNAPPROVED"; 
        }

        $data->save();
        return redirect()->route('admin.occupationList')->with('message','Data Stored Sucessfully');
    }

    public function occupationDelete(Request $request,$id){
        try{

            $data = Occupation::findOrFail($id);
            $data->delete();
            return redirect()->route('admin.occupationList')->with('message','Data Deleted Sucessfully');

        } catch (QueryException $e) {
            return redirect()->back()->with('message', 'An error occurred while deleting the occupation.');
        }
    }

    public function occupationstatus(Request $request){
        try{

            $selectedIds = $request->input('selectedreligion');

            if($request->action == "approve"){
                Occupation::whereIn('id', $selectedIds)->update(['status' => 'APPROVED']);
                return redirect()->back()->with('message','Approved Sucessfully');
            }

            if($request->action == "unapprove"){
                Occupation::whereIn('id', $selectedIds)->update(['status' => 'UNAPPROVED']);
                return redirect()->back()->with('message','Unapproved Sucessfully');
            }

            if($request->action == "delete"){
                Occupation::whereIn('id', $selectedIds)->delete();
                return redirect()->back()->with('message','Data Deleted Sucessfully');
            }

            if($request->save != null){

                $id = $request->save;
                $data = Occupation::findOrFail($id);
                $data->ocp_name = $request->ocp_name;
                if($request->status == "on"){
                    $data->status = "APPROVED";
                }else{
                    $data->status = "UNAPPROVED"; 
                }

                $data->save();
                return redirect()->route('admin.occupationList')->with('message','Data Updated Sucessfully');
            }

        } catch (QueryException $e) {
            return redirect()->back()->with('message', 'An error occurred while deleting the occupation.');
        }
    }
}
