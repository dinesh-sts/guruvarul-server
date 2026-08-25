@php
    $user = Auth::guard('user')->user();
    $site_configs = DB::table('site_configs')->first();
    $status = DB::table('expressinterests')->where('ei_sender',$user->matri_id)->where('ei_receiver',$data->matri_id)->first();

    $age = null;
    if ($data->birthdate) {
        $age = Carbon\Carbon::parse($data->birthdate)->diff(Carbon\Carbon::now())->y;
    }

    $displayName = $data->matri_id;
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
    if (empty($eduName) && !empty($data->edu_detail)) {
        $eduIds = explode(',', $data->edu_detail);
        $eduName = DB::table('education_details')->where('id', trim($eduIds[0]))->value('edu_name');
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
<input type="hidden" value="{{$data->matri_id}}" id="id">
<div class="card mb-3 inMainResultCard inBorderColor1">
    <div class="row g-0 inMainResultRow">
        <div class="col-md-3 col-lg-3 inMainResultPhoto">
            <a href="{{ route('user.memberProfile',$data->matri_id) }}" title="{{$data->matri_id}}" class="text-decoration-none inMainResultPhotoLink">
                @if(isset($data))
                    @php $filePath = '/userImages/'.$data->photo1;  @endphp
                    @if($data->photo1 != "" && $data->photo1_approve == "APPROVED" && (($data->photo_setting == '0') || ($data->photo_setting == '1' && Auth::guard('user')->user()->status == 'Paid') || ($data->photo_setting == '2' && $status && $status->receiver_response == "Accept" )) && Storage::disk('public')->exists($filePath))
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
               <a href="{{ route('user.memberProfile',$data->matri_id) }}" title="{{$data->matri_id}}" class="text-decoration-none inMainResultInfo">
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
                    
                    <div class="col text-center">
                        <form action="{{route('user.chatthreadpost',$data->id)}}">
                            @csrf
                          @if(Auth::guard('user')->user()->status == "Paid")
                            <button type="submit" value="Message" name="Message">
                                <i class="fas fa-envelope"></i>
                                <p>Message</p>
                            </button>
                            @else
                                <a value="Message" name="Message" onclick="$('#messagebox').toast('show');"><i class="fas fa-envelope"></i><p>Message</p></a>
                            @endif
                        </form>
                    </div>
                   
                   
                    <?php
                     $id = Auth::guard('user')->user()->matri_id;
                     $site_configs = DB::table('site_configs')->first();
                     $ignorelist = DB::table('ignores')->where('ignore_by',$id)->where('ignore_to',$data->matri_id)->first();
                    
                     if($ignorelist != "")
                        {
                            $ignore = 1;
                        }else{
                            $ignore = 0;
                        }
                     $shortlist = DB::table('shortlists')->where('from_id',$id)->where('to_id',$data->matri_id)->first();
                        if($shortlist != "")
                        {
                            $shortstatus = 1;
                        }else{
                            $shortstatus = 0;
                        }
                    $intrestdata = DB::table('expressinterests')->where('ei_sender',$id)->where('ei_receiver',$data->matri_id)->first();
                        if($intrestdata != "")
                        {
                            $intrest = 1;
                        }else{
                            $intrest = 0;
                        }
                    ?>
                     @if($ignore == 1)
                        <div class="col text-center" id="unignoredata{{ $data->matri_id }}" onclick="$('#removeignore').toast('show');">
                            <a href="javascript:void(0);" data-register-id="{{ $data->matri_id }}" onclick="unignore('{{ $data->matri_id }}')">
                                <i class="fas fa-ban"></i>
                                <p>Remove Ignore</p>
                            </a>
                        </div>
                     @else
                        <div class="col text-center" id="ignoredata{{ $data->matri_id }}" onclick="$('#sentignore').toast('show');">
                            <a href="javascript:void(0);" data-register-id="{{ $data->matri_id }}" onclick="ignore('{{ $data->matri_id }}')">
                                <i class="fas fa-ban"></i>
                                <p>Ignore</p>
                            </a>
                        </div>
                     @endif
                        {{-- Ignore after ajax call --}}
                        <div class="col text-center" id="unignore{{ $data->matri_id }}" onclick="$('#removeignore').toast('show');" style="display:none;">
                            <a href="javascript:void(0);" data-register-id="{{ $data->matri_id }}" onclick="unignore('{{ $data->matri_id }}')">
                                <i class="fas fa-ban"></i>
                                <p>Remove Ignore</p>
                            </a>
                        </div>
                        <div class="col text-center" id="ignore{{ $data->matri_id }}" onclick="$('#sentignore').toast('show');" style="display:none;">
                            <a href="javascript:void(0);" data-register-id="{{ $data->matri_id }}" onclick="ignore('{{ $data->matri_id }}')">
                                <i class="fas fa-ban"></i>
                                <p>Ignore</p>
                            </a>
                        </div>
                        {{-- end ajax call --}}

                     @if($shortstatus == 1)
                        <div class="col text-center" id="removedata{{ $data->matri_id }}">
                            <a href="javascript:void(0);" data-register-id="{{ $data->matri_id }}" onclick="removeshortlist('{{ $data->matri_id }}')">
                                <i class="fas fa-list"></i>

                                <p>Remove Shortlist</p>
                            </a>
                        </div>
                    @else
                        <div class="col text-center" id="reshowdata{{$data->matri_id}}">
                            <a href="javascript:void(0);" data-register-id="{{ $data->matri_id }}" onclick="addshortlist('{{ $data->matri_id }}')">
                                <i class="fas fa-list"></i>
                                <p>Add Shortlist</p>
                            </a>
                        </div>
                    @endif
                    {{-- after ajax call --}}
                    <div class="col text-center" id="remove{{ $data->matri_id }}" style="display:none;">
                        <a href="javascript:void(0);" data-register-id="{{ $data->matri_id }}" onclick="removeshortlist('{{ $data->matri_id }}')">
                            <i class="fas fa-list"></i>
                            <p>Remove Shortlist</p>
                        </a>
                    </div>
                    
                    <div class="col text-center"  id="reshow{{$data->matri_id}}" style="display:none;">
                        <a href="javascript:void(0);" data-register-id="{{ $data->matri_id }}" onclick="addshortlist('{{ $data->matri_id }}')">
                            <i class="fas fa-list"></i>
                            <p>Add Shortlist</p>
                        </a>
                    </div>
                    {{-- end ajax call --}}

                    @if($intrest == 1)
                        @if($intrestdata->receiver_response == "Pending")
                            <div class="col text-center" id="interestremovedata{{ $data->matri_id }}">
                                <a href="javascript:void(0);"  data-register-id="{{ $data->matri_id }}" @if($site_configs->interest_setting == "send_to_paid")@if(Auth::guard('user')->user()->status == "Paid")onclick="removeintrest('{{ $data->matri_id }}')"@else onclick="$('#messagebox').toast('show');" @endif @else onclick="removeintrest('{{ $data->matri_id }}')" @endif>
                                    <i class="fas fa-heart" aria-hidden="true"></i>
                                
                                    <p>Remove Interest</p>
                                </a>
                            </div>
                            @elseif($intrestdata->receiver_response == "Accept")
                            <div class="col text-center">
                                <a>
                                    <i class="fas fa-heart" aria-hidden="true"></i>
                                    <p>Interest Accept</p>
                                </a>
                            </div>
                            @else
                            <div class="col text-center">
                                <a>
                                    <i class="fas fa-heart" aria-hidden="true"></i>
                                    <p>Interest Reject </p>
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="col text-center" id="interestshowdata{{ $data->matri_id }}">
                            <a href="javascript:void(0);" data-register-id="{{ $data->matri_id }}" @if($site_configs->interest_setting == "send_to_paid")@if(Auth::guard('user')->user()->status == "Paid")onclick="sendintrest('{{ $data->matri_id }}')"@else onclick="$('#messagebox').toast('show');" @endif @else onclick="sendintrest('{{ $data->matri_id }}')" @endif >
                                <i class="fas fa-heart" aria-hidden="true"></i>
                                <p>Send Interest</p>
                            </a>
                        </div>
                    @endif
                    {{-- Send Intrest after ajax call --}}
                    <div class="col text-center" id="sendintrest{{ $data->matri_id }}" style="display:none;">
                        <a href="javascript:void(0);" data-register-id="{{ $data->matri_id }}" @if($site_configs->interest_setting == "send_to_paid")@if(Auth::guard('user')->user()->status == "Paid")onclick="sendintrest('{{ $data->matri_id }}')"@else onclick="$('#messagebox').toast('show');" @endif @else onclick="sendintrest('{{ $data->matri_id }}')" @endif>
                            <i class="fas fa-heart"></i>
                            <p>Send Interest</p>
                        </a>
                    </div>
                    <div class="col text-center" id="removeintrest{{ $data->matri_id }}" style="display:none;">
                        <a href="javascript:void(0);" data-register-id="{{ $data->matri_id }}" @if($site_configs->interest_setting == "send_to_paid")@if(Auth::guard('user')->user()->status == "Paid")onclick="removeintrest('{{ $data->matri_id }}')"@else onclick="$('#messagebox').toast('show');" @endif @else onclick="removeintrest('{{ $data->matri_id }}')" @endif>
                            <i class="fas fa-heart"></i>
                            <p>Remove Interest</p>
                        </a>
                    </div>
                    {{-- close --}}
                </div>
            </div>
        </div>
    </div>
</div>
