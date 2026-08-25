<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Http\Request;
use App\Models\Religion;
use Illuminate\Database\QueryException;

class CurrencyController extends Controller{

    public function currency(Request $request){

        $currency = Currency::orderByDesc('id')->get();
        $currencyCount = Currency::count();
        $currencyApprovedCount = Currency::where('status','APPROVED')->count();
        $currencyUnapprovedCount = Currency::where('status','UNAPPROVED')->count();

        return view('admin.currency.currencyList',compact('currencyCount','currencyApprovedCount','currencyUnapprovedCount','currency'));
    }

    public function currencyStore(Request $request){

        $data = new Currency();
        $data->currency = $request->currency;

        if($request->status == "on"){
            $data->status = "APPROVED";
        }else{
            $data->status = "UNAPPROVED"; 
        }
        $data->save();
        return redirect()->route('admin.currencyList')->with('message','Data Store Sucessfully');
    }

    public function currencyDelete(Request $request,$id){
        try{

            $data = Currency::findOrFail($id);
            $data->delete();
            return redirect()->route('admin.currencyList')->with('message','Data Delete Sucessfully');

        } catch (QueryException $e) {
            return redirect()->back()->with('message', 'An error occurred while deleting the religion.');
        }
    }

    // Currency status update for multiple select
    public function currencyStatus(Request $request){
        try{
            $selectedIds = $request->input('selectedCurrency');

            if($request->action == "approve"){
                Currency::whereIn('id', $selectedIds)->update(['status' => 'APPROVED']);
                return redirect()->back()->with('message','Approved Sucessfully');
            }

            if($request->action == "unapprove"){
                Currency::whereIn('id', $selectedIds)->update(['status' => 'UNAPPROVED']);
                return redirect()->back()->with('message','Unapproved Sucessfully');
            }

            if($request->action == "delete"){
                Currency::whereIn('id', $selectedIds)->delete();
                return redirect()->back()->with('message','Deleted Sucessfully');
            }

            if($request->save != null){

                $id = $request->save;
                $data = Currency::findOrFail($id);
                $data->currency = $request->currency;
                if($request->status == "on"){
                    $data->status = "APPROVED";
                }else{
                    $data->status = "UNAPPROVED"; 
                }
                $data->save();

                return redirect()->route('admin.currencyList')->with('message','Data Updated Sucessfully');
            }
        } catch (QueryException $e) {
            return redirect()->back()->with('message', 'An error occurred while deleting the religion.');
        }
    }
}
