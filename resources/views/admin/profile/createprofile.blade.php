@extends('admin.layouts.afterLoginLayout')

@section('title') Admin - Register Profile @endsection

@section('pageCSS') 
    <link rel="stylesheet" href="{{ asset('admin/css/prism.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/chosen.css') }}">
@endsection

@section('content')

<div class="container pt-3">
    <div class="row mt-3">
        <div class="col-xl-4">
            <h3 class="colorSecondary inATitle1 mt-2">Add Profile</h3>
        </div>
        <div class="col-xl-8 text-end inAProfileActionBtn inMemberTopPanel">
            <a href="{{route('admin.membersAll')}}" class="btn btnPrimary d-inline-block ps-3 pe-3">
                <i class="fas fa-list pe-1"></i>All Member
            </a>
        </div>  
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mt-4 inEditCard">
                    <div class="card-header">
                        <h4>Add New Profile</h4>
                    </div>
                        <div class="card-body">
                            <form method="POST" id="register_form" action="{{route('admin.store-profile') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 mb-3">
                                        <label class="label-1">Marital Status</label>
                                        <select name="m_status" class="form-select" id="no_mstatus" required>
                                            <option value="" selected>select</option>
                                            <option value="Never Married" @selected(old('m_status') =="Never Married") >Never Married</option>
                                            <option value="Widower" @selected(old('m_status') == "Widower")>Widower</option>
                                            <option value="Divorced" @selected(old('m_status') == "Divorced")>Divorced</option>
                                            <option value="Awaiting Divorce" @selected(old('m_status') == "Awaiting Divorce")>Awaiting Divorce</option>
                                            <option value="Widow" @selected(old('m_status') == "Widow")>Widow</option>
                                        </select>
                                        @error('m_status')
                                        <div style="color:red">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-xl-6 col-lg-6 mb-3">
                                        <label class="label-1">Profile Created By</label>
                                        <select name="profileby" class="form-select" id="floatingSelect" required>
                                            <option value="" selected>select</option>
                                            @foreach ($profiles as $profile)
                                            <option value="{{$profile->profile_by}}" @if(isset($register)){{$register->profileby == $profile->profile_by ? "selected" : ''}}@else @selected(old('profileby') == $profile->profile_by)@endif>{{$profile->profile_by}}</option>
                                            @endforeach
                                        </select>
                                        @error('profileby')
                                        <div style="color:red">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-xl-6 col-lg-6 mb-3">
                                        <label class="label-1">Gender</label>
                                        <select name="gender" class="form-select" id="floatingSelect" required>
                                            <option value="" selected>select</option>
                                            <option value="Male" @if(isset($register)) {{$register->gender == "Male" ? "selected" : ''}}@else @selected(old('gender') == "Male")@endif>Male</option>
                                            <option value="Female" @if(isset($register)) {{$register->gender == "Female" ? "selected" : ''}}@else @selected(old('gender') == "Female")@endif>Female</option>
                                        </select>
                                        @error('gender')
                                        <div style="color:red">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-xl-6 col-lg-6 mb-3">
                                        <div class="row">
                                            <div class="col-6">
                                                <label class="label-1">First Name</label>
                                                <input type="text" name="firstname" value="@if(isset($register->firstname)){{$register->firstname}}@else{{old('firstname')}}@endif" class="form-control" placeholder="Enter First Name" required>
                                                @error('firstname')
                                                <div style="color:red">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-6">
                                                <label class="label-1">Last Name</label>
                                                <input type="text" name="lastname" value="@if(isset($register->lastname)){{$register->lastname}}@else{{old('lastname')}}@endif" class="form-control" placeholder="Enter Last Name" required>
                                                @error('lastname')
                                                <div style="color:red">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                       
                                    </div>
                                    <div class="col-xl-6 col-lg-6 mb-3">
                                        <label class="label-1">Date of Birth</label>
                                        <div class="row">
                                            <div class="col-4">
                                                <select name="day" id="day" class="form-select" onchange="setDays(month, this, year)" required>
                                                    <option value="01" @selected(old('day') == "01")>01</option>
                                                    <option value="02" @selected(old('day') == "02")>02</option>
                                                    <option value="03" @selected(old('day') == "03")>03</option>
                                                    <option value="04" @selected(old('day') == "04")>04</option>
                                                    <option value="05" @selected(old('day') == "05")>05</option>
                                                    <option value="06" @selected(old('day') == "06")>06</option>
                                                    <option value="07" @selected(old('day') == "07")>07</option>
                                                    <option value="08" @selected(old('day') == "08")>08</option>
                                                    <option value="09" @selected(old('day') == "09")>09</option>
                                                    <option value="10" @selected(old('day') == "10")>10</option>
                                                    <option value="11" @selected(old('day') == "11")>11</option>
                                                    <option value="12" @selected(old('day') == "12")>12</option>
                                                    <option value="13" @selected(old('day') == "13")>13</option>
                                                    <option value="14" @selected(old('day') == "14")>14</option>
                                                    <option value="15" @selected(old('day') == "15")>15</option>
                                                    <option value="16" @selected(old('day') == "16")>16</option>
                                                    <option value="17" @selected(old('day') == "17")>17</option>
                                                    <option value="18" @selected(old('day') == "18")>18</option>
                                                    <option value="19" @selected(old('day') == "19")>19</option>
                                                    <option value="20" @selected(old('day') == "20")>20</option>
                                                    <option value="21" @selected(old('day') == "21")>21</option>
                                                    <option value="22" @selected(old('day') == "22")>22</option>
                                                    <option value="23" @selected(old('day') == "23")>23</option>
                                                    <option value="24" @selected(old('day') == "24")>24</option>
                                                    <option value="25" @selected(old('day') == "25")>25</option>
                                                    <option value="26" @selected(old('day') == "26")>26</option>
                                                    <option value="27" @selected(old('day') == "27")>27</option>
                                                    <option value="28" @selected(old('day') == "28")>28</option>
                                                    <option value="29" @selected(old('day') == "29")>29</option>
                                                    <option value="30" @selected(old('day') == "30")>30</option>
                                                    <option value="31" @selected(old('day') == "31")>31</option>
                                                </select>
                                                @error('day')
                                                <div style="color:red">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-3">
                                                <select name="month" id="month" class="form-select" onchange="setDays(this, day, year)" required>
                                                    <option value="">Month</option>
                                                    <option value="01" @selected(old('month') == "01")>Jan</option>
                                                    <option value="02" @selected(old('month') == "02")>Feb</option>
                                                    <option value="03" @selected(old('month') == "03")>Mar</option>
                                                    <option value="04" @selected(old('month') == "04")>Apr</option>
                                                    <option value="05" @selected(old('month') == "05")>May</option>
                                                    <option value="06" @selected(old('month') == "06")>Jun</option>
                                                    <option value="07" @selected(old('month') == "07")>Jul</option>
                                                    <option value="08" @selected(old('month') == "08")>Aug</option>
                                                    <option value="09" @selected(old('month') == "09")>Sep</option>
                                                    <option value="10" @selected(old('month') == "10")>Oct</option>
                                                    <option value="11" @selected(old('month') == "11")>Nov</option>
                                                    <option value="12" @selected(old('month') == "12")>Dec</option>
                                                </select>
                                                @error('month')
                                                <div style="color:red">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-5">
                                                <select name="year" id="year" class="form-select" onchange="setDays(month, day, this)" required>
                                                    <?php
                                                        $siteconfig = DB::table('site_configs')->first('birthyear');
                                                        if(isset($siteconfig))
                                                        {
                                                            $year = $siteconfig->birthyear;
                                                        }else{
                                                            $year = 0;
                                                        }
                                                        for ($x = $year; $x >= 1930; $x--) { ?>
                                                        <option value='<?php echo $x; ?>' @selected(old('year') == $x)>
                                                            <?php echo $x; ?>
                                                        </option>
                                                        <?php } ?>
                                                </select>
                                                @error('year')
                                                <div style="color:red">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>                           
                                    <div class="col-xl-6 col-lg-6 mb-3 chosen-style-1">
                                        <label class="label-1">Country</label>
                                        <select name="country_id" class="form-select chosen-select" data-placeholder="Choose" id="floatingSelect" required>
                                            <option value="" selected>Select</option>
                                            @foreach($countries as $country)
                                            <option value="{{$country->id}}" @if(isset($register)){{$register->country_id == $country->id ? "selected" : ''}}@else @selected(old('country_id') == $country->id)@endif>{{$country->country_name}}</option>
                                            @endforeach
                                        </select>
                                        @error('country_id')
                                        <div style="color:red">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-xl-6 col-lg-6 mb-3 chosen-style-1">
                                        <label class="label-1">Religion</label>
                                        <select name="religion" class="form-select chosen-select" data-placeholder="Choose" id="religion-dropdown" required>
                                            <option value="" selected>select</option>
                                            @foreach($religions as $religion)
                                            <option value="{{$religion->id}}" @if(isset($register)){{$register->religion == $religion->id ? "selected" : ''}}@else @selected(old('religion') == $religion->id)@endif>{{$religion->religion_name}}</option>
                                            @endforeach
                                        </select>
                                        @error('religion')
                                        <div style="color:red">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-xl-6 col-lg-6 mb-3 chosen-style-1">
                                        <label class="label-1">Caste</label>
                                        <select name="caste" class="form-select chosen-select" data-placeholder="Select religion first" id="caste-dropdown" required>
                                        </select>
                                        @error('caste')
                                        <div style="color:red">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-xl-6 col-lg-6 mb-3">
                                        <div class="row">
                                            <div class="col-4 chosen-style-1">
                                                <label class="label-1">Mobile Code</label>
                                                <select name="mobile_code" class="form-select chosen-select" data-placeholder="Choose" id="mobile_code" required>
                                                    <?php 
                                                        if(isset($register->mobile_code))
                                                        {
                                                            $mobile_code= $register->mobile_code;
                                                        }else{
                                                            $mobile_code = 91;
                                                        }
                                                    ?>
                                                    <option value="" selected>select</option>
                                                    @foreach ($country_code as $code)
                                                    <option value="{{$code->phonecode}}" @if(isset($mobile_code)){{$mobile_code == $code->phonecode ? "selected" : ''}}@else @selected(old('mobile_code') == $code->id)@endif>{{$code->phonecode}}</option>
                                                    @endforeach
                                                </select>
                                                @error('mobile_code')
                                                <div style="color:red">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-8">
                                                <label class="label-1">Mobile No</label>
                                                <input  value="@if(isset($register)){{$register->mobile}}@else{{old('mobile')}}@endif" name="mobile" type="text" class="form-control" placeholder="Enter mobile no"  required> 
                                                @error('mobile')
                                                <div style="color:red">{{ $message }}</div>
                                                @enderror            
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 mb-3">
                                        <label class="label-1">Email Id</label>
                                        <input type="text" value="@if(isset($register)){{$register->email}}@else{{old('email')}}@endif" name="email" class="form-control" placeholder="Enter Email Id" required>
                                        @error('email')
                                        <div style="color:red">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-xl-6 col-lg-6 mb-3">
                                        <label class="label-1">Password</label>
                                        <input type="password" name="password" value="" class="form-control" placeholder="Enter Password" required>
                                        @error('password')
                                        <div style="color:red">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                </div>
                                <div class="text-center mt-3">
                                    <input type="submit" value="SUBMIT" name="basicDetails" class="btn btnPrimary">
                                </div>
                            </form>
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
    </div>
</div>
@endsection

@section('pageJS')

<script src="{{asset('admin/js/chosen.jquery.js')}}" type="text/javascript"></script>
<script src="{{asset('admin/js/prism.js')}}" type="text/javascript" charset="utf-8"></script>

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
    $(document).ready(function () {
        @if(Session::has('message'))
            $('#message').toast('show');
        @endif
        Dropdowncaste();
        $('#religion-dropdown').on('change', function () {
            Dropdowncaste();
        });
        function Dropdowncaste(){
            var religion_id = $('#religion-dropdown').val();
            $("#caste-dropdown").html('');
            $.ajax({
                url: "{{ route('creteprofilecaste') }}",
                type: "POST",
                data: {
                    religion_id: religion_id,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (result) {
                $('#caste-dropdown').html('<option value="">-- Select Caste --</option>');
                    $.each(result.caste, function (key, value) {
                        var selected = '';
                        if ('{{ old("caste") }}' == value.id) {
                            selected = 'selected';
                        }
                        $("#caste-dropdown").append('<option value="' + value.id + '" ' + selected + '>' + value.caste_name + '</option>');
                        $('#caste-dropdown').val('').trigger('chosen:updated');
                    });
                }
            });
        };
    });
</script>
@endsection