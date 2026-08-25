<?php

namespace App\Http\Controllers\admin\addProfileDetails;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Caste;
use App\Models\Religion;
use Illuminate\Database\QueryException;

class AddProfileCasteController extends Controller{

    public function caste(Request $request){

        $religions = Religion::select('id','religion_name','status')->get();
        $filter = $request->input('filter');
       
        $query = Caste::select('id', 'religion_id', 'caste_name', 'status')->with('rel');
      
        if ($filter === 'approved') {
            $query->where('status', 'APPROVED');
        } elseif ($filter === 'unapproved') {
            $query->where('status', 'UNAPPROVED');
        }

        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('caste_name', 'like', '%' . $searchTerm . '%');
            $query->orWhereHas('rel', function($query) use($searchTerm){
                $query->where('religion_name', 'LIKE', '%'. $searchTerm .'%');
            });
        }
        
        $caste = $query->orderByDesc('id')->paginate(10);
        $casteCount = Caste::count();
        $casteApprovedCount = Caste::where('status',"APPROVED")->count();
        $casteUnapprovedCount = Caste::where('status',"UNAPPROVED")->count();

        return view('admin.addProfileDetails.casteList',compact('casteUnapprovedCount','casteCount','casteApprovedCount','caste','religions'));
    }

    public function casteStore(Request $request){

        $data = new Caste();
        $data->religion_id = $request->religion_id;
        $data->caste_name = $request->caste_name;
        if($request->status == "on"){
            $data->status = "APPROVED";
        }else{
            $data->status = "UNAPPROVED"; 
        }

        $data->save();
        return redirect()->route('admin.casteList')->with('message','Data Stored Sucessfully');

    }

    public function casteDelete($id){

        try{ 
            $data = Caste::findOrFail($id);
            $data->delete();
            return redirect()->route('admin.casteList')->with('message','Data Deleted Sucessfully');
        } catch (QueryException $e) {
            return redirect()->back()->with('message', 'An error occurred while deleting the caste.');
        }

    }

    public function casteStatus(Request $request){
        try{
            $selectedIds = $request->input('selected');

            if($request->action == "approve"){
                Caste::whereIn('id', $selectedIds)->update(['status' => 'APPROVED']);
                return redirect()->back()->with('message','Approved Sucessfully');
            }

            if($request->action == "unapprove"){
                Caste::whereIn('id', $selectedIds)->update(['status' => 'UNAPPROVED']);
                return redirect()->back()->with('message','Unapproved Sucessfully');
            }

            if($request->action == "delete"){
                Caste::whereIn('id', $selectedIds)->delete();
                return redirect()->back()->with('message','Data Deleted Sucessfully');
            }

            if($request->save != null){

                $id = $request->save;
                $data = Caste::findOrFail($id);
                $data->religion_id = $request->religion_id;
                $data->caste_name = $request->caste_name;
                if($request->status == "on"){
                    $data->status = "APPROVED";
                }else{
                    $data->status = "UNAPPROVED"; 
                }

                $data->save();
                return redirect()->route('admin.casteList')->with('message','Data Updated Sucessfully');

            }

        } catch (QueryException $e) {
            return redirect()->back()->with('message', 'An error occurred while deleting the caste.');
        }
    }

}
