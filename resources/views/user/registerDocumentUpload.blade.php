@extends('user.layouts.beforeLoginLayout')

@section('pageCSS')
    
@endsection

<!-- Content Section Start -->
@section('content')
<section class="inLogin mb-5 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-xl-8 offset-xl-2">
                <div class="card">
                    <div class="card-body ps-md-5 pe-md-5 ps-4 pe-4 pt-4 pb-4">
                        <div class="row">
                            <div class="col">
                                    <h4 class="text-center inLoginTitle mb-1">Upload Your Document</h4> 
                                    <p class="text-center mb-4">Upload your identity proof.</p>
                            </div>
                            <div class="col-3">
                                <a href="{{route('user.registerConfirmation')}}" class="btn btnSecondary shadow-sm btn-sm">Skip <i class="fas fa-chevron-right"></i></a>
                            </div>
                        </div>
                        <form method="POST" id="register_form" action="{{route('user.registerDocumentPost')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-xl-6 offset-xl-3 mb-3">
                                    <img src="{{asset('user/img/document-default.jpg')}}" class="img-fluid img-thumbnail">
                                </div>
                                <div class="col-xl-12 inDocumentUpload">
                                    <div class="mb-3 text-center">
                                        <input type="file" name="aadhaar_card" id="documentreg" >
                                        <label for="documentreg" class="btn btnPrimary">
                                            Select Document
                                        </label>
                                        <button type="submit" id="documentregform" class="btn btnSecondary d-none">Perform Action</button>
                                    </div>
                                </div>
                            </div>    
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="toast-container position-fixed position-static bottom-0 end-0 p-3 mb-5 mb-sm-0">
        <div id="mobilevarify" class="toast inToastExpress" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
            <div class="d-flex">
                <div class="toast-body">
                    <strong class="me-auto">Mobile No verified successfully</strong>
                </div>
                <button type="button" class="btn-close me-2 m-auto bg-white p-1" data-bs-dismiss="toast" aria-label="Close"></button>
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
</section>


@endsection

@section('pageJS')
<script type="text/javascript">
    $(document).ready(function () {
        $('#documentreg').on('change',function(){
            $('#documentregform').click();
        });
        @if(Session::has('varify'))
            $('#mobilevarify').toast('show');
        @endif
        @if(Session::has('message'))
            $('#message').toast('show');
        @endif
    });
</script>
@endsection