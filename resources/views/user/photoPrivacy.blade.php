@extends('user.layouts.afterLoginLayout')

@section('pageCSS')
    
@endsection

<!-- Content Section Start -->
@section('content')
<section class="inPageHeader">
    <div class="container">
        <h2 class="text-center">Photo Privacy</h2>
    </div>
</section>
<section class="inHome mt-5">
    <div class="container">
        <div class="row">
            
            <!-- Settings Panel -->
            @include('user.layouts.settingsLeftPanel')
            <!-- /.Settings Panel -->
        
            <div class="col-lg-9 col-md-8">
                <div class="card mb-4 inBorderColor1">
                    <div class="card-body">
                        <form action="{{route('user.photoPrivacyStore')}}" method="Post">
                            @csrf
                            <div class="row inPrivacyCurrentStatus">
                                <div class="col-xl-3 pt-2">
                                    <h5>Current Status:</h5>
                                </div>
                                <div class="col-xl-6 pt-2">
                                    <h4 class="inPrivacyStatus">
                                        <i class="fas fa-eye pe-2"></i>
                                        @if(isset($photoprivacy->photo_setting)) 
                                            @if($photoprivacy->photo_setting == '0') 
                                                Show To All Members 
                                            @elseif($photoprivacy->photo_setting == '1') 
                                                Show To Paid Members 
                                            @else
                                                Show To Express Interest Accepted Members 
                                            @endif 
                                        @endif
                                    </h4>
                                </div>
                                <div class="col-xl-3 mt-2 mt-xl-0">
                                     <a class="btn btnPrimary" data-bs-toggle="collapse" href="#collapseExample2" role="button" aria-expanded="false" aria-controls="collapseExample2">
                                       <i class="fas fa-pen-square pe-1"></i>EDIT
                                    </a>
                                </div>
                            </div>
                            <div class="collapse mt-4" id="collapseExample2">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 mb-3">
                                        <label>
                                            <input type="radio" value="0" @if(isset($photoprivacy->photo_setting)){{$photoprivacy->photo_setting == '0' ? 'checked' : ''}}@endif name="photo_setting">
                                            <span class="ps-2">Show To All Members</span>
                                        </label>
                                    </div>
                                    <div class="col-xl-12 col-lg-12 mb-3">
                                        <label>
                                            <input type="radio" value="1" @if(isset($photoprivacy->photo_setting)){{$photoprivacy->photo_setting == '1' ? 'checked' : ''}}@endif name="photo_setting" >
                                            <span class="ps-2">Show To Paid Members</span>
                                        </label>
                                    </div>
                                    <div class="col-xl-12 col-lg-12 mb-3">
                                        <label>
                                            <input type="radio" value="2" @if(isset($photoprivacy->photo_setting)){{$photoprivacy->photo_setting == '2' ? 'checked' : ''}}@endif name="photo_setting" class="pe-2">
                                            <span class="ps-2">Show To Express Interest Accepted Members</span>
                                        </label>
                                    </div>
                                    <div class="text-center mt-3">
                                        <input type="submit" value="UPDATE" name="" class="btn btnPrimary">
                                    </div>
                                </div>
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