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