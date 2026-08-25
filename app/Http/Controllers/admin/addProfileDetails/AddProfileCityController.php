<?php

namespace App\Http\Controllers\admin\addProfileDetails;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Models\City;
use App\Models\State;
use App\Models\Country;
use Illuminate\Database\QueryException;

class AddProfileCityController extends Controller{

    public function city(Request $request){

        $state_code = State::all();
        $countries = Country::all();
        $filter = $request->input('filter');
        $query = City::with('country','state');

        if ($filter === 'approved') {
            $query->where('status', 'APPROVED'); 
        }
        if ($filter === 'unapproved') {
            $query->where('status', 'UNAPPROVED'); 
        }

        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('city_name', 'like', '%' . $searchTerm . '%');
            $query->orWhereHas('country', function($query) use($searchTerm){
                $query->where('country_name', 'LIKE', '%'. $searchTerm .'%');
            });
            $query->orWhereHas('state', function($query) use($searchTerm){
                $query->where('state_name', 'LIKE', '%'. $searchTerm .'%');
            });
        }

        $city = $query->orderBy('id', 'desc')->paginate(10);
        $cityCount = City::count();
        $cityApprovedCount = City::where('status',"APPROVED")->count();
        $cityUnapprovedCount = City::where('status',"UNAPPROVED")->count();

        return view('admin.addProfileDetails.cityList',compact('cityUnapprovedCount','cityApprovedCount','cityCount','city','state_code','countries'));
    }

    public function fetchState(Request $request){     
        $data['states'] = State::where("country_code", $request->country_id)
        ->get(["state_name", "state_code","id"]);
        return response()->json($data);
    }

    public function editState(Request $request,$id){
        $edit = City::where('id',$id)->first();
        $arr = array('id'=>$edit->id,'country_code'=>$edit->country_code,'state_code'=>$edit->state_code);
        echo json_encode($arr);
    }
    
    public function edit_country($id){

        $countries = Country::all();
        $output = '';
        foreach ($countries as $country){
            $country_id = $country->id;
            $country_name = $country->country_name;

            $output .= '<option value="'.$country_id.'" '.(($country_id == $id) ? 'selected="selected"':"").'>'.$country_name.'</option>';
        }
        return $output;
    }

    public function edit_country_state(Request $request,$id){

        $city = State::where('id',$id)->first();
        $states = State::where('country_code',$city->country_code)->get();
        $output = '';
        if(!$states->isEmpty()){  
            foreach ($states as $state){
                $state_id = $state->id;
                $state_name = $state->state_name;
    
                $output .= '<option value="'.$state_id.'" '.(($state_id == $id) ? 'selected="selected"':"").'>'.$state_name.'</option>';
        
            }
        }
        return $output;
    }

    public function cityStore(Request $request){

        $data = new City();
        $data->country_code = $request->country_code;
        $data->state_code = $request->state_code;
        $data->city_name = $request->city_name;
        if($request->status == "on"){
            $data->status = "APPROVED";
        }else{
            $data->status = "UNAPPROVED"; 
        }
        $data->save();
        return redirect()->route('admin.cityList')->with('message','Data Stored Sucessfully');
    }

    public function cityDelete($id){
        try{
            $data = City::findOrFail($id);
            $data->delete();
            return redirect()->route('admin.cityList')->with('message','Data Delete Sucessfully');
        } catch (QueryException $e) {
            return redirect()->back()->with('message', 'An error occurred while deleting the city.');
        }
    }

    public function citystatus(Request $request){
        try{
            $selectedIds = $request->input('selected');
            if($request->action == "approve"){
                City::whereIn('id', $selectedIds)->update(['status' => 'APPROVED']);
                return redirect()->back()->with('message','Approved Sucessfully');
            }

            if($request->action == "unapprove"){
                City::whereIn('id', $selectedIds)->update(['status' => 'UNAPPROVED']);
                return redirect()->back()->with('message','Unapproved Sucessfully');
            }

            if($request->action == "delete"){
                City::whereIn('id', $selectedIds)->delete();
                return redirect()->back()->with('message','Data Deleted Sucessfully');
            }

            if($request->save != null){
                $id = $request->save;
                $data = City::findOrFail($id);
                $data->country_code = $request->country_code;
                $data->state_code = $request->state_code;
                $data->city_name = $request->city_name;
                if($request->status == "on"){
                    $data->status = "APPROVED";
                }else{
                    $data->status = "UNAPPROVED"; 
                }
                $data->save();
                return redirect()->route('admin.cityList')->with('message','Data Updated Sucessfully');
            }
        } catch (QueryException $e) {
            return redirect()->back()->with('message', 'An error occurred while deleting the city.');
        }
    }
}
