<?php

namespace App\Http\Controllers\admin\addProfileDetails;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mothertongue;
use Illuminate\Database\QueryException;

class AddProfileMotherTongueController extends Controller{

    public function mtongue(Request $request){

        $filter = $request->input('filter');

        $query = Mothertongue::select('id','mtongue_name','status');

        if ($filter === 'approved') {
            $query->where('status', 'APPROVED'); 
        } 
        if ($filter === 'unapproved') {
            $query->where('status', 'UNAPPROVED'); 
        }

        $mothertongue = $query->orderByDesc('id')->get();
        $mothertongueCount = Mothertongue::count();
        $mothertongueApprovedCount = Mothertongue::where('status',"APPROVED")->count();
        $mothertongueUnapprovedCount = Mothertongue::where('status',"UNAPPROVED")->count();

        return view('admin.addProfileDetails.mtongueList',compact('mothertongueCount','mothertongueApprovedCount','mothertongueUnapprovedCount','mothertongue'));
    }

    
    public function mtongueStore(Request $request){

        $data = new Mothertongue();
        $data->mtongue_name = $request->mtongue_name;
        if($request->status == "on"){
            $data->status = "APPROVED";
        }else{
            $data->status = "UNAPPROVED"; 
        }
        $data->save();

        return redirect()->route('admin.mtongueList')->with('message','Data Stored Sucessfully');
    }

    public function mtongueDelete(Request $request,$id){

        try{

            $data = Mothertongue::findOrFail($id);
            $data->delete();
            return redirect()->route('admin.mtongueList')->with('message','Data Deleted Sucessfully');

        } catch (QueryException $e) {
            return redirect()->back()->with('message', 'An error occurred while deleting the Education.');
        }

    }

    public function mtonguestatus(Request $request){

        try{
            $selectedIds = $request->input('selectedreligion');

            if($request->action == "approve"){
                Mothertongue::whereIn('id', $selectedIds)->update(['status' => 'APPROVED']);
                return redirect()->back()->with('message','Approved Sucessfully');
            }

            if($request->action == "unapprove"){
                Mothertongue::whereIn('id', $selectedIds)->update(['status' => 'UNAPPROVED']);
                return redirect()->back()->with('message','Unapproved Sucessfully');
            }

            if($request->action == "delete"){
                Mothertongue::whereIn('id', $selectedIds)->delete();
                return redirect()->back()->with('message','Data Deleted Sucessfully');
            }

            if($request->save != null){
                $id = $request->save;
                $data = Mothertongue::findOrFail($id);
                $data->mtongue_name = $request->mtongue_name;
                if($request->status == "on"){
                    $data->status = "APPROVED";
                }else{
                    $data->status = "UNAPPROVED"; 
                }

                $data->save();

                return redirect()->route('admin.mtongueList')->with('message','Data Updated Sucessfully');
            }
        } catch (QueryException $e) {
            return redirect()->back()->with('message', 'An error occurred while deleting the Education.');
        }
    }
}
