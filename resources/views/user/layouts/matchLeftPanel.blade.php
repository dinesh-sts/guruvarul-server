<?php 
    $id = Auth::guard('user')->user();
    $ignore = DB::table('ignores')->where('ignore_by', $id->matri_id)->pluck('ignore_to')->toArray();
        $blockuser = DB::table('block_profiles')->where('block_by', $id->matri_id)->pluck('block_to')->toArray();

        $countryLivingIds = explode(',', $id->part_country_living);
        $religionIds = explode(',', $id->part_religion);
        $casteIds = explode(',', $id->part_caste);
        $looking_forIds = explode(',', $id->looking_for);

        $data = DB::table('registers')->select('*')->whereNotIn('status',['Inactive','Suspended'])->whereNotIn('matri_id',$ignore)->whereNotIn('matri_id',$blockuser)
        ->selectRaw('YEAR(CURDATE()) - YEAR(birthdate) - (DATE_FORMAT(CURDATE(), "%m%d") < DATE_FORMAT(birthdate, "%m%d")) AS age');

        $data->WhereNot('gender', $id->gender);
        $data->whereIn('country_id', $countryLivingIds);
        $data->whereIn('religion', $religionIds);
        $data->whereIn('caste', $casteIds);
        $data->whereIn('m_status', $looking_forIds);
        if(isset($id->age_to))
        {
            $ageto = $id->age_to->age;
            $agefrom = $id->age_from->age;
            if (!empty($ageto) && !empty($agefrom)) {  
                $data->whereRaw('YEAR(CURDATE()) - YEAR(birthdate) - (DATE_FORMAT(CURDATE(), "%m%d") < DATE_FORMAT(birthdate, "%m%d")) BETWEEN ? AND ?', [$agefrom, $ageto]);
            }
        }
        $onewaymatch = $data->count();

?>
<?php 
    $edudeatils = explode(',', $id->edu_detail);
    $edu = $edudeatils[0];
    
    $data = DB::table('registers')->select('*')->whereNotIn('status',['Inactive','Suspended'])->whereNotIn('matri_id',$ignore)->whereNotIn('matri_id',$blockuser)
    ->selectRaw('YEAR(CURDATE()) - YEAR(birthdate) - (DATE_FORMAT(CURDATE(), "%m%d") < DATE_FORMAT(birthdate, "%m%d")) AS age');

    $data->where('part_edu', 'like', '%' . $edu . '%');
    $data->where('country_id', $id->country_id);
    $data->where('religion', $id->religion);
    $data->WhereNot('gender', $id->gender);
    $data->where('caste', $id->caste);
    $data->where('m_status', $id->m_status);
    $twoway = $data->count();
?>
<?php 
    $casteIds = explode(',', $id->part_caste);
    if($id->will_to_mary_caste == '1'){
        $c=$id->caste;
    }elseif($casteIds != null){
        $c=$casteIds;
    }else{
        $c="";
    }
    $data = DB::table('registers')->select('*')->whereNotIn('status',['Inactive','Suspended'])->whereNotIn('matri_id',$ignore)->whereNotIn('matri_id',$blockuser)
    ->selectRaw('YEAR(CURDATE()) - YEAR(birthdate) - (DATE_FORMAT(CURDATE(), "%m%d") < DATE_FORMAT(birthdate, "%m%d")) AS age');
    $data->where('country_id', $id->country_id);
    $data->where('religion', $id->religion);
    $data->WhereNot('gender', $id->gender);
    $data->where('caste', $c);
    
    $broaderway = $data->count();
?>
<?php 
    $edu_detail = explode(',', $id->edu_detail);
    $data = DB::table('registers')->select('*')->whereNotIn('status',['Inactive','Suspended'])->whereNotIn('matri_id',$ignore)->whereNotIn('matri_id',$blockuser)
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
    $preferedway = $data->count();
?>
<?php
    $Authuser = Auth::guard('user')->user();
        $matchis = DB::table('matches')->where('matri_id',$Authuser->matri_id)->first();
        $customway = 0;
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
    
        $data = DB::table('registers')->select('*')->whereNotIn('matri_id',$ignore)->whereNotIn('matri_id',$blockuser)->whereNot('matri_id',$Authuser->matri_id)->whereNotIn('status',['Inactive','Suspended'])
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
                $data->whereBetween('height', [$height_to, $height_from]);
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
        $customway = $data->count();
        }
?>

<div class="col-lg-3 col-md-4">
    <div class="card mb-3 inLeftPanelCard d-none d-md-block">
        <div class="card-header">
            <i class="fas fa-users pe-2"></i>MATCHES
        </div>
        <div class="card-body">
            <ul class="list-unstyled mb-0">
                <li><a href="{{route('user.oneWayMatch')}}"><span>One Way Match</span><span class="badge text-bg-primary float-end">@if(isset($onewaymatch)){{$onewaymatch}}@endif</span></a></li>
                <li><a href="{{route('user.twoWayMatch')}}"><span>Two Way Match</span><span class="badge text-bg-primary float-end">@if(isset($twoway)){{$twoway}}@endif</span></a></li>
                <li><a href="{{route('user.broaderWayMatch')}}"><span>Broader Match</span><span class="badge text-bg-primary float-end">@if(isset($broaderway)){{$broaderway}}@endif</span></a></li>
                <li><a href="{{route('user.preferedWayMatch')}}"><span>Prefered Match</span><span class="badge text-bg-primary float-end">@if(isset($preferedway)){{$preferedway}}@endif</span></a></li>
                <li><a href="{{route('user.customWayMatch')}}"><span>Custom Match</span><span class="badge text-bg-primary float-end">@if(isset($customway)){{$customway}}@endif</span></a></li>
            </ul>
        </div>
    </div>
    <!-- Advertisement -->
    @include('user.layouts.advertisement.advLevel2')
</div>