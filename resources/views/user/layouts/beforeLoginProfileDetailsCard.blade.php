<div id="olddata" class="card mb-3 inMainResultCard inBorderColor1">
    <div class="row g-0">
        <div class="col-lg-4">
            <a href="{{route('user.login')}}" class="text-decoration-none">
               
                @if(isset($data))
                <?php  $filePath = '/userImages/'.$data->photo1; ?>
                    @if($data->photo1 != "" && $data->photo1_approve == "APPROVED" && Storage::disk('public')->exists($filePath))
                    <img src="{{asset('storage/userImages/'. $data->photo1)}}" class="img-fluid rounded maxH-250">
                        {{-- <img src="{{ route('apply.watermark', ['image' => $data->photo1]) }}" class="img-fluid rounded maxH-250 gtFullWidth"> --}}
                    @elseif($data->photo1 != ""  && $data->gender == "Female" && $data->photo1_approve == "PENDING" && Storage::disk('public')->exists($filePath))
                        <img src="{{asset('user/img/femalepending.jpg')}}" class="img-fluid rounded maxH-250">
                    @elseif($data->photo1 != ""  && $data->gender == "Male" && $data->photo1_approve == "PENDING" && Storage::disk('public')->exists($filePath))
                        <img src="{{asset('user/img/malepending.jpg')}}" class="img-fluid rounded maxH-250">
                    @else
                        @if($data->gender == "Male")
                            <img src="{{asset('user/img/male.jpg')}}" class="img-fluid rounded maxH-250">
                        @else
                            <img src="{{asset('user/img/female.jpg')}}" class="img-fluid rounded maxH-250">
                        @endif
                    @endif
                @endif
            </a>
        </div>
        <div class="col-lg-8">
            <div class="card-body">
            <a href="{{route('user.login')}}" class="text-decoration-none">
                <?php
                    $siteconfig = DB::table('site_configs')->first();
                ?>
                    @if($siteconfig->username_setting == "full_username")
                        <h5 class="card-title">@if(isset($data->firstname)){{$data->firstname}}@endif @if(isset($data->lastname)){{$data->lastname}}({{$data->matri_id}})@else {{$data->matri_id}}@endif</h5>
                    @elseif($siteconfig->username_setting == "first_surname")
                        <h5 class="card-title">@if(isset($data->firstname)){{$data->firstname}}@endif @if(isset($data->lastname)){{substr($data->lastname, 0, 1)}}({{$data->matri_id}})@else {{$data->matri_id}}@endif</h5>
                    @else
                        
                    @endif
                
                    <h6 class="mb-3">@if(isset($data->matri_id)){{$data->matri_id}}@endif &nbsp;&nbsp;|&nbsp;&nbsp; Profile Created by @if(isset($data->profileby)){{$data->profileby}}@else Not Available @endif</h6>
                  
                    <?php   
                    if($data->birthdate)
                    {
                        $from = Carbon\Carbon::parse($data->birthdate);
                        $to = Carbon\Carbon::now();
                        $age =$from->diff($to)->y;
                    }
                    ?>
                    @if(isset($data->edu_detail))
                    <?php
                        $eduDetails = explode(',', $data->edu_detail);
                        $edu = DB::table('education_details')->where('id',$eduDetails[0])->pluck('edu_name');
                        ?>
                    @endif
                    <p class="card-text">@if(isset($data->birthdate)){{$age}} Yrs @else Not Available @endif, @if(isset($data->height)){{$data->hei->height}}@else Not Available @endif, @if(isset($data->m_tongue)){{$data->mother_tongue->mtongue_name}}@else Not Available @endif, </p>
                    <p class="card-text">@if(isset($data->religion)){{$data->rel->religion_name}}@else Not Available @endif, @if(isset($data->caste)){{$data->cast->caste_name}}@else Not Available @endif,</p>
                    <p class="card-text">@if(isset($data->occupation) && !empty($data->occ->ocp_name)){{$data->occ->ocp_name}}@else Not Available @endif, @if(isset($eduDetails[0]->h_edu->edu_name)){{$eduDetails[0]->h_edu->edu_name}}@else Not Available @endif, @if(isset($data->citi->city_name)){{$data->citi->city_name}}@else Not Available @endif, @if(isset($data->country)){{$data->country->country_name}}@else Not Available @endif</p>
                </a>
                <div class="row mt-4 inMainResultAction mt-lg-2 mt-xl-4">
                   
                    <div class="col text-center" id="message" onclick="message('{{ $data->matri_id }}')">
                        <a href="#">
                            <i class="fas fa-envelope"></i>
                            <p>Message</p>
                        </a>
                    </div>
                    
                    <div class="col text-center" id="ignore">
                        <a href="#" data-register-id="{{ $data->matri_id }}" onclick="ignore('{{ $data->matri_id }}')">
                            <i class="fas fa-ban"></i>
                            <p>Ignore</p>
                        </a>
                    </div>
                
                    <div class="col text-center"  id="shortlist">
                        <a href="#" data-register-id="{{ $data->matri_id }}" onclick="addshortlist('{{ $data->matri_id }}')">
                            <i class="fas fa-list"></i>
                            <p>Add Shortlist</p>
                        </a>
                    </div>
                    
                    <div class="col text-center" id="intrest">
                        <a href="#" data-register-id="{{ $data->matri_id }}" onclick="sendintrest('{{ $data->matri_id }}')">
                            <i class="fas fa-heart" aria-hidden="true"></i>
                            <p>Send Interest</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>   
