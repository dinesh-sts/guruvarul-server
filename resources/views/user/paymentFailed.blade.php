@extends('user.layouts.afterLoginLayout')

@section('pageCSS')
    
@endsection

<!-- Content Section Start -->
@section('content')
<!-- Register Confirmation Card -->
<section class="inLogin mb-5 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-xl-8 offset-xl-2">
                <div class="card">
                    <div class="card-body ps-md-5 pe-md-5 ps-4 pe-4 pt-4 pb-4 text-center">
                        <i class="fas fa-times-circle font-50 text-danger mb-2"></i>
                        <h3 class="fw-bolder">Payment Not Completed.</h3>
                        <p>Payment not completed. If payment deducted contact us.</p>
                        <a href="{{route('user.dashboard')}}" class="btn btnPrimary">Back To Home</a>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</section>

@endsection

@section('pageJS')


@endsection