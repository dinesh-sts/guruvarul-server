@extends('user.layouts.beforeLoginLayout')

@section('pageCSS')
    
@endsection

<!-- Content Section Start -->
@section('content')

<section class="inLogin mb-5 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-xl-8 offset-xl-2">
                <div class="card">
                    <div class="card-body ps-md-5 pe-md-5 ps-4 pe-4 pt-4 pb-4 text-center">
                        <i class="fas fa-check-circle font-50 text-success mb-2"></i>
                        <h3 class="fw-bolder">Thank you for registering with us! 🎉</h3>
                        <!--<p>You are registered user now. Check your registered email id and click on verification link and start searching for your life partner.</p>-->
			<p>Please log in to complete your subscription payment.</p>
			<p>Kindly note that if the payment is not made within 3 days, your account will be automatically deleted.</p>
                        <!-- Verification Note -->
                        <!--<div class="alert alert-warning text-center" role="alert">
                            <h3 class="text-danger fw-bolder fs-4 mb-1">IMPORTANT</h3>
                            <h4 class="fs-6 fw-semibold">Verify your email id</h4>
                            <p class="font-13">Verify your email id by checking email and click on activation link for activating email account.If you dont get verification link please contact us.</p>
                        </div>-->
                        <!-- /.Verification Note -->
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <div class="toast-container position-fixed position-static bottom-0 end-0 p-3 mb-5 mb-sm-0">
        <div id="register" class="toast inToastExpress" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
            <div class="d-flex">
                <div class="toast-body">
                    <strong class="me-auto">User Register successfully</strong>
                </div>
                <button type="button" class="btn-close me-2 m-auto bg-white p-1" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
    <div class="toast-container position-fixed position-static bottom-0 end-0 p-3 mb-5 mb-sm-0">
        <div id="email" class="toast inToastExpress" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
            <div class="d-flex">
                <div class="toast-body">
                    <strong class="me-auto">Email verification link sent on your registed email id.Please verify your email id.</strong>
                </div>
                <button type="button" class="btn-close me-2 m-auto bg-white p-1" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
</section>

@endsection

@section('pageJS')
<script type="text/javascript">
    $(document).ready(function () {
        @if(Session::has('register'))
            $('#register').toast('show');
        @endif
        @if(Session::has('email'))
            //$('#email').toast('show');
        @endif
    });
</script>
@endsection
