@extends('user.layouts.afterLoginLayout')

@section('pageCSS')
    
@endsection

<!-- Content Section Start -->
@section('content')

<!-- Page Header -->
<section class="inPageHeader">
    <div class="container">
        <h2 class="text-center">Manage Photos</h2>
    </div>
</section>
<!-- /. Page Header -->

<!-- Manage photos Section -->
<section class="inHome inManagePhoto mt-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-4">
                <!-- Profile Picture Card -->
                <div class="card mb-3 inCardHomeProfile">
                    <form method="POST" id="register_form" action="{{route('user.managePhotoUpdate',$register->id) }}" enctype="multipart/form-data">
                        @csrf
                        @if(isset($register))
                            <?php $filePath = '/userImages/'.$register->photo1; ?>
                            @if($register->photo1 != "" && Storage::disk('public')->exists($filePath))
                                <img src="{{ asset('storage/userImages/'. $register->photo1) }}" class="card-img-top">
                                @if($register->photo1_approve == "PENDING")
                                <span class="inPhotoUploadStatus">
                                    <p class="inStatusPending mb-0">
                                        <i class="fas fa-clock"></i> Pending Approval 
                                    </p>
                                </span>
                                @endif
                            @elseif($register->photo1 != ""  && $register->gender == "Female" && $register->photo1_approve == "PENDING" && Storage::disk('public')->exists($filePath))
                                <img src="{{asset('user/img/femalepending.jpg')}}" class="card-img-top">
                            @elseif($register->photo1 != ""  && $register->gender == "Male" && $register->photo1_approve == "PENDING" && Storage::disk('public')->exists($filePath))
                                <img src="{{asset('user/img/malepending.jpg')}}" class="card-img-top">
                            @else
                                @if($register->gender == "Male")
                                    <img src="{{asset('user/img/male.jpg')}}" class="card-img-top">
                                @else
                                    <img src="{{asset('user/img/female.jpg')}}" class="card-img-top">
                                @endif
                            @endif
                        @endif
                        <div class="card-body text-center">
                            <input type="file" name="photo1" id="photo1" >
								<label for="photo1" class="btn btnSecondary d-block mb-2">
									CHANGE PROFILE PIC
								</label>
                                <button type="submit" id="photo1form" class="btn btnSecondary d-none">Perform Action</button>
                            @if($register->photo1 != null)
                            <a href="{{route('user.profileimagedelete',['id' => $register->id, 'photo' => 'photo1'])}}" class="btn btnPrimary d-block mb-0">DELETE PROFILE PIC</a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-9 col-md-8">
                
                <div class="card mb-4 inEditCard">
                    <div class="card-header">
                        <h4>UPLOAD MORE PHOTOS</h4>
                    </div>
                    <div class="card-body">
                            <div class="row">
                                <div class="col-xl-3 col-6 mb-4">
                                    <form method="POST" id="register_form" action="{{route('user.managePhotoUpdate',$register->id) }}" enctype="multipart/form-data" >
                                        @csrf
                                        <div class="card inManagePhotoCard border-0">
                                            @if(isset($register))
                                            <?php  $filePath = '/userImages/'.$register->photo2; ?>
                                                @if($register->photo2 != "" && Storage::disk('public')->exists($filePath))
                                                    <img src="{{asset('storage/userImages/'. $register->photo2)}}" class="card-img-top">
                                                    @if($register->photo2_approve == "PENDING")
                                                    <span class="inPhotoUploadStatus">
                                                        <p class="inStatusPending mb-0">
                                                            <i class="fas fa-clock"></i> Pending Approval 
                                                        </p>
                                                    </span>
                                                    @endif
                                                    {{-- <img src="{{ route('apply.watermark', ['image' => $register->photo2]) }}" class="card-img-top gtFullWidth"> --}}
                                                @elseif($register->photo2 != ""  && $register->gender == "Female" && $register->photo2_approve == "PENDING" && Storage::disk('public')->exists($filePath))
                                                    <img src="{{asset('user/img/femalepending.jpg')}}" class="card-img-top">
                                                @elseif($register->photo2 != ""  && $register->gender == "Male" && $register->photo2_approve == "PENDING" && Storage::disk('public')->exists($filePath))
                                                    <img src="{{asset('user/img/malepending.jpg')}}" class="card-img-top">
                                                @else
                                                    @if($register->gender == "Male")
                                                        <img src="{{asset('user/img/male.jpg')}}" class="card-img-top">
                                                    @else
                                                        <img src="{{asset('user/img/female.jpg')}}" class="card-img-top">
                                                    @endif
                                                @endif
                                            @endif
                                            <div class="card-body p-0">
                                                <div class="row g-0">
                                                    <div class="@if(isset($register->photo2))col-6 @else col-12 @endif">
                                                        <input type="file" name="photo2" id="photo2" >
                                                        <label for="photo2" class="btn btnSecondary d-block btn1">
                                                            <i class="fas fa-pen"></i>
                                                        </label>
                                                        <button type="submit" id="photo2form" class="btn btnSecondary d-none">Perform Action</button>
                                                    </div>
                                                    @if(isset($register->photo2))
                                                    <div class="@if($register->photo2 != null)col-6 @else col-12 @endif">
                                                        <a href="{{route('user.profileimagedelete',['id' => $register->id, 'photo' => 'photo2'])}}" class="btn btnSecondary d-block btn2"><i class="fas fa-trash"></i></a>
                                                    </div>
                                                    @endif
                                                </div> 
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-xl-3 col-6 mb-4">
                                    <form method="POST" id="register_form" action="{{route('user.managePhotoUpdate',$register->id) }}" enctype="multipart/form-data" >
                                        @csrf
                                        <div class="card inManagePhotoCard border-0">
                                            @if(isset($register))
                                                <?php  $filePath = '/userImages/'.$register->photo3; ?>
                                                @if($register->photo3 != "" && $register->photo3_approve == "APPROVED" && Storage::disk('public')->exists($filePath))
                                                    <img src="{{asset('storage/userImages/'. $register->photo3)}}" class="card-img-top">
                                                    @if($register->photo3_approve == "PENDING")
                                                    <span class="inPhotoUploadStatus">
                                                        <p class="inStatusPending mb-0">
                                                            <i class="fas fa-clock"></i> Pending Approval 
                                                        </p>
                                                    </span>
                                                    @endif
                                                    {{-- <img src="{{ route('apply.watermark', ['image' => $register->photo3]) }}" class="card-img-top gtFullWidth"> --}}
                                                @elseif($register->photo3 != ""  && $register->gender == "Female" && $register->photo3_approve == "PENDING" && Storage::disk('public')->exists($filePath))
                                                    <img src="{{asset('user/img/femalepending.jpg')}}" class="card-img-top">
                                                @elseif($register->photo3 != ""  && $register->gender == "Male" && $register->photo3_approve == "PENDING" && Storage::disk('public')->exists($filePath))
                                                    <img src="{{asset('user/img/malepending.jpg')}}" class="card-img-top">
                                                @else
                                                    @if($register->gender == "Male")
                                                        <img src="{{asset('user/img/male.jpg')}}" class="card-img-top">
                                                    @else
                                                        <img src="{{asset('user/img/female.jpg')}}" class="card-img-top">
                                                    @endif
                                                @endif
                                            @endif
                                        <div class="card-body p-0">
                                            <div class="row g-0">
                                                <div class="{{ $register->photo3 != null ? 'col-6' : 'col-12' }}">
                                                    <input type="file" name="photo3" id="photo3" >
                                                    <label for="photo3" class="btn btnSecondary d-block btn1">
                                                        <i class="fas fa-pen"></i>
                                                    </label>
                                                    <button type="submit" id="photo3form" class="btn btnSecondary d-none">Perform Action</button>
                                                </div>
                                                @if($register->photo3 != null)
                                                <div class="{{ $register->photo3 != null ? 'col-6' : 'col-12' }}">
                                                    <a href="{{route('user.profileimagedelete',['id' => $register->id, 'photo' => 'photo3'])}}" class="btn btnSecondary d-block btn2"><i class="fas fa-trash"></i></a>
                                                </div>
                                                @endif
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-6 mb-4">
                                    <form method="POST" id="register_form" action="{{route('user.managePhotoUpdate',$register->id) }}" enctype="multipart/form-data" >
                                        @csrf
                                    <div class="card inManagePhotoCard border-0">
                                        @if(isset($register))
                                        <?php  $filePath = '/userImages/'.$register->photo4; ?>
                                            @if($register->photo4 != "" && $register->photo4_approve == "APPROVED" && Storage::disk('public')->exists($filePath))
                                                <img src="{{asset('storage/userImages/'. $register->photo4)}}" class="card-img-top">
                                                @if($register->photo4_approve == "PENDING")
                                                <span class="inPhotoUploadStatus">
                                                    <p class="inStatusPending mb-0">
                                                        <i class="fas fa-clock"></i> Pending Approval 
                                                    </p>
                                                </span>
                                                @endif
                                                {{-- <img src="{{ route('apply.watermark', ['image' => $register->photo4]) }}" class="card-img-top gtFullWidth"> --}}
                                            @elseif($register->photo4 != ""  && $register->gender == "Female" && $register->photo4_approve == "PENDING" && Storage::disk('public')->exists($filePath))
                                                <img src="{{asset('user/img/femalepending.jpg')}}" class="card-img-top">
                                            @elseif($register->photo4 != ""  && $register->gender == "Male" && $register->photo4_approve == "PENDING" && Storage::disk('public')->exists($filePath))
                                                <img src="{{asset('user/img/malepending.jpg')}}" class="card-img-top">
                                            @else
                                                @if($register->gender == "Male")
                                                    <img src="{{asset('user/img/male.jpg')}}" class="card-img-top">
                                                @else
                                                    <img src="{{asset('user/img/female.jpg')}}" class="card-img-top">
                                                @endif
                                            @endif
                                        @endif
                                        <div class="card-body p-0">
                                            <div class="row g-0">
                                                <div class="@if(isset($register->photo4))col-6 @else col-12 @endif">
                                                    <input type="file" name="photo4" id="photo4" >
                                                    <label for="photo4" class="btn btnSecondary d-block btn1">
                                                        <i class="fas fa-pen"></i>
                                                    </label>
                                                    <button type="submit" id="photo4form" class="btn btnSecondary d-none">Perform Action</button>
                                                </div>
                                                @if(isset($register->photo4))
                                                <div class="@if($register->photo4 != null)col-6 @else col-12 @endif">
                                                    <a href="{{route('user.profileimagedelete',['id' => $register->id, 'photo' => 'photo4'])}}" class="btn btnSecondary d-block btn2"><i class="fas fa-trash"></i></a>
                                                </div>
                                                @endif
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-6 mb-4">
                                    <form method="POST" id="register_form" action="{{route('user.managePhotoUpdate',$register->id) }}" enctype="multipart/form-data" >
                                        @csrf
                                    <div class="card inManagePhotoCard border-0">
                                        @if(isset($register))
                                        <?php  $filePath = '/userImages/'.$register->photo5; ?>
                                            @if($register->photo5 != "" && $register->photo5_approve == "APPROVED" && Storage::disk('public')->exists($filePath))
                                                <img src="{{asset('storage/userImages/'. $register->photo5)}}" class="card-img-top">
                                                @if($register->photo5_approve == "PENDING")
                                                <span class="inPhotoUploadStatus">
                                                    <p class="inStatusPending mb-0">
                                                        <i class="fas fa-clock"></i> Pending Approval 
                                                    </p>
                                                </span>
                                                @endif
                                                {{-- <img src="{{ route('apply.watermark', ['image' => $register->photo5]) }}" class="card-img-top gtFullWidth"> --}}
                                            @elseif($register->photo5 != ""  && $register->gender == "Female" && $register->photo5_approve == "PENDING" && Storage::disk('public')->exists($filePath))
                                                <img src="{{asset('user/img/femalepending.jpg')}}" class="card-img-top">
                                            @elseif($register->photo5 != ""  && $register->gender == "Male" && $register->photo5_approve == "PENDING" && Storage::disk('public')->exists($filePath))
                                                <img src="{{asset('user/img/malepending.jpg')}}" class="card-img-top">
                                            @else
                                                @if($register->gender == "Male")
                                                    <img src="{{asset('user/img/male.jpg')}}" class="card-img-top">
                                                @else
                                                    <img src="{{asset('user/img/female.jpg')}}" class="card-img-top">
                                                @endif
                                            @endif
                                        @endif
                                        <div class="card-body p-0">
                                            <div class="row g-0">
                                                <div class="@if(isset($register->photo5))col-6 @else col-12 @endif">
                                                    <input type="file" name="photo5" id="photo5" >
                                                    <label for="photo5" class="btn btnSecondary d-block btn1">
                                                        <i class="fas fa-pen"></i>
                                                    </label>
                                                    <button type="submit" id="photo5form" class="btn btnSecondary d-none">Perform Action</button>
                                                </div>
                                                @if(isset($register->photo5))
                                                <div class="@if($register->photo5 != null)col-6 @else col-12 @endif">
                                                    <a href="{{route('user.profileimagedelete',['id' => $register->id, 'photo' => 'photo5'])}}" class="btn btnSecondary d-block btn2"><i class="fas fa-trash"></i></a>
                                                </div>
                                                @endif
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-3 col-6 mb-4">
                                    <form method="POST" id="register_form" action="{{route('user.managePhotoUpdate',$register->id) }}" enctype="multipart/form-data" >
                                        @csrf
                                    <div class="card inManagePhotoCard border-0">
                                        @if(isset($register))
                                        <?php  $filePath = '/userImages/'.$register->photo6; ?>
                                            @if($register->photo6 != "" && $register->photo6_approve == "APPROVED" && Storage::disk('public')->exists($filePath))
                                                <img src="{{asset('storage/userImages/'. $register->photo6)}}" class="card-img-top">
                                                @if($register->photo6_approve == "PENDING")
                                                <span class="inPhotoUploadStatus">
                                                    <p class="inStatusPending mb-0">
                                                        <i class="fas fa-clock"></i> Pending Approval 
                                                    </p>
                                                </span>
                                                @endif
                                                {{-- <img src="{{ route('apply.watermark', ['image' => $register->photo6]) }}" class="card-img-top gtFullWidth"> --}}
                                            @elseif($register->photo6 != ""  && $register->gender == "Female" && $register->photo6_approve == "PENDING" && Storage::disk('public')->exists($filePath))
                                                <img src="{{asset('user/img/femalepending.jpg')}}" class="card-img-top">
                                            @elseif($register->photo6 != ""  && $register->gender == "Male" && $register->photo6_approve == "PENDING" && Storage::disk('public')->exists($filePath))
                                                <img src="{{asset('user/img/malepending.jpg')}}" class="card-img-top">
                                            @else
                                                @if($register->gender == "Male")
                                                    <img src="{{asset('user/img/male.jpg')}}" class="card-img-top">
                                                @else
                                                    <img src="{{asset('user/img/female.jpg')}}" class="card-img-top">
                                                @endif
                                            @endif
                                        @endif
                                        <div class="card-body p-0">
                                            <div class="row g-0">
                                                <div class="@if(isset($register->photo6))col-6 @else col-12 @endif">
                                                    <input type="file" name="photo6" id="photo6" >
                                                    <label for="photo6" class="btn btnSecondary d-block btn1">
                                                        <i class="fas fa-pen"></i>
                                                    </label>
                                                    <button type="submit" id="photo6form" class="btn btnSecondary d-none">Perform Action</button>
                                                </div>
                                                @if(isset($register->photo6))
                                                <div class="@if($register->photo6 != null)col-6 @else col-12 @endif">
                                                    <a href="{{route('user.profileimagedelete',['id' => $register->id, 'photo' => 'photo6'])}}" class="btn btnSecondary d-block btn2"><i class="fas fa-trash"></i></a>
                                                </div>
                                                @endif
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-6 mb-4">
                                    <form method="POST" id="register_form" action="{{route('user.managePhotoUpdate',$register->id) }}" enctype="multipart/form-data" >
                                        @csrf
                                    <div class="card inManagePhotoCard border-0">
                                        @if(isset($register))
                                            <?php  $filePath = '/userImages/'.$register->photo7; ?>
                                            @if($register->photo7 != "" && $register->photo7_approve == "APPROVED" && Storage::disk('public')->exists($filePath))
                                                <img src="{{asset('storage/userImages/'. $register->photo7)}}" class="card-img-top">
                                                @if($register->photo7_approve == "PENDING")
                                                <span class="inPhotoUploadStatus">
                                                    <p class="inStatusPending mb-0">
                                                        <i class="fas fa-clock"></i> Pending Approval 
                                                    </p>
                                                </span>
                                                @endif
                                                {{-- <img src="{{ route('apply.watermark', ['image' => $register->photo7]) }}" class="card-img-top gtFullWidth"> --}}
                                            @elseif($register->photo7 != ""  && $register->gender == "Female" && $register->photo7_approve == "PENDING" && Storage::disk('public')->exists($filePath))
                                                <img src="{{asset('user/img/femalepending.jpg')}}" class="card-img-top">
                                            @elseif($register->photo7 != ""  && $register->gender == "Male" && $register->photo7_approve == "PENDING" && Storage::disk('public')->exists($filePath))
                                                <img src="{{asset('user/img/malepending.jpg')}}" class="card-img-top">
                                            @else
                                                @if($register->gender == "Male")
                                                    <img src="{{asset('user/img/male.jpg')}}" class="card-img-top">
                                                @else
                                                    <img src="{{asset('user/img/female.jpg')}}" class="card-img-top">
                                                @endif
                                            @endif
                                        @endif
                                        <div class="card-body p-0">
                                            <div class="row g-0">
                                                <div class="@if(isset($register->photo7))col-6 @else col-12 @endif">
                                                    <input type="file" name="photo7" id="photo7" >
                                                    <label for="photo7" class="btn btnSecondary d-block btn1">
                                                        <i class="fas fa-pen"></i>
                                                    </label>
                                                    <button type="submit" id="photo7form" class="btn btnSecondary d-none">Perform Action</button>
                                                </div>
                                                @if(isset($register->photo7))
                                                <div class="@if($register->photo7 != null)col-6 @else col-12 @endif">
                                                    <a href="{{route('user.profileimagedelete',['id' => $register->id, 'photo' => 'photo7'])}}" class="btn btnSecondary d-block btn2"><i class="fas fa-trash"></i></a>
                                                </div>
                                                @endif
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-6 mb-4">
                                    <form method="POST" id="register_form" action="{{ route('user.managePhotoUpdate',$register->id) }}" enctype="multipart/form-data" >
                                        @csrf
                                    <div class="card inManagePhotoCard border-0">
                                        @if(isset($register))
                                            <?php  $filePath = '/userImages/'.$register->photo8; ?>
                                            @if($register->photo8 != "" && $register->photo8_approve == "APPROVED" && Storage::disk('public')->exists($filePath))
                                                <img src="{{asset('storage/userImages/'. $register->photo8)}}" class="card-img-top">
                                                @if($register->photo8_approve == "PENDING")
                                                <span class="inPhotoUploadStatus">
                                                    <p class="inStatusPending mb-0">
                                                        <i class="fas fa-clock"></i> Pending Approval 
                                                    </p>
                                                </span>
                                                @endif
                                                {{-- <img src="{{ route('apply.watermark', ['image' => $register->photo8]) }}" class="card-img-top gtFullWidth"> --}}
                                            @elseif($register->photo8 != ""  && $register->gender == "Female" && $register->photo8_approve == "PENDING" && Storage::disk('public')->exists($filePath))
                                                <img src="{{asset('user/img/femalepending.jpg')}}" class="card-img-top">
                                            @elseif($register->photo8 != ""  && $register->gender == "Male" && $register->photo8_approve == "PENDING" && Storage::disk('public')->exists($filePath))
                                                <img src="{{asset('user/img/malepending.jpg')}}" class="card-img-top">
                                            @else
                                                @if($register->gender == "Male")
                                                    <img src="{{asset('user/img/male.jpg')}}" class="card-img-top">
                                                @else
                                                    <img src="{{asset('user/img/female.jpg')}}" class="card-img-top">
                                                @endif
                                            @endif
                                        @endif
                                        <div class="card-body p-0">
                                            <div class="row g-0">
                                                <div class="@if(isset($register->photo8))col-6 @else col-12 @endif">
                                                    <input type="file" name="photo8" id="photo8" >
                                                    <label for="photo8" class="btn btnSecondary d-block btn1">
                                                        <i class="fas fa-pen"></i>
                                                    </label>
                                                    <button type="submit" id="photo8form" class="btn btnSecondary d-none">Perform Action</button>
                                                </div>
                                                @if(isset($register->photo8))
                                                <div class="@if($register->photo8 != null)col-6 @else col-12 @endif">
                                                    <a href="{{route('user.profileimagedelete',['id' => $register->id, 'photo' => 'photo8'])}}" class="btn btnSecondary d-block btn2"><i class="fas fa-trash"></i></a>
                                                </div>
                                                @endif
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                            </div>
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
<script>
    $(document).ready(function(e) {
        @if(Session::has('message'))
            $('#message').toast('show');
        @endif

        $('#photo1').on('change',function(){
            $('#photo1form').click();
        });
        
        $('#photo2').on('change',function(){
            $('#photo2form').click();
        });

        $('#photo3').on('change',function(){
            $('#photo3form').click();
        });

        $('#photo4').on('change',function(){
            $('#photo4form').click();
        });

        $('#photo5').on('change',function(){
            $('#photo5form').click();
        });

        $('#photo6').on('change',function(){
            $('#photo6form').click();
        });

        $('#photo7').on('change',function(){
            $('#photo7form').click();
        });

        $('#photo8').on('change',function(){
            $('#photo8form').click();
        });
    });
</script>	
@endsection