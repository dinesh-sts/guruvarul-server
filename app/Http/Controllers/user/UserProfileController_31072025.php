<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use App\Models\Register;
use App\Models\Country;
use App\Models\Religion;
use App\Models\Caste;
use App\Models\Mothertongue;
use App\Models\Subcast;
use App\Models\EducationDetail;
use App\Models\Occupation;
use App\Models\Income;
use App\Models\SiteConfig;
use Carbon\Carbon;
use App\Models\State;
use App\Models\City;
use App\Models\Height;
use App\Models\Expressinterest;
use App\Models\BlockProfile;
use App\Models\Dosh;
use App\Models\Rasi;
use App\Models\Star;
use App\Models\Age;
use App\Models\ContactView;
use App\Models\Payment;
use App\Models\Shortlist;
use App\Models\Notification;
use App\Models\CountryCode;
use App\Models\Ignore;
use App\Models\DeleteProfile;
use App\Models\FieldSetting;
use App\Models\Gotra;
use App\Models\ProfileBy;
use App\Models\WhoViewedMyProfiles;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;

class UserProfileController extends Controller
{
    public function deleteProfile()
    {
        return view('user.deleteProfile');
    }
 
    public function deleteProfileStore(Request $request)
    {
        $id = Auth::guard('user')->user();
        $data = new DeleteProfile();
        $data->matri_id = $id->matri_id;
        $data->reason = $request->reason;
        $data->save();
        return redirect()->route('user.dashboard')->with('message','Profile delete request sent successfully.');
    }

    public function photoPrivacy(Request $request)
    {
        $id = Auth::guard('user')->user()->id;
        $photoprivacy = Register::where('id',$id)->first(); 
        return view('user.photoPrivacy',compact('photoprivacy'));
    }

    public function photoPrivacyStore(Request $request)
    {
        $id = Auth::guard('user')->user()->id;
        $data = Register::findOrFail($id);
        $data->photo_setting = $request->photo_setting;
        $data->save();
        return redirect()->route('user.photoPrivacy')->with('message','Photo privacy updated.');
    }

    public function contactPrivacy(Request $request)
    {
        $id = Auth::guard('user')->user()->id;
        $contactprivacy = Register::where('id',$id)->first(); 
        return view('user.contactPrivacy',compact('contactprivacy'));
    }

    public function contactPrivacyStore(Request $request)
    {
        $id = Auth::guard('user')->user()->id;
        $data = Register::findOrFail($id);
        $data->contact_view_security = $request->contact_view_security;
        $data->save();
        return redirect()->route('user.contactPrivacy')->with('message','Contact privacy updated.');
    }

    public function profileEdit(Request $request)
    {
        $id = Auth::guard('user')->user()->id;
        $siteconfig = SiteConfig::first();
        $states = State::where('status',"APPROVED")->get();
        $cities = City::where('status',"APPROVED")->get();
        $castes = Caste::where('status',"APPROVED")->get();
        $profiles = ProfileBy::where('status',"APPROVED")->get();
        $countries = Country::where('status',"APPROVED")->get();
        $religions = Religion::where('status',"APPROVED")->get();
        $country_code = CountryCode::all();
        $subcastes = Subcast::where('status',"APPROVED")->get();
        $gotras = Gotra::where('status',"APPROVED")->get();
        $mothertongues = Mothertongue::where('status',"APPROVED")->get();
        $edu_details = EducationDetail::where('status',"APPROVED")->get();
        $occupations = Occupation::where('status',"APPROVED")->get();
        $incomes = Income::where('status',"APPROVED")->get();
        $heights = Height::all();
        $doshes = Dosh::where('status',"APPROVED")->get();
        $rashies = Rasi::where('status',"APPROVED")->get();
        $stars = Star::where('status',"APPROVED")->get();
        $ages = Age::all();
        $fieldsetting = FieldSetting::first();
        $register = Register::where('id',$id)->first();
    
        return view('user.editProfile',compact('siteconfig','fieldsetting','cities','states','castes','country_code','ages','doshes','rashies','stars','heights','incomes','occupations','edu_details','register','profiles','countries','religions','mothertongues','subcastes','gotras'));
    }

    //Express Intrest 
    public function expressInterest(Request $request,$tab)
    {
        $log_inid = Auth::guard('user')->user();
        $siteconfig = SiteConfig::first();
        $sentInterests = [];
        $receiverpaginator = [];
        $sentpaginator = [];
      //  $expressInterestssend = Expressinterest::where('ei_sender', $log_inid->matri_id)->where('trash_sender', '!=' , "Yes")->orWhereNull('trash_sender')->orderBy('created_at', 'desc')->get();
        $expressInterestssend = Expressinterest::where('ei_sender', $log_inid->matri_id)->whereNot('ei_receiver',$log_inid->matri_id)
            ->where(function($query) {
                $query->where('trash_sender', '!=', 'Yes')
                    ->orWhereNull('trash_sender');
            })
            ->orderBy('created_at', 'desc')
            ->get();
        foreach ($expressInterestssend as $data) {
            $registerData = Register::where('matri_id', $data->ei_receiver)->whereNot('gender',$log_inid->gender)->first(); 
            
            $sentInterests[] = [
                'expressInterest' => $data, 
                'registerData' => $registerData, 
            ];
        }
       
        $receiverInterests = [];

        $expressInterests = Expressinterest::where('ei_receiver', $log_inid->matri_id)->whereNot('ei_sender',$log_inid->matri_id)
        ->where(function($query) {
            $query->where('trash_receiver', '!=', 'Yes')
                ->orWhereNull('trash_receiver');
        })
        ->orderBy('created_at', 'desc')
        ->get();
        
        foreach ($expressInterests as $data) {
            $registerData = Register::where('matri_id', $data->ei_sender)->whereNot('gender',$log_inid->gender)->first(); 
            
            $receiverInterests[] = [
                'expressInterest' => $data, 
                'registerData' => $registerData, 
            ];
        }

            $page = request()->get('page', 1);
            $perPage = 5; 

            $offset = ($page * $perPage) - $perPage;
          
        if(count($receiverInterests) != 0 || count($sentInterests) != 0)
        {
            $currentPageItemssent = array_slice($sentInterests, $offset, $perPage);
            $currentPageItemsrecive = array_slice($receiverInterests, $offset, $perPage);
            if(isset($receiverInterests))
            {
                $sentpaginator = new LengthAwarePaginator(
                    $currentPageItemssent,
                    count($sentInterests),
                    $perPage,
                    $page,
                    ['path' => request()->url(), 'query' => request()->query()]
                );
            }else{
                $sentpaginator = [];
            }
            
            if(isset($receiverInterests))
            {
                $receiverpaginator = new LengthAwarePaginator(
                    $currentPageItemsrecive,
                    count($receiverInterests),
                    $perPage,
                    $page,
                    ['path' => request()->url(), 'query' => request()->query()]
                );
            }else{
                $receiverpaginator = [];
            }
           

            return view('user.expressInterest',compact('sentpaginator','receiverpaginator','tab','siteconfig'));
        }
        return view('user.expressInterest',compact('tab','siteconfig','sentpaginator','receiverpaginator',));
    }

    public function expressInterestAccept(Request $request)
    {
        $id = $request->id;
        $data = Expressinterest::findOrFail($id);
        $data->receiver_response = "Accept";
        $data->save();

        return response()->json(['message' => 'Express interest accepted']);
    }

    public function expressinterestreject(Request $request)
    {
        $id = $request->id;
        $data = Expressinterest::findOrFail($id);
        $data->receiver_response = "Reject";
        $data->trash_receiver = "Yes";
        $data->save();

        return response()->json(['message' => 'Express interest rejected']);
    }
    public function expressInterestDelete(Request $request)
    {
        $id = $request->id;
        $data = Expressinterest::findOrFail($id);
        $data->delete();

        return response()->json(['message' => 'Express interest deleted']);
    }

    public function addshortlist(Request $request)
    {
        $id = Auth::guard('user')->user()->matri_id;
        
        $registerId = $request->input('register_id');
        $data = new Shortlist();
        $data->from_id = $id;
        $data->to_id = $registerId;
        $data->add_date = Carbon::now();
        $data->save();
        
        if($data)
        {
            $notification = new Notification();
            $notification->sender_id  = $id;
            $notification->receiver_id  = $data->to_id;
            $notification->notification_type  = "Shortlist";
            $notification->notification  = "Your profile is shortlisted by";
            $notification->seen  = 0;
            $notification->date = Carbon::now();
            $notification->save();
        }
        return response()->json();
    }

    public function removeshortlist(Request $request)
    {
        $id = Auth::guard('user')->user()->matri_id;
        
        $registerId = $request->input('register_id');
        Shortlist::where('from_id', $id)->where('to_id',$registerId)->delete();

        return response()->json(['message' => 'Profile removed from shortlist.']);
    }

    public function addinterest(Request $request)
    {   
        $siteconfig = SiteConfig::first();
      
        $id = Auth::guard('user')->user()->matri_id;
        if($siteconfig->interest_setting == "send_to_paid")
        {    
            if(Auth::guard('user')->user()->status == "Paid")
            {
                $registerId = $request->input('register_id');
                $data = new Expressinterest();
                $data->ei_sender = $id;
                $data->ei_receiver = $registerId;
                $data->receiver_response = "Pending";
                $data->ei_sent_date = Carbon::now();
                $data->save();
                if($data)
                {
                    $notification = new Notification();
                    $notification->sender_id  = $id;
                    $notification->receiver_id  = $registerId;
                    $notification->notification_type  = "Express Interest";
                    $notification->notification  = "Express intrest received from";
                    $notification->seen = 0;
                    $notification->date = Carbon::now();
                    $notification->save();
                }
                return response()->json(['message' => 'Express interest sent.']);
            }else{
                return response()->json(['message' => 'Please upgrade your membership.']);
            }
        }else{
            $registerId = $request->input('register_id');
            $data = new Expressinterest();
            $data->ei_sender = $id;
            $data->ei_receiver = $registerId;
            $data->receiver_response = "Pending";
            $data->ei_sent_date = Carbon::now();
            $data->save();
            if($data)
            {
                $notification = new Notification();
                $notification->sender_id  = $id;
                $notification->receiver_id  = $registerId;
                $notification->notification_type  = "Express Interest";
                $notification->notification  = "Express interest received from.";
                $notification->seen  = 0;
                $notification->date = Carbon::now();
                $notification->save();
            }
            return response()->json(['message' => 'Express interest sent by']);
        }
    }
    public function removeInterest(Request $request)
    {
        $id = Auth::guard('user')->user()->matri_id;
        $siteconfig = SiteConfig::first();
        $registerId = $request->input('register_id');
        if($siteconfig->interest_setting == "send_to_paid")
        {    
            if(Auth::guard('user')->user()->status == "Paid")
            {
                Expressinterest::where('ei_sender', $id)->where('ei_receiver',$registerId)->delete();
                return response()->json(['message' => 'Express interest removed.']);
            }else{
                return response()->json(['message' => 'Please upgrade your membership.']);
            }
        }else{
            Expressinterest::where('ei_sender', $id)->where('ei_receiver',$registerId)->delete();
            return response()->json(['message' => 'Express interest removed.']);
        }
    }

    public function ignore(Request $request)
    {
        $id = Auth::guard('user')->user()->matri_id;
      
        $registerId = $request->input('register_id');
        $data = new Ignore();
        $data->ignore_by = $id;
        $data->ignore_to = $registerId;
        $data->ignore_date = Carbon::now();
        $data->save();
        return response()->json(['message' => 'Profile added in ignored list.']);
    }
    public function unignore(Request $request)
    {
        $id = Auth::guard('user')->user()->matri_id;
        
        $registerId = $request->input('register_id');
        Ignore::where('ignore_by', $id)->where('ignore_to',$registerId)->delete();

        return response()->json(['message' => 'Profile removed from ignored list.']);
    }

    public function block(Request $request,$id)
    {
        $auth_id = Auth::guard('user')->user()->matri_id;
        $data = new BlockProfile();
        $data->block_by = $auth_id;
        $data->block_to = $id;
        $data->block_date = Carbon::now();
        $data->save();
        return redirect()->route('user.dashboard')->with('message', 'Profile blocked successfully.');
    }
    public function Unblock(Request $request,$id)
    {
        $auth_id = Auth::guard('user')->user()->matri_id;
        
        $data = BlockProfile::where('block_to',$id)->where('block_by',$auth_id)->delete();

        return redirect()->back()->with('message', 'Profile unblocked successfully.');
    }

    public function profileupdate(Request $request,$id)
    {
        $register = Register::findOrFail($id);

        if ($request->has('personalDetailsUpdate')) {
            $register->profileby = $request->profileby;
            $register->firstname = $request->firstname;
            $register->lastname = $request->lastname;
            $register->m_status = $request->m_status;
            $register->tot_children = $request->tot_children;
            $register->status_children = $request->status_children;
            $register->m_tongue = $request->m_tongue;
        // }
        // if ($request->has('Religiondetails')) {
            $register->religion = $request->religion;
            $register->caste = $request->caste;
            $register->subcaste = $request->subcaste;
            $register->gotra = $request->gotra;
            $register->will_to_mary_caste =  $request->will_to_mary_caste;
            $register->church_name = $request->church_name;
            $register->denomination = $request->denomination;
            $register->baptism = $request->baptism;
            $register->born_again = $request->born_again;
        // }
            // if ($request->has('edu_details')) {
            $edu_details = collect($request->input('edu_detail'));
            $register->edu_detail = $edu_details->implode(',');
            $register->emp_in = $request->emp_in;
            $register->occupation = $request->occupation;
            $register->company_name = $request->company_name;
            $register->designation = $request->designation;
            $register->income = $request->income;
            // }
            // if ($request->has('family_details')) {
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
            // }
            // if ($request->has('location_details')) {
            $register->country_id = $request->country_id;
            $register->state_id = $request->state_id;
            $register->city = $request->city;
            $register->address = $request->address;
            // }
            // if ($request->has('Habits')) {
            $register->diet = $request->diet;
            $register->smoke = $request->smoke;
            $register->drink = $request->drink;
            // }
            // if ($request->has('Physical')) {
            $register->height = $request->height;
            $register->weight = $request->weight;
            $register->bodytype = $request->bodytype;
            $register->complexion = $request->complexion;
            $register->physicalStatus = $request->physical_status;
            $register->b_group = $request->b_group;
            // }
            // if ($request->has('About')) {
            $register->profile_text = $request->profile_text;
            // }
            // if ($request->has('Horoscope')) {
            $register->dosh = $request->dosh;
            $register->manglik = $request->manglik;
            $register->moonsign = $request->moonsign;
            $register->star = $request->star;
            $register->birthtime = $request->birthtime;
            $register->birthplace = $request->birthplace;
            // }
        }
        if ($request->has('photo1')) {
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
                    $register->photo1_approve = "PENDING";
                }
            }
        }
        if ($request->has('horoscope_img')) {
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
                    $register->hor_check = "PENDING";
                }
            }
        }
        
            if ($request->has('preferenceDetailsUpdate')) {
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

            // }
            // if ($request->has('part_habit_pre')) {
                $part_diet = collect($request->input('part_diet'));
                $register->part_diet = $part_diet->implode(',');

                $part_smoke = collect($request->input('part_smoke'));
                $register->part_smoke = $part_smoke->implode(',');

                $part_drink = collect($request->input('part_drink'));
                $register->part_drink = $part_drink->implode(',');
            // }

            // if ($request->has('part_edu_pre')) {
                $part_edu = collect($request->input('part_edu'));
                $register->part_edu = $part_edu->implode(',');

                $part_occu = collect($request->input('part_occu'));
                $register->part_occu = $part_occu->implode(',');

                $part_emp_in = collect($request->input('part_emp_in'));
                $register->part_emp_in = $part_emp_in->implode(',');

                $part_income = collect($request->input('part_income'));
                $register->part_income = $part_income->implode(',');
            // }
        
            // if ($request->has('part_religion_pre')) {
              //  dd($request->all());
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
            // }
        
            // if ($request->has('part_location_pre')) {
                $part_country_living = collect($request->input('part_country_living'));
                $register->part_country_living = $part_country_living->implode(',');

                $part_state = collect($request->input('part_state'));
                $register->part_state = $part_state->implode(',');

                $part_city = collect($request->input('part_city'));
                $register->part_city = $part_city->implode(',');
            // }

            // if ($request->has('part_pre')) {
                $register->part_expect = $request->part_expect;
            }

        $register->save();
        return redirect()->back()->with('message', 'Data Update Sucessfully');
    }
    
    public function memberprofile(Request $request,$id)
    {   
        $fieldsetting = FieldSetting::first();
        $profileviewsetting = SiteConfig::first();
        $log_inid = Auth::guard('user')->user();
        
        $blockuser = BlockProfile::where('block_by', $log_inid->matri_id)->where('block_to',$id)->first();
        $expressInterests = Expressinterest::where('ei_sender',$log_inid->matri_id)->where('ei_receiver', $id)->first();
            if($blockuser != null)
            {
                return redirect()->route('user.dashboard');
            }
          
            if($profileviewsetting->profile_view_setting == "visible_to_paid")
            {
                if($log_inid->status != "Paid")
                {
                    return redirect()->back()->with('message','Please upgrade your membership plan');
                }
            }
           
            $register = Register::whereNotIn('status',['Inactive','Suspended'])->where('matri_id',$id)->with('mother_tongue','age_from','age_to','rel','cast','subcast','occ','inc','country','state','citi','hei','doshes','staars','rashi','father_occ','mother_occ','part_from_hei','part_to_hei')->first();
            $percentage = 0;
            if($register != null)
            {
                $gotra = Gotra::where('id',$register->gotra)->select('gotra_name')->first();
                if($log_inid->matri_id != $id)
                {
                    $viewedprofiles = WhoViewedMyProfiles::where('my_id',$log_inid->matri_id)->where('viewed_member_id',$id)->first();
                    if($viewedprofiles != "")
                    {
                        $data = WhoViewedMyProfiles::findOrFail($viewedprofiles->id);
                        $data->updated_at = Carbon::now();
                        $data->save();
                    }else{
                        $data = new WhoViewedMyProfiles();
                        $data->my_id = $log_inid->matri_id;
                        $data->viewed_member_id = $id;
                        $data->viewed_date = Carbon::now();
                        $data->save();
                    }
                }
                //mother tongue
                $part_mtongue = isset($register->part_mtongue)?$register->part_mtongue:"";
                $mother_tongue = isset($register->part_mtongue)?explode(",",$register->part_mtongue):"";
                $logInidMStatus = $log_inid->m_tongue; 
                $isMatchmother_tongue = 0;
                if($logInidMStatus != null && $mother_tongue != "")
                {
                    $isMatchm_tongue = in_array($logInidMStatus, $mother_tongue);
                    if ($isMatchm_tongue) {
                        $isMatchmother_tongue = 1;
                        $percentage =  $percentage + 1;
                    } 
                }
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
                $part_edu = isset($register->part_edu)?$register->part_edu:"";
               
                $part_education = isset($register->part_edu)?explode(",",$register->part_edu):"";
              
                $isMatchedudetail = 0;
                if($log_inid->edu_detail != Null && $part_education != "")
                {
                    $logInidedu = explode(",",$log_inid->edu_detail); 
                   
                    if($logInidedu != null)
                    {
                        $isMatchedu_detail = in_array($logInidedu[0], $part_education);
                        if ($isMatchedu_detail) {
                            $isMatchedudetail = 1;
                        $percentage =  $percentage + 1;
                        } 
                    }
                }
                
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
                $part_occupation = isset($register->part_occu)?$register->part_occu:"";
                $part_occu = isset($register->part_occu)?explode(",",$register->part_occu):"";
                $logInidoccu = $log_inid->occupation; 
                $isMatchoccu = 0;
                if($logInidoccu != null && $part_occu != "")
                {
                    $isMatchpart_occu = in_array($logInidoccu, $part_occu);
                    if ($isMatchpart_occu) {
                        $isMatchoccu = 1;
                        $percentage =  $percentage + 1;
                    } 
                }
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
                $part_inc = isset($register->part_occu)?$register->part_income:"";
                $part_income = isset($register->part_occu)?explode(",",$register->part_income):"";
                $logInidincome = $log_inid->income; 
                $isMatch_income = 0;
                if($logInidincome != null && $part_income != "")
                {
                    $isMatchincome = in_array($logInidincome, $part_income);
                    if ($isMatchincome) {
                        $isMatch_income = 1;
                    $percentage =  $percentage + 1;
                    } 
                }
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
                $cast = isset($register->part_caste)?$register->part_caste:"";
                $part_caste = isset($register->part_caste)?explode(",",$register->part_caste):"";
                $logInidcaste = $log_inid->caste; 
                $isMatch_caste = 0;
                if($logInidcaste != null && $part_caste != "")
                {
                    $isMatchcaste = in_array($logInidcaste, $part_caste);
                    if ($isMatchcaste) {
                        $isMatch_caste = 1;
                        $percentage =  $percentage + 1;
                    } 
                }
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
                $rel = isset($register->part_religion)?$register->part_religion:"";
                $part_religion = isset($register->part_religion)?explode(",",$register->part_religion):"";
                $logInidreligion = $log_inid->religion; 
                $isMatch_religion = 0;
                if($logInidreligion != null && $part_religion != "")
                {
                    $isMatchreligion = in_array($logInidreligion, $part_religion);
                    if ($isMatchreligion) {
                        $isMatch_religion = 1;
                        $percentage =  $percentage + 1;
                    }
                }
                
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
                $str = isset($register->part_star)?$register->part_star:"";
                $part_start = isset($register->part_star)?explode(",",$register->part_star):"";
                $logInidstar = $log_inid->star; 

                $isMatchstar = 0;
                if($logInidstar != null && $part_start != "")
                {
                    $isMatchstar = in_array($logInidstar, $part_start);
                    if ($isMatchstar) {
                        $isMatch_religion = 1;
                        $percentage =  $percentage + 1;
                    }
                }

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
                $rassi = isset($register->part_rasi)?$register->part_rasi:"";
                $part_rasi = isset($register->part_rasi)?explode(",",$register->part_rasi):"";
                $logInidmoonsign = $log_inid->moonsign; 
                $isMatch_moonsign = 0;
                if($logInidstar != null && $part_rasi != "")
                {
                    $isMatchmoonsign = in_array($logInidmoonsign, $part_rasi);
                    if ($isMatchmoonsign) {
                        $isMatch_moonsign = 1;
                        $percentage =  $percentage + 1;
                    }
                }
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
                $country_living = isset($register->part_country_living)?$register->part_country_living:"";
                $part_country_living = isset($register->part_country_living)?explode(",",$register->part_country_living):"";
                $logInidcountry = $log_inid->country_id; 
                $isMatch_country = 0;
                if($logInidcountry != null && $part_country_living != "")
                {
                    $isMatchcountry_id = in_array($logInidcountry, $part_country_living);
                    if ($isMatchcountry_id) {
                        $isMatch_country = 1;
                        $percentage =  $percentage + 1;
                    }
                }
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
                $citi = isset($register->part_city)?$register->part_city:"";
                $part_city = isset($register->part_city)?explode(",",$register->part_city):"";
                $logInidcity = $log_inid->city; 
                $isMatch_city = 0;
                if($logInidcity != null && $part_city != "")
                {
                    $isMatchcity = in_array($logInidcity, $part_city);
                    if ($isMatchcity) {
                        $isMatch_city = 1;
                        $percentage =  $percentage + 1;
                    }
                }
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
                $stat = isset($register->part_state)?$register->part_state:"";
                $part_state = isset($register->part_state)?explode(",",$register->part_state):"";
                $logInidstate = $log_inid->state_id; 
                $isMatch_state = 0;
                if($logInidstate != null && $part_state != "")
                {
                    $isMatchstate_id = in_array($logInidstate, $part_state);
                    if ($isMatchstate_id) {
                        $isMatch_state = 1;
                        $percentage =  $percentage + 1;
                    }
                }
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
                //have a dosh 
                $part_dosh = isset($register->part_dosh)?$register->part_dosh:"";
                $Matchdosh = $log_inid->dosh;
                $isMatch_dosh = 0;
                if($Matchdosh != null && $part_dosh != "")
                {
                    if ($Matchdosh == $part_dosh) {
                        $isMatch_dosh = 1;
                        $percentage =  $percentage + 1;
                    }
                }
                //part dosh type
                
                $manglik = isset($register->part_manglik)?$register->part_manglik:"";
                $part_manglik = isset($register->part_manglik)?explode(",",$register->part_manglik):"";
                $logInidmanglik = $log_inid->manglik; 
                $isMatch_manglik = 0;
                if($logInidmanglik != null && $part_manglik != "")
                {
                    $isMatchmanglik = in_array($logInidmanglik, $part_manglik);
                    if ($isMatchmanglik) {
                        $isMatch_manglik = 1;
                        $percentage =  $percentage + 1;
                    }
                }

                $dosh = [];
                if($manglik  != "")
                {
                    if($part_manglik != "")
                    {
                        foreach($part_manglik as $key => $value)
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
                $edu_details = isset($register->edu_detail)?explode(",",$register->edu_detail):"";
                $add_edu = "";
                $high_edu = "";
                
                if($edu_details != null)
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
                $matri_id = Auth::guard('user')->user()->matri_id;

                $shortlist = Shortlist::where('from_id',$matri_id)->where('to_id',$register->matri_id)->first();
                if($shortlist != "")
                {
                    $shortstatus = 1;
                }else{
                    $shortstatus = 0;
                }
                $intrestdata = Expressinterest::where('ei_sender',$matri_id)->where('ei_receiver',$register->matri_id)->first();
                if($intrestdata != "")
                {
                    $intrest = 1;
                }else{
                    $intrest = 0;
                }
                //Basic Preference
                $lookingForArray = explode(',', $register->looking_for); 
                $logInidMStatus = $log_inid->m_status;
                $ismatchm_status = 0;
                if($logInidMStatus != null)
                {
                    $ismatchmstatus = in_array($logInidMStatus, $lookingForArray);
                    if ($ismatchmstatus) {
                        $ismatchm_status = 1;
                        $percentage =  $percentage + 1;
                    }
                }
                $physical = explode(',', $register->part_physical); 
                $logInidpStatus = $log_inid->physicalStatus;
                $isMatch_physical = 0;
                if($logInidpStatus != null)
                {
                    $isMatchphysical = in_array($logInidpStatus, $physical);
                    if ($isMatchphysical) {
                        $isMatch_physical = 1;
                        $percentage =  $percentage + 1;
                    }
                }
                $part_complexation = explode(',', $register->part_complexation); 
                $logInidcomplexion = $log_inid->complexion;
                $isMatch_complexion = 0;
                if($logInidcomplexion != null)
                {
                    $isMatchcomplexion = in_array($logInidcomplexion, $part_complexation);
                    if ($isMatchcomplexion) {
                        $isMatch_complexion = 1;
                        $percentage =  $percentage + 1;
                    }
                }
                $part_bodytype = explode(',', $register->part_bodytype); 
                $logInidbodytype = $log_inid->bodytype;
                $isMatch_bodytype = 0;
                if($logInidbodytype != null)
                {
                    $isMatchbodytype = in_array($logInidbodytype, $part_bodytype);
                    if ($isMatchbodytype) {
                        $isMatch_bodytype = 1;
                        $percentage =  $percentage + 1;
                    }
                }

                $part_diet = explode(',', $register->part_diet); 
                $logIniddiet = $log_inid->diet;
                $isMatch_diet = 0;
                if($logIniddiet != null)
                {
                    $isMatchdiet = in_array($logIniddiet, $part_diet);
                    if ($isMatchdiet) {
                        $isMatch_diet = 1;
                        $percentage =  $percentage + 1;
                    }
                }

                $part_smoke = explode(',', $register->part_smoke); 
                $logInidsmoke = $log_inid->smoke;
                $isMatch_smoke = 0;
                if($logInidsmoke != null)
                {
                    $isMatchsmoke = in_array($logInidsmoke, $part_smoke);
                    if ($isMatchsmoke) {
                        $isMatch_smoke = 1;
                        $percentage =  $percentage + 1;
                    }
                }

                $part_drink = explode(',', $register->part_drink); 
                $logIniddrink = $log_inid->drink;
                $isMatch_drink = 0;
                if($logIniddrink != null)
                {
                    $isMatchdrink = in_array($logIniddrink, $part_drink);
                    if ($isMatchdrink) {
                        $isMatch_drink = 1;
                        $percentage =  $percentage + 1;   
                    }
                }

                $part_emp_in = explode(',', $register->part_emp_in); 
                $logInidemp_in = $log_inid->emp_in;
                $isMatch_emp_in = 0;
                if($logInidemp_in != null)
                {
                    $isMatchemp_in = in_array($logInidemp_in, $part_emp_in);
                    if ($isMatchemp_in) {
                        $isMatch_emp_in = 1;
                        $percentage =  $percentage + 1;
                    }
                }
                
                //get age percentage
                $isMatchage= 0;
                if($register->age_from != "" && $register->age_to != "")
                {
                    $from = Carbon::parse($log_inid->birthdate);
                    $to = Carbon::now();
                    $age =$from->diff($to)->y;
                    $a = $age; 
                    $rangeStart = $register->age_from->age;
                    $rangeEnd = $register->age_to->age;
                    if ($a >= $rangeStart && $a <= $rangeEnd) {
                        $isMatchage = 1;
                        $percentage =  $percentage + 1;
                    }
                }
                $isMatchheight = 0;
                if($register->part_height_to !=  "")
                {
                    $a = $log_inid->height;
                    $rangeStart = $register->part_height;
                    $rangeEnd = $register->part_height_to;
                    if ($a >= $rangeStart && $a <= $rangeEnd) {
                        $isMatchheight = 1;
                        $percentage =  $percentage + 1;
                    }
                }
                //get percentage for check match profile
                $a = $percentage * 100;
                $b = $a /23; 
                $number = $b;
                $finalmatchpercentage = round($number, 0);

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

            return view('user.memberProfile',compact('fieldsetting','expressInterests','isMatch_dosh','isMatch_manglik','isMatch_state','isMatch_city','isMatch_country','isMatch_moonsign','isMatchstar','isMatch_religion','isMatch_caste','isMatch_income','isMatchoccu','isMatchedudetail','isMatchmother_tongue','ismatchm_status','isMatch_physical','isMatch_complexion','isMatch_bodytype','isMatch_diet','isMatch_smoke','isMatch_drink','isMatch_emp_in','isMatchage','isMatchheight','add_edu','high_edu','city','state','country','dosh','mtongue','edu','register','occ','inc','rasi','star','caste','religion','shortstatus','intrest','intrestdata','finalmatchpercentage','profileviewsetting','gotra'));
            }
          
            return redirect()->back();
       
    }

    public function managePhotos(Request $request)
    {
        $id = Auth::guard('user')->user()->id;
        $register = Register::where('id',$id)->first();
        return view('user.managePhotos',compact('register'));
    }

    public function manageHoroscopePhoto(Request $request)
    {
        $id = Auth::guard('user')->user()->id;
        $register = Register::where('id',$id)->first();
        return view('user.horoscopePhoto',compact('register'));
    }
    
    public function manageDocumentPhoto(Request $request)
    {
        $id = Auth::guard('user')->user()->id;
        $register = Register::where('id',$id)->first();
        return view('user.documentPhoto',compact('register'));
    }

    public function managePhotoUpdate(Request $request,$id)
    {
        $register = Register::findOrFail($id);
        if ($request->has('photo1')) {
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
                    $register->photo1_approve = "PENDING";
                }
            }
        }
        if ($request->has('photo2')) {
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
                    $register->photo2_approve = "PENDING";
                }
            }
        }
        if ($request->has('photo3')) {
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
                    $register->photo3_approve = "PENDING";
                }
            }
        }
        if ($request->has('photo4')) {
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
                    $register->photo4_approve = "PENDING";
                }
            }
        }
        if ($request->has('photo5')) {
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
                    $register->photo5_approve = "PENDING";
                }
            }
        }
        if ($request->has('photo6')) {
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
                    $register->photo6_approve = "PENDING";
                }
            }
        }
        if ($request->has('photo7')) {
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
                    $register->photo7_approve = "PENDING";
                }
            }
        }
        if ($request->has('photo8')) {
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
                    $register->photo8_approve = "PENDING";
                }
            }
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
                    $register->hor_check = "PENDING";
                }
            }
        }
        if ($request->has('aadhaar_card')) {
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
                    $register->aadhaar_card_status = "PENDING";
                }
            }
        }
        $register->save();
    
        return redirect()->back()->with('message', 'Photo updated successfully.It will reflect to other users once approved');
    }

    public function profileimage(Request $request)
    {  
        $id = Auth::guard('user')->user()->id;
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
        return redirect()->back()->with('message', 'Photo deleted successfully.');
    }

    public function profilestate(Request $request)
    {  
        if($request->country_id == null)
        {
            $register = Register::where('id',$request->modalId)->first();
            $data['states'] = State::where('country_code',$register->country_id)->get();
            return response()->json($data);
        }else{
            $data['states'] = State::where("country_code", $request->country_id)
            ->get();
            return response()->json($data);
        }   
    }

    public function profilecity(Request $request)
    { 
        if($request->state_id == null)
        {
            $register = Register::where('id',$request->modalId)->first();
            $data['cities'] = City::where('state_code',$register->state_id)->get();
            return response()->json($data);
        }else{
            $data['cities'] = City::where("state_code", $request->state_id)
            ->get();
            return response()->json($data);
        }
    }

    public function profilecaste(Request $request)
    {  
        if($request->religion_id == null)
        {
            $register = Register::where('id',$request->modalId)->first();
            $data['caste'] = Caste::where('religion_id',$register->religion)->where('status','APPROVED')->get();
            return response()->json($data);
        }else{
            $data['caste'] = Caste::where("religion_id", $request->religion_id)->where('status','APPROVED')->
            get();
            return response()->json($data);
        }
    }

    public function profilepartcaste(Request $request)
    {   
      
        if($request->modalId != null)
        {
            $register = Register::where('id',$request->modalId)->first();
            $casteIds = explode(',', $register->part_religion);
           
            $data['partcastie'] = Caste::whereIn('religion_id', $casteIds)->where('status','APPROVED')->get();
            return response()->json($data);
        }else{
            $casteIds = $request->input('part_religion_id');
         
            if($casteIds != null)
            {
                $data['partcastie'] = Caste::whereIn('religion_id', $casteIds)->where('status','APPROVED')->get();
              
            }else{
                $data['partcastie'] = "";
            }
            return response()->json($data);
        }
    }
    public function profilepartstate(Request $request)
    {   
        if($request->modalId != null)
        {
            $register = Register::where('id',$request->modalId)->first();
            $countryIds = explode(',', $register->part_country_living);
            $data['partstates'] = State::whereIn('country_code', $countryIds)->get();
           
            return response()->json($data);
        }else{
            $countryIds = $request->input('partcountryIds');
            if($countryIds != null)
            {
                $data['partstates'] = State::whereIn('country_code', $countryIds)->get();
            }else{
                $data['partstates'] = "";
            }
            return response()->json($data);
        }
    }

    public function profilepartcity(Request $request)
    {   
        if($request->modalId != null)
        {
            $register = Register::where('id',$request->modalId)->first();
            $stateIds = explode(',', $register->part_state);
        
            $data['partcities'] = City::whereIn('state_code', $stateIds)->get();
            //dd($data);
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
    public function contactdetailsshow(Request $request)
    {
        $id = Auth::guard('user')->user();
        $payment = Payment::where('pmatri_id',$id->matri_id)->OrderBy('created_at', 'desc')->first();
        $contactview = ContactView::where('my_id',$request->matriId)->where('viewed_mem_id',$id->matri_id)->first();
        $r_cnt = $payment->r_cnt + 1;
        if($contactview == null)
        {
            $contact = new ContactView();
            $contact->my_id = $request->matriId;
            $contact->viewed_mem_id = $id->matri_id;
            $contact->viewed_date = Carbon::now();
            $contact->save();
            if($contact)
            {
                $data = Payment::findOrFail($payment->id);
                $data->r_cnt = $r_cnt;
                $data->save();
            }
        }
        return response()->json();
    }
   
}
