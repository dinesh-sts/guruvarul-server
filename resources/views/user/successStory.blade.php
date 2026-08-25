@extends('user.layouts.beforeLoginLayout')

@section('pageCSS')
    
@endsection

<!-- Content Section Start -->
@section('content')

    <!-- Page Header -->
    <section class="inPageHeader">
        <div class="container">
            <h2 class="text-center">Success Story</h2>
        </div>
    </section>
    <!-- /.Page Header -->

    <!-- Success Story Card -->
    <section class="inSuccessCard mb-5">
        <div class="container">
            
            <div class="row">
                <div class="col-xl-12 inSuccessPill">

                    <!-- Tabs -->
                    <!-- <ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab" role="tablist">
                        <li class="nav-item me-2" role="presentation">
                            <button class="nav-link active" id="pills-story-tab" data-bs-toggle="pill" data-bs-target="#pills-story" type="button" role="tab" aria-controls="pills-story" aria-selected="true">Success Story</button>
                        </li>
                        <li class="nav-item ms-2 me-2" role="presentation">
                            <button class="nav-link" id="pills-post-tab" data-bs-toggle="pill" data-bs-target="#pills-post" type="button" role="tab" aria-controls="pills-post" aria-selected="false">Post Success Story</button>
                        </li>
                    </ul> -->
                    <!-- /. Tabs -->

                    <!-- Tab pan-->
                    <div class="tab-content" id="pills-tabContent">
                        <!-- Success Story Card-->
                        <div class="tab-pane fade show active" id="pills-story" role="tabpanel" aria-labelledby="pills-story-tab" tabindex="0">
                            <div class="row pt-4">
                                @foreach ($successStories as $story)
                                <div class="col-xl-4 mb-4">
                                    <div class="card inStoryCard">
                                        <div class="card-img-top">
                                            <img src="{{asset('storage/successStory/'. $story->weddingphoto)}}" class="card-img-top">
                                        </div>
                                        <div class="card-body text-center">
                                            <h1 class="card-title">@if(isset($story->groomname)){{$story->groomname}}@endif & @if(isset($story->bridename)){{$story->bridename}}@endif</h1>
                                            <p class="card-text mb-3">@if(isset($story->successmessage)){{substr($story->successmessage, 0, 80)}}...@endif</p>
                                            <h6 class="mb-3">POSTED ON - <span class="colorPrimary">@if(isset($story->created_at)){{$story->created_at->format('d M Y')}}@endif</span></h6>
                                            <a href="{{route('user.successStoryRead',$story->id)}}" class="btn btnSecondary">Read More</a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- /.Success Story Card -->
                        
                        <!-- Post Story Card -->
                        <div class="tab-pane fade" id="pills-post" role="tabpanel" aria-labelledby="pills-post-tab" tabindex="0">
                            <div class="row">
                                <div class="col-xl-10 offset-xl-1">
                                    <div class="card inPostCard">
                                        <div class="card-body p-md-5 p-4">
                                            <form method="POST" action="{{route('user.successStoryPost')}}" enctype="multipart/form-data">
                                                @csrf
                                                <div class="mb-4 row">
                                                    <label for="inputPassword" class="col-sm-3 col-form-label">Bride Member Id</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" value="{{old('brideid')}}" name="brideid" class="form-control" placeholder="Enter bride matrimony id" required>
                                                        @error('brideid')
                                                    <div style="color:red">{{ $message }}</div>
                                                    @enderror                                                
                                                    </div>
                                                </div>
                                                <div class="mb-4 row">
                                                    <label for="inputPassword" class="col-sm-3 col-form-label">Bride's Name</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" value="{{old('bridename')}}" name="bridename" class="form-control" placeholder="Enter bride name" required>
                                                        @error('bridename')
                                                    <div style="color:red">{{ $message }}</div>
                                                    @enderror                                                
                                                    </div>
                                                </div>
                                                <div class="mb-4 row">
                                                    <label for="inputPassword" class="col-sm-3 col-form-label">Groom Member Id</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" value="{{old('groomid')}}" name="groomid" class="form-control" placeholder="Enter groom matrimony id" required>
                                                        @error('groomid')
                                                    <div style="color:red">{{ $message }}</div>
                                                    @enderror                                                
                                                    </div>
                                                </div>
                                                <div class="mb-4 row">
                                                    <label for="inputPassword" class="col-sm-3 col-form-label">Groom's Name</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" value="{{old('groomname')}}" name="groomname" class="form-control" placeholder="Enter groom name" required>
                                                        @error('groomname')
                                                    <div style="color:red">{{ $message }}</div>
                                                    @enderror
                                                    </div>
                                                </div>
                                                <div class="mb-4 row">
                                                    <label for="inputPassword" class="col-sm-3 col-form-label">Engagement Date</label>
                                                    <div class="col-sm-6">
                                                        <input type="date" value="{{old('engagement_date')}}" name="engagement_date" class="form-control" required>
                                                        @error('engagement_date')
                                                        <div style="color:red">{{ $message }}</div>
                                                        @enderror                                              
                                                    </div>
                                                </div>
                                                <div class="mb-4 row">
                                                    <label for="inputPassword" class="col-sm-3 col-form-label">Marriage Date</label>
                                                    <div class="col-sm-6">
                                                        <input type="date" value="{{old('marriagedate')}}" name="marriagedate" class="form-control" required>
                                                        @error('marriagedate')
                                                    <div style="color:red">{{ $message }}</div>
                                                    @enderror                                                
                                                    </div>
                                                </div>
                                                <div class="mb-4 row">
                                                    <label for="inputPassword" class="col-sm-3 col-form-label">Upload Marriage Photo</label>
                                                    <div class="col-sm-6">
                                                        <input type="file" value="" name="weddingphoto" class="form-control" required>
                                                        @error('weddingphoto')
                                                    <div style="color:red">{{ $message }}</div>
                                                    @enderror                                                
                                                    </div>
                                                </div>
                                                <div class="mb-4 row">
                                                    <label for="inputPassword" class="col-sm-3 col-form-label">Success Story</label>
                                                    <div class="col-sm-6">
                                                        <textarea class="form-control" value="" name="successmessage" rows="3" required>{{ old('successmessage') }}</textarea>
                                                        @error('successmessage')
                                                        <div style="color:red">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="mb-3 text-center">
                                                    <input type="submit" value="SUBMIT" name="basicDetails" class="btn btnPrimary">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.Post Story Card -->
                    </div>
                    <!-- /.Tab pan-->
                </div>
            </div>
        </div>
        <div class="toast-container position-fixed position-static bottom-0 end-0 p-3 mb-5 mb-sm-0">
            <div id="successstory" class="toast inToastExpress" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
                <div class="d-flex">
                    <div class="toast-body">
                        <strong class="me-auto">Success Story Posted Successfully</strong>
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
            $('#successstory').toast('show');
        @endif
    });
</script>
@endsection
