<?php

namespace App\Http\Controllers\admin\addProfileDetails;

use App\Http\Controllers\Controller;
use App\Models\Gotra;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class AddProfileGotraController extends Controller{
    
    public function gotra(Request $request){
        $filter = $request->input('filter');

        $query = Gotra::select('id','gotra_name','status');

        if ($filter === 'approved') {
            $query->where('status', 'APPROVED'); 
        } 
        if ($filter === 'unapproved') {
            $query->where('status', 'UNAPPROVED'); 
        }

        $gotra = $query->orderByDesc('id')->get();
        $gotraCount = Gotra::count();
        $gotraApprovedCount = Gotra::where('status',"APPROVED")->count();
        $gotraUnapprovedCount = Gotra::where('status',"UNAPPROVED")->count();

        return view('admin.addProfileDetails.gotraList',compact('gotraCount','gotraApprovedCount','gotraUnapprovedCount','gotra'));
    }

    public function gotraStore(Request $request){
        $data = new Gotra();
        $data->gotra_name = $request->gotra_name;

        if($request->status == "on"){
            $data->status = "APPROVED";
        }else{
            $data->status = "UNAPPROVED"; 
        }

        $data->save();

        return redirect()->route('admin.gotraList')->with('message','Gotra Added Sucessfully');
    }

    public function gotraDelete($id){
        try{

            $data = Gotra::findOrFail($id);
            $data->delete();
            return redirect()->route('admin.gotraList')->with('message','Data Deleted Sucessfully');

        } catch (QueryException $e) {
            return redirect()->back()->with('message', 'An error occurred while deleting the gotra.');
        }
    }

    public function gotraStatus(Request $request){
        try{
            $selectedIds = $request->input('selected');

            if($request->action == "approve"){
                Gotra::whereIn('id', $selectedIds)->update(['status' => 'APPROVED']);
                return redirect()->back()->with('message','Approved Sucessfully');
            }

            if($request->action == "unapprove"){
                Gotra::whereIn('id', $selectedIds)->update(['status' => 'UNAPPROVED']);
                return redirect()->back()->with('message','Unapproved Sucessfully');
            }

            if($request->action == "delete"){
                Gotra::whereIn('id', $selectedIds)->delete();
                return redirect()->back()->with('message','Deleted Sucessfully');
            }

            if($request->save != null){

                $id = $request->save;
                $data = Gotra::findOrFail($id);
                $data->gotra_name = $request->gotra_name;

                if($request->status == "on"){
                    $data->status = "APPROVED";
                }else{
                    $data->status = "UNAPPROVED"; 
                }

                $data->save();

                return redirect()->route('admin.gotraList')->with('message','Data Updated Sucessfully');
            }
        } catch (QueryException $e) {
            return redirect()->back()->with('message', 'An error occurred while deleting the gotra.');
        }
    }
}
