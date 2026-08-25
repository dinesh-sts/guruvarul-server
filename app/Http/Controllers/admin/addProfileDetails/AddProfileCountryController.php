<?php

namespace App\Http\Controllers\admin\addProfileDetails;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use Illuminate\Database\QueryException;

class AddProfileCountryController extends Controller{

    public function country(Request $request){

        $filter = $request->input('filter');

        $query = Country::select('id','country_code','country_name','status');

        if ($filter === 'approved') {
            $query->where('status', 'APPROVED'); 
        } 
        if ($filter === 'unapproved') {
            $query->where('status', 'UNAPPROVED'); 
        }

        $country = $query->orderByDesc('id')->get();
        $countryCount = Country::count();
        $countryApprovedCount = Country::where('status',"APPROVED")->count();
        $countryUnapprovedCount = Country::where('status',"UNAPPROVED")->count();

        return view('admin.addProfileDetails.countryList',compact('countryCount','countryApprovedCount','countryUnapprovedCount','country'));
    }

    public function countryStore(Request $request)
    {
        $data = new Country();
        $data->country_code = $request->country_code;
        $data->country_name = $request->country_name;

        if($request->status == "on"){
            $data->status = "APPROVED";
        }else{
            $data->status = "UNAPPROVED"; 
        }

        $data->save();
        return redirect()->route('admin.countryList')->with('message','Country added Sucessfully');
    }

    public function countryDelete($id){
        try {

            $data = Country::findOrFail($id);
            $data->delete();
            return redirect()->route('admin.countryList')->with('message','Data Deleted Sucessfully');

        } catch (QueryException $e) {
            return redirect()->back()->with('message', 'An error occurred while deleting the country.');
        }
    }

    public function countryStatus(Request $request){

        try {

            $selectedIds = $request->input('selected');

            if($request->action == "approve"){
                Country::whereIn('id', $selectedIds)->update(['status' => 'APPROVED']);
                return redirect()->back()->with('message','Approved Sucessfully');
            }

            if($request->action == "unapprove"){
                Country::whereIn('id', $selectedIds)->update(['status' => 'UNAPPROVED']);
                return redirect()->back()->with('message','Unapproved Sucessfully');
            }

            if($request->action == "delete"){
                Country::whereIn('id', $selectedIds)->delete();
                return redirect()->back()->with('message','Data Deleted Sucessfully');
            }

            if($request->save != null){

                $id = $request->save;
                $data = Country::findOrFail($id);
                $data->country_code = $request->country_code;
                $data->country_name = $request->country_name;

                if($request->status == "on"){
                    $data->status = "APPROVED";
                }else{
                    $data->status = "UNAPPROVED"; 
                }

                $data->save();
                return redirect()->route('admin.countryList')->with('message','Data Updated Sucessfully');
            }
        } catch (QueryException $e) {
            return redirect()->back()->with('message', 'An error occurred while deleting the country.');
        }
    }
}
