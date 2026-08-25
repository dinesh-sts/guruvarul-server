@extends('user.layouts.afterLoginLayout')

@section('pageCSS')
    
@endsection

<!-- Content Section Start -->
@section('content')
<section class="inPageHeader">
    <div class="container">
        <h2 class="text-center">Block Profiles</h2>
    </div>
</section>
<section class="inHome mt-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-4">
                <!-- Profile Details Panel -->
                @include('user.layouts.profileLeftPanel')
                <!-- /. Profile Details Panel -->
            </div>
            <div class="col-lg-9 col-md-8">
                @if(count($blocklist) == 0)
                    <img src="{{asset('user/img/nodata.jpg')}}" class="img-fluid rounded">
                @else
                    @foreach ($blocklist as $block)
                    @foreach ($block as $data)
                    <div class="card mb-3 inMainResultCard inBorderColor1">
                        <div class="row g-0">
                            <div class="col-lg-4">
                                <a href="" class="text-decoration-none">
                                    @if(isset($data))
                                    <?php  $filePath = '/userImages/'.$data->photo1; ?>
                                        @if($data->photo1 != "" && $data->photo1_approve == "APPROVED" && Storage::disk('public')->exists($filePath))
                                            <img src="{{asset('storage/userImages/'.$data->photo1)}}" class="img-fluid rounded maxH-250">
                                        @else
                                            @if($data->gender == "Male")
                                                <img src="{{asset('user/img/male.jpg')}}" class="img-fluid rounded maxH-250">
                                            @else
                                                <img src="{{asset('user/img/female.jpg')}}" class="img-fluid rounded maxH-250">
                                            @endif
                                        @endif
                                    @endif
                                </a>
                            </div>
                            <div class="col-lg-8">
                                <div class="card-body">
                                <a href="" class="text-decoration-none">
                                        <h5 class="card-title">@if(isset($data->firstname)){{$data->firstname}}@endif @if(isset($data->lastname)){{$data->lastname}}({{$data->matri_id}})@else {{$data->matri_id}} @endif</h5>
                                        <h6 class="mb-3">@if(isset($data->matri_id)){{$data->matri_id}}@endif &nbsp;&nbsp;|&nbsp;&nbsp; Profile Created by @if(isset($data->profileby)){{$data->profileby}}@else Not Available @endif</h6>
                                    </a>
                                    <div class="row mt-4 inMainResultAction mt-lg-2 mt-xl-4">
                                        <div class="col text-center">
                                            <a href="{{route('user.Unblock',$data->matri_id)}}">
                                                <i class="fas fa-ban"></i>
                                                <p>UnBlock</p>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endforeach
                    <div class="d-flex justify-content-center">
                        {!! $blocklist->links() !!}
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@include('user.layouts.searchResultActionToast')
@endsection

@section('pageJS')

    @include('user.layouts.resultActionBtnJs')
    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>
@endsection