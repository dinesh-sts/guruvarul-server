<?php

namespace App\Http\Controllers\admin\approvals;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Register;
use Illuminate\Support\Facades\Storage;

class ApprovalDocumentController extends Controller{

    public function document(Request $request){
        $filter = $request->input('filter');

        $query = Register::where('aadhaar_card_status','!=','NULL')->select('id','firstname','lastname','matri_id','aadhaar_card_status','aadhaar_card','status');

        if ($filter === 'approved') {
            $query->where('aadhaar_card_status', 'APPROVED'); 
        } 
        if ($filter === 'unapproved') {
            $query->where('aadhaar_card_status', 'UNAPPROVED'); 
        }
        if ($filter === 'pending') {
            $query->where('aadhaar_card_status', 'PENDING'); 
        }

        $documents = $query->orderBy('id', 'DESC')->get();
        $documentsCount = Register::where('aadhaar_card','!=','NULL')->count();  
        $documentsApprovedCount =Register::where('aadhaar_card_status',"APPROVED")->count();
        $documentsUnapprovedCount =Register::where('aadhaar_card_status',"UNAPPROVED")->count();
        $documentsPendingCount =Register::where('aadhaar_card_status',"PENDING")->count();

        return view('admin.approvals.documentList',compact('documentsCount','documentsApprovedCount','documentsUnapprovedCount','documentsPendingCount','documents'));
    }
    
    // Horoscope delete single
    public function documentDelete(Request $request,$id){

        $data = Register::findOrFail($id);
        Storage::disk('public')->delete('userImages/' . $data->aadhaar_card);
        $data->aadhaar_card = Null;
        $data->aadhaar_card_status = Null;
        $data->save();

        return redirect()->route('admin.documentlist')->with('message','Document Deleted Sucessfully');
    }

    // Action bar for status change multiple select
    public function documentStatus(Request $request){

        $selectedIds = $request->input('selected');

        if($request->action == "approve"){
            Register::whereIn('id', $selectedIds)->update(['aadhaar_card_status' => 'APPROVED']);
            return redirect()->back()->with('message','Approved Sucessfully');
        }

        if($request->action == "unapprove"){
            Register::whereIn('id', $selectedIds)->update(['aadhaar_card_status' => 'UNAPPROVED']);
            return redirect()->back()->with('message','Unapproved Sucessfully');
        }

        if($request->action == "panding"){
            Register::whereIn('id', $selectedIds)->update(['aadhaar_card_status' => 'PENDING']);
            return redirect()->back()->with('message','Pending Sucessfully');
        }

        if($request->action == "delete"){

            $images = Register::whereIn('id',$selectedIds)->get();

            foreach ($images as $image) {
                Storage::disk('public')->delete('userImages/' . $image->aadhaar_card);
            }

            $updateDetails = [
                'aadhaar_card_status' => Null,
                'aadhaar_card' => Null
            ];

            Register::whereIn('id', $selectedIds)->update($updateDetails);

            return redirect()->back()->with('message','Data Deleted Sucessfully');
        }
    }
}
