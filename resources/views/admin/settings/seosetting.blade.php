@extends('admin.layouts.afterLoginLayout')

@section('title') Admin - SEO Setting @endsection

@section('pageCSS') @endsection

@section('content')
<div class="container pt-5">
    <div class="row">            
        <div class="col-xl-8 offset-xl-2 mb-3">
            <div class="card inBorderColor1 inAAddMembership mb-3">
                <div class="card-header">
                    <h4 class="card-title">SEO Settings</h4>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.seoSettingsUpdate')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-xl-12 mb-4">
                                <div class="row">
                                    <div class="col-xl-4">
                                        <label class="label-1 fw-semibold mt-2">Enter Title</label>
                                    </div>
                                    <div class="col-xl-8">
                                        <input type="text" name="title" value="@if(isset($siteconfig->title)){{$siteconfig->title}}@endif" class="form-control"required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 mb-4">
                                <div class="row">
                                    <div class="col-xl-4">
                                        <label class="label-1 fw-semibold mt-2">Enter Keyword</label>
                                    </div>
                                    <div class="col-xl-8">
                                        <input type="text" name="keyword" value="@if(isset($siteconfig->keyword)){{$siteconfig->keyword}}@endif" class="form-control"required>
                                    </div>
                                </div>
                            </div>
                                
                            <div class="col-xl-12 mb-4">
                                <div class="row">
                                    <div class="col-xl-4">
                                        <label class="label-1 fw-semibold mt-2">Enter Description</label>
                                    </div>
                                    <div class="col-xl-8">
                                        <textarea class="form-control" name="description" rows="4"required>@if(isset($siteconfig->description)){{$siteconfig->description}}@endif</textarea>
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