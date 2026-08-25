<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\AdminMatchCriteria;
use App\Models\Age;
use App\Models\Caste;
use App\Models\Country;
use App\Models\Register;
use App\Models\MatchesList;
use App\Models\EmailSetting;
use App\Models\Religion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Mail;


class MatchMakingController extends Controller
{
    public function matchmaking(Request $request)
    {
        $ages = Age::all();
        $countries = Country::where('status',"APPROVED")->get();
        $religions = Religion::where('status',"APPROVED")->get();
        $castes = Caste::where('status',"APPROVED")->get();

        $adminMatchCriteria = AdminMatchCriteria::first();
        $matchParameters = explode(',',$adminMatchCriteria->parameter);
        
        $members = Register::whereNotIn('status', ["Inactive", "Suspended"])->orderby('created_at','desc')->get();
        $matchmaking = [];

        foreach ($members as $id) {
            $countryLivingIds = explode(',', $id->part_country_living);
            $religionIds = explode(',', $id->part_religion);
            $casteIds = explode(',', $id->part_caste);
            $looking_forIds = explode(',', $id->looking_for);
            $edu_detail = explode(',', $id->edu_detail);
            $part_mtongue = explode(',', $id->part_mtongue);
        
            $data = Register::select('*')->with('age_from','age_to','rel','cast','hei')
                ->selectRaw('YEAR(CURDATE()) - YEAR(birthdate) - (DATE_FORMAT(CURDATE(), "%m%d") < DATE_FORMAT(birthdate, "%m%d")) AS age');

            $data->WhereNot('gender', $id->gender);

            if(in_array('m_status',$matchParameters)){
                $data->where('m_status', $looking_forIds);
            }
            if(in_array('country',$matchParameters)){
                $data->whereIn('country_id', $countryLivingIds);
            }
            if(in_array('religion',$matchParameters)){
                $data->whereIn('religion', $religionIds);
            }
            if(in_array('caste',$matchParameters)){
                $data->whereIn('caste', $casteIds);
            }
            //$data->where('part_edu', 'like', '%' . $edu_detail[0] . '%');
            //$data->where('m_tongue', $part_mtongue);
            if(in_array('age',$matchParameters)){
                if (!empty($id->age_to) && !empty($id->age_from) && !empty($id->age_to->age) && !empty($id->age_from->age)) {
                    $ageto = $id->age_to->age;
                    $agefrom = $id->age_from->age;

                    $data->whereRaw('YEAR(CURDATE()) - YEAR(birthdate) - (DATE_FORMAT(CURDATE(), "%m%d") < DATE_FORMAT(birthdate, "%m%d")) BETWEEN ? AND ?', [$agefrom, $ageto]);
                }
            }

            if(in_array('height',$matchParameters)){
                if (!empty($id->part_height_to) && !empty($id->part_height)){
                    $height_to = $id->part_height_to; 
                    $height_from = $id->part_height;
                    if(!empty($height_to) && !empty($height_from)) {
                        $data->whereBetween('height', [$height_from, $height_to]);
                    }
                }
            }

            $count = $data->count();
            if ($count >= 1) {
                $matchmaking[] = [
                    'member_data' => $id,
                    'count' => $count,
                ];
            }
        }
        $perPage = 10;
        $page = request()->get('page', 1); 
        
        $slicedData = array_slice($matchmaking, ($page - 1) * $perPage, $perPage);
        
        $paginator = new LengthAwarePaginator(
            $slicedData, 
            count($matchmaking),
            $perPage, 
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
        $AllmemberCount = Register::count();        
        $featuredCount = Register::where('fstatus',"Featured")->count();
        $unapproveCount = Register::where('status',"Inactive")->count();
        $approveeCount = Register::where('status',"Active")->count();
        $paidCount = Register::where('status',"Paid")->count();

        return view('admin.matchMaking.matchMaking',compact('AllmemberCount','featuredCount','unapproveCount','approveeCount','paidCount','paginator','ages','castes','countries','religions','matchParameters'));
    }

    public function sendmailprofile(Request $request,$id)
    {
            $adminMatchCriteria = AdminMatchCriteria::first();
            $matchParameters = explode(',',$adminMatchCriteria->parameter);

            $id = Register::where('id',$id)->whereNotIn('status', ["Inactive", "Suspended"])->first();
            $matchmaking = [];

            $countryLivingIds = explode(',', $id->part_country_living);
            $religionIds = explode(',', $id->part_religion);
            $casteIds = explode(',', $id->part_caste);
            $looking_forIds = explode(',', $id->looking_for);
            $edu_detail = explode(',', $id->edu_detail);
            $part_mtongue = explode(',', $id->part_mtongue);

            $data = Register::select('*')->with('age_from','age_to','rel','cast','hei')
                ->selectRaw('YEAR(CURDATE()) - YEAR(birthdate) - (DATE_FORMAT(CURDATE(), "%m%d") < DATE_FORMAT(birthdate, "%m%d")) AS age');

            $data->WhereNot('gender', $id->gender);
            
            if(in_array('m_status',$matchParameters)){
                $data->where('m_status', $looking_forIds);
            }
            if(in_array('country',$matchParameters)){
                $data->whereIn('country_id', $countryLivingIds);
            }
            if(in_array('religion',$matchParameters)){
                $data->whereIn('religion', $religionIds);
            }
            if(in_array('caste',$matchParameters)){
                $data->whereIn('caste', $casteIds);
            }

            //$data->where('part_edu', 'like', '%' . $edu_detail[0] . '%');
            //$data->where('m_tongue', $part_mtongue);

            if(in_array('age',$matchParameters)){
                if (!empty($id->age_to) && !empty($id->age_from) && !empty($id->age_to->age) && !empty($id->age_from->age)) {
                    $ageto = $id->age_to->age;
                    $agefrom = $id->age_from->age;

                    $data->whereRaw('YEAR(CURDATE()) - YEAR(birthdate) - (DATE_FORMAT(CURDATE(), "%m%d") < DATE_FORMAT(birthdate, "%m%d")) BETWEEN ? AND ?', [$agefrom, $ageto]);
                }
            }
            if(in_array('height',$matchParameters)){
                if (!empty($id->part_height_to) && !empty($id->part_height)){
                    $height_to = $id->part_height_to; 
                    $height_from = $id->part_height;
                    if(!empty($height_to) && !empty($height_from)) {
                        $data->whereBetween('height', [$height_from, $height_to]);
                    }
                }
            }
            $matchmaking = $data->paginate(5);
       
        return view('admin.matchMaking.sendMatchProfile',compact('matchmaking','id'));
    }

    public function matchismailsend(Request $request)
    {
       
        $selectedMembers = request()->selectedMembers; // Assuming the selectedMembers array comes from the request
        
        $idsAsString = implode(',', $selectedMembers);

        $emails = $request->email;
        
        $emailSetting = EmailSetting::find(1);
        $emailTo = $emails;
        $content = $selectedMembers; 

        Mail::send('admin.email.matchingProfileEmailTemplate', compact('content'), function($message) use($request){
            $message->to($request->email)
            ->subject("Matching Profiles");
        });


        //store data in matchlist table
        foreach($selectedMembers as $data)
        {
            $matchesList = MatchesList::where('my_id',$request->membermatri_id)->where('other_id',$data)->first();
            
            if($matchesList == null)
            {
                $matchesList = new MatchesList();
                $matchesList->my_id = $request->membermatri_id;
                $matchesList->other_id = $data;
                $matchesList->sent_on = Carbon::now();
                $matchesList->save();
            }
        }
        return redirect()->back()->with('message','Matching profile sent successfully');
    }

    public function setMatchCriteria(Request $request){

        $adminMatchCriteria = AdminMatchCriteria::first();
        if($request->matchCriteria != NULL){
            $criteria = implode(',',$request->matchCriteria);
        }else{
            $criteria = NULL;
        }
        $adminMatchCriteria->parameter = $criteria;
        $adminMatchCriteria->save();
        return redirect()->back()->with('message','Match criteria set successfully.');

    }
}
