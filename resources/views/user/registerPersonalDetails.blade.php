@extends('user.layouts.beforeLoginLayout')

@section('pageCSS')
    <!-- chosen css -->
    <link rel="stylesheet" href="{{ asset('user/css/prism.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/chosen.css') }}">
    <!-- /. chosen css -->    
@endsection

<!-- Content Section Start -->
@section('content')
<section class="inLogin mb-5 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-xl-8 m-auto">
                <div class="card">
                    <div class="card-body ps-md-5 pe-md-5 ps-4 pe-4 pt-4 pb-4">
                        <h4 class="inLoginTitle"><i class="fas fa-user pe-3"></i>Personal Details</h4>
                        <p class="mb-4">Enter your details which help your match to find you quickly.</p> 
                        <form method="POST" id="register_form" action="{{ route('user.registerPersonalDetailsPost') }}">
                            @csrf
                            <div class="row mb-4">
                                <div class="col-xl-6">
                                    <div class="mb-3 chosen-style-2">
                                        <label class="label-1">Mother Tongue</label>
                                        <select name="m_tongue" class="form-select chosen-select" data-placeholder="Select Mother Tongue">
                                            <option value="" selected>select</option>
                                            @foreach ($mothertongues as $mothertongue)
                                            <option value="{{$mothertongue->id}}" >{{$mothertongue->mtongue_name}}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>
                            </div>
                            <h5 class="mb-4 colorSecondary inRegisterSubTitle"><i class="fas fa-book pe-2"></i> Religion Details</h5>
                            <div class="row mb-4">
                                @if(!isset($fieldsetting->sub_caste) || $fieldsetting->sub_caste == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3 chosen-style-2">
                                    <label class="label-1">Sub Caste</label>
                                    <select name="subcaste" class="form-select chosen-select" data-placeholder="Select sub caste" id="floatingSelect">
                                        <option value="" selected>Select</option>
                                        @foreach($subcastes as $subcaste)
                                        <option value="{{$subcaste->id}}">{{ $subcaste->sub_caste_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                                @if(!isset($fieldsetting->gotra) || $fieldsetting->gotra == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3 chosen-style-2">
                                    <label class="label-1">Gotra</label>
                                    <!--<select name="gotra" class="form-select chosen-select" data-placeholder="Select gotra" id="floatingSelect">
                                        <option value="" selected>Select</option>
                                        @foreach($gotras as $gotra)
                                        <option value="{{$gotra->id}}">{{$gotra->gotra_name}}</option>
                                        @endforeach
                                    </select>-->
				    <input type="text" value="" name="gotra" class="form-control" placeholder="Enter gotra name">
                                </div>
                                @endif
                                @if(!isset($fieldsetting->will_to_marry) || $fieldsetting->will_to_marry == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3">
                                    <label  class="label-1">Willing to marry other caste?</label>
                                    <select name="will_to_mary_caste" class="form-select" id="floatingSelect">
                                        <option value="" selected>select</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                                @endif
                                @if(!isset($fieldsetting->church_name) || $fieldsetting->church_name == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3">
                                    <label  class="label-1">Baptism</label>
                                    <input type="text" name="church_name" class="form-control" placeholder="Enter Church Name">
                                </div>
                                @endif
                                @if(!isset($fieldsetting->denomination) || $fieldsetting->denomination == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3">
                                    <label  class="label-1">Denomination</label>
                                    <input type="text" name="denomination" class="form-control" placeholder="Enter Denomination">
                                </div>
                                @endif
                                @if(!isset($fieldsetting->baptism) || $fieldsetting->baptism == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3">
                                    <label  class="label-1">Baptism</label>
                                    <select name="baptism" class="form-select" id="floatingSelect">
                                        <option value="" selected>select</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                                @endif
                                @if(!isset($fieldsetting->born_again) || $fieldsetting->born_again == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3">
                                    <label  class="label-1">Born Again?</label>
                                    <select name="born_again" class="form-select" id="floatingSelect">
                                        <option value="" selected>select</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                                @endif
                            </div>
                            <h5 class="mb-4 colorSecondary inRegisterSubTitle"><i class="fas fa-user-graduate pe-2"></i> Education / Occupation Details</h5>
                            <div class="row mb-4">
                                <div class="col-xl-6 col-lg-6 mb-3 chosen-style-2">
                                    <label class="label-1">Highest Education</label>
                                    <?php if(isset($register->edu_detail)){ $get_edu_details = explode(",",$register->edu_detail);}?>
                                    <select name="edu_detail[0]" class="form-select chosen-select" data-placeholder="Choose">
                                        <option value="" selected>Select</option>
                                        @foreach($edu_details as $edu_detail)
                                        <option value="{{$edu_detail->id}}">{{$edu_detail->edu_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @if(!isset($fieldsetting->additional_degree) || $fieldsetting->additional_degree == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3 chosen-style-2">
                                    <label class="label-1">Additional Degree :</label>
                                    <select name="edu_detail[1]" class="form-select chosen-select" data-placeholder="Choose">
                                        <option value="" selected>Select</option>
                                        @foreach($edu_details as $edu_detail)
                                        <option value="{{$edu_detail->id}}">{{ $edu_detail->edu_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                                <div class="col-xl-6 col-lg-6 mb-3 chosen-style-2">
                                    <label class="label-1">Employed in :</label>
                                    <select name="emp_in" class="form-select chosen-select" data-placeholder="Choose">
                                        <option value="" selected>Select</option>
                                        <option value="Government">Government</option>
                                        <option value="Private">Private</option>
                                        <option value="Defence">Defence</option>
                                        <option value="Bussiness">Bussiness</option>
                                        <option value="Self Employed">Self Employed</option>
                                        <option value="Not Working">Not Working</option>
                                    </select>
                                </div>
                                <div class="col-xl-6 col-lg-6 mb-3 chosen-style-2">
                                    <label class="label-1">Occupation :</label>
                                    <select name="occupation" class="form-select chosen-select" data-placeholder="Choose" id="floatingSelect" >
                                        <option value="" selected>Select</option>
                                        @foreach($occupations as $occupation)
                                        <option value="{{$occupation->id}}">{{$occupation->ocp_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @if(!isset($fieldsetting->company_name) || $fieldsetting->company_name == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3">
                                    <label class="label-1">Company Name :</label>
                                    <input type="text" value="" name="company_name" class="form-control" placeholder="Company Name">
                                </div>
                                @endif
                                @if(!isset($fieldsetting->designation) || $fieldsetting->designation == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3">
                                    <label class="label-1">Designation :</label>
                                    <input type="text" value="" name="designation" class="form-control" placeholder="Designation Name">
                                </div>
                                @endif
                                @if(!isset($fieldsetting->annual_income) || $fieldsetting->annual_income == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3 chosen-style-2">
                                    <label class="label-1">Monthly Income :</label>
                                    <select name="income" class="form-select chosen-select" data-placeholder="Choose" id="floatingSelect" >
                                        <option value="" selected>Select</option>
                                        @foreach($incomes as $income)
                                        <option value="{{$income->id}}">{{$income->income}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                            </div>
                            <h5 class="mb-4 colorSecondary inRegisterSubTitle"><i class="fas fa-people-group pe-2"></i> Family Details</h5>
                            <div class="row mb-4">
                                @if(!isset($fieldsetting->family_type) || $fieldsetting->family_type == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3">
                                    <label class="label-1">Family Type</label>
                                    <select name="family_type" class="form-select" id="floatingSelect">
                                        <option value="" selected>select</option>
                                        <option value="Middle class">Middle class</option>
                                        <option value="Upper middle class">Upper middle class</option>
                                        <option value="Rich">Rich</option>
                                        <option value="Affluent">Affluent</option>
                                    </select>
                                </div>
                                @endif
                                @if(!isset($fieldsetting->family_value) || $fieldsetting->family_value == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3">
                                    <label class="label-1">Family Value</label>
                                    <select name="family_value" class="form-select" id="floatingSelect">
                                        <option value="" selected>select</option>
                                        <option value="Joint">Joint</option>
                                        <option value="Nuclear">Nuclear</option>
                                    </select>
                                </div>
                                @endif
                                @if(!isset($fieldsetting->family_status) || $fieldsetting->family_status == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3">
                                    <label class="label-1">Family Status</label>
                                    <select name="family_status" class="form-select" id="floatingSelect">
                                        <option value="" selected>select</option>
                                        <option value="Orthodox">Orthodox</option>
                                        <option value="Traditional">Traditional</option>
                                        <option value="Moderate">Moderate</option>
                                        <option value="Liberal">Liberal</option>
                                    </select>
                                </div>
                                @endif
                                @if(!isset($fieldsetting->father_name) || $fieldsetting->father_name == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3">
                                    <label class="label-1">Father Name</label>
                                    <input type="text" value="" name="father_name" class="form-control" placeholder="Father Name">
                                </div>
                                @endif
                                @if(!isset($fieldsetting->father_occupation) || $fieldsetting->father_occupation == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3">
                                    <label class="label-1">Father Occupation</label>
                                    <select name="father_occupation" class="form-select" id="floatingSelect" >
                                        <option value="" selected>Select</option>
                                        @foreach($occupations as $occupation)
                                        <option value="{{$occupation->ocp_name}}">{{$occupation->ocp_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                                @if(!isset($fieldsetting->mother_name) || $fieldsetting->mother_name == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3">
                                    <label class="label-1">Mother Name</label>
                                    <input type="text" value="" name="mother_name" class="form-control" placeholder="Mother Name">
                                </div>
                                @endif
                                @if(!isset($fieldsetting->mother_occupation) || $fieldsetting->mother_occupation == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3">
                                    <label class="label-1">Mother Occupation</label>
                                    <select name="mother_occupation" class="form-select" id="floatingSelect" >
                                        <option value="" selected>Select</option>
                                        @foreach($occupations as $occupation)
                                        <option value="{{$occupation->ocp_name}}">{{$occupation->ocp_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                                @if(!isset($fieldsetting->no_of_brother) || $fieldsetting->no_of_brother == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3" id="no_brothers">
                                    <label class="label-1">No Of Brothers</label>
                                    <select name="no_of_brothers" class="form-select" id="no_brother">
                                        <option value="" selected>select</option>
                                        <option value="No Brother">No Brother</option>
                                        <option value="1 Brother">1 Brother</option>
                                        <option value="2 Brothers">2 Brothers</option>
                                        <option value="3 Brothers">3 Brothers</option>
                                        <option value="4 Brothers">4 Brothers</option>
                                        <option value="4 + Brothers">4 + Brothers</option>
                                    </select>
                                </div>
                                @endif
                                @if(!isset($fieldsetting->no_of_married_brother) || $fieldsetting->no_of_married_brother == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3" id="no_marri_brother">
                                    <label class="label-1">No Of Married Brothers</label>
                                    <select name="no_marri_brother" class="form-select" id="floatingSelect">
                                        <option value="" selected>select</option>
                                        <option value="No married brother">No married brother</option>
                                        <option value="1 married brother">1 married brother</option>
                                        <option value="2 married brothers">2 married brothers</option>
                                        <option value="3 married brothers">3 married brothers</option>
                                        <option value="4 married brothers">4 married brothers</option>
                                        <option value="4 + married brothers">4 + married brothers</option>

                                    </select>
                                </div>
                                @endif
                                @if(!isset($fieldsetting->no_of_sister) || $fieldsetting->no_of_sister == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3" id="no_of_sister">
                                    <label class="label-1">No Of Sisters</label>
                                    <select name="no_of_sisters" class="form-select" id="no_sister">
                                        <option value="" selected>select</option>
                                        <option value="No Sister">No Sister</option>                                            
                                        <option value="1 Sister">1 Sister</option>
                                        <option value="2 Sisters">2 Sisters</option>
                                        <option value="3 Sisters">3 Sisters</option>
                                        <option value="4 Sisters">4 Sisters</option>
                                        <option value="4 + Sisters">4 + Sisters</option>
                                    </select>
                                </div>
                                @endif
                                @if(!isset($fieldsetting->no_of_married_sister) || $fieldsetting->no_of_married_sister == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3" id="no_marri_sister">
                                    <label class="label-1">No Of Married Sisters</label>
                                    <select name="no_marri_sister" class="form-select" id="floatingSelect">
                                        <option value="" selected>select</option>
                                        <option value="No married sister">No married sister</option>
                                        <option value="1 married sister">1 married sister</option>
                                        <option value="2 married sisters">2 married sisters</option>
                                        <option value="3 married sisters">3 married sisters</option>
                                        <option value="4 married sisters">4 married sisters</option>
                                        <option value="4+ married sisters">4+ married sisters</option>
                                    </select>
                                </div>
                                @endif
                                @if(!isset($fieldsetting->maternal_details) || $fieldsetting->maternal_details == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3">
                                    <label class="label-1">Maternal Details</label>
                                    <textarea class="form-control" name="maternal_details"></textarea>
                                </div>
                                @endif
                                @if(!isset($fieldsetting->paternal_details) || $fieldsetting->paternal_details == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3">
                                    <label class="label-1">Paternal Details</label>
                                    <textarea class="form-control" name="paternal_details"></textarea>
                                </div>
                                @endif

                            </div>
                            <h5 class="mb-4 colorSecondary inRegisterSubTitle"><i class="fas fa-location-dot pe-2"></i> Location Details</h5>
                            <div class="row mb-4">
                                <input class="form-control" type="hidden" value="@if(isset($register->id)){{$register->id}}@endif" name="id" id="id">
                                <input class="form-control" type="hidden" value="@if(isset($register->state_id)){{$register->state_id}}@endif" name="state_id" id="state_id">
                                <input class="form-control" type="hidden" value="@if(isset($register->city)){{$register->city}}@endif" name="city_id" id="city_id">
                                <div class="col-xl-6 col-lg-6 mb-3 chosen-style-2">
                                    <label class="label-1">Country</label>
                                    <select name="country_id" class="form-select chosen-select" data-placeholder="Choose" id="country">
                                        <option value="" selected>Select state</option>
                                        @foreach($countries as $country)
                                        <option value="{{ $country->id }}" @if(isset($register->country_id)){{ $register->country_id == $country->id ? "selected" : ''}}@else @selected(old('country_id') == $country->id)@endif>{{ $country->country_name }}</option>
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

                                    </select>
                                </div>
                                @if(!isset($fieldsetting->address) || $fieldsetting->address == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3">
                                    <label class="label-1">Address</label>
                                    <textarea class="form-control" name="address">@if(isset($register->address)){{$register->address}}@else{{old('address')}}@endif</textarea>
                                </div>
                                @endif
                            </div>
                            <h5 class="mb-4 colorSecondary inRegisterSubTitle"><i class="fas fa-utensils pe-2"></i> Habits & Hobbies</h5>
                            <div class="row mb-4">
                                @if(!isset($fieldsetting->diet) || $fieldsetting->diet == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3">
                                    <label class="label-1">Eating Habits</label>
                                    <select NAME="diet" class="form-select">
                                        <option value="" selected>Select</option>
                                        <option value="Vegetarian">Vegetarian</option>
                                        <option value="Non Vegetarian">Non Vegetarian</option>
                                        <option value="Eggetarian">Eggetarian</option>
                                    </select>
                                </div>
                                @endif
                                @if(!isset($fieldsetting->smoke) || $fieldsetting->smoke == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3">
                                    <label class="label-1">Smoking Habits</label>
                                    <select NAME="smoke" class="form-select">
                                        <option value="" selected>Select</option>
                                        <option value="No">No</option>
                                        <option value="Occasionally">Occasionally</option>
                                        <option value="Yes">Yes</option>
                                    </select>
                                </div>
                                @endif
                                @if(!isset($fieldsetting->drink) || $fieldsetting->drink == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3">
                                    <label class="label-1">Drinking Habits</label>
                                    <select name="drink" class="form-select">
                                        <option value="" selected>Select</option>
                                        <option value="No">No</option>
                                        <option value="Drinks Socially">Drinks Socially</option>
                                        <option value="Yes">Yes</option>
                                    </select>
                                </div>
                                @endif
                            </div>
                            <h5 class="mb-4 colorSecondary inRegisterSubTitle"><i class="fas fa-person pe-2"></i> Physical Attributes</h5>
                            <div class="row mb-4">
                                @if(!isset($fieldsetting->height) || $fieldsetting->height == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3">
                                    <label class="label-1">Height</label>
                                    <select name="height" class="form-select">
                                        <option value="" selected>Select</option>
                                        @foreach($heights as $height)
                                        <option value="{{$height->id}}">{{$height->height}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                                @if(!isset($fieldsetting->weight) || $fieldsetting->weight == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3">
                                    <label class="label-1">Weight</label>
                                    @php
                                        $weight_first = $siteconfig->weight_first;
                                        $weight_last = $siteconfig->weight_last;
                                    @endphp
                                    <select name="weight" class="form-select">
                                        <option value="" selected>Select</option>
                                        @if(isset($weight_last) && isset($weight_first))
                                            @for($i=$weight_first;$i<=$weight_last;$i++)
                                            <option value="{{$i}}">{{$i}}</option>
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
                                        <option value="Slim">Slim</option>
                                        <option value="Average">Average</option>
                                        <option value="Athletic">Athletic</option>
                                        <option value="Heavy">Heavy</option>
                                    </select>
                                </div>
                                @endif
                                @if(!isset($fieldsetting->complexion) || $fieldsetting->complexion == "Yes" )
                                    <div class="col-xl-6 col-lg-6 mb-3">
                                        <label class="label-1">Complexion</label>
                                        <select name="complexion" class="form-select">
                                            <option value="" selected>Select</option>
                                            <option value="Very Fair">Very Fair</option>
                                            <option value="Fair">Fair</option>
                                            <option value="Wheatish">Wheatish</option>
                                            <option value="Wheatish brown">Wheatish brown</option>
                                            <option value="Dark">Dark</option>
                                        </select>
                                    </div>
                                @endif
                                @if(!isset($fieldsetting->physical_status) || $fieldsetting->physical_status == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3">
                                    <label class="label-1">Physical Status</label>
                                    <select name="physical_status" class="form-select">
                                        <option value="" selected>Select</option>
                                        <option value="Normal">Normal</option>
                                        <option value="Physically challenged">Physically challenged</option>
                                    </select>
                                </div>
                                @endif
                                @if(!isset($fieldsetting->b_group) || $fieldsetting->b_group == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3">
                                    <label class="label-1">Blood Group</label>
                                    <select name="b_group" class="form-select">
                                        <option value="" selected>Select</option>
                                        <option value="O negative">O negative</option>
                                        <option value="O positive">O positive</option>
                                        <option value="A negative">A negative</option>
                                        <option value="A positive">A positive</option>
                                        <option value="B negative">B negative</option>
                                        <option value="B positive">B positive</option>
                                        <option value="AB negative">AB negative</option>
                                        <option value="AB positive">AB positive</option>
                                    </select>
                                </div>
                                @endif
                            </div>
                            <h5 class="mb-4 colorSecondary inRegisterSubTitle"><i class="fas fa-star pe-2"></i> Horoscope Information</h5>
                            <div class="row mb-4">
                                @if(!isset($fieldsetting->dosh) || $fieldsetting->dosh == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3">
                                    {{-- <input type="hidden" value="{{$register->dosh}}" name="dosh" id="dosh"> --}}
                                    <label class="label-1">Have Dosh</label>
                                    <select name="dosh" class="form-select" id="havedosh">
                                        <option value="" selected>Select</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                                @endif
                                @if(!isset($fieldsetting->manglik) || $fieldsetting->manglik == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3" id="manglik">
                                    <label class="label-1">Dosh Type</label>
                                    <select name="manglik" class="form-select" id="floatingSelect" >
                                        <option value="" selected>Select</option>
                                        @foreach($doshes as $dosh)
                                        <option value="{{$dosh->id}}">{{$dosh->dosh}}</option>
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
                                        <option value="{{$rasi->id}}">{{$rasi->rasi}}</option>
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
                                        <option value="{{$star->id}}">{{$star->star}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                                @if(!isset($fieldsetting->birthtime) || $fieldsetting->birthtime == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3">
                                    <label class="label-1">Birth Time</label>
                                    <input type="time" value="" name="birthtime" class="form-control">
                                </div>
                                @endif
                                @if(!isset($fieldsetting->birthplace) || $fieldsetting->birthplace == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3">
                                    <label class="label-1">Birth Place</label>
                                    <input type="text" value="" name="birthplace" class="form-control" placeholder="Enter birth place">
                                </div>
                                @endif
                            </div>
                            <h5 class="mb-4 colorSecondary inRegisterSubTitle"><i class="fas fa-user pe-2"></i> About Me</h5>
                            <div class="row mb-4">
                                <div class="col-xl-12 mb-3">
                                <textarea rows="4" name="profile_text" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="col-xl-12 text-center">
                                <div class="mb-3">
                                    <input type="submit" value="Continue" class="btn btnSecondary shadow-sm">
                                </div>
                            </div>
                               
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Error  message -->
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
    </div>
</section>

@endsection

@section('pageJS')

<!-- Chosen js -->
<script src="{{ asset('user/js/chosen.jquery.js') }}" type="text/javascript"></script>
<script src="{{ asset('user/js/prism.js') }}" type="text/javascript" charset="utf-8"></script>
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
        
        $('#country').on('change', function () {
            Dropdown();
        });
        $('#state').on('change', function () {
            Dropdowncity();
        });

        function Dropdown(state){
            //var modalId = $('#id').val();
            var idCountry = $('#country').val();
            $("#state").html('');
            $.ajax({
                url: "{{ route('userprofilestate') }}",
                type: "POST",
                data: {
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
            //var modalId = $('#id').val();
            var idstate =  $('#state').val();
            $("#city").html('');
            $.ajax({
                url: "{{route('userprofilecity')}}",
                type: "POST",
                data: {
                    state_id: idstate,
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

    
    });
</script>

@endsection
