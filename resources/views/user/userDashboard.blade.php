@extends('user.layouts.afterLoginLayout')

@section('pageCSS')
    
@endsection

<!-- Content Section Start -->
@section('content')
<section class="inHome mt-5">
    <div class="container">
        <?php $user_id = Auth::guard('user')->user();  ?>
        <div class="row">

            <!-- User home left panel -->
            @include('user.layouts.leftPanel')
            <!-- /.User home left panel -->

            <div class="col-lg-9 col-md-8">
                
                <!-- Hidden in small screen only -->
                @if($siteconfig->username_setting == "full_username")
                    <h2 class="inDashHello mb-3 d-none d-md-block">Hello,&nbsp;<small>@if(isset($user_id->firstname)){{$user_id->firstname}}@endif @if(isset($user_id->lastname)){{$user_id->lastname}} ({{$user_id->matri_id}})@else {{$user_id->matri_id}} @endif</small></h2>
                @elseif($siteconfig->username_setting == "first_surname")
                    <h2 class="inDashHello mb-3 d-none d-md-block">Hello,&nbsp;<small>@if(isset($user_id->firstname)){{$user_id->firstname}}@endif @if(isset($user_id->lastname)){{substr($user_id->lastname, 0, 1)}} ({{$user_id->matri_id}})@else {{$user_id->matri_id}} @endif</small></h2>
                @else
                    <h2 class="inDashHello mb-3 d-none d-md-block">Hello,&nbsp;<small>@if(isset($user_id->matri_id)){{$user_id->matri_id}}@endif</small></h2>
                @endif
                <!-- /.Hidden in small screen only -->
                
                <!-- Profile Verification Alert -->
                @if($user_id->cpass_status != "Yes")
                <!--<div class="row inDashActiveProfile mb-2">
                    <div class="col-xl-12">
                       <div class="alert alert-primary">
                            <p class="mb-0">Your email id verification is pending! Please verify your email to get better response<a href="{{ route('user.varifyloginemail') }}" class="btn btnSecondary ms-sm-3 ms-3 mt-2 mt-sm-0">Verify Now</a></p>
                        </div>
                    </div>
                </div>-->
                @endif
                <!-- /.Profile Verification Alert -->
		<!-- /.Profile Verification Alert -->
                <!-- 
                <div class="row mb-6">
                    <div class="col-xl-12 mb-6">
                        <div class="card inDashProfileMeter">
                            <div class="card-body">
                                <h5>Profile is {{$profileCompleteness}}% complete.</h5>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-label="Animated striped example" aria-valuenow="{{$profileCompleteness}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$profileCompleteness}}%"></div> 
                                </div>
                                @if($profileCompleteness == 100)
                                <p class="mb-0">Your Profile Is Done</p>
                                @else
                                <p class="mb-0">Fill all details will increase your chance to get better match.</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6 mb-3">
                        <div class="card inDashMatriSearch">
                            <div class="card-body pt-3 pb-3">
                                <label class="mb-1">Matrimony Id Search</label>
                                <form id="Memberidsearch">
                                <div class="row">
                                    <div class="col-xl-8 col-8">
                                        <input type="text" class="form-control" name="member_id" placeholder="Enter Matrimony id">
                                    </div>
                                    <div class="col-xl-4 col-4">
                                        <button type="submit" id="submit" value="SEARCH" class="btn btnPrimary d-block w-100">SEARCH</button>
                                    </div>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div> 
                </div>-->
                @if(count($recentlyjoin) != 0)
                <!-- Recently Joined Section -->
                <div class="row mb-3 inDashProfile">
                    <div class="col-xl-12 pt-2 pb-3">
                        <div class="row">
                            <div class="col-xl-8 col-7">
                                <h4 class="inDashTitle">Recently Joined Profiles</h4>
                            </div>
                            @if($recentlyjoin->count() >= 4)
                                <div class="col-xl-4 col-5 text-end">
                                    <a href="{{ route('user.recentelyJoinedProfiles') }}" class="btn btnPrimary inDashAllBtn">VIEW ALL</a>
                                </div>
                            @endif
                        </div>
                    </div>
                    @foreach ($recentlyjoin as $data)
                        <!-- Small profile result -->
                        @include('user.layouts.profileResultSmall')
                        <!-- /. Small profile result -->
                    @endforeach
                </div>
                @endif
                <!-- /.Recently Joined Section -->

                <!-- Current Membership Plan Section -->
                @if($membershipplan != null)
                <?php
                    $today = \Carbon\Carbon::now()->format('d-m-Y') ;
                    $expdate = \Carbon\Carbon::createFromFormat('d-m-y', $membershipplan->exp_date)->format('d-m-Y'); 
                    $today = strtotime(date($today));
                    $date = strtotime(date($expdate)); 
                ?>

                @if($date >= $today)
                <div class="row mb-5">
                    <div class="col-xl-12">
                        <div class="card inHomeMemCard">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-12 mb-3">
                                        <div class="row">
                                            <div class="col-xl-8 col-lg-6 col-12 inHomePlanName">
                                                <h4>Current Plan - <span>@if(isset($membershipplan->p_plan)){{$membershipplan->p_plan}}@endif</span></h4>
                                            </div>
                                            <div class="col-xl-4 col-lg-6 text-lg-end inHomePlanExpiry">
                                                <p>Plan Expiry Date - <span>
                                                @if(isset($expdate)){{ \Carbon\Carbon::parse($expdate)->format('jS M Y')}}@endif</span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-4 mb-2 mb-sm-3">
                                        <h6 class="inPlanDes">Duration</h6>
                                        <h4 class="inPlanValue">@if(isset($membershipplan->plan_duration)){{$membershipplan->plan_duration}}@endif Days</h4>
                                    </div>
                                    <div class="col-xl-3 col-4 mb-2 mb-sm-3">
                                        <h6 class="inPlanDes">Contact View</h6>
                                        <h4 class="inPlanValue">@if(isset($membershipplan->p_no_contacts)){{$membershipplan->p_no_contacts}}@endif</h4>
                                    </div>
                                    <div class="col-xl-3 col-4 mb-2 mb-sm-3">
                                        <h6 class="inPlanDes">Live Chat</h6>
                                        <h4 class="inPlanValue">@if(isset($membershipplan->chat)){{$membershipplan->chat}}@endif</h4>
                                    </div>
                                    <div class="col-xl-3">
                                        <a href="{{ route('user.userMembershipPlans') }}" class="btn btnPrimary d-block mt-3 mt-sm-0">UPGRADE NOW</a>
                                    </div>
                                </div>
                            </div>   
                        </div>
                    </div>
                </div>
                @endif
                @endif
                <!-- /.Current Membership Plan Section -->
    
                <!-- Featured Profile Section -->
                <div class="row mb-3 inDashProfile">
                    <div class="col-xl-12 pt-2 pb-3">
                        <div class="row">
                            <div class="col-xl-8 col-7">
                                <h4 class="inDashTitle">Featured Profile</h4>
                            </div>
                            @if($featured->count() >= 4)
                            <div class="col-xl-4 col-5 text-end">
                                <a href="{{ route('user.featuredProfiles') }}" class="btn btnPrimary inDashAllBtn">VIEW ALL</a>
                            </div>
                            @endif
                        </div>
                    </div>
                    @if(count($featured) == 0)
                    <img src="{{asset('user/img/nodata.jpg')}}" class="img-fluid w-50">
                    @else 
                    @foreach ($featured as $data)
                        <!-- Small profile result -->
                        @include('user.layouts.profileResultSmall')
                        <!-- /. Small profile result -->
                    @endforeach
                    @endif
                </div>
               
                <!-- /.Featured Profile Section -->
               
                <!-- My Profile Viewed By Profile Section -->
                <div class="row mb-3 inDashProfile">
                    <div class="col-xl-12 pt-2 pb-3">
                        <div class="row">
                            <div class="col-xl-8 col-7">
                                <h4 class="inDashTitle">My Profile Viewed By</h4>
                            </div>
                            @if($profileview->count() >= 4)
                                <div class="col-xl-4 col-5 text-end">
                                    <a href="{{route('user.myProfileViewedBy')}}" class="btn btnPrimary inDashAllBtn">VIEW ALL</a>
                                </div>
                            @endif
                        </div>
                    </div>
                    @if(count($profileview) == 0)
                    <img src="{{asset('user/img/nodata.jpg')}}" class="img-fluid w-50">
                    @else 
                    @foreach ($profileview as $data)
                        <!-- Small profile result -->
                        @include('user.layouts.profileResultSmall')
                        <!-- /. Small profile result -->
                    @endforeach
                    @endif
                </div>
                <!-- /.My Profile Viewed By Profile Section -->
                
            </div>
        </div>
    </div>
    

    <div class="toast-container position-fixed position-static bottom-0 end-0 p-3 mb-5 mb-sm-0">
        <div id="sendintrest" class="toast inToastExpress" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
            <div class="d-flex">
                <div class="toast-body">
                    <strong class="me-auto">Express Interest Sent Successfully.</strong>
                </div>
                <button type="button" class="btn-close me-2 m-auto bg-white p-1" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
        <div id="login" class="toast inToastExpress" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
            <div class="d-flex">
                <div class="toast-body">
                    <strong class="me-auto">{{ Session::get('message') }}</strong>
                </div>
                <button type="button" class="btn-close me-2 m-auto bg-white p-1" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
        <div id="messagebox" class="toast inToastExpress" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
            <div class="d-flex">
                <div class="toast-body">
                    <strong class="me-auto">Please Upgrade Your Membership Plan</strong>
                </div>
                <button type="button" class="btn-close me-2 m-auto bg-white p-1" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
    
</section>
@endsection

@section('pageJS')

<!-- Send interest Ajax -->
<script>
    function sendintrest(matri_id){
        var registerId = matri_id;
        $.ajax({
            url: "{{ route('user.intereststore') }}",
            type: "POST",
            data: {
                register_id: registerId,
                _token: '{{ csrf_token() }}'
            },
            dataType: 'json',
            success: function (result) {
                $("#interestshow" + registerId).hide();
                $('#sendintrest').toast('show');
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }
</script>
<!-- /. Send interest Ajax -->

<script>
    $(document).ready(function () {
        @if(Session::has('message'))
            $('#login').toast('show');
        @endif
        // Delete temparery chat thubmnail
        var currentURL = window.location.href;
        if (currentURL.includes('{{ route("user.message") }}')) {
        
        }else{
            fetch('{{ route("delete.record") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                })
            })
            .then(response => {
                if (response.ok) {
                    console.log('Success');
                } else {
                    console.error('Failed');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        // Matri id search ajax
        $('#Memberidsearch').submit(function(e) {
            e.preventDefault(); 
            var formData = $(this).serialize(); 
            $.ajax({
                type: 'POST',
                url: "{{ route('user.searchResult') }}",
                data: {
                    formData,
                    _token: '{{csrf_token()}}'
                },
                success: function(result) {
                    $('#result').html(result);
                    var redirectUrl = "{{ route('user.searchResultView') }}";
                    window.location.href = redirectUrl;
                    },
                    error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
    });
</script>
@endsection
