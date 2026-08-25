@extends('admin.layouts.afterLoginLayout')

@section('title') Admin - Whatsapp Button Settings @endsection

@section('pageCSS') @endsection

@section('content')
<div class="container pt-5">
    <div class="row">            
        <div class="col-xl-8 offset-xl-2 mb-3">
            <div class="card inBorderColor1 inAAddMembership mb-3">
                <div class="card-header">
                    <h4 class="card-title">Whatsapp Button Settings</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.whatsappButtonSettingsUpdate') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-xl-12 mb-4">
                                <div class="row">
                                    <div class="col-xl-4">
                                        <label class="label-1 fw-semibold mt-2">Whatsapp Mobile No</label>
                                    </div>
                                    <div class="col-xl-8">
                                        <input type="text" name="whatsapp_no" value="@if(isset($siteconfig->whatsapp_no)){{ $siteconfig->whatsapp_no }}@endif" class="form-control @error('whatsapp_no') is-invalid @enderror" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 mb-4">
                                <div class="row">
                                    <div class="col-xl-4">
                                        <label class="label-1 fw-semibold mt-2">Whatspp Button Text</label>
                                    </div>
                                    <div class="col-xl-8">
                                        <input type="text" name="whatsapp_btn_text" value="@if(isset($siteconfig->whatsapp_btn_text)){{ $siteconfig->whatsapp_btn_text }}@endif" class="form-control @error('whatsapp_btn_text') is-invalid @enderror" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xl-12 mb-4">
                                <div class="row">
                                    <div class="col-xl-4">
                                        <label class="label-1 fw-semibold mt-2">Status</label>
                                    </div>
                                    <div class="col-xl-8">
                                        <select name="whatsapp_btn_status" class="form-select @error('whatsapp_btn_status') is-invalid @enderror" required>
                                            <option value="">select</option>
                                            <option value="APPROVED" @if(isset($siteconfig->whatsapp_btn_status)) {{ $siteconfig->whatsapp_btn_status == "APPROVED" ? "selected" : '' }} @endif>APPROVED</option>
                                            <option value="UNAPPROVED" @if(isset($siteconfig->whatsapp_btn_status)) {{ $siteconfig->whatsapp_btn_status == "UNAPPROVED" ? "selected" : '' }}@endif>UNAPPROVED</option>
                                        </select>
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