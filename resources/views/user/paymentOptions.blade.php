@extends('user.layouts.afterLoginLayout')

@section('pageCSS')
    
@endsection

<!-- Content Section Start -->
@section('content')
<!-- Page Header -->
<section class="inPageHeader">
    <div class="container">
        <h2 class="text-center">Payment Options</h2>
    </div>
</section>
<!-- Page Header -->

<section class="inPaymentOption mb-5">
    <div class="container">
        <div class="row">
            <div class="col-xl-8 offset-xl-2 p-5 p-sm-0">
                <!-- Cart -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-4 mb-3 mb-sm-0 text-center text-sm-start">
                                <h4 class="inPlanName">@if(isset($membership->plan_name)){{$membership->plan_name}}@endif</h4>
                                <h2 class="inPlanPrice">Rs.@if(isset($membership->plan_amount)){{$membership->plan_amount}}@endif/-</h2>
                            </div>
                            <div class="col-xl-8 mb-3 mb-sm-0 text-center text-sm-start">
                                <div class="row">
                                    <div class="col-xl-4 mb-2 mb-sm-0">
                                        <h6 class="inPlanDes">Duration</h6>
                                        <h4 class="inPlanValue">@if(isset($membership->plan_duration)){{$membership->plan_duration}}@endif Days</h4>
                                    </div>
                                    <div class="col-xl-4 mb-2 mb-sm-0">
                                        <h6 class="inPlanDes">Contact View</h6>
                                        <h4 class="inPlanValue">@if(isset($membership->plan_contacts)){{$membership->plan_contacts}}@endif</h4>
                                    </div>
                                    <div class="col-xl-4 mb-2 mb-sm-0">
                                        <h6 class="inPlanDes">Live Chat</h6>
                                        <h4 class="inPlanValue">@if(isset($membership->chat)){{$membership->chat}}@endif</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.Cart -->
                @php
                    $user = Auth::guard('user')->user();
                @endphp

                <div class="container">
                    <div class="row mb-4">
                        <!-- Uploaded Payment Proof -->
                        <div class="col-md-6 text-center">
                            @if(!empty($user->payment_image))
                                <h5>Your Uploaded Payment Proof</h5>
                                <img src="{{ asset('storage/' . $user->payment_image) }}" 
                                    alt="Payment Proof" 
                                    class="img-fluid rounded shadow"
                                    style="max-width: 300px;">
                            @else
                                <p>No payment proof uploaded yet.</p>
                            @endif
                        </div>

                        <!-- QR Code -->
                        <div class="col-md-6 text-center">
                            <h5>Scan to Pay</h5>
                            <img src="{{ Storage::url('manualPaymentImg/qr-code.png') }}" 
                                alt="QR Code" 
                                class="img-fluid rounded shadow"
                                style="max-width: 250px;">
                            <p class="mt-2">Scan the QR code to make your payment</p>
                        </div>
                    </div>

                    <!-- Payment Form -->
                    <h4 class="inPaymentTitle mt-2 mb-4 borderBottomPrimary1 text-center">Upload your payment details</h4>

                    <form action="{{ route('payment.upload') }}" method="POST" enctype="multipart/form-data" class="shadow p-4 rounded bg-light">
                        @csrf

                        <!-- Full Name -->
                        <div class="mb-3">
                            <label for="full_name" class="form-label">Full Name (As per Aadhaar)</label>
                            <input type="text" name="full_name" id="full_name" class="form-control" 
                                value="{{ old('full_name') }}" required>
                            @error('full_name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Aadhaar Number -->
                        <div class="mb-3">
                            <label for="aadhaar_number" class="form-label">Aadhaar Number</label>
                            <input type="text" name="aadhaar_number" id="aadhaar_number" class="form-control" 
                                value="{{ old('aadhaar_number') }}" required maxlength="12">
                            @error('aadhaar_number')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Payment Proof -->
                        <div class="mb-3">
                            <label for="payment_image" class="form-label">Upload Payment Proof (Image)</label>
                            <input type="file" name="payment_image" id="payment_image" class="form-control" 
                                accept="image/*" required>
                            @error('payment_image')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary px-5">Submit Payment Details</button>
                        </div>
                    </form>
                </div>


                
            </div>
        </div>
    </div>
</section>


@endsection

@section('pageJS')


@endsection
