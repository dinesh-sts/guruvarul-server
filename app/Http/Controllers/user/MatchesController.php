<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Register;
use Illuminate\Support\Facades\Auth;
use App\Models\Age;
use App\Models\BlockProfile;
use App\Models\Caste;
use App\Models\Mothertongue;
use App\Models\Country;
use App\Models\City;
use App\Models\Height;
use App\Models\Religion;
use App\Models\EducationDetail;
use App\Models\Ignore;
use App\Models\Matches;
use App\Models\SiteConfig;


class MatchesController extends Controller
{
    public function oneWayMatch()
    {
        
        $siteconfig = SiteConfig::first();
        $id = Auth::guard('user')->user();

        $ignore = Ignore::where('ignore_by', $id->matri_id)->pluck('ignore_to')->toArray();
        $blockuser =  BlockProfile::where('block_by', $id->matri_id)->pluck('block_to')->toArray();

        $countryLivingIds = explode(',', $id->part_country_living);
        $religionIds = explode(',', $id->part_religion);
        $casteIds = explode(',', $id->part_caste);
        $looking_forIds = explode(',', $id->looking_for);

        $data = Register::select('*')->whereNotIn('matri_id',$ignore)->whereNotIn('status',['Inactive','Suspended'])->whereNotIn('matri_id',$blockuser)->with('high_edu','mother_tongue','age_from','age_to','rel','cast','subcast','occ','father_occ','mother_occ','inc','country','state','citi','hei','part_from_hei','part_to_hei','doshes','staars','rashi')
        ->selectRaw('YEAR(CURDATE()) - YEAR(birthdate) - (DATE_FORMAT(CURDATE(), "%m%d") < DATE_FORMAT(birthdate, "%m%d")) AS age');

        $data->WhereNot('gender', $id->gender);
        $data->whereIn('country_id', $countryLivingIds);
        $data->whereIn('religion', $religionIds);
        $data->whereIn('caste', $casteIds);
        $data->whereIn('m_status', $looking_forIds);
        if(isset($id->age_to)){

            $agefrom = $id->age_from->age;
            $ageto = $id->age_to->age;
            if (!empty($ageto) && !empty($agefrom)) {  
                $data->whereRaw('YEAR(CURDATE()) - YEAR(birthdate) - (DATE_FORMAT(CURDATE(), "%m%d") < DATE_FORMAT(birthdate, "%m%d")) BETWEEN ? AND ?', [$agefrom, $ageto]);
            }
        }

        $oneway = $data->orderby('created_at','desc')->paginate(5);
    
        return view('user.oneWayMatch',compact('siteconfig','oneway'));
    }

    public function twoWayMatch()
    {
        $siteconfig = SiteConfig::first();
        $id = Auth::guard('user')->user();

        $ignore = Ignore::where('ignore_by', $id->matri_id)->pluck('ignore_to')->toArray();
        $blockuser =  BlockProfile::where('block_by', $id->matri_id)->pluck('block_to')->toArray();

        $edudeatils = explode(',', $id->edu_detail);
        $edu = $edudeatils[0];
      
        $data = Register::select('*')->whereNotIn('matri_id',$ignore)->whereNotIn('status',['Inactive','Suspended'])->whereNotIn('matri_id',$blockuser)->with('high_edu','mother_tongue','age_from','age_to','rel','cast','subcast','occ','father_occ','mother_occ','inc','country','state','citi','hei','part_from_hei','part_to_hei','doshes','staars','rashi')
        ->selectRaw('YEAR(CURDATE()) - YEAR(birthdate) - (DATE_FORMAT(CURDATE(), "%m%d") < DATE_FORMAT(birthdate, "%m%d")) AS age');

       $data->where('part_edu', 'like', '%' . $edu . '%');
       $data->where('country_id', $id->country_id);
       $data->where('religion', $id->religion);
        $data->WhereNot('gender', $id->gender);
        $data->where('caste', $id->caste);
       $data->where('m_status', $id->m_status);
        $twoway = $data->orderby('created_at','desc')->paginate(5);
        return view('user.twoWayMatch',compact('siteconfig','twoway'));
    }
    public function broaderWayMatch()
    {
        $siteconfig = SiteConfig::first();
        $id = Auth::guard('user')->user();

        $ignore = Ignore::where('ignore_by', $id->matri_id)->pluck('ignore_to')->toArray();
        $blockuser =  BlockProfile::where('block_by', $id->matri_id)->pluck('block_to')->toArray();

        $casteIds = explode(',', $id->part_caste);
       // dd($casteIds);
        if($id->will_to_mary_caste == '1'){
            $c=$id->caste;
        }elseif($casteIds != null){
            $c=$casteIds;
        }else{
            $c="";
        }
       
        $data = Register::select('*')->whereNotIn('matri_id',$ignore)->whereNotIn('status',['Inactive','Suspended'])->whereNotIn('matri_id',$blockuser)->with('high_edu','mother_tongue','age_from','age_to','rel','cast','subcast','occ','father_occ','mother_occ','inc','country','state','citi','hei','part_from_hei','part_to_hei','doshes','staars','rashi')
        ->selectRaw('YEAR(CURDATE()) - YEAR(birthdate) - (DATE_FORMAT(CURDATE(), "%m%d") < DATE_FORMAT(birthdate, "%m%d")) AS age');

        $data->where('country_id', $id->country_id);
        $data->where('religion', $id->religion);
        $data->WhereNot('gender', $id->gender);
       $data->where('caste', $c);
        
        $broaderway = $data->orderby('created_at','desc')->paginate(5);
        return view('user.broaderWayMatch',compact('siteconfig','broaderway'));
    }

    public function preferedWayMatch()
    {
        $siteconfig = SiteConfig::first();
        $id = Auth::guard('user')->user();

        $ignore = Ignore::where('ignore_by', $id->matri_id)->pluck('ignore_to')->toArray();
        $blockuser =  BlockProfile::where('block_by', $id->matri_id)->pluck('block_to')->toArray();

        $edu_detail = explode(',', $id->edu_detail);
       
        $data = Register::select('*')->whereNotIn('matri_id',$ignore)->whereNotIn('status',['Inactive','Suspended'])->whereNotIn('matri_id',$blockuser)->with('high_edu','mother_tongue','age_from','age_to','rel','cast','subcast','occ','father_occ','mother_occ','inc','country','state','citi','hei','part_from_hei','part_to_hei','doshes','staars','rashi')
        ->selectRaw('YEAR(CURDATE()) - YEAR(birthdate) - (DATE_FORMAT(CURDATE(), "%m%d") < DATE_FORMAT(birthdate, "%m%d")) AS age');
        
        $data->where('part_height', 'like', '%' . $id->height . '%');
        $data->where('part_country_living', 'like', '%' . $id->country_id . '%');
        $data->where('part_religion', 'like', '%' . $id->religion . '%');
        $data->where('part_caste', 'like', '%' . $id->caste . '%');
        $data->where('part_edu', 'like', '%' . $edu_detail[0] . '%');
        $data->WhereNot('gender', $id->gender);
        if(isset($id->age_to))
        {
            $ageto = $id->age_to->age;
            $agefrom = $id->age_from->age;
            if (!empty($ageto) && !empty($agefrom)) {  
                $data->whereRaw('YEAR(CURDATE()) - YEAR(birthdate) - (DATE_FORMAT(CURDATE(), "%m%d") < DATE_FORMAT(birthdate, "%m%d")) BETWEEN ? AND ?', [$agefrom, $ageto]);
            }
        }
        
        $preferedway = $data->orderby('created_at','desc')->paginate(5);
        return view('user.preferedWayMatch',compact('siteconfig','preferedway'));
    }

    public function customWayMatch()
    {
        $siteconfig = SiteConfig::first();
        $mothertongues = Mothertongue::where('status',"APPROVED")->get();
        $countries = Country::where('status',"APPROVED")->get();
        $religions = Religion::where('status',"APPROVED")->get();
        $edu_details = EducationDetail::where('status',"APPROVED")->get();
        $ages = Age::all();
        $cities = City::where('status',"APPROVED")->get();
        $heights = Height::all();
        $castes = Caste::where('status',"APPROVED")->get();

        $Authuser = Auth::guard('user')->user();

        $ignore = Ignore::where('ignore_by', $Authuser->matri_id)->pluck('ignore_to')->toArray();
        $blockuser =  BlockProfile::where('block_by', $Authuser->matri_id)->pluck('block_to')->toArray();

        $matchis = matches::where('matri_id',$Authuser->matri_id)->first();
        $customway = [];
        if($matchis != null)
        {
            $id = $matchis;
        
        $edu_detail = Null;
        if(isset($id->edu_detail) && $id->edu_detail != "")
        {
            $edu_detail = explode(',', $id->edu_detail);
        }
        $m_status = Null;
        if(isset($id->looking_for) && $id->looking_for != "")
        {
            $m_status = explode(',', $id->looking_for);
        }
        $part_frm_age = Null;
        if(isset($id->part_frm_age) && $id->part_frm_age != "")
        {
            $part_frm_age = explode(',', $id->part_frm_age);
        }
        $part_to_age = Null;
        if(isset($id->part_to_age) && $id->part_to_age != "")
        {
            $part_to_age = explode(',', $id->part_to_age);
        }
        $part_height = Null;
        if(isset($id->part_height) && $id->part_height != "")
        {
            $part_height = explode(',', $id->part_height);
        }
        $part_height_to = Null;
        if(isset($id->part_height_to) && $id->part_height_to != "")
        {
            $part_height_to = explode(',', $id->part_height_to);
        }
        $part_religion = Null;
        if(isset($id->part_caste) && $id->part_religion != "")
        {
            $part_religion = explode(',', $id->part_religion);
        }
        $part_caste = Null;
        if(isset($id->part_caste) && $id->part_caste != "")
        {
            $part_caste = explode(',', $id->part_caste);
        }
        $part_mtongue = Null;
        if(isset($id->part_mtongue) && $id->part_mtongue != "")
        {
            $part_mtongue = explode(',', $id->part_mtongue);
        }
        $part_complexation = Null;
        if(isset($id->part_complexation) && $id->part_complexation != "")
        {
            $part_complexation = explode(',', $id->part_complexation);
        }
        $part_country_living = Null;
        if(isset($id->part_country_living) && $id->part_country_living != "")
        {
            $part_country_living = explode(',', $id->part_country_living);
        }
       // \DB::enableQueryLog();
        $data = Register::select('*')->whereNotIn('matri_id',$ignore)->whereNotIn('matri_id',$blockuser)->whereNotIn('status',['Inactive','Suspended'])->whereNotIn('status',['Inactive','Suspended'])->with('high_edu','mother_tongue','age_from','age_to','rel','cast','hei','part_from_hei','part_to_hei')
        ->selectRaw('YEAR(CURDATE()) - YEAR(birthdate) - (DATE_FORMAT(CURDATE(), "%m%d") < DATE_FORMAT(birthdate, "%m%d")) AS age');
        if(isset($id->age_to) && $id->age_to != null)
        {
            $ageto = $id->age_to->age;
            $agefrom = $id->age_from->age;
            if(!empty($ageto) && !empty($agefrom)) {
                $data->whereRaw('YEAR(CURDATE()) - YEAR(birthdate) - (DATE_FORMAT(CURDATE(), "%m%d") < DATE_FORMAT(birthdate, "%m%d")) BETWEEN ? AND ?', [$agefrom, $ageto]);
            }	
        }
        if(isset($id->part_height_to) && $id->part_height_to != null)
        {
            
            $height_to = $id->part_height_to; 
            $height_from = $id->part_height;
            if(!empty($height_to) && !empty($height_from)) {
                $data->whereBetween('height', [$height_from, $height_to]);
            }
        }
        if(isset($id->part_caste) && $id->part_religion != "")
        {
            $data->whereIn('religion', $part_religion);
        }
        if(isset($id->part_caste) && $id->part_caste != "")
        {
            $data->whereIn('caste', $part_caste);
        }
        if(isset($id->part_mtongue) && $id->part_mtongue != "")
        {
            $data->whereIn('m_tongue', $part_mtongue);
        }
        if(isset($id->part_complexation) && $id->part_complexation != "")
        {
            $data->whereIn('complexion', $part_complexation);
        }
        if(isset($id->part_country_living) && $id->part_country_living != "")
        {
            $data->whereIn('country_id', $part_country_living);
        }
        if(isset($id->looking_for) && $id->looking_for != "")
        {
            $data->whereIn('m_status', $m_status);
        }
        if($edu_detail != null && $id->edu_detail != "")
        {
            $data->whereIn('part_edu', $edu_detail);
        }
       
        $data->whereNot('gender', Auth::guard('user')->user()->gender);
        $customway = $data->orderby('created_at','desc')->paginate(5);
        }
        return view('user.customWayMatch',compact('siteconfig','castes','matchis','customway','mothertongues','countries','religions','edu_details','ages','cities','heights'));
    }

    public function customWayPost(Request $request)
    {
        $id = Auth::guard('user')->user();
        $matchis = matches::where('matri_id',$id->matri_id)->first();
        if($matchis != null)
        {
            $matchis = Matches::findOrFail($matchis->id);
            $looking_for = collect($request->input('looking_for'));
            $matchis->looking_for = $looking_for->implode(',');
            $matchis->matri_id = $id->matri_id;
            $matchis->part_frm_age = $request->part_frm_age;
            $matchis->part_to_age = $request->part_to_age;
            $matchis->part_height = $request->part_height;
            $matchis->part_height_to = $request->part_height_to;

            $part_mtongue = collect($request->input('part_mtongue'));
            $matchis->part_mtongue = $part_mtongue->implode(',');

            $part_religion = collect($request->input('part_religion'));
            $matchis->part_religion = $part_religion->implode(',');

            $part_complexation = collect($request->input('part_complexation'));
            $matchis->part_complexation = $part_complexation->implode(',');

            $part_caste = collect($request->input('part_caste'));
            $matchis->part_caste = $part_caste->implode(',');

            $part_edu = collect($request->input('part_edu'));
            $matchis->part_edu = $part_edu->implode(',');

            $part_country_living = collect($request->input('part_country_living'));
            $matchis->part_country_living = $part_country_living->implode(',');

            $matchis->save();
        }else{
            $matchis = new Matches();
            $looking_for = collect($request->input('looking_for'));
            $matchis->looking_for = $looking_for->implode(',');
            $matchis->matri_id = $id->matri_id;
            $matchis->part_frm_age = $request->part_frm_age;
            $matchis->part_to_age = $request->part_to_age;
            $matchis->part_height = $request->part_height;
            $matchis->part_height_to = $request->part_height_to;

            $part_mtongue = collect($request->input('part_mtongue'));
            $matchis->part_mtongue = $part_mtongue->implode(',');

            $part_religion = collect($request->input('part_religion'));
            $matchis->part_religion = $part_religion->implode(',');

            $part_complexation = collect($request->input('part_complexation'));
            $matchis->part_complexation = $part_complexation->implode(',');

            $part_caste = collect($request->input('part_caste'));
            $matchis->part_caste = $part_caste->implode(',');

            $part_edu = collect($request->input('part_edu'));
            $matchis->part_edu = $part_edu->implode(',');

            $part_country_living = collect($request->input('part_country_living'));
            $matchis->part_country_living = $part_country_living->implode(',');

            $matchis->save();
        }
        return redirect()->route('user.customWayMatch');
    }
}
