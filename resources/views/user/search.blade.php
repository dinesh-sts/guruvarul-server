@extends('user.layouts.beforeLoginLayout')

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
            <h2 class="text-center">Search Options</h2>
        </div>
    </section>
    <!-- /.Page Header -->

    <!-- Search Card -->
    <section class="inSearchCard mb-5">
        <div class="container">
            <div class="row">
                <div class="col-xl-10 offset-xl-1 inSearchPill">
                    <!-- Tabs -->
                    <ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab" role="tablist">
                        <li class="nav-item me-2" role="presentation">
                            <button class="nav-link active" id="pills-quick-tab" data-bs-toggle="pill" data-bs-target="#pills-quick" type="button" role="tab" aria-controls="pills-quick" aria-selected="true">Quick Search</button>
                        </li>
                        <li class="nav-item ms-2 me-2" role="presentation">
                            <button class="nav-link" id="pills-advance-tab" data-bs-toggle="pill" data-bs-target="#pills-advance" type="button" role="tab" aria-controls="pills-advance" aria-selected="false">Advance Search</button>
                        </li>
                        <li class="nav-item ms-2 me-2" role="presentation">
                            <button class="nav-link" id="pills-location-tab" data-bs-toggle="pill" data-bs-target="#pills-location" type="button" role="tab" aria-controls="pills-location" aria-selected="false">Location Search</button>
                        </li>
                        <li class="nav-item ms-2 me-2" role="presentation">
                            <button class="nav-link" id="pills-occupation-tab" data-bs-toggle="pill" data-bs-target="#pills-occupation" type="button" role="tab" aria-controls="pills-occupation" aria-selected="false">Occupation Search</button>
                        </li>
                        <li class="nav-item ms-2 me-2" role="presentation">
                            <button class="nav-link" id="pills-id-tab" data-bs-toggle="pill" data-bs-target="#pills-id" type="button" role="tab" aria-controls="pills-id" aria-selected="false">Search By Id</button>
                        </li>
                        <li class="nav-item ms-2 me-2" role="presentation">
                            <button class="nav-link" id="pills-keyword-tab" data-bs-toggle="pill" data-bs-target="#pills-keyword" type="button" role="tab" aria-controls="pills-keyword" aria-selected="false">Keyword Search</button>
                        </li>
                    </ul>
                    <!-- /. Tabs -->
                    <!-- Tab Pan -->
                    <div class="tab-content" id="pills-tabContent">
                        <!-- Quick Search Card-->
                        <div class="tab-pane fade show active" id="pills-quick" role="tabpanel" aria-labelledby="pills-quick-tab" tabindex="0">
                            <div class="card">
                                <div class="card-body p-md-5 p-4">
                                    <form id="Quicksearch">
                                        <div class="mb-4 row">
                                            <label class="col-sm-3 col-form-label">Gender</label>
                                            <div class="col-sm-9 pt-1">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" value="Male" type="radio" name="gender" id="male">
                                                    <label class="form-check-label" for="male">Male</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" value="Female" type="radio" name="gender" id="female" checked>
                                                    <label class="form-check-label" for="female">Female</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-4 row">
                                            <label class="col-sm-3 col-form-label">Age</label>
                                            <div class="col-sm-6">
                                                <div class="row">
                                                    <div class="col-5">
                                                        <?php $selected_a = 1 ;?>
                                                        <select name="age_to" class="form-select"  id="ageToSelect">
                                                            {{-- <option value="" selected>select</option> --}}
                                                            @foreach ($ages as $age)
                                                            <option value="{{$age->age}}" @if(isset($selected_a)) {{ $selected_a == $age->id ? "selected" : ''}} @endif >{{$age->age}} Years </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-2 text-center">
                                                        <h6 class="mt-2">To</h6>
                                                    </div>
                                                    <div class="col-5">
                                                        <?php $selected_b = 13 ;?>
                                                        <select name="age_from" class="form-select"  id="ageFromSelect">
                                                            @foreach ($ages as $age)
                                                            <option value="{{$age->age}}" @if(isset($selected_b)) {{ $selected_b == $age->id ? "selected" : ''}} @endif >{{$age->age}} Years</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-4 row chosen-style-3">
                                            <label class="col-sm-3 col-form-label">Religion</label>
                                            <div class="col-sm-6">
                                                <select name="part_religion[]" class="form-select chosen-select" id="part_religion" data-placeholder="Select Religion" multiple>
                                                    <option value="">select</option>
                                                    @foreach($religions as $religion)
                                                    <option value="{{$religion->id}}">{{$religion->religion_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-4 row chosen-style-3">
                                            <label class="col-sm-3 col-form-label">Caste</label>
                                            <div class="col-sm-6">
                                                <select name="part_caste[]" class="form-select chosen-select" id="part_caste" data-placeholder="Select Religion First" multiple>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-3 text-center">
                                            <button type="submit" id="submit" name="submit" class="btn btnPrimary">SEARCH</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- /.Quick Search Card -->
                        
                        <!-- Advance Search Card -->
                        <div class="tab-pane fade" id="pills-advance" role="tabpanel" aria-labelledby="pills-advance-tab" tabindex="0">
                            <div class="card">
                                <div class="card-body p-md-5 p-4">
                                    <form id="advancesearch">
                                        <div class="mb-4 row">
                                            <label class="col-sm-3 col-form-label">Gender</label>
                                            <div class="col-sm-9 pt-1">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" value="Male" type="radio" name="gender" id="adv_male">
                                                    <label class="form-check-label" for="adv_male">Male</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" value="Female" type="radio" name="gender" id="adv_female" checked>
                                                    <label class="form-check-label" for="adv_female">Female</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-4 row">
                                            <label class="col-sm-3 col-form-label">Age</label>
                                            <div class="col-sm-6">
                                                <div class="row">
                                                    <div class="col-5">
                                                        <?php $selected_a = 1 ;?>
                                                        <select name="age_to" class="form-select"  id="ageToSelectadv">
                                                            {{-- <option value="" selected>select</option> --}}
                                                            @foreach ($ages as $age)
                                                            <option value="{{$age->age}}" @if(isset($selected_a)) {{ $selected_a == $age->id ? "selected" : ''}} @endif >{{$age->age}} </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-2 text-center">
                                                        <h6 class="mt-2">To</h6>
                                                    </div>
                                                    <div class="col-5">
                                                        <?php $selected_b = 13 ;?>
                                                        <select name="age_from" class="form-select" id="ageFromSelectadv">
                                                            @foreach ($ages as $age)
                                                            <option value="{{$age->age}}" @if(isset($selected_b)) {{ $selected_b == $age->id ? "selected" : ''}} @endif >{{$age->age}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @if(!isset($fieldsetting->height) || $fieldsetting->height == "Yes" )
                                        <div class="mb-4 row">
                                            <label class="col-sm-3 col-form-label">Height</label>
                                            <div class="col-sm-6">
                                                <div class="row">
                                                    <div class="col-5">
                                                        <select name="part_height" class="form-select" id="part_frm_height" >
                                                            <option value="" selected>Select</option>
                                                            @foreach($heights as $height)
                                                            <option value="{{$height->id}}">{{$height->height}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-2 text-center">
                                                        <h6 class="mt-2">To</h6>
                                                    </div>
                                                    <div class="col-5">
                                                        <select name="height_from" class="form-select" id="part_to_height">
                                                            <option value="" selected>Select</option>
                                                            @foreach($heights as $height)
                                                            <option value="{{$height->id}}">{{$height->height}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="mb-4 row chosen-style-3">
                                            <label class="col-sm-3 col-form-label">Marital Status</label>
                                            <div class="col-sm-6">
                                                <select name="m_status[]" class="form-select chosen-select" id="floatingSelect" data-placeholder="Choose" multiple>
                                                    <option value="" >select</option>
                                                    <option value="Never Married">Never Married</option>
                                                    <option value="Widower">Widower</option>
                                                    <option value="Divorced">Divorced</option>
                                                    <option value="Awaiting Divorce">Awaiting Divorce</option>
                                                    <option value="Widow">Widow</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-4 row chosen-style-3">
                                            <label class="col-sm-3 col-form-label">Religion</label>
                                            <div class="col-sm-6">
                                                <select name="part_religion[]" class="form-select chosen-select" id="part_religion_as" data-placeholder="Select" multiple>
                                                    <option value="">select</option>
                                                    @foreach($religions as $religion)
                                                    <option value="{{$religion->id}}">{{$religion->religion_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-4 row chosen-style-3">
                                            <label class="col-sm-3 col-form-label">Caste</label>
                                            <div class="col-sm-6">
                                                <select name="part_caste[]" class="form-select chosen-select" id="part_caste_as" data-placeholder="Select Religion First" multiple>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-4 row">
                                            <div class="col-12">
                                                <h4 class="font-nunito borderBottomPrimary1">Location Details</h4>
                                            </div>
                                        </div>
                                        <div class="mb-4 row chosen-style-3">
                                            <label class="col-sm-3 col-form-label">Country</label>
                                            <div class="col-sm-6">
                                                <select  name="part_country_living[]" id="part_country" class="form-select chosen-select" data-placeholder="Select" multiple>
                                                    <option value="">Select</option>
                                                    @foreach($countries as $country)
                                                    <option value="{{$country->id}}">{{$country->country_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @if(!isset($fieldsetting->part_state) || $fieldsetting->part_state == "Yes" )
                                        <div class="mb-4 row chosen-style-3">
                                            <label class="col-sm-3 col-form-label">State</label>
                                            <div class="col-sm-6">
                                                <select name="part_state[]" id="part_state" class="form-select chosen-select" data-placeholder="Select Country First" multiple>                            
                                                </select>
                                            </div>
                                        </div>
                                        @endif
                                        @if(!isset($fieldsetting->part_city) || $fieldsetting->part_city == "Yes" )
                                        <div class="mb-4 row chosen-style-3">
                                            <label class="col-sm-3 col-form-label">City</label>
                                            <div class="col-sm-6">
                                                <select name="part_city[]" class="form-select chosen-select" id="part_city" data-placeholder="Select State First" multiple>
                                                </select>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="mb-4 row">
                                            <div class="col-12">
                                                <h4 class="font-nunito borderBottomPrimary1">Education & Occupation Details</h4>
                                            </div>
                                        </div>
                                        <div class="mb-4 row chosen-style-3">
                                            <label class="col-sm-3 col-form-label">Education</label>
                                            <div class="col-sm-6">
                                                <select name="part_edu[]" class="form-select chosen-select" id="floatingSelect" data-placeholder="Select" multiple>
                                                    <option value="">Select</option>
                                                    @foreach($eduDetails as $eduDetail)
                                                    <option value="{{$eduDetail->id}}">{{$eduDetail->edu_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-4 row chosen-style-3">
                                            <label class="col-sm-3 col-form-label">Occupation</label>
                                            <div class="col-sm-6">
                                                <select name="part_occu[]" class="form-select chosen-select" id="floatingSelect" data-placeholder="Select" multiple>
                                                    <option value="">Select</option>
                                                    @foreach($occupations as $occupation)
                                                    <option value="{{$occupation->id}}">{{$occupation->ocp_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @if(!isset($fieldsetting->part_annual_income) || $fieldsetting->part_annual_income == "Yes" )
                                        <div class="mb-4 row chosen-style-3">
                                            <label class="col-sm-3 col-form-label">Monthly Income</label>
                                            <div class="col-sm-6">
                                                <select name="part_income[]" class="form-select chosen-select" id="floatingSelect" data-placeholder="Select" multiple>
                                                    <option value="">Select</option>
                                                    @foreach($incomes as $income)
                                                    <option value="{{$income->id}}">{{$income->income}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="mb-3 text-center">
                                            <button type="submit" id="submit" name="submit" class="btn btnPrimary">SEARCH</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- /.Advance Search Card -->
                        
                        <!-- Location Search Card -->
                        <div class="tab-pane fade" id="pills-location" role="tabpanel" aria-labelledby="pills-location-tab" tabindex="0">
                            <div class="card">
                                <div class="card-body p-md-5 p-4">
                                    <form id="locationSearch">
                                        <div class="mb-4 row">
                                            <label class="col-sm-3 col-form-label">Gender</label>
                                            <div class="col-sm-9 pt-1">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" value="Male" type="radio" name="gender" id="adv_male">
                                                    <label class="form-check-label" for="adv_male">Male</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" value="Female" type="radio" name="gender" id="adv_female" checked>
                                                    <label class="form-check-label" for="adv_female">Female</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-4 row chosen-style-3">
                                            <label class="col-sm-3 col-form-label">Country</label>
                                            <div class="col-sm-6">
                                                <select  name="part_country_living[]" id="part_country_location" class="form-select chosen-select" data-placeholder="Select" multiple>
                                                    <option value="">Select</option>
                                                    @foreach($countries as $country)
                                                    <option value="{{$country->id}}">{{$country->country_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @if(!isset($fieldsetting->part_state) || $fieldsetting->part_state == "Yes" )
                                        <div class="mb-4 row chosen-style-3">
                                            <label class="col-sm-3 col-form-label">State</label>
                                            <div class="col-sm-6">
                                                <select name="part_state[]" id="part_state_location" class="form-select chosen-select" data-placeholder="Select Country First" multiple>                            
                                                </select>
                                            </div>
                                        </div>
                                        @endif
                                        @if(!isset($fieldsetting->part_city) || $fieldsetting->part_city == "Yes" )
                                        <div class="mb-4 row chosen-style-3">
                                            <label class="col-sm-3 col-form-label">City</label>
                                            <div class="col-sm-6">
                                                <select name="part_city[]" class="form-select chosen-select" id="part_city_location" data-placeholder="Select State First" multiple>
                                                </select>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="mb-3 text-center">
                                            <button type="submit" id="submit" name="submit" class="btn btnPrimary">SEARCH</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- /.Location Search Card -->

                        <!-- Occupation Search Card -->
                        <div class="tab-pane fade" id="pills-occupation" role="tabpanel" aria-labelledby="pills-occupation-tab" tabindex="0">
                            <div class="card">
                                <div class="card-body p-md-5 p-4">
                                    <form id="occupationSearch">
                                        <div class="mb-4 row">
                                            <label class="col-sm-3 col-form-label">Gender</label>
                                            <div class="col-sm-9 pt-1">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" value="Male" type="radio" name="gender" id="adv_male">
                                                    <label class="form-check-label" for="adv_male">Male</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" value="Female" type="radio" name="gender" id="adv_female" checked>
                                                    <label class="form-check-label" for="adv_female">Female</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-4 row chosen-style-3">
                                            <label class="col-sm-3 col-form-label">Education</label>
                                            <div class="col-sm-6">
                                                <select name="part_edu[]" class="form-select chosen-select" data-placeholder="Select" multiple>
                                                    <option value="">Select</option>
                                                    @foreach($eduDetails as $eduDetail)
                                                    <option value="{{$eduDetail->id}}">{{$eduDetail->edu_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-4 row chosen-style-3">
                                            <label class="col-sm-3 col-form-label">Occupation</label>
                                            <div class="col-sm-6">
                                                <select name="part_occu[]" class="form-select chosen-select" data-placeholder="Select" multiple>
                                                    <option value="">Select</option>
                                                    @foreach($occupations as $occupation)
                                                    <option value="{{$occupation->id}}">{{$occupation->ocp_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @if(!isset($fieldsetting->part_annual_income) || $fieldsetting->part_annual_income == "Yes" )
                                        <div class="mb-4 row chosen-style-3">
                                            <label class="col-sm-3 col-form-label">Monthly Income</label>
                                            <div class="col-sm-6">
                                                <select name="part_income[]" class="form-select chosen-select" data-placeholder="Select" multiple>
                                                    <option value="">Select</option>
                                                    @foreach($incomes as $income)
                                                    <option value="{{$income->id}}">{{$income->income}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="mb-3 text-center">
                                            <button type="submit" id="submit" name="submit" class="btn btnPrimary">SEARCH</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- /.Occupation Search Card -->

                        <!-- Member Id Search Card -->
                        <div class="tab-pane fade" id="pills-id" role="tabpanel" aria-labelledby="pills-id-tab" tabindex="0">
                            <div class="card">
                                <div class="card-body p-md-5 p-4">
                                    <form id="Memberidsearch">
                                        <div class="mb-4 row">
                                            <label class="col-sm-3 col-form-label">Member Id</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="member_id" placeholder="Enter Member Id">
                                            </div>
                                        </div>
                                        <div class="mb-3 text-center">
                                            <button type="submit" id="submit" name="submit" class="btn btnPrimary">SEARCH</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- /.Member Id Search Card -->
                        
                        <!-- Keyword Search Card -->
                        <div class="tab-pane fade" id="pills-keyword" role="tabpanel" aria-labelledby="pills-keyword-tab" tabindex="0">
                            <div class="card">
                                <div class="card-body card-body p-md-5 p-4 ">
                                    <form id="keywordsearch">
                                        <div class="mb-4 row">
                                            <label class="col-sm-3 col-form-label">Enter Keyword</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="keyword" placeholder="Member Id,Email id,Religion Name etc.">
                                            </div>
                                        </div>
                                        <div class="mb-3 text-center">
                                            <button type="submit" id="submit" name="submit" class="btn btnPrimary">SEARCH</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- /.Keyword Search Card -->
                        
                    </div>
                    <!-- /. Tab Pan -->
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
        var isMobileViewport = window.matchMedia('(max-width: 991.98px)').matches;
        for (var selector in config) {
            if (isMobileViewport) {
                $(selector).not('#advancesearch select[multiple]').chosen(config[selector]);
            } else {
                $(selector).chosen(config[selector]);
            }
        }
    </script>
    <!-- /. Chosen js -->

    <script>
        $(document).ready(function() {
            //quick search
            $('#Quicksearch').submit(function(e) {
                e.preventDefault(); 
                var formData = $(this).serialize(); 
                $.ajax({
                    type: 'POST',
                    url: "{{ route('user.searchResult') }}",
                    data: {
                            formData,
                        _token: '{{csrf_token()}}'
                    },
                    success: function(result) {
                        console.log($('#result').html(result));
                        $('#result').html(result);
                        var redirectUrl = "{{ route('user.searchResultView') }}";
                        window.location.href = redirectUrl;
                        },
                        error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });
           
            //advance serach
            $('#advancesearch').submit(function(e) {
                e.preventDefault();
                var $form = $(this);
                $form.find('select').each(function() {
                    if ($(this).data('chosen')) {
                        $(this).trigger('chosen:updated');
                    }
                });
                var formData = $form.serialize(); 
                $.ajax({
                    type: 'POST',
                    url: "{{ route('user.searchResult') }}",
                    data: {
                            formData,
                        _token: '{{csrf_token()}}'
                    },
                    success: function(result) {
                        console.log($('#result').html(result));
                        $('#result').html(result);
                        var redirectUrl = "{{ route('user.searchResultView') }}";
                        window.location.href = redirectUrl;
                        },
                        error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });

            $('#locationSearch').submit(function(e) {
                e.preventDefault(); 
                
                var formData = $(this).serialize(); 
                $.ajax({
                    type: 'POST',
                    url: "{{ route('user.searchResult') }}",
                    data: {
                            formData,
                        _token: '{{csrf_token()}}'
                    },
                    success: function(result) {
                        console.log($('#result').html(result));
                        $('#result').html(result);
                        var redirectUrl = "{{ route('user.searchResultView') }}";
                        window.location.href = redirectUrl;
                        },
                        error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });

            $('#occupationSearch').submit(function(e) {
                e.preventDefault(); 
                
                var formData = $(this).serialize(); 
                $.ajax({
                    type: 'POST',
                    url: "{{ route('user.searchResult') }}",
                    data: {
                            formData,
                        _token: '{{csrf_token()}}'
                    },
                    success: function(result) {
                        console.log($('#result').html(result));
                        $('#result').html(result);
                        var redirectUrl = "{{ route('user.searchResultView') }}";
                        window.location.href = redirectUrl;
                        },
                        error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });

            //memberid serach
            $('#Memberidsearch').submit(function(e) {
                e.preventDefault(); 
                var formData = $(this).serialize(); 

                $.ajax({
                    type: 'POST',
                    url: "{{ route('user.searchResult') }}",
                    data: {
                            formData,
                        _token: '{{csrf_token()}}'
                    },
                    success: function(result) {
                        console.log($('#result').html(result));
                        $('#result').html(result);
                        var redirectUrl = "{{ route('user.searchResultView') }}";
                        window.location.href = redirectUrl;
                        },
                        error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });

            // Keyword Search
            $('#keywordsearch').submit(function(e) {
                e.preventDefault(); 
                var formData = $(this).serialize(); 

                $.ajax({
                    type: 'POST',
                    url: "{{ route('user.searchResult') }}",
                    data: {
                            formData,
                        _token: '{{csrf_token()}}'
                    },
                    success: function(result) {
                        console.log($('#result').html(result));
                        $('#result').html(result);
                        var redirectUrl = "{{ route('user.searchResultView') }}";
                        window.location.href = redirectUrl;
                        },
                        error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {

            $('#ageToSelect').change(function () {
                var selectedAgeTo = parseInt($(this).val());
                $('#ageFromSelect option').each(function () {
                    var ageValue = parseInt($(this).val());
                    if (ageValue <= selectedAgeTo) {
                        $(this).prop('disabled', true);
                        var defaultSelectedValue = ageValue+1; 
                        $('#ageFromSelect').val(defaultSelectedValue);
                    }
                });
                $('#ageFromSelect').prop('disabled', false);
            });
            
            $('#ageToSelectadv').change(function () {
                var selectedAgeTo = parseInt($(this).val());
                $('#ageFromSelectadv option').each(function () {
                    var ageValue = parseInt($(this).val());
                    if (ageValue <= selectedAgeTo) {
                        $(this).prop('disabled', true);
                        var defaultSelectedValue = ageValue+1; 
                        $('#ageFromSelectadv').val(defaultSelectedValue);
                    }
                });
                $('#ageFromSelectadv').prop('disabled', false);
            });

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

            $('#part_religion').on('change', function () {
                var part_religion_id = $('#part_religion').val();
                $("#part_caste").html('');
                $.ajax({
                    url: "{{route('search.fetch.caste')}}",
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

            $('#part_religion_as').on('change', function () {
                var part_religion_id = $('#part_religion_as').val();
                $("#part_caste_as").html('');
                $.ajax({
                    url: "{{route('search.fetch.caste')}}",
                    type: "POST",
                    data: {
                        part_religion_id: part_religion_id,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (result) {
                        $.each(result.partcastie, function (key, value) {
                            console.log(value);
                            $("#part_caste_as").append('<option value="' + value.id + '">' + value.caste_name + '</option>');
                        });

                        $("#part_caste_as").chosen({
                            allow_single_deselect: true,
                            disable_search_threshold:10,
                            no_results_text:'Oops, nothing found!',
                            width :"100%"
                        });

                        $('#part_caste_as').val('').trigger('chosen:updated');
                    }
                });
            });

            $('#part_country').change(function () {
                var partcountryIds = $('#part_country').val();
                $("#part_state").html('');
                $.ajax({
                    url: "{{route('searchstate')}}",
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
                    url: "{{route('searchcity')}}",
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

            $('#part_country_location').change(function () {
                var partcountryIds = $('#part_country_location').val();
                $("#part_state_location").html('');
                $.ajax({
                    url: "{{route('searchstate')}}",
                    type: 'POST',
                    data: {
                    partcountryIds: partcountryIds,
                    _token: '{{csrf_token()}}'
                    },
                    success: function (result) {
                        $.each(result.partstates, function (key, value) {
                            $("#part_state_location").append('<option value="' + value.id + '">' + value.state_name + '</option>');
                        });
                        $("#part_state_location").chosen({
                            allow_single_deselect: true,
                            disable_search_threshold:10,
                            no_results_text:'Oops, nothing found!',
                            width :"100%"
                        });
                        $('#part_state_location').val('').trigger('chosen:updated');

                        $("#part_city_location").val('').trigger('chosen:updated');
                    }
                });
            });

            $('#part_state_location').change(function () {
                var partstateIds = $('#part_state_location').val();
                $("#part_city_location").html('');
                $.ajax({
                    url: "{{route('searchcity')}}",
                    type: 'POST',
                    data: {
                    partstateIds: partstateIds,
                    _token: '{{csrf_token()}}'
                    },
                    success: function (result) {
                        $.each(result.partcities, function (key, value) {
                            $("#part_city_location").append('<option value="' + value.id + '">' + value.city_name + '</option>');
                        });

                        $("#part_city_location").chosen({
                            allow_single_deselect: true,
                            disable_search_threshold:10,
                            no_results_text:'Oops, nothing found!',
                            width :"100%"
                        });
                        $('#part_city_location').val('').trigger('chosen:updated');
                    }
                });
            });
    
        });
    </script>
@endsection
