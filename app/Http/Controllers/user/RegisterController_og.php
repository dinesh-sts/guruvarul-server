<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\Religion;
use App\Models\Caste;
use App\Models\Register;
use App\Models\SiteConfig;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\RegisterRequest;
use App\Models\Age;
use App\Models\City;
use App\Models\CountryCode;
use App\Models\Dosh;
use App\Models\EducationDetail;
use App\Models\FieldSetting;
use App\Models\Gotra;
use App\Models\Height;
use App\Models\Income;
use App\Models\Mothertongue;
use App\Models\Occupation;
use App\Models\ProfileBy;
use App\Models\Rasi;
use App\Models\Sms;
use App\Models\Star;
use App\Models\State;
use App\Models\Subcast;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail; 
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;


class RegisterController extends Controller
{

    public function register()
    { 
        $profiles = ProfileBy::where('status',"APPROVED")->get();
        $countries = Country::where('status',"APPROVED")->get();
        $religions = Religion::where('status',"APPROVED")->get();
        $castes = Caste::where('status',"APPROVED")->get();
        $country_code = CountryCode::all();

        return view('user.register',compact('country_code','profiles','countries','religions','castes'));
    }

    public function registerPost(RegisterRequest $request)
    {
        $siteconfig = SiteConfig::select('male_legal_age','female_legal_age','prefix','mobileVerification','registerPersonalDetails','registerPreferenceDetails')->first();

        $year = $request->year;
        $month = $request->month;
        $day = $request->day;
        $birthdate = $year.'-'.$month.'-'.$day; 

        $female_legal_age = $siteconfig->female_legal_age;
        $male_legal_age = $siteconfig->male_legal_age;
        $from = new Carbon($birthdate);
	    $to = new Carbon('today');
	    $age =$from->diff($to)->y;

        $register = new Register();
        $register->mobile_code = '+'.$request->mobile_code;
        $register->profileby = $request->profileby;
        $register->gender = $request->gender;
        $register->firstname = $request->firstname;
        $register->lastname = $request->lastname;
        //check legal age
        if($request->gender == 'Female')
        {
            if($age >= $female_legal_age)
            {
                $register->birthdate = $birthdate;
            }else{
                return Redirect::back()->with('legalage', 'Your age is below ' .$female_legal_age.' year or check your birthdate');
            }
        }

        if($request->gender == 'Male')
        {
            if($age >= $male_legal_age)
            {
                $register->birthdate = $birthdate;
            }else{
                return Redirect::back()->with('legalage', 'Your age is below ' .$male_legal_age.' year or check your birthdate');
            }
        }

        $register->religion = $request->religion;
        $register->caste = $request->caste;
        $register->mobile = $request->mobile; 
        $register->email = $request->email;
        $register->m_status = $request->m_status;
        $register->password =  Hash::make($request['password']);
        $register->country_id = $request->country_id;
        $register->prefix = $siteconfig->prefix;
        $register->status = 'Inactive';
        $register->contact_view_security = '1';
        if($siteconfig->mobileVerification == "No"){
            $register->mobile_verify = 'Yes';
        }
        $register->save();
        Session::put('registerid', $register->id);
        if($register == true)
        {
            $updateregister = Register::findOrFail($register->id);
            $updateregister->matri_id = $siteconfig->prefix.$register->id;
            $updateregister->save();
          
            $id = $updateregister->matri_id;
            $token = Str::random(64);
             DB::table('password_reset_tokens')->insert([
                'email' => $register->email, 
                'token' => $token,
                'created_at' => Carbon::now()
            ]);
            //Email verification mail sending
            // Mail::send('user.email.verifyEmail', ['token' => $token], function($message) use($register){
            //     $message->to($register->email);
            //     $message->subject('Verify your email account');
            // });
            session::put('email',"email sent successfully");
        }
        session::put('register',"register successfully");

        if($siteconfig->mobileVerification == "Yes"){
            return redirect()->route('user.mobileVerify');
        }elseif($siteconfig->registerPersonalDetails == "Yes"){
            return redirect()->route('user.registerPersonalDetails');
        }elseif($siteconfig->registerPreferenceDetails == "Yes"){
            return redirect()->route('user.registerPersonalDetails');
        }else{
            return redirect()->route('user.registerDocumentUpload');
	    //return redirect()->route('user.userMembershipPlans');
        }
        
    }

    public function registerMobileVerify(Request $request)
    {
        $id = $request->session()->get('registerid');
        $user = Register::where('id', $id)->first();
        if($user != "")
        {
            $otp = rand(1234, 9999);
            session::put('user_id',$user->mobile);
            session::put('otp',$otp);
            $mobile = $user->mobile;
            $api = $this->smsapi($otp,$mobile);
            return view('user.registerMobileVerify',compact('id'));

        }else{
            return redirect()->back()->with('message','enter correct mobile number');
        }
    }

    public function smsapi($otp ,$mobile)
    { 
        $key = Sms::where('key','fast2smsKey')->first();
        $route = Sms::where('key','fast2smsRoute')->first();
        $activeapi = Sms::where('key','activeapi')->first();
        if($activeapi->value == "fast2sms"){
            if(isset($key->value) && isset($route->value)){
                $url = "https://www.fast2sms.com/dev/bulkV2?authorization=$key->value&route=$route->value&variables_values=$otp&flash=0&numbers=$mobile";
                if(env('DEMO_MODE') != 'On'){
                    $ret = file($url);
                    return $ret;
                }
            }
        }elseif($activeapi->value == "msg91"){
            $url = "";
        }else{
            $url = "";
        }
      
    }

    public function registerMobileEdit()
    { 
        return view('user.registerEditMobile');
    }
    
    public function registerOTPRegenerate(Request $request)
    {
        $id = $request->session()->get('registerid');
        $user = Register::FindOrFail($id);
        $user->mobile = $request->mobile;
        $user->save();
        
        Session::forget('otp');
        if($user)
        {
            $otp = rand(1234, 9999);
            session::put('user_id',$user->mobile);
            session::put('otp',$otp);
            return redirect()->route('user.mobileVerify')->with('success',  "OTP has been sent on Your Mobile Number."); 
        }else{
            return redirect()->back()->with('message','Enter correct mobile number');
        }
    }

    public function registerOtpVerify(Request $request)
    {
        
        $siteconfig = SiteConfig::first();
        $otp = session('otp');
        $mobile = session('user_id');
        

        if($request->varify_code == $otp){
            $id = $request->session()->get('registerid');
            $user_id = Register::where('mobile',$mobile)->first();
            if($user_id != "")
            {
                $user = Register::FindOrFail($id);
                $user->mobile_verify = "Yes";
                $user->save();
                session::put('varify',"Mobile No verified successfully");
                Session::forget('otp');
                Session::forget('user_id');
                

                if($siteconfig->registerPersonalDetails == "Yes"){
                    return redirect()->route('user.registerPersonalDetails');
                }elseif($siteconfig->registerPreferenceDetails == "Yes"){
                    return redirect()->route('user.registerPersonalDetails');
                }else{
                    return redirect()->route('user.registerDocumentUpload');
                }
            }else{
                return redirect()->back()->with('message', 'Please enter correct OTP');
            }
        }
        return redirect()->back()->with('message', 'Please enter correct OTP');
        
    }

    public function registerPersonalDetails(Request $request){

        $id = $request->session()->get('registerid');
        
        $register = Register::findOrFail($id);
        $siteconfig = SiteConfig::first();
        $profiles = ProfileBy::where('status',"APPROVED")->get();
        $countries = Country::where('status',"APPROVED")->get();
        $religions = Religion::where('status',"APPROVED")->get();
        $castes = Caste::where('status',"APPROVED")->get();
        $country_code = CountryCode::all();
        $subcastes = Subcast::where('status',"APPROVED")->get();
        $gotras = Gotra::where('status',"APPROVED")->get();
        $mothertongues = Mothertongue::where('status',"APPROVED")->get();
        $edu_details = EducationDetail::where('status',"APPROVED")->get();
        $occupations = Occupation::where('status',"APPROVED")->get();
        $incomes = Income::where('status',"APPROVED")->get();
        $states = State::where([['status',"APPROVED"],['country_code',$register->country_id]])->get();
        $cities = City::where('status',"APPROVED")->get();
        $heights = Height::all();
        $doshes = Dosh::where('status',"APPROVED")->get();
        $rashies = Rasi::where('status',"APPROVED")->get();
        $stars = Star::where('status',"APPROVED")->get();
        $ages = Age::all();
        $fieldsetting = FieldSetting::first();
        //$register = Register::where('matri_id',$id)->first();

        return view('user.registerPersonalDetails',compact('siteconfig','fieldsetting','country_code','ages','doshes','rashies','stars','heights','cities','states','incomes','occupations','edu_details','profiles','countries','religions','castes','mothertongues','subcastes','gotras','register'));

    }

    public function registerPersonalDetailsPost(Request $request){
        
        $siteconfig = SiteConfig::first();
        $id = $request->session()->get('registerid');
        $register = Register::findOrFail($id);

        $register->m_tongue = $request->m_tongue;
        $register->subcaste = $request->subcaste;
        $register->gotra = $request->gotra;
        $register->will_to_mary_caste =  $request->will_to_mary_caste;

        $edu_details = collect($request->input('edu_detail'));
        $register->edu_detail = $edu_details->implode(',');
        $register->emp_in = $request->emp_in;
        $register->occupation = $request->occupation;
        $register->company_name = $request->company_name;
        $register->designation = $request->designation;
        $register->income = $request->income;

        $register->family_type = $request->family_type;
        $register->family_value = $request->family_value;
        $register->family_status = $request->family_status;
        $register->father_name = $request->father_name;
        $register->father_occupation = $request->father_occupation;
        $register->mother_name = $request->mother_name;
        $register->mother_occupation = $request->mother_occupation;
        $register->no_of_brothers = $request->no_of_brothers;
        $register->no_marri_brother = $request->no_marri_brother;
        $register->no_of_sisters = $request->no_of_sisters;
        $register->no_marri_sister = $request->no_marri_sister;
        $register->maternal_details = $request->maternal_details;
        $register->paternal_details = $request->paternal_details;

        $register->country_id = $request->country_id;
        $register->state_id = $request->state_id;
        $register->city = $request->city;
        $register->address = $request->address;

        $register->diet = $request->diet;
        $register->smoke = $request->smoke;
        $register->drink = $request->drink;

        $register->height = $request->height;
        $register->weight = $request->weight;
        $register->bodytype = $request->bodytype;
        $register->complexion = $request->complexion;
        $register->physicalStatus = $request->physical_status;
        $register->b_group = $request->b_group;     

        $register->dosh = $request->dosh;
        $register->manglik = $request->manglik;
        $register->moonsign = $request->moonsign;
        $register->star = $request->star;
        $register->birthtime = $request->birthtime;
        $register->birthplace = $request->birthplace;

        $register->profile_text = $request->profile_text;
            
        $register->save();

        if($siteconfig->registerPreferenceDetails == "Yes"){
            return redirect()->route('user.registerPreferenceDetails')->with('message', 'Data Updated Sucessfully');
        }else{
            return redirect()->route('user.registerDocumentUpload');
        }
    }

    public function registerPreferenceDetails(Request $request){
        $id = $request->session()->get('registerid');
        
        $register = Register::findOrFail($id);
        $siteconfig = SiteConfig::first();
        $profiles = ProfileBy::where('status',"APPROVED")->get();
        $countries = Country::where('status',"APPROVED")->get();
        $religions = Religion::where('status',"APPROVED")->get();
        $castes = Caste::where('status',"APPROVED")->get();
        $country_code = CountryCode::all();
        $subcastes = Subcast::where('status',"APPROVED")->get();
        $gotras = Gotra::where('status',"APPROVED")->get();
        $mothertongues = Mothertongue::where('status',"APPROVED")->get();
        $edu_details = EducationDetail::where('status',"APPROVED")->get();
        $occupations = Occupation::where('status',"APPROVED")->get();
        $incomes = Income::where('status',"APPROVED")->get();
        $states = State::where('status',"APPROVED")->get();
        $cities = City::where('status',"APPROVED")->get();
        $heights = Height::all();
        $doshes = Dosh::where('status',"APPROVED")->get();
        $rashies = Rasi::where('status',"APPROVED")->get();
        $stars = Star::where('status',"APPROVED")->get();
        $ages = Age::all();
        $fieldsetting = FieldSetting::first();

         return view('user.registerPreferenceDetails',compact('siteconfig','fieldsetting','country_code','ages','doshes','rashies','stars','heights','cities','states','incomes','occupations','edu_details','profiles','countries','religions','castes','mothertongues','subcastes','gotras','register'));

    }

    public function registerPreferenceDetailsPost(Request $request){

        $id = $request->session()->get('registerid');
        $register = Register::findOrFail($id);
        
        $looking_for = collect($request->input('looking_for'));
        $register->looking_for = $looking_for->implode(',');

        $register->part_frm_age = $request->part_frm_age;
        $register->part_to_age = $request->part_to_age;
        $register->part_height = $request->part_height;
        $register->part_height_to = $request->part_height_to;

        $part_mtongue = collect($request->input('part_mtongue'));
        $register->part_mtongue = $part_mtongue->implode(',');

        $part_physical = collect($request->input('part_physical'));
        $register->part_physical = $part_physical->implode(',');

        $part_complexation = collect($request->input('part_complexation'));
        $register->part_complexation = $part_complexation->implode(',');

        $part_bodytype = collect($request->input('part_bodytype'));
        $register->part_bodytype = $part_bodytype->implode(',');
    
        $part_diet = collect($request->input('part_diet'));
        $register->part_diet = $part_diet->implode(',');

        $part_smoke = collect($request->input('part_smoke'));
        $register->part_smoke = $part_smoke->implode(',');

        $part_drink = collect($request->input('part_drink'));
        $register->part_drink = $part_drink->implode(',');
    
        $part_edu = collect($request->input('part_edu'));
        $register->part_edu = $part_edu->implode(',');

        $part_occu = collect($request->input('part_occu'));
        $register->part_occu = $part_occu->implode(',');

        $part_emp_in = collect($request->input('part_emp_in'));
        $register->part_emp_in = $part_emp_in->implode(',');

        $part_income = collect($request->input('part_income'));
        $register->part_income = $part_income->implode(',');
    
        $part_religion = collect($request->input('part_religion'));
        $register->part_religion = $part_religion->implode(',');

        $part_caste = collect($request->input('part_caste'));
        $register->part_caste = $part_caste->implode(',');

        $part_star = collect($request->input('part_star'));
        $register->part_star = $part_star->implode(',');

        $part_rasi = collect($request->input('part_rasi'));
        $register->part_rasi = $part_rasi->implode(',');

        $register->part_dosh = $request->part_dosh;

        $part_manglik = collect($request->input('part_manglik'));
        
        $register->part_manglik = $part_manglik->implode(',');
    
        $part_country_living = collect($request->input('part_country_living'));
        $register->part_country_living = $part_country_living->implode(',');

        $part_state = collect($request->input('part_state'));
        $register->part_state = $part_state->implode(',');

        $part_city = collect($request->input('part_city'));
        $register->part_city = $part_city->implode(',');
    
        $register->part_expect = $request->part_expect;
           
        $register->save();
        return redirect()->route('user.registerDocumentUpload')->with('message', 'Data Update Sucessfully');
	//return redirect()->route('user.userMembershipPlans')->with('message', 'Data Update Sucessfully');
    }


    public function documentupload()
    { 
        return view('user.registerDocumentUpload');
    }
    
    public function documentpost(Request $request)
    {
        $id = $request->session()->get('registerid');
        $register = Register::findOrFail($id);
        if ($request->has('aadhaar_card')) {
            if ($request->hasFile('aadhaar_card')) {

                $file = $request->file('aadhaar_card');
                $imageFileType = $file->getClientOriginalExtension();
                $imageFilesize = $request->aadhaar_card->getSize();
                $imageName = time().'.'.$imageFileType; 

                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                    return redirect()->back()->with('message','Sorry, only JPG, JPEG, PNG & GIF files are allowed');
                }elseif($imageFilesize > 8000000) {
                    return redirect()->back()->with('message','your file size is more than 4MB.');
                }else{
                    $imageManager = new ImageManager(new Driver());

                    $thumbImage = $imageManager->read($file);
                    //$resizedImage = $thumbImage->resize(1200, 1200)->toJpeg(90);
                    $resizedImage = $thumbImage->toJpeg(90);
                    
                    Storage::disk('public')->delete('userImages/' . $register->aadhaar_card);
                    Storage::disk('public')->put('userImages/'.$imageName,$resizedImage);

                    $register->aadhaar_card = $imageName;
                    $register->aadhaar_card_status = "PENDING";
                }

            }
        }
        $register->save();
        return redirect()->route('user.registerConfirmation');   
    }

    public function registerConfirmation()
    { 
        Session::forget('registerid');
        return view('user.registerConfirmation');
    }

    public function emailVerification($token)
    {
        $site_configvarify = SiteConfig::first();
        $updatePassword = DB::table('password_reset_tokens')->where(['token' => $token])->first();
        if ($updatePassword != null) {
            $difference = Carbon::now()->diffInSeconds($updatePassword->created_at);
            if ($difference > 900) {
                DB::table('password_reset_tokens')->where(['token'=> $token])->delete();
                return redirect()->back()->with('message', 'Token Expired!');
            }else{
                if($site_configvarify->profile_varification == "manual_approve")
                {
                    $register = Register::where('email',$updatePassword->email)->first();
                    $data = Register::FindOrFail($register->id);
                    $data->cpass_status = "Yes";
                    $data->mobile_verify = "Yes";
                    $data->save();
                    DB::table('password_reset_tokens')->where(['token'=> $token])->delete();
                    return redirect()->route('home')->with('message', 'Email id verified succesfully.');
                }else{
                    $register = Register::where('email',$updatePassword->email)->first();
                    $data = Register::FindOrFail($register->id);
                    $data->cpass_status = "Yes";
                    $data->status = "Active";
                    if($site_configvarify->mobileVerification == "No"){
                        $data->mobile_verify = "Yes";
                    }
                    $data->save();
                    DB::table('password_reset_tokens')->where(['token'=> $token])->delete();
                    return redirect()->route('home')->with('message', 'Email id verified succesfully.');
                }
            }
        }
        return redirect()->route('home')->with('message', 'Problem in email verification link or email is already verified.');
    }


    public function userprofilestate(Request $request)
    {  
        $data['states'] = State::where("country_code", $request->country_id)->get();
        return response()->json($data);
    }

    public function userprofilecity(Request $request)
    { 
        $data['cities'] = City::where("state_code", $request->state_id)->get();
        return response()->json($data);
    }

    public function userprofilepartcaste(Request $request)
    {   
        $casteIds = $request->input('part_religion_id');
        if($casteIds != null)
        {
            $data['partcastie'] = Caste::whereIn('religion_id', $casteIds)->where('status','APPROVED')->get();
        }else{
            $data['partcastie'] = "";
        }
        return response()->json($data);
    }

    public function userprofilepartstate(Request $request)
    {   
        $countryIds = $request->input('partcountryIds');
        if($countryIds != null)
        {
            $data['partstates'] = State::whereIn('country_code', $countryIds)->get();
        }else{
            $data['partstates'] = "";
        }
        return response()->json($data);
    }

    public function userprofilepartcity(Request $request)
    {   
        $stateIds = $request->input('partstateIds');
        if($stateIds != null)
        {
            $data['partcities'] = City::whereIn('state_code', $stateIds)->get();
    
        }else{
            $data['partcities'] = "";
        }
        return response()->json($data);
    }

}
