@extends('user.layouts.afterLoginLayout')

@section('pageCSS')
    
@endsection

<!-- Content Section Start -->
@section('content')
<section class="inPageHeader">
    <div class="container">
        <h2 class="text-center">Change Password</h2>
    </div>
</section>
<section class="inHome mt-5">
    <div class="container">
        <div class="row">
             <!-- Settings Panel -->
             @include('user.layouts.settingsLeftPanel')
             <!-- /.Settings Panel -->
          
            <div class="col-lg-9 col-md-8">
                <!-- Change Password Form -->
                <div class="card mb-4 inEditCard">
                    <div class="card-body pt-5 pb-5">
                        <form method="Post" action="{{route('user.checkChangePassword')}}">
                            @csrf
                            <div class="col-xl-8 offset-xl-2">
                                <div class="row">
                                    <div class="col-xl-12 mb-3">
                                        <label class="label-1">Current Password</label>
                                        <input type="password" value="" name="old_password" class="form-control" placeholder="Enter Current Password">
                                        @error('old_password')
                                            <div style="color:red">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-xl-12 mb-3">
                                        <label class="label-1">New Password</label>
                                        <input type="password" value="" name="new_password" class="form-control" placeholder="Enter New Password">
                                        @error('new_password')
                                            <div style="color:red">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-xl-12 mb-3">
                                        <label class="label-1">Confirm New Password</label>
                                        <input type="password" value="" name="confirm_password" class="form-control" placeholder="Confirm New Password">
                                        @error('confirm_password')
                                            <div style="color:red">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="text-center mt-3">
                                        <input type="submit" value="UPDATE" name="" class="btn btnPrimary">
                                    </div>
                                </div>
                            </div>
                            
                        </form>
                    </div>
                </div>
                <!-- /.Change Password Form -->
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

    @include('user.layouts.resultActionBtnJs')
    <script type="text/javascript">
        $(document).ready(function () {
            @if(Session::has('message'))
                $('#message').toast('show');
            @endif
        });
    </script>
@endsection