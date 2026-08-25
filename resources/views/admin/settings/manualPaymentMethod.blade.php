@extends('admin.layouts.afterLoginLayout')

@section('title') Admin - Manual Payment Methods @endsection

@section('pageCSS') 
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="container pt-3">
    <div class="row">            
        <div class="col-xl-6 m-auto mb-3 mt-3">
            <div class="card inBorderColor1 inAAddMembership mb-3">
                <div class="card-header">
                    <h4 class="card-title">Manual Payment Method</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.manualPaymentMethodUpdate') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-xl-12 mb-3">
                                <label class="label-1">Payment Title</label>
                                <input type="text" name="pay_name" value="@if(isset($manualPaymentMethod->pay_name)){{ $manualPaymentMethod->pay_name }} @else {{ old('pay_name') }} @endif" class="form-control" required>
                            </div>
                            <div class="col-xl-12 mb-3">
                                <label class="label-1">Select QR Code Image</label>
                                <input type="file" name="qr_code" value="" class="form-control">
                                <div class="mt-3 mb-3">
                                    <img src="{{ asset('storage/manualPaymentImg/'.$manualPaymentMethod->qr_code) }}" class="img-fluid maxH-75 rounded">
                                </div>
                            </div>
                            <div class="col-xl-12 mb-3">
                                <label class="label-1">Manual Payment Message</label>
                                <textarea id="summernote" name="manual_payment_message">@if(isset($manualPaymentMethod->manual_payment_message)){{ $manualPaymentMethod->manual_payment_message }} @else {{ old('manual_payment_message') }} @endif</textarea>
                            </div>
                            <div class="col-xl-12 mb-3">
                                <label class="label-1">Status</label>
                                <select name="status" class="form-control" required>
                                    <option value="">select</option>
                                    <option value="APPROVED" @if(isset($manualPaymentMethod->status)) {{ $manualPaymentMethod->status == "APPROVED" ? "selected" : '' }} @endif>APPROVED</option>
                                    <option value="UNAPPROVED" @if(isset($manualPaymentMethod->status)) {{ $manualPaymentMethod->status == "UNAPPROVED" ? "selected" : '' }}@endif>UNAPPROVED</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-12 mb-4 text-center">
                            <input type="submit" name="manualPaymentMethod" value="UPDATE" class="btn btnPrimary">
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
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        @if(Session::has('message'))
            $('#message').toast('show');
        @endif
        $('#summernote').summernote({
                height: 200,                 // set editor height
                minHeight: null,             // set minimum height of editor
                maxHeight: null,             // set maximum height of editor
                focus: true                  // set focus to editable area after initializing summernote
        });
    });
</script>
@endsection