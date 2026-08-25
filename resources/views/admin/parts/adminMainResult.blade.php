<div class="card mb-3 inMainResultCard inBorderColor1">
    <div class="row g-0">
        <div class="col-lg-3 col-md-3">
            <label class="inMainResultCheck" for="checkboxprofile">
                <input type="checkbox" value="{{$member->id}}" name="selectedMembers[]" name="checkbox" id="checkbox" class="checkbox">
            </label>
           
            <a href="{{ route('admin.view-profile',$member->matri_id) }}" class="text-decoration-none">
                @if(isset($member))
                    <?php $filePath = '/userImages/'.$member->photo1; ?>
                    @if($member->photo1 != "" && $member->photo1_approve == "APPROVED" && Storage::disk('public')->exists($filePath))
                        <img src="{{asset('storage/userImages/'.$member->photo1)}}" class="img-fluid rounded w-100">
                    @elseif($member->photo1 != ""  && $member->gender == "Female" && $member->photo1_approve == "PENDING" && Storage::disk('public')->exists($filePath))
                        <img src="{{asset('admin/img/femalepending.jpg')}}" class="card-img-top">
                    @elseif($member->photo1 != ""  && $member->gender == "Male" && $member->photo1_approve == "PENDING" && Storage::disk('public')->exists($filePath))
                        <img src="{{asset('admin/img/malepending.jpg')}}" class="card-img-top">
                    @else
                        @if($member->gender == "Male")
                            <img src="{{ asset('admin/img/male.jpg') }}" class="img-fluid rounded w-100">
                        @else
                            <img src="{{asset('admin/img/female.jpg')}}" class="img-fluid rounded w-100">
                        @endif
                    @endif
                @endif
            </a>
        </div>
        
        <div class="col-lg-9 col-md-9">
            <div class="card-body pb-1">
                <a href="{{ route('admin.view-profile',$member->matri_id) }}" class="text-decoration-none">
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <h5 class="card-title">@if(isset($member->firstname)){{$member->firstname}}@endif @if(isset($member->lastname)){{$member->lastname}}@endif</h5>
                            <h6 class="mb-3">@if(isset($member->matri_id)){{$member->matri_id}}@endif &nbsp;&nbsp;|&nbsp;&nbsp; Profile Created by @if(isset($member->profileby)){{$member->profileby}}@else Not Available @endif</h6>
                        </div>
                        <div class="col-lg-6 col-12 inAResultStatus mb-3 mb-md-0">
                            <div class="row">
                                @if($member->status === "Active")
                                <div class="@if(!$member->fstatus == 'Featured') col-12 @else col-6 @endif">
                                    <i class="fa-solid fa-thumbs-up pe-2"></i><span class="">Approved</span> 
                                </div>
                                @elseif($member->status === "Suspended")
                               
                                <div class="@if(!$member->fstatus == 'Featured') col-12 @else col-6 @endif">
                                    <i class="fa-solid fa-thumbs-up pe-2"></i><span class="">Suspended</span> 
                                </div>
                                @elseif($member->status === "Inactive")
                                <div class="@if(!$member->fstatus == 'Featured') col-12 @else col-6 @endif ">
                                    <i class="fa-solid fa-thumbs-down pe-2"></i><span class="">Unapproved</span> 
                                </div>
                                @elseif($member->status === "Paid")
                                <div class="@if(!$member->fstatus == 'Featured') col-12 @else col-6 @endif">
                                    <i class="fa-solid fa-money-check-dollar pe-2"></i><span class="">Paid</span>
                                </div>
                                @endif

                                @if($member->fstatus == "Featured")
                                <div class="col-6">
                                    <i class="fa-solid fa-star pe-2"></i><span class="">Featured</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="row inAResultDatails">
                        <div class="col-lg-6 mb-1">
                            <div class="row">
                                <div class="col-4">
                                    <b>Email</b>
                                </div>
                                <div class="col">
                                    @if(env('DEMO_MODE') == 'On')
                                        <span>Disabled In Demo</span>
                                    @else
                                        <span>@if(isset($member->email)) {{ $member->email }} @else Not Available @endif</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-1">
                            <div class="row">
                                <div class="col-4">
                                    <b>Mobile</b>
                                </div>
                                <div class="col">
                                    @if(env('DEMO_MODE') == 'On')
                                        <span>Disabled In Demo</span>
                                    @else
                                        <span>@if(isset($member->mobile)) {{ $member->mobile }} @else Not Available @endif</span> 
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-1">
                            <div class="row">
                                <div class="col-4">
                                    <b>Gender</b>
                                </div>
                                <div class="col">
                                    <span>@if(isset($member->gender)) {{ $member->gender }} @else Not Available @endif</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-1">
                            <div class="row">
                                <div class="col-4">
                                    <b>Age</b>
                                </div>
                                <div class="col">
                                    <?php   
                                        if($member->birthdate){
                                            $from = Carbon\Carbon::parse($member->birthdate);
                                            $to = Carbon\Carbon::now();
                                            $age =$from->diff($to)->y;
                                        }
                                    ?>
                                    <span>@if(isset($member->birthdate)) {{ $age }} Yrs @else Not Available @endif</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-1">
                            <div class="row">
                                <div class="col-4">
                                    <b>Expiry Date</b>
                                </div>
                                <div class="col">
				        @php
					    $payment = DB::table('payments')
					        ->where('pmatri_id', $member->matri_id)
					        ->orderBy('created_at', 'desc')
					        ->first();
					@endphp
                                    <span>@if(isset($payment->exp_date)) {{ $payment->exp_date }} @else Not Available @endif</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-1">
                            <div class="row">
                                <div class="col-4">
                                    <b>Religion</b>
                                </div>
                                <div class="col">
                                    <span>@if(isset($member->religion)) {{ $member->rel->religion_name }} @else Not Available @endif</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-1">
                            <div class="row">
                                <div class="col-4">
                                    <b>Caste</b>
                                </div>
                                <div class="col">
                                    <span>@if(isset($member->caste)) {{ $member->cast->caste_name }} @else Not Available @endif</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-1">
                            <div class="row">
                                <div class="col-4">
                                    <b>Location</b>
                                </div>
                                <div class="col">
                                    <span>@if(isset($member->country_id)) {{ $member->country->country_name }} @else Not Available @endif</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                
                <!-- Visible in large device only -->
                <div class="d-none d-lg-block">
                    <div class="row mt-4 inMainResultAction mt-lg-2 mt-xl-4">
                        <div class="col col-xl-2 text-center">
                            <a href="{{ route('admin.view-profile',$member->matri_id) }}">
                                <i class="fas fa-eye"></i>
                                <p>View Profile</p>
                            </a>
                        </div>
                        <div class="col col-xl-2 text-center">
                            <a href="{{ route('admin.edit-profile',$member->matri_id) }}">
                                <i class="fas fa-pen"></i>
                                <p>Edit Profile</p>
                            </a>
                        </div>
                        @if($member->fstatus == "")
                        <div class="col col-xl-2 text-center">
                            <a href="{{ route('admin.makeFeaturedProfile',$member->id) }}" id="featuredButton">
                                <i class="fas fa-star"></i>
                                <p>Make Featured</p>
                            </a>
                        </div>
                        @else
                        <div class="col col-xl-2 text-center">
                            <a href="{{ route('admin.removeFeaturedProfile',$member->id) }}" id="unfeaturedButton">
                                <i class="fas fa-star"></i>
                                <p>Remove Featured</p>
                            </a>
                        </div>
                        @endif
        
                        @if(session('member') == 'memberBtnApproved')
                            @if($member->status == "Inactive" || $member->status == "Paid")
                                <div class="col col-xl-2 text-center">
                                    <a href="{{ route('admin.approveProfile',$member->id) }}">
                                        <i class="fas fa-thumbs-up"></i>
                                        <p>Approve</p>
                                    </a>
                                </div>
                            @endif
                            @if($member->status == "Active" || $member->status == "Paid")
                                <div class="col col-xl-2 text-center">
                                    <a href="{{ route('admin.unApproveProfile',$member->id) }}">
                                        <i class="fas fa-thumbs-down"></i>
                                        <p>Unapprove</p>
                                    </a>
                                </div>
                            @endif
                        @endif
                        
                        @if(session('member') == 'memberBtnPaid')
                        <div class="col col-xl-2 text-center">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#staticBackdrop{{$member->id}}">
                                <i class="fa-sharp fa-solid fa-id-card"></i>
                                <p>Make Paid</p>
                            </a>
                        </div>
                        @endif

                        <div class="col col-xl-2 text-center" onclick="return confirm('Are you sure?')">
                            <a href="{{route('admin.memberDelete',$member->id)}}">
                                <i class="fas fa-trash"></i>
                                <p>Delete</p>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /.Visible in large device only -->
            </div>
        </div>
       
        <!-- Visible in mobile device only -->
        <div class="col-md-12 pe-3 ps-3 d-block d-lg-none">
            <div class="row mt-2 inMainResultAction mt-lg-2 mt-xl-4">
                <div class="col-4 col-xl-2 text-center mb-3">
                    <a href="{{ route('admin.view-profile',$member->matri_id) }}">
                        <i class="fas fa-eye"></i>
                        <p>View Profile</p>
                    </a>
                </div>
                <div class="col-4 col-xl-2 text-center mb-3">
                    <a href="{{ route('admin.edit-profile',$member->matri_id) }}">
                        <i class="fas fa-pen"></i>
                        <p>Edit Profile</p>
                    </a>
                </div>
                @if($member->fstatus == "")
                    <div class="col col-xl-2 text-center">
                        <a href="{{ route('admin.makeFeaturedProfile',$member->id) }}" id="featuredButton">
                            <i class="fas fa-star"></i>
                            <p>Make Featured</p>
                        </a>
                    </div>
                    @else
                    <div class="col col-xl-2 text-center">
                        <a href="{{ route('admin.removeFeaturedProfile',$member->id) }}" id="unfeaturedButton">
                            <i class="fas fa-star"></i>
                            <p>Remove Featured</p>
                        </a>
                    </div>
                @endif
                @if(session('member') == 'memberBtnApproved')
                    @if($member->status == "Inactive" || $member->status == "Paid")
                        <div class="col-4 col-xl-2 text-center mb-3">
                            <a href="{{ route('admin.approveProfile',$member->id) }}">
                                <i class="fas fa-thumbs-up"></i>
                                <p>Approve</p>
                            </a>
                        </div>
                    @endif
                    @if($member->status == "Active" || $member->status == "Paid")
                        <div class="col-4 col-xl-2 text-center mb-3">
                            <a href="{{ route('admin.unApproveProfile',$member->id) }}">
                                <i class="fas fa-thumbs-down"></i>
                                <p>Unapprove</p>
                            </a>
                        </div>
                    @endif
                @endif
                <div class="col-4 col-xl-2 text-center mb-3" onclick="return confirm('Are you sure?')">
                    <a href="{{route('admin.memberDelete',$member->id)}}">
                        <i class="fas fa-trash"></i>
                        <p>Delete</p>
                    </a>
                </div>
                @if(session('member') == 'memberBtnPaid')
                <div class="col-4 col-xl-2 text-center mb-3">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#staticBackdrop{{$member->id}}">
                        <i class="fa-sharp fa-solid fa-id-card"></i>
                        <p>Make Paid</p>
                    </a>
                </div>
                @endif
            </div>
        </div>
        <!-- /.Visible in mobile device only -->
    </div>
</div>


