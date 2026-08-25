@extends('admin.layouts.afterLoginLayout')

@section('title') Admin - Payment Methods @endsection

@section('pageCSS') @endsection

@section('content')
<div class="container pt-3">
    <h3 class="colorSecondary inATitle1">Payment Methods</h3>
    <div class="row">            
        <div class="col-xl-12 mb-3">
            <div class="card inBorderColor1 inAAddMembership mb-3">
                <div class="card-header">
                    <h4 class="card-title">Razorpay Integration</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.paymentMethodsUpdate') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-xl-6 mb-3">
                                <label class="label-1">Razorpay Key</label>
                                <input type="text" name="razorpay_key" value="@if(isset($razorpay->razorpay_key)){{$razorpay->razorpay_key}}@endif" class="form-control"required>
                            </div>
                            <div class="col-xl-6 mb-3">
                                <label class="label-1">Razorpay Secret</label>
                                <input type="text" name="razorpay_secret" value="@if(isset($razorpay->razorpay_secret)){{$razorpay->razorpay_secret}}@endif" class="form-control"required>
                            </div>

                            <div class="col-xl-6 mb-3">
                                <label class="label-1">Status</label>
                                <select name="status" class="form-control" required>
                                    <option value="" selected>select</option>
                                    <option value="APPROVED" @if(isset($razorpay->status)) {{$razorpay->status == "APPROVED" ? "selected" : ''}}@endif>APPROVED</option>
                                    <option value="UNAPPROVED" @if(isset($razorpay->status)) {{$razorpay->status == "UNAPPROVED" ? "selected" : ''}}@endif>UNAPPROVED</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-12 mb-4 text-center">
                            <input type="submit" name="razorpay" value="UPDATE" class="btn btnPrimary">
                        </div>
                    </form>
                </div>
            </div>
        </div> 
    </div>
    <div class="row">            
        <div class="col-xl-12 mb-3">
            <div class="card inBorderColor1 inAAddMembership mb-3">
                <div class="card-header">
                    <h4 class="card-title">Payumoney Integration</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.paymentMethodsUpdate') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-xl-6 mb-3">
                                <label class="label-1">Merchant Key</label>
                                <input type="text" name="merchant_key" value="@if(isset($payumoney->merchant_key)){{$payumoney->merchant_key}}@endif" class="form-control"required>
                            </div>
                            <div class="col-xl-6 mb-3">
                                <label class="label-1">Salt</label>
                                <input type="text" name="salt" value="@if(isset($payumoney->salt)){{$payumoney->salt}}@endif" class="form-control"required>
                            </div>

                            <div class="col-xl-6 mb-3">
                                <label class="label-1">Status</label>
                                <select name="status" class="form-control" required>
                                    <option value="" selected>select</option>
                                    <option value="APPROVED" @if(isset($payumoney->status)) {{$payumoney->status == "APPROVED" ? "selected" : ''}}@endif>APPROVED</option>
                                    <option value="UNAPPROVED" @if(isset($payumoney->status)) {{$payumoney->status == "UNAPPROVED" ? "selected" : ''}}@endif>UNAPPROVED</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-12 mb-4 text-center">
                            <input type="submit" name="payumoney" value="UPDATE" class="btn btnPrimary">
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