@extends('user.layouts.beforeLoginLayout')

@section('pageCSS')
    
@endsection

<!-- Content Section Start -->
@section('content')
    <!-- Login Card -->
    <section class="inLogin mb-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 offset-xl-3">
                    <div class="card">
                        <div class="card-body ps-md-5 pe-md-5 ps-4 pe-4 pt-4 pb-4">
                            <h4 class="text-center inLoginTitle mb-4">LOGIN WITH OTP</h4> 
                            <form method="POST" action="{{ route('user.generateOtp') }}">
                            @csrf
                                <div class="form-floating mb-4">
                                    <input type="text" class="form-control" name="mobile" id="floatingInput" placeholder="name@example.com" required>
                                    <label for="floatingInput">Mobile No</label>
                                </div>
                                <div class="mb-4">
                                    <input type="submit" value="LOGIN WITH OTP" class="btn btnSecondary d-block w-100">
                                
                                </div>
                                
                                <div class="mb-0 text-center inLoginCreateText">
                                    <p class="mb-0">Don't Have Account Yet?</p>
                                    <a href="{{route('user.register')}}" class="">Create an account</a>
                                </div>
                            </form>
                            
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </section>
    <div class="toast-container position-fixed position-static bottom-0 end-0 p-3 mb-5 mb-sm-0">
        <div id="message" class="toast inToastExpress" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
            <div class="d-flex">
                <div class="toast-body">
                    <strong class="me-auto">{{ Session::get('message') }}</strong>
                </div>
                <button type="button" class="btn-close me-2 m-auto bg-white p-1" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
@endsection

@section('pageJS')
<script type="text/javascript">
    $(document).ready(function () {
        @if(Session::has('message'))
            $('#message').toast('show');
        @endif
    });
</script>
@endsection
