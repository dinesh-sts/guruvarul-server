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

    $eduName = $data->h_edu->edu_name ?? null;
    if (empty($eduName) && isset($data->edu_detail) && $data->edu_detail !== '') {
        $eduDetails = explode(',', $data->edu_detail);
        $eduName = DB::table('education_details')->where('id', trim($eduDetails[0]))->value('edu_name');
    }

    $detailRows = [];
    if ($age !== null) {
        $detailRows[] = ['label' => 'Age', 'value' => $age . ' Yrs'];
    }
    if (!empty($data->rel->religion_name ?? null)) {
        $detailRows[] = ['label' => 'Religion', 'value' => $data->rel->religion_name];
    }
    if (!empty($data->cast->caste_name ?? null)) {
        $detailRows[] = ['label' => 'Caste', 'value' => $data->cast->caste_name];
    }
    if (!empty($data->subcast->sub_caste_name ?? null)) {
        $detailRows[] = ['label' => 'Sub Caste', 'value' => $data->subcast->sub_caste_name];
    }
    if (!empty($data->rashi->rasi ?? null)) {
        $detailRows[] = ['label' => 'Rasi', 'value' => $data->rashi->rasi];
    }
    if (!empty($data->staars->star ?? null)) {
        $detailRows[] = ['label' => 'Star', 'value' => $data->staars->star];
    }
    if (!empty($eduName)) {
        $detailRows[] = ['label' => 'Education', 'value' => $eduName];
    }
    if (!empty($data->m_status)) {
        $detailRows[] = ['label' => 'Marital Status', 'value' => $data->m_status];
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

                    @if(count($detailRows))
                    <dl class="inMainResultDetails">
                        @foreach($detailRows as $row)
                        <div class="inMainResultDetail">
                            <dt>{{ $row['label'] }}</dt>
                            <dd title="{{ $row['value'] }}">{{ $row['value'] }}</dd>
                        </div>
                        @endforeach
                    </dl>
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
