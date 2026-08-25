@extends('admin.layouts.afterLoginLayout')

@section('title') Admin - Theme Color Change @endsection

@section('pageCSS') @endsection

@section('content')
<div class="container pt-5">       
    <div class="row">            
        <div class="col-xl-8 offset-xl-2 mb-3">
            <form action="{{ route('admin.themeColorChangeUpdate') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card inBorderColor1 inAAddMembership mb-3">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-xl-8">
                                <h4 class="card-title">Theme Color Change</h4>
                            </div>
                            <div class="col-xl-4">
                                <input type="submit" value="RESET TO DEFAULT" class="btn btnSecondary pt-1 pb-1 font-13 mt-1" name="reset">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                            
                        <div class="row mb-3">
                            <div class="col-xl-6">
                                <div class="row mb-3">
                                    <div class="col-xl-6 col-8 mb-3">
                                        <label class="label-1">Primary Color</label>
                                    </div>
                                    <div class="col-xl-6 col-4 mb-3">
                                        <input type="color" value="@if(isset($siteConfig->colorPrimary)){{ $siteConfig->colorPrimary }}@endif" name="colorPrimary">  
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-xl-6 col-8 mb-3">
                                        <label class="label-1">Primary Hover Color</label>
                                    </div>
                                    <div class="col-xl-6 col-4 mb-3">
                                        <input type="color" value="@if(isset($siteConfig->colorPrimaryHover)){{ $siteConfig->colorPrimaryHover }}@endif" name="colorPrimaryHover">  
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="row mb-3">
                                    <div class="col-xl-6 col-8 mb-3">
                                        <label class="label-1">Secondary Color</label>
                                    </div>
                                    <div class="col-xl-6 col-4 mb-3">
                                        <input type="color" value="@if(isset($siteConfig->colorSecondary)){{ $siteConfig->colorSecondary }}@endif" name="colorSecondary">  
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-xl-6 col-8 mb-3">
                                        <label class="label-1">Secondary Hover Color</label>
                                    </div>
                                    <div class="col-xl-6 col-4 mb-3">
                                        <input type="color" value="@if(isset($siteConfig->colorSecondaryHover)){{ $siteConfig->colorSecondaryHover }}@endif" name="colorSecondaryHover">  
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12 mb-4 text-center">
                            <input type="submit" value="UPDATE" class="btn btnPrimary" name="update">
                        </div>
                    </div>
                </div>
            </form>
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