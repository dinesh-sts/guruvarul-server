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
                            <h4 class="text-center inLoginTitle mb-0">FORGOT PASSWORD?</h4>
                            <p class="mb-4 text-center">Enter your registered email id to recover password.</p>
                            <form action="{{route('user.forgotPassword')}}" method="POST">
                                @csrf
                                <div class="form-floating mb-4">
                                    <input type="email" name="username" class="form-control" id="floatingInput" placeholder="name@example.com" required>
                                    <label for="floatingInput">Email id</label>
                                </div>
                                <div class="mb-2">
                                    <input type="submit" value="SUBMIT" class="btn btnSecondary d-block w-100">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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