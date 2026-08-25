<?php

namespace App\Http\Controllers\admin\addProfileDetails;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Star;
use Illuminate\Database\QueryException;

class AddProfileStarController extends Controller{

    public function star(Request $request){

        $filter = $request->input('filter');

        $query = Star::select('id','star','status');

        if ($filter === 'approved') {
            $query->where('status', 'APPROVED'); 
        } 
        if ($filter === 'unapproved') {
            $query->where('status', 'UNAPPROVED'); 
        }

        $star = $query->orderByDesc('id')->get();
        $starCount = Star::count();
        $starApprovedCount = Star::where('status',"APPROVED")->count();
        $starUnapprovedCount = Star::where('status',"UNAPPROVED")->count();

        return view('admin.addProfileDetails.starList',compact('starUnapprovedCount','starApprovedCount','starCount','star'));
    }

    public function starStore(Request $request){
        $data = new Star();
        $data->star = $request->star;
        if($request->status == "on"){
            $data->status = "APPROVED";
        }else{
            $data->status = "UNAPPROVED"; 
        }

        $data->save();
        return redirect()->route('admin.starList')->with('message','Data Stored Sucessfully');
    }

    public function starDelete(Request $request,$id){

        try{
            $data = Star::findOrFail($id);
            $data->delete();
            return redirect()->route('admin.starList')->with('message','Data Deleted Sucessfully');

        } catch (QueryException $e) {
            return redirect()->back()->with('message', 'An error occurred while deleting the star.');
        }
    }

    public function starStatus(Request $request){
        try{
            $selectedIds = $request->input('selectedreligion');

            if($request->action == "approve"){
                Star::whereIn('id', $selectedIds)->update(['status' => 'APPROVED']);
                return redirect()->back()->with('message','Approved Sucessfully');
            }

            if($request->action == "unapprove"){
                Star::whereIn('id', $selectedIds)->update(['status' => 'UNAPPROVED']);
                return redirect()->back()->with('message','Unapproved Sucessfully');
            }

            if($request->action == "delete"){
                Star::whereIn('id', $selectedIds)->delete();
                return redirect()->back()->with('message','Data Deleted Sucessfully');
            }

            if($request->save != null){
                $id = $request->save;
                $data = Star::findOrFail($id);
                $data->star = $request->star;

                if($request->status == "on"){
                    $data->status = "APPROVED";
                }else{
                    $data->status = "UNAPPROVED"; 
                }

                $data->save();
                return redirect()->route('admin.starList')->with('message','Data Updated Sucessfully');
            }

        } catch (QueryException $e) {
            return redirect()->back()->with('message', 'An error occurred while deleting the star.');
        }
    }
}
