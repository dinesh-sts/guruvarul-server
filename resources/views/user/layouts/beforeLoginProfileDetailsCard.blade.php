@php
    $siteconfig = DB::table('site_configs')->first();

    $age = null;
    if ($data->birthdate) {
        $age = Carbon\Carbon::parse($data->birthdate)->diff(Carbon\Carbon::now())->y;
    }

    $displayName = $data->matri_id ?? '';
    if ($siteconfig->username_setting == "full_username") {
        $displayName = trim(($data->firstname ?? '') . ' ' . ($data->lastname ?? ''));
        if ($displayName === '') {
            $displayName = $data->matri_id;
        }
    } elseif ($siteconfig->username_setting == "first_surname") {
        $lastInitial = isset($data->lastname) && $data->lastname !== '' ? substr($data->lastname, 0, 1) : '';
        $displayName = trim(($data->firstname ?? '') . ' ' . $lastInitial);
        if ($displayName === '') {
            $displayName = $data->matri_id;
        }
    }

    $eduName = null;
    if (isset($data->edu_detail) && $data->edu_detail !== '') {
        $eduDetails = explode(',', $data->edu_detail);
        $eduName = DB::table('education_details')->where('id', $eduDetails[0])->value('edu_name');
    }

    $metaChips = [];
    if ($age !== null) {
        $metaChips[] = $age . ' Yrs';
    }
    if (isset($data->height) && !empty($data->hei->height ?? null)) {
        $metaChips[] = $data->hei->height;
    }
    if (isset($data->m_tongue) && !empty($data->mother_tongue->mtongue_name ?? null)) {
        $metaChips[] = $data->mother_tongue->mtongue_name;
    }
    if (isset($data->religion) && !empty($data->rel->religion_name ?? null)) {
        $metaChips[] = $data->rel->religion_name;
    }
    if (isset($data->caste) && !empty($data->cast->caste_name ?? null)) {
        $metaChips[] = $data->cast->caste_name;
    }
    if (isset($data->occupation) && !empty($data->occ->ocp_name ?? null)) {
        $metaChips[] = $data->occ->ocp_name;
    }
    if (!empty($eduName)) {
        $metaChips[] = $eduName;
    }
    if (!empty($data->citi->city_name ?? null)) {
        $metaChips[] = $data->citi->city_name;
    }
    if (!empty($data->country->country_name ?? null)) {
        $metaChips[] = $data->country->country_name;
    }
@endphp
<div id="olddata" class="card mb-3 inMainResultCard inBorderColor1">
    <div class="row g-0 inMainResultRow">
        <div class="col-md-3 col-lg-3 inMainResultPhoto">
            <a href="{{route('user.login')}}" class="text-decoration-none inMainResultPhotoLink">
                @if(isset($data))
                <?php  $filePath = '/userImages/'.$data->photo1; ?>
                    @if($data->photo1 != "" && $data->photo1_approve == "APPROVED" && Storage::disk('public')->exists($filePath))
                    <img src="{{asset('storage/userImages/'. $data->photo1)}}" class="inMainResultImg" alt="{{ $displayName }}">
                    @elseif($data->photo1 != ""  && $data->gender == "Female" && $data->photo1_approve == "PENDING" && Storage::disk('public')->exists($filePath))
                        <img src="{{asset('user/img/femalepending.jpg')}}" class="inMainResultImg" alt="Pending photo">
                    @elseif($data->photo1 != ""  && $data->gender == "Male" && $data->photo1_approve == "PENDING" && Storage::disk('public')->exists($filePath))
                        <img src="{{asset('user/img/malepending.jpg')}}" class="inMainResultImg" alt="Pending photo">
                    @else
                        @if($data->gender == "Male")
                            <img src="{{asset('user/img/male.jpg')}}" class="inMainResultImg" alt="Profile">
                        @else
                            <img src="{{asset('user/img/female.jpg')}}" class="inMainResultImg" alt="Profile">
                        @endif
                    @endif
                @endif
            </a>
        </div>
        <div class="col-md-9 col-lg-9 inMainResultContent">
            <div class="card-body inMainResultBody">
            <a href="{{route('user.login')}}" class="text-decoration-none inMainResultInfo">
                    <div class="inMainResultHeader">
                        <h5 class="card-title">{{ $displayName }}</h5>
                        <p class="inMainResultMeta">
                            <span class="inMainResultId">{{ $data->matri_id }}</span>
                            <span class="inMainResultDot" aria-hidden="true">·</span>
                            <span>Profile Created by {{ $data->profileby ?? 'Not Available' }}</span>
                        </p>
                    </div>

                    @if(count($metaChips))
                    <ul class="inMainResultChips">
                        @foreach($metaChips as $chip)
                        <li>{{ $chip }}</li>
                        @endforeach
                    </ul>
                    @endif
                </a>
                <div class="row g-0 inMainResultAction">
                   
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
