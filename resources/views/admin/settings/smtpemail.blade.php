@extends('admin.layouts.afterLoginLayout')

@section('title') Admin - SMTP Settings @endsection

@section('pageCSS') @endsection

@section('content')
<div class="container pt-3">
    <h3 class="colorSecondary inATitle1">SMTP Settings</h3>
    <div class="row">            
        <div class="col-xl-6 mb-3">
            <div class="card inBorderColor1 inAAddMembership mb-3">
                <div class="card-header">
                    <h4 class="card-title">SMTP Settings</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.smtpSettingsUpdate') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-xl-12 mb-3">
                                <label class="label-1">Type</label>
                                <select name="enc_type" class="form-control" required>
                                    <option value="" selected>select</option>
                                    <option value="tls" @if(isset($email)) {{$email->enc_type == "tls" ? "selected" : ''}}@endif>tls</option>
                                    <option value="SMTP" @if(isset($email)) {{$email->enc_type == "SMTP" ? "selected" : ''}}@endif>SMTP</option>
                                </select>
                                <p class="font-monospace mt-2 text-danger mb-0 font-13">Note: If you are getting issue in <b>SMTP</b> change it to <b>SendMail</b></p>
                            </div>
                            <div class="col-xl-12 mb-3">
                                <label class="label-1">Host</label>
                                <input type="text" name="host" value="@if(isset($email->host)){{$email->host}}@endif" class="form-control"required>
                            </div>
                            <div class="col-xl-12 mb-3">
                                <label class="label-1">From Email</label>
                                <input type="text" name="email" value="@if(isset($email->email)){{$email->email}}@endif" class="form-control"required>
                            </div>
                            <div class="col-xl-12 mb-3">
                                <label class="label-1">Email Password</label>
                                <input type="text" name="email_password" value="@if(isset($email->email_password)){{$email->email_password}}@endif" class="form-control"required>
                                <p class="font-monospace mt-2 text-danger mb-0 font-13">Note: Enter your email password which is set for your email id.</p>
                            </div>
                            <div class="col-xl-12 mb-3">
                                <label class="label-1">Port</label>
                                <input type="text" name="port" value="@if(isset($email->port)){{$email->port}}@endif" class="form-control"required>
                                <p class="font-monospace mt-2 text-danger mb-0 font-13">Note: For <b>Non SSL Use Port 587</b> & For <b>SSL Use Port 465</b></p>
                            </div>
                            <div class="col-xl-12 mb-3">
                                <label class="label-1">Email Name</label>
                                <input type="text" name="email_name" value="@if(isset($email->email_name)){{$email->email_name}}@endif" class="form-control"required>
                            </div>
                            <div class="col-xl-12 mb-4 text-center">
                                <input type="submit" name="smtp" value="UPDATE" class="btn btnPrimary">
                            </div>
                        </div>
                    </form>    
                </div>
            </div>
        </div>
        <div class="col-xl-6 mb-3">
            <div class="card inBorderColor1 inAAddMembership mb-3">
                <div class="card-header">
                    <h4 class="card-title">Send Test Email</h4>
                </div>
                <div class="card-body">
                    <form action="{{route('mail.testSend')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <h4 class="fs-6"></h4>
                    <div class="row">
                        <div class="col-8 mb-3">
                            <label class="label-1">Email Id</label>
                            <input type="text" name="emailto" value="" class="form-control">
                        </div>
                        <div class="col-4 mb-3">
                            <input type="submit" name="email" value="SEND" class="btn btnPrimary mt-4">
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