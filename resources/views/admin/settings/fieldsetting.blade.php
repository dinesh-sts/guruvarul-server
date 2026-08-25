@extends('admin.layouts.afterLoginLayout')

@section('title') Admin - Field Settings @endsection

@section('pageCSS') @endsection

@section('content')
<div class="container pt-5">
    <div class="row">            
        <div class="col-xl-8 offset-xl-2 mb-3">
            <div class="card inBorderColor1 inAAddMembership mb-3">
                <div class="card-header">
                    <h4 class="card-title">Field Settings</h4>
                </div>
                <div class="card-body">
                    <p><b>Note:</b> Checked fields are enabled field</p>
                    <form action="{{route('admin.fieldSettingsUpdate')}}" class="inFieldSetting col-xl-8 offset-xl-2" method="POST" enctype="multipart/form-data">
                        @csrf
                        <h4 class="mb-4 fs-6">Religion Section</h4>
                        <div class="row">
                            <div class="col-xl-12 mb-4 ps-4">
                                <div class="row">
                                    <div class="col-xl-12 inMB-10">
                                        <label class="" for="subcaste">
                                            <input type="checkbox" @if(isset($fieldsetting->sub_caste)){{$fieldsetting->sub_caste == 'Yes' ? 'checked' : '' }}@endif name="sub_caste" id="subcaste" class="form-check-input"><span class="ps-2">Sub Caste</span>
                                        </label>
                                    </div>
                                    <div class="col-xl-12 inMB-10">
                                        <label class="" for="gotra">
                                            <input type="checkbox" @if(isset($fieldsetting->gotra)){{$fieldsetting->gotra == 'Yes' ? 'checked' : ''}}@endif name="gotra" id="gotra" class="form-check-input"><span class="ps-2">Gotra</span>
                                        </label>
                                    </div>
                                    <div class="col-xl-12 inMB-10">
                                        <label class="inMainResultCheck" for="will_to_marry">
                                            <input type="checkbox" @if(isset($fieldsetting->will_to_marry)){{$fieldsetting->will_to_marry == 'Yes' ? "checked" : ''}}@endif name="will_to_marry" id="will_to_marry" class="form-check-input"><span class="ps-2">Will to marry in other caste ?</span>
                                        </label>
                                    </div>
                                    <p class="mt-3 mb-3"><b>Christian Religion Fields</b></p>
                                    <div class="col-xl-12 inMB-10">
                                        <label class="inMainResultCheck" for="church_name">
                                            <input type="checkbox" @if(isset($fieldsetting->church_name)){{$fieldsetting->church_name == 'Yes' ? "checked" : ''}}@endif name="church_name" id="church_name" class="form-check-input"><span class="ps-2">Church Name</span>
                                        </label>
                                    </div>
                                    <div class="col-xl-12 inMB-10">
                                        <label class="inMainResultCheck" for="denomination">
                                            <input type="checkbox" @if(isset($fieldsetting->denomination)){{$fieldsetting->denomination == 'Yes' ? "checked" : ''}}@endif name="denomination" id="denomination" class="form-check-input"><span class="ps-2">Denomination</span>
                                        </label>
                                    </div>
                                    <div class="col-xl-12 inMB-10">
                                        <label class="inMainResultCheck" for="baptism">
                                            <input type="checkbox" @if(isset($fieldsetting->baptism)){{$fieldsetting->baptism == 'Yes' ? "checked" : ''}}@endif name="baptism" id="baptism" class="form-check-input"><span class="ps-2">Baptism</span>
                                        </label>
                                    </div>
                                    <div class="col-xl-12 inMB-10">
                                        <label class="inMainResultCheck" for="born_again">
                                            <input type="checkbox" @if(isset($fieldsetting->born_again)){{$fieldsetting->born_again == 'Yes' ? "checked" : ''}}@endif name="born_again" id="born_again" class="form-check-input"><span class="ps-2">Born Again</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h4 class="mb-4 fs-6">Education / Occupation Section</h4>
                        <div class="row">
                            <div class="col-xl-12 mb-4 ps-4">
                                <div class="row">
                                    <div class="col-xl-12 inMB-10">
                                        <label class="" for="additional_degree">
                                            <input type="checkbox" @if(isset($fieldsetting->additional_degree)){{$fieldsetting->additional_degree == 'Yes' ? "checked" : ''}}@endif name="additional_degree" id="additional_degree" class="form-check-input"><span class="ps-2">Additional Degree</span>
                                        </label>
                                    </div>
                                    <div class="col-xl-12 inMB-10">
                                        <label class="" for="company_name">
                                            <input type="checkbox" @if(isset($fieldsetting->company_name)){{$fieldsetting->company_name == 'Yes' ? "checked" : ''}}@endif name="company_name" id="company_name" class="form-check-input"><span class="ps-2">Company Name</span>
                                        </label>
                                    </div>
                                    <div class="col-xl-12 inMB-10">
                                        <label class="" for="designation">
                                            <input type="checkbox" @if(isset($fieldsetting->designation)){{$fieldsetting->designation == 'Yes' ? "checked" : ''}}@endif name="designation" id="designation" class="form-check-input"><span class="ps-2">Designation</span>
                                        </label>
                                    </div>
                                    <div class="col-xl-12 inMB-10">
                                        <label class="" for="annual_income">
                                            <input type="checkbox" @if(isset($fieldsetting->annual_income)){{$fieldsetting->annual_income == 'Yes' ? "checked" : ''}}@endif name="annual_income" id="annual_income" class="form-check-input"><span class="ps-2">Monthly Income</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h4 class="mb-4 fs-6">Family Details Section</h4>
                        <div class="row">
                            <div class="col-xl-12 mb-4 ps-4">
                                <div class="row">
                                    <div class="col-xl-12 inMB-10">
                                        <label class="" for="family_status">
                                            <input type="checkbox" @if(isset($fieldsetting->family_status)){{$fieldsetting->family_status == 'Yes' ? "checked" : ''}}@endif name="family_status" id="family_status" class="form-check-input"><span class="ps-2">Family Status</span>
                                        </label>
                                    </div>
                                    <div class="col-xl-12 inMB-10">
                                        <label class="" for="family_type">
                                            <input type="checkbox" @if(isset($fieldsetting->family_type)){{$fieldsetting->family_type == 'Yes' ? "checked" : ''}}@endif name="family_type" id="family_type" class="form-check-input"><span class="ps-2">Family Type</span>
                                        </label>
                                    </div>
                                    <div class="col-xl-12 inMB-10">
                                        <label class="" for="family_value">
                                            <input type="checkbox" @if(isset($fieldsetting->family_value)){{$fieldsetting->family_value == 'Yes' ? "checked" : ''}}@endif name="family_value" id="family_value" class="form-check-input"><span class="ps-2">Family Value</span>
                                        </label>
                                    </div>
                                    <div class="col-xl-12 inMB-10">
                                        <label class="" for="father_name">
                                            <input type="checkbox" @if(isset($fieldsetting->father_name)){{$fieldsetting->father_name == 'Yes' ? "checked" : ''}}@endif name="father_name" id="father_name" class="form-check-input"><span class="ps-2">Father Name</span>
                                        </label>
                                    </div>
                                    <div class="col-xl-12 inMB-10">
                                        <label class="" for="father_occupation">
                                            <input type="checkbox" @if(isset($fieldsetting->father_occupation)){{$fieldsetting->father_occupation == 'Yes' ? "checked" : ''}}@endif name="father_occupation" id="father_occupation" class="form-check-input"><span class="ps-2">Father Occupation</span>
                                        </label>
                                    </div>
                                    <div class="col-xl-12 inMB-10">
                                        <label class="" for="mother_name">
                                            <input type="checkbox" @if(isset($fieldsetting->mother_name)){{$fieldsetting->mother_name == 'Yes' ? "checked" : ''}}@endif name="mother_name" id="mother_name" class="form-check-input"><span class="ps-2">Mother Name</span>
                                        </label>
                                    </div>
                                    <div class="col-xl-12 inMB-10">
                                        <label class="" for="mother_occupation">
                                            <input type="checkbox" @if(isset($fieldsetting->mother_occupation)){{$fieldsetting->mother_occupation == 'Yes' ? "checked" : ''}}@endif name="mother_occupation" id="mother_occupation" class="form-check-input"><span class="ps-2">Mother Occupation</span>
                                        </label>
                                    </div>
                                    <div class="col-xl-12 inMB-10">
                                        <label class="" for="no_of_brother">
                                            <input type="checkbox" @if(isset($fieldsetting->no_of_brother)){{$fieldsetting->no_of_brother == 'Yes' ? "checked" : ''}}@endif name="no_of_brother" id="no_of_brother" class="form-check-input"><span class="ps-2">No of Brothers</span>
                                        </label>
                                    </div>
                                    <div class="col-xl-12 inMB-10">
                                        <label class="" for="no_of_married_brother">
                                            <input type="checkbox" @if(isset($fieldsetting->no_of_married_brother)){{$fieldsetting->no_of_married_brother == 'Yes' ? "checked" : ''}}@endif name="no_of_married_brother" id="no_of_married_brother" class="form-check-input"><span class="ps-2">No of Married Brothers</span>
                                        </label>
                                    </div>
                                    <div class="col-xl-12 inMB-10">
                                        <label class="" for="no_of_sister">
                                            <input type="checkbox" @if(isset($fieldsetting->no_of_sister)){{$fieldsetting->no_of_sister == 'Yes' ? "checked" : ''}}@endif name="no_of_sister" id="no_of_sister" class="form-check-input"><span class="ps-2">No of Sisters</span>
                                        </label>
                                    </div>
                                    <div class="col-xl-12 inMB-10">
                                        <label class="" for="no_of_married_sister">
                                            <input type="checkbox" @if(isset($fieldsetting->no_of_married_sister)){{$fieldsetting->no_of_married_sister == 'Yes' ? "checked" : ''}}@endif name="no_of_married_sister" id="no_of_married_sister" class="form-check-input"><span class="ps-2">No of Married Sisters</span>
                                        </label>
                                    </div>
                                    <div class="col-xl-12 inMB-10">
                                        <label class="" for="maternal_details">
                                            <input type="checkbox" @if(isset($fieldsetting->maternal_details)){{$fieldsetting->maternal_details == 'Yes' ? "checked" : ''}}@endif name="maternal_details" id="maternal_details" class="form-check-input"><span class="ps-2">Maternal Details</span>
                                        </label>
                                    </div>
                                    <div class="col-xl-12 inMB-10">
                                        <label class="" for="paternal_details">
                                            <input type="checkbox" @if(isset($fieldsetting->paternal_details)){{$fieldsetting->paternal_details == 'Yes' ? "checked" : ''}}@endif name="paternal_details" id="paternal_details" class="form-check-input"><span class="ps-2">Paternal Details</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <h4 class="mb-4 fs-6">Location Details Section</h4>
                        <div class="row">
                            <div class="col-xl-12 mb-4 ps-4">
                                <div class="row">
                                    <div class="col-xl-12 inMB-10">
                                        <label class="" for="address">
                                            <input type="checkbox" @if(isset($fieldsetting->address)){{$fieldsetting->address == 'Yes' ? "checked" : ''}}@endif name="address" id="address" class="form-check-input"><span class="ps-2">Address</span>
                                        </label>
                                    </div>
                                </div> 
                            </div>
                        </div>

                        <h4 class="mb-4 fs-6">About Section</h4>
                        <div class="row">
                            <div class="col-xl-12 mb-4 ps-4">
                                <div class="row">
                                    <div class="col-xl-12 inMB-10">
                                        <label class="" for="profile_text">
                                            <input type="checkbox" @if(isset($fieldsetting->profile_text)){{$fieldsetting->profile_text == 'Yes' ? "checked" : ''}}@endif name="profile_text" id="profile_text" class="form-check-input"><span class="ps-2">Profile Text</span>
                                        </label>
                                    </div>
                                </div> 
                            </div>
                        </div>
                        <h4 class="mb-4 fs-6">Habits & Hobbies Section</h4>
                        <div class="row">
                            <div class="col-xl-12 mb-4 ps-4">
                                <div class="row">
                                    <div class="col-xl-12 inMB-10">
                                        <label class="" for="diet">
                                            <input type="checkbox" @if(isset($fieldsetting->diet)){{$fieldsetting->diet == 'Yes' ? "checked" : ''}}@endif name="diet" id="diet" class="form-check-input"><span class="ps-2">Eating Habits</span>
                                        </label>
                                    </div>
                                    <div class="col-xl-12 inMB-10">
                                        <label class="" for="drink">
                                            <input type="checkbox" @if(isset($fieldsetting->drink)){{$fieldsetting->drink == 'Yes' ? "checked" : ''}}@endif name="drink" id="drink" class="form-check-input"><span class="ps-2">Drinking Habits</span>
                                        </label>
                                    </div>
                                    <div class="col-xl-12 inMB-10">
                                        <label class="" for="smoke">
                                            <input type="checkbox" @if(isset($fieldsetting->smoke)){{$fieldsetting->smoke == 'Yes' ? "checked" : ''}}@endif name="smoke" id="smoke" class="form-check-input"><span class="ps-2">Smoking Habits</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h4 class="mb-4 fs-6">Physical Details Section</h4>
                        <div class="row">
                            <div class="col-xl-12 mb-4 ps-4">
                                <div class="row">
                                    <div class="col-xl-12 inMB-10">
                                        <label class="" for="complexion">
                                            <input type="checkbox" @if(isset($fieldsetting->complexion)){{$fieldsetting->complexion == 'Yes' ? "checked" : ''}}@endif name="complexion" id="complexion" class="form-check-input"><span class="ps-2">Complexion</span>
                                        </label>
                                    </div>
                                    <div class="col-xl-12 inMB-10">
                                        <label class="" for="height">
                                            <input type="checkbox" @if(isset($fieldsetting->height)){{$fieldsetting->height == 'Yes' ? "checked" : ''}}@endif name="height" id="height" class="form-check-input"><span class="ps-2">Height</span>
                                        </label>
                                    </div>
                                    <div class="col-xl-12 inMB-10">
                                        <label class="" for="body_type">
                                            <input type="checkbox" @if(isset($fieldsetting->body_type)){{$fieldsetting->body_type == 'Yes' ? "checked" : ''}}@endif name="body_type" id="body_type" class="form-check-input"><span class="ps-2">Body Type</span>
                                        </label>
                                    </div>
                                    <div class="col-xl-12 inMB-10">
                                        <label class="" for="weight">
                                            <input type="checkbox" @if(isset($fieldsetting->weight)){{$fieldsetting->weight == 'Yes' ? "checked" : ''}}@endif name="weight" id="weight" class="form-check-input"><span class="ps-2">Weight</span>
                                        </label>
                                    </div>
                                    <div class="col-xl-12 inMB-10">
                                        <label class="" for="physical_status">
                                            <input type="checkbox" @if(isset($fieldsetting->physical_status)){{$fieldsetting->physical_status == 'Yes' ? "checked" : ''}}@endif name="physical_status" id="physical_status" class="form-check-input"><span class="ps-2">Physical Status</span>
                                        </label>
                                    </div>
                                    <div class="col-xl-12 inMB-10">
                                        <label class="" for="b_group">
                                            <input type="checkbox" @if(isset($fieldsetting->b_group)){{$fieldsetting->b_group == 'Yes' ? "checked" : ''}}@endif name="b_group" id="b_group" class="form-check-input"><span class="ps-2">Blood Group</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h4 class="mb-4 fs-6">Horoscope Details Section</h4>
                        <div class="row">
                            <div class="col-xl-12 mb-4 ps-4">
                                <div class="row">
                                    <div class="col-xl-12 inMB-10">
                                        <label class="" for="dosh">
                                            <input type="checkbox" @if(isset($fieldsetting->dosh)){{$fieldsetting->dosh == 'Yes' ? "checked" : ''}}@endif name="dosh" id="dosh" class="form-check-input"><span class="ps-2">Have Dosh</span>
                                        </label>
                                    </div>
                                    <div class="col-xl-12 inMB-10">
                                        <label class="" for="manglik">
                                            <input type="checkbox" @if(isset($fieldsetting->manglik)){{$fieldsetting->manglik == 'Yes' ? "checked" : ''}}@endif name="manglik" id="manglik" class="form-check-input"><span class="ps-2">Dosh Type</span>
                                        </label>
                                    </div>
                                    <div class="col-xl-12 inMB-10">
                                        <label class="" for="rasi">
                                            <input type="checkbox" @if(isset($fieldsetting->rasi)){{$fieldsetting->rasi == 'Yes' ? "checked" : ''}}@endif name="rasi" id="rasi" class="form-check-input"><span class="ps-2">Rasi/Moonsign</span>
                                        </label>
                                    </div>
                                    <div class="col-xl-12 inMB-10">
                                        <label class="" for="star">
                                            <input type="checkbox" @if(isset($fieldsetting->star)){{$fieldsetting->star == 'Yes' ? "checked" : ''}}@endif name="star" id="star" class="form-check-input"><span class="ps-2">Star</span>
                                        </label>
                                    </div>
                                    <div class="col-xl-12 inMB-10">
                                        <label class="" for="birthtime">
                                            <input type="checkbox" @if(isset($fieldsetting->birthtime)){{$fieldsetting->birthtime == 'Yes' ? "checked" : ''}}@endif name="birthtime" id="birthtime" class="form-check-input"><span class="ps-2">Birth Time</span>
                                        </label>
                                    </div>
                                    <div class="col-xl-12 inMB-10">
                                        <label class="" for="birthplace">
                                            <input type="checkbox" @if(isset($fieldsetting->birthplace)){{$fieldsetting->birthplace == 'Yes' ? "checked" : ''}}@endif name="birthplace" id="birthplace" class="form-check-input"><span class="ps-2">Birth Place</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <h4 class="mb-4 fs-6">Basic Preference Section</h4>
                        <div class="row">
                            <div class="col-xl-12 mb-4 ps-4">
                                <div class="row">
                                    <div class="col-xl-12 inMB-10">
                                        <label class="" for="part_complexation">
                                            <input type="checkbox" @if(isset($fieldsetting->part_complexation)){{$fieldsetting->part_complexation == 'Yes' ? "checked" : ''}}@endif name="part_complexation" id="part_complexation" class="form-check-input"><span class="ps-2">Complexion</span>
                                        </label>
                                    </div>
                                    <div class="col-xl-12 inMB-10">
                                        <label class="" for="part_bodytype">
                                            <input type="checkbox" @if(isset($fieldsetting->part_bodytype)){{$fieldsetting->part_bodytype == 'Yes' ? "checked" : ''}}@endif name="part_bodytype" id="part_bodytype" class="form-check-input"><span class="ps-2">Body Type</span>
                                        </label>
                                    </div>
                                    <div class="col-xl-12 inMB-10">
                                        <label class="" for="part_physical_status">
                                            <input type="checkbox" @if(isset($fieldsetting->part_physical_status)){{$fieldsetting->part_physical_status == 'Yes' ? "checked" : ''}}@endif name="part_physical_status" id="part_physical_status" class="form-check-input"><span class="ps-2">Physical Status</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <h4 class="mb-4 fs-6">Habit Preference Section</h4>
                        <div class="row">
                            <div class="col-xl-12 mb-4 ps-4">
                                <div class="row">
                                    <div class="col-xl-12 inMB-10">
                                        <label class="" for="part_diet">
                                            <input type="checkbox" @if(isset($fieldsetting->part_diet)){{$fieldsetting->part_diet == 'Yes' ? "checked" : ''}}@endif name="part_diet" id="part_diet" class="form-check-input"><span class="ps-2">Eating Habit</span>
                                        </label>
                                    </div>
                                    <div class="col-xl-12 inMB-10">
                                        <label class="" for="part_smoke">
                                            <input type="checkbox" @if(isset($fieldsetting->part_smoke)){{$fieldsetting->part_smoke == 'Yes' ? "checked" : ''}}@endif name="part_smoke" id="part_smoke" class="form-check-input"><span class="ps-2">Smoking Habit</span>
                                        </label>
                                    </div>
                                    <div class="col-xl-12 inMB-10">
                                        <label class="" for="part_drink">
                                            <input type="checkbox" @if(isset($fieldsetting->part_drink)){{$fieldsetting->part_drink == 'Yes' ? "checked" : ''}}@endif name="part_drink" id="part_drink" class="form-check-input"><span class="ps-2">Drinking Habit</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <h4 class="mb-4 fs-6">Education & Occupation Preference Section</h4>
                        <div class="row">
                            <div class="col-xl-12 mb-4 ps-4">
                                <div class="row">
                                    <div class="col-xl-12 inMB-10">
                                        <label class="" for="part_annual_income">
                                            <input type="checkbox" @if(isset($fieldsetting->part_annual_income)){{$fieldsetting->part_annual_income == 'Yes' ? "checked" : ''}}@endif name="part_annual_income" id="part_annual_income" class="form-check-input"><span class="ps-2">Monthly Income</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <h4 class="mb-4 fs-6">Religion Preference Section</h4>
                        <div class="row">
                            <div class="col-xl-12 mb-4 ps-4">
                                <div class="row">
                                    <div class="col-xl-12 inMB-10">
                                        <label class="" for="part_star">
                                            <input type="checkbox" @if(isset($fieldsetting->part_star)){{$fieldsetting->part_star == 'Yes' ? "checked" : ''}}@endif name="part_star" id="part_star" class="form-check-input"><span class="ps-2">Star</span>
                                        </label>
                                    </div>
                                    <div class="col-xl-12 inMB-10">
                                        <label class="" for="part_rasi">
                                            <input type="checkbox" @if(isset($fieldsetting->part_rasi)){{$fieldsetting->part_rasi == 'Yes' ? "checked" : ''}}@endif name="part_rasi" id="part_rasi" class="form-check-input"><span class="ps-2">Rasi/Moonsign</span>
                                        </label>
                                    </div>
                                    <div class="col-xl-12 inMB-10">
                                        <label class="" for="part_dosh">
                                            <input type="checkbox" @if(isset($fieldsetting->part_dosh)){{$fieldsetting->part_dosh == 'Yes' ? "checked" : ''}}@endif name="part_dosh" id="part_dosh" class="form-check-input"><span class="ps-2">Have Dosh?</span>
                                        </label>
                                    </div>
                                    <div class="col-xl-12 inMB-10">
                                        <label class="" for="part_manglik">
                                            <input type="checkbox" @if(isset($fieldsetting->part_manglik)){{$fieldsetting->part_manglik == 'Yes' ? "checked" : ''}}@endif name="part_manglik" id="part_manglik" class="form-check-input"><span class="ps-2">Dosh Type</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h4 class="mb-4 fs-6">Partner Location Details Section</h4>
                        <div class="row">
                            <div class="col-xl-12 mb-4 ps-4">
                                <div class="row">
                                    <div class="col-xl-12 inMB-10">
                                        <label class="" for="part_state">
                                            <input type="checkbox" @if(isset($fieldsetting->part_state)){{$fieldsetting->part_state == 'Yes' ? "checked" : ''}}@endif name="part_state" id="part_state" class="form-check-input"><span class="ps-2">State</span>
                                        </label>
                                    </div>
                                    <div class="col-xl-12 inMB-10">
                                        <label class="" for="part_city">
                                            <input type="checkbox" @if(isset($fieldsetting->part_city)){{$fieldsetting->part_city == 'Yes' ? "checked" : ''}}@endif name="part_city" id="part_city" class="form-check-input"><span class="ps-2">City</span>
                                        </label>
                                    </div>
                                </div> 
                            </div>
                        </div>

                        <h4 class="mb-4 fs-6">Partner Expectation Section</h4>
                        <div class="row">
                            <div class="col-xl-12 mb-4 ps-4">
                                <div class="row">
                                    <div class="col-xl-12 inMB-10">
                                        <label class="" for="part_expect">
                                            <input type="checkbox" @if(isset($fieldsetting->part_expect)){{$fieldsetting->part_expect == 'Yes' ? "checked" : ''}}@endif name="part_expect" id="part_expect" class="form-check-input"><span class="ps-2">Partner Expectation</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12 mb-4 text-center">
                            <input type="submit" value="UPDATE" class="btn btnPrimary">
                        </div>
                    </form>
                </div>
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
