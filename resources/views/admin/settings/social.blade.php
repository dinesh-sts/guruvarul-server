@extends('admin.layouts.afterLoginLayout')

@section('title') Admin - Social Media Links @endsection

@section('pageCSS') @endsection

@section('content')
<div class="container pt-5">       
    <div class="row">            
        <div class="col-xl-8 offset-xl-2 mb-3">
            <div class="card inBorderColor1 inAAddMembership mb-3">
                <div class="card-header">
                    <h4 class="card-title">Social Media Links</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.socialMediaLinksUpdate') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <h4 class="mb-3 fs-6">Facebook</h4>
                        <div class="row mb-3">
                            <div class="col-xl-6 mb-3">
                                <label class="label-1">Facebook Link</label>
                                <input type="text" name="facebook" value="@if(isset($siteconfig->facebook)){{$siteconfig->facebook}}@endif" class="form-control"required>
                            </div>

                            <div class="col-xl-6 mb-3">
                                <label class="label-1">Status</label>
                                <select name="facebook_status" class="form-control"required>
                                    <option value="" selected>select</option>
                                    <option value="APPROVED" @if(isset($siteconfig->facebook_status)) {{$siteconfig->facebook_status == "APPROVED" ? "selected" : ''}}@endif>APPROVED</option>
                                    <option value="UNAPPROVED" @if(isset($siteconfig->facebook_status)) {{$siteconfig->facebook_status == "UNAPPROVED" ? "selected" : ''}}@endif>UNAPPROVED</option>
                                </select>
                            </div>
                        </div>
                        <h4 class="mb-3 fs-6">Instagram</h4>
                        <div class="row mb-3">
                            <div class="col-xl-6 mb-3">
                                <label class="label-1">Instagram Link</label>
                                <input type="text" name="instagram" value="@if(isset($siteconfig->instagram)){{$siteconfig->instagram}}@endif" class="form-control"required>
                            </div>

                            <div class="col-xl-6 mb-3">
                                <label class="label-1">Status</label>
                                <select name="instagram_status" class="form-control"required>
                                    <option value="" selected>select</option>
                                    <option value="APPROVED" @if(isset($siteconfig->instagram_status)) {{$siteconfig->instagram_status == "APPROVED" ? "selected" : ''}}@endif>APPROVED</option>
                                    <option value="UNAPPROVED" @if(isset($siteconfig->instagram_status)) {{$siteconfig->instagram_status == "UNAPPROVED" ? "selected" : ''}}@endif>UNAPPROVED</option>
                                </select>
                            </div>
                        </div>
                        <h4 class="mb-3 fs-6">Twitter</h4>
                        <div class="row mb-3">
                            <div class="col-xl-6 mb-3">
                                <label class="label-1">Twitter Link</label>
                                <input type="text" name="twitter" value="@if(isset($siteconfig->twitter)){{$siteconfig->twitter}}@endif" class="form-control"required>
                            </div>

                            <div class="col-xl-6 mb-3">
                                <label class="label-1">Status</label>
                                <select name="twitter_status" class="form-control"required>
                                    <option value="" selected>select</option>
                                    <option value="APPROVED" @if(isset($siteconfig->twitter_status)) {{$siteconfig->twitter_status == "APPROVED" ? "selected" : ''}}@endif>APPROVED</option>
                                    <option value="UNAPPROVED" @if(isset($siteconfig->twitter_status)) {{$siteconfig->twitter_status == "UNAPPROVED" ? "selected" : ''}}@endif>UNAPPROVED</option>
                                </select>
                            </div>
                        </div>
                        <h4 class="mb-3 fs-6">LinkedIn</h4>
                        <div class="row mb-3">
                            <div class="col-xl-6 mb-3">
                                <label class="label-1">LinkedIn Link</label>
                                <input type="text" name="linkedin" value="@if(isset($siteconfig->linkedin)){{$siteconfig->linkedin}}@endif" class="form-control"required>
                            </div>

                            <div class="col-xl-6 mb-3">
                                <label class="label-1">Status</label>
                                <select name="linkedin_status" class="form-control"required>
                                    <option value="" selected>select</option>
                                    <option value="APPROVED" @if(isset($siteconfig->linkedin_status)) {{$siteconfig->linkedin_status == "APPROVED" ? "selected" : ''}}@endif>APPROVED</option>
                                    <option value="UNAPPROVED" @if(isset($siteconfig->linkedin_status)) {{$siteconfig->linkedin_status == "UNAPPROVED" ? "selected" : ''}}@endif>UNAPPROVED</option>
                                </select>
                            </div>
                        </div>
                        <h4 class="mb-3 fs-6">Youtube</h4>
                        <div class="row mb-3">
                            <div class="col-xl-6 mb-3">
                                <label class="label-1">Youtube Link</label>
                                <input type="text" name="youtube" value="@if(isset($siteconfig->youtube)){{$siteconfig->youtube}}@endif" class="form-control"required>
                            </div>

                            <div class="col-xl-6 mb-3">
                                <label class="label-1">Status</label>
                                <select name="youtube_status" class="form-control"required>
                                    <option value="" selected>select</option>
                                    <option value="APPROVED" @if(isset($siteconfig->youtube_status)) {{$siteconfig->youtube_status == "APPROVED" ? "selected" : ''}}@endif>APPROVED</option>
                                    <option value="UNAPPROVED" @if(isset($siteconfig->youtube_status)) {{$siteconfig->youtube_status == "UNAPPROVED" ? "selected" : ''}}@endif>UNAPPROVED</option>
                                </select>
                            </div>
                        </div>
                        <h4 class="mb-3 fs-6">Pinterest</h4>
                        <div class="row mb-3">
                            <div class="col-xl-6 mb-3">
                                <label class="label-1">Pinterest Link</label>
                                <input type="text" name="pinterest" value="@if(isset($siteconfig->pinterest)){{$siteconfig->pinterest}}@endif" class="form-control"required>
                            </div>

                            <div class="col-xl-6 mb-3">
                                <label class="label-1">Status</label>
                                <select name="pinterest_status" class="form-control"required>
                                    <option value="" selected>select</option>
                                    <option value="APPROVED" @if(isset($siteconfig->pinterest_status)) {{$siteconfig->pinterest_status == "APPROVED" ? "selected" : ''}}@endif>APPROVED</option>
                                    <option value="UNAPPROVED" @if(isset($siteconfig->pinterest_status)) {{$siteconfig->pinterest_status == "UNAPPROVED" ? "selected" : ''}}@endif>UNAPPROVED</option>
                                </select>
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