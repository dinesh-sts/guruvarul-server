@extends('admin.layouts.afterLoginLayout')

@section('title') Admin - Watermark Update @endsection

@section('pageCSS') @endsection

@section('content')
<div class="container pt-3">
    <div class="row">
        <h3 class="colorSecondary inATitle1">Watermark Update</h3>
        <div class="col-xl-6 offset-xl-3 mb-3">
            <div class="card inBorderColor1 inAAddMembership mb-5">
                <div class="card-header">
                    <h4 class="card-title">Upload Watermark</h4>
                </div>
                
                <form action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body ps-4 pe-4">
                        <div class="row">
                            <div class="col-12 mb-3">
                                @if(isset($siteconfig))
                                <div class="img-thumbnail">
                                    <center class="p-3">
                                        <?php  $filePath = '/SiteConfig/'.$siteconfig->watermark; ?>
                                        @if($siteconfig->watermark != "" && Storage::disk('public')->exists($filePath))
                                        <img src="{{asset('storage/SiteConfig/'.$siteconfig->watermark)}}" class="img-fluid maxH-75">
                                        @endif
                                    </center>
                                </div>
                                @endif
                                <p class="font-monospace mt-2 text-danger mb-0 font-13"><b>Note:</b> Upload banner size - <b>25px X 250px</b> in <b>.png</b> for better view.</p>
                            </div>
                            <div class="col-12 mb-3">
                                <input type="file" name="watermark" class="form-control">
                            </div>
                            <div class="col-12 mb-3">
                                <div class="alert inAPrimaryAlert" role="alert">
                                    <p class="mb-0 font-13"><i class="fas fa-info-circle"></i> Only .PNG types are allowed. 500Kb maximum size.</p>
                                </div>
                            </div>
                            <div class="col-12 text-center mb-3">
                                <input type="submit" value="UPLOAD" class="btn btnPrimary">
                            </div>
                        </div>
                    </div>
                </form>
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