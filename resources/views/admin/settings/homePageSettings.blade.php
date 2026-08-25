@extends('admin.layouts.afterLoginLayout')

@section('title') Admin -  Home Page Configuration @endsection

@section('pageCSS') @endsection

@section('content')
<div class="container pt-3">
    <h3 class="colorSecondary inATitle1">Home Page Configuration</h3>
</div>

<div class="container mb-5">
    <div class="row">
        <div class="col-xl-4 mb-4">
            <div class="card inBorderColor1 inAAddMembership">
                <div class="card-header">
                    <h4 class="card-title">Upload Banner 1</h4>
                </div>
                <div class="card-body ps-4 pe-4">
                    <form action="{{route('admin.uploadBannerUpdate')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-12 mb-3">
                                @if(isset($siteconfig))
                                <div class="img-thumbnail">
                                    <center class="p-3">
                                        <?php  $filePath = '/siteConfig/'.$siteconfig->banner1; ?>
                                        @if($siteconfig->banner1 != "" && Storage::disk('public')->exists($filePath))
                                            <img src="{{asset('storage/siteConfig/'.$siteconfig->banner1)}}" class="img-fluid maxH-75">
                                        @endif
                                    </center>
                                </div>
                                @endif
                                <p class="font-monospace mt-2 text-danger mb-0 font-13"><b>Note:</b> Upload banner size - <b>1351px X 905px</b> in <b>.jpg</b> for better view.</p>
                            </div>
                            <div class="col-12 mb-3">
                                <input type="file" name="banner1" class="form-control"required>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="alert inAPrimaryAlert" role="alert">
                                    <p class="mb-0 font-13"><i class="fas fa-info-circle"></i> Only JPEG & JPG types are allowed. 1 MB maximum size.</p>
                                </div>
                            </div>
                            <div class="col-12 text-center mb-3">
                                <input type="submit" name="banner1" value="UPLOAD" class="btn btnPrimary">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xl-4 mb-4">
            <div class="card inBorderColor1 inAAddMembership">
                <div class="card-header">
                    <h4 class="card-title">Upload Banner 2</h4>
                </div>
                <div class="card-body ps-4 pe-4">
                    <form action="{{ route('admin.uploadBannerUpdate') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12 mb-3">
                            @if(isset($siteconfig))
                            <div class="img-thumbnail">
                                <center class="p-3">
                                    <?php  $filePath = '/siteConfig/'.$siteconfig->banner2; ?>
                                    @if($siteconfig->banner1 != "" && Storage::disk('public')->exists($filePath))
                                    <img src="{{asset('storage/siteConfig/'.$siteconfig->banner2)}}" class="img-fluid maxH-75">
                                    @endif
                                </center>
                            </div>
                            @endif
                            <p class="font-monospace mt-2 text-danger mb-0 font-13"><b>Note:</b> Upload banner size - <b>1351px X 905px</b> in <b>.jpg</b> for better view.</p>
                        </div>
                        <div class="col-12 mb-3">
                            <input type="file" name="banner2" class="form-control"required>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="alert inAPrimaryAlert" role="alert">
                                <p class="mb-0 font-13"><i class="fas fa-info-circle"></i> Only JPEG & JPG types are allowed. 1 MB maximum size.</p>
                            </div>
                        </div>
                        <div class="col-12 text-center mb-3">
                            <input type="submit"  name="banner2" value="UPLOAD" class="btn btnPrimary">
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
        <div class="col-xl-4 mb-4">
            <div class="card inBorderColor1 inAAddMembership">
                <div class="card-header">
                    <h4 class="card-title">Upload Banner 3</h4>
                </div>
                <div class="card-body ps-4 pe-4">
                    <form action="{{ route('admin.uploadBannerUpdate') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12 mb-3">
                            @if(isset($siteconfig))
                            <div class="img-thumbnail">
                                <center class="p-3">
                                    <?php  $filePath = '/siteConfig/'.$siteconfig->banner3; ?>
                                    @if($siteconfig->banner3 != "" && Storage::disk('public')->exists($filePath))
                                    <img src="{{asset('storage/siteConfig/'.$siteconfig->banner3)}}" class="img-fluid maxH-75">
                                    @endif
                                </center>
                            </div>
                            @endif
                            <p class="font-monospace mt-2 text-danger mb-0 font-13"><b>Note:</b> Upload banner size - <b>1351px X 905px</b> in <b>.jpg</b> for better view.</p>
                        </div>
                        <div class="col-12 mb-3">
                            <input type="file" name="banner3" class="form-control"required>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="alert inAPrimaryAlert" role="alert">
                                <p class="mb-0 font-13"><i class="fas fa-info-circle"></i> Only JPEG & JPG types are allowed. 1 MB maximum size.</p>
                            </div>
                        </div>
                        <div class="col-12 text-center mb-3">
                            <input type="submit" name="banner3" value="UPLOAD" class="btn btnPrimary">
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div> 
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card inBorderColor1 inAAddMembership mb-5 mt-3">
                <div class="card-header">
                    <h4 class="card-title">Homepage Configuration</h4>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.homepageConfigUpdate')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-xl-6 mb-4">
                                <div class="row">
                                    <div class="col-xl-5">
                                        <label class="label-1 fw-semibold mt-2">Homepage Register Form</label>
                                    </div>
                                    <div class="col-xl-7">
                                        <select name="homepage_register" class="form-select" required>
                                            <option value="show" @if(isset($siteconfig->homepage_register)) {{ $siteconfig->homepage_register == "show" ? "selected" : '' }}@endif>Show</option>
                                            <option value="hide" @if(isset($siteconfig->homepage_register)) {{$siteconfig->homepage_register == "hide" ? "selected" : ''}}@endif>Hide</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 mb-4">
                                <div class="row">
                                    <div class="col-xl-5">
                                        <label class="label-1 fw-semibold mt-2">Homepage Search</label>
                                    </div>
                                    <div class="col-xl-7">
                                        <select name="homepage_search" class="form-select" required>
                                            <option value="show" @if(isset($siteconfig->homepage_search)) {{ $siteconfig->homepage_search == "show" ? "selected" : '' }}@endif>Show</option>
                                            <option value="hide" @if(isset($siteconfig->homepage_search)) {{$siteconfig->homepage_search == "hide" ? "selected" : ''}}@endif>Hide</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 mb-4">
                                <div class="row">
                                    <div class="col-xl-5">
                                        <label class="label-1 fw-semibold mt-2">Homepage Simple Step</label>
                                    </div>
                                    <div class="col-xl-7">
                                        <select name="homepage_steps" class="form-select" required>
                                            <option value="show" @if(isset($siteconfig->homepage_steps)) {{ $siteconfig->homepage_steps == "show" ? "selected" : '' }}@endif>Show</option>
                                            <option value="hide" @if(isset($siteconfig->homepage_steps)) {{$siteconfig->homepage_steps == "hide" ? "selected" : ''}}@endif>Hide</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 mb-4">
                                <div class="row">
                                    <div class="col-xl-5">
                                        <label class="label-1 fw-semibold mt-2">Homepage Featured Bride</label>
                                    </div>
                                    <div class="col-xl-7">
                                        <select name="homepage_fbride" class="form-select" required>
                                            <option value="show" @if(isset($siteconfig->homepage_fbride)) {{ $siteconfig->homepage_fbride == "show" ? "selected" : '' }}@endif>Show</option>
                                            <option value="hide" @if(isset($siteconfig->homepage_fbride)) {{$siteconfig->homepage_fbride == "hide" ? "selected" : ''}}@endif>Hide</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 mb-4">
                                <div class="row">
                                    <div class="col-xl-5">
                                        <label class="label-1 fw-semibold mt-2">Homepage Featured Groom</label>
                                    </div>
                                    <div class="col-xl-7">
                                        <select name="homepage_fgroom" class="form-select" required>
                                            <option value="show" @if(isset($siteconfig->homepage_fgroom)) {{ $siteconfig->homepage_fgroom == "show" ? "selected" : '' }}@endif>Show</option>
                                            <option value="hide" @if(isset($siteconfig->homepage_fgroom)) {{$siteconfig->homepage_fgroom == "hide" ? "selected" : ''}}@endif>Hide</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 mb-4">
                                <div class="row">
                                    <div class="col-xl-5">
                                        <label class="label-1 fw-semibold mt-2">Homepage Success Story</label>
                                    </div>
                                    <div class="col-xl-7">
                                        <select name="homepage_success_story" class="form-select" required>
                                            <option value="show" @if(isset($siteconfig->homepage_success_story)) {{ $siteconfig->homepage_success_story == "show" ? "selected" : '' }}@endif>Show</option>
                                            <option value="hide" @if(isset($siteconfig->homepage_success_story)) {{$siteconfig->homepage_success_story == "hide" ? "selected" : ''}}@endif>Hide</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 text-center">
                                <input type="submit" name="submit" value="SUBMIT" class="btn btnPrimary">
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