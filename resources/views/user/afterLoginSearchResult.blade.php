@extends('user.layouts.afterLoginLayout')


@section('pageCSS')

    <link rel="stylesheet" href="{{asset('user/css/prism.css')}}">
    <link rel="stylesheet" href="{{asset('user/css/chosen.css')}}">
    <link rel="stylesheet" href="{{asset('user/css/tel/intlTelInput.min.css')}}">
    <style>
        .fixed-bottom {
            position: fixed;
            right: 50px !important;
            bottom: 0;
            left: 0;
            z-index: 1030;
        }
    </style>
@endsection

<!-- Content Section Start -->
@section('content')
<section class="inPageHeader">
    <div class="container">
        <h2 class="text-center">Search Result</h2>
    </div>
</section>

<!-- Home Section -->
<section class="inHome mt-2">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-4">
                <h4 class="inRefineTitle d-none d-lg-block">Refine Search</h4>
                
                <?php  
                    $old = Session::get('formData');
                    $formDataArray = [];
                    parse_str($old, $formDataArray);
                    $gender = isset($formDataArray['gender']) ? $formDataArray['gender'] : null;
                    $photo = isset($formDataArray['photo']) ? $formDataArray['photo'] : null;
                ?>
                   
                <form id="searchForm" class="d-none d-lg-block">
                    <div class="card mb-3 inRefinePanel">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-8">
                                    <h5 class="mb-0">PROFILE TYPE</h5>
                                </div>
                                <div class="col-4">
                                    <a href="" class="text-decoration-none text-white">
                                        <i class="fas fa-times-circle pe-1"></i>Clear
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card-body">
                                <div class="col-12 mb-2">
                                    <label for="gender-male">
                                        <input type="radio" id="withphoto" @if($photo == "with_photo")checked @endif name="photo" value="with_photo">
                                        <span class="ps-2 align-text-bottom">With Photo</span>
                                    </label>
                                </div>
                                <div class="col-12">
                                    <label for="gender-female">
                                        <input type="radio" id="withoutphoto" @if($photo != "with_photo")checked @endif name="photo">
                                        <span class="ps-2 align-text-bottom">Does Not Matter</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3 inRefinePanel">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-8">
                                    <h5 class="mb-0">AGE</h5>
                                </div>
                                <div class="col-4">
                                    <a href="" class="text-decoration-none text-white">
                                        <i class="fas fa-times-circle pe-1"></i>Clear
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php
                                $ageto = isset($formDataArray['age_to']) ? $formDataArray['age_to'] : null;
                                if($ageto != null)
                                {
                                    $selected_a = $ageto;
                                }else{
                                    $selected_a = 18 ;
                                }
                                
                                $agefrom = isset($formDataArray['age_from']) ? $formDataArray['age_from'] : null;
                                if($agefrom != null)
                                {
                                    $selected_b = $agefrom;
                                }else{
                                    $selected_b = 30 ;
                                }
                            ?>
                            <div class="row">
                                <div class="col-5">
                                    <select name="age_to" class="form-select"  id="ageToSelect">
                                        {{-- <option value="" selected>select</option> --}}
                                        @foreach ($ages as $age)
                                        <option value="{{$age->age}}" @if(isset($selected_a)) {{ $selected_a == $age->age ? "selected" : ''}} @endif >{{$age->age}} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-2 pt-1">
                                    <h5 class="text-dark pt-2">To</h5>
                                </div>
                                <div class="col-5">
                                    <select name="age_from" class="form-select"  id="ageFromSelect">
                                        @foreach ($ages as $age)
                                        <option value="{{$age->age}}" @if(isset($selected_b)) {{ $selected_b == $age->age ? "selected" : ''}} @endif >{{$age->age}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(!isset($fieldsetting->height) || $fieldsetting->height == "Yes" )
                    <div class="card mb-3 inRefinePanel">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-8">
                                    <h5 class="mb-0">HEIGHT</h5>
                                </div>
                                <div class="col-4">
                                    <a href="" class="text-decoration-none text-white" onclick="myFunctionheight()">
                                        <i class="fas fa-times-circle pe-1"></i>Clear
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-5">
                                            <?php  $part_height = isset($formDataArray['part_height']) && !empty($formDataArray['part_height']) ? $formDataArray['part_height'] : null; ?>
                                            <select name="height_to" class="form-select" id="part_frm_height">
                                                <option value="" selected>Select</option>
                                                @foreach($heights as $height)
                                                <option value="{{$height->id}}" @if(isset($part_height)){{$part_height == $height->id ? "selected" : ''}}@endif>{{$height->height}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-2 text-center pt-2">
                                            <h4 class="fs-6">To</h4>
                                        </div>
                                        <div class="col-5">
                                            <?php  $height_from = isset($formDataArray['height_from']) && !empty($formDataArray['height_from']) ? $formDataArray['height_from'] : null; ?>
                                            <select name="height_from" class="form-select" id="part_to_height">
                                                <option value="" selected>Select</option>
                                                @foreach($heights as $height)
                                                <option value="{{$height->id}}" @if(isset($height_from)){{$height_from == $height->id ? "selected" : ''}}@endif>{{$height->height}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="card mb-3 inRefinePanel">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-8">
                                    <h5 class="mb-0">RELIGION</h5>
                                </div>
                                <div class="col-4">
                                    <a href="" class="text-decoration-none text-white" onclick="myFunctionreligion()">
                                        <i class="fas fa-times-circle pe-1"></i>Clear
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                            
                                <?php $part_religion = isset($formDataArray['part_religion']) ? $formDataArray['part_religion'] : null; ?>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <select name="part_religion[]" class="form-select chosen-select" id="part_religion" data-placeholder="Choose" multiple>
                                                @foreach($religions as $religion)
                                                <option value="{{$religion->id}}" @if(isset($part_religion)) @if(in_array($religion->id,$part_religion)) {{"selected"}}@endif @endif>{{$religion->religion_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3 inRefinePanel">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-8">
                                    <h5 class="mb-0">CASTE</h5>
                                </div>
                                <div class="col-4">
                                    <a href="" class="text-decoration-none text-white" onclick="myFunctioncaste()">
                                        <i class="fas fa-times-circle pe-1"></i>Clear
                                    </a>
                                </div>
                            </div>
                        </div>
                    
                        <div class="card-body">
                            <?php $part_caste = isset($formDataArray['part_caste']) ? $formDataArray['part_caste'] : null; ?>
                            <div class="row">
                                <div class="col-12">
                                    <select name="part_caste[]" class="form-select chosen-select" id="part_caste" data-placeholder="Choose" multiple>
                                    
                                        @foreach($casties as $caste)
                                        <option value="{{$caste->id}}" @if(isset($part_caste)) @if(in_array($caste->id,$part_caste)) {{"selected"}}@endif @endif>{{$caste->caste_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3 inRefinePanel">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-8">
                                    <h5 class="mb-0">MARITAL STATUS</h5>
                                </div>
                                <div class="col-4">
                                    <a href="" class="text-decoration-none text-white"  onclick="myFunctionmstatus()">
                                        <i class="fas fa-times-circle pe-1"></i>Clear
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <?php $m_status = isset($formDataArray['m_status']) ? $formDataArray['m_status'] : null; ?>
                            
                                <div class="col-12">
                                    <select name="m_status[]" class="form-select chosen-select" id="m_status" data-placeholder="Choose" multiple>
                                
                                        <option value="Never Married" @if(isset($m_status)) @if(in_array("Never Married",$m_status)) {{"selected"}}@endif @endif>Never Married</option>
                                        <option value="Widower" @if(isset($m_status)) @if(in_array("Widower",$m_status)){{"selected"}} @endif @endif>Widower</option>
                                        <option value="Divorced"  @if(isset($m_status)) @if(in_array("Divorced",$m_status)){{"selected"}} @endif @endif>Divorced</option>
                                        <option value="Awaiting Divorce"  @if(isset($m_status)) @if(in_array("Awaiting Divorce",$m_status)){{"selected"}} @endif @endif>Awaiting Divorce</option>
                                        <option value="Widow"  @if(isset($m_status)) @if(in_array("Widow",$m_status)){{"selected"}} @endif @endif>Widow</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3 inRefinePanel">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-8">
                                    <h5 class="mb-0">OCCUPATION</h5>
                                </div>
                                <div class="col-4">
                                    <a href="" class="text-decoration-none text-white" onclick="myFunctionoccu()">
                                        <i class="fas fa-times-circle pe-1"></i>Clear
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <?php $part_occu = isset($formDataArray['part_occu']) ? $formDataArray['part_occu'] : null; ?>
                                    <select name="part_occu[]" class="form-select chosen-select" id="part_occu" data-placeholder="Choose" multiple>
                                        @foreach($occupations as $occupation)
                                        <option value="{{$occupation->id}}" @if(isset($part_occu)) @if(in_array($occupation->id,$part_occu)) {{"selected"}}@endif @endif>{{$occupation->ocp_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3 inRefinePanel">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-8">
                                    <h5 class="mb-0">COUNTRY</h5>
                                </div>
                                <div class="col-4">
                                    <a href="" class="text-decoration-none text-white" onclick="myFunctioncountry()">
                                        <i class="fas fa-times-circle pe-1"></i>Clear
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <?php $part_country_living = isset($formDataArray['part_country_living']) ? $formDataArray['part_country_living'] : null; ?>
                                <div class="col-12">
                                    <select  name="part_country_living[]" id="part_country" class="form-select chosen-select" data-placeholder="Choose" multiple>
                                        @foreach($countries as $country)
                                        <option value="{{$country->id}}" @if(isset($part_country_living)) @if(in_array($country->id,$part_country_living)) {{"selected"}}@endif @endif>{{$country->country_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3 inRefinePanel">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-8">
                                    <h5 class="mb-0">EDUCATION</h5>
                                </div>
                                <div class="col-4">
                                    <a href="" class="text-decoration-none text-white" onclick="myFunctionedudetails()">
                                        <i class="fas fa-times-circle pe-1"></i>Clear
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <?php $part_edu = isset($formDataArray['part_edu']) ? $formDataArray['part_edu'] : null; ?>
                                <div class="col-12">
                                    <select name="part_edu[]" class="form-select chosen-select" id="part_edu" data-placeholder="Choose" multiple>
                                        @foreach($edu_details as $edu_detail)
                                        <option value="{{$edu_detail->id}}" @if(isset($part_edu)) @if(in_array($edu_detail->id,$part_edu)) {{"selected"}}@endif @endif>{{$edu_detail->edu_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
		    <div class="card mb-3 inRefinePanel">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-8">
                                    <h5 class="mb-0">BIRTHSTAR</h5>
                                </div>
                                <div class="col-4">
                                    <a href="" class="text-decoration-none text-white" onclick="myFunctionedudetails()">
                                        <i class="fas fa-times-circle pe-1"></i>Clear
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <?php $part_edu = isset($formDataArray['part_edu']) ? $formDataArray['part_edu'] : null; ?>
                                <div class="col-12">
                                    <select name="part_edu[]" class="form-select chosen-select" id="part_edu" data-placeholder="Choose" multiple>
                                        @foreach($edu_details as $edu_detail)
                                        <option value="{{$edu_detail->id}}" @if(isset($part_edu)) @if(in_array($edu_detail->id,$part_edu)) {{"selected"}}@endif @endif>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                
                <button class="btn d-block d-lg-none btnPrimary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                  <i class="fas fa-filter"></i> REFINE SEARCH
                </button>
                <div class="offcanvas offcanvas-start d-block d-lg-none" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel" style="overflow-y: scroll;">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Refine Search</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <form id="searchForm1" class="">
                            <div class="card mb-3 inRefinePanel">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-8">
                                            <h5 class="mb-0">PROFILE TYPE</h5>
                                        </div>
                                        <div class="col-4">
                                            <a href="" class="text-decoration-none text-white">
                                                <i class="fas fa-times-circle pe-1"></i>Clear
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="card-body">
                                        <div class="col-12 mb-2">
                                            <label for="gender-male">
                                                <input type="radio" id="withphoto" @if($photo == "with_photo")checked @endif name="photo" value="with_photo">
                                                <span class="ps-2 align-text-bottom">With Photo</span>
                                            </label>
                                        </div>
                                        <div class="col-12">
                                            <label for="gender-female">
                                                <input type="radio" id="withoutphoto" @if($photo != "with_photo")checked @endif name="photo">
                                                <span class="ps-2 align-text-bottom">Does Not Matter</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-3 inRefinePanel">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-8">
                                            <h5 class="mb-0">AGE</h5>
                                        </div>
                                        <div class="col-4">
                                            <a href="" class="text-decoration-none text-white">
                                                <i class="fas fa-times-circle pe-1"></i>Clear
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <?php
                                        $ageto = isset($formDataArray['age_to']) ? $formDataArray['age_to'] : null;
                                        if($ageto != null)
                                        {
                                            $selected_a = $ageto;
                                        }else{
                                            $selected_a = 18 ;
                                        }
                                        
                                        $agefrom = isset($formDataArray['age_from']) ? $formDataArray['age_from'] : null;
                                        if($agefrom != null)
                                        {
                                            $selected_b = $agefrom;
                                        }else{
                                            $selected_b = 30 ;
                                        }
                                    ?>
                                    <div class="row">
                                        <div class="col-5">
                                            <select name="age_to" class="form-select"  id="ageToSelect">
                                                {{-- <option value="" selected>select</option> --}}
                                                @foreach ($ages as $age)
                                                <option value="{{$age->age}}" @if(isset($selected_a)) {{ $selected_a == $age->age ? "selected" : ''}} @endif >{{$age->age}} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-2 pt-1">
                                            <h5 class="text-dark pt-2">To</h5>
                                        </div>
                                        <div class="col-5">
                                            <select name="age_from" class="form-select"  id="ageFromSelect">
                                                @foreach ($ages as $age)
                                                <option value="{{$age->age}}" @if(isset($selected_b)) {{ $selected_b == $age->age ? "selected" : ''}} @endif >{{$age->age}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if(!isset($fieldsetting->height) || $fieldsetting->height == "Yes" )
                            <div class="card mb-3 inRefinePanel">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-8">
                                            <h5 class="mb-0">HEIGHT</h5>
                                        </div>
                                        <div class="col-4">
                                            <a href="" class="text-decoration-none text-white" onclick="myFunctionheight()">
                                                <i class="fas fa-times-circle pe-1"></i>Clear
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-5">
                                                    <?php  $part_height = isset($formDataArray['part_height']) && !empty($formDataArray['part_height']) ? $formDataArray['part_height'] : null; ?>
                                                    <select name="height_to" class="form-select" id="part_frm_height">
                                                        <option value="" selected>Select</option>
                                                        @foreach($heights as $height)
                                                        <option value="{{$height->id}}" @if(isset($part_height)){{$part_height == $height->id ? "selected" : ''}}@endif>{{$height->height}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-2 text-center pt-2">
                                                    <h4 class="fs-6">To</h4>
                                                </div>
                                                <div class="col-5">
                                                    <?php  $height_from = isset($formDataArray['height_from']) && !empty($formDataArray['height_from']) ? $formDataArray['height_from'] : null; ?>
                                                    <select name="height_from" class="form-select" id="part_to_height">
                                                        <option value="" selected>Select</option>
                                                        @foreach($heights as $height)
                                                        <option value="{{$height->id}}" @if(isset($height_from)){{$height_from == $height->id ? "selected" : ''}}@endif>{{$height->height}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="card mb-3 inRefinePanel">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-8">
                                            <h5 class="mb-0">RELIGION</h5>
                                        </div>
                                        <div class="col-4">
                                            <a href="" class="text-decoration-none text-white" onclick="myFunctionreligion()">
                                                <i class="fas fa-times-circle pe-1"></i>Clear
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                    
                                        <?php $part_religion = isset($formDataArray['part_religion']) ? $formDataArray['part_religion'] : null; ?>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <select name="part_religion[]" class="form-select chosen-select" id="part_religion" data-placeholder="Choose" multiple>
                                                        @foreach($religions as $religion)
                                                        <option value="{{$religion->id}}" @if(isset($part_religion)) @if(in_array($religion->id,$part_religion)) {{"selected"}}@endif @endif>{{$religion->religion_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-3 inRefinePanel">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-8">
                                            <h5 class="mb-0">CASTE</h5>
                                        </div>
                                        <div class="col-4">
                                            <a href="" class="text-decoration-none text-white" onclick="myFunctioncaste()">
                                                <i class="fas fa-times-circle pe-1"></i>Clear
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="card-body">
                                    <?php $part_caste = isset($formDataArray['part_caste']) ? $formDataArray['part_caste'] : null; ?>
                                    <div class="row">
                                        <div class="col-12">
                                            <select name="part_caste[]" class="form-select chosen-select" id="part_caste" data-placeholder="Choose" multiple>
                                            
                                                @foreach($casties as $caste)
                                                <option value="{{$caste->id}}" @if(isset($part_caste)) @if(in_array($caste->id,$part_caste)) {{"selected"}}@endif @endif>{{$caste->caste_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-3 inRefinePanel">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-8">
                                            <h5 class="mb-0">MARITAL STATUS</h5>
                                        </div>
                                        <div class="col-4">
                                            <a href="" class="text-decoration-none text-white"  onclick="myFunctionmstatus()">
                                                <i class="fas fa-times-circle pe-1"></i>Clear
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <?php $m_status = isset($formDataArray['m_status']) ? $formDataArray['m_status'] : null; ?>
                                    
                                        <div class="col-12">
                                            <select name="m_status[]" class="form-select chosen-select" id="m_status" data-placeholder="Choose" multiple>
                                        
                                                <option value="Never Married" @if(isset($m_status)) @if(in_array("Never Married",$m_status)) {{"selected"}}@endif @endif>Never Married</option>
                                                <option value="Widower" @if(isset($m_status)) @if(in_array("Widower",$m_status)){{"selected"}} @endif @endif>Widower</option>
                                                <option value="Divorced"  @if(isset($m_status)) @if(in_array("Divorced",$m_status)){{"selected"}} @endif @endif>Divorced</option>
                                                <option value="Awaiting Divorce"  @if(isset($m_status)) @if(in_array("Awaiting Divorce",$m_status)){{"selected"}} @endif @endif>Awaiting Divorce</option>
                                                <option value="Widow"  @if(isset($m_status)) @if(in_array("Widow",$m_status)){{"selected"}} @endif @endif>Widow</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-3 inRefinePanel">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-8">
                                            <h5 class="mb-0">OCCUPATION</h5>
                                        </div>
                                        <div class="col-4">
                                            <a href="" class="text-decoration-none text-white" onclick="myFunctionoccu()">
                                                <i class="fas fa-times-circle pe-1"></i>Clear
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <?php $part_occu = isset($formDataArray['part_occu']) ? $formDataArray['part_occu'] : null; ?>
                                            <select name="part_occu[]" class="form-select chosen-select" id="part_occu" data-placeholder="Choose" multiple>
                                                @foreach($occupations as $occupation)
                                                <option value="{{$occupation->id}}" @if(isset($part_occu)) @if(in_array($occupation->id,$part_occu)) {{"selected"}}@endif @endif>{{$occupation->ocp_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-3 inRefinePanel">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-8">
                                            <h5 class="mb-0">COUNTRY</h5>
                                        </div>
                                        <div class="col-4">
                                            <a href="" class="text-decoration-none text-white" onclick="myFunctioncountry()">
                                                <i class="fas fa-times-circle pe-1"></i>Clear
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <?php $part_country_living = isset($formDataArray['part_country_living']) ? $formDataArray['part_country_living'] : null; ?>
                                        <div class="col-12">
                                            <select  name="part_country_living[]" id="part_country" class="form-select chosen-select" data-placeholder="Choose" multiple>
                                                @foreach($countries as $country)
                                                <option value="{{$country->id}}" @if(isset($part_country_living)) @if(in_array($country->id,$part_country_living)) {{"selected"}}@endif @endif>{{$country->country_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-3 inRefinePanel">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-8">
                                            <h5 class="mb-0">EDUCATION</h5>
                                        </div>
                                        <div class="col-4">
                                            <a href="" class="text-decoration-none text-white" onclick="myFunctionedudetails()">
                                                <i class="fas fa-times-circle pe-1"></i>Clear
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <?php $part_edu = isset($formDataArray['part_edu']) ? $formDataArray['part_edu'] : null; ?>
                                        <div class="col-12">
                                            <select name="part_edu[]" class="form-select chosen-select" id="part_edu" data-placeholder="Choose" multiple>
                                                @foreach($edu_details as $edu_detail)
                                                <option value="{{$edu_detail->id}}" @if(isset($part_edu)) @if(in_array($edu_detail->id,$part_edu)) {{"selected"}}@endif @endif>{{$edu_detail->edu_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div id="pagination-content" class="col-lg-9 col-md-8 inMT-35">
                @foreach($result as $data)
                    @include('user.layouts.profileDetailsCard')
                @endforeach
                @if(isset($result))
                <div class="d-flex justify-content-center" id="pagination-links">
                    {!! $result->links() !!}
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="toast-container position-fixed position-static bottom-0 end-0 p-3 mb-5 mb-sm-0">
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
                    <?php $cansendinterest = ""; ?>
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

    @include('user.layouts.resultActionBtnJs')
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
    <script>
    function loadPage(pageUrl) {
        var searchData = $('#searchForm').serialize();
        $.ajax({
            url: '{{ route('user.searchData') }}',
            type: "GET",
            data: {
            searchData,
        },
            success: function(response) {
                $.ajax({
                    url: pageUrl,
                    type: "GET",
                    data: {
                _token: '{{csrf_token()}}'
                },
                    success: function(response) {
                        $('#pagination-content').html($(response).find('#pagination-content').html());
                        $('#pagination-links').html($(response).find('#pagination-links').html());
                        $('html, body').animate({ scrollTop: 0 }, 'slow'); // Scroll to top
                    },
                });
            },
            error: function(xhr) {
                console.log(xhr.responseText); // Handle error
            }
        });
    }
    $('#searchForm').change(function() {
        var pageUrl = $('#pagination-links a').attr('href');
        loadPage();  
    });

    function loadPage1(pageUrl) {
        var searchData = $('#searchForm1').serialize();
        $.ajax({
            url: '{{ route('user.searchData') }}',
            type: "GET",
            data: {
            searchData,
        },
            success: function(response) {
                $.ajax({
                    url: pageUrl,
                    type: "GET",
                    data: {
                _token: '{{csrf_token()}}'
                },
                    success: function(response) {
                        $('#pagination-content').html($(response).find('#pagination-content').html());
                        $('#pagination-links').html($(response).find('#pagination-links').html());
                        $('html, body').animate({ scrollTop: 0 }, 'slow'); // Scroll to top
                    },
                });
            },
            error: function(xhr) {
                console.log(xhr.responseText); // Handle error
            }
        });
    }
    $('#searchForm1').change(function() {
        var pageUrl = $('#pagination-links a').attr('href');
        loadPage1();  
    });


    function myFunctionheight() {
        $('select[name="height_to"]').find(":selected").attr('selected', false);
        $('#height_to').val('').trigger('chosen:updated');
        $('select[name="height_from"]').find(":selected").attr('selected', false);
        $('#height_from').val('').trigger('chosen:updated');
        var pageUrl = $('#pagination-links a').attr('href');
        loadPage();
        loadPage1();
    }
    function myFunctionreligion() {
        $('select[name="part_religion"]').find(":selected").attr('selected', false);
        $('#part_religion').val('').trigger('chosen:updated');
        var pageUrl = $('#pagination-links a').attr('href');
        loadPage();
        loadPage1();
    }
    function myFunctioncaste() {
        $('select[name="part_caste"]').find(":selected").attr('selected', false);
        $('#part_caste').val('').trigger('chosen:updated');
        var pageUrl = $('#pagination-links a').attr('href');
        loadPage();
        loadPage1();

    }
    function myFunctionoccu() {
       $('select[name="part_occu"]').find(":selected").attr('selected', false);
        $('#part_occu').val('').trigger('chosen:updated');
        var pageUrl = $('#pagination-links a').attr('href');
        loadPage(pageUrl);
        loadPage1(pageUrl);
       
    }
    function myFunctionmstatus() {
       $('select[name="m_status"]').find(":selected").attr('selected', false);
        $('#m_status').val('').trigger('chosen:updated');
        var pageUrl = $('#pagination-links a').attr('href');
        loadPage(pageUrl);
        loadPage1(pageUrl);
       
    }
    function myFunctioncountry() {
       $('select[name="part_country_living"]').find(":selected").attr('selected', false);
        $('#part_country').val('').trigger('chosen:updated');
        var pageUrl = $('#pagination-links a').attr('href');
        loadPage(pageUrl);
        loadPage1(pageUrl);
       
    }
    function myFunctionedudetails() {
       $('select[name="part_edu"]').find(":selected").attr('selected', false);
        $('#part_edu').val('').trigger('chosen:updated');
        var pageUrl = $('#pagination-links a').attr('href');
        loadPage(pageUrl);
        loadPage1(pageUrl);
    }

    $(document).on('click', '#pagination-links a', function(event) {
        event.preventDefault();
        var pageUrl = $(this).attr('href');
        loadPage(pageUrl);
        loadPage1(pageUrl);
    });	
    
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
</script>  
@endsection
