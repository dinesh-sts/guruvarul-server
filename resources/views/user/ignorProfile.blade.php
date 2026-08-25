@extends('user.layouts.afterLoginLayout')

@section('pageCSS')
    
@endsection

<!-- Content Section Start -->
@section('content')
<section class="inPageHeader">
    <div class="container">
        <h2 class="text-center">Ignored Profiles</h2>
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
                @if(count($ignorelist) == 0)
                <img src="{{asset('user/img/nodata.jpg')}}" class="img-fluid rounded">
                @else
                    @foreach ($ignorelist as $ignore)
                        @foreach ($ignore as $data)
                        @include('user.layouts.profileDetailsCard')
                        @endforeach
                    @endforeach
                    <div class="d-flex justify-content-center">
                        {!! $ignorelist->links() !!}
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