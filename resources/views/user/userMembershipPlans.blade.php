@extends('user.layouts.afterLoginLayout')

@section('pageCSS')
    
@endsection

<!-- Content Section Start -->
@section('content')
<!-- Page Header -->
<section class="inPageHeader">
    <div class="container">
        <h2 class="text-center">Membership Plans</h2>
    </div>
</section>
<!-- /.Page Header -->

<!-- Membership Plans -->
<section class="inMembershipCard mb-5">
    <div class="container">
        <div class="row">
            <div class="col-xl-10 offset-xl-1">
                @foreach ($memberships as $membership)
                
                @if($membership->only_for != NULL )
                <h5 class="inMembershipOnlyFor"><i class="fas fa-user pe-2"></i>{{ $membership->only_for }} Only Plan</h5>
                @endif
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-4 mb-3 mb-sm-0 text-center text-sm-start">
                                <h4 class="inPlanName">@if(isset($membership->plan_name)){{$membership->plan_name}}@endif</h4>
                                <h2 class="inPlanPrice">@if(isset($membership->currency)){{$membership->currency}} @endif @if(isset($membership->plan_amount)){{$membership->plan_amount}}@endif/-</h2>
                            </div>
                            <div class="col-xl-6 mb-3 mb-sm-0 text-center text-sm-start">
                                <div class="row">
                                    <div class="col-xl-4 col-4 mb-2 mb-sm-0">
                                        <h6 class="inPlanDes">Duration</h6>
                                        <h4 class="inPlanValue">@if(isset($membership->plan_duration)){{$membership->plan_duration}}@endif Days</h4>
                                    </div>
                                    <div class="col-xl-4 col-4 mb-2 mb-sm-0">
                                        <h6 class="inPlanDes">Contact View</h6>
                                        <h4 class="inPlanValue">@if(isset($membership->plan_contacts)){{$membership->plan_contacts}}@endif</h4>
                                    </div>
                                    <div class="col-xl-4 col-4 mb-2 mb-sm-0">
                                        <h6 class="inPlanDes">Live Chat</h6>
                                        <h4 class="inPlanValue">@if(isset($membership->chat)){{$membership->chat}}@endif</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2">
                               <a href="{{route('user.paymentOptions',$membership->id)}}" class="btn btnPrimary d-block mt-2">PURCHASE</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection

@section('pageJS')


@endsection
