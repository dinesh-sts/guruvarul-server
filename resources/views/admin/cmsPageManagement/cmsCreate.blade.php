<!-- Main layout -->
@extends('admin.layouts.afterLoginLayout')

<!-- Page title -->
@section('title') Admin - Add / Edit CMS Page @endsection

<!-- Additional page css add here -->
@section('pageCSS')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="container pt-3">
    <div class="row mb-3 inMemberTopPanel">
        <div class="col-xl-9">
            <h3 class="colorSecondary inATitle1">
                @if(isset($cmspage))
                    Edit CMS Page
                @else
                    Add CMS Page
                @endif
            </h3>
        </div>
        <div class="col-xl-3 text-end">
            <a href="{{ route('admin.cmsList') }}" class="btn btnPrimary">
                <i class="fas fa-chevron-left pe-1"></i>Back
            </a>   
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 mb-3">
            <div class="card inBorderColor1 inAAddMembership mb-5">
                <div class="card-body pt-5">
                    <form action="{{ isset($cmspage) ? route('admin.cmsUpdate', $cmspage->id) : route('admin.cmsStore') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-xl-12 mb-4">
                                <div class="row">
                                    <div class="col-xl-3">
                                        <label class="label-1 fw-semibold mt-2">Page Title(slug)</label>
                                    </div>
                                    <div class="col-xl-9">
                                        <input type="text" value="@if(isset($cmspage->page_name)){{$cmspage->page_name}}@else{{old('page_name')}}@endif" name="page_name" class="form-control" required>
                                        @error('page_name')
                                        <div style="color:red">{{ $message }}</div>
                                    @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 mb-4">
                                <div class="row">
                                    <div class="col-xl-3">
                                        <label class="label-1 fw-semibold mt-2">CMS Title</label>
                                    </div>
                                    <div class="col-xl-9">
                                        <input type="text" value="@if(isset($cmspage->cms_title)){{$cmspage->cms_title}}@else{{old('cms_title')}}@endif" name="cms_title" class="form-control" required>
                                        @error('cms_title')
                                        <div style="color:red">{{ $message }}</div>
                                    @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 mb-4">
                                <label class="label-1 fw-semibold mt-2">Page Content</label>
                                <textarea id="summernote" name="cms_content"required >@if(isset($cmspage->cms_content)){{$cmspage->cms_content}}@else{{old('cms_content')}}@endif</textarea>
                                @error('cms_content')
                                <div style="color:red">{{ $message }}</div>
                            @enderror
                            </div>
                            <div class="col-xl-12 mb-4">
                                <div class="row">
                                    <div class="col-xl-3">
                                        <label class="label-1 fw-semibold mt-2">Page Placement</label>
                                    </div>
                                    <div class="col-xl-9">
                                        <select name="page_placement" class="form-control" required>
                                            <option value="footer_help_section" 
                                            @if(isset($cmspage->page_placement)){{ $cmspage->page_placement == "footer_help_section" ? "selected" : '' }}  @else @selected(old('page_placement') == "footer_help_section") @endif >Footer - Help & Support Section</option>

                                            <option value="footer_privacy_section" 
                                            @if(isset($cmspage->page_placement)){{ $cmspage->page_placement == "footer_privacy_section" ? "selected" : '' }}  @else @selected(old('page_placement') == "footer_privacy_section") @endif >Footer - Privacy Section</option>

                                            <option value="footer_quicklink_section" 
                                            @if(isset($cmspage->page_placement)){{ $cmspage->page_placement == "footer_quicklink_section" ? "selected" : '' }}  @else @selected(old('page_placement') == "footer_quicklink_section") @endif >Footer - Quick Link Section</option>

                                            <option value="footer_information_section" 
                                            @if(isset($cmspage->page_placement)){{ $cmspage->page_placement == "footer_information_section" ? "selected" : '' }}  @else @selected(old('page_placement') == "footer_information_section") @endif >Footer - Information Section</option>
                                            
                                        </select>
                                        @error('page_placement')
                                        <div style="color:red">{{ $message }}</div>
                                    @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xl-12 mb-4">
                                <div class="row">
                                    <div class="col-xl-3">
                                        <label class="label-1 fw-semibold mt-1">Status</label>
                                    </div>
                                    <div class="col-xl-9">
                                        <div class="form-check form-check-inline pe-3">
                                            <input class="form-check-input" type="radio" value="APPROVED" @if(isset($cmspage->status)){{($cmspage->status=="APPROVED")? "checked" : "" }}@endif name="status" id="flexRadioDefault1" required>
                                            <label class="form-check-label" for="flexRadioDefault1">
                                                Approved
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio"  value="UNAPPROVED" @if(isset($cmspage->status)){{($cmspage->status=="UNAPPROVED")? "checked" : "" }}@endif name="status" id="flexRadioDefault2" required>
                                            <label class="form-check-label" for="flexRadioDefault2">
                                                Unapproved
                                            </label>
                                        </div>
                                        @error('status')
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
</div>
@endsection

@section('pageJS')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        @if(Session::has('message'))
            $('#message').toast('show');
        @endif
        $('#summernote').summernote({
            height: 300,                 // set editor height
            minHeight: null,             // set minimum height of editor
            maxHeight: null,             // set maximum height of editor
            focus: true                  // set focus to editable area after initializing summernote
        });
    });
</script>
@endsection