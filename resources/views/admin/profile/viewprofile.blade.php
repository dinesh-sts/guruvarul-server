@extends('admin.layouts.afterLoginLayout')

@section('title') Admin - View Profile @endsection

@section('pageCSS') @endsection

@section('content')
<div class="container pt-3">
    <div class="row mb-4 mt-3">
        <div class="col-xl-4">
            <h3 class="colorSecondary inATitle1 mt-2">@if(isset($register->firstname)){{$register->firstname}}@else Not Available @endif @if(isset($register->lastname)){{$register->lastname}}@else Not Available @endif - @if(isset($register->lastname)){{$register->matri_id}}@else Not Available @endif</h3>
        </div>
        <div class="col-xl-8 text-end inAProfileActionBtn">
            <div class="btn-group" role="group" aria-label="Basic example">
                <form action="{{ route('admin.user-status',$register->id) }}" method="post">
                    @csrf  
                    <button type="submit" name="filter" value="active" class="btn btnSecondary inBorderRightLightGrey"><i class="fas fa-thumbs-up"></i><span class="ps-1 d-none d-lg-inline">Approve</span></button>
                    <button type="submit" name="filter" value="inactive" class="btn btnSecondary inBorderRightLightGrey"><i class="fas fa-thumbs-down pe-1"></i><span class="ps-1 d-none d-lg-inline">Unapprove</span></button>
                    <button type="submit" name="filter" value="delete" class="btn btnSecondary inBorderRightLightGrey"><i class="fas fa-trash pe-1 "></i><span class="ps-1 d-none d-lg-inline">Delete</span></button>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-3">
            <div class="card inBorderColor1">
                @if(isset($register))
                <?php  $filePath = '/userImages/'.$register->photo1; ?>
                    @if($register->photo1 != "" && $register->photo1_approve == "APPROVED" && Storage::disk('public')->exists($filePath))
                        <img src="{{asset('storage/userImages/'.$register->photo1)}}" class="card-img-top">
                    @elseif($register->photo1 != ""  && $register->gender == "Female" && $register->photo1_approve == "PENDING" && Storage::disk('public')->exists($filePath))
                        <img src="{{asset('admin/img/femalepending.jpg')}}" class="card-img-top">
                        <div class="card-body text-center inFullProfilePhoto">
                            <p class="mb-0 text-center">Profile Photo Approval Status</p>
                                <p><b class="badge bg-dark">@if(isset($register->photo1_approve)){{$register->photo1_approve}}@else Not Available @endif</b></p>
                            @if($register->photo1_approve == "UNAPPROVED" || $register->photo1_approve == "PENDING")
                                <a href="{{route('admin.image-status',$register->id)}}" class="btn btnPrimary d-block"><i class="fas fa-thumbs-up pe-2"></i>Approve Profile Pic</a>
                            @else
                                <a href="{{route('admin.image-status',$register->matri_id)}}" class="btn btnPrimary d-block"><i class="fas fa-thumbs-up pe-2"></i>UnApprove Profile Pic</a>
                            @endif
                        </div>
                    @elseif($register->photo1 != ""  && $register->gender == "Male" && $register->photo1_approve == "PENDING" && Storage::disk('public')->exists($filePath))
                        <img src="{{asset('admin/img/malepending.jpg')}}" class="card-img-top">
                        <div class="card-body text-center inFullProfilePhoto">
                            <p class="mb-0 text-center">Profile Photo Approval Status</p>
                                <p><b class="badge bg-dark">@if(isset($register->photo1_approve)){{$register->photo1_approve}}@else Not Available @endif</b></p>
                            @if($register->photo1_approve == "UNAPPROVED" || $register->photo1_approve == "PENDING")
                                <a href="{{route('admin.image-status',$register->id)}}" class="btn btnPrimary d-block"><i class="fas fa-thumbs-up pe-2"></i>Approve Profile Pic</a>
                            @else
                                <a href="{{route('admin.image-status',$register->matri_id)}}" class="btn btnPrimary d-block"><i class="fas fa-thumbs-up pe-2"></i>UnApprove Profile Pic</a>
                            @endif
                        </div>
                    @else
                        @if($register->gender == "Male")
                            <img src="{{asset('admin/img/male.jpg')}}" class="card-img-top">
                        @else
                            <img src="{{asset('admin/img/female.jpg')}}" class="card-img-top">
                        @endif
                    @endif
                @endif
                
            </div>
        </div>
	@php
            use App\Models\Payment;
            use Carbon\Carbon;

            $latestPayment = Payment::where('pmatri_id', $register->matri_id)
                ->orderByDesc('id')
                ->first();

            $expiryFullYear = null;

            if ($latestPayment && $latestPayment->exp_date) {
                // Parse dd-mm-yy into Carbon
                $expiryFullYear = Carbon::createFromFormat('d-m-y', $latestPayment->exp_date)
                    ->format('d-m-Y');
            }
        @endphp
        <div class="col-xl-9">
            <div class="card inBorderColor1 mb-4 inMemberDetCard">
                <div class="card-header">
                    <h5><i class="fas fa-phone pe-2" aria-hidden="true"></i>Contact Details</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 inMemTopBasicDet">
                            <h5 class="">
                                <span class="inMemDetMain pe-1">Mobile No :</span>
                                <span class="ps-1 inMemDet">
                                    @if(env('DEMO_MODE') == 'On')
                                        <span>Disabled In Demo</span>
                                    @else
                                        @if(isset($register->mobile)){{ $register->mobile }}@else Not Available @endif
                                    @endif 
                                </span>
                            </h5>
                        </div>
                        <div class="col-xl-6 col-lg-6 inMemTopBasicDet">
                             <h5 class="">
                                <span class="inMemDetMain pe-1">Email Id :</span>
                                <span class="ps-1 inMemDet">
                                    @if(env('DEMO_MODE') == 'On')
                                        <span>Disabled In Demo</span>
                                    @else
                                        @if(isset($register->email)){{ $register->email }} @else Not Available @endif
                                    @endif
                                    
                                </span>
                            </h5>
                        </div>
			<div class="col-xl-6 col-lg-6 inMemTopBasicDet">
                             <h5 class="">
                                <span class="inMemDetMain pe-1">MemberShip Expiry :</span>
                                <span class="ps-1 inMemDet">
                                    <strong>{{ $expiryFullYear ?? 'Not Available' }}</strong> 
                                </span>
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card inBorderColor1 mb-4 inMemberDetCard">
                <div class="card-header">
                    <h5><i class="fas fa-user pe-2" aria-hidden="true"></i>Basic Details</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 inMemTopBasicDet">
                            <h5 class=""><span class="inMemDetMain pe-1">Full Name :</span><span class="ps-1 inMemDet">@if(isset($register->firstname)){{$register->firstname}}@else Not Available @endif @if(isset($register->lastname)){{$register->lastname}}@else Not Available @endif</span></h5>
                        </div>
			<div class="col-xl-6 col-lg-6 inMemTopBasicDet">
                            <h5 class=""><span class="inMemDetMain pe-1">Gender :</span><span class="ps-1 inMemDet">@if(isset($register->gender)){{$register->gender}}@else Not Available @endif</h5>
                        </div>
			<div class="col-xl-6 col-lg-6 inMemTopBasicDet">
			    <h5 class="">
			        <span class="inMemDetMain pe-1">DOB :</span>
			        <span class="ps-1 inMemDet">
			            @if(isset($register->birthdate))
			                {{ \Carbon\Carbon::parse($register->birthdate)->format('d-m-Y') }}
			            @endif
			        </span>
			    </h5>
			</div>
                        <div class="col-xl-6 col-lg-6 inMemTopBasicDet">
                             <h5 class=""><span class="inMemDetMain pe-1">Marital Status :</span><span class="ps-1 inMemDet">@if(isset($register->m_status)){{$register->m_status}}@else Not Available @endif</span></h5>
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
                    <h5><i class="fas fa-book pe-2" aria-hidden="true"></i>Horoscope Details</h5>
                </div>
                <div class="card-body">
                    <div class="row inMB-5">
                        <?php $val = "Not Available" ?>
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
                            <h5 class=""><span class="inMemDetMain pe-1">Gotra :</span><span class="ps-1 inMemDet">@if(isset($register->gotra)){{$register->gotra}}@else Not Available @endif</span></h5>
                        </div>
                        @endif
                        @if(!isset($fieldsetting->will_to_marry) || $fieldsetting->will_to_marry == "Yes" )
                        <div class="col-xl-6 col-lg-6 inMemTopBasicDet">
                             <h5 class=""><span class="inMemDetMain pe-1">Willing to marry other caste? :</span><span class="ps-1 inMemDet">@if(isset($register->will_to_mary_caste))@if($register->will_to_mary_caste == 1) Yes @else No @endif @else Not Available @endif</span></h5>
                        </div>
                        @endif
			@if(!isset($fieldsetting->star) || $fieldsetting->star == "Yes" )
	                    <div class="col-xl-6 col-lg-6 inMemTopBasicDet">
	                         <h5 class=""><span class="inMemDetMain pe-1">Star :</span><span class="ps-1 inMemDet">@if(isset($register->star) && !empty($register->staars->star)){{$register->staars->star}}@else Not Available @endif</span></h5>
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
            @if(!isset($fieldsetting) || $fieldsetting->family_type == "Yes" || $fieldsetting->family_value == "Yes" || $fieldsetting->family_status == "Yes" || $fieldsetting->father_name == "Yes" || $fieldsetting->father_occupation == "Yes" || $fieldsetting->mother_name == "Yes" || $fieldsetting->mother_occupation == "Yes" || $fieldsetting->no_of_brothers == "Yes" || $fieldsetting->no_marri_brother == "Yes" || $fieldsetting->no_of_sisters == "Yes" || $fieldsetting->no_marri_sister == "Yes" || $fieldsetting->maternal_details == "Yes" || $fieldsetting->paternal_details == "Yes")
            <div class="card inBorderColor1 mb-4 inMemberDetCard">
            <div class="card-header">
                <h5><i class="fas fa-users pe-2" aria-hidden="true"></i>Family Details</h5>
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
                    <h5><i class="fas fa-graduation-cap pe-2" aria-hidden="true"></i>Education / Occupation Details</h5>
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
                            <h5 class=""><span class="inMemDetMain pe-1">Occupation :</span><span class="ps-1 inMemDet">@if(isset($register->occupation) && !empty($register->occ->ocp_name)){{$register->occ->ocp_name}}@else Not Available @endif</span></h5>
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
                            <h5 class=""><span class="inMemDetMain pe-1">Monthly Income :</span><span class="ps-1 inMemDet">@if(isset($register->income) && !empty($register->inc->income)){{$register->inc->income}}@else Not Available @endif</span></h5>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="card inBorderColor1 mb-4 inMemberDetCard">
            <div class="card-header">
                <h5><i class="fas fa-globe pe-2" aria-hidden="true"></i>Location Details</h5>
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
                        <h5 class=""><span class="inMemDetMain pe-1">City :</span><span class="ps-1 inMemDet">@if(isset($register->city) && !empty($register->citi->city_name)){{$register->citi->city_name}}@else Not Available @endif</span></h5>
                    </div>
                    @if(!isset($fieldsetting->address) || $fieldsetting->address == "Yes" )
                    <div class="col-xl-6 col-lg-6 inMemTopBasicDet">
                         <h5 class=""><span class="inMemDetMain pe-1">Address :</span><span class="ps-1 inMemDet">@if(isset($register->address)){{$register->address}}@else Not Available @endif</span></h5>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @if(!isset($fieldsetting) || $fieldsetting->diet == "Yes" || $fieldsetting->smoke == "Yes" || $fieldsetting->drink == "Yes")
        <div class="card inBorderColor1 mb-4 inMemberDetCard">
            <div class="card-header">
                <h5><i class="fas fa-wine-glass pe-2" aria-hidden="true"></i>Habits &amp; Hobbies</h5>
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
                <h5><i class="fas fa-person pe-2" aria-hidden="true"></i>Physical Details</h5>
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
        @if(!isset($fieldsetting->profile_text) || $fieldsetting->profile_text == "Yes" )
            <div class="card inBorderColor1 mb-4 inMemberDetCard">
            <div class="card-header">
                <h5><i class="fas fa-user pe-2" aria-hidden="true"></i>About</h5>
            </div>
            <div class="card-body">
                <div class="row inMB-5">
                    <div class="col-xl-12 inMemTopBasicDet">
                        <h5 class=""><span class="inMemDetMain pe-1">About :</span><span class="ps-1 inMemDet">@if(isset($register->profile_text)){{$register->profile_text}}@else Not Available @endif</span></h5>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @php    
            $isAdmin = Auth::guard('admin')->user();
        @endphp    
            @if($isAdmin)
            <div class="card inBorderColor1 mb-4 inMemberDetCard">
                <div class="card-header">
                    <h5><i class="fas fa-users pe-2" aria-hidden="true"></i>Payment Details</h5>
                </div>
                <div class="container">
                    <div class="row mb-4">
                        <!-- Uploaded Payment Proof -->
                        <div class="col-md-12 d-flex flex-column align-items-left text-left"><br/>
                            @if(!empty($register) && !empty($register->payment_image))
                                <h5 class="mb-2"><strong>Name (as per Aadhaar) :</strong> {{ $register->aadhaar_name }}  <strong><br/>Aadhaar No :</strong> {{ $register->aadhaar_card }}</h5>
                                <img src="{{ asset('storage/' . $register->payment_image) }}" 
                                    alt="Payment Proof" 
                                    class="img-fluid rounded shadow mb-2"
                                    style="max-width: 300px;">
                            @else
                                <p>No payment proof uploaded yet.</p>
                            @endif
                        </div>
                    </div>  
                </div>
            </div>
            <div class="card inBorderColor1 mb-4 inMemberDetCard">
                <div class="card-header">
                    <h5><i class="fas fa-users pe-2" aria-hidden="true"></i>Donation Payment Details</h5>
                </div>
                <div class="container">
                    <div class="row mb-4">
                        <!-- Uploaded Donation Screenshot -->
                        <div class="col-md-12 d-flex flex-column align-items-left text-left"><br/>
                            @if(!empty($register) && !empty($register->donation_image))
                                <img src="{{ Storage::url($register->donation_image) }}" 
                                    alt="Donation Screenshot" 
                                    class="img-fluid rounded shadow mb-2"
                                    style="max-width: 300px;">
                            @else
                                <p>No donation proof uploaded yet.</p>
                            @endif
                        </div>
                    </div>  
                </div>
            </div>
            @endif
        </div>
        
        </div>
    </div>
</div>
@endsection

@section('pageJS')
<script type="text/javascript">
    $(document).ready(function () {
        @if(Session::has('message'))
            $('#message').toast('show');
        @endif
    });
</script>
@endsection
