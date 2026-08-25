@extends('user.layouts.afterLoginLayout')

@section('pageCSS')
    
@endsection

<!-- Content Section Start -->
@section('content')

<!-- Page Header -->
<section class="inPageHeader">
    <div class="container">
        <h2 class="text-center">Current Plan</h2>
    </div>
</section>
<!-- /.Page Header -->

<!-- Home Section -->
<section class="inHome mt-5">
    <div class="container">
        <div class="row">
            
            @include('user.layouts.leftPanel')
                
            <div class="col-lg-9 col-md-8 inMembershipCard">
                <?php 
                    $today = \Carbon\Carbon::now()->format('d-m-Y');
                    $date = "";
                    if(isset($payment)) {
                        $date = \Carbon\Carbon::createFromFormat('d-m-y', $payment->exp_date)->format('d-m-Y');
                    }
                    $today = strtotime($today);
                    $date = strtotime($date);
                ?>
                
                @if($date >= $today)
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-4 text-center text-sm-start mb-3 inHomePlanExpiry">
                                    <h2 class="inPlanPrice pt-4 pb-2">@if(isset($payment->p_plan)){{$payment->p_plan}}@endif</h2>
                                    <?php
                                        if(isset($payment->exp_date)) {
                                            $date = \Carbon\Carbon::createFromFormat('d-m-y', $payment->exp_date)->format('jS F Y');
                                        }
                                    ?>
                                    <p>Plan Expiry Date - <span>@if(isset($date)){{$date}}@endif</span></p>
                                </div>
                                <div class="col-xl-8 mb-3 mb-sm-0 text-center text-sm-start">
                                    <div class="row">
                                        <div class="col-xl-4 mb-2 mb-sm-0">
                                            <h6 class="inPlanDes">Duration</h6>
                                            <h4 class="inPlanValue">@if(isset($payment->plan_duration)){{$payment->plan_duration}}@endif Days</h4>
                                            <h6 class="inPlanDes">Remaining</h6>
                                            <?php
                                                $currentDate = \Carbon\Carbon::now();
                                                if(isset($payment->exp_date)) {
                                                    $targetDate  = \Carbon\Carbon::createFromFormat('d-m-y', $payment->exp_date);
                                                }
                                            ?>
                                            <h4 class="inPlanValue text-danger">@if(isset($targetDate)){{ abs(round($targetDate->diffInDays($currentDate))) }}@endif Days</h4>
                                        </div>
                                        <div class="col-xl-4 mb-2 mb-sm-0">
                                            <h6 class="inPlanDes">Contact View</h6>
                                            <h4 class="inPlanValue">@if(isset($payment->p_no_contacts)){{$payment->p_no_contacts}}@endif</h4>
                                            <h6 class="inPlanDes">Remaining</h6>
                                            <?php
                                                if(isset($payment->p_no_contacts) && isset($payment->r_cnt)) {
                                                    $remaining = $payment->p_no_contacts - $payment->r_cnt;
                                                    if($remaining < 0) $remaining = 0;
                                                } else {
                                                    $remaining = $payment->p_no_contacts ?? 0;
                                                }
                                            ?>
                                            <h4 class="inPlanValue text-danger">{{$remaining}}</h4>
                                        </div>
                                        <div class="col-xl-4 mb-2 mb-sm-0">
                                            <h6 class="inPlanDes">Live Chat</h6>
                                            <h4 class="inPlanValue">@if(isset($payment->chat)){{$payment->chat}}@endif</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="card mb-4">
                        <div class="card-body">
                            <p>Please Upgrade Your Membership Plan</p>
                        </div>
                    </div>
                @endif
                
                <section class="inPageHeader">
                    <div class="container">
                        <h2 class="text-center">Plan Purchase History</h2>
                    </div>
                </section>

            </div>
        </div>
    </div>
</section>
@endsection

@section('pageJS')
    @include('user.layouts.resultActionBtnJs')
@endsection
