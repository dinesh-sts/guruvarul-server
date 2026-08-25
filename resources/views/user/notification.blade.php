@extends('user.layouts.afterLoginLayout')

@section('pageCSS')
    
@endsection

<!-- Content Section Start -->
@section('content')
<section class="inPageHeader">
    <div class="container">
        <h2 class="text-center">Notification</h2>
    </div>
</section>
<section class="inHome mt-5">
    <div class="container">
        <div class="row">
            @include('user.layouts.leftPanel')
           
                <div class="col-lg-9 col-md-8">
                    <div class="text-end mb-3">
                        <a href="{{route('user.markread')}}" class="btn btnSecondary inNotificationMarkBtn">Mark all as readed</a>
                    </div>
                    @if(isset($paginator))
                    @if(count($paginator) == 0)
                        <img src="{{asset('user/img/nodata.jpg')}}" class="img-fluid rounded">
                    @else
                        @foreach ($paginator as $data)
                        <div class="card mb-3 inNotification @if($data['notify'] == "0") inBorderColor1 @else inBorderColor1  @endif">
                            <a href="@if(isset($data['notify']->notification))@if($data['notify']->notification_type == 'Message'){{ route('user.message') }}@elseif($data['notify']->notification_type == 'Express Interest'){{ route('user.expressInterest',['tab' => 'received']) }}@else{{ route('user.memberProfile',$data['registerData']->matri_id) }} @endif @endif" class="card-body text-decoration-none">
                                <div class="row">
                                    <div class="col-xl-2">
                                        <?php  $filePath = '/userimages/'.$data['registerData']->photo1; ?>
                                        @if($data['registerData']->photo1 != "" && $data['registerData']->photo1_approve == "APPROVED" && Storage::disk('public')->exists($filePath))
                                            <img src="{{asset('storage/userimages/'.$data['registerData']->photo1)}}"class="img-fluid avtar60">
                                        @else
                                            @if($data['registerData']->gender == "Male")
                                                <img src="{{asset('user/img/male.jpg')}}" class="img-fluid avtar60">
                                            @else
                                                <img src="{{asset('user/img/female.jpg')}}" class="img-fluid avtar60">
                                            @endif
                                        @endif
                                    
                                    </div>
                                    <div class="col-xl-10">
                                        <h5 class="">@if(isset($data['notify']->notification)){{$data['notify']->notification}}@endif <span class="colorPrimary">@if(isset($data['registerData']->firstname)){{$data['registerData']->firstname}}@endif @if(isset($data['registerData']->lastname)){{substr($data['registerData']->lastname,0,1)}} ({{$data['registerData']->matri_id}})@else {{$data['registerData']->matri_id}} @endif</span>.</h5>
                                        <p class="mb-0"> @if(isset($data['notify']->date)){{ \Carbon\Carbon::parse($data['notify']->date)->format('h:iA, jS M Y')}}@endif</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                        <div class="d-flex justify-content-center">
                            {!! $paginator->links() !!}
                        </div>
                    @endif
                    @else
                    <img src="{{asset('user/img/nodata.jpg')}}" class="img-fluid rounded">
                    @endif
                </div>
        </div>
    </div>

</section>

@endsection

@section('pageJS')

    @include('user.layouts.resultActionBtnJs')

@endsection