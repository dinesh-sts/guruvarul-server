<?php

namespace App\Http\Controllers\admin\addProfileDetails;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\State;
use Illuminate\Database\QueryException;


class AddProfileStateController extends Controller{

    public function state(Request $request){

        $counries = Country::all();
        $filter = $request->input('filter');

        $query = State::select('id','country_code','state_code','state_name','status')->with('country');

        if ($filter === 'approved') {
            $query->where('status', 'APPROVED'); 
        }

        if ($filter === 'unapproved') {
            $query->where('status', 'UNAPPROVED'); 
        }

        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('state_name', 'like', '%' . $searchTerm . '%');
            $query->orwhere('state_code', 'like', '%' . $searchTerm . '%');
            $query->orWhereHas('country', function($query) use($searchTerm){
                $query->where('country_name', 'LIKE', '%'. $searchTerm .'%');
            });
        }

        $state = $query->orderByDesc('id')->paginate(10);
        $stateCount = State::count();

        $stateApprovedCount = State::where('status',"APPROVED")->count();
        $stateUnapprovedCount = State::where('status',"UNAPPROVED")->count();

        return view('admin.addProfileDetails.stateList',compact('stateCount','stateApprovedCount','stateUnapprovedCount','state','counries'));
    }

    public function stateStore(Request $request){
        $data = new State();
        $data->country_code = $request->country_code;
        $data->state_code = $request->state_code;
        $data->state_name = $request->state_name;

        if($request->status == "on"){
            $data->status = "APPROVED";
        }else{
            $data->status = "UNAPPROVED"; 
        }

        $data->save();
        return redirect()->route('admin.stateList')->with('message','Data Store Sucessfully');
    }

    public function stateDelete($id){
        try{
            $data = State::findOrFail($id);
            $data->delete();
            return redirect()->route('admin.stateList')->with('message','Data Delete Sucessfully');
        } catch (QueryException $e) {
            return redirect()->back()->with('message', 'An error occurred while deleting the state.');
        }
    }

    public function stateStatus(Request $request){
        try{
            $selectedIds = $request->input('selected');

            if($request->action == "approve") {
                State::whereIn('id', $selectedIds)->update(['status' => 'APPROVED']);
                return redirect()->back()->with('message','All Status Approved Sucessfully');
            }

            if($request->action == "unapprove"){
                State::whereIn('id', $selectedIds)->update(['status' => 'UNAPPROVED']);
                return redirect()->back()->with('message','All Status UnApproved Sucessfully');
            }

            if($request->action == "delete"){
                State::whereIn('id', $selectedIds)->delete();
                return redirect()->back()->with('message','Data Deleted Sucessfully');
            }

            if($request->save != null){

                $id = $request->save;
                $data = State::findOrFail($id);
                $data->country_code = $request->country_code;
                $data->state_code = $request->state_code;
                $data->state_name = $request->state_name;

                if($request->status == "on"){
                    $data->status = "APPROVED";
                }else{
                    $data->status = "UNAPPROVED"; 
                }

                $data->save();
                return redirect()->route('admin.stateList')->with('message','Data Updated Sucessfully');
            }
        } catch (QueryException $e) {
            return redirect()->back()->with('message', 'An error occurred while deleting the state.');
        }
    }
}
