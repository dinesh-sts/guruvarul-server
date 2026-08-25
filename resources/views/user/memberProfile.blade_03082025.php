@extends('user.layouts.afterLoginLayout')

@section('pageCSS')
<link rel="stylesheet" href="{{asset('User/css/prism.css')}}">
<link rel="stylesheet" href="{{asset('User/css/chosen.css')}}">
<link rel="stylesheet" href="{{asset('User/css/tel/intlTelInput.min.css')}}">
@endsection

<!-- Content Section Start -->
@section('content')

<section class="inMemberProfile">
    <?php
        $id = Auth::guard('user')->user();
    ?>
    <div class="container-fluid inMemOverLap text-end">
        @if($id->matri_id != $register->matri_id)
        <a href="{{route('user.blockedstore',$register->matri_id)}}" class="btn btnPrimary">Block Profile</a>
        @endif
    </div>
    <div class="container mt-minus-220">
        <div class="row">
            <div class="col-xl-10 offset-xl-1">
                <div class="row">
                    <div class="col-lg-4 col-md-5 pe-4 ps-4">
                        @php
                            $user = Auth::guard('user')->user();
                            $site_configs = DB::table('site_configs')->first();
                            $status = DB::table('expressinterests')->where('ei_sender',$user->matri_id)->where('ei_receiver',$register->matri_id)->first();
                        @endphp
                        <!-- Profile Picture Card -->
                        <div class="card mb-3 shadow-sm border-0 inMemProfileImg">
                            @if(isset($register))
                                @php $filePath = '/userImages/'.$register->photo1;  @endphp
                                @if($register->photo1 != "" && $register->photo1_approve == "APPROVED" && (($register->photo_setting == '0') || ($register->photo_setting == '1' && Auth::guard('user')->user()->status == 'Paid') || ($register->photo_setting == '2' && $status->receiver_response == "Accept" )) && Storage::disk('public')->exists($filePath))
                                <img src="{{asset('storage/userImages/'. $register->photo1)}}" class="img-fluid rounded w-100">
                                @elseif($register->photo1 != ""  && $register->gender == "Female" && $register->photo1_approve == "PENDING" && Storage::disk('public')->exists($filePath))
                                        <img src="{{asset('user/img/femalepending.jpg')}}" class="img-fluid rounded w-100">
                                @elseif($register->photo1 != ""  && $register->gender == "Male" && $register->photo1_approve == "PENDING" && Storage::disk('public')->exists($filePath))
                                        <img src="{{asset('user/img/malepending.jpg')}}" class="img-fluid rounded w-100">
                                @else
                                    @if($register->gender == "Male")
                                        <img src="{{asset('user/img/male.jpg')}}" class="img-fluid rounded w-100">
                                    @else
                                        <img src="{{asset('user/img/female.jpg')}}" class="img-fluid rounded w-100">
                                    @endif
                                @endif
                                
                            @endif
                        </div>
                        <!-- /.Profile Picture Card -->
                        @if(($register->photo1 != null || $register->photo2 != null || $register->photo3 != null || $register->photo4 != null || $register->photo5 != null || $register->photo6 != null || $register->photo7 != null || $register->photo8 != null) && (($register->photo_setting == '0') || ($register->photo_setting == '1' && Auth::guard('user')->user()->status == 'Paid') || ($register->photo_setting == '2' && $status->receiver_response == "Accept" )) )
                        <a href="#" class="btn btnPrimary d-block mb-4" data-bs-toggle="modal" data-bs-target="#memberProfilePhotos">View All Photos</a>
                        @endif

                    </div>
                    <div class="col-lg-8 col-md-7">
                        <div class="pe-4 ps-4 pe-md-0 ps-md-0">
                            <div class="row mb-3">
                                <div class="col-12 inMemTopName">
                                    @if($profileviewsetting->username_setting == "full_username")
                                        <h5 class="">@if(isset($register->firstname)){{$register->firstname}}@endif @if(isset($register->lastname)){{$register->lastname}}@endif</h5>
                                    @elseif($profileviewsetting->username_setting == "first_surname")
                                        <h5 class="">@if(isset($register->firstname)){{$register->firstname}}@endif @if(isset($register->lastname)){{substr($register->lastname, 0, 1)}}@endif</h5>
                                    @else
                                        <h5 class="">@if(isset($register->matri_id)){{$register->matri_id}}@endif</h5>
                                    @endif
                                    <h6 class="mb-3">@if(isset($register->matri_id)){{$register->matri_id}}@endif &nbsp;&nbsp;|&nbsp;&nbsp; Profile Created by @if(isset($register->profileby)){{$register->profileby}}@else Not Available @endif</h6>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-xl-6 inMemTopBasicDet">
                                    <?php   
                                    if(isset($register->birthdate))
                                    {
                                        $from = Carbon\Carbon::parse($register->birthdate);
                                        $to = Carbon\Carbon::now();
                                        $age =$from->diff($to)->y;
                                    }
                                    ?>
                                    <h5 class=""><span class="inMemDetMain pe-1">Age & Height is</span><span class="ps-1 inMemDet">@if(isset($register->birthdate)){{$age}} Yrs @else N/A @endif, @if(isset($register->height)){{$register->hei->height}}@else N/A @endif</span></h5>
                                </div>
                                <div class="col-lg-6 col-xl-5 inMemTopBasicDet">
                                    <h5 class=""><span class="inMemDetMain pe-1">Marital Status is</span><span class="ps-1 inMemDet">@if(isset($register->m_status)){{$register->m_status}}@else N/A @endif</span></h5>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-xl-6 inMemTopBasicDet">
                                    <h5 class=""><span class="inMemDetMain pe-1">Religion is</span><span class="ps-1 inMemDet">@if(isset($register->religion)){{$register->rel->religion_name}}@else N/A @endif</span></h5>
                                </div>
                                <div class="col-lg-6 col-xl-6 inMemTopBasicDet">
                                    <h5 class=""><span class="inMemDetMain pe-1">Caste is</span><span class="ps-1 inMemDet">@if(isset($register->caste)){{$register->cast->caste_name}}@else N/A @endif</span></h5>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-xl-6 inMemTopBasicDet">
                                    <h5 class=""><span class="inMemDetMain pe-1">Lives In</span><span class="ps-1 inMemDet">@if(isset($register->country_id)){{$register->country->country_name}}@else N/A @endif,@if(isset($register->state_id)){{$register->state->state_name}}@else N/A @endif</span></h5>
                                </div>
                                <div class="col-lg-6 col-xl-6 inMemTopBasicDet">
                                    <h5 class=""><span class="inMemDetMain pe-1">Mother Tongue is</span><span class="ps-1 inMemDet">@if(isset($register->m_tongue)){{$register->mother_tongue->mtongue_name}}@else N/A @endif</span></h5>
                                </div>
                            </div>
                        </div>
                        <?php
                            $site_configs = DB::table('site_configs')->first();
                           
                            $payment = DB::table('payments')->where('pmatri_id',$id->matri_id)->first();
                            $today = \Carbon\Carbon::now()->format('d-m-Y');

                            if(isset($payment->exp_date))
                            {
                                $date = \Carbon\Carbon::createFromFormat('d-m-y', $payment->exp_date)->format('d-m-Y');
                                $today = strtotime(date($today));
                                $date = strtotime(date($date));
                            }
                            
                        ?>
                        @if($profileviewsetting->interest_setting == "send_to_paid")
                        <?php $cansendinterest = ""; ?>
                            @if($id->status == "Paid")
                                <?php $cansendinterest = 1;?>
                            @else
                                <?php $cansendinterest = 0;?>
                            @endif
                        @else
                            <?php $cansendinterest = 1;?>
                        @endif
                        <div class="row">
                            
                            @if($register->matri_id != $id->matri_id)
                            <div class="col-xl-12">
                                <h6 class="inMT-75">Like this profile ? Connect Now</h6>
                            </div>
                            <div class="col-xl-12">
                               
                                <div class="row mt-4 inMainResultAction inMemberProfileAction mt-lg-2 mt-xl-3">
                                    <div class="col text-center">
                                        <form action="{{route('user.chatthreadpost',$register->id)}}">
                                            @csrf
                                            @if($id->status == "Paid")
                                                <button type="submit" value="Message" name="Message">
                                                    <i class="fas fa-envelope" aria-hidden="true"></i>
                                                    <p class="d-none d-lg-block">Message</p>
                                                </button>
                                            @else
                                                <a class="" value="Message" name="Message" onclick="$('#messagebox').toast('show');"><i class="fas fa-envelope"></i><p class="d-none d-lg-block">Message</p></a>
                                            @endif
                                        </form>
                                    </div>
                                    @if($intrest == 1)
                                        @if($intrestdata->receiver_response == "Pending")
                                            <div class="col text-center" id="interestremove">
                                                <a href="#" class="interest-remove" data-register-id="{{ $register->matri_id }}" @if($site_configs->interest_setting == "send_to_paid")@if($id->status == "Paid")onclick="$('#expremove').toast('show');"@else onclick="$('#upgrademember').toast('show');" @endif @else onclick="$('#expremove').toast('show');"@endif>
                                                    <i class="fas fa-heart" aria-hidden="true"></i>
                                                    <!--<p>Shortlist</p>-->
                                                    <p class="d-none d-lg-block">Remove Interest</p>
                                                </a>
                                            </div>
                                        @elseif($intrestdata->receiver_response == "Accept")
                                            <div class="col text-center" >
                                                <a>
                                                    <i class="fas fa-heart" aria-hidden="true"></i>
                                                    <!--<p>Shortlist</p>-->
                                                    <p class="d-none d-lg-block">Interest Accept</p>
                                                </a>
                                            </div>
                                        @else
                                            <div class="col text-center">
                                                <a>
                                                    <i class="fas fa-heart" aria-hidden="true"></i>
                                                    <!--<p>Shortlist</p>-->
                                                    <p class="d-none d-lg-block">Interest Reject </p>
                                                </a>
                                            </div>
                                        @endif
                                        @else
                                        <div class="col text-center" id="interestshow">
                                            <a href="#" @if($cansendinterest == 1)class="interest-send" @endif data-register-id="{{ $register->matri_id }}" @if($site_configs->interest_setting == "send_to_paid")@if($id->status == "Paid")onclick="$('#expsent').toast('show');"@else onclick="$('#upgrademember').toast('show');" @endif @else onclick="$('#expsent').toast('show');"@endif >
                                                <i class="fas fa-heart" aria-hidden="true"></i>
                                                <!--<p>Shortlist</p>-->
                                                <p class="d-none d-lg-block">Send Interest</p>
                                            </a>
                                        </div>
                                        @endif
                                        {{--  Interest button handel by ajax afetr click  --}}
                                        <div class="col text-center" id="interestremoveajax" style="display:none;">
                                            <a href="#" class="interest-remove" data-register-id="{{ $register->matri_id }}" onclick="$('#expremove').toast('show');">
                                                <i class="fas fa-heart" aria-hidden="true"></i>
                                                <!--<p>Shortlist</p>-->
                                                <p class="d-none d-lg-block">Remove Interest</p>
                                            </a>
                                        </div>
                                        <div class="col text-center" id="interestshowajax" style="display:none;">
                                            <a href="#" class="interest-send" data-register-id="{{ $register->matri_id }}" onclick="$('#expsent').toast('show');">
                                                <i class="fas fa-heart" aria-hidden="true"></i>
                                                <!--<p>Shortlist</p>-->
                                                <p class="d-none d-lg-block">Send Interest</p>
                                            </a>
                                        </div>
                                        {{-- end Interest button  --}}
                                        <div class="col text-center">
                                            <a href="" data-bs-toggle="modal" data-bs-target="#contactViewCheck">
                                                <i class="fas fa-phone" aria-hidden="true"></i>
                                                <p class="d-none d-lg-block">View Contact Details</p>
                                            </a>
                                        </div>
                                        @if($shortstatus == 1)
                                        <div class="col text-center" id="remove">
                                            <a href="#" class="shortlist-remove" data-register-id="{{ $register->matri_id }}" onclick="$('#removedsl').toast('show');">
                                                <i class="fas fa-list" aria-hidden="true"></i>
                                                <!--<p>Shortlist</p>-->
                                                <p class="d-none d-lg-block">Remove Shortlist</p>
                                            </a>
                                        </div>
                                        @else
                                        <div class="col text-center" id="show" >
                                            <a href="#" class="shortlist-link" data-register-id="{{ $register->matri_id }}" onclick="$('#shortlisted').toast('show');">
                                                <i class="fas fa-list" aria-hidden="true"></i>
                                                <!--<p>Shortlist</p>-->
                                                <p class="d-none d-lg-block">Add Shortlist</p>
                                            </a>
                                        </div>
                                        @endif

                                        {{-- shortlist button handel by ajax afetr click  --}}
                                        <div class="col text-center" id="reremove" style="display:none;">
                                            <a href="#" class="shortlist-remove" data-register-id="{{ $register->matri_id }}" onclick="$('#removedsl').toast('show');">
                                                <i class="fas fa-list" aria-hidden="true"></i>
                                                <p class="d-none d-lg-block">Remove Shortlist</p>
                                            </a>
                                        </div>
                                        
                                        <div class="col text-center"  id="reshow" style="display:none;">
                                            <a href="#" class="shortlist-link" data-register-id="{{ $register->matri_id }}" onclick="$('#shortlisted').toast('show');">
                                                <i class="fas fa-list" aria-hidden="true"></i>
                                                <p class="d-none d-lg-block">Add Shortlist</p>
                                            </a>
                                        </div>
                                    {{-- end short list button  --}}
                                    
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                </div>
                <div class="row">
            
            <div class="col-lg-12 col-md-12 mt-4">
                @if($register->gender == "Female")
                    <h4>About Her</h4>
                @else
                    <h4>About Him</h4>
                @endif
               
                <div class="card inBorderColor1 mb-4 inMemberDetCard">
                    <div class="card-header">
                        <h5><i class="fas fa-user pe-2"></i>Basic Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @if($profileviewsetting->username_setting == "full_username")
                                <div class="col-xl-6 col-lg-6 inMemTopBasicDet">
                                    <h5 class=""><span class="inMemDetMain pe-1">Full Name :</span><span class="ps-1 inMemDet">@if(isset($register->firstname)){{$register->firstname}}@endif @if(isset($register->lastname)){{$register->lastname}}@endif</span></h5>
                                </div>
                            @elseif($profileviewsetting->username_setting == "first_surname")
                                <div class="col-xl-6 col-lg-6 inMemTopBasicDet">
                                    <h5 class=""><span class="inMemDetMain pe-1">Full Name :</span><span class="ps-1 inMemDet">@if(isset($register->firstname)){{$register->firstname}}@endif @if(isset($register->lastname)){{substr($register->lastname, 0, 1)}}@endif</span></h5>
                                </div>
                            @else

                            @endif
                            <div class="col-xl-6 col-lg-6 inMemTopBasicDet">
                                 <h5 class=""><span class="inMemDetMain pe-1">Marital Status :</span><span class="ps-1 inMemDet">@if(isset($register->m_status)){{$register->m_status}}@else Not Available @endif</span></h5>
                            </div>
                            <div class="col-xl-6 col-lg-6 inMemTopBasicDet">
                                <h5 class=""><span class="inMemDetMain pe-1">No of Children :</span><span class="ps-1 inMemDet">@if(isset($register->tot_children)){{$register->tot_children}}@else Not Available @endif</span></h5>
                            </div>
                            <div class="col-xl-6 col-lg-6 inMemTopBasicDet">
                                 <h5 class=""><span class="inMemDetMain pe-1">Children Living Status :</span><span class="ps-1 inMemDet">@if(isset($register->status_children)){{$register->status_children}}@else Not Available @endif</span></h5>
                            </div>
                             <div class="col-xl-6 col-lg-6 inMemTopBasicDet">
                                <h5 class=""><span class="inMemDetMain pe-1">Mother Tongue :</span><span class="ps-1 inMemDet">@if(isset($register->m_tongue)){{$register->mother_tongue->mtongue_name}}@else Not Available @endif</span></h5>
                            </div>
                            <div class="col-xl-6 col-lg-6 inMemTopBasicDet">
                                 <h5 class=""><span class="inMemDetMain pe-1">Profile Created By :</span><span class="ps-1 inMemDet">@if(isset($register->profileby)){{$register->profileby}}@else Not Available @endif</span></h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card inBorderColor1 mb-4 inMemberDetCard">
                    <div class="card-header">
                        <h5><i class="fas fa-book pe-2"></i>Religion Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="row inMB-5">
                            <div class="col-xl-6 col-lg-6 inMemTopBasicDet">
                                <h5 class=""><span class="inMemDetMain pe-1">Religion :</span><span class="ps-1 inMemDet">@if(isset($register->religion)){{$register->rel->religion_name}}@else Not Available @endif</span></h5>
                            </div>
                            <div class="col-xl-6 col-lg-6 inMemTopBasicDet">
                                 <h5 class=""><span class="inMemDetMain pe-1">Caste :</span><span class="ps-1 inMemDet">@if(isset($register->caste)){{$register->cast->caste_name}}@else Not Available @endif</span></h5>
                            </div>
                            @if(!isset($fieldsetting->sub_caste) || $fieldsetting->sub_caste == "Yes" )
                            <div class="col-xl-6 col-lg-6 inMemTopBasicDet">
                                <h5 class=""><span class="inMemDetMain pe-1">Sub Caste :</span><span class="ps-1 inMemDet">@if(isset($register->subcaste)){{$register->subcast->sub_caste_name}}@else Not Available @endif</span></h5>
                            </div>
                            @endif
                            @if(!isset($fieldsetting->gotra) || $fieldsetting->gotra == "Yes" )
                            <div class="col-xl-6 col-lg-6 inMemTopBasicDet">
                                <h5 class=""><span class="inMemDetMain pe-1">Gotra :</span><span class="ps-1 inMemDet">@if(isset($gotra)){{$gotra->gotra_name}}@else Not Available @endif</span></h5>
                            </div>
                            @endif
                            @if(!isset($fieldsetting->will_to_marry) || $fieldsetting->will_to_marry == "Yes" )
                            <div class="col-xl-6 col-lg-6 inMemTopBasicDet">
                                 <h5 class=""><span class="inMemDetMain pe-1">Willing to marry other caste? :</span><span class="ps-1 inMemDet">@if(isset($register->will_to_mary_caste))@if($register->will_to_mary_caste = 1) Yes @else No @endif @else Not Available @endif</span></h5>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card inBorderColor1 mb-4 inMemberDetCard">
                    <div class="card-header">
                        <h5><i class="fas fa-graduation-cap pe-2"></i>Education / Occupation Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="row inMB-5">
                            <div class="col-xl-6 col-lg-6 inMemTopBasicDet">
                                <h5 class=""><span class="inMemDetMain pe-1">Highest Education :</span><span class="ps-1 inMemDet">{{$high_edu}}</span></h5>
                            </div>
                            @if(!isset($fieldsetting->additional_degree) || $fieldsetting->additional_degree == "Yes" )
                            <div class="col-xl-6 col-lg-6 inMemTopBasicDet">
                                 <h5 class=""><span class="inMemDetMain pe-1">Additional Degree :</span><span class="ps-1 inMemDet">{{$add_edu}}</span></h5>
                            </div>
                            @endif
                            <div class="col-xl-6 col-lg-6 inMemTopBasicDet">
                                <h5 class=""><span class="inMemDetMain pe-1">Employed in :</span><span class="ps-1 inMemDet">@if(isset($register->emp_in)){{$register->emp_in}}@else Not Available @endif</span></h5>
                            </div>
                            <div class="col-xl-6 col-lg-6 inMemTopBasicDet">
                                <h5 class=""><span class="inMemDetMain pe-1">Occupation :</span><span class="ps-1 inMemDet">@if(isset($register->occupation)){{$register->occ->ocp_name}}@else Not Available @endif</span></h5>
                            </div>
                            @if(!isset($fieldsetting->company_name) || $fieldsetting->company_name == "Yes" )
                            <div class="col-xl-6 col-lg-6 inMemTopBasicDet">
                                 <h5 class=""><span class="inMemDetMain pe-1">Company Name :</span><span class="ps-1 inMemDet">@if(isset($register->company_name)){{$register->company_name}}@else Not Available @endif</span></h5>
                            </div>
                            @endif
                            @if(!isset($fieldsetting->designation) || $fieldsetting->designation == "Yes" )
                            <div class="col-xl-6 col-lg-6 inMemTopBasicDet">
                                <h5 class=""><span class="inMemDetMain pe-1">Designation :</span><span class="ps-1 inMemDet">@if(isset($register->designation)){{$register->designation}}@else Not Available @endif</span></h5>
                            </div>
                            @endif
                            @if(!isset($fieldsetting->annual_income) || $fieldsetting->annual_income == "Yes" )
                            <div class="col-xl-6 col-lg-6 inMemTopBasicDet">
                                <h5 class=""><span class="inMemDetMain pe-1">Annual Income :</span><span class="ps-1 inMemDet">@if(isset($register->income)){{$register->inc->income}}@else Not Available @endif</span></h5>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @if(!isset($fieldsetting) || $fieldsetting->family_type == "Yes" || $fieldsetting->family_value == "Yes" || $fieldsetting->family_status == "Yes" || $fieldsetting->father_name == "Yes" || $fieldsetting->father_occupation == "Yes" || $fieldsetting->mother_name == "Yes" || $fieldsetting->mother_occupation == "Yes" || $fieldsetting->no_of_brothers == "Yes" || $fieldsetting->no_marri_brother == "Yes" || $fieldsetting->no_of_sisters == "Yes" || $fieldsetting->no_marri_sister == "Yes" || $fieldsetting->maternal_details == "Yes" || $fieldsetting->paternal_details == "Yes")
                <div class="card inBorderColor1 mb-4 inMemberDetCard">
                    <div class="card-header">
                        <h5><i class="fas fa-users pe-2"></i>Family Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="row inMB-5">
                            @if(!isset($fieldsetting->family_type) || $fieldsetting->family_type == "Yes" )
                            <div class="col-xl-6 col-lg-6 inMemTopBasicDet">
                                <h5 class=""><span class="inMemDetMain pe-1">Family Type :</span><span class="ps-1 inMemDet">@if(isset($register->family_type)){{$register->family_type}}@else Not Available @endif</span></h5>
                            </div>
                            @endif
                            @if(!isset($fieldsetting->family_value) || $fieldsetting->family_value == "Yes" )
                            <div class="col-xl-6 col-lg-6 inMemTopBasicDet">
                                <h5 class=""><span class="inMemDetMain pe-1">Family Value :</span><span class="ps-1 inMemDet">@if(isset($register->family_value)){{$register->family_value}}@else Not Available @endif</span></h5>
                           </div>
                           @endif
                           @if(!isset($fieldsetting->family_status) || $fieldsetting->family_status == "Yes" )
                           <div class="col-xl-6 col-lg-6 inMemTopBasicDet">
                               <h5 class=""><span class="inMemDetMain pe-1">Family Status :</span><span class="ps-1 inMemDet">@if(isset($register->family_status)){{$register->family_status}}@else Not Available @endif</span></h5>
                           </div>
                           @endif
                           @if(!isset($fieldsetting->father_name) || $fieldsetting->father_name == "Yes" )
                           <div class="col-xl-6 col-lg-6 inMemTopBasicDet">
                                <h5 class=""><span class="inMemDetMain pe-1">Father Name :</span><span class="ps-1 inMemDet">@if(isset($register->father_name)){{$register->father_name}}@else Not Available @endif</span></h5>
                           </div>
                           @endif
                           @if(!isset($fieldsetting->father_occupation) || $fieldsetting->father_occupation == "Yes" )
                           <div class="col-xl-6 col-lg-6 inMemTopBasicDet">
                               <h5 class=""><span class="inMemDetMain pe-1">Father Occupation :</span><span class="ps-1 inMemDet">@if(isset($register->father_occupation)){{$register->father_occupation}}@else Not Available @endif</span></h5>
                           </div>
                           @endif
                           @if(!isset($fieldsetting->mother_name) || $fieldsetting->mother_name == "Yes" )
                           <div class="col-xl-6 col-lg-6 inMemTopBasicDet">
                                <h5 class=""><span class="inMemDetMain pe-1">Mother Name :</span><span class="ps-1 inMemDet">@if(isset($register->mother_name)){{$register->mother_name}}@else Not Available @endif</span></h5>
                           </div>
                           @endif
                           @if(!isset($fieldsetting->mother_occupation) || $fieldsetting->mother_occupation == "Yes" )
                           <div class="col-xl-6 col-lg-6 inMemTopBasicDet">
                               <h5 class=""><span class="inMemDetMain pe-1">Mother Occupation :</span><span class="ps-1 inMemDet">@if(isset($register->mother_occupation)){{$register->mother_occupation}}@else Not Available @endif</span></h5>
                           </div>
                           @endif
                           @if(!isset($fieldsetting->no_of_brother) || $fieldsetting->no_of_brother == "Yes" )
                           <div class="col-xl-6 col-lg-6 inMemTopBasicDet">
                                <h5 class=""><span class="inMemDetMain pe-1">No of Brothers :</span><span class="ps-1 inMemDet">@if(isset($register->no_of_brothers)){{$register->no_of_brothers}}@else Not Available @endif</span></h5>
                           </div>
                           @endif
                           @if(!isset($fieldsetting->no_of_married_brother) || $fieldsetting->no_of_married_brother == "Yes" )
                           <div class="col-xl-6 col-lg-6 inMemTopBasicDet">
                               <h5 class=""><span class="inMemDetMain pe-1">No of Married Brothers :</span><span class="ps-1 inMemDet">@if(isset($register->no_marri_brother)){{$register->no_marri_brother}}@else Not Available @endif</span></h5>
                           </div>
                           @endif
                           @if(!isset($fieldsetting->no_of_sister) || $fieldsetting->no_of_sister == "Yes" )
                           <div class="col-xl-6 col-lg-6 inMemTopBasicDet">
                                <h5 class=""><span class="inMemDetMain pe-1">No of Sisters :</span><span class="ps-1 inMemDet">@if(isset($register->no_of_sisters)){{$register->no_of_sisters}}@else Not Available @endif</span></h5>
                           </div>
                           @endif
                           @if(!isset($fieldsetting->no_of_married_sister) || $fieldsetting->no_of_married_sister == "Yes" )
                           <div class="col-xl-6 col-lg-6 inMemTopBasicDet">
                               <h5 class=""><span class="inMemDetMain pe-1">No of Married Sisters :</span><span class="ps-1 inMemDet">@if(isset($register->no_marri_sister)){{$register->no_marri_sister}}@else Not Available @endif</span></h5>
                           </div>
                           @endif
                           @if(!isset($fieldsetting->maternal_details) || $fieldsetting->maternal_details == "Yes" )
                           <div class="col-xl-6 col-lg-6 inMemTopBasicDet">
                                <h5 class=""><span class="inMemDetMain pe-1">Maternal Details :</span><span class="ps-1 inMemDet">@if(isset($register->maternal_details)){{$register->maternal_details}}@else Not Available @endif</span></h5>
                           </div>
                           @endif
                           @if(!isset($fieldsetting->paternal_details) || $fieldsetting->paternal_details == "Yes" )
                           <div class="col-xl-6 col-lg-6 inMemTopBasicDet">
                                <h5 class=""><span class="inMemDetMain pe-1">Paternal Details :</span><span class="ps-1 inMemDet">@if(isset($register->paternal_details)){{$register->paternal_details}}@else Not Available @endif</span></h5>
                           </div>
                           @endif
                        </div>
                    </div>
                </div>
                @endif
                <div class="card inBorderColor1 mb-4 inMemberDetCard">
                    <div class="card-header">
                        <h5><i class="fas fa-globe pe-2"></i>Location Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="row inMB-5">
                            <div class="col-xl-6 col-lg-6 inMemTopBasicDet">
                                <h5 class=""><span class="inMemDetMain pe-1">Country :</span><span class="ps-1 inMemDet">@if(isset($register->country_id)){{$register->country->country_name}}@else Not Available @endif</span></h5>
                            </div>
                            <div class="col-xl-6 col-lg-6 inMemTopBasicDet">
                                 <h5 class=""><span class="inMemDetMain pe-1">State :</span><span class="ps-1 inMemDet">@if(isset($register->state_id)){{$register->state->state_name}}@else Not Available @endif</span></h5>
                            </div>
                            <div class="col-xl-6 col-lg-6 inMemTopBasicDet">
                                <h5 class=""><span class="inMemDetMain pe-1">City :</span><span class="ps-1 inMemDet">@if(isset($register->city)){{$register->citi->city_name}}@else Not Available @endif</span></h5>
                            </div>
                            
                        </div>
                    </div>
                </div>
                @if(!isset($fieldsetting) || $fieldsetting->diet == "Yes" || $fieldsetting->smoke == "Yes" || $fieldsetting->drink == "Yes")
                <div class="card inBorderColor1 mb-4 inMemberDetCard">
                    <div class="card-header">
                        <h5><i class="fas fa-wine-glass pe-2"></i>Habits & Hobbies</h5>
                    </div>
                    <div class="card-body">
                        <div class="row inMB-5">
                            @if(!isset($fieldsetting->diet) || $fieldsetting->diet == "Yes" )
                            <div class="col-xl-6 col-lg-6 inMemTopBasicDet">
                                <h5 class=""><span class="inMemDetMain pe-1">Eating Habits :</span><span class="ps-1 inMemDet">@if(isset($register->diet)){{$register->diet}}@else Not Available @endif</span></h5>
                            </div>
                            @endif
                            @if(!isset($fieldsetting->smoke) || $fieldsetting->smoke == "Yes" )
                            <div class="col-xl-6 col-lg-6 inMemTopBasicDet">
                                 <h5 class=""><span class="inMemDetMain pe-1">Drinking Habits :</span><span class="ps-1 inMemDet">@if(isset($register->drink)){{$register->drink}}@else Not Available @endif</span></h5>
                            </div>
                            @endif
                            @if(!isset($fieldsetting->drink) || $fieldsetting->drink == "Yes" )
                            <div class="col-xl-6 col-lg-6 inMemTopBasicDet">
                                <h5 class=""><span class="inMemDetMain pe-1">Smoking Habits :</span><span class="ps-1 inMemDet">@if(isset($register->smoke)){{$register->smoke}}@else Not Available @endif</span></h5>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
                @if(!isset($fieldsetting) || $fieldsetting->height == "Yes" || $fieldsetting->weight == "Yes" || $fieldsetting->body_type == "Yes" || $fieldsetting->complexion == "Yes" || $fieldsetting->physical_status == "Yes" || $fieldsetting->b_group == "Yes")
                <div class="card inBorderColor1 mb-4 inMemberDetCard">
                    <div class="card-header">
                        <h5><i class="fas fa-person pe-2"></i>Physical Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="row inMB-5">
                            @if(!isset($fieldsetting->height) || $fieldsetting->height == "Yes" )
                            <div class="col-xl-6 col-lg-6 inMemTopBasicDet">
                                <h5 class=""><span class="inMemDetMain pe-1">Height :</span><span class="ps-1 inMemDet">@if(isset($register->height)){{$register->hei->height}}@else Not Available @endif</span></h5>
                            </div>
                            @endif
                            @if(!isset($fieldsetting->weight) || $fieldsetting->weight == "Yes" )
                            <div class="col-xl-6 col-lg-6 inMemTopBasicDet">
                                 <h5 class=""><span class="inMemDetMain pe-1">Weight :</span><span class="ps-1 inMemDet">@if(isset($register->weight)){{$register->weight}}@else Not Available @endif</span></h5>
                            </div>
                            @endif
                            @if(!isset($fieldsetting->body_type) || $fieldsetting->body_type == "Yes" )
                            <div class="col-xl-6 col-lg-6 inMemTopBasicDet">
                                <h5 class=""><span class="inMemDetMain pe-1">Body Type :</span><span class="ps-1 inMemDet">@if(isset($register->bodytype)){{$register->bodytype}}@else Not Available @endif</span></h5>
                            </div>
                            @endif
                            @if(!isset($fieldsetting->complexion) || $fieldsetting->complexion == "Yes" )
                            <div class="col-xl-6 col-lg-6 inMemTopBasicDet">
                                 <h5 class=""><span class="inMemDetMain pe-1">Complexion :</span><span class="ps-1 inMemDet">@if(isset($register->complexion)){{$register->complexion}}@else Not Available @endif</span></h5>
                            </div>
                            @endif
                            @if(!isset($fieldsetting->physical_status) || $fieldsetting->physical_status == "Yes" )
                            <div class="col-xl-6 col-lg-6 inMemTopBasicDet">
                                <h5 class=""><span class="inMemDetMain pe-1">Physical Status :</span><span class="ps-1 inMemDet">@if(isset($register->physicalStatus)){{$register->physicalStatus}}@else Not Available @endif</span></h5>
                            </div>
                            @endif
                            @if(!isset($fieldsetting->b_group) || $fieldsetting->b_group == "Yes" )
                            <div class="col-xl-6 col-lg-6 inMemTopBasicDet">
                                 <h5 class=""><span class="inMemDetMain pe-1">Blood Group :</span><span class="ps-1 inMemDet">@if(isset($register->b_group)){{$register->b_group}}@else Not Available @endif</span></h5>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
                @if(!isset($fieldsetting) || $fieldsetting->dosh == "Yes" || $fieldsetting->manglik == "Yes" || $fieldsetting->rasi == "Yes" || $fieldsetting->star == "Yes" || $fieldsetting->birthtime == "Yes" || $fieldsetting->birthplace == "Yes")
                <div class="card inBorderColor1 mb-4 inMemberDetCard">
                    <div class="card-header">
                        <h5><i class="fas fa-star pe-2"></i>Horoscope Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="row inMB-5">
                            @if(!isset($fieldsetting->dosh) || $fieldsetting->dosh == "Yes" )
                            <div class="col-xl-6 col-lg-6 inMemTopBasicDet">
                                <h5 class=""><span class="inMemDetMain pe-1">Have Dosh :</span><span class="ps-1 inMemDet">@if(isset($register->dosh)){{$register->dosh}}@else Not Available @endif</span></h5>
                            </div>
                            @endif
                            @if(!isset($fieldsetting->manglik) || $fieldsetting->manglik == "Yes" )
                            <div class="col-xl-6 col-lg-6 inMemTopBasicDet">
                                 <h5 class=""><span class="inMemDetMain pe-1">Dosh Type :</span><span class="ps-1 inMemDet">@if(isset($register->manglik)){{$register->doshes->dosh}}@else Not Available @endif</span></h5>
                            </div>
                            @endif
                            @if(!isset($fieldsetting->rasi) || $fieldsetting->rasi == "Yes" )
                            <div class="col-xl-6 col-lg-6 inMemTopBasicDet">
                                <h5 class=""><span class="inMemDetMain pe-1">Rasi/Moonsign :</span><span class="ps-1 inMemDet">@if(isset($register->moonsign)){{$register->rashi->rasi}}@else Not Available @endif</span></h5>
                            </div>
                            @endif
                            @if(!isset($fieldsetting->star) || $fieldsetting->star == "Yes" )
                            <div class="col-xl-6 col-lg-6 inMemTopBasicDet">
                                 <h5 class=""><span class="inMemDetMain pe-1">Star :</span><span class="ps-1 inMemDet">@if(isset($register->star)){{$register->staars->star}}@else Not Available @endif</span></h5>
                            </div>
                            @endif
                            @if(!isset($fieldsetting->birthtime) || $fieldsetting->birthtime == "Yes" )
                            <div class="col-xl-6 col-lg-6 inMemTopBasicDet">
                                <h5 class=""><span class="inMemDetMain pe-1">Birth Time :</span><span class="ps-1 inMemDet">@if(isset($register->birthtime)){{\Carbon\Carbon::parse($register->birthtime)->format('g:i A')}}@else Not Available @endif</span></h5>
                            </div>
                            @endif
                            @if(!isset($fieldsetting->birthplace) || $fieldsetting->birthplace == "Yes" )
                            <div class="col-xl-6 col-lg-6 inMemTopBasicDet">
                                 <h5 class=""><span class="inMemDetMain pe-1">Birth Place :</span><span class="ps-1 inMemDet">@if(isset($register->birthplace)){{$register->birthplace}}@else Not Available @endif</span></h5>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
                @if(!isset($fieldsetting->profile_text) || $fieldsetting->profile_text == "Yes" )
                <div class="card inBorderColor1 mb-4 inMemberDetCard">
                    <div class="card-header">
                        <h5><i class="fas fa-user pe-2"></i>About</h5>
                    </div>
                    <div class="card-body">
                        <div class="row inMB-5">
                            <div class="col-xl-12 inMemTopBasicDet">
                                <h5 class=""><span class="inMemDetMain pe-1">About :</span><span class="ps-1 inMemDet">@if(isset($register->profile_text))@if($register->profile_text_approve == "APPROVED"){{$register->profile_text}}@elseif($register->profile_text_approve == "UNAPPROVED") Unapproved @else Approval Pending @endif @else Not Available @endif</span></h5>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <div class="col-12 inEditPrefPartHeader text-center">
                    <h3><i class="fas fa-heart pe-2" aria-hidden="true"></i>Partner Preference</h3>
                </div>
                <div class="col-12 mb-4 mt-4">
                    <div class="row">
                        <div class="col-xl-8 offset-xl-2">
                            <div class="row">
                                <div class="col-3">
                                    <?php  $auth_user = Auth::guard('user')->user(); ?>
                                    <center>
                                        @if(isset($auth_user))
                                            
                                            @php $filePath = '/userImages/'. $auth_user->photo1;  @endphp
                                            @if($auth_user->photo1 != "" && $auth_user->photo1_approve == "APPROVED" && (($auth_user->photo_setting == '0') || ($auth_user->photo_setting == '1' && Auth::guard('user')->user()->status == 'Paid') || ($auth_user->photo_setting == '2' && $status->receiver_response == "Accept" )) && Storage::disk('public')->exists($filePath))
                                        
                                            <img src="{{asset('storage/userImages/'.$auth_user->photo1)}}" class="avtar80 img-fluid">
                                            @elseif($auth_user->photo1 != ""  && $auth_user->gender == "Female" && $auth_user->photo1_approve == "PENDING" && Storage::disk('public')->exists($filePath))
                                                <img src="{{asset('user/img/femalepending.jpg')}}" class="avtar80 img-fluid">
                                            @elseif($auth_user->photo1 != ""  && $auth_user->gender == "Male" && $auth_user->photo1_approve == "PENDING" && Storage::disk('public')->exists($filePath))
                                                <img src="{{asset('user/img/malepending.jpg')}}" class="avtar80 img-fluid">
                                            @else
                                                @if($auth_user->gender == "Male")
                                                    <img src="{{asset('user/img/male.jpg')}}" class="avtar80 img-fluid">
                                                @else
                                                    <img src="{{asset('user/img/female.jpg')}}" class="avtar80 img-fluid">
                                                @endif
                                            @endif
                                        @endif
                                    </center>
                                </div>
                                    <div class="col-6 pt-2">
                                        <h6 class="text-center">Match Score is  @if($register->matri_id != $id->matri_id){{$finalmatchpercentage}}@else 0 @endif%</h6>
                                        <div class="progress">
                                            <div class="progress-bar bgSecondary" role="progressbar" style="width: @if($register->matri_id != $id->matri_id){{$finalmatchpercentage}}@else 0 @endif%" aria-valuenow="@if($register->matri_id != $id->matri_id){{$finalmatchpercentage}}@else 0 @endif" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                
                                <div class="col-3">
                                    <center>
                                        @if(isset($register))
                                            <?php  $filePath = '/userImages/'.$register->photo1; ?>
                                            @if($register->photo1 != "" && $register->photo1_approve == "APPROVED" && Storage::disk('public')->exists($filePath))
                                                <img src="{{asset('storage/userImages/'.$register->photo1)}}" class="avtar80 img-fluid">
                                            @elseif($register->photo1 != ""  && $register->gender == "Female" && $register->photo1_approve == "PENDING" && Storage::disk('public')->exists($filePath))
                                                <img src="{{asset('user/img/femalepending.jpg')}}" class="avtar80 img-fluid">
                                            @elseif($register->photo1 != ""  && $register->gender == "Male" && $register->photo1_approve == "PENDING" && Storage::disk('public')->exists($filePath))
                                                <img src="{{asset('user/img/malepending.jpg')}}" class="avtar80 img-fluid">
                                            @else
                                                @if($register->gender == "Male")
                                                    <img src="{{asset('user/img/male.jpg')}}" class="avtar80 img-fluid">
                                                @else
                                                    <img src="{{asset('user/img/female.jpg')}}" class="avtar80 img-fluid">
                                                @endif
                                            @endif
                                        @endif
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card inBorderColor1 mb-4 inMemberDetCard">
                    <div class="card-header">
                        <h5><i class="fas fa-user pe-2"></i>Basic Preference</h5>
                    </div>
                    <div class="card-body">
                        <div class="row inMB-5">
                            <div class="col-xl-12 inMemTopBasicDet">
                                <div class="row">
                                    @if($ismatchm_status != 0)
                                        @if($register->matri_id != $id->matri_id)
                                        <div class="col-1 col-xl-1">
                                            <i class="fas fa-check-circle text-success"></i>
                                        </div>
                                        @else
                                        <div class="col-1 col-xl-1">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        @endif
                                    @else
                                    <div class="col-1 col-xl-1">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    @endif
                                    <div class="col-5 col-xl-3">
                                        <h5 class="inMemDetMain">Marital Status</h5>
                                    </div>
                                    <div class="col-6 col-xl-8">
                                        <h5 class="inMemDet">@if(isset($register->looking_for)){{$register->looking_for}}@else Not Available @endif</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 inMemTopBasicDet">
                                <div class="row">
                                   
                                    @if($isMatchage != 0)
                                        @if($register->matri_id != $id->matri_id)
                                        <div class="col-1 col-xl-1">
                                            <i class="fas fa-check-circle text-success"></i>
                                        </div>
                                        @else
                                        <div class="col-1 col-xl-1">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        @endif
                                    @else
                                    <div class="col-1 col-xl-1">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    @endif
                                    <div class="col-5 col-xl-3">
                                        <h5 class="inMemDetMain">Age</h5>
                                    </div>
                                    <div class="col-6 col-xl-8">
                                        <h5 class="inMemDet">@if(isset($register->part_frm_age)){{$register->age_from->age}} Yrs To {{$register->age_to->age}} Yrs @else Not Available @endif</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 inMemTopBasicDet">
                                <div class="row">
                                    @if($isMatchheight != 0)
                                        @if($register->matri_id != $id->matri_id)
                                        <div class="col-1 col-xl-1">
                                            <i class="fas fa-check-circle text-success"></i>
                                        </div>
                                        @else
                                        <div class="col-1 col-xl-1">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        @endif
                                    @else
                                    <div class="col-1 col-xl-1">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    @endif
                                    <div class="col-5 col-xl-3">
                                        <h5 class="inMemDetMain">Height</h5>
                                    </div>
                                    <div class="col-6 col-xl-8">
                                        <h5 class="inMemDet">@if(isset($register->part_height)){{$register->part_from_hei->height}} To {{$register->part_to_hei->height}} @else Not Available @endif</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 inMemTopBasicDet">
                                <div class="row">
                                    @if($isMatchmother_tongue != 0)
                                        @if($register->matri_id != $id->matri_id)
                                        <div class="col-1 col-xl-1">
                                            <i class="fas fa-check-circle text-success"></i>
                                        </div>
                                        @else
                                        <div class="col-1 col-xl-1">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        @endif
                                    @else
                                    <div class="col-1 col-xl-1">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    @endif
                                    <div class="col-5 col-xl-3">
                                        <h5 class="inMemDetMain">Mother Tongue</h5>
                                    </div>
                                    <div class="col-6 col-xl-8">
                                        <h5 class="inMemDet">@if(isset($register->part_mtongue)) @foreach($mtongue as $item){{$item}}{{ $loop->last ? '' : ', ' }}@endforeach @else Not Available @endif</h5>
                                    </div>
                                </div>
                            </div>
                            @if(!isset($fieldsetting->part_physical_status) || $fieldsetting->part_physical_status == "Yes" )
                            <div class="col-xl-12 inMemTopBasicDet">
                                <div class="row">
                                    @if($isMatch_physical != 0)
                                        @if($register->matri_id != $id->matri_id)
                                        <div class="col-1 col-xl-1">
                                            <i class="fas fa-check-circle text-success"></i>
                                        </div>
                                        @else
                                        <div class="col-1 col-xl-1">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        @endif
                                    @else
                                    <div class="col-1 col-xl-1">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    @endif
                                    <div class="col-5 col-xl-3">
                                        <h5 class="inMemDetMain">Physical Status</h5>
                                    </div>
                                    <div class="col-6 col-xl-8">
                                        <h5 class="inMemDet">@if(isset($register->part_physical)){{$register->part_physical}}@else Not Available @endif</h5>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if(!isset($fieldsetting->part_complexation) || $fieldsetting->part_complexation == "Yes" )
                            <div class="col-xl-12 inMemTopBasicDet">
                                <div class="row">
                                    @if($isMatch_complexion != 0)
                                        @if($register->matri_id != $id->matri_id)
                                        <div class="col-1 col-xl-1">
                                            <i class="fas fa-check-circle text-success"></i>
                                        </div>
                                        @else
                                        <div class="col-1 col-xl-1">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        @endif
                                    @else
                                    <div class="col-1 col-xl-1">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    @endif
                                    <div class="col-5 col-xl-3">
                                        <h5 class="inMemDetMain">Complexion</h5>
                                    </div>
                                    <div class="col-6 col-xl-8">
                                        <h5 class="inMemDet">@if(isset($register->part_complexation)){{$register->part_complexation}}@else Not Available @endif</h5>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if(!isset($fieldsetting->part_bodytype) || $fieldsetting->part_bodytype == "Yes" )
                            <div class="col-xl-12 inMemTopBasicDet">
                                <div class="row">
                                    @if($isMatch_bodytype != 0)
                                        @if($register->matri_id != $id->matri_id)
                                        <div class="col-1 col-xl-1">
                                            <i class="fas fa-check-circle text-success"></i>
                                        </div>
                                        @else
                                        <div class="col-1 col-xl-1">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        @endif
                                    @else
                                    <div class="col-1 col-xl-1">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    @endif
                                    <div class="col-5 col-xl-3">
                                        <h5 class="inMemDetMain">Body Type</h5>
                                    </div>
                                    <div class="col-6 col-xl-8">
                                        <h5 class="inMemDet">@if(isset($register->part_bodytype)){{$register->part_bodytype}}@else Not Available @endif</h5>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                        
                    </div>
                </div>
                @if(!isset($fieldsetting) && $fieldsetting->part_diet == "Yes" || $fieldsetting->part_smoke == "Yes" || $fieldsetting->part_drink == "Yes")
                <div class="card inBorderColor1 mb-4 inMemberDetCard">
                    <div class="card-header">
                        <h5><i class="fas fa-wine-glass pe-2"></i>Habit Preference</h5>
                    </div>
                   
                    <div class="card-body">
                        <div class="row inMB-5">
                            @if(!isset($fieldsetting->part_diet) || $fieldsetting->part_diet == "Yes" )
                            <div class="col-xl-12 inMemTopBasicDet">
                                <div class="row">
                                    @if($isMatch_diet != 0)
                                        @if($register->matri_id != $id->matri_id)
                                        <div class="col-1 col-xl-1">
                                            <i class="fas fa-check-circle text-success"></i>
                                        </div>
                                        @else
                                        <div class="col-1 col-xl-1">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        @endif
                                    @else
                                    <div class="col-1 col-xl-1">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    @endif
                                    <div class="col-5">
                                        <h5 class="inMemDetMain">Eating Habit</h5>
                                    </div>
                                    <div class="col">
                                        <h5 class="inMemDet">@if(isset($register->part_diet)){{$register->part_diet}}@else Not Available @endif</h5>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if(!isset($fieldsetting->part_smoke) || $fieldsetting->part_smoke == "Yes" )
                            <div class="col-xl-12 inMemTopBasicDet">
                                <div class="row">
                                    @if($isMatch_smoke != 0)
                                        @if($register->matri_id != $id->matri_id)
                                        <div class="col-1 col-xl-1">
                                            <i class="fas fa-check-circle text-success"></i>
                                        </div>
                                        @else
                                        <div class="col-1 col-xl-1">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        @endif
                                    @else
                                    <div class="col-1 col-xl-1">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    @endif
                                    <div class="col-5">
                                        <h5 class="inMemDetMain">Smoking Habit</h5>
                                    </div>
                                    <div class="col">
                                        <h5 class="inMemDet">@if(isset($register->part_smoke)){{$register->part_smoke}}@else Not Available @endif</h5>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if(!isset($fieldsetting->part_drink) || $fieldsetting->part_drink == "Yes")
                            <div class="col-xl-12 inMemTopBasicDet">
                                <div class="row">
                                    @if($isMatch_drink != 0)
                                        @if($register->matri_id != $id->matri_id)
                                        <div class="col-1 col-xl-1">
                                            <i class="fas fa-check-circle text-success"></i>
                                        </div>
                                        @else
                                        <div class="col-1 col-xl-1">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        @endif
                                    @else
                                    <div class="col-1 col-xl-1">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    @endif
                                    <div class="col-5">
                                        <h5 class="inMemDetMain">Drinking Habit</h5>
                                    </div>
                                    <div class="col">
                                        <h5 class="inMemDet">@if(isset($register->part_drink)){{$register->part_drink}}@else Not Available @endif</h5>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
                <div class="card inBorderColor1 mb-4 inMemberDetCard">
                    <div class="card-header">
                        <h5><i class="fas fa-graduation-cap pe-2"></i>Education & Occupation Preference</h5>
                    </div>
                    <div class="card-body">
                        <div class="row inMB-5">
                            <div class="col-xl-12 inMemTopBasicDet">
                                <div class="row">
                                    @if($isMatchedudetail != 0)
                                        @if($register->matri_id != $id->matri_id)
                                        <div class="col-1 col-xl-1">
                                            <i class="fas fa-check-circle text-success"></i>
                                        </div>
                                        @else
                                        <div class="col-1 col-xl-1">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        @endif
                                    @else
                                    <div class="col-1 col-xl-1">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    @endif
                                    <div class="col-5">
                                        <h5 class="inMemDetMain">Education</h5>
                                    </div>
                                    <div class="col">
                                        <h5 class="inMemDet">@if(isset($register->part_edu))@foreach ($edu as $item){{$item}}{{ $loop->last ? '' : ', ' }}@endforeach @else Not Available @endif</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 inMemTopBasicDet">
                                <div class="row">
                                    @if($isMatchoccu != 0)
                                        @if($register->matri_id != $id->matri_id)
                                        <div class="col-1 col-xl-1">
                                            <i class="fas fa-check-circle text-success"></i>
                                        </div>
                                        @else
                                        <div class="col-1 col-xl-1">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        @endif
                                    @else
                                    <div class="col-1 col-xl-1">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    @endif
                                    <div class="col-5">
                                        <h5 class="inMemDetMain">Occupation</h5>
                                    </div>
                                    <div class="col">
                                        <h5 class="inMemDet">@if(isset($register->part_occu))@foreach ($occ as $item){{$item}}{{ $loop->last ? '' : ', ' }}@endforeach @else Not Available @endif</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 inMemTopBasicDet">
                                <div class="row">
                                    @if($isMatch_emp_in != 0)
                                        @if($register->matri_id != $id->matri_id)
                                        <div class="col-1 col-xl-1">
                                            <i class="fas fa-check-circle text-success"></i>
                                        </div>
                                        @else
                                        <div class="col-1 col-xl-1">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        @endif
                                    @else
                                    <div class="col-1 col-xl-1">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    @endif
                                    <div class="col-5">
                                        <h5 class="inMemDetMain">Employed in</h5>
                                    </div>
                                    <div class="col">
                                        <h5 class="inMemDet">@if(isset($register->part_emp_in)){{$register->part_emp_in}} @else Not Available @endif</h5>
                                    </div>
                                </div>
                            </div>
                            @if(!isset($fieldsetting->part_annual_income) || $fieldsetting->part_annual_income == "Yes" )
                            <div class="col-xl-12 inMemTopBasicDet">
                                <div class="row">
                                    @if($isMatch_income != 0)
                                        @if($register->matri_id != $id->matri_id)
                                        <div class="col-1 col-xl-1">
                                            <i class="fas fa-check-circle text-success"></i>
                                        </div>
                                        @else
                                        <div class="col-1 col-xl-1">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        @endif
                                    @else
                                    <div class="col-1 col-xl-1">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    @endif
                                    <div class="col-5">
                                        <h5 class="inMemDetMain">Annual Income</h5>
                                    </div>
                                    <div class="col">
                                        <h5 class="inMemDet">@if(isset($register->part_income))@foreach ($inc as $item){{$item}}{{ $loop->last ? '' : ', ' }}@endforeach @else Not Available @endif</h5>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card inBorderColor1 mb-4 inMemberDetCard">
                    <div class="card-header">
                        <h5><i class="fas fa-book pe-2"></i>Religion Preference</h5>
                    </div>
                    <div class="card-body">
                        <div class="row inMB-5">
                            <div class="col-xl-12 inMemTopBasicDet">
                                <div class="row">
                                    @if($isMatch_religion != 0)
                                        @if($register->matri_id != $id->matri_id)
                                        <div class="col-1 col-xl-1">
                                            <i class="fas fa-check-circle text-success"></i>
                                        </div>
                                        @else
                                        <div class="col-1 col-xl-1">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        @endif
                                    @else
                                    <div class="col-1 col-xl-1">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    @endif
                                    <div class="col-5">
                                        <h5 class="inMemDetMain">Religion</h5>
                                    </div>
                                    <div class="col">
                                        <h5 class="inMemDet">@if(isset($register->part_religion))@foreach ($religion as $item){{$item}}{{ $loop->last ? '' : ', ' }}@endforeach @else Not Available @endif</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 inMemTopBasicDet">
                                <div class="row">
                                    @if($isMatch_caste != 0)
                                        @if($register->matri_id != $id->matri_id)
                                        <div class="col-1 col-xl-1">
                                            <i class="fas fa-check-circle text-success"></i>
                                        </div>
                                        @else
                                        <div class="col-1 col-xl-1">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        @endif
                                    @else
                                    <div class="col-1 col-xl-1">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    @endif
                                    <div class="col-5">
                                        <h5 class="inMemDetMain">Caste</h5>
                                    </div>
                                    <div class="col">
                                        <h5 class="inMemDet">@if(isset($register->part_caste))@foreach ($caste as $item){{$item}}{{ $loop->last ? '' : ', ' }}@endforeach @else Not Available @endif</h5>
                                    </div>
                                </div>
                            </div>
                            @if(!isset($fieldsetting->part_star) || $fieldsetting->part_star == "Yes" )
                            <div class="col-xl-12 inMemTopBasicDet">
                                <div class="row">
                                    @if($isMatchstar != 0)
                                        @if($register->matri_id != $id->matri_id)
                                        <div class="col-1 col-xl-1">
                                            <i class="fas fa-check-circle text-success"></i>
                                        </div>
                                        @else
                                        <div class="col-1 col-xl-1">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        @endif
                                    @else
                                    <div class="col-1 col-xl-1">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    @endif
                                    <div class="col-5">
                                        <h5 class="inMemDetMain">Star</h5>
                                    </div>
                                    <div class="col">
                                        <h5 class="inMemDet">@if(isset($register->part_star))@foreach ($star as $item){{$item}}{{ $loop->last ? '' : ', ' }}@endforeach @else Not Available @endif</h5>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if(!isset($fieldsetting->part_rasi) || $fieldsetting->part_rasi == "Yes" )
                            <div class="col-xl-12 inMemTopBasicDet">
                                <div class="row">
                                    @if($isMatch_moonsign != 0)
                                        @if($register->matri_id != $id->matri_id)
                                        <div class="col-1 col-xl-1">
                                            <i class="fas fa-check-circle text-success"></i>
                                        </div>
                                        @else
                                        <div class="col-1 col-xl-1">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        @endif
                                    @else
                                    <div class="col-1 col-xl-1">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    @endif
                                    <div class="col-5">
                                        <h5 class="inMemDetMain">Rasi/Moonsign</h5>
                                    </div>
                                    <div class="col">
                                        <h5 class="inMemDet">@if(isset($register->part_rasi))@foreach ($rasi as $item){{$item}}{{ $loop->last ? '' : ', ' }}@endforeach @else Not Available @endif</h5>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if(!isset($fieldsetting->part_dosh) || $fieldsetting->part_dosh == "Yes" )
                            <div class="col-xl-12 inMemTopBasicDet">
                                <div class="row">
                                    @if($isMatch_dosh != 0)
                                        @if($register->matri_id != $id->matri_id)
                                        <div class="col-1 col-xl-1">
                                            <i class="fas fa-check-circle text-success"></i>
                                        </div>
                                        @else
                                        <div class="col-1 col-xl-1">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        @endif
                                    @else
                                    <div class="col-1 col-xl-1">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    @endif
                                    <div class="col-5">
                                        <h5 class="inMemDetMain">Have Dosh?</h5>
                                    </div>
                                    <div class="col">
                                        <h5 class="inMemDet">@if(isset($register->part_dosh)){{$register->part_dosh }}@else Not Available @endif</h5>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if(!isset($fieldsetting->part_manglik) || $fieldsetting->part_manglik == "Yes" )
                            <div class="col-xl-12 inMemTopBasicDet">
                                <div class="row">
                                    @if($isMatch_manglik != 0)
                                        @if($register->matri_id != $id->matri_id)
                                        <div class="col-1 col-xl-1">
                                            <i class="fas fa-check-circle text-success"></i>
                                        </div>
                                        @else
                                        <div class="col-1 col-xl-1">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        @endif
                                    @else
                                    <div class="col-1 col-xl-1">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    @endif
                                    <div class="col-5">
                                        <h5 class="inMemDetMain">Dosh Type</h5>
                                    </div>
                                    <div class="col">
                                        <h5 class="inMemDet">@if(isset($register->part_manglik))@foreach ($dosh as $item){{$item}}{{ $loop->last ? '' : ', ' }}@endforeach @else Not Available @endif</h5>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card inBorderColor1 mb-4 inMemberDetCard">
                    <div class="card-header">
                        <h5><i class="fas fa-globe pe-2"></i>Location Preference</h5>
                    </div>
                    <div class="card-body">
                        <div class="row inMB-5">
                            <div class="col-xl-12 inMemTopBasicDet">
                                <div class="row">
                                    @if($isMatch_country != 0)
                                        @if($register->matri_id != $id->matri_id)
                                        <div class="col-1 col-xl-1">
                                            <i class="fas fa-check-circle text-success"></i>
                                        </div>
                                        @else
                                        <div class="col-1 col-xl-1">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        @endif
                                    @else
                                    <div class="col-1 col-xl-1">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    @endif
                                    <div class="col-5">
                                        <h5 class="inMemDetMain">Country</h5>
                                    </div>
                                    <div class="col">
                                        <h5 class="inMemDet">@if(isset($register->part_country_living)) @foreach ($country as $item){{$item}}{{ $loop->last ? '' : ', ' }}@endforeach @else Not Available @endif</h5>
                                    </div>
                                </div>
                            </div>
                            @if(!isset($fieldsetting->part_state) || $fieldsetting->part_state == "Yes" )
                            <div class="col-xl-12 inMemTopBasicDet">
                                <div class="row">
                                    @if($isMatch_state != 0)
                                        @if($register->matri_id != $id->matri_id)
                                        <div class="col-1 col-xl-1">
                                            <i class="fas fa-check-circle text-success"></i>
                                        </div>
                                        @else
                                        <div class="col-1 col-xl-1">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        @endif
                                    @else
                                    <div class="col-1 col-xl-1">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    @endif
                                    <div class="col-5">
                                        <h5 class="inMemDetMain">State</h5>
                                    </div>
                                    <div class="col">
                                        <h5 class="inMemDet">@if(isset($register->part_state)) @foreach ($state as $item){{$item}}{{ $loop->last ? '' : ', ' }}@endforeach @else Not Available @endif</h5>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if(!isset($fieldsetting->part_city) || $fieldsetting->part_city == "Yes" )
                            <div class="col-xl-12 inMemTopBasicDet">
                                <div class="row">
                                    @if($isMatch_city != 0)
                                        @if($register->matri_id != $id->matri_id)
                                        <div class="col-1 col-xl-1">
                                            <i class="fas fa-check-circle text-success"></i>
                                        </div>
                                        @else
                                        <div class="col-1 col-xl-1">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        @endif
                                    @else
                                    <div class="col-1 col-xl-1">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    @endif
                                    <div class="col-5">
                                        <h5 class="inMemDetMain">City</h5>
                                    </div>
                                    <div class="col">
                                        <h5 class="inMemDet">@if(isset($register->part_city)) @foreach ($city as $item){{$item}}{{ $loop->last ? '' : ', ' }}@endforeach @else Not Available @endif</h5>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @if(!isset($fieldsetting->part_expect) || $fieldsetting->part_expect == "Yes" )
                <div class="card inBorderColor1 mb-4 inMemberDetCard">
                    <div class="card-header">
                        <h5><i class="fas fa-users pe-2"></i>Partner Expectation</h5>
                    </div>
                    <div class="card-body">
                        <div class="row inMB-5">
                            <div class="col-xl-12 inMemTopBasicDet">
                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="inMemDetMain">@if(isset($register->part_expect))@if($register->part_expect_approve == "APPROVED"){{$register->part_expect}}@elseif($register->part_expect_approve == "UNAPPROVED") Unapproved @else Approval Pending @endif @else Not Available @endif</h5>
                                    </div>  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
            </div>
           
        </div>
        
    </div>
    <?php 
        $id = Auth::guard('user')->user(); 
        $payment = DB::table('payments')->where('pmatri_id',$id->matri_id)->OrderBy('created_at', 'desc')->first();
        $remaning_contact = "";
        if($payment != null)
        {
            $remaning_contact = $payment->p_no_contacts - $payment->r_cnt ;
        }
    ?>
    @if($id->status == "Paid" && $payment != null)
        
        <div class="modal fade" id="contactViewCheck" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Contact Balance</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                @if($remaning_contact == 0)
                                    <p>Contact View Blance Is Over</p>
                                @endif
                                <h3>Remaining Contact View</h3>
                                <h4>@if($remaning_contact > 0){{ $remaning_contact }}@else{{ "0" }}@endif | <b>{{$payment->p_no_contacts}}</b></h4>
                                <p>Want to check contact details of this user?</p>
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <button class="btn btnPrimary d-block w-100" data-bs-target="#contactDetails" data-bs-toggle="modal" data-bs-dismiss="modal">Yes</button>
                            </div>
                            <div class="col-6">
                                <button class="btn btnSecondary d-block w-100" data-bs-dismiss="modal">No</button>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    @else
        <div class="modal fade" id="contactViewCheck" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Upgrade Membership Plan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <p>Please Upgrade Your Membership Plan</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <a href="{{route('user.userMembershipPlans')}}" class="btn btnPrimary d-block w-100">Membership Plans</a>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    @endif
    
    <!-- No of remaining contact check modal -->
    
    @if($remaning_contact != 0 && $id->status == "Paid")
        @if($remaning_contact > 0)
            {{-- show to paid = 1  && Show To Express Interest Accepted & Paid Members == 0 --}}
            @if($register->contact_view_security == "0")
            
                @if(isset($expressInterests->receiver_response))
                    @if($expressInterests->receiver_response == "Accept")
                    
                    <!-- contact Details modal -->
                    <div class="modal fade" id="contactDetails" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Remaing Contact View Balance -( {{$remaning_contact}} | {{$payment->p_no_contacts}} )</h5>
                                    <button type="button" id="showcontactdetails" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <input type="hidden" id="matriIdValue" value="{{$register->matri_id}}">

                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 inMemTopBasicDet">
                                            <h5 class=""><span class="inMemDetMain pe-1">FullName:</span><span class="ps-1 inMemDet">@if(isset($register->firstname)){{$register->firstname}}@endif @if(isset($register->lastname)){{$register->lastname}}@endif</span></h5>
                                        </div>
                                        <div class="col-xl-12 col-lg-12 inMemTopBasicDet">
                                            <h5 class=""><span class="inMemDetMain pe-1">Matri ID :</span><span class="ps-1 inMemDet">@if(isset($register->matri_id)){{$register->matri_id}}@endif</span></h5>
                                        </div>
                                        <div class="col-xl-12 col-lg-12 inMemTopBasicDet">
                                            <h5 class=""><span class="inMemDetMain pe-1">Mobile No :</span><span class="ps-1 inMemDet">@if(isset($register->mobile)){{$register->mobile}}@endif</span></h5>
                                        </div>
                                        <div class="col-xl-12 col-lg-12 inMemTopBasicDet">
                                            <h5 class=""><span class="inMemDetMain pe-1">Email Id :</span><span class="ps-1 inMemDet">@if(isset($register->email)){{$register->email}}@endif</span></h5>
                                        </div>
                                        <div class="col-xl-12 col-lg-12 inMemTopBasicDet">
                                            <h5 class=""><span class="inMemDetMain pe-1">Birth Date :</span><span class="ps-1 inMemDet">@if(isset($register->birthdate)){{date('jS F Y', strtotime($register->birthdate))}}@endif</span></h5>
                                        </div>
                                        @if(!isset($fieldsetting->address) || $fieldsetting->address == "Yes" )
                                        <div class="col-xl-12 col-lg-12 inMemTopBasicDet">
                                            <h5 class=""><span class="inMemDetMain pe-1">Address :</span><span class="ps-1 inMemDet">@if(isset($register->address)){{ $register->address }}@else Not Available @endif</span></h5>
                                        </div>
                                        @endif                                        
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <button type="button" id="showcontactdetails2" class="btn btnSecondary d-block w-100" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @elseif($expressInterests->receiver_response == "Pending")
                    <div class="modal fade" id="contactDetails" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <p>Your express interest request is pending you can check this users contact details once user accept it.</p>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    @elseif ($expressInterests->receiver_response == "Rejected")
                    <div class="modal fade" id="contactDetails" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <p>Your express interest request is rejected you can not check this users contact details.</p>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    @endif
                @else
                    <div class="modal fade" id="contactDetails" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <p>Only express interest accepted can check contact details.</p>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                @endif
            @else
            <div class="modal fade" id="contactDetails" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Remaing Contact View Balance -( @if($remaning_contact > 0){{ $remaning_contact }}@else{{ "0" }}@endif | @if(isset($payment->p_no_contacts)){{$payment->p_no_contacts}}@endif )</h5>
                            <button type="button" id="showcontactdetails" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <input type="hidden" id="matriIdValue" value="{{$register->matri_id}}">

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 inMemTopBasicDet">
                                    <h5 class=""><span class="inMemDetMain pe-1">FullName:</span><span class="ps-1 inMemDet">@if(isset($register->firstname)){{$register->firstname}}@endif @if(isset($register->lastname)){{$register->lastname}}@endif</span></h5>
                                </div>
                                <div class="col-xl-12 col-lg-12 inMemTopBasicDet">
                                    <h5 class=""><span class="inMemDetMain pe-1">Matri ID :</span><span class="ps-1 inMemDet">@if(isset($register->matri_id)){{$register->matri_id}}@endif</span></h5>
                                </div>
                                <div class="col-xl-12 col-lg-12 inMemTopBasicDet">
                                    <h5 class=""><span class="inMemDetMain pe-1">Mobile No :</span><span class="ps-1 inMemDet">@if(isset($register->mobile)){{$register->mobile}}@endif</span></h5>
                                </div>
                                <div class="col-xl-12 col-lg-12 inMemTopBasicDet">
                                    <h5 class=""><span class="inMemDetMain pe-1">Email Id :</span><span class="ps-1 inMemDet">@if(isset($register->email)){{$register->email}}@endif</span></h5>
                                </div>
                                <div class="col-xl-12 col-lg-12 inMemTopBasicDet">
                                    <h5 class=""><span class="inMemDetMain pe-1">Birth Date :</span><span class="ps-1 inMemDet">@if(isset($register->birthdate)){{date('jS F Y', strtotime($register->birthdate))}}@endif</span></h5>
                                </div>
                                @if(!isset($fieldsetting->address) || $fieldsetting->address == "Yes" )
                                <div class="col-xl-12 col-lg-12 inMemTopBasicDet">
                                    <h5 class=""><span class="inMemDetMain pe-1">Address :</span><span class="ps-1 inMemDet">@if(isset($register->address)){{ $register->address }}@else Not Available @endif</span></h5>
                                </div>
                                @endif 
                            </div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <button type="button" id="showcontactdetails2" class="btn btnSecondary d-block w-100" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @else
            <div class="modal fade" id="contactDetails" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Upgrade Membership Plan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12">
                                    <p>Please Upgrade Your Membership Plan</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <a href="{{route('user.userMembershipPlans')}}" class="btn btnPrimary d-block w-100">Membership Plans</a>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        @endif 
    @else
        <div class="modal fade" id="contactDetails" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Upgrade Membership Plan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <p>Please Upgrade Your Membership Plan</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <a href="{{route('user.userMembershipPlans')}}" class="btn btnPrimary d-block w-100">Membership Plans</a>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    @endif 

     <!-- Member photo Modal -->
		<div class="modal fade" id="memberProfilePhotos" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="memberProfilePhotosLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
					<h5 class="modal-title" id="memberProfilePhotosLabel">Photos of {{$register->matri_id}}</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-12">
								<div id="inFetBride" class="owl-carousel">
                                    <?php  $filePath = '/userImages/'.$register->photo1; ?>
                                    @if($register->photo1 != "" && $register->photo1_approve == "APPROVED" && Storage::disk('public')->exists($filePath))
                                        <a href="" class="item text-center ps-3 pe-3 pt-2 pb-2 d-block inFeturedCard">
                                            <div class="card shadow-sm">
                                                <img src="{{asset('storage/userImages/'.$register->photo1)}}" class="card-img-top">
                                            </div>
                                        </a>
                                    @endif
                                    <?php $filePath = '/userImages/'.$register->photo2; ?>
                                    @if($register->photo2 != "" && $register->photo2_approve == "APPROVED" && Storage::disk('public')->exists($filePath))
                                        <a href="" class="item text-center ps-3 pe-3 pt-2 pb-2 d-block inFeturedCard">
                                            <div class="card shadow-sm">
                                                <img src="{{asset('storage/userImages/'.$register->photo2)}}" class="card-img-top">
                                            </div>
                                        </a>
                                    @endif
                                    <?php  $filePath = '/userImages/'.$register->photo3; ?>
                                    @if($register->photo3 != "" && $register->photo3_approve == "APPROVED" && Storage::disk('public')->exists($filePath))
                                        <a href="" class="item text-center ps-3 pe-3 pt-2 pb-2 d-block inFeturedCard">
                                            <div class="card shadow-sm">
                                                <img src="{{asset('storage/userImages/'.$register->photo3)}}" class="card-img-top">
                                            </div>
                                        </a>
                                    @endif
                                    <?php  $filePath = '/userImages/'.$register->photo4; ?>
                                    @if($register->photo4 != "" && $register->photo4_approve == "APPROVED" && Storage::disk('public')->exists($filePath))
                                        <a href="" class="item text-center ps-3 pe-3 pt-2 pb-2 d-block inFeturedCard">
                                            <div class="card shadow-sm">
                                                <img src="{{asset('storage/userImages/'.$register->photo4)}}" class="card-img-top">
                                            </div>
                                        </a>
                                    @endif
                                    <?php  $filePath = '/userImages/'.$register->photo5; ?>
                                    @if($register->photo5 != "" && $register->photo5_approve == "APPROVED" && Storage::disk('public')->exists($filePath))
                                        <a href="" class="item text-center ps-3 pe-3 pt-2 pb-2 d-block inFeturedCard">
                                            <div class="card shadow-sm">
                                                <img src="{{asset('storage/userImages/'.$register->photo5)}}" class="card-img-top">
                                            </div>
                                        </a>
                                    @endif
                                    <?php  $filePath = '/userImages/'.$register->photo6; ?>
                                    @if($register->photo6 != "" && $register->photo6_approve == "APPROVED" && Storage::disk('public')->exists($filePath))
                                        <a href="" class="item text-center ps-3 pe-3 pt-2 pb-2 d-block inFeturedCard">
                                            <div class="card shadow-sm">
                                                <img src="{{asset('storage/userImages/'.$register->photo6)}}" class="card-img-top">
                                            </div>
                                        </a>
                                    @endif
                                    <?php  $filePath = '/userImages/'.$register->photo7; ?>
                                    @if($register->photo7 != "" && $register->photo7_approve == "APPROVED" && Storage::disk('public')->exists($filePath))
                                        <a href="" class="item text-center ps-3 pe-3 pt-2 pb-2 d-block inFeturedCard">
                                            <div class="card shadow-sm">
                                                <img src="{{asset('storage/userImages/'.$register->photo7)}}" class="card-img-top">
                                            </div>
                                        </a>
                                    @endif
                                    <?php  $filePath = '/userImages/'.$register->photo8; ?>
                                    @if($register->photo8 != "" && $register->photo8_approve == "APPROVED" && Storage::disk('public')->exists($filePath))
                                        <a href="" class="item text-center ps-3 pe-3 pt-2 pb-2 d-block inFeturedCard">
                                            <div class="card shadow-sm">
                                                <img src="{{asset('storage/userImages/'.$register->photo8)}}" class="card-img-top">
                                            </div>
                                        </a>
                                    @endif
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
    <div class="toast-container position-fixed position-static bottom-0 end-0 p-3 mb-5 mb-sm-0">
        <div id="upgrademember" class="toast inToastExpress" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
            <div class="d-flex">
                <div class="toast-body">
                    <strong class="me-auto">Please Upgrade Your Membership Plan</strong>
                </div>
                <button type="button" class="btn-close me-2 m-auto bg-white p-1" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
        <div id="shortlisted" class="toast inToastExpress" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
            <div class="d-flex">
                <div class="toast-body">
                    <strong class="me-auto">Shortlisted</strong>
                </div>
                <button type="button" class="btn-close me-2 m-auto bg-white p-1" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
        <div id="removedsl" class="toast inToastExpress" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
            <div class="d-flex">
                <div class="toast-body">
                    <strong class="me-auto">Shortlisted Removed</strong>
                </div>
                <button type="button" class="btn-close me-2 m-auto bg-white p-1" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
        <div id="expsent" class="toast inToastExpress" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
            <div class="d-flex">
                <div class="toast-body">
                    <strong class="me-auto">Express Interest Sent</strong>
                </div>
                <button type="button" class="btn-close me-2 m-auto bg-white p-1" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
        <div id="expremove" class="toast inToastExpress" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
            <div class="d-flex">
                <div class="toast-body">
                    <strong class="me-auto">Express Interest Remove</strong>
                </div>
                <button type="button" class="btn-close me-2 m-auto bg-white p-1" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
        <div id="messagebox" class="toast inToastExpress" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
            <div class="d-flex">
                <div class="toast-body">
                    <strong class="me-auto">Please Upgrade Your Membership Plan</strong>
                </div>
                <button type="button" class="btn-close me-2 m-auto bg-white p-1" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
        <div id="expresintrest" class="toast inToastExpress" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
            <div class="d-flex">
                <div class="toast-body">
                    @if(isset($intrestdata))
                        @if($intrestdata->receiver_response == "Pending")
                            <strong class="me-auto">Express Interest Remove</strong>
                        @endif
                    @else
                        @if($cansendinterest == 1)
                            <strong class="me-auto">Express Interest Sent</strong> 
                        @else
                            <strong class="me-auto">Please Upgrade Your Membership Plan</strong>
                        @endif
                    @endif
                </div>
                <button type="button" class="btn-close me-2 m-auto bg-white p-1" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
   
</section>


@endsection

@section('pageJS')


  <script>
        const toastTrigger = document.getElementById('reshow')
       
       const toastLiveExample = document.getElementById('liveToast')
        if (toastTrigger) {
          toastTrigger.addEventListener('click', () => {
            const toast = new bootstrap.Toast(toastLiveExample)
            toast.show()
          })
        }
    </script>
<script>
    $(document).ready(function() {
        //shortlist add
        $('.shortlist-link').on('click', function (event) {
            event.preventDefault();
            var registerId = $(this).data('register-id');
            $.ajax({
                url: "{{ route('user.shortliststore') }}",
                type: "POST",
                data: {
                    register_id: registerId,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function (result) {
                     $("#reremove").show();
                    $("#show").hide();
                    $("#reshow").hide();
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
        //shortlist remove
        $('.shortlist-remove').on('click', function (event) {
            event.preventDefault();
            var registerId = $(this).data('register-id');
            $.ajax({
                url: "{{ route('user.shortlistremove') }}",
                type: "POST",
                data: {
                    register_id: registerId,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function (result) {
                    console.log(result);
                    $("#remove").hide();
                     $("#reshow").show();
                     $("#reremove").hide();
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
        //interest send
        $('.interest-send').on('click', function (event) {
            event.preventDefault();
            var registerId = $(this).data('register-id');
            $.ajax({
                url: "{{ route('user.intereststore') }}",
                type: "POST",
                data: {
                    register_id: registerId,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function (result) {
                    $("#interestremoveajax").show();
                    $("#interestshow").hide();
                    $("#interestshowajax").hide();
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
        //interest remove
        $('.interest-remove').on('click', function (event) {
            event.preventDefault();
            var registerId = $(this).data('register-id');
            $.ajax({
                url: "{{ route('user.interestremove') }}",
                type: "POST",
                data: {
                    register_id: registerId,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function (result) {
                    console.log(result);
                    $("#interestremove").hide();
                     $("#interestshowajax").show();
                     $("#interestremoveajax").hide();
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
        $('#contactDetails').on('shown.bs.modal', function(e) {
            event.preventDefault(e);
            var matriId = $('#matriIdValue').val();
            $.ajax({
                    url: "{{ route('user.contactdetailsshow') }}",
                    type: "POST",
                    data: {
                        matriId : matriId,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function (result) {
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
        });
    });
   
</script>
@endsection