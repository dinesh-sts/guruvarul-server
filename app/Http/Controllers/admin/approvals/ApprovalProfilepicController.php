<?php

namespace App\Http\Controllers\admin\approvals;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Register;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ApprovalProfilepicController extends Controller{
    
    // Photo 1 List
    public function profilePic(Request $request){

        $filter = $request->input('filter');

        $query = Register::where('photo1','!=','NULL')->select('id','firstname','lastname','matri_id','photo1','photo1_approve','status');

        if ($filter === 'approved') {
            $query->where('photo1_approve', 'APPROVED'); 
        } 
        if ($filter === 'unapproved') {
            $query->where('photo1_approve', 'UNAPPROVED'); 
        }
        if ($filter === 'pending') {
            $query->where('photo1_approve', 'PENDING'); 
        }

        $url = Crypt::decryptString("eyJpdiI6ImQvQXIwWUVpaSt3NWZhTjV6T29kR2c9PSIsInZhbHVlIjoiREJpdElVbEN4aEx0SFVuYm13NHN1TS9NeU5Ha3VNV0UvSU1UVkh2MTRocUFvMDNSTmNJaWoxaW8vOVdHVTJQRkFtSUtJYlNHcTZXTUh4bkQ1SStiZWc9PSIsIm1hYyI6Ijk1ZDgzYWM5YjI4N2Y0ZTNjYWY3ZmI0YTRmMmNlNzBmNjFkOWI3OWVjODhkZWJmNDI3ZGVlYTVmOWRmZjUzNjYiLCJ0YWciOiIifQ==");

        $data['url'] = $_SERVER['SERVER_NAME'];
        $data['product_user_verify'] = env("APP_VERIFY_KEY");
        $postdata = json_encode($data);

        $ch = curl_init($url); 
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        $result = curl_exec($ch);
        curl_close($ch);

        $json = json_decode($result, true);
    
        if($json['status'] == "0" && env('DEMO_MODE') != 'On') {            
            return redirect()->route('home')->send();
        }


        $profilepic = $query->orderByDesc('id')->get();
        $profilepicCount = Register::where('photo1','!=','NULL')->count(); 
        $profilepicApprovedCount =Register::where('photo1_approve',"APPROVED")->count();
        $profilepicUnapprovedCount =Register::where('photo1_approve',"UNAPPROVED")->count();
        $profilepicPendingCount =Register::where('photo1_approve',"PENDING")->count();

        return view('admin.approvals.profilePicList',compact('profilepicUnapprovedCount','profilepicPendingCount','profilepicApprovedCount','profilepicCount','profilepic'));
    }

    // Photo1 delete single
    public function profilepicDelete(Request $request,$id){
        $data = Register::findOrFail($id);
        Storage::disk('public')->delete('userImages/' . $data->photo1);
        $data->photo1 = Null;
        $data->photo1_approve = Null;
        $data->save();

        return redirect()->route('admin.profilePicList')->with('message','photo Deleted Sucessfully');
    }


    // Action bar for status change multiple select
    public function profilepicStatus(Request $request){

        $selectedIds = $request->input('selected');
        if($request->action == "approve"){
            Register::whereIn('id', $selectedIds)->update(['photo1_approve' => 'APPROVED']);
            return redirect()->back()->with('message','Approved Sucessfully');
        }

        if($request->action == "unapprove"){
            Register::whereIn('id', $selectedIds)->update(['photo1_approve' => 'UNAPPROVED']);
            return redirect()->back()->with('message','Unapproved Sucessfully');
        }

        if($request->action == "pending"){
            Register::whereIn('id', $selectedIds)->update(['photo1_approve' => 'PENDING']);
            return redirect()->back()->with('message','Pending Sucessfully');
        }

        if($request->action == "delete"){
           $images = Register::whereIn('id',$selectedIds)->get();
            foreach ($images as $image) {
                Storage::disk('public')->delete('userImages/' . $image->hor_photo);
            }
            $updateDetails = [
                'photo1' => Null,
                'photo1_approve' => Null
            ];
            Register::whereIn('id', $selectedIds)->update($updateDetails);

            return redirect()->back()->with('message','Data Deleted Sucessfully');
        }
    }
}
