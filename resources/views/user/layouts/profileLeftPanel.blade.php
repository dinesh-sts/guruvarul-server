    <?php
        $log_inid = Auth::guard('user')->user();
        $registeruser = DB::table('registers')->whereNotIn('status',['Inactive','Suspended'])->pluck('matri_id')->toArray();
       
        $ignore = DB::table('ignores')->where('ignore_by', $log_inid->matri_id)->whereIn('ignore_to', $registeruser)->pluck('ignore_to')->toArray();
        $blockuser = DB::table('block_profiles')->where('block_by', $log_inid->matri_id)->whereIn('block_to', $registeruser)->pluck('block_to')->toArray();
        $featured = DB::table('registers')->whereNotIn('matri_id',$blockuser)->whereNot('matri_id',$log_inid->matri_id)->whereNotIn('matri_id',$ignore)->whereNot('matri_id',$log_inid->matri_id)->whereNot('gender',$log_inid->gender)->whereNotIn('status',['Inactive','Suspended'])->where('fstatus','featured')->count();
        $recentelyjoin = DB::table('registers')->whereNotIn('matri_id',$blockuser)->whereNot('matri_id',$log_inid->matri_id)->whereNotIn('matri_id',$ignore)->whereNot('matri_id',$log_inid->matri_id)->whereNot('gender',$log_inid->gender)->whereNotIn('status',['Inactive','Suspended'])->whereBetween('created_at',[\Carbon\Carbon::now()->subMonth(3), \Carbon\Carbon::now()])->count();
        $viewprofile = DB::table('who_viewed_my_profiles')->whereIn('my_id', $registeruser)->whereNotIn('my_id',$ignore)->whereNotIn('my_id',$blockuser)->whereNot('my_id',$log_inid->matri_id)->where('viewed_member_id',$log_inid->matri_id)->count();
        $visit = DB::table('who_viewed_my_profiles')->whereIn('viewed_member_id', $registeruser)->where('my_id',$log_inid->matri_id)->whereNot('viewed_member_id',$log_inid->matri_id)->whereNotIn('viewed_member_id',$ignore)->whereNotIn('viewed_member_id',$blockuser)->count();

        $contactViewedBy = DB::table('contact_views')->where('my_id',$log_inid->matri_id)->whereNot('viewed_mem_id',$log_inid->matri_id)->whereNotIn('viewed_mem_id',$ignore)->whereNotIn('viewed_mem_id',$blockuser)->orderBy('created_at', 'desc')->count();

        $ignoreid = DB::table('ignores')->whereNotIn('ignore_to',$blockuser)->where('ignore_by',$log_inid->matri_id)->whereIn('ignore_to', $registeruser)->count();
        $block = DB::table('block_profiles')->where('block_by',$log_inid->matri_id)->whereIn('block_to', $registeruser)->count();
        $Shortlist = DB::table('shortlists')->whereNotIn('to_id',$blockuser)->whereNotIn('to_id',$ignore)->where('from_id',$log_inid->matri_id)->whereIn('to_id', $registeruser)->count();
    ?>
    
<div class="card mb-3 inLeftPanelCard d-none d-md-block">
    <div class="card-header">
        <i class="fas fa-users pe-2"></i>PROFILE DETAILS
    </div>
    <div class="card-body">
        <ul class="list-unstyled mb-0">
            <li><a href="{{ route('user.shortListedProfiles') }}"><span>Shortlisted</span><span class="badge text-bg-primary float-end">@if(isset($Shortlist)){{ $Shortlist }}@endif</span></a></li>
            <li><a href="{{ route('user.ignoredProfiles') }}"><span>Ignored</span><span class="badge text-bg-primary float-end">@if(isset($ignoreid)){{ $ignoreid }}@endif</span></a></li>
            <li><a href="{{ route('user.myProfileViewedBy') }}"><span>My Profile Viewed By</span><span class="badge text-bg-primary float-end">@if(isset($viewprofile)){{$viewprofile}}@endif</span></a></li>
            <li><a href="{{ route('user.iVisitedProfiles') }}"><span>I Visted Profile</span><span class="badge text-bg-primary float-end">@if(isset($visit)){{ $visit }}@endif</span></a></li>
            <li><a href="{{ route('user.contactDetailsViewedBy') }}"><span>Contact Details Viewed By</span><span class="badge text-bg-primary float-end">@if(isset($contactViewedBy)){{ $contactViewedBy }}@endif</span></a></li>
            <li><a href="{{ route('user.recentelyJoinedProfiles') }}"><span>Recently Joined Profile</span><span class="badge text-bg-primary float-end">@if(isset($recentelyjoin)){{ $recentelyjoin }}@endif</span></a></li>
            <li><a href="{{ route('user.featuredProfiles') }}"><span>Featured Profile</span><span class="badge text-bg-primary float-end">@if(isset($featured)){{ $featured }}@endif</span></a></li>
            <li><a href="{{ route('user.blockedProfiles') }}"><span>Block Profile</span><span class="badge text-bg-primary float-end">@if(isset($block)){{ $block }}@endif</span></a></li>
        </ul>
    </div>
</div>
<!-- Advertisement -->
@include('user.layouts.advertisement.advLevel2')