<!-- Main layout -->
@extends('admin.layouts.afterLoginLayout')

<!-- Page title -->
@section('title') Admin - Add / Edit Success Story @endsection

<!-- Additional page css add here -->
@section('pageCSS') @endsection

@section('content')
<div class="container pt-3">
    <div class="row mb-3 inMemberTopPanel">
        <div class="col-xl-9">
            <h3 class="colorSecondary inATitle1">
                @if(isset($story))
                    Edit Success Story
                @else
                    Add Success Story
                @endif
            </h3>
        </div>
        <div class="col-xl-3 text-end">
            <a href="{{ route('admin.successStoryList') }}" class="btn btnPrimary">
                <i class="fas fa-chevron-left pe-1"></i>Back
            </a>   
        </div>
    </div>
    <div class="row">
        <div class="col-xl-8 offset-xl-2 mb-3">
            <div class="card inBorderColor1 inAAddMembership mb-5">
                <div class="card-body pt-5">
                    <form method="POST" action="{{ isset($story) ? route('admin.successStoryUpdate', $story->id) : route('admin.successStoryStore') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-xl-12 mb-4">
                                <div class="row">
                                    <div class="col-xl-4">
                                        <label class="label-1 fw-semibold mt-2">Bride's Member Id</label>
                                    </div>
                                    <div class="col-xl-8">
                                        <input type="text" value="@if(isset($story->brideid)){{$story->brideid}}@else{{old('brideid')}}@endif" name="brideid" class="form-control" placeholder="Enter Bride's Member Id">
                                        @error('brideid')
                                        <div style="color:red">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 mb-4">
                                <div class="row">
                                    <div class="col-xl-4">
                                        <label class="label-1 fw-semibold mt-2">Bride's Name</label>
                                    </div>
                                    <div class="col-xl-8">
                                        <input type="text" value="@if(isset($story->bridename)){{$story->bridename}}@else{{old('bridename')}}@endif" name="bridename" class="form-control" placeholder="Enter Bride's Name" required>
                                        @error('bridename')
                                       <div style="color:red">{{ $message }}</div>
                                       @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 mb-4">
                                <div class="row">
                                    <div class="col-xl-4">
                                        <label class="label-1 fw-semibold mt-2">Groom's Member Id</label>
                                    </div>
                                    <div class="col-xl-8">
                                        <input type="text" value="@if(isset($story->groomid)){{$story->groomid}}@else{{old('groomid')}}@endif" name="groomid" class="form-control" placeholder="Enter Groom's Member Id">
                                        @error('groomid')
                                        <div style="color:red">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 mb-4">
                                <div class="row">
                                    <div class="col-xl-4">
                                        <label class="label-1 fw-semibold mt-2">Groom's Name</label>
                                    </div>
                                    <div class="col-xl-8">
                                        <input type="text" value="@if(isset($story->groomname)){{$story->groomname}}@else{{old('groomname')}}@endif" name="groomname" class="form-control" placeholder="Enter Groom's Name" required>
                                        @error('groomname')
                                        <div style="color:red">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 mb-4">
                                <div class="row">
                                    <div class="col-xl-4">
                                        <label class="label-1 fw-semibold mt-2">Marriage Date</label>
                                    </div>
                                    <div class="col-xl-8">
                                        <input type="date" value="@if(isset($story->marriagedate)){{$story->marriagedate}}@else{{old('marriagedate')}}@endif" name="marriagedate" class="form-control" required>
                                        @error('marriagedate')
                                        <div style="color:red">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 mb-4">
                                <div class="row">
                                    <div class="col-xl-4">
                                        <label class="label-1 fw-semibold mt-2">Engagement Date</label>
                                    </div>
                                    <div class="col-xl-8">
                                        <input type="date" value="@if(isset($story->engagement_date)){{$story->engagement_date}}@else{{old('engagement_date')}}@endif" name="engagement_date" class="form-control" required>
                                        @error('engagement_date')
                                       <div style="color:red">{{ $message }}</div>
                                       @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 mb-4">
                                <div class="row">
                                    <div class="col-xl-4">
                                        <label class="label-1 fw-semibold mt-2">Upload Marriage Photo</label>
                                    </div>
                                    <div class="col-xl-8">
                                        @if(isset($story->weddingphoto))
                                            <input type="file" value="" name="weddingphoto" class="form-control" @if(isset($story->weddingphoto))@else Required @endif>
                                            <div class="col-12 mb-3">
                                            <img src="{{asset('storage/SuccessStory/'.$story->weddingphoto)}}" class="img-fluid maxH-75">
                                            </div>
                                            @error('weddingphoto')
                                            <div style="color:red">{{ $message }}</div>
                                            @enderror
                                        @else
                                        <input type="file" value="" name="weddingphoto" class="form-control" required>
                                            @error('weddingphoto')
                                            <div style="color:red">{{ $message }}</div>
                                            @enderror   
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 mb-4">
                                <div class="row">
                                    <div class="col-xl-4">
                                        <label class="label-1 fw-semibold mt-2">Success Story</label>
                                    </div>
                                    <div class="col-xl-8">
                                        <textarea class="form-control" value="" name="successmessage" rows="3" required>@if(isset($story->successmessage)){{$story->successmessage}}@else{{ old('successmessage') }}@endif</textarea>
                                        @error('successmessage')
                                       <div style="color:red">{{ $message }}</div>
                                       @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 mb-4 text-center">
                                <input type="submit" value="SUBMIT" class="btn btnPrimary">
                            </div>
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