@extends('user.layouts.beforeLoginLayout')

@section('pageCSS')
    
@endsection

<!-- Content Section Start -->
@section('content')
    <section class="inLogin mb-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 offset-xl-3">
                    <div class="card">
                        <div class="card-body ps-md-5 pe-md-5 ps-4 pe-4 pt-4 pb-4">
                            <h4 class="text-center inLoginTitle mb-4">LOGIN</h4> 
                            <form action="{{route('user.loginPost')}}" method="POST">
                                @csrf
                                <div class="form-floating mb-4">
                                    <input type="text" class="form-control" name="username" id="floatingInput" placeholder="name@example.com" required>
                                    <label for="floatingInput">Email id/Mobile No/Matrimony Id</label>
                                    @error('username')
                                        <div style="color:red">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" name="password" id="floatingPassword" placeholder="Password" required>
                                    <label for="floatingPassword">Password</label>
                                    @error('password')
                                        <div style="color:red">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3 text-end">
                                    <a href="{{ route('user.forgotPassword') }}" class="inForgotPasswordLink">Forgot Password?</a>
                                </div>
                                <div class="mb-2">
                                    <input type="submit" value="LOGIN NOW" class="btn btnPrimary d-block w-100">
                                </div>
                                @if($siteconfig->loginWithOTP == 'Yes')
                                <div class="col-12">
                                    <div class="inHearts text-center mb-3 bg-white">
                                        <div class="inHeartsGroup pt-2">
                                            <h5>OR</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <a href="{{ route('user.loginWithOtp') }}" class="btn btnSecondary d-block">LOGIN WITH OTP</a>
                                </div>
                                @endif
                                <div class="mb-0 text-center inLoginCreateText">
                                    <p class="mb-0">Don't Have Account Yet?</p>
                                    <a href="{{ route('user.register') }}" class="">Create an account</a>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="toast-container position-fixed position-static bottom-0 end-0 p-3 mb-5 mb-sm-0">
            <div id="email" class="toast inToastExpress" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
                <div class="d-flex">
                    <div class="toast-body">
                        <strong class="me-auto">{{ Session::get('message') }}</strong>
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
        @if(Session::has('message'))
            $('#email').toast('show');
        @endif
    });
</script>
@endsection