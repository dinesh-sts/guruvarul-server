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
                
                <!-- Payment Options -->
                <h4 class="inPaymentTitle mt-2 mb-4 borderBottomPrimary1">Select Payment Method</h4>
                <div class="row">
                    @php
                        $amount = $membership->plan_amount;
                        $amount = $amount*100;
                        $authuser = Auth::guard('user')->user();
                    @endphp
                    @if(isset($razorpay->pay_name))
                        @if($razorpay->status == "APPROVED")
                        <div class="col-xl-4 col-sm-6 col-12 paymentOptionCard mb-4">
                            <div class="card shadow-sm">
                                <img src="{{asset('user/img/payment-logo/razorpay.png')}}" class="card-img-top ps-4 pe-4 pt-3 pb-3 bg-light">
                                <div class="card-body ps-1 pe-1 pt-34">
                                    <form action="{{ route('razorpay.payment.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" id="name" name="name" value="{{ $authuser->firstname }} {{ $authuser->lastname }}" >
                                        <input type="hidden" id="email" name="email" value="{{ $authuser->email }}">
                                        <script
                                            src="https://checkout.razorpay.com/v1/checkout.js"
                                            data-key="{{ $razorpay->razorpay_key }}"
                                            data-amount="{{ $amount }}"
                                            data-buttontext="Pay Via Razorpay"
                                            data-name="{{ $siteConfig->web_name }}"
                                            data-description="@if(isset($membership->plan_name)){{$membership->plan_name}}@endif"
                                            data-image="{{ asset('storage/siteConfig/'.$siteConfig->web_logo_path) }}"
                                            data-email="{{ $authuser->email }}"
                                            data-mobile="{{ $authuser->mobile }}"
                                            data-theme.color="#932c8b"
                                        ></script>
                                        <input type="hidden" name="plan_id" value="{{ $membership->id }}">
                                    </form>
                                </div>
                            </div>  
                        </div>
                        @endif
                    @endif

                    @if(isset($payumoney->pay_name))
                        @if($payumoney->status == "APPROVED")
                        <a class="col-xl-4 col-sm-6 col-12 paymentOptionCard mb-4" href="{{ route('pay.u',$membership) }}">
                            <div class="card shadow-sm">
                                <img src="{{asset('user/img/payment-logo/payumoney.png')}}" class="card-img-top ps-4 pe-4 pt-3 pb-3 bg-light">
                                <div class="card-body ps-1 pe-1">
                                    <h5>Pay With Payumoney</h5>
                                </div>
                            </div>
                        </a>
                        @endif
                    @endif

                    @if(isset($manualPayment->pay_name))
                        @if($manualPayment->status == "APPROVED")
                        <a class="col-xl-4 col-sm-6 col-12 paymentOptionCard mb-4" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions1" aria-controls="offcanvasScrolling" >
                            <div class="card shadow-sm">
                                <img src="{{ asset('user/img/payment-logo/manual_payment.png') }}" class="card-img-top ps-4 pe-4 pt-3 pb-3 bg-light">
                                <div class="card-body ps-1 pe-1">
                                    <h5>{{ $manualPayment->pay_name }}</h5>
                                </div>
                            </div>
                        </a>
                        <!-- Manual Payment Off Canvas -->
                        <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions1" aria-labelledby="offcanvasWithBothOptionsLabel">
                            <div class="offcanvas-header">
                                <h5 class="offcanvas-title" id="offcanvasWithBothOptionsLabel">{{ $manualPayment->pay_name }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body">
                                <div class="col-xl-12 m-auto">
                                    <img src="{{ asset('storage/manualPaymentImg/'.$manualPayment->qr_code) }}" class="img-fluid max-25 rounded">
                                </div>
                                <div class="col-12 mt-3 ">
                                    {!! $manualPayment->manual_payment_message !!}
                                </div>
                            </div>
                        </div>
                        <!-- /.Manual Payment Off Canvas -->
                        @endif
                    @endif
                </div>
                
                <!-- /.Payment Options -->
                
            </div>
        </div>
    </div>
</section>


@endsection

@section('pageJS')


@endsection