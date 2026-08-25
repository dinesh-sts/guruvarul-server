<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Age;
use App\Models\Caste;
use App\Models\Country;
use App\Models\DeleteProfile;
use App\Models\MembershipPlan;
use App\Models\Payment;
use App\Models\Register;
use App\Models\Religion;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\Schema;

class MembersController extends Controller{

    // All members
    public function membersAll(Request $request){

        $ages = Age::all();
        $countries = Country::where('status',"APPROVED")->get();
        $religions = Religion::where('status',"APPROVED")->get();
        $castes = Caste::where('status',"APPROVED")->get();

        $query = Register::select('id','status','fstatus', 'matri_id','firstname', 'lastname', 'profileby', 'email', 'gender', 'height', 'caste', 'mobile', 'birthdate', 'religion', 'address','country_id', 'photo1_approve','photo1')
        ->selectRaw('YEAR(CURDATE()) - YEAR(birthdate) - (DATE_FORMAT(CURDATE(), "%m%d") < DATE_FORMAT(birthdate, "%m%d")) AS age');

        //For quick search modal
        //$searchId = $request->input('id');

        // if (!empty($searchId)) {
        //     $query->where('matri_id', $searchId);
        // }

        $keyword  = $request->input('keyword');
        //$keyword = isset($request->input('id')) ? $formDataArray['keyword'] : null;

        
        if (!empty($keyword)) {
            $query->where(function ($query) use ($keyword) {
                $model = new Register(); 
                $columns = Schema::getColumnListing($model->getTable()); 
            
                foreach ($columns as $column) {
                    $query->orWhere($column, 'like', '%' . $keyword . '%');
                }
            });
        }


        $searchcaste = $request->caste;
        if (!empty($searchcaste)) {
            $query->where('caste', $searchcaste);
        }

        $gender = $request->input('gender');
        if (!empty($gender)) {
            $query->where('gender', $gender);
        }

        $ageto = $request->input('age_to');
        $agefrom = $request->input('age_from');

        if (!empty($ageto) && !empty($agefrom)) {  
            $query->whereRaw('YEAR(CURDATE()) - YEAR(birthdate) - (DATE_FORMAT(CURDATE(), "%m%d") < DATE_FORMAT(birthdate, "%m%d")) BETWEEN ? AND ?', [$ageto, $agefrom]);
        }

        $religion = $request->input('religion');
        if (!empty($religion)) {
            $query->where('religion', $religion);
        }

        //for sort members
        $filter = $request->input('filter');
        if ($filter === 'active') {
            $query->where('status', 'Active'); 
        } 
        if ($filter === 'inactive') {
            $query->where('status', 'Inactive'); 
        } 
        if ($filter === 'featured') {
            $query->where('fstatus', 'Featured'); 
        }
        if ($filter === 'paid') {
            $query->where('status', 'Paid'); 
        }
        
        $members = $query->orderByDesc('id')->paginate(5);
        $allMembersCount = Register::count();        
        $featuredMembersCount = Register::where('fstatus',"Featured")->count();
        $unapprovedMembersCount = Register::where('status',"Inactive")->count();
        $approvedMembersCount = Register::where('status',"Active")->count();
        $paidMembersCount = Register::where('status',"Paid")->count();
       
        if (session('member') === 'memberbBtnPaid') {
            Session::forget('member');
        }
        Session::put('member', 'memberBtnApproved');

        return view('admin.members.allMembers',compact('members','ages','castes','countries','religions','allMembersCount','featuredMembersCount','unapprovedMembersCount','approvedMembersCount','paidMembersCount'));

    }

    // Active to paid members
    public function membersApprovedToPaid(Request $request){

        $countries = Country::where('status',"APPROVED")->get();
        $religions = Religion::where('status',"APPROVED")->get();
        $castes = Caste::where('status',"APPROVED")->get();
        $ages = Age::all();

        $query = Register::where('status','Active')->select('id','photo1_approve','matri_id', 'firstname', 'lastname', 'profileby', 'email', 'gender', 'height', 'caste', 'mobile', 'birthdate', 'religion', 'address', 'photo1','country_id','state_id','occupation','m_tongue','status','fstatus')
        ->selectRaw('YEAR(CURDATE()) - YEAR(birthdate) - (DATE_FORMAT(CURDATE(), "%m%d") < DATE_FORMAT(birthdate, "%m%d")) AS age');

        $members = $query->orderByDesc('id')->paginate(5);
        $allMembersCount = Register::count();        
        $featuredMembersCount = Register::where('fstatus',"Featured")->count();
        $unapprovedMembersCount = Register::where('status',"Inactive")->count();
        $approvedMembersCount = Register::where('status',"Active")->count();
        $paidMembersCount = Register::where('status',"Paid")->count();

        $membershipPlans = MembershipPlan::all();

        Session::put('member', 'memberBtnPaid');

        if (session('member') === 'memberBtnApproved') {
            Session::forget('memberBtnApproved');
        }

        return view('admin.members.membersApprovedToPaid',compact('allMembersCount','featuredMembersCount','unapprovedMembersCount','approvedMembersCount','paidMembersCount','ages','castes','countries','religions','membershipPlans','members'));
    }

    // Add to featured members
    public function membersFeatured(Request $request){

        $countries = Country::where('status',"APPROVED")->get();
        $religions = Religion::where('status',"APPROVED")->get();
        $castes = Caste::where('status',"APPROVED")->get();
        $ages = Age::all();

        $query = Register::where('status','Paid')->orWhere('status','Active')->select('id','matri_id' ,'firstname', 'lastname', 'profileby', 'email', 'gender', 'height', 'caste', 'mobile', 'birthdate', 'religion', 'address', 'photo1','country_id','state_id','occupation','m_tongue','status','fstatus','photo1_approve')
        ->selectRaw('YEAR(CURDATE()) - YEAR(birthdate) - (DATE_FORMAT(CURDATE(), "%m%d") < DATE_FORMAT(birthdate, "%m%d")) AS age');

        $members = $query->orderByDesc('id')->paginate(5);
        $allMembersCount = Register::count();        
        $featuredMembersCount = Register::where('fstatus',"Featured")->count();
        $unapprovedMembersCount = Register::where('status',"Inactive")->count();
        $approvedMembersCount = Register::where('status',"Active")->count();
        $paidMembersCount = Register::where('status',"Paid")->count();

        $membership = MembershipPlan::all();

        if (session('member') === 'memberBtnPaid') {
            Session::forget('member');
        }
        if (session('member') === 'memberBtnApproved') {
            Session::forget('memberBtnApproved');
        }
        return view('admin.members.membersFeatured',compact('allMembersCount','featuredMembersCount','unapprovedMembersCount','approvedMembersCount','paidMembersCount','ages','castes','countries','religions','membership','members'));
    }

    //Renew membership members
    public function renewMembership(Request $request){  
        
        $countries = Country::where('status',"APPROVED")->get();
        $religions = Religion::where('status',"APPROVED")->get();
        $castes = Caste::where('status',"APPROVED")->get();
        $countries = Country::where('status',"APPROVED")->get();
        $ages = Age::all();        
        
        $expiredMatriIds = [];

        $payment = Payment::select('id', 'pmatri_id', 'exp_date','created_at')
        ->whereIn('id', function ($query) {
            $query->select(FacadesDB::raw('MAX(id)'))
                ->from('payments')
                ->groupBy('pmatri_id');
        })
        ->orderBy('created_at', 'desc')
        ->get();
     
        foreach ($payment as $data) {

            $today = \Carbon\Carbon::now()->format('d-m-Y');
            $date = \Carbon\Carbon::createFromFormat('d-m-y', $data->exp_date)->format('d-m-Y');
           
            $today = strtotime(date($today));
            $date = strtotime(date($date));
            if ($date <= $today) {
                $expiredMatriIds[] = $data->pmatri_id;
            }
        }
        $query = Register::WhereIn('matri_id',$expiredMatriIds)->select('id','matri_id' ,'firstname', 'lastname', 'profileby', 'email', 'gender', 'height', 'caste', 'mobile', 'birthdate', 'religion', 'address', 'photo1','country_id','state_id','occupation','m_tongue','status','fstatus','photo1_approve')
        ->with('hei', 'rel','occ','mother_tongue','h_edu','country','state')
        ->WhereNot('status',"Suspended")
        ->selectRaw('YEAR(CURDATE()) - YEAR(birthdate) - (DATE_FORMAT(CURDATE(), "%m%d") < DATE_FORMAT(birthdate, "%m%d")) AS age');

        $renewMembers = $query->orderByDesc('id')->paginate(5);
        
        $allMembersCount = Register::count();        
        $featuredMembersCount = Register::where('fstatus',"Featured")->count();
        $unapprovedMembersCount = Register::where('status',"Inactive")->count();
        $approvedMembersCount = Register::where('status',"Active")->count();
        $paidMembersCount = Register::where('status',"Paid")->count();

        $membershipPlans = MembershipPlan::all();

        Session::put('member', 'memberBtnPaid');
        if (session('member') === 'memberBtnApproved') {
            Session::forget('memberBtnApproved');
        }
        return view('admin.members.renewMembership',compact('allMembersCount','featuredMembersCount','unapprovedMembersCount','approvedMembersCount','paidMembersCount','ages','castes','countries','religions','membershipPlans','renewMembers'));
    }

    // Action bar for status change multiple select
    public function updateStatus(Request $request){

        try {

            $selectedIds = $request->input('selectedMembers');

            if($request->action == "approve"){
                Register::whereIn('id', $selectedIds)->update(['status' => 'Active','mobile_verify' => 'Yes']);
                return redirect()->back()->with('message','Member approved sucessfully');
            }
    
            if($request->action == "unapprove"){
                Register::whereIn('id', $selectedIds)->update(['status' => 'Inactive','fstatus' => NULL]);
                return redirect()->back()->with('message','Member unapproved sucessfully');
            }
            
            if($request->action == "delete"){

                $deleteid = Register::whereIn('id', $selectedIds)->get();
              
                foreach($deleteid as $delete){
                    Register::where('matri_id', $delete->matri_id)->delete();
                    DeleteProfile::where('matri_id', $delete->matri_id)->delete();
                }

                Register::whereIn('id', $selectedIds)->delete();

                return redirect()->back()->with('message','Member deleted sucessfully');
            }

            if($request->action == "Featured"){
                Register::whereIn('id', $selectedIds)->update(['fstatus' => 'Featured']);
                return redirect()->back()->with('message','Featured sucessfully');
            }
    
            if($request->action == "removeFeatured"){
                Register::whereIn('id', $selectedIds)->update(['fstatus' => NULL]);
                return redirect()->back()->with('message','Removed from featured sucessfully');
            }

            return redirect()->back()->with('message','Please select members');

        } catch (QueryException $e) {
            return redirect()->back()->with('message', 'An error occurred while deleting the member.');
        }
    }

    // Make profile featured
    public function makeFeaturedProfile(Request $request,$id){
        Register::where('id', $id)->update(['fstatus' => 'Featured']);
        return redirect()->back()->with('message','Featured sucessfully');
    }

    //Remove profile from featured
    public function removeFeaturedProfile(Request $request,$id){
        Register::where('id', $id)->update(['fstatus' => NULL]);
        return redirect()->back()->with('message','Removed from featured sucessfully');
    }

    // Approve profile
    public function approveProfile(Request $request,$id){
        Register::where('id', $id)->update(['status' => 'Active','mobile_verify' => 'Yes']);
        return redirect()->back()->with('message','Member approved sucessfully');
    }

    // Unapprove profile
    public function unApproveProfile(Request $request,$id){
        Register::where('id', $id)->update(['status' => 'Inactive','fstatus' => NULL]);
        return redirect()->back()->with('message','Member unapproved sucessfully');
    }

    //Add membership plan
    public function approvedToPaidStore(Request $request){
       
        $id = $request->id;
        $register = Register::where('id',$id)->first();
        $membership = MembershipPlan::where('plan_name',$request->p_plan)->first();

        //calculate future date
        $today = Carbon::today();
        $planDuration = $membership->plan_duration;
        $futureDate =  $today->addDays($planDuration);
        $formattedFutureDate = $futureDate->format("d-m-y");

        $payment = new Payment();
        $payment->pmatri_id = $register->matri_id;
        $payment->pname = $register->firstname." ".$register->lastname;
        $payment->pcontact = $register->mobile;
        $payment->pemail = $register->email;
        $payment->paymode = $request->paymode;
        if($request->pactive_dt){
            $payment->pactive_dt = $request->pactive_dt;
        }else{
            $payment->pactive_dt = Carbon::today()->format("d-m-y");
        }
        $payment->p_plan = $request->p_plan;
        $payment->plan_duration = $membership->plan_duration;
        $payment->chat = $membership->chat;
        $payment->p_no_contacts = $membership->plan_contacts;
        $payment->plan_currency = $membership->currency;
        $payment->p_amount = $membership->plan_amount;
        $payment->exp_date = $formattedFutureDate;
        $payment->save();
        
        if($payment == true){
            $id = $request->id;
            $register = Register::findOrFail($id);
            $register->status = "Paid";
            $register->save();
        }
        return redirect()->back()->with('message', 'Membership plan created sucessfully');
    }

    // Fetch caste on bases of religion
    public function fetchCaste(Request $request){  
        $data['caste'] = Caste::where("religion_id", $request->religion_id)
        ->get(["caste_name","id"]);
    
        return response()->json($data);
    }

    public function memberDelete($id){  
        try {
            $data = Register::findOrFail($id);
            DeleteProfile::where('matri_id', $data->matri_id)->delete();
            $data->delete();
            return redirect()->route('admin.membersAll')->with('message', 'Data Deleted Sucessfully');
        } catch (QueryException $e) {
            return redirect()->back()->with('message', 'An error occurred while deleting the member.');
        }
    }

}
