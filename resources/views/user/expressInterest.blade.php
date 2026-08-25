@extends('user.layouts.afterLoginLayout')

@section('pageCSS')
    
@endsection

<!-- Content Section Start -->
@section('content')
<!-- Page Header -->
<section class="inPageHeader">
    <div class="container">
        <h2 class="text-center">Express Interest</h2>
    </div>
</section>
<!-- /. Page Header -->

<!-- Express Interest Section -->
<section class="inHome mt-5">
    <div class="container">
        <div class="row">
             <!-- User home left panel -->
             @include('user.layouts.leftPanel')
            <!-- /.User home left panel -->
            
            <div class="col-lg-9 col-md-8">
                <ul class="nav nav-tabs nav-justified inPhotoTab" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link {{ $tab === 'received' ? 'active' : '' }}" href="{{ route('user.expressInterest', ['tab' => 'received']) }}" role="tab" aria-selected="{{ $tab === 'received' ? 'true' : 'false' }}">Express Interest - Received</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link {{ $tab === 'sent' ? 'active' : '' }}" href="{{ route('user.expressInterest', ['tab' => 'sent']) }}" role="tab" aria-selected="{{ $tab === 'sent' ? 'true' : 'false' }}">Express Interest - Sent</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade pt-4 pb-3 {{ $tab === 'received' ? 'show active' : '' }}" id="received-tab-pane" role="tabpanel" aria-labelledby="received-tab" tabindex="0">
                        @if(count($receiverpaginator))
                        @foreach ($receiverpaginator as $data)
                        <div class="card mb-3 inMainResultCard inPhotoReqCard inBorderColor1">
                            <div class="row g-0">
                               
                                <div class="col-xl-3 col-sm-3 col-lg-4">
                                    <a href="{{ route('user.memberProfile',$data['registerData']->matri_id) }}" class="text-decoration-none">
                                        @if(isset($data))
                                            @php
                                                $user = Auth::guard('user')->user();
                                                $site_configs = DB::table('site_configs')->first();
                                                $status = DB::table('expressinterests')->where('ei_sender',$user->matri_id)->where('ei_receiver',$data['registerData']->matri_id)->first();
                                            @endphp
                                            @php $filePath = '/userImages/'. $data['registerData']->photo1; @endphp
                                            
                                            @if($data['registerData']->photo1 != "" && $data['registerData']->photo1_approve == "APPROVED" && (($data['registerData']->photo_setting == '0') || ($data['registerData']->photo_setting == '1' && Auth::guard('user')->user()->status == 'Paid') || ($data['registerData']->photo_setting == '2' && $status->receiver_response == "Accept" )) && Storage::disk('public')->exists($filePath))
                                            <img src="{{asset('storage/userImages/'. $data['registerData']->photo1)}}" class="img-fluid rounded w-100">
                                            @elseif($data['registerData']->photo1 != ""  && $data['registerData']->gender == "Female" && $data['registerData']->photo1_approve == "PENDING" && Storage::disk('public')->exists($filePath))
                                                    <img src="{{asset('user/img/femalepending.jpg')}}" class="img-fluid rounded w-100">
                                            @elseif($data['registerData']->photo1 != ""  && $data['registerData']->gender == "Male" && $data['registerData']->photo1_approve == "PENDING" && Storage::disk('public')->exists($filePath))
                                                <img src="{{asset('user/img/malepending.jpg')}}" class="img-fluid rounded w-100">
                                            @else
                                                @if($data['registerData']->gender == "Male")
                                                    <img src="{{asset('user/img/male.jpg')}}" class="img-fluid rounded w-100">
                                                @else
                                                    <img src="{{asset('user/img/female.jpg')}}" class="img-fluid rounded w-100">
                                                @endif
                                            @endif
                                        @endif
                                    </a>
                                </div>
                                <div class="col-xl-9 col-sm-9 col-lg-8">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-xl-7">
                                                @if($siteconfig->username_setting == "full_username")
                                                    <h5 class="card-title">@if(isset($data['registerData']->firstname)){{$data['registerData']->firstname}}@endif @if(isset($data['registerData']->lastname)){{$data['registerData']->lastname}}@endif</h5>
                                                @elseif($siteconfig->username_setting == "first_surname")
                                                    <h5 class="card-title">@if(isset($data['registerData']->firstname)){{$data['registerData']->firstname}}@endif @if(isset($data['registerData']->lastname)){{substr($data['registerData']->lastname, 0, 1)}}@endif</h5>
                                                @else
                                                    <h5 class="card-title">@if(isset($data['registerData']->matri_id)){{$data['registerData']->matri_id}}@endif</h5>
                                                @endif
                                                
                                                <h6 class="mb-3">@if(isset($data['registerData']->matri_id)){{$data['registerData']->matri_id}}@endif &nbsp;&nbsp;|&nbsp;&nbsp; Profile Created by @if(isset($data['registerData']->profileby)){{$data['registerData']->profileby}}@else Not Available @endif</h6>
                                            </div>
                                           
                                            <div class="col-xl-5">
                                                <p class="card-text">
                                                    <small class="text-muted fw-normal">Received on @if(isset($data['expressInterest']->ei_sent_date)){{ \Carbon\Carbon::parse($data['expressInterest']->ei_sent_date)->format('h:iA, jS M Y')}}@endif</small>
                                                </p>
                                            </div>
                                           
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <p class="card-text">
                                                    <i class="fa-solid fa-inbox pe-2"></i>Express Interest Received.
                                                </p>
                                            </div>
                                        </div>
                                       
                                        <div class="row">
                                            <div class="col-lg-5 pt-4">
                                                <h4 class="inExpressStatus"><span class="pt-1">Status:</span><span class="badge ms-2 bgPrimary pt-2 pb-2">@if(isset($data['expressInterest']->receiver_response)){{$data['expressInterest']->receiver_response}}@endif</span></h4>
                                            </div>
                                            @if($data['expressInterest']->receiver_response == "Pending") 
                                            <div id="button{{$data['expressInterest']->id }}" class="col-lg-7 mt-3 text-lg-end">
                                                <a href="#" class="btn btnGreen  me-2 accept-btn" onclick="acceptbtn('{{ $data['expressInterest']->id }}')" data-id="{{ $data['expressInterest']->id }}">
                                                    <i class="fas fa-check text-white pe-2 font-15"></i><span class="">Accept</span>
                                                </a>
                                                <a href="#" class="btn btnRed reject-btn" onclick="rejectbtn('{{ $data['expressInterest']->id }}')" data-id="{{ $data['expressInterest']->id }}">
                                                    <i class="fas fa-times text-white pe-2 font-15"></i><span class="">Reject</span>
                                                </a>
                                                {{-- <a href="{{route('user')}}" class="btn btnGreen  me-2">
                                                    <i class="fas fa-check text-white pe-2 font-15"></i><span class="">Accept</span>
                                                </a>
                                                <a href="" class="btn btnRed">
                                                    <i class="fas fa-times text-white pe-2 font-15"></i><span class="">Reject</span>
                                                </a>  --}}
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <div class="d-flex justify-content-center">
                            {!! $receiverpaginator->links() !!}
                        </div>
                        @else
                        <img src="{{asset('user/img/nodata.jpg')}}" class="img-fluid rounded">
                        @endif
                    </div>
                    <div class="tab-pane fade pt-4 pb-3 {{ $tab === 'sent' ? 'show active' : '' }}" id="sent-tab-pane" role="tabpanel" aria-labelledby="sent-tab" tabindex="0">
                        @if(count($sentpaginator))
                        @foreach ($sentpaginator as $data)
                        <div class="card mb-3 inMainResultCard inPhotoReqCard inBorderColor1">
                            <div class="row g-0">
                                <div class="col-xl-3 col-sm-3 col-lg-4">
                                    <a href="{{ route('user.memberProfile',$data['registerData']->matri_id) }}" class="text-decoration-none">
                                        @if(isset($data))
                                            @php
                                                $user = Auth::guard('user')->user();
                                                $site_configs = DB::table('site_configs')->first();
                                                $status = DB::table('expressinterests')->where('ei_sender',$user->matri_id)->where('ei_receiver',$data['registerData']->matri_id)->first();
                                            @endphp
                                            @php $filePath = '/userImages/'. $data['registerData']->photo1; @endphp
                                            
                                            @if($data['registerData']->photo1 != "" && $data['registerData']->photo1_approve == "APPROVED" && (($data['registerData']->photo_setting == '0') || ($data['registerData']->photo_setting == '1' && Auth::guard('user')->user()->status == 'Paid') || ($data['registerData']->photo_setting == '2' && $status->receiver_response == "Accept" )) && Storage::disk('public')->exists($filePath))
                                            <img src="{{asset('storage/userImages/'. $data['registerData']->photo1)}}" class="img-fluid rounded w-100">
                                            @elseif($data['registerData']->photo1 != ""  && $data['registerData']->gender == "Female" && $data['registerData']->photo1_approve == "PENDING" && Storage::disk('public')->exists($filePath))
                                                    <img src="{{asset('user/img/femalepending.jpg')}}" class="img-fluid rounded w-100">
                                            @elseif($data['registerData']->photo1 != ""  && $data['registerData']->gender == "Male" && $data['registerData']->photo1_approve == "PENDING" && Storage::disk('public')->exists($filePath))
                                                <img src="{{asset('user/img/malepending.jpg')}}" class="img-fluid rounded w-100">
                                            @else
                                                @if($data['registerData']->gender == "Male")
                                                    <img src="{{asset('user/img/male.jpg')}}" class="img-fluid rounded w-100">
                                                @else
                                                    <img src="{{asset('user/img/female.jpg')}}" class="img-fluid rounded w-100">
                                                @endif
                                            @endif
                                        @endif
                                    </a>
                                </div>
                                <div class="col-xl-9 col-sm-9 col-lg-8">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-xl-7">
                                                @if($siteconfig->username_setting == "full_username")
                                                    <h5 class="card-title">@if(isset($data['registerData']->firstname)){{$data['registerData']->firstname}}@endif @if(isset($data['registerData']->lastname)){{$data['registerData']->lastname}}@endif</h5>
                                                @elseif($siteconfig->username_setting == "first_surname")
                                                    <h5 class="card-title">@if(isset($data['registerData']->firstname)){{$data['registerData']->firstname}}@endif @if(isset($data['registerData']->lastname)){{substr($data['registerData']->lastname, 0, 1)}}@endif</h5>
                                                @else
                                                    <h5 class="card-title">@if(isset($data['registerData']->matri_id)){{$data['registerData']->matri_id}}@endif</h5>
                                                @endif
                                                
                                                <h6 class="mb-3">@if(isset($data['registerData']->matri_id)){{$data['registerData']->matri_id}}@endif &nbsp;&nbsp;|&nbsp;&nbsp; Profile Created by @if(isset($data['registerData']->profileby)){{$data['registerData']->profileby}}@else Not Available @endif</h6>
                                            </div>
                                            <div class="col-xl-5">
                                                <p class="card-text">
                                                    <small class="text-muted fw-normal">sent on @if(isset($data['expressInterest']->ei_sent_date)){{ \Carbon\Carbon::parse($data['expressInterest']->ei_sent_date)->format('h:iA, jS M Y')}}@endif</small>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <p class="card-text">
                                                    <i class="fa-solid fa-paper-plane pe-2"></i>Express Interest Sent.
                                                </p>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-lg-5 pt-4">
                                                <h4 class="inExpressStatus"><span class="pt-1">Status:</span><span class="badge ms-2 bgPrimary pt-2 pb-2">@if(isset($data['expressInterest']->receiver_response)){{$data['expressInterest']->receiver_response}}@endif</span></h4>
                                            </div>
                                            <div class="col-lg-7 mt-3 text-lg-end" id="delete{{$data['expressInterest']->id }}">
                                                <a href="#" class="btn btnRed me-2 reject-btn" onclick="deletebtn('{{ $data['expressInterest']->id }}')" data-id="{{ $data['expressInterest']->id }}">
                                                <i class="fas fa-trash text-white pe-2 font-15"></i><span class="">Delete</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <div class="d-flex justify-content-center">
                            {!! $sentpaginator->links() !!}
                        </div>
                        @else
                        <img src="{{asset('user/img/nodata.jpg')}}" class="img-fluid rounded">
                        @endif
                    </div>
                </div>        
            </div>
        </div>
    </div>
</section>
@endsection

@section('pageJS')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const receivedTab = document.getElementById('received-tab-link');
        const sentTab = document.getElementById('sent-tab-link');

        receivedTab.addEventListener('click', function(event) {
            sentTab.classList.remove('active');
            receivedTab.classList.add('active');
        });

        sentTab.addEventListener('click', function(event) {
            receivedTab.classList.remove('active');
            sentTab.classList.add('active');
        });
    });
</script>
<script>
    // AJAX call for Accept button
    function acceptbtn(id){
        $.ajax({
            url: "{{route('user.expressInterestAccept')}}",
            type: 'post',
            data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
            success: function(response) {
                $("#button" + id).hide();
            },
            error: function(xhr) {
            }
        });
    };

    // AJAX call for Reject button
    function rejectbtn(id){
        $.ajax({
            url: "{{route('user.expressInterestReject')}}",
            type: 'post',
            data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
            success: function(response) {
                $("#button" + id).hide();
            },
            error: function(xhr) {
            }
        });
    };

    function deletebtn(id){
        $.ajax({
            url: "{{route('user.expressInterestDelete')}}",
            type: 'post',
            data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
            success: function(response) {
                $("#delete" + id).hide();
            },
            error: function(xhr) {
            }
        });
    };
</script>
<script>
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
</script>

@endsection