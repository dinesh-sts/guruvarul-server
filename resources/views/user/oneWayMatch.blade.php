@extends('user.layouts.afterLoginLayout')

@section('pageCSS')
    
@endsection

<!-- Content Section Start -->
@section('content')

<!-- Page Header -->
<section class="inPageHeader">
    <div class="container">
        <h2 class="text-center">One Way Matching Profile</h2>
    </div>
</section>
<!-- /. Page Header -->

<section class="inHome mt-5">
    <div class="container">
        <div class="row">
            @include('user.layouts.matchLeftPanel')
     
            <div class="col-lg-9 col-md-8">
                @foreach ($oneway as $data)
                    @include('user.layouts.profileDetailsCard')
                @endforeach
                <div class="d-flex justify-content-center" id="pagination-links">
                    {!! $oneway->links() !!}
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

    @include('user.layouts.resultActionBtnJs')

@section('pageJS')