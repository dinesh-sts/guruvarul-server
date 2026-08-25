@extends('user.layouts.beforeLoginLayout')

@section('pageCSS')
    
@endsection

<!-- Content Section Start -->
@section('content')
<section class="inLogin mb-5 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 offset-xl-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body pe-5 ps-5 pt-4">
                         <form action="{{route('user.reset.post')}}" method="POST">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                            <h4 class="text-center inLoginTitle mb-4">Reset Password</h4> 
                            
                            <div class="form-floating mb-4 mt-4">
                                <input type="password" name="password" class="form-control" id="floatingInput" placeholder="name@example.com" required>
                                <label for="floatingInput">Password</label>
                                @error('password')
                                    <div style="color:red">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-floating mb-4 mt-4">
                                <input type="password" name="confirm_password" class="form-control" id="floatingInput" placeholder="name@example.com" required>
                                <label for="floatingInput">Confirm Password</label>
                                @error('confirm_password')
                                    <div style="color:red">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4 col-12">
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
            $('#message').toast('show');
        @endif
    });
</script>
@endsection