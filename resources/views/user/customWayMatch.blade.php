@extends('user.layouts.afterLoginLayout')

@section('pageCSS')
    <!-- Chosen css -->
    <link rel="stylesheet" href="{{ asset('user/css/prism.css') }} ">
    <link rel="stylesheet" href="{{ asset('user/css/chosen.css') }} ">
    <!-- /. Chosen css -->
@endsection

<!-- Content Section Start -->
@section('content')
<!-- Page Header -->
<section class="inPageHeader">
    <div class="container">
        <h2 class="text-center">Custom Way Matching Profile</h2>
    </div>
</section>
<!-- /. Page Header -->

<section class="inHome mt-5">
    <div class="container">
        <div class="row">
            @include('user.layouts.matchLeftPanel')
            <div class="col-lg-9 col-md-8">
                <div class="row">
                    <div class="col-xl-12 text-center">
                        <button class="btn btnPrimary mb-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                            Set Match Criteria
                        </button>
                    </div>
                    <div class="col-xl-12 mb-4">
                        <div class="collapse" id="collapseExample">
                            <div class="card card-body inBorderColor1">
                                <form action="{{ route('user.customwayPost')}} " method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-xl-6 mb-3 chosen-style-3">
                                            <label class="label-1">Looking for</label>
                                            <?php if(isset($matchis->looking_for)){{$get_looking = explode(",",$matchis->looking_for);}}?>
                                            <select name="looking_for[]" class="form-select chosen-select" id="floatingSelect" data-placeholder="Select" multiple>
                                                <option value="Never Married" @if(isset($matchis->looking_for)) @if(in_array("Never Married",$get_looking)) {{"selected"}}@endif @endif>Never Married</option>
                                                <option value="Widower" @if(isset($matchis->looking_for)) @if(in_array("Widower",$get_looking)){{"selected"}} @endif @endif>Widower</option>
                                                <option value="Divorced"  @if(isset($matchis->looking_for)) @if(in_array("Divorced",$get_looking)){{"selected"}} @endif @endif>Divorced</option>
                                                <option value="Awaiting Divorce" @if(isset($matchis->looking_for)) @if(in_array("Awaiting Divorce",$get_looking)){{"selected"}} @endif @endif>Awaiting Divorce</option>
                                                <option value="Widow"  @if(isset($matchis->looking_for)) @if(in_array("Widow",$get_looking)){{"selected"}} @endif @endif>Widow</option>
                                            </select>
                                        </div>
                                        <div class="col-xl-6 mb-3 chosen-style-3">
                                            <label class="label-1">Mother Tongue</label>
                                            <?php if(isset($matchis->part_mtongue)){$get_mother_tongue = explode(",",$matchis->part_mtongue);}?>
                                            <select name="part_mtongue[]" class="form-select chosen-select" id="floatingSelect" data-placeholder="Select" multiple>
                                                @foreach ($mothertongues as $mothertongue)
                                                <option value="{{$mothertongue->id}}" @if(isset($matchis->part_mtongue)) @if(in_array($mothertongue->id,$get_mother_tongue)) {{"selected"}} @endif @endif>{{$mothertongue->mtongue_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6 mb-3 chosen-style-3">
                                            <label class="label-1">Country</label>
                                            <?php if(isset($matchis->part_country_living)){$get_part_country_living = explode(",",$matchis->part_country_living);}?>
                                            <select  name="part_country_living[]" id="part_country" class="form-select chosen-select" data-placeholder="Select" multiple>
                                                @foreach($countries as $country)
                                                <option value="{{$country->id}}" @if(isset($matchis->part_country_living)) @if(in_array($country->id,$get_part_country_living)) {{"selected"}}@endif @endif>{{$country->country_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-xl-6 mb-3 chosen-style-3">
                                            <label class="label-1">Religion</label>
                                            <?php if(isset($matchis->part_religion)){$get_part_religion = explode(",",$matchis->part_religion);}?>
                                            <select name="part_religion[]" id="part_religion" class="form-select chosen-select" data-placeholder="Select" multiple>
                                                @foreach($religions as $religion)
                                                <option value="{{$religion->id}}" @if(isset($matchis->part_religion)) @if(in_array($religion->id,$get_part_religion)) {{"selected"}}@endif @endif>{{$religion->religion_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6 mb-3 chosen-style-3">
                                            <label class="label-1">Caste</label>
                                            <?php if(isset($matchis->part_caste)){$get_part_caste = explode(",",$matchis->part_caste);}?>
                                            
                                            <select name="part_caste[]" class="form-select chosen-select" data-placeholder="Select" id="part_caste"  multiple>
                                                
                                                @foreach($castes as $caste)
                                                <option value="{{$caste->id}}" @if(isset($matchis->part_caste)) @if(in_array($caste->id,$get_part_caste)) {{"selected"}}@endif @endif>{{$caste->caste_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-xl-6 mb-3 chosen-style-3">
                                            <label class="label-1">Education</label>
                                            <?php if(isset($matchis->part_edu)){$get_part_edu = explode(",",$matchis->part_edu);}?>
                                            <select name="part_edu[]" class="form-select chosen-select" id="floatingSelect" data-placeholder="Select" multiple>
                                                
                                                @foreach($edu_details as $edu_detail)
                                                <option value="{{$edu_detail->id}}" @if(isset($matchis->part_edu)) @if(in_array($edu_detail->id,$get_part_edu)) {{"selected"}}@endif @endif>{{$edu_detail->edu_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6 mb-3">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label class="label-1">Age</label>
                                                </div>
                                                <?php 
                                                   $age_from = "1";
                                                   $age_to = "13";
                                                ?>
                                                <div class="col-5">
                                                    <select name="part_frm_age" class="form-select" id="part_frm_age" >
                                                        <option value="" selected>select</option>
                                                        @foreach ($ages as $age)
                                                        <option value="{{$age->id}}" @if(isset($matchis->part_frm_age)){{$matchis->part_frm_age == $age->id ? "selected" : ''}}@else{{$age_from == $age->id ? "selected" : ''}}@endif>{{$age->age}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-2 text-center">
                                                    <h6 class="pt-2">To</h6>
                                                </div>
                                                <div class="col-5">
                                                    <select name="part_to_age" class="form-select" id="part_to_age" >
                                                        <option value="" selected>select</option>
                                                        @foreach ($ages as $age)
                                                        <option value="{{$age->id}}" @if(isset($matchis->part_to_age)){{$matchis->part_to_age == $age->id ? "selected" : ''}}@else{{$age_to == $age->id ? "selected" : ''}}@endif>{{$age->age}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 mb-3">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label class="label-1">Height</label>
                                                </div>
                                                <div class="col-5">
                                                    <select name="part_height" class="form-select" id="part_frm_height" >
                                                        <option value="" selected>Select</option>
                                                        @foreach($heights as $height)
                                                        <option value="{{$height->id}}" @if(isset($matchis->part_height)){{$matchis->part_height == $height->id ? "selected" : ''}}@endif>{{$height->height}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-2 text-center">
                                                    <h6 class="pt-2">To</h6>
                                                </div>
                                                <div class="col-5">
                                                    <select name="part_height_to" class="form-select" id="part_to_height">
                                                        <option value="" selected>Select</option>
                                                        @foreach($heights as $height)
                                                        <option value="{{$height->id}}" @if(isset($matchis->part_height_to)){{$matchis->part_height_to == $height->id ? "selected" : ''}}@endif>{{$height->height}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-xl-12 mb-3 text-center">
                                            <input type="submit" value="SUBMIT" class="btn btnSecondary">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @if(count($customway))
                    @foreach ($customway as $data)
                        @include('user.layouts.profileDetailsCard')
                    @endforeach
                    <div class="d-flex justify-content-center" id="pagination-links">
                        {!! $customway->links() !!}
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

@endsection

@section('pageJS')

    @include('user.layouts.resultActionBtnJs')

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

    <script>
        $(document).ready(function () {

            //part religion
            $('#part_religion').on('change', function () {
                var part_religion_id = $('#part_religion').val();
                $("#part_caste").html('');
                $.ajax({
                    url: "{{ route('profilepartcaste') }}",
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