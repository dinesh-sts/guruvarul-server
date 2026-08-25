@extends('user.layouts.afterLoginLayout')

@section('pageCSS')
    
@endsection

<!-- Content Section Start -->
@section('content')

<!-- Page Header -->
<section class="inPageHeader">
    <div class="container">
        <h2 class="text-center">Prefered Way Matching Profile</h2>
    </div>
</section>
<!-- /. Page Header -->

<section class="inHome mt-5">
    <div class="container">
        <div class="row">
            @include('user.layouts.matchLeftPanel')
            <div class="col-lg-9 col-md-8">
                @foreach ($preferedway as $data)
                    @include('user.layouts.profileDetailsCard')
                @endforeach
                <div class="d-flex justify-content-center" id="pagination-links">
                    {!! $preferedway->links() !!}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
    @include('user.layouts.resultActionBtnJs')
@section('pageJS')