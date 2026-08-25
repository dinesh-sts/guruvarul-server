<?php

namespace App\Http\Controllers\admin\addProfileDetails;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dosh;
use Illuminate\Database\QueryException;

class AddProfileDoshController extends Controller{

    public function dosh(Request $request){

        $filter = $request->input('filter');

        $query = Dosh::select('id','dosh','status');

        if ($filter === 'approved') {
            $query->where('status', 'APPROVED'); 
        } 
        if ($filter === 'unapproved') {
            $query->where('status', 'UNAPPROVED'); 
        }

        $dosh = $query->orderBy('id', 'DESC')->get();
        $doshCount = Dosh::count();
        $doshApprovedCount = Dosh::where('status',"APPROVED")->count();
        $doshUnapprovedCount = Dosh::where('status',"UNAPPROVED")->count();

        return view('admin.addProfileDetails.doshList',compact('doshUnapprovedCount','doshApprovedCount','doshCount','dosh'));
    }

    public function doshStore(Request $request){

        $data = new Dosh();
        $data->dosh = $request->dosh;

        if($request->status == "on"){
            $data->status = "APPROVED";
        }else{
            $data->status = "UNAPPROVED"; 
        }

        $data->save();

        return redirect()->route('admin.doshList')->with('message','Data Stored Sucessfully');
    }

    public function doshDelete(Request $request,$id){

        try {

            $data = Dosh::findOrFail($id);
            $data->delete();
            return redirect()->route('admin.doshList')->with('message','Data Deleted Sucessfully');

        } catch (QueryException $e) {
            return redirect()->back()->with('message', 'An error occurred while deleting the dosh.');
        }
    }

    public function doshstatus(Request $request){

        try {
            $selectedIds = $request->input('selectedreligion');

            if($request->action == "approve"){
                Dosh::whereIn('id', $selectedIds)->update(['status' => 'APPROVED']);
                return redirect()->back()->with('message','Approved Sucessfully');
            }

            if($request->action == "unapprove"){
                Dosh::whereIn('id', $selectedIds)->update(['status' => 'UNAPPROVED']);
                return redirect()->back()->with('message','Unapproved Sucessfully');
            }

            if($request->action == "delete"){
                Dosh::whereIn('id', $selectedIds)->delete();
                return redirect()->back()->with('message','Data Deleted Sucessfully');
            }

            if($request->save != null){
                $id = $request->save;
                $data = Dosh::findOrFail($id);
                $data->dosh = $request->dosh;
                if($request->status == "on")
                {
                    $data->status = "APPROVED";
                } 
                else{
                    $data->status = "UNAPPROVED"; 
                }
                $data->save();

                return redirect()->route('admin.doshList')->with('message','Data Updated Sucessfully');
            }

        } catch (QueryException $e) {
            return redirect()->back()->with('message', 'An error occurred while deleting the dosh.');
        }
        
    }
}
