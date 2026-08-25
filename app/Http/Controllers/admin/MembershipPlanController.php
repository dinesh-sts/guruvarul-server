<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Http\Request;
use App\Models\MembershipPlan;


class MembershipPlanController extends Controller{

    // All membership plans 
    public function membershipPlan(Request $request){

        $filter = $request->input('filter');

        $query = MembershipPlan::select('id','plan_name','plan_amount','plan_duration','plan_contacts','chat','status','only_for','currency');
       
        if ($filter === 'active') {
            $query->where('status', 'APPROVED'); 
        } 
        if ($filter === 'inactive') {
            $query->where('status', 'UNAPPROVED'); 
        } 
       
        $membershipPlans = $query->orderByDesc('id')->get();
        $membershipPlansCount = MembershipPlan::count();        
        $membershipPlansApproveCount = MembershipPlan::where('status',"APPROVED")->count();
        $membershipPlansUnapproveCount = MembershipPlan::where('status',"UNAPPROVED")->count();
        
        return view('admin.membershipPlans.allMembershipPlan',compact('membershipPlansUnapproveCount','membershipPlansApproveCount','membershipPlansCount','membershipPlans'));
    }

    // Add membership plan view
    public function membershipPlanCreate(){
        $currencies = Currency::where('status','APPROVED')->get();
        return view('admin.membershipPlans.addMembershipPlan',compact('currencies'));
    }

    // Store new membership plan
    public function membershipPlanStore(Request $request){

        $data = new MembershipPlan();
        $data->plan_name = $request->plan_name;
        $data->plan_type = $request->plan_type;
        $data->currency = $request->currency;
        $data->plan_amount = $request->plan_amount;
        $data->plan_duration = $request->plan_duration;
        $data->plan_contacts = $request->plan_contacts;
        $data->chat = $request->chat;
        $data->status = 'APPROVED';
        $data->only_for = $request->only_for;
        $data->save();
        return redirect()->route('admin.membershipPlan.all')->with('message', 'Membership plan created successfully');
    }

    // Edit membership plan view
    public function membershipPlanEdit(Request $request,$id){
        $membershipPlan = MembershipPlan::where('id',$id)->first();
        $currencies = Currency::where('status','APPROVED')->get();
        return view('admin.membershipPlans.addMembershipPlan',compact('membershipPlan','currencies'));
    }

    // Edit membership plan store
    public function membershipPlanUpdate(Request $request,$id){

       $update = MembershipPlan::findOrFail($id);
       $update->plan_name = $request->plan_name;
       $update->plan_type = $request->plan_type;
       $update->plan_amount = $request->plan_amount;
       $update->currency = $request->currency;
       $update->plan_duration = $request->plan_duration;
       $update->plan_contacts = $request->plan_contacts;
       $update->chat = $request->chat;
       $update->only_for = $request->only_for;
       $update->save();

        return redirect()->route('admin.membershipPlan.all')->with('message', 'Data Update Sucessfully');
    }

    // Delete membership plan
    public function membershipPlanDestroy($id){
        $data = MembershipPlan::findOrFail($id);
        $data->delete();

        return redirect()->route('admin.membershipPlan.all')->with('message', 'Data Deleted Sucessfully');
    }
    
    // Membership plan action button
    public function membershipPlanStatus(Request $request){

        $selectedIds = $request->input('selected');

        if($request->action == "approve"){
            MembershipPlan::whereIn('id', $selectedIds)->update(['status' => 'APPROVED']);
            return redirect()->back()->with('message','Status updated Sucessfully');
        }

        if($request->action == "unapprove"){
            MembershipPlan::whereIn('id', $selectedIds)->update(['status' => 'UNAPPROVED']);
            return redirect()->back()->with('message','Status updated Sucessfully');
        }

        if($request->action == "delete"){
            MembershipPlan::whereIn('id', $selectedIds)->delete();
            return redirect()->back()->with('message','Data Deleted Sucessfully');
        }
    }
}
