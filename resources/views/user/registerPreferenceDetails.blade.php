@extends('user.layouts.beforeLoginLayout')

@section('pageCSS')
    <!-- chosen css -->
    <link rel="stylesheet" href="{{ asset('user/css/prism.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/chosen.css') }}">
    <!-- /. chosen css -->    
@endsection

<!-- Content Section Start -->
@section('content')
<!--<section class="inLogin mb-5 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-xl-8 m-auto">
                <div class="card">
                    <div class="card-body ps-md-5 pe-md-5 ps-4 pe-4 pt-4 pb-4">
                        <h4 class="inLoginTitle"><i class="fas fa-users pe-3"></i>Partner Preference</h4>
                        <p class="mb-4">Fill your partner preference details so we can show best match as per your criteria.</p>
                        <form method="POST" id="register_form" action="{{ route('user.registerPreferenceDetailsPost') }}">
                            @csrf
                           
                            <h5 class="mb-4 colorSecondary inRegisterSubTitle">
                                <i class="fas fa-file-text pe-2"></i> Basic Preference
                            </h5>
                            <div class="row mb-4">
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

                            <h5 class="mb-4 colorSecondary inRegisterSubTitle">
                                <i class="fas fa-wine-glass pe-2"></i>Habit Preference
                            </h5>
                            <div class="row mb-4">
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
                            <h5 class="mb-4 colorSecondary inRegisterSubTitle">
                                <i class="fas fa-graduation-cap pe-2"></i> Education & Occupation Preference
                            </h5>
                            <div class="row mb-4">
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
                                    <label class="label-1">Monthly Income</label>
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
                            <h5 class="mb-4 colorSecondary inRegisterSubTitle">
                                <i class="fas fa-book pe-2"></i> Religion Preference
                            </h5>
                            <div class="row mb-4">
                                <div class="col-xl-6 col-lg-6 mb-3 chosen-style-3">
                                    <label class="label-1">Religion</label>
                                    <select name="part_religion[]" class="form-select chosen-select" data-placeholder="Choose" id="part_religion" data-placeholder="Choose" multiple>
                                        <option value="">select</option>
                                        @foreach($religions as $religion)
                                        <option value="{{ $religion->id }}" >{{ $religion->religion_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-xl-6 col-lg-6 mb-3 chosen-style-3">
                                    <label class="label-1">Caste</label>
                                    <select name="part_caste[]" class="form-select chosen-select" id="part_caste" data-placeholder="Choose" multiple>
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
                                        <option value="{{ $rasi->id }}">{{ $rasi->rasi }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                                @if(!isset($fieldsetting->part_dosh) || $fieldsetting->part_dosh == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3 ">
                                    <label class="label-1">Have Dosh?</label>
                                    <select name="part_dosh" class="form-select" id="havedoshpart">
                                        <option value="" selected>Select</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div> 
                                @endif
                                @if(!isset($fieldsetting->part_manglik) || $fieldsetting->part_manglik == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3 chosen-style-3" id="doshpart">
                                    <label class="label-1">Dosh Type</label>
                                    <select name="part_manglik[]" class="form-select chosen-select" id="floatingSelect" data-placeholder="Choose" multiple>
                                        <option value="">Select</option>
                                        @foreach($doshes as $dosh)
                                        <option value="{{ $dosh->id }}">{{ $dosh->dosh }}</option>
                                        @endforeach
                                    </select>
                                </div> 
                                @endif
                            </div>
                            <h5 class="mb-4 colorSecondary inRegisterSubTitle">
                                <i class="fas fa-location-dot pe-2"></i> Location Preference
                            </h5>
                            <div class="row mb-4">
                                <div class="col-xl-6 col-lg-6 mb-3 chosen-style-3">
                                    <label class="label-1">Country</label>
                                    <select  name="part_country_living[]" id="part_country" class="form-select chosen-select" data-placeholder="Choose" multiple>
                                        <option value="">Select</option>
                                        @foreach($countries as $country)
                                        <option value="{{$country->id}}">{{$country->country_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @if(!isset($fieldsetting->part_state) || $fieldsetting->part_state == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3 chosen-style-3">
                                    <label class="label-1">State</label>
                                    <select name="part_state[]" id="part_state" class="form-select chosen-select"  multiple>                            
                                    </select>
                                </div>
                                @endif
                                @if(!isset($fieldsetting->part_city) || $fieldsetting->part_city == "Yes" )
                                <div class="col-xl-6 col-lg-6 mb-3 chosen-style-3">
                                    <label class="label-1">City</label>
                                    <select name="part_city[]" class="form-select chosen-select" id="part_city" multiple>
                                    </select>
                                </div> 
                                @endif
                            </div>
                            <h5 class="mb-4 colorSecondary inRegisterSubTitle">
                                <i class="fas fa-user-group pe-2"></i> Partner Preference
                            </h5>
                            <div class="row mb-4">
                                <div class="col-xl-12 mb-3">
                                <textarea rows="4" name="part_expect" class="form-control">@if(isset($register->part_expect)){{$register->part_expect}}@else{{old('part_expect')}}@endif</textarea>
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
</section>-->

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
       
        $('#doshpart').hide(); 
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

    
        // Dropdownpartcaste(partcaste,modalId);
        // partcountry(partstate,modalId);
        // PartStateUser(partcity,modalId);

        //part religion
        $('#part_religion').on('change', function () {
            var part_religion_id = $('#part_religion').val();
            $("#part_caste").html('');
            $.ajax({
                url: "{{ route('userprofilepartcaste') }}",
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
   
        //change state
        $('#part_country').change(function () {
            var partcountryIds = $('#part_country').val();
            $("#part_state").html('');

            $.ajax({
                url: "{{ route('userprofilepartstate') }}",
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
        $('#part_state').change(function () {
             var partstateIds = $('#part_state').val();
            $("#part_city").html('');

            $.ajax({
                url: "{{route('userprofilepartcity')}}",
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
