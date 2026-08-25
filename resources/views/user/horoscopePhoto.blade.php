@extends('user.layouts.afterLoginLayout')

@section('pageCSS')
    
@endsection

<!-- Content Section Start -->
@section('content')

<!-- Page Header -->
<section class="inPageHeader">
    <div class="container">
        <h2 class="text-center">Manage Horoscope</h2>
    </div>
</section>
<!-- /. Page Header -->

<!-- Horoscope Section -->
<section class="inHome mt-5">
    <div class="container">
        <div class="row">
            <!-- User home left panel -->
            @include('user.layouts.leftPanel')
            <!-- /.User home left panel -->

            <div class="col-lg-9 col-md-8">
                
                <div class="card mb-4 inEditCard">
                    <div class="card-header">
                        <h4>MANAGE HOROSCOPE IMAGE</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" id="register_form" action="{{route('user.managePhotoUpdate',$register->id) }}" enctype="multipart/form-data" >
                            @csrf
                            <div class="row">
                                <div class="col-xl-5 mb-4">
                                    <div class="card inManagePhotoCard border-0">
                                        @if(isset($register))
                                        <?php  $filePath = '/userImages/'.$register->hor_photo; ?>
                                            @if($register->hor_photo != "" && Storage::disk('public')->exists($filePath))
                                                <img src="{{asset('storage/userImages/'.$register->hor_photo)}}" class="card-img-top">
                                                @if($register->hor_check == "PENDING")
                                                <span class="inPhotoUploadStatus">
                                                    <p class="inStatusPending mb-0">
                                                        <i class="fas fa-clock"></i> Pending Approval 
                                                    </p>
                                                </span>
                                                @endif
                                            @else
                                                <img src="{{asset('User/img/upload_horoscope.jpg')}}" class="card-img-top">
                                            @endif
                                        @endif
                                        @if(isset($register->hor_photo))
                                        <div class="card-body p-0">
                                            <div class="row g-0">
                                                <div class="col-12">
                                                    <a href="{{route('user.profileimagedelete',['id' => $register->id, 'photo' => 'hor_photo'])}}" class="btn btnSecondary d-block btn2"><i class="fas fa-trash"></i> DELETE</a>
                                                </div>
                                            </div> 
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xl-7">
                                    <div class="form">
                                        <div class="mb-3">
                                            <label>Upload Horoscope Picture</label>
                                            <input type="file" name="hor_photo" class="form-control">
                                        </div>
                                        <div class="mb-3 text-center">
                                            <input type="submit" value="UPLOAD" name="horoscope_img" class="btn btnPrimary">
                                        </div>
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
                    <strong class="me-auto">Horoscope uploaded successfully. It will reflect to other users once get approved.</strong>
                </div>
                <button type="button" class="btn-close me-2 m-auto bg-white p-1" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
@endsection

@section('pageJS')
<script>
    $(document).ready(function(e) {
        @if(Session::has('message'))
            $('#message').toast('show');
        @endif
    });
</script>
@endsection