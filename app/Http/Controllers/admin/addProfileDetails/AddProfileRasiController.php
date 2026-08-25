<?php

namespace App\Http\Controllers\admin\addProfileDetails;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rasi;
use Illuminate\Database\QueryException;

class AddProfileRasiController extends Controller{

    public function rasi(Request $request){
        $filter = $request->input('filter');

        $query = Rasi::select('id','rasi','status');

        if ($filter === 'approved') {
            $query->where('status', 'APPROVED'); 
        } 
        if ($filter === 'unapproved') {
            $query->where('status', 'UNAPPROVED'); 
        }

        $rasi = $query->orderByDesc('id')->get();
        $rasiCount = Rasi::count();
        $rasiApprovedCount = Rasi::where('status',"APPROVED")->count();
        $rasiUnapprovedCount = Rasi::where('status',"UNAPPROVED")->count();

        return view('admin.addProfileDetails.rasiList',compact('rasiUnapprovedCount','rasiApprovedCount','rasiCount','rasi'));
    }

    public function rasiStore(Request $request){

        $data = new Rasi();
        $data->rasi = $request->rasi;

        if($request->status == "on"){
            $data->status = "APPROVED";
        }else{
            $data->status = "UNAPPROVED"; 
        }

        $data->save();
        return redirect()->route('admin.rasiList')->with('message','Data Stored Sucessfully');
    }

    public function rasiDelete(Request $request,$id){
        try{

            $data = Rasi::findOrFail($id);
            $data->delete();

            return redirect()->route('admin.rasiList')->with('message','Data Deleted Sucessfully');

        } catch (QueryException $e) {
            return redirect()->back()->with('message', 'An error occurred while deleting the rasi.');
        }
    }

    public function rasiStatus(Request $request){
        try{
            $selectedIds = $request->input('selectedreligion');

            if($request->action == "approve"){
                Rasi::whereIn('id', $selectedIds)->update(['status' => 'APPROVED']);
                return redirect()->back()->with('message','Approved Sucessfully');
            }

            if($request->action == "unapprove"){
                Rasi::whereIn('id', $selectedIds)->update(['status' => 'UNAPPROVED']);
                return redirect()->back()->with('message','Unapproved Sucessfully');
            }

            if($request->action == "delete"){
                Rasi::whereIn('id', $selectedIds)->delete();
                return redirect()->back()->with('message','Data Deleted Sucessfully');
            }

            if($request->save != null){

                $id = $request->save;
                $data = Rasi::findOrFail($id);
                $data->rasi = $request->rasi;
                if($request->status == "on"){
                    $data->status = "APPROVED";
                }else{
                    $data->status = "UNAPPROVED"; 
                }
                $data->save();
                
                return redirect()->route('admin.rasiList')->with('message','Data Updated Sucessfully');
            }
        } catch (QueryException $e) {
            return redirect()->back()->with('message', 'An error occurred while deleting the rasi.');
        }
    }
}
