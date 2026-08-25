@extends('user.layouts.afterLoginLayout')

@section('pageCSS')
    
@endsection

<!-- Content Section Start -->
@section('content')
<section class="inPageHeader">
    <div class="container">
        <h2 class="text-center">I Visited Profile</h2>
        <!--<p class="text-center">Edit your profile details is easy just update details  and click on update button that's it.</p>-->
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
                @if(count($visitlist) == 0)
                <img src="{{asset('User/img/nodata.jpg')}}" class="img-fluid rounded">
                @else
                    @foreach ($visitlist as $visit)
                        @foreach ($visit as $data)
                            @include('user.layouts.profileDetailsCard')
                        @endforeach
                    @endforeach
                    <div class="d-flex justify-content-center">
                        {!! $visitlist->links() !!}
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