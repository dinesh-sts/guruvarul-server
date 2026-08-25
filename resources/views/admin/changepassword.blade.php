@extends('admin.layouts.afterLoginLayout')

@section('title') Admin Panel - Change Admin Password @endsection

@section('pageCSS') @endsection

@section('content')
<div class="container pt-5">
                    
    <div class="row">            
        <div class="col-xl-8 offset-xl-2 mb-3">
            <div class="card inBorderColor1 inAAddMembership mb-3">
                <div class="card-header">
                    <h4 class="card-title">Change Admin Password</h4>
                </div>
                <div class="card-body ps-5 pe-5">
                    <form action="{{route('admin.changeAdminPasswordStore')}}" method="POST">
                        @csrf                        
                        <div class="row mb-3">
                            <div class="col-xl-12 mb-3">
                                <label class="label-1">Old Password</label>
                                <input type="password" name="old_password" value="" class="form-control">
                                @error('old_password')
                                    <div style="color:red">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-xl-12 mb-3">
                                <label class="label-1">New Password</label>
                                <input type="password" name="new_password" value="" class="form-control">
                                @error('new_password')
                                    <div style="color:red">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-xl-12 mb-3">
                                <label class="label-1">Confirm New Password</label>
                                <input type="password" name="confirm_password" value="" class="form-control">
                                @error('confirm_password')
                                    <div style="color:red">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xl-12 mb-4 text-center">
                            <input type="submit" value="UPDATE" class="btn btnPrimary">
                        </div>
                    </form>
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