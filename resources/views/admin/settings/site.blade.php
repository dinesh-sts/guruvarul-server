@extends('admin.layouts.afterLoginLayout')

@section('title') Admin - Basic Settings @endsection

@section('pageCSS') @endsection

@section('content')
<div class="container pt-5">
    <div class="row">            
        <div class="col-xl-12 mb-3">
            <div class="card inBorderColor1 inAAddMembership mb-3">
                <div class="card-header">
                    <h4 class="card-title">Basic Settings</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.basicSiteSettingsUpdate') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-xl-6 mb-4">
                                <div class="row">
                                    <div class="col-xl-4">
                                        <label class="label-1 fw-semibold mt-2">Enter Matrimony Name</label>
                                    </div>
                                    <div class="col-xl-8">
                                        <input type="text" name="web_name" value="@if(isset($siteconfig->web_name)){{$siteconfig->web_name}}@endif" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 mb-4">
                                <div class="row">
                                    <div class="col-xl-4">
                                        <label class="label-1 fw-semibold mt-2">Enter Domain URL</label>
                                    </div>
                                    <div class="col-xl-8">
                                        <input type="text" name="web_frienly_name" value="@if(isset($siteconfig->web_frienly_name)){{$siteconfig->web_frienly_name}}@endif" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xl-6 mb-4">
                                <div class="row">
                                    <div class="col-xl-4">
                                        <label class="label-1 fw-semibold mt-2">Helpline Number</label>
                                    </div>
                                    <div class="col-xl-8">
                                        <input type="number" name="contact_no" value="@if(isset($siteconfig->contact_no)){{$siteconfig->contact_no}}@endif" class="form-control"required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 mb-4">
                                <div class="row">
                                    <div class="col-xl-4">
                                        <label class="label-1 fw-semibold mt-2">Helpline Email</label>
                                    </div>
                                    <div class="col-xl-8">
                                        <input type="email" name="contact_email" value="@if(isset($siteconfig->contact_email)){{$siteconfig->contact_email}}@endif" class="form-control"required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 mb-4">
                                <div class="row">
                                    <div class="col-xl-4">
                                        <label class="label-1 fw-semibold mt-2">Member Profile Prefix</label>
                                    </div>
                                    <div class="col-xl-8">
                                        <input type="text" name="prefix" value="@if(isset($siteconfig->prefix)){{$siteconfig->prefix}}@endif" class="form-control"required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 mb-4">
                                <div class="row">
                                    <div class="col-xl-4">
                                        <label class="label-1 fw-semibold mt-2">Google Analytics Code</label>
                                    </div>
                                    <div class="col-xl-8">
                                        <input type="text" name="google_analytics" value="@if(isset($siteconfig->google_analytics)){{$siteconfig->google_analytics}}@endif" class="form-control"required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 mb-4">
                                <div class="row">
                                    <div class="col-xl-2">
                                        <label class="label-1 fw-semibold mt-2">Footer About</label>
                                    </div>
                                    <div class="col-xl-10">
                                        <textarea class="form-control" name="web_fshort_description" rows="3" required>@if(isset($siteconfig->web_fshort_description)){{$siteconfig->web_fshort_description}}@endif</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 mb-4 text-center">
                                <input type="submit" name="basic" value="SUBMIT" class="btn btnPrimary">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card inBorderColor1 inAAddMembership mb-5">
                <div class="card-header">
                    <h4 class="card-title">Site Configuration</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.basicSiteSettingsUpdate') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-xl-6 mb-4">
                                <div class="row">
                                    <div class="col-xl-5">
                                        <label class="label-1 fw-semibold mt-2">Footer Contact No</label>
                                    </div>
                                    <div class="col-xl-7">
                                        <select name="footer_contact_status" class="form-select" required>
                                            <option value="show" @if(isset($siteconfig->footer_contact_status)) {{ $siteconfig->footer_contact_status == "show" ? "selected" : '' }}@endif>Show</option>
											<option value="hide" @if(isset($siteconfig->footer_contact_status)) {{$siteconfig->footer_contact_status == "hide" ? "selected" : ''}}@endif>Hide</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 mb-4">
                                <div class="row">
                                    <div class="col-xl-5">
                                        <label class="label-1 fw-semibold mt-2">Footer Email Id</label>
                                    </div>
                                    <div class="col-xl-7">
                                        <select name="footer_email_status" class="form-select" required>
                                            <option value="show" @if(isset($siteconfig->footer_email_status)) {{ $siteconfig->footer_email_status == "show" ? "selected" : '' }}@endif>Show</option>
											<option value="hide" @if(isset($siteconfig->footer_email_status)) {{$siteconfig->footer_email_status == "hide" ? "selected" : ''}}@endif>Hide</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 mb-4">
                                <div class="row">
                                    <div class="col-xl-5">
                                        <label class="label-1 fw-semibold mt-2">Right Click</label>
                                    </div>
                                    <div class="col-xl-7">
                                        <select name="right_click" class="form-select" required>
                                            <option value="ENABLED" @if(isset($siteconfig->right_click)) {{ $siteconfig->right_click == "ENABLED" ? "selected" : '' }}@endif>Enable</option>
											<option value="DISABLED" @if(isset($siteconfig->right_click)) {{$siteconfig->right_click == "DISABLED" ? "selected" : ''}}@endif>Disable</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 mb-4">
                                <div class="row">
                                    <div class="col-xl-5">
                                        <label class="label-1 fw-semibold mt-2">Mobile No Verification</label>
                                    </div>
                                    <div class="col-xl-7">
                                        <select name="mobileVerification" class="form-control" required>
                                            <option value="Yes" @if(isset($siteconfig->mobileVerification)) {{ $siteconfig->mobileVerification == "Yes" ? "selected" : '' }}@endif>Yes</option>
											<option value="No" @if(isset($siteconfig->mobileVerification)) {{$siteconfig->mobileVerification == "No" ? "selected" : ''}}@endif>No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 mb-4">
                                <div class="row">
                                    <div class="col-xl-5">
                                        <label class="label-1 fw-semibold mt-2">Login With OTP</label>
                                    </div>
                                    <div class="col-xl-7">
                                        <select name="loginWithOTP" class="form-control" required>
                                            <option value="Yes" @if(isset($siteconfig->loginWithOTP)) {{ $siteconfig->loginWithOTP == "Yes" ? "selected" : '' }}@endif>Yes</option>
											<option value="No" @if(isset($siteconfig->loginWithOTP)) {{$siteconfig->loginWithOTP == "No" ? "selected" : ''}}@endif>No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 mb-4">
                                <div class="row">
                                    <div class="col-xl-5">
                                        <label class="label-1 fw-semibold mt-2">Register Personal Details Form</label>
                                    </div>
                                    <div class="col-xl-7">
                                        <select name="registerPersonalDetails" class="form-control" required>
                                            <option value="Yes" @if(isset($siteconfig->registerPersonalDetails)) {{ $siteconfig->registerPersonalDetails == "Yes" ? "selected" : '' }}@endif>Yes</option>
											<option value="No" @if(isset($siteconfig->registerPersonalDetails)) {{$siteconfig->registerPersonalDetails == "No" ? "selected" : ''}}@endif>No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 mb-4">
                                <div class="row">
                                    <div class="col-xl-5">
                                        <label class="label-1 fw-semibold mt-2">Register Preference Details Form</label>
                                    </div>
                                    <div class="col-xl-7">
                                        <select name="registerPreferenceDetails" class="form-control" required>
                                            <option value="Yes" @if(isset($siteconfig->registerPreferenceDetails)) {{ $siteconfig->registerPreferenceDetails == "Yes" ? "selected" : '' }}@endif>Yes</option>
											<option value="No" @if(isset($siteconfig->registerPreferenceDetails)) {{$siteconfig->registerPreferenceDetails == "No" ? "selected" : ''}}@endif>No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 mb-4">
                                <div class="row">
                                    <div class="col-xl-5">
                                        <label class="label-1 fw-semibold mt-2">Express Interest Sent Setting</label>
                                    </div>
                                    <div class="col-xl-7">
                                        <select name="interest_setting" class="form-control"required>
                                            <option value="send_to_all"  @if(isset($siteconfig->interest_setting)) {{$siteconfig->interest_setting == "send_to_all" ? "selected" : ''}}@endif>All Member Can Send</option>
											<option value="send_to_paid" @if(isset($siteconfig->interest_setting)) {{$siteconfig->interest_setting == "send_to_paid" ? "selected" : ''}}@endif>Only Paid Member Can Send</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 mb-4">
                                <div class="row">
                                    <div class="col-xl-5">
                                        <label class="label-1 fw-semibold mt-2">Profile View Setting</label>
                                    </div>
                                    <div class="col-xl-7">
                                        <select name="profile_view_setting" class="form-control"required>
                                            <option value="visible_to_all"  @if(isset($siteconfig->profile_view_setting)) {{$siteconfig->profile_view_setting == "visible_to_all" ? "selected" : ''}}@endif>All Member View</option>
                                            <option value="visible_to_paid" @if(isset($siteconfig->profile_view_setting)) {{$siteconfig->profile_view_setting == "visible_to_paid" ? "selected" : ''}}@endif>Only Paid Member View</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 mb-4">
                                <div class="row">
                                    <div class="col-xl-5">
                                        <label class="label-1 fw-semibold mt-2">Username Setting</label>
                                    </div>
                                    <div class="col-xl-7">
                                        <select name="username_setting" class="form-control"required>
                                            <option value="full_username" @if(isset($siteconfig->username_setting)) {{$siteconfig->username_setting == "full_username" ? "selected" : ''}}@endif>Show full username</option>
                                            <option value="first_surname" @if(isset($siteconfig->username_setting)) {{$siteconfig->username_setting == "first_surname" ? "selected" : ''}}@endif>Show firstname and lastname first letter</option>
                                            <option value="hide_username" @if(isset($siteconfig->username_setting)) {{$siteconfig->username_setting == "hide_username" ? "selected" : ''}}@endif>Hide username</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 mb-4">
                                <div class="row">
                                    <div class="col-xl-5">
                                        <label class="label-1 fw-semibold mt-2">Profile Activation Method Setting</label>
                                    </div>
                                    <div class="col-xl-7">
                                        <select name="profile_varification" class="form-control"required>
                                            <option value="auto_approve" @if(isset($siteconfig->profile_varification)) {{$siteconfig->profile_varification == "auto_approve" ? "selected" : ''}}@endif>User can activate profile via email verification link</option>
                                            <option value="manual_approve" @if(isset($siteconfig->profile_varification)) {{$siteconfig->profile_varification == "manual_approve" ? "selected" : ''}}@endif>Approve Profile Only Via Admin</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 mb-4">
                                <div class="row">
                                    <div class="col-xl-5">
                                        <label class="label-1 fw-semibold mt-3">Weight Field Settings</label>
                                    </div>
                                    <div class="col-xl-7">
                                        <div class="row">
                                            <div class="col-6">
                                                <label class="label-1">Weight Start From</label>
                                                <input type="number" name="weight_first" value="@if(isset($siteconfig->weight_first)){{$siteconfig->weight_first}}@endif" class="form-control"required>
                                            </div>
                                            <div class="col-6">
                                                <label class="label-1">Weight Start To</label>
                                                <input type="number" name="weight_last" value="@if(isset($siteconfig->weight_last)){{$siteconfig->weight_last}}@endif" class="form-control"required>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 mb-4">
                                <div class="row">
                                    <div class="col-xl-5">
                                        <label class="label-1 fw-semibold mt-3">Legal Age Settings</label>
                                    </div>
                                    <div class="col-xl-7">
                                        <div class="row">
                                            <div class="col-6">
                                                <label class="label-1 font-12">Female Leagal Age</label>
                                                <input type="number" name="female_legal_age" value="@if(isset($siteconfig->female_legal_age)){{$siteconfig->female_legal_age}}@endif" class="form-control"required>
                                            </div>
                                            <div class="col-6">
                                                <label class="label-1 font-12">Male Leagal Age</label>
                                                <input type="number" name="male_legal_age" value="@if(isset($siteconfig->male_legal_age)){{$siteconfig->male_legal_age}}@endif" class="form-control"required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 mb-4">
                                <div class="row">
                                    <div class="col-xl-5">
                                        <label class="label-1 fw-semibold mt-3">Year Field Setting</label>
                                    </div>
                                    <div class="col-xl-7">
                                        <div class="row">
                                            <div class="col-6">
                                                <label class="label-1 font-12">Last Birth Year</label>
                                                <input type="number" name="birthyear" value="@if(isset($siteconfig->birthyear)){{$siteconfig->birthyear}}@endif" class="form-control"required>
                                            </div>
                                            <div class="col-6">
                                                <label class="label-1 font-12">Last Success Story Year</label>
                                                <input type="number" name="success_marriage_year" value="@if(isset($siteconfig->success_marriage_year)){{$siteconfig->success_marriage_year}}@endif" class="form-control"required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 mb-4 text-center">
                                <input type="submit" name="site" value="SUBMIT" class="btn btnPrimary">
                            </div>
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