<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Religion;
use App\Models\Age;
use App\Models\BlockProfile;
use App\Models\Register;
use App\Models\Caste;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\EducationDetail;
use App\Models\FieldSetting;
use App\Models\Height;
use App\Models\Ignore;
use App\Models\Income;
use App\Models\Occupation;
use App\Models\SiteConfig;
//use App\Models\Register;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class SearchController extends Controller
{
    //search form
    public function search(Request $request)
    {
        $religions = Religion::where('status',"APPROVED")->get();
        $ages = Age::all();
        $countries = Country::where('status',"APPROVED")->get();
        $edu_details = EducationDetail::where('status',"APPROVED")->get();
        $occupations = Occupation::where('status',"APPROVED")->get();
        $incomes = Income::where('status',"APPROVED")->get();
        $heights = Height::all();
        $fieldsetting = FieldSetting::first();
        $request->session()->forget('searchResultData');
        $request->session()->forget('formData');
        return view('user.searchUser',compact('fieldsetting','religions','ages','countries','edu_details','occupations','incomes','heights'));
    }
    
    //search form data fatch
    public function quickSearch(Request $request)
    { 
        $log_inid = Auth::guard('user')->user();
        $formData = $request->input('formData');
        $request->session()->put('formData', $formData);
        $formDataArray = [];
        
        parse_str($formData, $formDataArray);
        if($log_inid != Null)
        {
            $ignore = Ignore::where('ignore_by', $log_inid->matri_id)->pluck('ignore_to')->toArray();
            $blockuser =  BlockProfile::where('block_by', $log_inid->matri_id)->pluck('block_to')->toArray();
            $data = Register::select('*')->whereNotIn('matri_id',$ignore)->whereNotIn('matri_id',$blockuser)->whereNot('gender',$log_inid->gender)->whereNotIn('status',['Inactive','Suspended'])->with('high_edu','mother_tongue','age_from','age_to','rel','cast','subcast','h_edu','add_edu','occ','inc','country','state','citi','hei','part_from_hei','part_to_hei','doshes','staars','rashi')
            ->selectRaw('YEAR(CURDATE()) - YEAR(birthdate) - (DATE_FORMAT(CURDATE(), "%m%d") < DATE_FORMAT(birthdate, "%m%d")) AS age');
        }else{
            $data = Register::select('*')->whereNotIn('status',['Inactive','Suspended'])->with('high_edu','mother_tongue','age_from','age_to','rel','cast','subcast','h_edu','add_edu','occ','mother_occ','inc','country','state','citi','hei','part_from_hei','part_to_hei','doshes','staars','rashi')
            ->selectRaw('YEAR(CURDATE()) - YEAR(birthdate) - (DATE_FORMAT(CURDATE(), "%m%d") < DATE_FORMAT(birthdate, "%m%d")) AS age');
        }
    
        $gender = isset($formDataArray['gender']) ? $formDataArray['gender'] : null;
        if (!empty($gender)) {
            $data->where('gender', $gender);
        }
        $ageto = isset($formDataArray['age_to']) && !empty($formDataArray['age_to']) ? $formDataArray['age_to'] : null;
        if (!is_null($ageto)) {
            $ageto = $formDataArray['age_to'];
            $agefrom = $formDataArray['age_from'];
            if (!empty($ageto) && !empty($agefrom)) {  
                $data->whereRaw('YEAR(CURDATE()) - YEAR(birthdate) - (DATE_FORMAT(CURDATE(), "%m%d") < DATE_FORMAT(birthdate, "%m%d")) BETWEEN ? AND ?', [$ageto, $agefrom]);
            }
        } 

        $height_from = isset($formDataArray['height_from']) && !empty($formDataArray['height_from']) ? $formDataArray['height_from'] : null;
        if (!is_null($height_from)) {
            $part_height = $formDataArray['part_height_to'];
            $height_from = $formDataArray['height_from'];
            if (!empty($part_height) && !empty($height_from)) {  
                $data->whereBetween('height', [$height_from, $part_height]);
            }
        } 
        
        $part_edu = isset($formDataArray['part_edu']) ? $formDataArray['part_edu'] : null;
        if (!is_null($part_edu) && !empty($part_edu)) {
            $data->where(function ($query) use ($part_edu) {
                foreach ($part_edu as $eduValue) {
                    $query->orWhereRaw("FIND_IN_SET(?, edu_detail)", [$eduValue]);
                }
            });
        }

        $part_religion = isset($formDataArray['part_religion']) ? $formDataArray['part_religion'] : null;
        if (!is_null($part_religion) && !empty($part_religion)) {
            $data->whereIn('religion', $part_religion);
        }
        
        $part_caste = isset($formDataArray['part_caste']) ? $formDataArray['part_caste'] : null;
        if (!is_null($part_caste) && !empty($part_caste)) {
            $data->whereIn('caste', $part_caste);
        }

        //fatch part_occu
        $part_occu = isset($formDataArray['part_occu']) ? $formDataArray['part_occu'] : null;
        if (!is_null($part_occu) && !empty($part_occu)) {
            $data->whereIn('occupation', $part_occu);
        }

        $looking_for = isset($formDataArray['m_status']) ? $formDataArray['m_status'] : null;
      
        if (!is_null($looking_for) && !empty($looking_for)) {
            $data->whereIn('m_status', $looking_for);
        }
        $part_income = isset($formDataArray['part_income']) ? $formDataArray['part_income'] : null;
        if (!is_null($part_income) && !empty($part_income)) {
            $data->whereIn('income', $part_income);
        }

        $part_country_living = isset($formDataArray['part_country_living']) ? $formDataArray['part_country_living'] : null;
        if (!is_null($part_country_living) && !empty($part_country_living)) {
            $data->whereIn('country_id', $part_country_living);
        }

        $part_state = isset($formDataArray['part_state']) ? $formDataArray['part_state'] : null;
        if (!is_null($part_state) && !empty($part_state)) {
            $data->whereIn('state_id', $part_state);
        }

        $part_city = isset($formDataArray['part_city']) ? $formDataArray['part_city'] : null;
        if (!is_null($part_city) && !empty($part_city)) {
            $data->whereIn('city', $part_city);
        }
        
        //MEMBERID SEARCH
        $member_id = isset($formDataArray['member_id']) ? $formDataArray['member_id'] : null;
        if (!empty($member_id)) {
            $data->where('matri_id', $member_id);
        }
        //KEYWORD SEARCH
       
        $keyword = isset($formDataArray['keyword']) ? $formDataArray['keyword'] : null;
       
        if (!empty($keyword)) {
            $data->where(function ($query) use ($keyword) {
                $model = new Register(); 
                $columns = Schema::getColumnListing($model->getTable()); 
            
                foreach ($columns as $column) {
                    $query->orWhere($column, 'like', '%' . $keyword . '%');
                }
            });
        }
        
        $data = $data->orderBy('created_at',"desc")->get();
        $request->session()->put('searchResultData', $data);
       
        return Redirect()->route('user.searchResultView');
      
    }

    //single search
    public function singlesearch(Request $request)
    { 
        $log_inid = Auth::guard('user')->user();
     
        $formData = $request->gender;
        $request->session()->put('formData', $formData);
        if($log_inid != Null)
        {
            $ignore = Ignore::where('ignore_by', $log_inid->matri_id)->pluck('ignore_to')->toArray();
            $blockuser =  BlockProfile::where('block_by', $log_inid->matri_id)->pluck('block_to')->toArray();
            $data = Register::select('*')->whereNotIn('matri_id',$ignore)->whereNotIn('matri_id',$blockuser)->whereNotIn('status',['Inactive','Suspended'])->whereNot('gender',$log_inid->gender)->with('high_edu','mother_tongue','age_from','age_to','rel','cast','subcast','h_edu','add_edu','occ','inc','country','state','citi','hei','part_from_hei','part_to_hei','doshes','staars','rashi')
            ->selectRaw('YEAR(CURDATE()) - YEAR(birthdate) - (DATE_FORMAT(CURDATE(), "%m%d") < DATE_FORMAT(birthdate, "%m%d")) AS age');
        }else{
            $data = Register::select('*')->whereNotIn('status',['Inactive','Suspended'])->with('high_edu','mother_tongue','age_from','age_to','rel','cast','subcast','h_edu','add_edu','occ','inc','country','state','citi','hei','part_from_hei','part_to_hei','doshes','staars','rashi')
            ->selectRaw('YEAR(CURDATE()) - YEAR(birthdate) - (DATE_FORMAT(CURDATE(), "%m%d") < DATE_FORMAT(birthdate, "%m%d")) AS age');
        }

        $gender = isset($request->gender) ? $request->gender : null;
        if (!empty($gender)) {
            $data->where('gender', $gender);
        }
        $ageto = isset($request->age_to) && !empty($request->age_to) ? $request->age_to : null;
        if (!is_null($ageto)) {
            $ageto = $request->age_to;
            $agefrom = $request->age_from;
            if (!empty($ageto) && !empty($agefrom)) {  
                $data->whereRaw('YEAR(CURDATE()) - YEAR(birthdate) - (DATE_FORMAT(CURDATE(), "%m%d") < DATE_FORMAT(birthdate, "%m%d")) BETWEEN ? AND ?', [$ageto, $agefrom]);
            }
        } 

        $part_religion = isset($request->religion) ? $request->religion : null;
        if (!is_null($part_religion) && !empty($part_religion)) {
            $data->where('religion', $part_religion);
        }
        
        $part_caste = isset($request->caste) ? $request->caste : null;
        if (!is_null($part_caste) && !empty($part_caste)) {
            $data->where('caste', $part_caste);
        }
      
        $data = $data->get();
        $request->session()->put('searchResultData', $data);
       
        return Redirect()->route('user.searchResultView');
    }

    //main page 
    /*public function result(Request $request)
    {
        $fieldsetting = FieldSetting::first();
        $countries = Country::where('status',"APPROVED")->get();
        $occupations = Occupation::where('status',"APPROVED")->get();
        $edu_details = EducationDetail::where('status',"APPROVED")->get();
        $heights = Height::all();
        $religions = Religion::where('status',"APPROVED")->get();
        $casties = Caste::where('status',"APPROVED")->get();
        $ages = Age::all();
        $siteconfig = SiteConfig::first();
        $data = $request->session()->get('searchResultData');
	//dd($data);
        //$currentPage = LengthAwarePaginator::resolveCurrentPage();
	$currentPage = 1;
        $perPage = 5;
    	if($data !== null) {
		$currentPageItems = $data->slice(($currentPage - 1) * $perPage, $perPage)->all();
	}
    
        $result = new LengthAwarePaginator($currentPageItems, $data->count(), $perPage);
        $result->withPath(route('user.searchResultView')); 
        if(Auth::guard('user')->user())
        {
            return view('user.afterLoginSearchResult', compact('fieldsetting','casties','result','siteconfig','religions','ages','heights','edu_details','occupations','countries'));
           
        }else{
            return view('user.beforeLoginSearchResult', compact('fieldsetting','casties','result','siteconfig','religions','ages','heights','edu_details','occupations','countries'));
        }
        
    }*/
public function result(Request $request)
{
    $fieldsetting = FieldSetting::first();
    $countries = Country::where('status', "APPROVED")->get();
    $occupations = Occupation::where('status', "APPROVED")->get();
    $edu_details = EducationDetail::where('status', "APPROVED")->get();
    $heights = Height::all();
    $religions = Religion::where('status', "APPROVED")->get();
    $casties = Caste::where('status', "APPROVED")->get();
    $ages = Age::all();
    $siteconfig = SiteConfig::first();

    // Fetch all users or data you want to paginate
    //$data = Registers::where('status', 'APPROVED')->get();  // example, replace User with your model
    //$data = Register::all();
    $data = Register::whereNotIn('status', ['Inactive','Expired','Suspended'])
        ->when(Auth::guard('user')->check(), function($query) {
            $log_inid = Auth::guard('user')->user();
            // Only opposite gender
            $query->where('gender', '!=', $log_inid->gender);
        })
        ->orderBy('created_at','desc')
        ->get();

    $perPage = 25;
    $currentPage = LengthAwarePaginator::resolveCurrentPage();

    $total = $data->count();
    $currentPageItems = $data->slice(($currentPage - 1) * $perPage, $perPage)->values();

    $result = new LengthAwarePaginator($currentPageItems, $total, $perPage, $currentPage, [
        'path' => route('user.searchResultView'),
        'query' => $request->query(),
    ]);

    if (Auth::guard('user')->check()) {
        return view('user.afterLoginSearchResult', compact(
            'fieldsetting', 'casties', 'result', 'siteconfig',
            'religions', 'ages', 'heights', 'edu_details', 'occupations', 'countries'
        ));
    } else {
        return view('user.beforeLoginSearchResult', compact(
            'fieldsetting', 'casties', 'result', 'siteconfig',
            'religions', 'ages', 'heights', 'edu_details', 'occupations', 'countries'
        ));
    }
}


    //caste fatch
    public function searchfetchcaste(Request $request)
    {    
        $casteIds = $request->input('part_religion_id');
   
        if($casteIds != null)
        {
            $data['partcastie'] = Caste::whereIn('religion_id', $casteIds)->where('status',"APPROVED")->get();
           
        }else{
            $data['partcastie'] = "";
        }
        return response()->json($data);
    }

    //state fatch
     public function searchstate(Request $request)
     {    
        $countryIds = $request->input('partcountryIds');
        if($countryIds != null)
        {
            $data['partstates'] = State::whereIn('country_code', $countryIds)->where('status',"APPROVED")->get();
        }else{
            $data['partstates'] = "";
        }
        return response()->json($data);
     }

    //city fatch
    public function searchcity(Request $request)
    {    
        $stateIds = $request->input('partstateIds');
        if($stateIds != null)
        {
            $data['partcities'] = City::whereIn('state_code', $stateIds)->where('status',"APPROVED")->get();
    
        }else{
            $data['partcities'] = "";
        }
        return response()->json($data);
    }

    public function searchdata(Request $request)
    {
        $log_inid = Auth::guard('user')->user();
        $formData = $request->input('searchData');
        $request->session()->put('formData', $formData);

        $formDataArray = [];
        parse_str($formData, $formDataArray);
        //query start
        if($log_inid != Null)
        {
            $blockuser =  BlockProfile::where('block_by', $log_inid->matri_id)->pluck('block_to')->toArray();
            $ignore = Ignore::where('ignore_by', $log_inid->matri_id)->pluck('ignore_to')->toArray();
            $data = Register::select('*')->whereNotIn('matri_id',$ignore)->whereNotIn('matri_id',$blockuser)->whereNotIn('status',['Inactive','Suspended'])->whereNot('gender',$log_inid->gender)
        ->selectRaw('YEAR(CURDATE()) - YEAR(birthdate) - (DATE_FORMAT(CURDATE(), "%m%d") < DATE_FORMAT(birthdate, "%m%d")) AS age');
           
        }else{
            $data = Register::select('*')->whereNotIn('status',['Inactive','Suspended'])
        ->selectRaw('YEAR(CURDATE()) - YEAR(birthdate) - (DATE_FORMAT(CURDATE(), "%m%d") < DATE_FORMAT(birthdate, "%m%d")) AS age');
        }
        
        //fatch gender
        $gender = isset($formDataArray['gender']) ? $formDataArray['gender'] : null;
        if (!empty($gender)) {
            $data->where('gender', $gender);
        }
      
        //fatch photo
        $photo = isset($formDataArray['photo']) ? $formDataArray['photo'] : null;
      
        if ($photo == "with_photo") {
            $data->whereNotNull('photo1');
        }
        //fatch age
        $ageto = isset($formDataArray['age_to']) && !empty($formDataArray['age_to']) ? $formDataArray['age_to'] : null;
        if (!is_null($ageto)) {
            $ageto = $formDataArray['age_to'];
            $agefrom = $formDataArray['age_from'];
            if (!empty($ageto) && !empty($agefrom)) {  
                $data->whereRaw('YEAR(CURDATE()) - YEAR(birthdate) - (DATE_FORMAT(CURDATE(), "%m%d") < DATE_FORMAT(birthdate, "%m%d")) BETWEEN ? AND ?', [$ageto, $agefrom]);
            }
        } 
        //height
        $height_to = isset($formDataArray['height_to']) && !empty($formDataArray['height_to']) ? $formDataArray['height_to'] : null;
        if (!is_null($height_to)) {
            $height_to = $formDataArray['height_to'];
            $height_from = $formDataArray['height_from'];
            if (!empty($height_to) && !empty($height_from)) {  
                $data->whereBetween('height', [$height_to, $height_from]);
            }
        }
        //fatch religion
        $part_religion = isset($formDataArray['part_religion']) ? $formDataArray['part_religion'] : null;
        if (!is_null($part_religion) && !empty($part_religion)) {
            $data->whereIn('religion', $part_religion);
        }
        //fatch caste
        $part_caste = isset($formDataArray['part_caste']) ? $formDataArray['part_caste'] : null;
        if (!is_null($part_caste) && !empty($part_caste)) {
            $data->whereIn('caste', $part_caste);
        }
        //fatch m status
        $m_status = isset($formDataArray['m_status']) ? $formDataArray['m_status'] : null;
        if (!is_null($m_status) && !empty($m_status)) {
            $data->whereIn('m_status', $m_status);
        }
        //fatch part_occu
        $part_occu = isset($formDataArray['part_occu']) ? $formDataArray['part_occu'] : null;
        if (!is_null($part_occu) && !empty($part_occu)) {
            $data->whereIn('occupation', $part_occu);
        }
        //fatch country
        $part_country_living = isset($formDataArray['part_country_living']) ? $formDataArray['part_country_living'] : null;
        if (!is_null($part_country_living) && !empty($part_country_living)) {
            $data->whereIn('country_id', $part_country_living);
        }
        //fatch Education Details
        $part_edu = isset($formDataArray['part_edu']) ? $formDataArray['part_edu'] : null;
        if (!is_null($part_edu) && !empty($part_edu)) {
            $data->where(function ($query) use ($part_edu) {
                foreach ($part_edu as $eduValue) {
                    $query->orWhereRaw("FIND_IN_SET(?, edu_detail)", [$eduValue]);
                }
            });
        }
        $data = $data->orderBy('created_at',"desc")->get();
        $request->session()->put('searchResultData', $data);

        return response()->json([
        ]);
    }
}
