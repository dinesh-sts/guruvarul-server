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
            <div class="col-xl-8 offset-xl-2">

                <div class="card">
                    <div class="card-body ps-md-5 pe-md-5 ps-4 pe-4 pt-4 pb-4">
                        <h4 class="text-center inLoginTitle mb-4">Create Free Account</h4> 
			<p class="text-center">
                            Already have an account?
                            <a href="{{ route('user.loginWithOtp') }}" class="colorPrimary fw-semibold">Log in here</a>
                        </p>
                        <form method="POST" id="register_form" action="{{ route('user.registerPost') }}">
                            @csrf
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="mb-3">
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
                                </div>
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label class="label-1">Profile Created By</label>
                                        <select name="profileby" class="form-select" required>
                                            <option value="" selected>select</option>
                                            @foreach ($profiles as $profile)
                                            <option value="{{$profile->profile_by}}" @selected(old('profileby') == $profile->profile_by)>{{$profile->profile_by}}</option>
                                            @endforeach
                                        </select>
                                        @error('profileby')
                                            <div style="color:red">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label class="label-1">Gender</label>
                                        <select name="gender" class="form-select" required>
                                            <option value="" selected>select</option>
                                            <option value="Male" @selected(old('gender') == "Male")>Male</option>
                                            <option value="Female" @selected(old('gender') == "Female")>Female</option>
                                        </select>
                                        @error('gender')
                                        <div style="color:red">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label class="label-1">First Name</label>
                                        <input type="text" value="{{old('firstname')}}" name="firstname" class="form-control" placeholder="Enter First Name" required>
                                        @error('firstname')
                                        <div style="color:red">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label class="label-1">Last Name</label>
                                        <input type="text" value="{{old('lastname')}}" name="lastname" class="form-control" placeholder="Enter Last Name" required>
                                        @error('lastname')
                                        <div style="color:red">{{ $message }}</div>
                                        @enderror
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
                                        <div class="col-3 g-0">
                                            <select name="month" id="month" class="form-select" onchange="setDays(this, day, year)" required>
                                                <option value="" selected>Month</option>
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
                                                @php
                                                    $siteconfig = DB::table('site_configs')->select('birthyear')->first();
                                                    $year = "";

                                                    if(isset($siteconfig->birthyear)) {
                                                        $year = $siteconfig->birthyear;
                                                    }

                                                    for ($x = $year; $x >= 1930; $x--) {
                                                @endphp
                                                    <option value='{{ $x }}'@selected(old('year') == $x)>
                                                        {{ $x }}
                                                    </option>
                                                @php } @endphp
                                            </select>
                                            @error('year')
                                            <div style="color:red">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="mb-3 chosen-style-1">
                                        <label class="label-1">Country</label>
                                        <select name="country_id" class="form-select chosen-select" id="floatingSelect" data-placeholder="Select Country" required>
                                            <option value="" selected>Select</option>
                                            @foreach($countries as $country)
                                            <option value="{{$country->id}}" @selected(old('country_id') == $country->id)>{{$country->country_name}}</option>
                                            @endforeach
                                        </select>
                                        @error('country_id')
                                        <div style="color:red">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-xl-6">
                                    <div class="mb-3 chosen-style-1">
                                        <label class="label-1">Religion</label>
                                        <select name="religion" class="form-select chosen-select" data-placeholder="Select Religion" id="religion-dropdown" required>
                                            <option value="" selected>select</option>
                                            @foreach($religions as $religion)
                                            <option value="{{$religion->id}}" @selected(old('religion') == $religion->id)>{{$religion->religion_name}}</option>
                                            @endforeach
                                        </select>
                                        @error('religion')
                                        <div style="color:red">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="mb-3 chosen-style-1">
                                        <label class="label-1">Caste</label>
                                        <select name="caste" class="form-select chosen-select" data-placeholder="Select Religion First" id="caste-dropdown" required>
                                        </select>
                                        @error('caste')
                                        <div style="color:red">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="row ">
                                        <div class="col-5 col-xl-4 mb-3 chosen-style-1">
                                            <label class="label-1">Country Code</label>
                                            <select name="mobile_code" class="form-select chosen-select" data-placeholder="Select Country Code" required>
                                                <?php $mobile_code = 91; ?>
                                                <option value="" selected>select</option>
                                                @foreach ($country_code as $code)
                                                <option value="{{$code->phonecode}}" @if(isset($mobile_code)){{$mobile_code == $code->phonecode ? "selected" : ''}} @else @selected(old('mobile_code') == $code->id)@endif > +{{$code->phonecode}}</option>
                                                @endforeach
                                            </select>
                                            @error('mobile_code')
                                            <div style="color:red">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-xl-8 col-7 mb-3">
                                            <label class="label-1">Mobile No</label>
                                            <input value="{{ old('mobile') }}" name="mobile" type="text" class="form-control" placeholder="Enter Mobile No" required oninput="updateEmail()">
                                            @error('mobile')
                                            <div style="color:red">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="row">
                                        <div class="col-12 col-xl-6">
                                            <div class="mb-3" style="display:none;">
                                                <label class="label-1">Email Id</label>
                                                <input type="email" value="{{ old('mobile') ? old('mobile').'@guruvarul.com' : '' }}" class="form-control" placeholder="Enter Email id" name="email" autocomplete="off" readonly id="emailField" style="background-color:lightgrey;">
                                                @error('email')
                                                    <div style="color:red">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 col-xl-6">
                                            <div class="mb-3" style="display:none;">
                                                <label class="label-1">Password</label>
                                                <input type="password" name="password" class="form-control" value="welcome" readonly style="background-color:lightgrey;">
                                                @error('password')
                                                <div style="color:red">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-xl-12 inFormTerms">
                                    <div class="mb-3">
                                        <?php  
                                            $termspolicy = DB::table('cms_pages')->where('page_name','terms-policy')->where('status','APPROVED')->first(); 
                                            $privatepolicy = DB::table('cms_pages')->where('page_name','private-policy')->where('status','APPROVED')->first();
                                        ?>
                                        <div class="form-check">
                                          <input class="form-check-input" name="" type="checkbox" id="flexCheckDefault" required>
                                          <label class="form-check-label" for="flexCheckDefault">
                                            By register you agree to our <a href="@if(isset($termspolicy->page_name)){{route('user.footer',$termspolicy->page_name)}}@endif">Terms & Condition</a> & <a href="@if(isset($privatepolicy->page_name)){{route('user.footer',$privatepolicy->page_name)}}@endif">Privacy Policy</a>. 
                                          </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12 text-center">
                                    <div class="mb-3">
                                       <input type="submit" value="REGISTER NOW" class="btn btnSecondary shadow-sm">
                                    </div>
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
        <div class="toast-container position-fixed position-static bottom-0 end-0 p-3 mb-5 mb-sm-0">
            <div id="legalage" class="toast inToastExpress" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
                <div class="d-flex">
                    <div class="toast-body">
                        <strong class="me-auto">{{ Session::get('legalage') }}</strong>
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
    function updateEmail() {
        let mobile = document.querySelector('input[name="mobile"]').value.trim();
        document.getElementById('emailField').value = mobile ? mobile + '@guruvarul.com' : '';
    }
</script>
<!-- /. Chosen js -->
<script>
    const toastTrigger = document.getElementById('reshow')
   
   const toastLiveExample = document.getElementById('liveToast')
    if (toastTrigger) {
      toastTrigger.addEventListener('click', () => {
        const toast = new bootstrap.Toast(toastLiveExample)
        toast.show()
      })
    }
</script>
<!-- Dynamic option Js -->
<script type="text/javascript">
    $(document).ready(function () {
        @if(Session::has('message'))
            $('#message').toast('show');
        @endif
        @if(Session::has('legalage'))
            $('#legalage').toast('show');
        @endif
        Dropdowncaste();
        $('#religion-dropdown').on('change', function () {
            Dropdowncaste();
	    //console.log("religion changed");
        });
        function Dropdowncaste(){
            var religion_id = $('#religion-dropdown').val();
            $("#caste-dropdown").html('');
            $.ajax({
                url: "{{route('searchfetchcastesingle')}}",
                type: "POST",
                data: {
                    religion_id: religion_id,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (result) {
		//console.log("caste loaded");
                $('#caste-dropdown').html('<option value="">Select caste</option>');
                    $.each(result.caste, function (key, value) {
                        var selected = '';
                        if ('{{ old("caste") }}' == value.id) {
                            selected = 'selected';
                        }
                        $("#caste-dropdown").append('<option value="' + value.id + '" ' + selected + '>' + value.caste_name + '</option>');
                    });
                    $('#caste-dropdown').val('').trigger('chosen:updated');
                }
            });
        };

    });
</script>
<!-- /. Dynamic option Js -->

@endsection
