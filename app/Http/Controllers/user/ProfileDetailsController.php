<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;

use App\Models\Shortlist;
use App\Models\Register;
use App\Models\BlockProfile;
use App\Models\ContactView;
use App\Models\Ignore;
use App\Models\SiteConfig;
use Illuminate\Support\Carbon;
use App\Models\Who_viewed_my_profiles;
use App\Models\WhoViewedMyProfiles;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;


class ProfileDetailsController extends Controller
{
    public function shortListedProfiles()
    {
        $shortlists = [];
        $log_inid = Auth::guard('user')->user();
        $siteconfig = SiteConfig::first();
        $ignore = Ignore::where('ignore_by', $log_inid->matri_id)->pluck('ignore_to')->toArray();
        $blockuser =  BlockProfile::where('block_by', $log_inid->matri_id)->pluck('block_to')->toArray();
        $shortlistdata = [];
        $Shortlist = Shortlist::whereNot('to_id',$log_inid->matri_id)->whereNotIn('to_id',$ignore)->whereNotIn('to_id',$blockuser)->where('from_id',$log_inid->matri_id)->orderBy('created_at', 'desc')->get();
            foreach ($Shortlist as $data) {
                $register = Register::whereNotIn('status',['Inactive','Suspended'])->whereNot('gender',$log_inid->gender)->where('matri_id',$data->to_id)->with('mother_tongue','rel','cast','occ','country','citi')->first();
                if($register != null)
                {
                    $shortlistdata[] = [
                        'data' =>$register,
                    ];
                }
            }
            if(count($shortlistdata))
            {
                $page = request()->get('page', 1);
                $perPage = 5; 
        
                $offset = ($page * $perPage) - $perPage;

                if(count($shortlistdata) != 0)
                {
                    $currentPageItems = array_slice($shortlistdata, $offset, $perPage);
                }
                    
                $shortlists = new LengthAwarePaginator(
                    $currentPageItems,
                    count($shortlistdata),
                    $perPage,
                    $page,
                    ['path' => request()->url(), 'query' => request()->query()]
                );
                return view('user.shortlistProfile',compact('shortlists','siteconfig'));
            }
            return view('user.shortlistProfile',compact('shortlists','siteconfig'));
    }

    public function blockedProfiles()
    {
        $blocklist = [];
        $id = Auth::guard('user')->user();
        $siteconfig = SiteConfig::first();
        $block = BlockProfile::whereNot('block_to',$id->matri_id)->where('block_by',$id->matri_id)->orderby('created_at','desc')->get();
        $blockdata = [];
        foreach ($block as $data) {
            $register = Register::where('matri_id',$data->block_to)->whereNot('gender',$id->gender)->whereNotIn('status',['Inactive','Suspended'])->with('mother_tongue','rel','cast','occ','country','citi')->first();
            if($register != null)
            {
                $blockdata[] = [
                    'data' =>$register,
                ];
            }
        }
        if(count($blockdata))
            {
                $page = request()->get('page', 1);
                $perPage = 5; 
        
                $offset = ($page * $perPage) - $perPage;

                if(count($blockdata) != 0)
                {
                    $currentPageItems = array_slice($blockdata, $offset, $perPage);
                }
                    
                $blocklist = new LengthAwarePaginator(
                    $currentPageItems,
                    count($blockdata),
                    $perPage,
                    $page,
                    ['path' => request()->url(), 'query' => request()->query()]
                );
                return view('user.blockProfile',compact('blocklist','siteconfig'));
            }
        return view('user.blockProfile',compact('blocklist','siteconfig'));
        
    }

    public function ignoredProfiles()
    {
        $ignorelist = [];
        $log_inid = Auth::guard('user')->user();
        $siteconfig = SiteConfig::first();
        $blockuser =  BlockProfile::where('block_by', $log_inid->matri_id)->pluck('block_to')->toArray();
        $ignoredata = [];
        $ignore = Ignore::whereNotIn('ignore_to',$blockuser)->whereNot('ignore_to',$log_inid->matri_id)->where('ignore_by',$log_inid->matri_id)->orderBy('created_at', 'desc')->get();

        foreach ($ignore as $data) {
            $register = Register::where('matri_id',$data->ignore_to)->whereNot('gender',$log_inid->gender)->whereNotIn('status',['Inactive','Suspended'])->with('mother_tongue','rel','cast','occ','country','citi')->first();
            if($register != null)
            {
                $ignoredata[] = [
                    'data' =>$register,
                ];
            }
        }
        if(count($ignoredata))
        {
            $page = request()->get('page', 1);
            $perPage = 5; 
    
            $offset = ($page * $perPage) - $perPage;

            if(count($ignoredata) != 0)
            {
                $currentPageItems = array_slice($ignoredata, $offset, $perPage);
            }
                
            $ignorelist = new LengthAwarePaginator(
                $currentPageItems,
                count($ignoredata),
                $perPage,
                $page,
                ['path' => request()->url(), 'query' => request()->query()]
            );
            return view('user.ignorProfile',compact('ignorelist','siteconfig'));
        }
        return view('user.ignorProfile',compact('ignorelist','siteconfig'));
    }

    public function iVisitedProfiles()
    {
        $visitlist = [];
        $log_inid = Auth::guard('user')->user();
        $siteconfig = SiteConfig::first();
        $ignore = Ignore::where('ignore_by', $log_inid->matri_id)->pluck('ignore_to')->toArray();
        $blockuser =  BlockProfile::where('block_by', $log_inid->matri_id)->pluck('block_to')->toArray();
        
        $visitdata = [];
        $visit = WhoViewedMyProfiles::where('my_id',$log_inid->matri_id)->whereNot('viewed_member_id',$log_inid->matri_id)->whereNotIn('viewed_member_id',$ignore)->whereNotIn('viewed_member_id',$blockuser)->orderBy('created_at', 'desc')->get();
        foreach ($visit as $data) {
            $register = Register::where('matri_id',$data->viewed_member_id)->whereNot('gender',$log_inid->gender)->whereNotIn('status',['Inactive','Suspended'])->with('mother_tongue','rel','cast','occ','country','citi')->first();
            if($register != null)
            {
                $visitdata[] = [
                    'data' =>$register,
                ];
            }
        }
        if(count($visitdata))
        {
            $page = request()->get('page', 1);
            $perPage = 5; 
    
            $offset = ($page * $perPage) - $perPage;

            if(count($visitdata) != 0)
            {
                $currentPageItems = array_slice($visitdata, $offset, $perPage);
            }
            $visitlist = new LengthAwarePaginator(
                $currentPageItems,
                count($visitdata),
                $perPage,
                $page,
                ['path' => request()->url(), 'query' => request()->query()]
            );
            return view('user.iVisitedProfile',compact('visitlist','siteconfig'));
        }
        return view('user.iVisitedProfile',compact('visitlist','siteconfig'));
    }


    public function myProfileViewedBy()
    {
        $viewprofiletlist = [];
        $log_inid = Auth::guard('user')->user();
        $siteconfig = SiteConfig::first();
        $ignore = Ignore::where('ignore_by', $log_inid->matri_id)->pluck('ignore_to')->toArray();
        $blockuser =  BlockProfile::where('block_by', $log_inid->matri_id)->pluck('block_to')->toArray();
       
        $viewprofiledata = [];
        $viewprofile = WhoViewedMyProfiles::whereNotIn('my_id',$ignore)->whereNotIn('my_id',$blockuser)->whereNot('my_id',$log_inid->matri_id)->where('viewed_member_id',$log_inid->matri_id)->orderBy('created_at', 'desc')->get();
        
        foreach ($viewprofile as $data) {
       
            $register = Register::where('matri_id',$data->my_id)->whereNot('gender',$log_inid->gender)->whereNotIn('status',['Inactive','Suspended'])->with('mother_tongue','rel','cast','occ','country','citi')->first();
            if($register != null)
            {
                $viewprofiledata[] = [
                    'data' =>$register,
                ];
            }
        }
        if(count($viewprofiledata))
        {
            $page = request()->get('page', 1);
            $perPage = 5; 
    
            $offset = ($page * $perPage) - $perPage;

            if(count($viewprofiledata) != 0)
            {
                $currentPageItems = array_slice($viewprofiledata, $offset, $perPage);
            }
            $viewprofiletlist = new LengthAwarePaginator(
                $currentPageItems,
                count($viewprofiledata),
                $perPage,
                $page,
                ['path' => request()->url(), 'query' => request()->query()]
            );
            return view('user.whoViewedProfile',compact('viewprofiletlist','siteconfig'));
        }
        return view('user.whoViewedProfile',compact('viewprofiletlist','siteconfig'));
    }


    public function recentelyJoinedProfile()
    {
        $log_inid = Auth::guard('user')->user();
        $siteconfig = SiteConfig::first();
        $ignore = Ignore::where('ignore_by', $log_inid->matri_id)->pluck('ignore_to')->toArray();
        $blockuser =  BlockProfile::where('block_by', $log_inid->matri_id)->pluck('block_to')->toArray();
        $register = Register::whereNotIn('matri_id',$blockuser)->whereNot('matri_id',$log_inid->matri_id)->whereNotIn('matri_id',$ignore)->whereNot('matri_id',$log_inid->matri_id)->whereNot('gender',$log_inid->gender)->whereNotIn('status',['Inactive','Suspended'])->whereBetween('created_at',[Carbon::now()->subMonth(3), Carbon::now()])->with('mother_tongue','rel','cast','occ','country','citi')->orderBy('created_at', 'desc')->paginate(5);

        return view('user.recentlyJoinedProfile',compact('register','siteconfig'));
    }

    public function featuredProfiles()
    {
        $log_inid = Auth::guard('user')->user();
        $siteconfig = SiteConfig::first();
        $ignore = Ignore::where('ignore_by', $log_inid->matri_id)->pluck('ignore_to')->toArray();
        $blockuser =  BlockProfile::where('block_by', $log_inid->matri_id)->pluck('block_to')->toArray();
        $register = Register::whereNotIn('matri_id',$blockuser)->whereNot('matri_id',$log_inid->matri_id)->whereNotIn('matri_id',$ignore)->whereNot('matri_id',$log_inid->matri_id)->whereNot('gender',$log_inid->gender)->whereNotIn('status',['Inactive','Suspended'])->where('fstatus','featured')->with('mother_tongue','rel','cast','occ','country','citi')->orderBy('created_at', 'desc')->paginate(5);

        return view('user.featuredProfile',compact('register','siteconfig'));
    }


    public function contactDetailsViewedBy()
    {
        $visitlist = [];
        $log_inid = Auth::guard('user')->user();
        $siteconfig = SiteConfig::first();
        $ignore = Ignore::where('ignore_by', $log_inid->matri_id)->pluck('ignore_to')->toArray();
        $blockuser =  BlockProfile::where('block_by', $log_inid->matri_id)->pluck('block_to')->toArray();
        
        $visitdata = [];
        $visit = ContactView::where('my_id',$log_inid->matri_id)->whereNot('viewed_mem_id',$log_inid->matri_id)->whereNotIn('viewed_mem_id',$ignore)->whereNotIn('viewed_mem_id',$blockuser)->orderBy('created_at', 'desc')->get();
        foreach ($visit as $data) {
            $register = Register::where('matri_id',$data->viewed_mem_id)->whereNot('gender',$log_inid->gender)->whereNotIn('status',['Inactive','Suspended'])->with('mother_tongue','rel','cast','occ','country','citi')->first();
            if($register != null)
            {
                $visitdata[] = [
                    'data' =>$register,
                ];
            }
        }
        
        if(count($visitdata))
        {
            $page = request()->get('page', 1);
            $perPage = 5; 
    
            $offset = ($page * $perPage) - $perPage;

            if(count($visitdata) != 0)
            {
                $currentPageItems = array_slice($visitdata, $offset, $perPage);
            }
            $visitlist = new LengthAwarePaginator(
                $currentPageItems,
                count($visitdata),
                $perPage,
                $page,
                ['path' => request()->url(), 'query' => request()->query()]
            );
            return view('user.contactDetailsViewedBy',compact('visitlist','siteconfig'));
        }
        return view('user.contactDetailsViewedBy',compact('visitlist','siteconfig'));
        
    }


    
}
