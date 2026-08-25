<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Register;
use App\Models\DeleteProfile;
use App\Models\Country;
use App\Models\Religion;
use App\Models\Caste;
use App\Models\Age;
use Illuminate\Pagination\LengthAwarePaginator;


class ProfileDeactiveController extends Controller{

    public function profileDeactiveRequest(){

        $paginator = 0;
        $countries = Country::where('status',"APPROVED")->get();
        $religions = Religion::where('status',"APPROVED")->get();
        $castes = Caste::where('status',"APPROVED")->get();
        $ages = Age::all();

        $AllmemberCount = 0;
        $featuredCount = Register::where('fstatus',"Featured")->count();
        $unapproveCount = Register::where('status',"Inactive")->count();
        $approveeCount = Register::where('status',"Active")->count();
        $paidCount = Register::where('status',"Paid")->count();
        $profiles = DeleteProfile::where('status', '!=', 'No')->orWhereNull('status')->orderby('created_at','desc')->get();
       
        if(count($profiles)){
           foreach($profiles as $value){ 
                $data = Register::where('matri_id',$value->matri_id)->first();
                $deactivedata[] = [
                    'profile' => $value,
                    'registerData' => $data,
                ];
            }
            
            $page = request()->get('page', 1);
            $perPage = 5; 

            $offset = ($page * $perPage) - $perPage;

            if(count($deactivedata)){
                $currentPageItems = array_slice($deactivedata, $offset, $perPage);
                $paginator = new LengthAwarePaginator(
                    $currentPageItems,
                    count($deactivedata),
                    $perPage,
                    $page,
                    ['path' => request()->url(), 'query' => request()->query()]
                 );
                 $AllmemberCount = Register::count();
                 
             return view('admin.profileDeactiveRequest.profileDeactiveList',compact('AllmemberCount','featuredCount','unapproveCount','approveeCount','paidCount','paginator','ages','castes','religions','countries'));
            }
        }
      return view('admin.profileDeactiveRequest.profileDeactiveList',compact('AllmemberCount','featuredCount','unapproveCount','approveeCount','paidCount','paginator','ages','castes','religions','countries'));
    }

    public function ProfileStatus(Request $request,$id)
    {
        $status = DeleteProfile::findOrFail($id);
        $status->status = "Yes";
        $status->save();
      
        if($status == true)
        {
            $data = Register::where('matri_id',$status->matri_id)->first();
            $register = Register::findOrFail($data->id);
            $register->status = "Suspended";
            $register->fstatus = null;
            $register->save();
        }
        return redirect()->back()->with('message','Profile Deactive Sucessfully');
    }

    public function ProfileStatusdelete(Request $request,$id)
    {
        $status = DeleteProfile::findOrFail($id);
        $status->status = "No";
        $status->save();
        return redirect()->back()->with('message','Profile Deactive Request Cancel Sucessfully');
    }
    
    public function profiledeactiveallstatus(Request $request)
    {
        $selectedIds = $request->input('selectedMembers');
        if($request->action == "Yes")
        {
          $userdata = DeleteProfile::whereIn('id', $selectedIds)->get();
           foreach($userdata as $data)
           {
                $data = Register::where('matri_id',$data->matri_id)->first();
                $data->status = "Suspended";
                $data->fstatus = null;
                $data->save();
            }
             DeleteProfile::whereIn('id', $selectedIds)->update(['status' => 'Yes']);
             return redirect()->back()->with('message','Status Updated Sucessfully');
        }

        if($request->action == "No")
        {
            DeleteProfile::whereIn('id', $selectedIds)->update(['status' => 'No']);
            return redirect()->back()->with('message','Status Updated Sucessfully');
        }
    }

    // Fetch caste on bases of religion
    public function fetchCaste(Request $request){  
        $data['caste'] = Caste::where("religion_id", $request->religion_id)
        ->get(["caste_name","id"]);
    
        return response()->json($data);
    }
}
