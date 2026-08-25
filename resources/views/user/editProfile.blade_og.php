@extends('user.layouts.afterLoginLayout')

@section('pageCSS')
   <!-- Chosen css -->
    <link rel="stylesheet" href="{{asset('user/css/prism.css')}}">
    <link rel="stylesheet" href="{{asset('user/css/chosen.css')}}">
    <!-- /. Chosen css --> 
@endsection

<!-- Content Section Start -->
@section('content')

<!-- Page Header -->
<section class="inPageHeader">
    <div class="container">
        <h2 class="text-center">Edit Profile</h2>
    </div>
</section>
<!-- /. Page Header -->

<!-- Home Section -->
<section class="inHome mt-5">
    <div class="container">
        <div class="row">
            <!-- User home left panel -->
            @include('user.layouts.leftPanel')
            <!-- /.User home left panel -->

            <div class="col-lg-9 col-md-8">
                 <!-- Profile Picture & Horoscope Image Section -->
                <div class="row">
                    <div class="col-xl-6 col-lg-6">
                        <div class="card mb-4 inEditCard">
                            <div class="card-header pt-9 pb-9">
                                <div class="row">
                                    <div class="col-7 mt-10">
                                        <h4 class="inMT-5">Profile Picture Update</h4>
                                    </div>
                                    <div class="col-5">
                                        <a href="{{route('user.managePhotos')}}" class="btn btn-dark btn-sm d-block">Manage Photos</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form method="POST" id="register_form" action="{{ isset($register) ? route('user.profileupdate', $register->id) : route('admin.store-profile') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-xl-12 mb-4">
                                            <label class="label-1">Select Profile Picture</label>
                                            <input type="file" name="photo1" class="form-control">
                                        </div>
                                        <div class="col-xl-4 mb-3">
                                            @if(isset($register))
                                                <?php $filePath = '/userImages/'.$register->photo1; ?>
                                                @if($register->photo1 != "" && Storage::disk('public')->exists($filePath))
                                                    <img src="{{asset('storage/userImages/'. $register->photo1)}}" class="img-fluid inProfileThumb">
                                                    
                                                    {{-- <img src="{{ route('apply.watermark', ['image' => $register->photo1]) }}" class="img-fluid inProfileThumb"> --}}
                                                @elseif($register->photo1 != ""  && $register->gender == "Female" && $register->photo1_approve == "PENDING" && Storage::disk('public')->exists($filePath))
                                                    <img src="{{asset('user/img/femalepending.jpg')}}" class="img-fluid inProfileThumb">
                                                @elseif($register->photo1 != ""  && $register->gender == "Male" && $register->photo1_approve == "PENDING" && Storage::disk('public')->exists($filePath))
                                                    <img src="{{asset('user/img/malepending.jpg')}}" class="img-fluid inProfileThumb">
                                                @else
                                                    @if($register->gender == "Male")
                                                        <img src="{{asset('user/img/male.jpg')}}" class="img-fluid inProfileThumb">
                                                    @else
                                                        <img src="{{asset('user/img/female.jpg')}}" class="img-fluid inProfileThumb">
                                                    @endif
                                                @endif
                                            @endif
                                            @if($register->photo1 != "")
                                            <a href="{{route('user.profileimagedelete',['id' => $register->id, 'photo' => 'photo1'])}}" class="inTimesIconOver"><i class="fas fa-trash" aria-hidden="true"></i></a>
                                            @endif
                                        </div>
                                        @if($register->photo1_approve == "PENDING")
                                        <div class="col-xl-12">
                                            Status : <span class="text-danger">
                                                 <i class="fas fa-clock"></i> Pending Approval 
                                            </span>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="text-center mt-3">
                                        <input type="submit" value="UPDATE" name="photo1" class="btn btnPrimary">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6">
                        <div class="card mb-4 inEditCard">
                            <div class="card-header pt-9 pb-9">
                                <div class="row">
                                    <div class="col-6 mt-10">
                                        <h4 class="inMT-5">Horoscope Image</h4>
                                    </div>
                                    <div class="col-6">
                                        <a href="{{route('user.managePhotos')}}" class="btn btn-dark btn-sm d-block">Manage Horoscope</a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card-body">
                                <form method="POST" id="register_form" action="{{ isset($register) ? route('user.profileupdate', $register->id) : route('admin.store-profile') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-xl-12 mb-4">
                                            <label class="label-1">Horoscope Image</label>
                                            <input type="file" name="hor_photo" class="form-control">
                                        </div>
                                        <div class="col-xl-4 mb-3">
                                            @if(isset($register))
                                            <?php  $filePath = '/userImages/'.$register->hor_photo; ?>
                                                @if($register->hor_photo != "" && Storage::disk('public')->exists($filePath))
                                                    <img src="{{asset('storage/userImages/'.$register->hor_photo)}}" class="img-fluid inProfileThumb">
                                                @else
                                                    <img src="{{asset('user/img/upload_horoscope.jpg')}}" class="img-fluid inProfileThumb">
                                                @endif
                                            @endif
                                            @if($register->hor_photo != "")
                                            <a href="{{route('user.profileimagedelete',['id' => $register->id, 'photo' => 'hor_photo'])}}" class="inTimesIconOver"><i class="fas fa-trash" aria-hidden="true"></i></a>
                                            @endif
                                        </div>
                                        @if($register->hor_check == "PENDING")
                                        <div class="col-xl-12">
                                            Status : <span class="text-danger">
                                                 <i class="fas fa-clock"></i> Pending Approval 
                                            </span>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="text-center mt-3">
                                        <input type="submit" value="UPDATE" name="horoscope_img" class="btn btnPrimary">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /. Profile Picture & Horoscope Image Section -->

                
                <div class="card mb-4 inEditCard">
                    <div class="card-header">
                        <h4>Edit Personal Details</h4>
                    </div>
                    <div class="card-body">
                        <form id="register_form" action="{{ isset($register) ? route('user.profileupdate', $register->id) : route('admin.store-profile') }}" method="POST">
                            @csrf
                            <!-- Basic Details Section -->
                            <h4><i class="fas fa-user pe-3"></i>Basic Details</h4>
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 mb-3">
                                    <label class="label-1">First Name</label>
                                    <input type="text" name="firstname" value="@if(isset($register->firstname)){{$register->firstname}}@else{{old('firstname')}}@endif" class="form-control" placeholder="Enter First Name" pattern="[a-zA-Z\s]+" required>
                                </div>
                                <div class="col-xl-6 col-lg-6 mb-3">
                                    <label class="label-1">Last Name</label>
                                    <input type="text" name="lastname" value="@if(isset($register->lastname)){{$register->lastname}}@else{{old('lastname')}}@endif" class="form-control" placeholder="Enter Last Name" pattern="[a-zA-Z\s]+" required>
                                </div>
                                <div class="col-xl-6 col-lg-6 mb-3" id="dis_m_status">
                                    <label class="label-1">Marital Status</label>
                                    <input type="hidden" value="{{$register->m_status}}" name="m_status" id="m_status">
                                    <select name="m_status" class="form-select" id="no_mstatus" required>
                                        <option value="" selected>select</option>
                                        <option value="Never Married" @if(isset($register->m_status)) {{$register->m_status == "Never Married" ? "selected" : ''}}@else @selected(old('m_status') == "Never Married")@endif>Never Married</option>
                                        <option value="Widower" @if(isset($register->m_status)) {{$register->m_status == "Widower" ? "selected" : ''}}@else @selected(old('m_status') == "Widower")@endif>Widower</option>
                                        <option value="Divorced" @if(isset($register->m_status)) {{$register->m_status == "Divorced" ? "selected" : ''}}@else @selected(old('m_status') == "Divorced")@endif>Divorced</option>
                                        <option value="Awaiting Divorce" @if(isset($register->m_status)) {{$register->m_status == "Awaiting Divorce" ? "selected" : ''}}@else @selected(old('m_status') == "Awaiting Divorce")@endif>Awaiting Divorce</option>
                                        <option value="Widow" @if(isset($register->m_status)) {{$register->m_status == "Widow" ? "selected" : ''}}@else @selected(old('m_status') == "Widow")@endif>Widow</option>
                                    </select>
                                </div>
                                <div class="col-xl-6 col-lg-6 mb-3" id="dis_tot_children">
                                    <label class="label-1">No of Children</label>
                                    <input type="hidden" value="{{$register->tot_children}}" name="tot_children" id="tot_children">
                                    <select name="tot_children" class="form-select" id="no_children">
                                        <option value="" selected>select</option>
                                        <option value="No Children" @if(isset($register->tot_children)) {{$register->tot_children == "No Children" ? "selected" : ''}}@else @selected(old('tot_children') == "No Children")@endif>No Children</option>
                                        <option value="One" @if(isset($register->tot_children)) {{$register->tot_children == "One" ? "selected" : ''}}@else @selected(old('tot_children') == "One")@endif>One</option>
                                        <option value="Two" @if(isset($register->tot_children)) {{$register->tot_children == "Two" ? "selected" : ''}}@else @selected(old('tot_children') == "Two")@endif>Two</option>
                                        <option value="Three" @if(isset($register->tot_children)) {{$register->tot_children == "Three" ? "selected" : ''}}@else @selected(old('tot_children') == "Three")@endif>Three</option>
                                        <option value="Four" @if(isset($register->tot_children)) {{$register->tot_children == "Four" ? "selected" : ''}}@else @selected(old('tot_children') == "Four")@endif>Four</option>
                                        <option value="Four Pluse" @if(isset($register->tot_children)) {{$register->tot_children == "Four Pluse" ? "selected" : ''}}@else @selected(old('tot_children') == "Four Pluse")@endif>Four Pluse</option>
                                    </select>
                                </div>
                                <div class="col-xl-6 col-lg-6 mb-3" id="dis_child">
                                    <label class="label-1">Children Living Status</label>
                                    <select name="status_children" class="form-select" id="floatingSelect" >
                                        <option value="" selected>select</option>
                                        <option value="Living With Me"  @if(isset($register->status_children)){{$register->status_children == "Living With Me" ? "selected" : ''}}@else @selected(old('status_children') == "Living With Me")@endif>Living With Me</option>
                                        <option value="Not Living With Me"  @if(isset($register->status_children)){{$register->status_children == "Not Living With Me" ? "selected" : ''}}@else @selected(old('status_children') == "Not Living With Me")@endif>Not Living With Me</option>
                                    </select>
                                </div>
                                <div class="col-xl-6 col-lg-6 mb-3 chosen-style-2">
                                    <label class="label-1">Mother Tongue</label>
                                    <select name="m_tongue" class="form-select chosen-select" data-placeholder="Select Mother Tongue">
                                        <option value="" selected>select</option>
                                        @foreach ($mothertongues as $mothertongue)
                                        <option value="{{$mothertongue->id}}" @if(isset($register->m_tongue)){{$register->m_tongue == $mothertongue->id ? "selected" : ''}}@else @selected(old('m_tongue') == $mothertongue->id)@endif>{{$mothertongue->mtongue_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-xl-6 col-lg-6 mb-3">
                                    <label class="label-1">Profile Created By</label>
                                    <select name="profileby" class="form-select" required>
                                        <option value="" selected>select</option>
                                        @foreach ($profiles as $profile)
                                        <option value="{{$profile->profile_by}}" @if(isset($register->profileby)){{$register->profileby == $profile->profile_by ? "selected" : ''}}@else @selected(old('profileby') == $profile->profile_by)@endif>{{$profile->profile_by}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- /. Basic Details Section -->

                            <!-- Religion Details Section -->
                            <h4><i class="fas fa-book pe-2"></i>Religion Details</h4>
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 mb-3 chosen-style-2">
                                    <label class="label-1">Religion</label>
                                    <select name="religion" class="form-select chosen-select" data-placeholder="Select religion" id="religion" required>
                                        @foreach($religions as $religion)
                                        <option value="{{$religion->id}}" @if(isset($register->religion)){{$register->religion == $religion->id ? "selected" : ''}}@else @selected(old('religion') == $religion->id)@endif>{{$religion->religion_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-xl-6 col-lg-6 mb-3 chosen-style-2">
                                    <label class="label-1">Caste</label>
                                    <select name="caste" class="form-select chosen-select" data-placeholder="Select religion first" id="caste" required>
                                        
                                        @foreach($castes as $cast)
                                        <option value="{{$cast->id}}" @if(isset($register->caste)){{$register->caste == $cast->id ? "selected" : ''}}@else @selected(old('caste') == $cast->id)@endif>{{$cast->caste_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @if(!isset($fieldsetting->sub_caste) || $fieldsetting->sub_caste == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3 chosen-style-2">
                                    <label class="label-1">Sub Caste</label>
                                    <select name="subcaste" class="form-select chosen-select" data-placeholder="Select sub caste" id="floatingSelect">
                                        <option value="" selected>Select</option>
                                        @foreach($subcastes as $subcaste)
                                        <option value="{{$subcaste->id}}" @if(isset($register->subcaste)){{$register->subcaste == $subcaste->id ? "selected" : ''}}@else @selected(old('subcaste') == $subcaste->id)@endif>{{$subcaste->sub_caste_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                                @if(!isset($fieldsetting->gotra) || $fieldsetting->gotra == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3 chosen-style-2">
                                    <label class="label-1">Gotra</label>
                                    <select name="gotra" class="form-select chosen-select" data-placeholder="Select gotra" id="floatingSelect">
                                        <option value="" selected>Select</option>
                                        @foreach($gotras as $gotra)
                                        <option value="{{$gotra->id}}" @if(isset($register->gotra)){{$register->gotra == $gotra->id ? "selected" : ''}}@else @selected(old('gotra') == $gotra->id)@endif>{{$gotra->gotra_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                                @if(!isset($fieldsetting->will_to_marry) || $fieldsetting->will_to_marry == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3">
                                    <label  class="label-1">Willing to marry other caste?</label>
                                    <select name="will_to_mary_caste" class="form-select" id="floatingSelect">
                                        <option value="" selected>select</option>
                                        <option value="1" @if(isset($register->will_to_mary_caste)){{$register->will_to_mary_caste == "1" ? "selected" : ''}}@else @selected(old('will_to_mary_caste') == "1")@endif>Yes</option>
                                        <option value="0" @if(isset($register->will_to_mary_caste)){{$register->will_to_mary_caste == "0" ? "selected" : ''}}@else @selected(old('will_to_mary_caste') == "0")@endif>No</option>
                                    </select>
                                </div>
                                @endif
                                @if(!isset($fieldsetting->church_name) || $fieldsetting->church_name == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3">
                                    <label  class="label-1">Church Name</label>
                                    <input type="text" value="@if(isset($register->church_name)){{ $register->church_name }}@endif" name="church_name" class="form-control" placeholder="Enter church name">
                                </div>
                                @endif
                                @if(!isset($fieldsetting->denomination) || $fieldsetting->denomination == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3">
                                    <label  class="label-1">Denomination</label>
                                    <input type="text" value="@if(isset($register->denomination)){{ $register->denomination }}@endif" name="denomination" class="form-control" placeholder="Enter Denomination">
                                </div>
                                @endif
                                @if(!isset($fieldsetting->baptism) || $fieldsetting->baptism == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3">
                                    <label  class="label-1">Baptism</label>
                                    <select name="baptism" class="form-select" id="floatingSelect">
                                        <option value="" selected>select</option>
                                        <option value="Yes" @if(isset($register->baptism)){{$register->baptism == "Yes" ? "selected" : ''}}@else @selected(old('baptism') == "Yes")@endif>Yes</option>
                                        <option value="No" @if(isset($register->baptism)){{$register->baptism == "No" ? "selected" : ''}}@else @selected(old('baptism') == "No")@endif>No</option>
                                    </select>
                                </div>
                                @endif
                                @if(!isset($fieldsetting->born_again) || $fieldsetting->born_again == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3">
                                    <label  class="label-1">Born again?</label>
                                    <select name="born_again" class="form-select" id="floatingSelect">
                                        <option value="" selected>select</option>
                                        <option value="Yes" @if(isset($register->born_again)){{$register->born_again == "Yes" ? "selected" : ''}}@else @selected(old('born_again') == "Yes")@endif>Yes</option>
                                        <option value="No" @if(isset($register->born_again)){{$register->born_again == "No" ? "selected" : ''}}@else @selected(old('born_again') == "No")@endif>No</option>
                                    </select>
                                </div>
                                @endif
                            </div>
                            <!-- /. Religion Details Section -->

                            <!-- Education & Occupation Section -->
                            <h4><i class="fas fa-user-graduate pe-2"></i>Education / Occupation Details</h4>
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 mb-3 chosen-style-2">
                                    <label class="label-1">Highest Education</label>
                                    <?php if(isset($register->edu_detail)){$get_edu_details = explode(",",$register->edu_detail);}?>
                                    <select name="edu_detail[0]" class="form-select chosen-select" data-placeholder="Choose">
                                        <option value="" selected>Select</option>
                                        @foreach($edu_details as $edu_detail)
                                        <option value="{{$edu_detail->id}}" @if(isset($register->edu_detail)){{$edu_detail->id == $get_edu_details[0] ? "selected" : ''}}@else @selected(old('edu_detail') == $edu_detail->id)@endif>{{$edu_detail->edu_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @if(!isset($fieldsetting->additional_degree) || $fieldsetting->additional_degree == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3 chosen-style-2">
                                    <label class="label-1">Additional Degree :</label>
                                    <?php if(isset($register->edu_detail)){$get_edu_add = explode(",",$register->edu_detail);}?>
                                    <select name="edu_detail[1]" class="form-select chosen-select" data-placeholder="Choose">
                                        <option value="" selected>Select</option>
                                        @foreach($edu_details as $edu_detail)
                                        <option value="{{$edu_detail->id}}"  @if(isset($register->edu_detail)) @if($get_edu_add[0] != "") {{$edu_detail->id == $get_edu_add[0] ? "selected" : ''}}@else @selected(old('edu_detail') == $edu_detail->id)@endif @endif>{{$edu_detail->edu_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                                <div class="col-xl-6 col-lg-6 mb-3 chosen-style-2">
                                    <label class="label-1">Employed in :</label>
                                    <select name="emp_in" class="form-select chosen-select" data-placeholder="Choose">
                                        <option value="" selected>Select</option>
                                        <option value="Government" @if(isset($register->emp_in)){{$register->emp_in == "Government" ? "selected" : ''}}@else @selected(old('emp_in') == "Government")@endif>Government</option>
                                        <option value="Private" @if(isset($register->emp_in)){{$register->emp_in == "Private" ? "selected" : ''}}@else @selected(old('emp_in') == "Private")@endif>Private</option>
                                        <option value="Defence" @if(isset($register->emp_in)){{$register->emp_in == "Defence" ? "selected" : ''}}@else @selected(old('emp_in') == "Defence")@endif>Defence</option>
                                        <option value="Bussiness" @if(isset($register->emp_in)){{$register->emp_in == "Bussiness" ? "selected" : ''}}@else @selected(old('emp_in') == "Bussiness")@endif>Bussiness</option>
                                        <option value="Self Employed" @if(isset($register->emp_in)){{$register->emp_in == "Self Employed" ? "selected" : ''}}@else @selected(old('emp_in') == "Self Employed")@endif>Self Employed</option>
                                        <option value="Not Working" @if(isset($register->emp_in)){{$register->emp_in == "Not Working" ? "selected" : ''}}@else @selected(old('emp_in') == "Not Working")@endif>Not Working</option>
                                    </select>
                                </div>
                                <div class="col-xl-6 col-lg-6 mb-3 chosen-style-2">
                                    <label class="label-1">Occupation :</label>
                                    <select name="occupation" class="form-select chosen-select" data-placeholder="Choose" id="floatingSelect" >
                                        <option value="" selected>Select</option>
                                        @foreach($occupations as $occupation)
                                        <option value="{{$occupation->id}}" @if(isset($register->occupation)){{$register->occupation == $occupation->id ? "selected" : ''}}@else @selected(old('emp_in') == "Not Working")@endif>{{$occupation->ocp_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @if(!isset($fieldsetting->company_name) || $fieldsetting->company_name == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3">
                                    <label class="label-1">Company Name :</label>
                                    <input type="text" value="@if(isset($register->company_name)){{$register->company_name}}@else{{old('company_name')}}@endif" name="company_name" class="form-control" placeholder="Company Name">
                                </div>
                                @endif
                                @if(!isset($fieldsetting->designation) || $fieldsetting->designation == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3">
                                    <label class="label-1">Designation :</label>
                                    <input type="text" value="@if(isset($register->designation)){{$register->designation}}@else{{old('designation')}}@endif" name="designation" class="form-control" placeholder="Designation Name">
                                </div>
                                @endif
                                @if(!isset($fieldsetting->annual_income) || $fieldsetting->annual_income == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3 chosen-style-2">
                                    <label class="label-1">Annual Income :</label>
                                    <select name="income" class="form-select chosen-select" data-placeholder="Choose" id="floatingSelect" >
                                        <option value="" selected>Select</option>
                                        @foreach($incomes as $income)
                                        <option value="{{$income->id}}" @if(isset($register->income)){{$register->income == $income->id ? "selected" : ''}}@else @selected(old('income') == $income->id)@endif>{{$income->income}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                            </div>
                            <!-- /. Education & Occupation Section -->

                            <!-- Family Details Section -->
                            @if(!isset($fieldsetting) || $fieldsetting->family_type == "Yes" || $fieldsetting->family_value == "Yes" || $fieldsetting->family_status == "Yes" || $fieldsetting->father_name == "Yes" || $fieldsetting->father_occupation == "Yes" || $fieldsetting->mother_name == "Yes" || $fieldsetting->mother_occupation == "Yes" || $fieldsetting->no_of_brothers == "Yes" || $fieldsetting->no_marri_brother == "Yes" || $fieldsetting->no_of_sisters == "Yes" || $fieldsetting->no_marri_sister == "Yes" || $fieldsetting->maternal_details == "Yes" || $fieldsetting->paternal_details == "Yes")
                            <h4><i class="fas fa-people-group pe-2"></i>Family Details</h4>
                            <div class="row">
                                @if(!isset($fieldsetting->family_type) || $fieldsetting->family_type == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3">
                                    <label class="label-1">Family Type</label>
                                    <select name="family_type" class="form-select" id="floatingSelect">
                                        <option value="" selected>select</option>
                                        <option value="Middle class" @if(isset($register->family_type)){{$register->family_type == "Middle class" ? "selected" : ''}}@else @selected(old('family_type') == "Middle class")@endif>Middle class</option>
                                        <option value="Upper middle class" @if(isset($register->family_type)){{$register->family_type == "Upper middle class" ? "selected" : ''}}@else @selected(old('family_type') == "Upper middle class")@endif>Upper middle class</option>
                                        <option value="Rich" @if(isset($register->family_type)){{$register->family_type == "Rich" ? "selected" : ''}}@else @selected(old('family_type') == "Rich")@endif>Rich</option>
                                        <option value="Affluent" @if(isset($register->family_type)){{$register->family_type == "Affluent" ? "selected" : ''}}@else @selected(old('family_type') == "Affluent")@endif>Affluent</option>
                                    </select>
                                </div>
                                @endif
                                @if(!isset($fieldsetting->family_value) || $fieldsetting->family_value == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3">
                                    <label class="label-1">Family Value</label>
                                    <select name="family_value" class="form-select" id="floatingSelect">
                                        <option value="" selected>select</option>
                                        <option value="Joint" @if(isset($register->family_value)){{$register->family_value == "Joint" ? "selected" : ''}}@else @selected(old('family_value') == "Joint")@endif>Joint</option>
                                        <option value="Nuclear" @if(isset($register->family_value)){{$register->family_value == "Nuclear" ? "selected" : ''}}@else @selected(old('family_value') == "Nuclear")@endif>Nuclear</option>
                                    </select>
                                </div>
                                @endif
                                @if(!isset($fieldsetting->family_status) || $fieldsetting->family_status == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3">
                                    <label class="label-1">Family Status</label>
                                    <select name="family_status" class="form-select" id="floatingSelect">
                                        <option value="" selected>select</option>
                                        <option value="Orthodox" @if(isset($register->family_status)){{$register->family_status == "Orthodox" ? "selected" : ''}}@else @selected(old('family_status') == "Orthodox")@endif>Orthodox</option>
                                        <option value="Traditional" @if(isset($register->family_status)){{$register->family_status == "Traditional" ? "selected" : ''}}@else @selected(old('family_status') == "Traditional")@endif>Traditional</option>
                                        <option value="Moderate" @if(isset($register->family_status)){{$register->family_status == "Moderate" ? "selected" : ''}}@else @selected(old('family_status') == "Moderate")@endif>Moderate</option>
                                        <option value="Liberal" @if(isset($register->family_status)){{$register->family_status == "Liberal" ? "selected" : ''}}@else @selected(old('family_status') == "Liberal")@endif>Liberal</option>
                                    </select>
                                </div>
                                @endif
                                @if(!isset($fieldsetting->father_name) || $fieldsetting->father_name == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3">
                                    <label class="label-1">Father Name</label>
                                    <input type="text" value="@if(isset($register->father_name)){{$register->father_name}}@else{{old('father_name')}}@endif" name="father_name" class="form-control" placeholder="Father Name">
                                </div>
                                @endif
                                @if(!isset($fieldsetting->father_occupation) || $fieldsetting->father_occupation == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3">
                                    <label class="label-1">Father Occupation</label>
                                    <select name="father_occupation" class="form-select" id="floatingSelect" >
                                        <option value="" selected>Select</option>
                                        @foreach($occupations as $occupation)
                                        <option value="{{$occupation->ocp_name}}" @if(isset($register->father_occupation)){{$register->father_occupation == $occupation->ocp_name ? "selected" : ''}}@else @selected(old('father_occupation') == $occupation->ocp_name)@endif>{{$occupation->ocp_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                                @if(!isset($fieldsetting->mother_name) || $fieldsetting->mother_name == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3">
                                    <label class="label-1">Mother Name</label>
                                    <input type="text" value="@if(isset($register->mother_name)){{$register->mother_name}}@else{{old('mother_name')}}@endif" name="mother_name" class="form-control" placeholder="Mother Name">
                                </div>
                                @endif
                                @if(!isset($fieldsetting->mother_occupation) || $fieldsetting->mother_occupation == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3">
                                    <label class="label-1">Mother Occupation</label>
                                    <select name="mother_occupation" class="form-select" id="floatingSelect" >
                                        <option value="" selected>Select</option>
                                        @foreach($occupations as $occupation)
                                        <option value="{{$occupation->ocp_name}}" @if(isset($register->mother_occupation)){{$register->mother_occupation == $occupation->ocp_name ? "selected" : ''}}@else @selected(old('mother_occupation') == $occupation->ocp_name)@endif>{{$occupation->ocp_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                                @if(!isset($fieldsetting->no_of_brother) || $fieldsetting->no_of_brother == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3" id="no_brothers">
                                    <label class="label-1">No Of Brothers</label>
                                    <input type="hidden" value="{{$register->no_of_brothers}}" name="no_of_brothers" id="no_of_brothers">
                                    <select name="no_of_brothers" class="form-select" id="no_brother">
                                        <option value="" selected>select</option>
                                        <option value="No Brother" @if(isset($register->no_of_brothers)) {{$register->no_of_brothers == "No Brother" ? "selected" : ''}}@else @selected(old('no_of_brothers') == "No Brother")@endif>No Brother</option>
                                        <option value="1 Brother" @if(isset($register->no_of_brothers)) {{$register->no_of_brothers == "1 Brother" ? "selected" : ''}}@else @selected(old('no_of_brothers') == "1 Brother")@endif>1 Brother</option>
                                        <option value="2 Brothers" @if(isset($register->no_of_brothers)) {{$register->no_of_brothers == "2 Brothers" ? "selected" : ''}}@else @selected(old('no_of_brothers') == "2 Brothers")@endif>2 Brothers</option>
                                        <option value="3 Brothers" @if(isset($register->no_of_brothers)) {{$register->no_of_brothers == "3 Brothers" ? "selected" : ''}}@else @selected(old('no_of_brothers') == "3 Brothers")@endif>3 Brothers</option>
                                        <option value="4 Brothers" @if(isset($register->no_of_brothers)) {{$register->no_of_brothers == "4 Brothers" ? "selected" : ''}}@else @selected(old('no_of_brothers') == "4 Brothers")@endif>4 Brothers</option>
                                        <option value="4 + Brothers" @if(isset($register->no_of_brothers)) {{$register->no_of_brothers == "4 + Brothers" ? "selected" : ''}}@else @selected(old('no_of_brothers') == "4 + Brothers")@endif>4 + Brothers</option>
                                    </select>
                                </div>
                                @endif
                                @if(!isset($fieldsetting->no_of_married_brother) || $fieldsetting->no_of_married_brother == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3" id="no_marri_brother">
                                    <label class="label-1">No Of Married Brothers</label>
                                    <select name="no_marri_brother" class="form-select" id="floatingSelect">
                                        <option value="" selected>select</option>
                                        <option value="No married brother" @if(isset($register->no_marri_brother)) {{$register->no_marri_brother == "No married brother" ? "selected" : ''}}@else @selected(old('no_marri_brother') == "No married brother")@endif>No married brother</option>
                                        <option value="1 married brother" @if(isset($register->no_marri_brother)) {{$register->no_marri_brother == "1 married brother" ? "selected" : ''}}@else @selected(old('no_marri_brother') == "1 married brother")@endif>1 married brother</option>
                                        <option value="2 married brothers" @if(isset($register->no_marri_brother)) {{$register->no_marri_brother == "2 married brothers" ? "selected" : ''}}@else @selected(old('no_marri_brother') == "2 married brothers")@endif>2 married brothers</option>
                                        <option value="3 married brothers" @if(isset($register->no_marri_brother)) {{$register->no_marri_brother == "3 married brothers" ? "selected" : ''}}@else @selected(old('no_marri_brother') == "3 married brothers")@endif>3 married brothers</option>
                                        <option value="4 married brothers" @if(isset($register->no_marri_brother)) {{$register->no_marri_brother == "4 married brothers" ? "selected" : ''}}@else @selected(old('no_marri_brother') == "4 married brothers")@endif>4 married brothers</option>
                                        <option value="4 + married brothers" @if(isset($register->no_marri_brother)) {{$register->no_marri_brother == "4 + married brothers" ? "selected" : ''}}@else @selected(old('no_marri_brother') == "4 + married brothers")@endif>4 + married brothers</option>

                                    </select>
                                </div>
                                @endif
                                @if(!isset($fieldsetting->no_of_sister) || $fieldsetting->no_of_sister == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3" id="no_of_sister">
                                    <label class="label-1">No Of Sisters</label>
                                    <input type="hidden" value="{{$register->no_of_sisters}}" name="no_of_sisters" id="no_of_sisters">
                                    <select name="no_of_sisters" class="form-select" id="no_sister">
                                        <option value="" selected>select</option>
                                        <option value="No Sister" @if(isset($register->no_of_sisters)) {{$register->no_of_sisters == "No Sister" ? "selected" : ''}}@else @selected(old('no_of_sisters') == "No Sister")@endif>No Sister</option>                                            
                                        <option value="1 Sister" @if(isset($register->no_of_sisters)) {{$register->no_of_sisters == "1 Sister" ? "selected" : ''}}@else @selected(old('no_of_sisters') == "1 Sister")@endif>1 Sister</option>
                                        <option value="2 Sisters" @if(isset($register->no_of_sisters)) {{$register->no_of_sisters == "2 Sisters" ? "selected" : ''}}@else @selected(old('no_of_sisters') == "2 Sisters")@endif>2 Sisters</option>
                                        <option value="3 Sisters" @if(isset($register->no_of_sisters)) {{$register->no_of_sisters == "3 Sisters" ? "selected" : ''}}@else @selected(old('no_of_sisters') == "3 Sisters")@endif>3 Sisters</option>
                                        <option value="4 Sisters" @if(isset($register->no_of_sisters)) {{$register->no_of_sisters == "4 Sisters" ? "selected" : ''}}@else @selected(old('no_of_sisters') == "4 Sisters")@endif>4 Sisters</option>
                                        <option value="4 + Sisters" @if(isset($register->no_of_sisters)) {{$register->no_of_sisters == "4 + Sisters" ? "selected" : ''}}@else @selected(old('no_of_sisters') == "4 + Sisters")@endif>4 + Sisters</option>
                                    </select>
                                </div>
                                @endif
                                @if(!isset($fieldsetting->no_of_married_sister) || $fieldsetting->no_of_married_sister == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3" id="no_marri_sister">
                                    <label class="label-1">No Of Married Sisters</label>
                                    <select name="no_marri_sister" class="form-select" id="floatingSelect">
                                        <option value="" selected>select</option>
                                        <option value="No married sister" @if(isset($register->no_marri_sister)) {{$register->no_marri_sister == "No married sister" ? "selected" : ''}}@else @selected(old('no_marri_sister') == "No married sister")@endif>No married sister</option>
                                        <option value="1 married sister" @if(isset($register->no_marri_sister)) {{$register->no_marri_sister == "1 married sister" ? "selected" : ''}}@else @selected(old('no_marri_sister') == "1 married sister")@endif>1 married sister</option>
                                        <option value="2 married sisters" @if(isset($register->no_marri_sister)) {{$register->no_marri_sister == "2 married sisters" ? "selected" : ''}}@else @selected(old('no_marri_sister') == "2 married sisters")@endif>2 married sisters</option>
                                        <option value="3 married sisters" @if(isset($register->no_marri_sister)) {{$register->no_marri_sister == "3 married sisters" ? "selected" : ''}}@else @selected(old('no_marri_sister') == "3 married sisters")@endif>3 married sisters</option>
                                        <option value="4 married sisters" @if(isset($register->no_marri_sister)) {{$register->no_marri_sister == "4 married sisters" ? "selected" : ''}}@else @selected(old('no_marri_sister') == "4 married sisters")@endif>4 married sisters</option>
                                        <option value="4+ married sisters" @if(isset($register->no_marri_sister)) {{$register->no_marri_sister == "4+ married sisters" ? "selected" : ''}}@else @selected(old('no_marri_sister') == "4+ married sisters")@endif>4+ married sisters</option>
                                    </select>
                                </div>
                                @endif
                                @if(!isset($fieldsetting->maternal_details) || $fieldsetting->maternal_details == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3">
                                    <label class="label-1">Maternal Details</label>
                                    <textarea class="form-control" name="maternal_details" >@if(isset($register->maternal_details)){{$register->maternal_details}}@else{{old('maternal_details')}}@endif</textarea>
                                </div>
                                @endif
                                @if(!isset($fieldsetting->paternal_details) || $fieldsetting->paternal_details == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3">
                                    <label class="label-1">Paternal Details</label>
                                    <textarea class="form-control" name="paternal_details">@if(isset($register->paternal_details)){{$register->paternal_details}}@else{{old('paternal_details')}}@endif</textarea>
                                </div>
                                @endif

                            </div>
                            @endif
                            <!-- /. Family Details Section -->

                            <!-- Location Details Section -->
                            <h4><i class="fas fa-location-dot pe-2"></i>Location Details</h4>
                            <div class="row">
                                <input class="form-control" type="hidden" value="@if(isset($register->id)){{$register->id}}@endif" name="id" id="id">
                                <input class="form-control" type="hidden" value="@if(isset($register->state_id)){{$register->state_id}}@endif" name="state_id" id="state_id">
                                <input class="form-control" type="hidden" value="@if(isset($register->city)){{$register->city}}@endif" name="city_id" id="city_id">
                                <div class="col-xl-6 col-lg-6 mb-3 chosen-style-2">
                                    <label class="label-1">Country</label>
                                    <select name="country_id" class="form-select chosen-select" data-placeholder="Choose" id="country">
                                        <option value="" selected>Select</option>
                                        @foreach($countries as $country)
                                        <option value="{{$country->id}}" @if(isset($register->country_id)){{$register->country_id == $country->id ? "selected" : ''}}@else @selected(old('country_id') == $country->id)@endif>{{$country->country_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-xl-6 col-lg-6 mb-3 chosen-style-2">
                                    <label class="label-1">State</label>
                                    <select name="state_id" class="form-select chosen-select" data-placeholder="Choose" id="state" >
                                        <option value="" selected>Select</option>
                                        @foreach($states as $state)
                                        <option value="{{ $state->id }}" @if(isset($register->state_id)){{$register->state_id == $state->id ? "selected" : ''}}@else @selected(old('state_id') == $state->id)@endif>{{$state->state_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-xl-6 col-lg-6 mb-3 chosen-style-2">
                                    <label class="label-1">City</label>
                                    <select name="city" class="form-select chosen-select" data-placeholder="Choose" id="city" >
                                        <option value="" selected>Select</option>
                                        @foreach($cities as $city)
                                        <option value="{{$city->id}}" @if(isset($register->city)){{$register->city == $city->id ? "selected" : ''}}@else @selected(old('city') == $city->id)@endif>{{$city->city_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @if(!isset($fieldsetting->address) || $fieldsetting->address == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3">
                                    <label class="label-1">Address</label>
                                    <textarea class="form-control" name="address">@if(isset($register->address)){{$register->address}}@else{{old('address')}}@endif</textarea>
                                </div>
                                @endif
                            </div>
                            <!-- /. Location Details Section -->

                            <!-- Habits & Hobbies Section -->
                            @if(!isset($fieldsetting) || $fieldsetting->diet == "Yes" || $fieldsetting->smoke == "Yes" || $fieldsetting->drink == "Yes")
                            <h4><i class="fas fa-utensils pe-2"></i>Habits & Hobbies</h4>
                            <div class="row">
                                @if(!isset($fieldsetting->diet) || $fieldsetting->diet == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3">
                                    <label class="label-1">Eating Habits</label>
                                    <select NAME="diet" class="form-select">
                                        <option value="" selected>Select</option>
                                        <option value="Vegetarian" @if(isset($register->diet)){{$register->diet == "Vegetarian" ? "selected" : ''}}@else @selected(old('diet') == "Vegetarian")@endif>Vegetarian</option>
                                        <option value="Non Vegetarian"@if(isset($register->diet)){{$register->diet == "Non Vegetarian" ? "selected" : ''}}@else @selected(old('diet') == "Non Vegetarian")@endif>Non Vegetarian</option>
                                        <option value="Eggetarian"@if(isset($register->diet)){{$register->diet == "Eggetarian" ? "selected" : ''}}@else @selected(old('diet') == "Eggetarian")@endif>Eggetarian</option>
                                    </select>
                                </div>
                                @endif
                                @if(!isset($fieldsetting->smoke) || $fieldsetting->smoke == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3">
                                    <label class="label-1">Smoking Habits</label>
                                    <select NAME="smoke" class="form-select">
                                        <option value="" selected>Select</option>
                                        <option value="No"@if(isset($register->smoke)){{$register->smoke == "No" ? "selected" : ''}}@else @selected(old('smoke') == "No")@endif>No</option>
                                        <option value="Occasionally"@if(isset($register->smoke)){{$register->smoke == "Occasionally" ? "selected" : ''}}@else @selected(old('smoke') == "Occasionally")@endif>Occasionally</option>
                                        <option value="Yes"@if(isset($register->smoke)){{$register->smoke == "Yes" ? "selected" : ''}}@else @selected(old('smoke') == "Yes")@endif>Yes</option>
                                    </select>
                                </div>
                                @endif
                                @if(!isset($fieldsetting->drink) || $fieldsetting->drink == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3">
                                    <label class="label-1">Drinking Habits</label>
                                    <select name="drink" class="form-select">
                                        <option value="" selected>Select</option>
                                        <option value="No"@if(isset($register->drink)){{$register->drink == "No" ? "selected" : ''}}@else @selected(old('drink') == "No")@endif>No</option>
                                        <option value="Drinks Socially"@if(isset($register->drink)){{$register->drink == "Drinks Socially" ? "drink" : ''}}@else @selected(old('income') == "Drinks Socially")@endif>Drinks Socially</option>
                                        <option value="Yes"@if(isset($register->drink)){{$register->drink == "Yes" ? "selected" : ''}}@else @selected(old('drink') == "Yes")@endif>Yes</option>
                                    </select>
                                </div>
                                @endif
                            </div>
                            @endif
                            <!-- /. Habits & Hobbies Section -->

                            <!-- Physical Attributes Section -->
                            @if(!isset($fieldsetting) || $fieldsetting->height == "Yes" || $fieldsetting->weight == "Yes" || $fieldsetting->body_type == "Yes" || $fieldsetting->complexion == "Yes" || $fieldsetting->physical_status == "Yes" || $fieldsetting->b_group == "Yes")
                            <h4><i class="fas fa-person pe-2"></i>Physical Attributes</h4>
                            <div class="row">
                                @if(!isset($fieldsetting->height) || $fieldsetting->height == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3">
                                    <label class="label-1">Height</label>
                                    <select name="height" class="form-select">
                                        <option value="" selected>Select</option>
                                        @foreach($heights as $height)
                                        <option value="{{$height->id}}" @if(isset($register->height)){{$register->height == $height->id ? "selected" : ''}}@else @selected(old('height') == $height->id)@endif>{{$height->height}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                                @if(!isset($fieldsetting->weight) || $fieldsetting->weight == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3">
                                    <label class="label-1">Weight</label>
                                    <?php
                                        $weight_first = $siteconfig->weight_first;
                                        $weight_last = $siteconfig->weight_last;
                                    ?>
                                    <select name="weight" class="form-select">
                                        <option value="" selected>Select</option>
                                    @if(isset($weight_last) && isset($weight_first))
                                        @for($i=$weight_first;$i<=$weight_last;$i++)
                                        <option value="{{$i}}" @if(isset($register->weight)){{$register->weight == $i ? "selected" : ''}}@else @selected(old('weight') == $i)@endif>{{$i}}</option>
                                        @endfor
                                    @endif
                                </select>
                                </div>
                                @endif
                                @if(!isset($fieldsetting->body_type) || $fieldsetting->body_type == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3">
                                    <label class="label-1">Body Type</label>
                                    <select name="bodytype" class="form-select">
                                        <option value="" selected>Select</option>
                                        <option value="Slim"@if(isset($register->bodytype)){{$register->bodytype == "Slim" ? "selected" : ''}}@else @selected(old('bodytype') == "Slim")@endif>Slim</option>
                                        <option value="Average"@if(isset($register->bodytype)){{$register->bodytype == "Average" ? "selected" : ''}}@else @selected(old('bodytype') == "Average")@endif>Average</option>
                                        <option value="Athletic"@if(isset($register->bodytype)){{$register->bodytype == "Athletic" ? "selected" : ''}}@else @selected(old('bodytype') == "Athletic")@endif>Athletic</option>
                                        <option value="Heavy"@if(isset($register->bodytype)){{$register->bodytype == "Heavy" ? "selected" : ''}}@else @selected(old('bodytype') == "Heavy")@endif>Heavy</option>
                                    </select>
                                </div>
                                @endif
                                @if(!isset($fieldsetting->complexion) || $fieldsetting->complexion == "Yes" )
                                    <div class="col-xl-6 col-lg-6 mb-3">
                                        <label class="label-1">Complexion</label>
                                        <select name="complexion" class="form-select">
                                            <option value="" selected>Select</option>
                                            <option value="Very Fair"@if(isset($register->complexion)){{$register->complexion == "Very Fair" ? "selected" : ''}}@else @selected(old('complexion') == "Very Fair")@endif>Very Fair</option>
                                            <option value="Fair"@if(isset($register->complexion)){{$register->complexion == "Fair" ? "selected" : ''}}@else @selected(old('complexion') == "Fair")@endif>Fair</option>
                                            <option value="Wheatish"@if(isset($register->complexion)){{$register->complexion == "Wheatish" ? "selected" : ''}}@else @selected(old('complexion') == "Wheatish")@endif>Wheatish</option>
                                            <option value="Wheatish brown"@if(isset($register->complexion)){{$register->complexion == "Wheatish brown" ? "selected" : ''}}@else @selected(old('complexion') == "Wheatish")@endif>Wheatish brown</option>
                                            <option value="Dark"@if(isset($register->complexion)){{$register->complexion == "Dark" ? "selected" : ''}}@else @selected(old('complexion') == "Dark")@endif>Dark</option>
                                        </select>
                                    </div>
                                @endif
                                @if(!isset($fieldsetting->physical_status) || $fieldsetting->physical_status == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3">
                                    <label class="label-1">Physical Status</label>
                                    <select name="physical_status" class="form-select">
                                        <option value="" selected>Select</option>
                                        <option value="Normal"@if(isset($register->physicalStatus)){{$register->physicalStatus == "Normal" ? "selected" : ''}}@else @selected(old('physicalStatus') == "Normal")@endif>Normal</option>
                                        <option value="Physically challenged"@if(isset($register->physicalStatus)){{$register->physicalStatus == "Physically challenged" ? "selected" : ''}}@else @selected(old('physicalStatus') == "Physically challenged")@endif>Physically challenged</option>
                                    </select>
                                </div>
                                @endif
                                @if(!isset($fieldsetting->b_group) || $fieldsetting->b_group == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3">
                                    <label class="label-1">Blood Group</label>
                                    <select name="b_group" class="form-select">
                                        <option value="" selected>Select</option>
                                        <option value="O negative"@if(isset($register->b_group)){{$register->b_group == "O negative" ? "selected" : ''}}@else @selected(old('b_group') == "O negative")@endif>O negative</option>
                                        <option value="O positive"@if(isset($register->b_group)){{$register->b_group == "O positive" ? "selected" : ''}}@else @selected(old('b_group') == "O positive")@endif>O positive</option>
                                        <option value="A negative"@if(isset($register->b_group)){{$register->b_group == "A negative" ? "selected" : ''}}@else @selected(old('b_group') == "A negative")@endif>A negative</option>
                                        <option value="A positive"@if(isset($register->b_group)){{$register->b_group == "A positive" ? "selected" : ''}}@else @selected(old('b_group') == "A positive")@endif>A positive</option>
                                        <option value="B negative"@if(isset($register->b_group)){{$register->b_group == "B negative" ? "selected" : ''}}@else @selected(old('b_group') == "B negative")@endif>B negative</option>
                                        <option value="B positive"@if(isset($register->b_group)){{$register->b_group == "B positive" ? "selected" : ''}}@else @selected(old('b_group') == "B positive")@endif>B positive</option>
                                        <option value="AB negative"@if(isset($register->b_group)){{$register->b_group == "AB negative" ? "selected" : ''}}@else @selected(old('b_group') == "AB negative")@endif>AB negative</option>
                                        <option value="AB positive"@if(isset($register->b_group)){{$register->b_group == "AB positive" ? "selected" : ''}}@else @selected(old('b_group') == "AB positive")@endif>AB positive</option>
                                    </select>
                                </div>
                                @endif
                            </div>
                            @endif
                            <!-- /. Physical Attributes Section -->

                            <!-- Horoscope Information Section -->
                            @if(!isset($fieldsetting) || $fieldsetting->dosh == "Yes" || $fieldsetting->manglik == "Yes" || $fieldsetting->rasi == "Yes" || $fieldsetting->star == "Yes" || $fieldsetting->birthtime == "Yes" || $fieldsetting->birthplace == "Yes")
                            <h4><i class="fas fa-star pe-2"></i>Horoscope Information</h4>
                            <div class="row">
                                @if(!isset($fieldsetting->dosh) || $fieldsetting->dosh == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3">
                                    <input type="hidden" value="{{$register->dosh}}" name="dosh" id="dosh">
                                    <label class="label-1">Have Dosh</label>
                                    <select name="dosh" class="form-select" id="havedosh">
                                        <option value="" selected>Select</option>
                                        <option value="Yes"@if(isset($register->dosh)){{$register->dosh == "Yes" ? "selected" : ''}}@else @selected(old('dosh') == "Yes")@endif>Yes</option>
                                        <option value="No"@if(isset($register->dosh)){{$register->dosh == "No" ? "selected" : ''}}@else @selected(old('dosh') == "No")@endif>No</option>
                                    </select>
                                </div>
                                @endif
                                @if(!isset($fieldsetting->manglik) || $fieldsetting->manglik == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3" id="manglik">
                                    <label class="label-1">Dosh Type</label>
                                    <select name="manglik" class="form-select" id="floatingSelect" >
                                        <option value="" selected>Select</option>
                                        @foreach($doshes as $dosh)
                                        <option value="{{$dosh->id}}" @if(isset($register->manglik)){{$register->manglik == $dosh->id ? "selected" : ''}}@else @selected(old('manglik') == $dosh->id)@endif>{{$dosh->dosh}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                                @if(!isset($fieldsetting->rasi) || $fieldsetting->rasi == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3">
                                    <label class="label-1">Rasi / Moonsign</label>
                                    <select name="moonsign" class="form-select" id="floatingSelect" >
                                        <option value="" selected>Select</option>
                                        @foreach($rashies as $rasi)
                                        <option value="{{$rasi->id}}" @if(isset($register->moonsign)){{$register->moonsign == $rasi->id ? "selected" : ''}}@else @selected(old('moonsign') == $rasi->id)@endif>{{$rasi->rasi}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                                @if(!isset($fieldsetting->star) || $fieldsetting->star == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3">
                                    <label class="label-1">Star</label>
                                    <select name="star" class="form-select" id="floatingSelect" >
                                        <option value="" selected>Select</option>
                                        @foreach($stars as $star)
                                        <option value="{{$star->id}}" @if(isset($register->star)){{$register->star == $star->id ? "selected" : ''}}@else @selected(old('star') == $star->id)@endif>{{$star->star}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                                @if(!isset($fieldsetting->birthtime) || $fieldsetting->birthtime == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3">
                                    <label class="label-1">Birth Time</label>
                                    <input type="time" value="@if(isset($register->birthtime)){{$register->birthtime}}@else{{old('birthtime')}}@endif" name="birthtime" class="form-control">
                                </div>
                                @endif
                                @if(!isset($fieldsetting->birthplace) || $fieldsetting->birthplace == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3">
                                    <label class="label-1">Birth Place</label>
                                    <input type="text" value="@if(isset($register->birthplace)){{$register->birthplace}}@else{{old('birthplace')}}@endif" name="birthplace" class="form-control">
                                </div>
                                @endif
                            </div>
                            @endif
                            <!-- /. Horoscope Information Section -->
                            
                            <!-- About Me Section -->
                            @if(!isset($fieldsetting->profile_text) || $fieldsetting->profile_text == "Yes" )
                            <h4><i class="fas fa-user pe-2"></i>About Me<h4>
                            <div class="row">
                                <div class="col-xl-12 mb-3">
                                   <textarea rows="4" name="profile_text" class="form-control">@if(isset($register->profile_text)){{$register->profile_text}}@else{{old('profile_text')}}@endif</textarea>
                                </div>
                            </div>
                            @endif
                            <!-- /. About Me Section -->
                            <div class="text-center mt-3">
                                <input type="submit" value="UPDATE" name="personalDetailsUpdate" class="btn btnPrimary">
                            </div>
                        </form>
                    </div>
                </div>
            
                <div class="col-12 inEditPrefPartHeader text-center">
                    <h3><i class="fas fa-heart pe-2"></i>Partner Preference</h3>
                </div>

                <!-- Partner Preference Section -->
                <div class="card mb-4 inEditCard">
                    <div class="card-header">
                        <h4>Edit Partner Preference<h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" id="register_form" action="{{ route('user.profileupdate', $register->id) }}" enctype="multipart/form-data">
                            @csrf
                            <!-- Basic Preference Section -->
                            <h4><i class="fas fa-file-text pe-2"></i>Basic Preference</h4>
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 mb-3 chosen-style-3">
                                    <label class="label-1">Marital Status</label>
                                    <?php if(isset($register->looking_for)){{$get_looking = explode(",",$register->looking_for);}}?>
                                    <select name="looking_for[]" class="form-select chosen-select" id="floatingSelect" data-placeholder="Choose" multiple>
                                        <option value="" >select</option>
                                        <option value="Never Married" @if(isset($register->looking_for)) @if(in_array("Never Married",$get_looking)) {{"selected"}}@endif @endif>Never Married</option>
                                        <option value="Widower" @if(isset($register->looking_for)) @if(in_array("Widower",$get_looking)){{"selected"}} @endif @endif>Widower</option>
                                        <option value="Divorced"  @if(isset($register->looking_for)) @if(in_array("Divorced",$get_looking)){{"selected"}} @endif @endif>Divorced</option>
                                        <option value="Awaiting Divorce"  @if(isset($register->looking_for)) @if(in_array("Awaiting Divorce",$get_looking)){{"selected"}} @endif @endif>Awaiting Divorce</option>
                                        <option value="Widow"  @if(isset($register->looking_for)) @if(in_array("Widow",$get_looking)){{"selected"}} @endif @endif>Widow</option>
                                    </select>
                                </div>
                                <div class="col-xl-6 col-lg-6 mb-3">
                                    <label class="label-1">Age</label>
                                    <div class="row">
                                        <div class="col-5">
                                            <select name="part_frm_age" class="form-select" id="part_frm_age" >
                                                <option value="" selected>select</option>
                                                @foreach ($ages as $age)
                                                <option value="{{$age->id}}" @if(isset($register->part_frm_age)){{$register->part_frm_age == $age->id ? "selected" : ''}}@else @selected(old('part_frm_age') == $age->id)@endif>{{$age->age}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-2 text-center pt-2">
                                            <h4 class="fs-6">To</h4>
                                        </div>
                                        <div class="col-5">
                                            <select name="part_to_age" class="form-select" id="part_to_age" >
                                                <option value="" selected>select</option>
                                                @foreach ($ages as $age)
                                                <option value="{{$age->id}}" @if(isset($register->part_to_age)){{$register->part_to_age == $age->id ? "selected" : ''}}@else @selected(old('part_to_age') == $age->id)@endif>{{$age->age}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 mb-3">
                                    <label class="label-1">Height</label>
                                    <div class="row">
                                        <div class="col-5">
                                            <select name="part_height" class="form-select" id="part_frm_height" >
                                                <option value="" selected>Select</option>
                                                @foreach($heights as $height)
                                                <option value="{{$height->id}}" @if(isset($register->part_height)){{$register->part_height == $height->id ? "selected" : ''}}@else @selected(old('part_height') == $height->id)@endif>{{$height->height}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-2 text-center pt-2">
                                            <h4 class="fs-6">To</h4>
                                        </div>
                                        <div class="col-5">
                                            <select name="part_height_to" class="form-select" id="part_to_height">
                                                <option value="" selected>Select</option>
                                                @foreach($heights as $height)
                                                <option value="{{$height->id}}" @if(isset($register->part_height_to)){{$register->part_height_to == $height->id ? "selected" : ''}}@else @selected(old('part_height_to') == $height->id)@endif>{{$height->height}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>  
                                </div>
                                <div class="col-xl-6 col-lg-6 mb-3 chosen-style-3">
                                    <label class="label-1">Mother Tongue</label>
                                    <?php if(isset($register->part_mtongue)){$get_mother_tongue = explode(",",$register->part_mtongue);}?>
                                    <select name="part_mtongue[]" class="form-select chosen-select" data-placeholder="Choose" multiple>
                                        <option value="" >select</option>
                                        @foreach ($mothertongues as $mothertongue)
                                        <option value="{{$mothertongue->id}}" @if(isset($register->part_mtongue)) @if(in_array($mothertongue->id,$get_mother_tongue)) {{"selected"}} @endif @endif>{{$mothertongue->mtongue_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @if(!isset($fieldsetting->part_physical_status) || $fieldsetting->part_physical_status == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3 chosen-style-3">
                                    <label class="label-1">Physical Status</label>
                                    <?php if(isset($register->part_physical)){$get_part_physical = explode(",",$register->part_physical);}?>
                                    <select name="part_physical[]" class="form-select chosen-select" data-placeholder="Choose" multiple>
                                        <option value="">Select</option>
                                        <option value="Normal" @if(isset($register->part_physical)) @if(in_array("Normal",$get_part_physical)) {{"selected"}} @endif @endif>Normal</option>
                                        <option value="Physically challenged" @if(isset($register->part_physical)) @if(in_array("Physically challenged",$get_part_physical)) {{"selected"}} @endif @endif>Physically challenged</option>
                                    </select>
                                </div>
                                @endif
                                @if(!isset($fieldsetting->part_complexation) || $fieldsetting->part_complexation == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3 chosen-style-3">
                                    <label class="label-1">Complexion</label>
                                    <?php if(isset($register->part_complexation)){$get_part_complexation = explode(",",$register->part_complexation);}?>
                                    <select name="part_complexation[]" class="form-select chosen-select" data-placeholder="Choose" multiple>
                                            <option value="">Select</option>
                                            <option value="Very Fair" @if(isset($register->part_complexation)) @if(in_array("Very Fair",$get_part_complexation)) {{"selected"}}@endif @endif>Very Fair</option>
                                            <option value="Fair" @if(isset($register->part_complexation)) @if(in_array("Fair",$get_part_complexation)) {{"selected"}}@endif @endif>Fair</option>
                                            <option value="Wheatish" @if(isset($register->part_complexation)) @if(in_array("Wheatish",$get_part_complexation)) {{"selected"}}@endif @endif>Wheatish</option>
                                            <option value="Wheatish brown" @if(isset($register->part_complexation)) @if(in_array("Wheatish brown",$get_part_complexation)) {{"selected"}}@endif @endif>Wheatish brown</option>
                                            <option value="Dark" @if(isset($register->part_complexation)) @if(in_array("Dark",$get_part_complexation)) {{"selected"}}@endif @endif>Dark</option>
                                        </select>
                                </div>
                                @endif
                                @if(!isset($fieldsetting->part_bodytype) || $fieldsetting->part_bodytype == "Yes" )
                                 <div class="col-xl-6 col-lg-6 mb-3 chosen-style-3">
                                    <label class="label-1">Body Type</label>
                                    <?php if(isset($register->part_bodytype)){$get_part_bodytype = explode(",",$register->part_bodytype);}?>
                                    <select name="part_bodytype[]" class="form-select chosen-select" data-placeholder="Choose" multiple>
                                        <option value="">Select</option>
                                        <option value="Slim" @if(isset($register->part_bodytype)) @if(in_array("Slim",$get_part_bodytype)) {{"selected"}}@endif @endif>Slim</option>
                                        <option value="Average" @if(isset($register->part_bodytype)) @if(in_array("Average",$get_part_bodytype)) {{"selected"}}@endif @endif>Average</option>
                                        <option value="Athletic" @if(isset($register->part_bodytype)) @if(in_array("Athletic",$get_part_bodytype)) {{"selected"}}@endif @endif>Athletic</option>
                                        <option value="Heavy" @if(isset($register->part_bodytype)) @if(in_array("Heavy",$get_part_bodytype)) {{"selected"}}@endif @endif>Heavy</option>
                                    </select>
                                </div> 
                                @endif
                            </div>
                            <!-- /. Basic Preference Section -->

                            <!--  Habit Preference Section -->
                            @if(!isset($fieldsetting) && $fieldsetting->part_diet == "Yes" || $fieldsetting->part_smoke == "Yes" || $fieldsetting->part_drink == "Yes")
                            <h4><i class="fas fa-wine-glass pe-2"></i>Habit Preference</h4>
                            <div class="row">
                                @if(!isset($fieldsetting->part_diet) || $fieldsetting->part_diet == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3 chosen-style-3">
                                    <label class="label-1">Eating Habits</label>
                                    <?php if(isset($register->part_diet)){$get_part_diet = explode(",",$register->part_diet);}?>
                                    <select NAME="part_diet[]" class="form-select chosen-select" id="floatingSelect" data-placeholder="Choose" multiple>
                                        <option value="">Select</option>
                                        <option value="Vegetarian" @if(isset($register->part_diet)) @if(in_array("Vegetarian",$get_part_diet)) {{"selected"}}@endif @endif>Vegetarian</option>
                                        <option value="Non Vegetarian" @if(isset($register->part_diet)) @if(in_array("Non Vegetarian",$get_part_diet)) {{"selected"}}@endif @endif>Non Vegetarian</option>
                                        <option value="Eggetarian" @if(isset($register->part_diet)) @if(in_array("Eggetarian",$get_part_diet)) {{"selected"}}@endif @endif>Eggetarian</option>
                                    </select>
                                </div>
                                @endif
                                @if(!isset($fieldsetting->part_smoke) || $fieldsetting->part_smoke == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3 chosen-style-3">
                                    <label class="label-1">Smoking Habits</label>
                                    <?php if(isset($register->part_smoke)){$get_part_smoke = explode(",",$register->part_smoke);}?>
                                    <select NAME="part_smoke[]" class="form-select chosen-select" id="floatingSelect" data-placeholder="Choose" multiple>
                                        <option value="">Select</option>
                                        <option value="No" @if(isset($register->part_smoke)) @if(in_array("No",$get_part_smoke)) {{"selected"}}@endif @endif>No</option>
                                        <option value="Occasionally" @if(isset($register->part_smoke)) @if(in_array("Occasionally",$get_part_smoke)) {{"selected"}}@endif @endif>Occasionally</option>
                                        <option value="Yes" @if(isset($register->part_smoke)) @if(in_array("Yes",$get_part_smoke)) {{"selected"}}@endif @endif>Yes</option>
                                    </select>
                                </div>
                                @endif
                                @if(!isset($fieldsetting->part_drink) || $fieldsetting->part_drink == "Yes")
                                <div class="col-xl-6 col-lg-6 mb-3 chosen-style-3">
                                    <label class="label-1">Drinking Habits</label>
                                    <?php if(isset($register->part_drink)){$get_part_drink = explode(",",$register->part_drink);}?>
                                    <select NAME="part_drink[]" class="form-select chosen-select" id="floatingSelect" data-placeholder="Choose" multiple>
                                        <option value="">Select</option>
                                        <option value="No" @if(isset($register->part_drink)) @if(in_array("No",$get_part_drink)) {{"selected"}}@endif @endif>No</option>
                                        <option value="Drinks Socially" @if(isset($register->part_drink)) @if(in_array("Drinks Socially",$get_part_drink)) {{"selected"}}@endif @endif>Drinks Socially</option>
                                        <option value="Yes" @if(isset($register->part_drink)) @if(in_array("Yes",$get_part_drink)) {{"selected"}}@endif @endif>Yes</option>
                                    </select>
                                </div>
                                @endif
                            </div>
                            @endif
                            <!-- /. Habit Preference Section -->

                            <!-- Education & Occupation Preference Section -->
                            <h4><i class="fas fa-graduation-cap pe-2"></i>Education & Occupation Preference</h4>
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 mb-3 chosen-style-3">
                                    <label class="label-1">Education</label>
                                    <?php if(isset($register->part_edu)){$get_part_edu = explode(",",$register->part_edu);}?>
                                    <select name="part_edu[]" class="form-select chosen-select" id="floatingSelect" data-placeholder="Choose" multiple>
                                        <option value="">Select</option>
                                        @foreach($edu_details as $edu_detail)
                                        <option value="{{$edu_detail->id}}" @if(isset($register->part_edu)) @if(in_array($edu_detail->id,$get_part_edu)) {{"selected"}}@endif @endif>{{$edu_detail->edu_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-xl-6 col-lg-6 mb-3 chosen-style-3">
                                    <label class="label-1">Occupation</label>
                                    <?php if(isset($register->part_occu)){$get_part_occu = explode(",",$register->part_occu);}?>
                                    <select name="part_occu[]" class="form-select chosen-select" id="floatingSelect" data-placeholder="Choose" multiple>
                                        <option value="">Select</option>
                                        @foreach($occupations as $occupation)
                                        <option value="{{$occupation->id}}" @if(isset($register->part_occu)) @if(in_array($occupation->id,$get_part_occu)) {{"selected"}}@endif @endif>{{$occupation->ocp_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-xl-6 col-lg-6 mb-3 chosen-style-3">
                                    <label class="label-1">Employed in</label>
                                    <?php if(isset($register->part_emp_in)){$get_part_emp_in = explode(",",$register->part_emp_in);}?>
                                    <select name="part_emp_in[]" class="form-select chosen-select" id="floatingSelect" data-placeholder="Choose" multiple>
                                        <option value="">Select</option>
                                        <option value="Government" @if(isset($register->part_emp_in)) @if(in_array("Government",$get_part_emp_in)) {{"selected"}}@endif @endif>Government</option>
                                        <option value="Private" @if(isset($register->part_emp_in)) @if(in_array("Private",$get_part_emp_in)) {{"selected"}}@endif @endif>Private</option>
                                        <option value="Defence" @if(isset($register->part_emp_in)) @if(in_array("Defence",$get_part_emp_in)) {{"selected"}}@endif @endif>Defence</option>
                                        <option value="Bussiness" @if(isset($register->part_emp_in)) @if(in_array("Bussiness",$get_part_emp_in)) {{"selected"}}@endif @endif>Bussiness</option>
                                        <option value="Self Employed" @if(isset($register->part_emp_in)) @if(in_array("Self Employed",$get_part_emp_in)) {{"selected"}}@endif @endif>Self Employed</option>
                                        <option value="Not Working" @if(isset($register->part_emp_in)) @if(in_array("Not Working",$get_part_emp_in)) {{"selected"}}@endif @endif>Not Working</option>
                                    </select>
                                </div> 
                                @if(!isset($fieldsetting->part_annual_income) || $fieldsetting->part_annual_income == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3 chosen-style-3">
                                    <label class="label-1">Annual Income</label>
                                    <?php if(isset($register->part_income)){$get_part_income = explode(",",$register->part_income);}?>
                                    <select name="part_income[]" class="form-select chosen-select" id="floatingSelect" data-placeholder="Choose" multiple>
                                        <option value="">Select</option>
                                        @foreach($incomes as $income)
                                        <option value="{{$income->id}}" @if(isset($register->part_income)) @if(in_array($income->id,$get_part_income)) {{"selected"}}@endif @endif>{{$income->income}}</option>
                                        @endforeach
                                    </select>
                                </div> 
                                @endif
                            </div>
                            <!-- /. Education & Occupation Preference Section -->

                            <!-- Religion Preference Section -->
                            <h4><i class="fas fa-book pe-2"></i>Religion Preference</h4>
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 mb-3 chosen-style-3">
                                    <label class="label-1">Religion</label>
                                    <input class="form-control" type="hidden" value="@if(isset($register->id)){{$register->id}}@endif" name="part_id" id="part_id">
                                    <input class="form-control" type="hidden" value="@if(isset($register->part_caste)){{$register->part_caste}}@endif" name="part_caste_id" id="part_caste_id">

                                    <?php if(isset($register->part_religion)){$get_part_religion = explode(",",$register->part_religion);}?>
                                    <select name="part_religion[]" class="form-select chosen-select" data-placeholder="Choose" id="part_religion" data-placeholder="Choose" multiple>
                                        <option value="">select</option>
                                        @foreach($religions as $religion)
                                        <option value="{{$religion->id}}" @if(isset($register->part_religion)) @if(in_array($religion->id,$get_part_religion)) {{"selected"}}@endif @endif>{{$religion->religion_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-xl-6 col-lg-6 mb-3 chosen-style-3">
                                    <label class="label-1">Caste</label>
                                    <select name="part_caste[]" class="form-select" id="part_caste" data-placeholder="Choose" multiple>
                                    </select>
                                </div>
                                @if(!isset($fieldsetting->part_star) || $fieldsetting->part_star == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3 chosen-style-3">
                                    <label class="label-1">Star</label>
                                    <?php if(isset($register->part_star)){$get_part_star = explode(",",$register->part_star);}?>
                                    <select name="part_star[]" class="form-select chosen-select" id="floatingSelect" data-placeholder="Choose" multiple>
                                        <option value="">Select</option>
                                        @foreach($stars as $star)
                                        <option value="{{$star->id}}" @if(isset($register->part_star)) @if(in_array($star->id,$get_part_star)) {{"selected"}}@endif @endif>{{$star->star}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                                @if(!isset($fieldsetting->part_rasi) || $fieldsetting->part_rasi == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3 chosen-style-3">
                                    <label class="label-1">Rasi</label>
                                    <?php if(isset($register->part_rasi)){$get_part_rasi = explode(",",$register->part_rasi);}?>
                                    <select name="part_rasi[]" class="form-select chosen-select" id="floatingSelect" data-placeholder="Choose" multiple>
                                        <option value="">Select</option>
                                        @foreach($rashies as $rasi)
                                        <option value="{{$rasi->id}}" @if(isset($register->part_rasi)) @if(in_array($rasi->id,$get_part_rasi)) {{"selected"}}@endif @endif>{{$rasi->rasi}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                                @if(!isset($fieldsetting->part_dosh) || $fieldsetting->part_dosh == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3 ">
                                    <input type="hidden" value="{{$register->part_dosh}}" name="part_dosh" id="part_dosh">
                                    <label class="label-1">Have Dosh?</label>
                                    <select name="part_dosh" class="form-select" id="havedoshpart">
                                        <option value="" selected>Select</option>
                                        <option value="Yes" @if(isset($register->part_dosh)){{$register->part_dosh == "Yes" ? "selected" : ''}}@else @selected(old('part_dosh') == "Yes")@endif>Yes</option>
                                        <option value="No" @if(isset($register->part_dosh)){{$register->part_dosh == "No" ? "selected" : ''}}@else @selected(old('part_dosh') == "No")@endif>No</option>
                                    </select>
                                </div> 
                                @endif
                                @if(!isset($fieldsetting->part_manglik) || $fieldsetting->part_manglik == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3 chosen-style-3" id="doshpart">
                                    <label class="label-1">Dosh Type</label>
                                    <?php if(isset($register->part_manglik)){$get_part_manglik = explode(",",$register->part_manglik);}?>
                                   
                                    <select name="part_manglik[]" class="form-select chosen-select" id="floatingSelect" data-placeholder="Choose" multiple>
                                        <option value="">Select</option>
                                        @foreach($doshes as $dosh)
                                        <option value="{{$dosh->id}}" @if(isset($register->part_manglik)) @if(in_array($dosh->id,$get_part_manglik)) {{"selected"}}@endif @endif>{{$dosh->dosh}}</option>
                                        @endforeach
                                    </select>
                                </div> 
                                @endif
                            </div>
                            <!-- /. Religion Preference Section -->

                            <!-- Location Preference Section -->
                            <h4><i class="fas fa-location-dot pe-2"></i>Location Preference</h4>
                            <div class="row">
                                <input class="form-control" type="hidden" value="{{$register->id}}" name="part_location_id" id="part_location_id">
                                <input class="form-control" type="hidden" value="{{$register->part_state}}" name="part_state_id" id="part_state_id">
                                <input class="form-control" type="hidden" value="{{$register->part_city}}" name="part_city_id" id="part_city_id">
                                <div class="col-xl-6 col-lg-6 mb-3 chosen-style-3">
                                    <label class="label-1">Country</label>
                                    <?php if(isset($register->part_country_living)){$get_part_country_living = explode(",",$register->part_country_living);}?>
                                    <select  name="part_country_living[]" id="part_country" class="form-select chosen-select" data-placeholder="Choose" multiple>
                                        <option value="">Select</option>
                                        @foreach($countries as $country)
                                        <option value="{{$country->id}}" @if(isset($register->part_country_living)) @if(in_array($country->id,$get_part_country_living)) {{"selected"}}@endif @endif>{{$country->country_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @if(!isset($fieldsetting->part_state) || $fieldsetting->part_state == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3 chosen-style-3">
                                    <label class="label-1">State</label>
                                    <?php if(isset($register->part_state)){$get_part_state = explode(",",$register->part_state);}?>
                                    <select name="part_state[]" id="part_state" class="form-select"  multiple>                            
                                    </select>
                                </div>
                                @endif
                                @if(!isset($fieldsetting->part_city) || $fieldsetting->part_city == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3 chosen-style-3">
                                    <label class="label-1">City</label>
                                    <?php if(isset($register->part_city)){$get_part_city = explode(",",$register->part_city);}?>
                                    <select name="part_city[]" class="form-select" id="part_city" multiple>
                                    </select>
                                </div> 
                                @endif
                            </div>
                            <!-- /. Location Preference Section -->

                            <!-- Partner Preference Section -->
                            @if(!isset($fieldsetting->part_expect) || $fieldsetting->part_expect == "Yes" )
                            <h4><i class="fas fa-user-group pe-2"></i>Partner Preference</h4>
                            <div class="row">
                                <div class="col-xl-12 mb-3">
                                   <textarea rows="4" name="part_expect" class="form-control">@if(isset($register->part_expect)){{$register->part_expect}}@else{{old('part_expect')}}@endif</textarea>
                                </div>
                            </div>
                            @endif
                            <!-- /. Partner Preference Section -->

                            <div class="text-center mt-3">
                                <input type="submit" value="UPDATE" name="preferenceDetailsUpdate" class="btn btnPrimary">
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /. Partner Preference Section --> 
            </div>
        </div>
    </div>

    <div class="toast-container position-fixed position-static bottom-0 end-0 p-3 mb-5 mb-sm-0">
        <div id="message" class="toast inToastExpress" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
            <div class="d-flex">
                <div class="toast-body">
                    <strong class="me-auto">{{ Session::get('message') }}</strong>
                </div>
                <button type="button" class="btn-close me-2 m-auto bg-white p-1" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
</section>

@endsection

@section('pageJS')

<!-- Chosen js -->
<script src="{{asset('user/js/chosen.jquery.js')}}" type="text/javascript"></script>
<script src="{{asset('user/js/prism.js')}}" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    var config = {
        '.chosen-select': {},
        '.chosen-select-deselect': {allow_single_deselect: true},
        '.chosen-select-no-single': {disable_search_threshold: 10},
        '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
        '.chosen-select-width': {width: "100%"}
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }
</script>
<!-- /. Chosen js -->

<!-- Birthdate JS -->
<script type="text/javascript">
    var numDays = {'01': 31, '02': 28, '03': 31, '04': 30, '05': 31, '06': 30, '07': 31, '08': 31, '09': 30, '10': 31, '11': 30, '12': 31};
    function setDays(oMonthSel, oDaysSel, oYearSel)
    {
        var nDays, oDaysSelLgth, opt, i = 1;
        nDays = numDays[oMonthSel[oMonthSel.selectedIndex].value];
        if (nDays == 28 && oYearSel[oYearSel.selectedIndex].value % 4 == 0)
            ++nDays;
        oDaysSelLgth = oDaysSel.length;
        if (nDays != oDaysSelLgth) {
            if (nDays < oDaysSelLgth)
                oDaysSel.length = nDays;
            else
                for (i; i < nDays - oDaysSelLgth + 1; i++) {
                    opt = new Option(oDaysSelLgth + i, oDaysSelLgth + i);
                    oDaysSel.options[oDaysSel.length] = opt;
                }
        }
        var oForm = oMonthSel.form;
        var month = oMonthSel.options[oMonthSel.selectedIndex].value;
        var day = oDaysSel.options[oDaysSel.selectedIndex].value;
        var year = oYearSel.options[oYearSel.selectedIndex].value;
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
       var lastUpdatedSection = document.getElementById('lastUpdatedSection').value;

       if (lastUpdatedSection) {
          var lastUpdatedTab = document.querySelector('[data-section="' + lastUpdatedSection + '"]');
          if (lastUpdatedTab) {
             lastUpdatedTab.classList.add('show', 'active');
          }
       }
    });
</script>

<script>
    $(document).ready(function () {
        @if(Session::has('message'))
            $('#message').toast('show');
        @endif
        $('#dis_tot_children').hide();
        $('#dis_child').hide();
        $('#manglik').hide();
        $('#no_marri_brother').hide();
        $('#no_marri_sister').hide();
        $('#doshpart').hide();
        var tot_children = $('#tot_children').val();
        if(tot_children == "No Children")
        {
            $('#dis_child').hide();
        }else{
            $('#dis_child').show();
        }

        var dosh = $('#dosh').val();
       
        if(dosh == "No")
        {
            $('#manglik').hide();
        }
        if(dosh == "Yes")
        {
            $('#manglik').show();
        }

        var mstatus = $('#m_status').val();
        if(mstatus == "Never Married")
        {
            $('#dis_tot_children').hide();
            $('#dis_child').hide();
        }
        if (mstatus == 'Widower'){
            $('#dis_tot_children').show();
        }
        if (mstatus == 'Divorced'){
            $('#dis_tot_children').show();
        }
        if (mstatus == 'Awaiting Divorce'){
            $('#dis_tot_children').show();
        }
        if (mstatus == 'Widow'){
            $('#dis_tot_children').show();
        }
        $('#havedosh').on('change', function () {
            var status = $('#havedosh').val();
            if (status == 'No'){
                $('#manglik').hide();
            }
            if (status == 'Yes'){
                $('#manglik').show();
            }
        });
        
        var part_dosh = $('#part_dosh').val();
        if(part_dosh == "No")
        {
            $('#doshpart').hide();
        }
        if(part_dosh == "Yes")
        {
            $('#doshpart').show();
        }
        $('#havedoshpart').on('change', function () {
            var status = $('#havedoshpart').val();
            if (status == 'No'){
                $('#doshpart').hide();
            }
            if (status == 'Yes'){
                $('#doshpart').show();
            }
        });
        var nos_brother = $('#no_of_brothers').val();
        if(nos_brother == "No Brother")
        {
            $('#no_marri_brother').hide();
        }
        if (nos_brother == '1 Brother'){
            $('#no_marri_brother').show();
        }
        if (nos_brother == '2 Brothers'){
            $('#no_marri_brother').show();
        }
        if (nos_brother == '3 Brothers'){
            $('#no_marri_brother').show();
        }
        if (nos_brother == '4 Brothers'){
            $('#no_marri_brother').show();
        }
        if (nos_brother == '4 + Brothers'){
            $('#no_marri_brother').show();
        }
        $('#no_brother').on('change', function () {
            var status = $('#no_brother').val();
            if (status == 'No Brother'){
                $('#no_marri_brother').hide();
            }
            if (status == '1 Brother'){
                $('#no_marri_brother').show();
            }
            if (status == '2 Brothers'){
                $('#no_marri_brother').show();
            }
            if (status == '3 Brothers'){
                $('#no_marri_brother').show();
            }
            if (status == '4 Brothers'){
                $('#no_marri_brother').show();
            }
            if (status == '4 + Brothers'){
                $('#no_marri_brother').show();
            }
        });
        var nos_sister = $('#no_of_sisters').val();
        if(nos_sister == "No Sister")
        {
            $('#no_marri_sister').hide();
        }
        if (nos_sister == '1 Sister'){
            $('#no_marri_sister').show();
        }
        if (nos_sister == '2 Sisters'){
            $('#no_marri_sister').show();
        }
        if (nos_sister == '3 Sisters'){
            $('#no_marri_sister').show();
        }
        if (nos_sister == '4 Sisters'){
            $('#no_marri_sister').show();
        }
        if (nos_sister == '4 + Sisters'){
            $('#no_marri_sister').show();
        }
        $('#no_sister').on('change', function () {
            var status = $('#no_sister').val();
          
            if (status == 'No Sister'){
                $('#no_marri_sister').hide();
            }
            if (status == '1 Sister'){
                $('#no_marri_sister').show();
            }
            if (status == '2 Sisters'){
                $('#no_marri_sister').show();
            }
            if (status == '3 Sisters'){
                $('#no_marri_sister').show();
            }
            if (status == '4 Sisters'){
                $('#no_marri_sister').show();
            }
            if (status == '4 + Sisters'){
                $('#no_marri_sister').show();
            }
        });

        $('#no_mstatus').on('change', function () {
            var status = $('#no_mstatus').val();
            if (status == 'Never Married'){
                $('#dis_tot_children').hide();
                $('#dis_child').hide();
            } 
            if (status == 'Widower'){
                $('#dis_tot_children').show();
            }
            if (status == 'Divorced'){
                $('#dis_tot_children').show();
            }
            if (status == 'Awaiting Divorce'){
                $('#dis_tot_children').show();
            }
            if (status == 'Widow'){
                $('#dis_tot_children').show();
            }
        });

        $('#no_children').on('change', function () {
            var status = $('#no_children').val();
        
            if (status == 'No Children'){
                $('#dis_child').hide();
            } 
            if (status == 'One'){
                $('#dis_child').show();
            }
            if (status == 'Two'){
                $('#dis_child').show();
            }
            if (status == 'Three'){
                $('#dis_child').show();
            }
            if (status == 'Four-divorce'){
                $('#dis_child').show();
            }
            if (status == 'Four Pluse'){
                $('#dis_child').show();
            }
        });
        var state = $('#state_id').val();
        var city = $('#city_id').val();
        var caste = $('#caste_id').val();
        var partcaste = $('#part_caste_id').val();
        var modalId = $('#part_location_id').val();
        var partstate = $('#part_state_id').val();
        var partcity = $('#part_city_id').val();

        Dropdownpartcaste(partcaste,modalId);
        partcountry(partstate,modalId);
        PartStateUser(partcity,modalId);
       
        $('#country').on('change', function () {
            Dropdown()
        });
        $('#state').on('change', function () {
            Dropdowncity()
        });
        $('#religion').on('change', function () {
            Dropdowncaste();
        });

        function Dropdowncaste(caste){
            var religion_id = $('#religion').val();
            var modalId = $('#religion_id').val();
            $("#caste").html('');
          
            $.ajax({
                url: "{{route('profilecaste')}}",
                type: 'POST',
                data: {
                    modalId: modalId,
                    religion_id: religion_id,
                _token: '{{csrf_token()}}'
                },
                success: function (result) {
                    $('#caste').html('<option value="">-- Select --</option>');
                    $.each(result.caste, function (key, value) {
                        $("#caste").append('<option value="' + value.id + '">' + value.caste_name + '</option>');
                    });
                    $('#caste').val('').trigger('chosen:updated');
                }
            });
        };

        function Dropdown(state){
            var modalId = $('#id').val();
            var idCountry = $('#country').val();
            $("#state").html('');
            $.ajax({
                url: "{{route('profilestate')}}",
                type: "POST",
                data: {
                    modalId: modalId,
                    country_id: idCountry,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (result) {
                    $('#state').html('<option value="">-- Select State --</option>');
                    $.each(result.states, function (key, value) {
                            var selected = ((value.id == state) ? 'selected' : '');
                           $("#state").append('<option value="' + value.id + '" ' + selected + '>' + value.state_name + '</option>');
                    });
                    $('#state').val('').trigger('chosen:updated');
                    $('#city').val('').trigger('chosen:updated');
                }
            });
        };

        function Dropdowncity(city){
            var modalId = $('#id').val();
            var idstate =  $('#state').val();
            $("#city").html('');
            $.ajax({
                url: "{{route('profilecity')}}",
                type: "POST",
                data: {
                    state_id: idstate,
                    modalId: modalId,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (result) {
                    $('#city').html('<option value="">-- Select city --</option>');
                    $.each(result.cities, function (key, value) {

                        var selected = ((value.id == city) ? 'selected' : '');
                        $("#city").append('<option value="' + value.id + '" ' + selected + '>' + value.city_name + '</option>');
                    });
                    $('#city').val('').trigger('chosen:updated');
                }
            });
        };

        //part religion
        $('#part_religion').on('change', function () {
            var part_religion_id = $('#part_religion').val();
            $("#part_caste").html('');
            $.ajax({
                url: "{{route('profilepartcaste')}}",
                type: "POST",
                data: {
                    part_religion_id: part_religion_id,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (result) {
                    $.each(result.partcastie, function (key, value) {
                        console.log(value);
                        $("#part_caste").append('<option value="' + value.id + '">' + value.caste_name + '</option>');
                    });

                    $("#part_caste").chosen({
                            allow_single_deselect: true,
                            disable_search_threshold:10,
                            no_results_text:'Oops, nothing found!',
                            width :"100%"
                        });

                        $('#part_caste').val('').trigger('chosen:updated');
                }
            });
        });
   
        function Dropdownpartcaste(partcaste,modalId){
            var modalId = $('#part_id').val();
            $("#part_caste").html('');
                $.ajax({
                    url: "{{route('profilepartcaste')}}",
                    type: 'POST',
                    data: {
                    modalId: modalId,
                    _token: '{{csrf_token()}}'
                    },
                    success: function (result) {
                        $.each(result.partcastie, function (key, value) {
                            var partcasteArray = partcaste.split(',');
                            var selected = (partcasteArray.includes(value.id.toString()) ? 'selected' : '');
                            $("#part_caste").append('<option value="' + value.id + '"' + selected + '>' + value.caste_name + '</option>');
                        });

                        $("#part_caste").chosen({
                            allow_single_deselect: true,
                            disable_search_threshold:10,
                            no_results_text:'Oops, nothing found!',
                            width :"100%"
                        });
                    }
                });
        };
        //change state
        $('#part_country').change(function () {
            var partcountryIds = $('#part_country').val();
            $("#part_state").html('');

                $.ajax({
                    url: "{{route('profilepartstate')}}",
                    type: 'POST',
                    data: {
                    partcountryIds: partcountryIds,
                    _token: '{{csrf_token()}}'
                    },
                    success: function (result) {
                        $.each(result.partstates, function (key, value) {
                            $("#part_state").append('<option value="' + value.id + '">' + value.state_name + '</option>');
                        });

                        $("#part_state").chosen({
                            allow_single_deselect: true,
                            disable_search_threshold:10,
                            no_results_text:'Oops, nothing found!',
                            width :"100%"
                        });
                        $('#part_state').val('').trigger('chosen:updated');

                        $("#part_city").val('').trigger('chosen:updated');
                    }
                });
            });

            function partcountry(partstate,modalId){
            $("#part_state").html('');
                $.ajax({
                    url: "{{route('profilepartstate')}}",
                    type: 'POST',
                    data: {
                    modalId: modalId,
                    _token: '{{csrf_token()}}'
                    },
                    success: function (result) {
                        $.each(result.partstates, function (key, value) {
                            var partstateArray = partstate.split(',');
                            var selected = (partstateArray.includes(value.id.toString()) ? 'selected' : '');
                            $("#part_state").append('<option value="' + value.id + '"' + selected + '>' + value.state_name + '</option>');
                        });

                        $("#part_state").chosen({
                            allow_single_deselect: true,
                            disable_search_threshold:10,
                            no_results_text:'Oops, nothing found!',
                            width :"100%"
                        });
                    }
                });
            };

            //change city
            $('#part_state').change(function () {
            var partstateIds = $('#part_state').val();
            $("#part_city").html('');

                $.ajax({
                    url: "{{route('profilepartcity')}}",
                    type: 'POST',
                    data: {
                    partstateIds: partstateIds,
                    _token: '{{csrf_token()}}'
                    },
                    success: function (result) {
                        $.each(result.partcities, function (key, value) {
                            $("#part_city").append('<option value="' + value.id + '">' + value.city_name + '</option>');
                        });

                        $("#part_city").chosen({
                            allow_single_deselect: true,
                            disable_search_threshold:10,
                            no_results_text:'Oops, nothing found!',
                            width :"100%"
                        });
                        $('#part_city').val('').trigger('chosen:updated');
                    }
                });
            });

        function PartStateUser(partcity,modalId){
            $("#part_city").html('');
            $.ajax({
                url: "{{route('profilepartcity')}}",
                type: 'POST',
                data: {
                    modalId: modalId,
                _token: '{{csrf_token()}}'
                },
                success: function (result) {
                    $.each(result.partcities, function (key, value) {
                        var partcityArray = partcity.split(',');
                        var selected = (partcityArray.includes(value.id.toString()) ? 'selected' : '');
                        $("#part_city").append('<option value="' + value.id + '"' + selected + '>' + value.city_name + '</option>');
                    });

                    $("#part_city").chosen({
                        allow_single_deselect: true,
                        disable_search_threshold:10,
                        no_results_text:'Oops, nothing found!',
                        width :"100%"
                    });
                }
            });
        };

         //age selcted
        $('#part_frm_age').change(function () {
            var selectedAgeTo = parseInt($(this).val());

            $('#part_to_age option').each(function () {
                var ageValue = parseInt($(this).val());
                if (ageValue <= selectedAgeTo) {
                    $(this).prop('disabled', true);
                    var defaultSelectedValue = ageValue+1; 
                    $('#part_to_age').val(defaultSelectedValue);
                }
            });
            $('#part_to_age').prop('disabled', false);
        });

         //height selcted
        $('#part_frm_height').change(function () {
            var selectedheightTo = parseInt($(this).val());
            $('#part_to_height option').prop('disabled', false);
            $('#part_to_height option').prop('selected', false);

            $('#part_to_height option').each(function () {
                var heightValue = parseInt($(this).val());
                if (heightValue <= selectedheightTo) {
                    $(this).prop('disabled', true);
                    var defaultSelectedValue = heightValue+1; 
                    $('#part_to_height').val(defaultSelectedValue);
                }
            });
            $('#part_to_height').prop('disabled', false);
        });
    });
</script>
@endsection
