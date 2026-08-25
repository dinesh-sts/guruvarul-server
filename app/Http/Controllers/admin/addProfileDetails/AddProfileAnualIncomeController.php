<?php

namespace App\Http\Controllers\admin\addProfileDetails;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Income;
use Illuminate\Database\QueryException;


class AddProfileAnualIncomeController extends Controller{

    public function income(Request $request){

        $filter = $request->input('filter');

        $query = Income::select('id','income','status');

        if ($filter === 'approved') {
            $query->where('status', 'APPROVED'); 
        } 
        if ($filter === 'unapproved') {
            $query->where('status', 'UNAPPROVED'); 
        }

        $income = $query->orderByDesc('id')->get();
        $incomeCount = Income::count();
        $incomeApprovedCount = Income::where('status',"APPROVED")->count();
        $incomeUnapprovedCount = Income::where('status',"UNAPPROVED")->count();

        return view('admin.addProfileDetails.incomeList',compact('incomeUnapprovedCount','incomeCount','incomeApprovedCount','income'));
    }

    public function incomeStore(Request $request){
        $data = new Income();
        $data->income = $request->income;
        if($request->status == "on"){
            $data->status = "APPROVED";
        }else{
            $data->status = "UNAPPROVED"; 
        }
        $data->save();
        return redirect()->route('admin.incomeList')->with('message','Data Stored Sucessfully');
    }

    public function incomeDelete(Request $request,$id){
        try {
            $data = Income::findOrFail($id);
            $data->delete();
            return redirect()->route('admin.incomeList')->with('message','Data Deleted Sucessfully');
        } catch (QueryException $e) {
            return redirect()->back()->with('message', 'An error occurred while deleting the income.');
        }
    }

    public function incomeStatus(Request $request){
        try {
            $selectedIds = $request->input('selectedreligion');

            if($request->action == "approve"){
                Income::whereIn('id', $selectedIds)->update(['status' => 'APPROVED']);
                return redirect()->back()->with('message','Approved Sucessfully');
            }

            if($request->action == "unapprove"){
                Income::whereIn('id', $selectedIds)->update(['status' => 'UNAPPROVED']);
                return redirect()->back()->with('message','Unapproved Sucessfully');
            }

            if($request->action == "delete"){
                Income::whereIn('id', $selectedIds)->delete();
                return redirect()->back()->with('message','Data Deleted Sucessfully');
            }

            if($request->save != null){
                $id = $request->save;
                $data = Income::findOrFail($id);
                $data->income = $request->income;
                if($request->status == "on")
                {
                    $data->status = "APPROVED";
                } 
                else{
                    $data->status = "UNAPPROVED"; 
                }
                $data->save();
                return redirect()->route('admin.incomeList')->with('message','Data Updated Sucessfully');
            }
        } catch (QueryException $e) {
            return redirect()->back()->with('message', 'An error occurred while deleting the income.');
        }
    }
}
