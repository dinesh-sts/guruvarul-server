@extends('admin.layouts.afterLoginLayout')

@section('title') Admin - SMS Settings @endsection

@section('pageCSS') @endsection

@section('content')
<div class="container pt-5">
    <div class="row">            
        <div class="col-xl-8 offset-xl-2 mb-3">
            <div class="card inBorderColor1 inAAddMembership mb-3">
                <div class="card-header">
                    <h4 class="card-title">SMS Settings</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.smsSettingsUpdate') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="col-xl-12">
                            <div class="row mb-4">
                                <div class="col-xl-3">
                                    <label class="label-1 fw-semibold mt-2">SMS Api</label>
                                </div>
                                <div class="col-xl-9">
                                    <select id="sms" name="activeapi" class="form-control" required>
                                        <option select>Select</option>
                                        <option id="fast_2_sms" value="fast2sms" @if(isset($activeapi->value)) {{$activeapi->value == "fast2sms" ? "selected" : ''}}@endif>Fast 2 SMS</option>
                                        <option id="msg_91" value="msg91" @if(isset($activeapi->value)) {{$activeapi->value == "msg91" ? "selected" : ''}}@endif>MSG 91</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row" id="sms2">
                                <div class="col-12 mb-4">
                                    <div class="row">
                                        <div class="col-xl-3">
                                            <label class="label-1 fw-semibold mt-2">route</label>
                                        </div>
                                        <div class="col-xl-9">
                                            <select name="route" class="form-control">
                                                <option select>Select</option>
                                                <option value="dlt" @if(isset($route->value)) {{$route->value == "dlt" ? "selected" : ''}}@endif>DLT</option>
                                                <option value="otp" @if(isset($route->value)) {{$route->value == "otp" ? "selected" : ''}}@endif>OTP</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12 mb-4">
                                    <div class="row">
                                        <div class="col-xl-3">
                                            <label class="label-1 fw-semibold mt-2">Api Key</label>
                                        </div>
                                        <div class="col-xl-9">
                                            <input type="text" name="key" value="@if(isset($key->value)){{$key->value}}@endif" class="form-control" placeholder="Enter Api Key">
                                        </div>
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
    
    $('#sms').on('change', function () {
        var status = $('#sms').val();
        if (status == 'fast2sms'){
            $('#sms2').show();
        }else{
            $('#sms2').hide();
        }
    });
</script>
@endsection