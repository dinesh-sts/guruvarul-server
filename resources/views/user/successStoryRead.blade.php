@extends('user.layouts.beforeLoginLayout')

@section('pageCSS')
    
@endsection

<!-- Content Section Start -->
@section('content')

    <!-- Page Header -->
    <section class="inPageHeader">
        <div class="container">
            <h2 class="text-center mb-2">@if(isset($story->groomname)){{$story->groomname}}@endif & @if(isset($story->bridename)){{$story->bridename}}@endif</h2>
            <h6 class="mb-3 text-center">POSTED ON - <span class="colorPrimary">@if(isset($story->created_at)){{$story->created_at->format('d M Y')}}@endif</span></h6>
        </div>
    </section>
    <!-- /.Page Header -->

    <!-- Success Story Full -->
    <section class="inSuccessCard mb-5">
        <div class="container">
            <div class="row">
                <div class="col-xl-10 offset-xl-1 text-center">
                    <div class="row">
                        <div class="col-xl-12">
                            <?php  $filePath = '/successStory/'.$story->weddingphoto; ?>
                            @if($story->weddingphoto != "" && Storage::disk('public')->exists($filePath))
                            <img src="{{asset('storage/successStory/'.$story->weddingphoto)}}" class="img-fluid border-radius-5">
                            @endif
                        </div>
                        <div class="col-xl-12 mt-4">
                            <p>@if(isset($story->successmessage)){{$story->successmessage}}@endif</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('pageJS')
@endsection