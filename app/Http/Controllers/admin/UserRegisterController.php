<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\RegisterRequest;
//use Intervention\Image\Facades\Image;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use App\Models\Register;
use App\Models\ProfileBy;
use App\Models\Country;
use App\Models\Religion;
use App\Models\Caste;
use App\Models\Mothertongue;
use App\Models\Subcast;
use App\Models\EducationDetail;
use App\Models\Occupation;
use App\Models\Income;
use App\Models\SiteConfig;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\State;
use App\Models\City;
use App\Models\Height;
use App\Models\Dosh;
use App\Models\Rasi;
use App\Models\Star;
use App\Models\Age;
use App\Models\CountryCode;
use App\Models\FieldSetting;
use App\Models\Gotra;
use Illuminate\Database\QueryException;

class UserRegisterController extends Controller{

    public function registerFirst(Request $request){

        $profiles = ProfileBy::where('status',"APPROVED")->get();
        $countries = Country::where('status',"APPROVED")->get();
        $religions = Religion::where('status',"APPROVED")->get();
        $country_code = CountryCode::all();
        $castes = Caste::where('status',"APPROVED")->get();
        $subcastes = Subcast::where('status',"APPROVED")->get();
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
    
        return view('admin.profile.createprofile',compact('country_code','ages','doshes','rashies','stars','heights','cities','states','incomes','occupations','edu_details','profiles','countries','religions','castes','mothertongues','subcastes'));
    }

    public function edituserstate(Request $request){

        if($request->country_id == null){
            $register = Register::where('id',$request->modalId)->first();
            $data['states'] = State::where('country_code',$register->country_id)->get();
            return response()->json($data);
        }else{
            $data['states'] = State::where("country_code", $request->country_id)
            ->get();
            return response()->json($data);
        }   
    }

    public function editusercity(Request $request){ 
        if($request->state_id == null){
            $register = Register::where('id',$request->modalId)->first();
            $data['cities'] = City::where('state_code',$register->state_id)->get();
            return response()->json($data);
        }else{
            $data['cities'] = City::where("state_code", $request->state_id)
            ->get();
            return response()->json($data);
        }
    }

    public function usercaste(Request $request){  
        if($request->religion_id == null){
            $register = Register::where('id',$request->modalId)->first();
            $data['caste'] = Caste::where('religion_id',$register->religion)->get();
            return response()->json($data);
        }else{
            $data['caste'] = Caste::where("religion_id", $request->religion_id)
            ->get();
           // dd($data);
            return response()->json($data);
        }
    }

    public function userpartcaste(Request $request){   
      
        if($request->modalId != null){
            $register = Register::where('id',$request->modalId)->first();
            $casteIds = explode(',', $register->part_religion);
           
            $data['partcastie'] = Caste::whereIn('religion_id', $casteIds)->get();
            return response()->json($data);
        }else{
            $casteIds = $request->input('part_religion_id');
         
            if($casteIds != null){
                $data['partcastie'] = Caste::whereIn('religion_id', $casteIds)->get();
            }else{
                $data['partcastie'] = "";
            }
            return response()->json($data);
        }
    }

    public function partstate(Request $request){   
        if($request->modalId != null){
            $register = Register::where('id',$request->modalId)->first();
            $countryIds = explode(',', $register->part_country_living);
            $data['partstates'] = State::whereIn('country_code', $countryIds)->get();
           
            return response()->json($data);
        }else{
            $countryIds = $request->input('partcountryIds');
            if($countryIds != null){
                $data['partstates'] = State::whereIn('country_code', $countryIds)->get();
            
            }else{
                $data['partstates'] = "";
            }
            return response()->json($data);
        }
    }

    public function partcity(Request $request){   
        if($request->modalId != null)
        {
            $register = Register::where('id',$request->modalId)->first();
            $stateIds = explode(',', $register->part_state);
        
            $data['partcities'] = City::whereIn('state_code', $stateIds)->get();
            return response()->json($data);
        }else{
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

    public function fetchcaste(Request $request){  
            $data['caste'] = Caste::where("religion_id", $request->religion_id)
            ->get(["caste_name","id"]);
       
            return response()->json($data);
    }

    public function storeProfile(RegisterRequest $request){
        $year = $request->year;
        $month = $request->month;
        $day = $request->day;
        $birthdate = $year.'-'.$month.'-'.$day; 
        $siteconfig = SiteConfig::select('male_legal_age','female_legal_age','prefix')->first();

        $female_legal_age = $siteconfig->female_legal_age;
        $male_legal_age = $siteconfig->male_legal_age;
        $from = new Carbon($birthdate);
	    $to = new Carbon('today');
	    $age =$from->diff($to)->y;

        $register = new Register();
        $register->mobile_code = '+'.$request->mobile_code;
        $register->mobile = $request->mobile;
        $register->email = $request->email;
        $register->profileby = $request->profileby;
        $register->gender = $request->gender;
        $register->m_status = $request->m_status;
        $register->firstname = $request->firstname;
        $register->lastname = $request->lastname;
        $register->religion = $request->religion;
        $register->caste = $request->caste;
        $register->country_id = $request->country_id;
        $register->status = 'Active';
        $register->mobile_verify = 'Yes';
        $register->contact_view_security = '1';
        //check legal age
        if($request->gender == 'Female'){
            if($age >= $female_legal_age)
            {
                $register->birthdate = $birthdate;
            }else{
                return Redirect::back()->with('message', 'Your age is below ' .$female_legal_age.' year or check your birthdate');
            }
        }

        if($request->gender == 'Male'){
            if($age >= $male_legal_age)
            {
                $register->birthdate = $birthdate;
            }else{
                return Redirect::back()->with('message', 'Your age is below ' .$male_legal_age.' year or check your birthdate');
            }
        }
        $register->password =  Hash::make($request['password']);
        $register->prefix = $siteconfig->prefix;
        $register->save();
        if($register == true){
            $register = Register::findOrFail($register->id);
            $register->matri_id = $siteconfig->prefix.$register->id;
            $register->save();
        }
            
        return redirect()->back()->with('message', 'Member Profile Created Sucessfully');
    }

    public function EditProfile(Request $request,$id){
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
        $register = Register::where('matri_id',$id)->first();
    
        return view('admin.profile.editprofile',compact('siteconfig','fieldsetting','country_code','ages','doshes','rashies','stars','heights','cities','states','incomes','occupations','edu_details','register','profiles','countries','religions','castes','mothertongues','subcastes','gotras'));
    }

    public function imageDelete(Request $request,$id){
        $photo = $request->input('photo');

        $data = Register::findOrFail($id);
        
        if($photo === 'photo1') {
            Storage::disk('public')->delete('userImages/' . $data->photo1);
            $data->photo1 = Null;
            $data->photo1_approve = Null;
        }
        if($photo === 'photo2') {
            Storage::disk('public')->delete('userImages/' . $data->photo2);
            $data->photo2 = Null;
            $data->photo2_approve = Null;
        }
        if($photo === 'photo3') {
            Storage::disk('public')->delete('userImages/' . $data->photo3);
            $data->photo3 = Null;
            $data->photo3_approve = Null;
        }
        if($photo === 'photo4') {
            Storage::disk('public')->delete('userImages/' . $data->photo4);
            $data->photo4 = Null;
            $data->photo4_approve = Null;
        }
        if($photo === 'photo5') {
            Storage::disk('public')->delete('userImages/' . $data->photo5);
            $data->photo5 = Null;
            $data->photo5_approve = Null;
        }
        if($photo === 'photo6') {
            Storage::disk('public')->delete('userImages/' . $data->photo6);
            $data->photo6 = Null;
            $data->photo6_approve = Null;
        }
        if($photo === 'photo7') {
            Storage::disk('public')->delete('userImages/' . $data->photo7);
            $data->photo7 = Null;
            $data->photo7_approve = Null;
        }
        if($photo === 'photo8') {
            Storage::disk('public')->delete('userImages/' . $data->photo8);
            $data->photo8 = Null;
            $data->photo8_approve = Null;
        }
        if($photo === 'hor_photo') {
            Storage::disk('public')->delete('userImages/' . $data->hor_photo);
            $data->hor_photo = Null;
            $data->hor_check = Null;
        }
        if($photo === 'aadhaar_card') {
            Storage::disk('public')->delete('userImages/' . $data->aadhaar_card);
            $data->aadhaar_card = Null;
            $data->aadhaar_card_status = Null;
        }
        $data->save();
        Session::put('lastUpdatedSection', 'managephoto');
        return redirect()->route('admin.edit-profile', ['id' => $data->matri_id])->with('managephoto', 'photo Deleted Sucessfully');
    }

    public function UpdateProfile(Request $request,$id){
        $year = $request->year;
        $month = $request->month;
        $day = $request->day;
        $birthdate = $year.'-'.$month.'-'.$day; 
        $siteconfig = SiteConfig::select('male_legal_age','female_legal_age',)->first();

        $female_legal_age = $siteconfig->female_legal_age;
        $male_legal_age = $siteconfig->male_legal_age;
       

        if ($request->has('personalDetailsUpdate')) {

            $from = new Carbon($birthdate);
            $to = new Carbon('today');
            $age =$from->diff($to)->y;
            $register = Register::findOrFail($id);
            $register->mobile_code = '+'.$request->mobile_code;

            $rules = $request->validate([
                'mobile' => 'required|numeric|min_digits:5|max_digits:15',
                'email' => 'required|email',
            ]);

            if($request->mobile != NULL && $register->mobile != $request->mobile ){
                $checkMobileNo = Register::where('mobile',$request->mobile)->count();
                if($checkMobileNo > 0){
                    return Redirect::back()->with('basic', 'Mobile no is already in use');
                }
            }
            $register->mobile = $request->mobile;

            if($request->email != NULL && $register->email != $request->email){
                $checkEmail = Register::where('email',$request->email)->count();
                if($checkEmail > 0){
                    return Redirect::back()->with('basic', 'Email is already in use');
                }
            }
            $register->email = $request->email;
            $register->profileby = $request->profileby;
            $register->gender = $request->gender;
            $register->firstname = $request->firstname;
            $register->lastname = $request->lastname;
            $register->m_status = $request->m_status;
            $register->tot_children = $request->tot_children;
            $register->status_children = $request->status_children;
            $register->m_tongue = $request->m_tongue;
            
            //check legal age
            if($request->gender == 'Female'){
                if($age >= $female_legal_age){
                    $register->birthdate = $birthdate;
                }else{
                   return Redirect::back()->with('femalelegalage', 'Your age is below ' .$female_legal_age.' year or check your birthdate');
                }
            }
    
            if($request->gender == 'Male'){
                if($age >= $male_legal_age)
                {
                    $register->birthdate = $birthdate;
                }else{
                   return Redirect::back()->with('femalelegalage', 'Your age is below ' .$male_legal_age.' year or check your birthdate');
                }
            } 
            if ($request->password != NULL) {
                $register->password = Hash::make($request['password']);
            }
            
            $register->religion = $request->religion;
            $register->caste = $request->caste;
            $register->subcaste = $request->subcaste;
            $register->gotra = $request->gotra;
            $register->will_to_mary_caste = $request->will_to_mary_caste;
            $register->church_name = $request->church_name;
            $register->denomination = $request->denomination;
            $register->baptism = $request->baptism;
            $register->born_again = $request->born_again;
    
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
            $register->physicalStatus = $request->physicalStatus;
            $register->b_group = $request->b_group;
       
            $register->profile_text = $request->profile_text;
            $register->dosh = $request->dosh;
            $register->manglik = $request->manglik;
            $register->moonsign = $request->moonsign;
            $register->star = $request->star;
            $register->birthtime = $request->birthtime;
            $register->birthplace = $request->birthplace;
            
            //dd($request->mobile);
            $register->save();
            Session::put('lastUpdatedSection', 'basic');
            return redirect()->route('admin.edit-profile', ['id' => $register->matri_id])->with('basic', 'Profile Details Updated Sucessfully');
        }


        if ($request->has('photo1')) {
            $register = Register::findOrFail($id);
            if ($request->hasFile('photo1')) {
               
                $file = $request->file('photo1');
                $imageFileType = $request->photo1->extension();
                $imageFilesize = $request->photo1->getSize();
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
                    
                    Storage::disk('public')->delete('userImages/' . $register->photo1);
                    Storage::disk('public')->put('userImages/' . $imageName, $resizedImage);
                
                    $register->photo1 = $imageName;
                    $register->photo1_approve = "APPROVED";
                }
            }
            $register->save();
            Session::put('lastUpdatedSection', 'managephoto');
            return redirect()->route('admin.edit-profile', ['id' => $register->matri_id])->with('managephoto', 'photo Update Sucessfully');
        }
        if ($request->has('photo2')) {
            $register = Register::findOrFail($id);
            if ($request->hasFile('photo2')) {
               
                $file = $request->file('photo2');
                $imageFileType = $request->photo2->extension();
                $imageFilesize = $request->photo2->getSize();
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

                    Storage::disk('public')->delete('userImages/' . $register->photo2);
                    Storage::disk('public')->put('userImages/' . $imageName, $resizedImage);
            
                    $register->photo2 = $imageName;
                    $register->photo2_approve = "APPROVED";
                }
            }
            $register->save();
            Session::put('lastUpdatedSection', 'managephoto');
            return redirect()->route('admin.edit-profile', ['id' => $register->matri_id])->with('managephoto', 'photo Update Sucessfully');
        }
        if ($request->has('photo3')) {
            $register = Register::findOrFail($id);
            if ($request->hasFile('photo3')) {
               
                $file = $request->file('photo3');
                $imageFileType = $request->photo3->extension();
                $imageFilesize = $request->photo3->getSize();
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

                    Storage::disk('public')->delete('userImages/' . $register->photo3);
                    Storage::disk('public')->put('userImages/' . $imageName, $resizedImage);
            
                    $register->photo3 = $imageName;
                    $register->photo3_approve = "APPROVED";
                }
            }
            $register->save();
            Session::put('lastUpdatedSection', 'managephoto');
            return redirect()->route('admin.edit-profile', ['id' => $register->matri_id])->with('managephoto', 'photo Update Sucessfully');
        }
        if ($request->has('photo4')) {
            $register = Register::findOrFail($id);
            if ($request->hasFile('photo4')) {
               
                $file = $request->file('photo4'); 
                $imageFileType = $request->photo4->extension();
                $imageFilesize = $request->photo4->getSize();
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

                    Storage::disk('public')->delete('userImages/' . $register->photo4);
                    Storage::disk('public')->put('userImages/' . $imageName, $resizedImage);
            
                    $register->photo4 = $imageName;
                    $register->photo4_approve = "APPROVED";
                }
            }
            $register->save();
            Session::put('lastUpdatedSection', 'managephoto');
            return redirect()->route('admin.edit-profile', ['id' => $register->matri_id])->with('managephoto', 'photo Update Sucessfully');
        }
        if ($request->has('photo5')) {
            $register = Register::findOrFail($id);
            if ($request->hasFile('photo5')) {
               
                $file = $request->file('photo5');
                $imageFileType = $request->photo5->extension();
                $imageFilesize = $request->photo5->getSize();
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

                    Storage::disk('public')->delete('userImages/' . $register->photo5);
                    Storage::disk('public')->put('userImages/' . $imageName, $resizedImage);
            
                    $register->photo5 = $imageName;
                    $register->photo5_approve = "APPROVED";
                }
            }
            $register->save();
            Session::put('lastUpdatedSection', 'managephoto');
            return redirect()->route('admin.edit-profile', ['id' => $register->matri_id])->with('managephoto', 'photo Update Sucessfully');
        }
        if ($request->has('photo6')) {
            $register = Register::findOrFail($id);
            if ($request->hasFile('photo6')) {
               
                $file = $request->file('photo6');
                $imageFileType = $request->photo6->extension();
                $imageFilesize = $request->photo6->getSize();
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

                    Storage::disk('public')->delete('userImages/' . $register->photo6);
                    Storage::disk('public')->put('userImages/' . $imageName, $resizedImage);
        
                    $register->photo6 = $imageName;
                    $register->photo6_approve = "APPROVED";
                }
            }
            $register->save();
            Session::put('lastUpdatedSection', 'managephoto');
            return redirect()->route('admin.edit-profile', ['id' => $register->matri_id])->with('managephoto', 'photo Update Sucessfully');
        }
        if ($request->has('photo7')) {
            $register = Register::findOrFail($id);
            if ($request->hasFile('photo7')) {
               
                $file = $request->file('photo7');
                $imageFileType = $request->photo7->extension();
                $imageFilesize = $request->photo7->getSize();
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

                    Storage::disk('public')->delete('userImages/' . $register->photo7);
                    Storage::disk('public')->put('userImages/' . $imageName, $resizedImage);
            
                    $register->photo7 = $imageName;
                    $register->photo7_approve = "APPROVED";
                }
            }
            $register->save();
            Session::put('lastUpdatedSection', 'managephoto');
            return redirect()->route('admin.edit-profile', ['id' => $register->matri_id])->with('managephoto', 'photo Update Sucessfully');
        }
        if ($request->has('photo8')) {
            $register = Register::findOrFail($id);
            if ($request->hasFile('photo8')) {
               
                $file = $request->file('photo8');
                $imageFileType = $request->photo8->extension();
                $imageFilesize = $request->photo8->getSize();
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

                    Storage::disk('public')->delete('userImages/' . $register->photo8);
                    Storage::disk('public')->put('userImages/' . $imageName, $resizedImage);
        
                    $register->photo8 = $imageName;
                    $register->photo8_approve = "APPROVED";
                }
            }
            $register->save();
            Session::put('lastUpdatedSection', 'managephoto');
            return redirect()->route('admin.edit-profile', ['id' => $register->matri_id])->with('managephoto', 'photo Update Sucessfully');
        }
        if ($request->has('horoscope_img')) {
            $register = Register::findOrFail($id);
            if ($request->hasFile('hor_photo')) {
               
                $file = $request->file('hor_photo');
                $imageFileType = $request->hor_photo->extension();
                $imageFilesize = $request->hor_photo->getSize();
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

                    Storage::disk('public')->delete('userImages/' . $register->hor_photo);
                    Storage::disk('public')->put('userImages/' . $imageName, $resizedImage);
                    $register->hor_photo = $imageName;
                    $register->hor_check = "APPROVED";
                }
            }
            $register->save();
            Session::put('lastUpdatedSection', 'managephoto');
            return redirect()->route('admin.edit-profile', ['id' => $register->matri_id])->with('managephoto', 'photo Update Sucessfully');
        }
        if ($request->has('aadhaar_card')) {
            $register = Register::findOrFail($id);
            if ($request->hasFile('aadhaar_card')) {
               
                $file = $request->file('aadhaar_card');
                $imageFileType = $request->aadhaar_card->extension();
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
                    Storage::disk('public')->put('userImages/' . $imageName, $resizedImage);
                    $register->aadhaar_card = $imageName;
                    $register->aadhaar_card_status = "APPROVED";
                }
            }
            $register->save();
            Session::put('lastUpdatedSection', 'managephoto');
            return redirect()->route('admin.edit-profile', ['id' => $register->matri_id])->with('managephoto', 'photo Update Sucessfully');
        }
        
        if ($request->has('preferenceDetailsUpdate')) {
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

            $part_dosh = collect($request->input('part_dosh'));
            $register->part_dosh = $part_dosh->implode(',');

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
            Session::put('lastUpdatedSection', 'preference');
            return redirect()->route('admin.edit-profile', ['id' => $register->matri_id])->with('preference', 'preference Details Update Sucessfully');
        }
        return redirect()->back();
    }

    public function imageStatus(Request $request,$id)
    {
        $status = Register::where('matri_id',$id)->first();
        if($status == true)
        {
            $register = Register::findOrFail($status->id);
            $register->photo1_approve = "UNAPPROVED";
            $register->save();
        }else{
            $register = Register::findOrFail($id);
            $register->photo1_approve = "APPROVED";
            $register->save();
        }
        return redirect()->back()->with('message','Photo Status Updated Sucessfully.');
    }

    public function userStatus(Request $request,$id)
    {
        try{
            if($request->filter == "active")
            {
                $register = Register::findOrFail($id);
                $register->status = "Active";
                $register->save();
                return redirect()->back()->with('message','Status Updated Sucessfully.');
            }
            if($request->filter == "inactive")
            {
                $register = Register::findOrFail($id);
                $register->status = "Inactive";
                $register->save();
                return redirect()->back()->with('message','Status Updated Sucessfully.');
            }
            if($request->filter == "delete")
            {
                $register = Register::findOrFail($id);
                $register->delete();
                //return redirect()->route('member.list')->with('message','Data Deleted Sucessfully.');
		return redirect()->back()->with('message','Data Deleted Sucessfully.');
            }
        } catch (QueryException $e) {
            return redirect()->back()->with('message', 'An error occurred while deleting the \member.');
        }
    }

    public function ViewProfile(Request $request,$id)
    {
        $fieldsetting = FieldSetting::first();
        $register = Register::where('matri_id',$id)->with('mother_tongue','age_from','age_to','rel','cast','subcast','occ','inc','country','state','citi','hei','doshes','staars','rashi','father_occ','mother_occ','part_from_hei','part_to_hei')->first();
      
        //$gotra = Gotra::where('id',$register->gotra)->select('gotra_name')->first();
	$gotra = $register->gotra;
        //mother tongue
        $part_mtongue = $register->part_mtongue;
        $mother_tongue = explode(",",$register->part_mtongue);
        
        $mtongue = [];
        if($part_mtongue != "")
        {
            if($mother_tongue != "")
            {
                foreach($mother_tongue as $key => $value)
                {
                    $mothertongues = Mothertongue::where('id',$value)->get();
                    if($mothertongues != null)
                    {
                        foreach($mothertongues as $value)
                        {
                            $val = $value->mtongue_name;
                        }
                        $mtongue[] = $val; 
                    }
                }
            }
        }
        
        //part edu
        $part_edu = $register->part_edu;
        $part_education = explode(",",$register->part_edu);
        $edu = [];
        if($part_edu != "")
        {
            if($part_education != "")
            {
                foreach($part_education as $key => $value)
                {
                    $education = EducationDetail::where('id',$value)->get();
                    if($education != null)
                    {
                        foreach($education as $value)
                        {
                            $val = $value->edu_name;
                        }
                        $edu[] = $val; 
                    }
                }
            }
        }

        //part occupation
        $part_occupation = $register->part_occu;
        $part_occu = explode(",",$register->part_occu);
        $occ = [];
        if($part_occupation != "")
        {
            if($part_occu != "")
            {
                foreach($part_occu as $key => $value)
                {
                    $occupations = Occupation::where('id',$value)->get();
                    if($occupations != null)
                    {
                        foreach($occupations as $value)
                        {
                            $val = $value->ocp_name;
                        }
                        $occ[] = $val; 
                    }
                }
            }
        }

        //part income
        $part_inc = $register->part_income;
        $part_income = explode(",",$register->part_income);
        $inc = [];
        if($part_inc != "")
        {
            if($part_income != "")
            {
                foreach($part_income as $key => $value)
                {
                    $incomes = Income::where('id',$value)->get();
                    if($incomes != null)
                    {
                        foreach($incomes as $value)
                        {
                            $val = $value->income;
                        }
                        $inc[] = $val; 
                    }
                }
            }
        }

        //part caste
        $cast = $register->part_caste;
        $part_caste = explode(",",$register->part_caste);
        $caste = [];
        if($cast != "")
        {
            if($part_caste != "")
            {
                foreach($part_caste as $key => $value)
                {
                    $castes = Caste::where('id',$value)->get();
                    if($castes != null)
                    {
                        foreach($castes as $value)
                        {
                            $val = $value->caste_name;
                        }
                        $caste[] = $val; 
                    }
                }
            }
        }

        //part religion
        $rel = $register->part_religion;
        $part_religion = explode(",",$register->part_religion);
        $religion = [];
        if($rel  != "")
        {
            if($part_religion != "")
            {
                foreach($part_religion as $key => $value)
                {
                    $religions = Religion::where('id',$value)->get();
                    if($religions != null)
                    {
                        foreach($religions as $value)
                        {
                            $val = $value->religion_name;
                        }
                        $religion[] = $val; 
                    }
                }
            }
        }

        //part star
        $str = $register->part_star;
        $part_start = explode(",",$register->part_star);
        $star = [];
        if($str  != "")
        {
            if($part_start != "")
            {
                foreach($part_start as $key => $value)
                {
                    $stars = Star::where('id',$value)->get();
                    if($stars != null)
                    {
                        foreach($stars as $value)
                        {
                            $val = $value->star;
                        }
                        $star[] = $val; 
                    }
                }
            }
        }

        //part rasi
        $rassi = $register->part_rasi;
        $part_rasi = explode(",",$register->part_rasi);
        $rasi = [];
        if($rassi  != "")
        {
            if($part_rasi != "")
            {
                foreach($part_rasi as $key => $value)
                {
                    $rashies = Rasi::where('id',$value)->get();
                    if($rashies != null)
                    {
                        foreach($rashies as $value)
                        {
                            $val = $value->rasi;
                        }
                        $rasi[] = $val; 
                    }
                }
            }
        }

        //part country
        $country_living = $register->part_country_living;
        $part_country_living = explode(",",$register->part_country_living);
        $country = [];
        if($country_living  != "")
        {
            if($part_country_living != "")
            {
                foreach($part_country_living as $key => $value)
                {
                    $countries = Country::where('id',$value)->get();
                    if($countries != null)
                    {
                        foreach($countries as $value)
                        {
                            $val = $value->country_name;
                        }
                        $country[] = $val;
                    } 
                }
            }
        }

        //part city
        $citi = $register->part_city;
        $part_city = explode(",",$register->part_city);
        $city = [];
        if($citi  != "")
        {
            if($part_city != "")
            {
                foreach($part_city as $key => $value)
                {
                    $cities = City::where('id',$value)->get();
                    if($cities != null)
                    {
                        foreach($cities as $value)
                        {
                            $val = $value->city_name;
                        }
                        $city[] = $val; 
                    }
                }
            }
        }

        //part state
        $stat = $register->part_state;
        $part_state = explode(",",$register->part_state);
        $state = [];
        if($stat  != "")
        {
            if($part_state != "")
            {
                foreach($part_state as $key => $value)
                {
                    $states = State::where('id',$value)->get();
                    if($states != null)
                    {
                        foreach($states as $value)
                        {
                            $val = $value->state_name;
                        }
                        $state[] = $val; 
                    }
                }
            }
        }

        //part dosh
        $part_manglik = $register->part_manglik;
        $part_dosh = explode(",",$register->part_manglik);
        $dosh = [];
        if($part_manglik  != "")
        {
            if($part_dosh != "")
            {
                foreach($part_dosh as $key => $value)
                {
                    $doshes = Dosh::where('id',$value)->get();
                    if($doshes != null)
                    {
                        foreach($doshes as $value)
                        {
                            $val = $value->dosh;
                        }
                        $dosh[] = $val; 
                    }
                }
            }
        }

        //highest education details
        $edu_details = explode(",",$register->edu_detail);
        $add_edu = "";
        $high_edu = "";
       //dd($edu_details[0]);
       if($register->edu_detail != null)
       {
            if(isset($edu_details[0])){
                if($edu_details[0] != "")
                {

                    $edu_hei = EducationDetail::where('id',$edu_details[0])->first();
                    if($edu_hei != null)
                    {
                        $high_edu = $edu_hei->edu_name;
                    }
                    
                }else{
                    $high_edu = "Not Available";
                }
            }
            if(isset($edu_details[1])){
                if($edu_details[1] != NULL)
                {

                    //additional education details
                    $edu_add = EducationDetail::where('id',$edu_details[1])->first();
                    if($edu_add != null)
                    {
                        $add_edu = $edu_add->edu_name;
                    }
                }else{
                    $add_edu = "Not Available";
                }
            }
       }else{
            $add_edu = "Not Available";
            $high_edu = "Not Available";
        }
       //dd($add_edu);
        
          
        return view('admin.profile.viewprofile',compact('fieldsetting','add_edu','high_edu','city','state','country','dosh','mtongue','edu','register','occ','inc','rasi','star','caste','religion','gotra'));
    }

    
}
