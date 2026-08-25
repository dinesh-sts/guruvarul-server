@extends('admin.layouts.afterLoginLayout')

@section('title') Admin - Logo & Favicon Update @endsection

@section('pageCSS') @endsection

@section('content')
<div class="container pt-3">
    <div class="row">
        <h3 class="colorSecondary inATitle1">Logo & Favicon Update</h3>
        <div class="col-xl-4 mb-3">
            <div class="card inBorderColor1 inAAddMembership mb-5">
                <div class="card-header">
                    <h4 class="card-title">Upload Header Logo</h4>
                </div>
                <div class="card-body ps-4 pe-4">
                <form action="{{ route('admin.uploadLogoUpdate') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12 mb-3">
                            @if(isset($siteconfig))
                            <div class="img-thumbnail">
                                <center class="p-3">
                                    <?php  $filePath = '/siteConfig/'.$siteconfig->web_logo_path; ?>
                                    @if($siteconfig->web_logo_path != "" && Storage::disk('public')->exists($filePath))
                                        <img src="{{asset('storage/siteConfig/'.$siteconfig->web_logo_path)}}" class="img-fluid maxH-75">
                                    @endif
                                </center>
                            </div>
                            @endif
                            <p class="font-monospace mt-2 text-danger mb-0 font-13"><b>Note:</b> Upload Logo size - <b>750px X 205px</b> in <b>.png</b> for better view.</p>
                        </div>
                        <div class="col-12 mb-3">
                            <input type="file" name="web_logo_path" class="form-control"required>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="alert inAPrimaryAlert" role="alert">
                                <p class="mb-0 font-13"><i class="fas fa-info-circle"></i> Only JPEG, JPG, GIF, PNG types are allowed. 2 MB maximum size.</p>
                            </div>
                        </div>
                        <div class="col-12 text-center mb-3">
                            <input type="submit" name="header" value="UPLOAD" class="btn btnPrimary">
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
        <div class="col-xl-4 mb-3">
            <div class="card inBorderColor1 inAAddMembership mb-5">
                <div class="card-header">
                    <h4 class="card-title">Upload Footer Logo</h4>
                </div>
                <div class="card-body ps-4 pe-4">
                    <form action="{{ route('admin.uploadLogoUpdate') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                    <div class="row">
                        <div class="col-12 mb-3">
                            @if(isset($siteconfig))
                            <div class="img-thumbnail">
                                <center class="p-3">
                                    <?php  $filePath = '/siteConfig/'.$siteconfig->web_logo_path2; ?>
                                    @if($siteconfig->web_logo_path2 != "" && Storage::disk('public')->exists($filePath))
                                    <img src="{{asset('storage/siteConfig/'.$siteconfig->web_logo_path2)}}" class="img-fluid maxH-75">
                                    @endif
                                </center>
                            </div>
                            @endif
                            <p class="font-monospace mt-2 text-danger mb-0 font-13"><b>Note:</b> Upload Logo size - <b>750px X 205px</b> in <b>.png</b> for better view.</p>
                        </div>
                        <div class="col-12 mb-3">
                            <input type="file" name="web_logo_path2" class="form-control"required>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="alert inAPrimaryAlert" role="alert">
                                <p class="mb-0 font-13"><i class="fas fa-info-circle"></i> Only JPEG, JPG, GIF, PNG types are allowed. 2 MB maximum size.</p>
                            </div>
                        </div>
                        <div class="col-12 text-center mb-3">
                            <input type="submit" name="footer" value="UPLOAD" class="btn btnPrimary">
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xl-4 mb-3">
            <div class="card inBorderColor1 inAAddMembership mb-5">
                <div class="card-header">
                    <h4 class="card-title">Upload Favicon</h4>
                </div>
                <div class="card-body ps-4 pe-4">
                    <form action="{{ route('admin.uploadLogoUpdate') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                    <div class="row">
                        <div class="col-12 mb-3">
                            @if(isset($siteconfig))
                            <div class="img-thumbnail">
                                <center class="p-3">
                                    <?php  $filePath = '/siteConfig/'.$siteconfig->favicon; ?>
                                    @if($siteconfig->favicon != "" && Storage::disk('public')->exists($filePath))
                                    <img src="{{asset('storage/siteConfig/'.$siteconfig->favicon)}}" class="img-fluid maxH-75">
                                    @endif
                                </center>
                            </div>
                            @endif
                            <p class="font-monospace mt-2 text-danger mb-0 font-13"><b>Note:</b> Upload Favicon size - <b>100px X 100px</b> in <b>.png</b> for better view.</p>
                        </div>
                        <div class="col-12 mb-3">
                            <input type="file" name="favicon" class="form-control"required>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="alert inAPrimaryAlert" role="alert">
                                <p class="mb-0 font-13"><i class="fas fa-info-circle"></i> Only JPEG, JPG, GIF, PNG types are allowed. 2 MB maximum size.</p>
                            </div>
                        </div>
                        <div class="col-12 text-center mb-3">
                            <input type="submit" name="favicon" value="UPLOAD" class="btn btnPrimary">
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