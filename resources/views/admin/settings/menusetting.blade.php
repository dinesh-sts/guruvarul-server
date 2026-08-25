@extends('admin.layouts.afterLoginLayout')

@section('title') Admin - Menu Enable / Disable @endsection

@section('pageCSS') @endsection

@section('content')
  <!-- Main Content -->
  <div class="container pt-5">
    <div class="row">   
        <div class="col-xl-8 offset-xl-2 mb-3">
            <div class="card inBorderColor1 inAAddMembership mb-3">
                <div class="card-header">
                    <h4 class="card-title">Menu Enable / Disable</h4>
                </div>
                <div class="card-body">
                    <p><b>Note:</b> Checked menu option are enabled menu option.</p>
                    <form action="{{ route('admin.menuSettingsUpdate') }}" class="inFieldSetting col-xl-8 offset-xl-2" method="POST" enctype="multipart/form-data">
                        @csrf
                        <h4 class="mb-4 fs-6">Header Menu Section</h4>
                        <div class="row">
                            <div class="col-xl-12 mb-4 ps-4">
                                <div class="row">
                                    <div class="col-xl-12 inMB-10">
                                        <label class="" for="menu_membership">
                                            <input type="checkbox" @if(isset($menusetting)){{$menusetting->menu_membership == 'APPROVED' ? 'checked' : ''}}@endif name="menu_membership" id="menu_membership" class="form-check-input"><span class="ps-2">Membership</span>
                                        </label>
                                    </div>
                                    <div class="col-xl-12 inMB-10">
                                        <label class="inMainResultCheck" for="menu_search">
                                            <input type="checkbox" @if(isset($menusetting)){{$menusetting->menu_search == 'APPROVED' ? 'checked' : ''}}@endif name="menu_search" id="menu_search" class="form-check-input"><span class="ps-2">Search</span>
                                        </label>
                                    </div>
                                    <div class="col-xl-12 inMB-10">
                                        <label class="inMainResultCheck" for="menu_success">
                                            <input type="checkbox" @if(isset($menusetting)){{$menusetting->menu_success == 'APPROVED' ? 'checked' : ''}}@endif name="menu_success" id="menu_success" class="form-check-input"><span class="ps-2">Success Story</span>
                                        </label>
                                    </div>
                                    <div class="col-xl-12 inMB-10">
                                        <label class="inMainResultCheck" for="menu_login">
                                            <input type="checkbox" @if(isset($menusetting)){{$menusetting->menu_login == 'APPROVED' ? 'checked' : ''}}@endif name="menu_login" id="menu_login" class="form-check-input"><span class="ps-2">Login</span>
                                        </label>
                                    </div>
                                    <div class="col-xl-12 inMB-10">
                                        <label class="inMainResultCheck" for="menu_signup">
                                            <input type="checkbox" @if(isset($menusetting)){{$menusetting->menu_signup == 'APPROVED' ? 'checked' : ''}}@endif name="menu_signup" id="menu_signup" class="form-check-input"><span class="ps-2">Register</span>
                                        </label>
                                    </div>
                                    <div class="col-xl-12 inMB-10">
                                        <label class="inMainResultCheck" for="menu_contact">
                                            <input type="checkbox" @if(isset($menusetting)){{$menusetting->menu_contact == 'APPROVED' ? 'checked' : ''}}@endif name="menu_contact" id="menu_contact" class="form-check-input"><span class="ps-2">Contact</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h4 class="mb-4 fs-6">Footer Menu Section</h4>
                        <div class="row">
                            <div class="col-xl-12 mb-4 ps-4">
                                <div class="row">
                                    <div class="col-xl-12 inMB-10">
                                        <label class="" for="footer_contact">
                                            <input type="checkbox" @if(isset($menusetting)){{$menusetting->footer_contact == 'APPROVED' ? 'checked' : ''}}@endif name="footer_contact" id="footer_contact" class="form-check-input"><span class="ps-2">Footer Contact</span>
                                        </label>
                                    </div>
                                    <div class="col-xl-12 inMB-10">
                                        <label class="" for="footer_faq">
                                            <input type="checkbox" @if(isset($menusetting)){{$menusetting->footer_faq == 'APPROVED' ? 'checked' : ''}}@endif name="footer_faq" id="footer_faq" class="form-check-input"><span class="ps-2">Footer FAQ</span>
                                        </label>
                                    </div>
                                    <div class="col-xl-12 inMB-10">
                                        <label class="" for="footer_report">
                                            <input type="checkbox" @if(isset($menusetting)){{$menusetting->footer_report == 'APPROVED' ? 'checked' : ''}}@endif name="footer_report" id="footer_report" class="form-check-input"><span class="ps-2">Footer Report Misuse</span>
                                        </label>
                                    </div>
                                    <div class="col-xl-12 inMB-10">
                                        <label class="" for="footer_terms">
                                            <input type="checkbox" @if(isset($menusetting)){{$menusetting->footer_terms == 'APPROVED' ? 'checked' : ''}}@endif name="footer_terms" id="footer_terms" class="form-check-input"><span class="ps-2">Footer Terms & Conditions</span>
                                        </label>
                                    </div>
                                    <div class="col-xl-12 inMB-10">
                                        <label class="" for="footer_policy">
                                            <input type="checkbox" @if(isset($menusetting)){{$menusetting->footer_policy == 'APPROVED' ? 'checked' : ''}}@endif name="footer_policy" id="footer_policy" class="form-check-input"><span class="ps-2">Footer Privacy Policy</span>
                                        </label>
                                    </div>
                                    <div class="col-xl-12 inMB-10">
                                        <label class="" for="footer_refund">
                                            <input type="checkbox" @if(isset($menusetting)){{$menusetting->footer_refund == 'APPROVED' ? 'checked' : ''}}@endif name="footer_refund" id="footer_refund" class="form-check-input"><span class="ps-2">Footer Refund Policy</span>
                                        </label>
                                    </div>
                                    <div class="col-xl-12 inMB-10">
                                        <label class="" for="footer_login">
                                            <input type="checkbox" @if(isset($menusetting)){{$menusetting->footer_login == 'APPROVED' ? 'checked' : ''}}@endif name="footer_login" id="footer_login" class="form-check-input"><span class="ps-2">Footer Login</span>
                                        </label>
                                    </div>
                                    <div class="col-xl-12 inMB-10">
                                        <label class="" for="footer_register">
                                            <input type="checkbox" @if(isset($menusetting)){{$menusetting->footer_register == 'APPROVED' ? 'checked' : ''}}@endif name="footer_register" id="footer_register" class="form-check-input"><span class="ps-2">Footer Register</span>
                                        </label>
                                    </div>
                                    <div class="col-xl-12 inMB-10">
                                        <label class="" for="footer_membership">
                                            <input type="checkbox" @if(isset($menusetting)){{$menusetting->footer_membership == 'APPROVED' ? 'checked' : ''}}@endif name="footer_membership" id="footer_membership" class="form-check-input"><span class="ps-2">Footer Membership</span>
                                        </label>
                                    </div>
                                    <div class="col-xl-12 inMB-10">
                                        <label class="" for="footer_about">
                                            <input type="checkbox" @if(isset($menusetting)){{$menusetting->footer_about == 'APPROVED' ? 'checked' : ''}}@endif name="footer_about" id="footer_about" class="form-check-input"><span class="ps-2">Footer About</span>
                                        </label>
                                    </div>
                                    <div class="col-xl-12 inMB-10">
                                        <label class="" for="footer_about_short">
                                            <input type="checkbox" @if(isset($menusetting)){{$menusetting->footer_about_short == 'APPROVED' ? 'checked' : ''}}@endif name="footer_about_short" id="footer_about_short" class="form-check-input"><span class="ps-2">Footer About Short</span>
                                        </label>
                                    </div>
                                    <div class="col-xl-12 inMB-10">
                                        <label class="" for="footer_search">
                                            <input type="checkbox" @if(isset($menusetting)){{$menusetting->footer_search == 'APPROVED' ? 'checked' : ''}}@endif name="footer_search" id="footer_search" class="form-check-input"><span class="ps-2">Footer Search</span>
                                        </label>
                                    </div>
                                    <div class="col-xl-12 inMB-10">
                                        <label class="" for="footer_success">
                                            <input type="checkbox" @if(isset($menusetting)){{$menusetting->footer_success == 'APPROVED' ? 'checked' : ''}}@endif name="footer_success" id="footer_success" class="form-check-input"><span class="ps-2">Footer Success Story</span>
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
<!-- /.Main Content -->
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