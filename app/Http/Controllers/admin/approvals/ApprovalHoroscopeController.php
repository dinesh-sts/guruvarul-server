<?php

namespace App\Http\Controllers\admin\approvals;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Register;
use Illuminate\Support\Facades\Storage;


class ApprovalHoroscopeController extends Controller{

    public function horoscope(Request $request){

        $filter = $request->input('filter');

        $query = Register::where('hor_photo','!=','NULL')->select('id','firstname','lastname','matri_id','hor_check','hor_photo','status');

        if ($filter === 'approved') {
            $query->where('hor_check', 'APPROVED'); 
        } 
        if ($filter === 'unapproved') {
            $query->where('hor_check', 'UNAPPROVED'); 
        }
        if ($filter === 'pending') {
            $query->where('hor_check', 'PENDING'); 
        }

        $horoscope = $query->orderByDesc('id')->get();
        $horoscopeCount = Register::where('hor_photo','!=','NULL')->count();  
        $horoscopeApprovedCount =Register::where('hor_check',"APPROVED")->count();
        $horoscopeUnapprovedCount =Register::where('hor_check',"UNAPPROVED")->count();
        $horoscopePendingCount =Register::where('hor_check',"PENDING")->count();

        return view('admin.approvals.horoscopeList',compact('horoscopeUnapprovedCount','horoscopePendingCount','horoscopeApprovedCount','horoscopeCount','horoscope'));
    }

    // Horoscope delete single
    public function horoscopeDelete(Request $request,$id){

        $data = Register::findOrFail($id);

        Storage::disk('public')->delete('userImages/' . $data->hor_photo);

        $data->hor_check = Null;
        $data->hor_photo = Null;
        $data->save();

        return redirect()->route('admin.horoscopeList')->with('message','Horoscope Deleted Sucessfully');
    }

    // Action bar for status change multiple select
    public function horoscopeStatus(Request $request){
     
        $selectedIds = $request->input('selected');

        if($request->action == "approve"){
            Register::whereIn('id', $selectedIds)->update(['hor_check' => 'APPROVED']);
            return redirect()->back()->with('message','Approved Sucessfully');
        }

        if($request->action == "unapprove"){
            Register::whereIn('id', $selectedIds)->update(['hor_check' => 'UNAPPROVED']);
            return redirect()->back()->with('message','Unapproved Sucessfully');
        }

        if($request->action == "panding"){
            Register::whereIn('id', $selectedIds)->update(['hor_check' => 'PENDING']);
            return redirect()->back()->with('message','Pending Sucessfully');
        }

        if($request->action == "delete"){
           $images = Register::whereIn('id',$selectedIds)->get();
            foreach ($images as $image) {
                Storage::disk('public')->delete('userImages/' . $image->hor_photo);
            }
            $updateDetails = [
                'hor_photo' => Null,
                'hor_check' => Null
            ];
            Register::whereIn('id', $selectedIds)->update($updateDetails);

            return redirect()->back()->with('message','Data Deleted Sucessfully');
        }

    }
}
