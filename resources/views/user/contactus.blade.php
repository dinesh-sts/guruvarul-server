@extends('user.layouts.beforeLoginLayout')

@section('pageCSS')
    
@endsection

<!-- Content Section Start -->
@section('content')
    <section class="inLogin mb-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body ps-md-5 pe-md-5 ps-4 pe-4 pt-4 pb-4">
                            <h4 class="text-center inLoginTitle mb-4">@if(isset($cms->cms_title)){{$cms->cms_title}}@endif</h4> 
                            <div class="inContactDet">
                                @if(isset($cms->cms_content)){!!$cms->cms_content!!}@endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body ps-md-5 pe-md-5 ps-4 pe-4 pt-4 pb-4">
                            <h4 class="text-center inLoginTitle mb-4">Contact Us</h4> 
                            <form action="{{ route('user.contactUsPost') }}" method="POST">
                                @csrf
                                <div class="form-floating mb-4">
                                    <input type="text" name="name" class="form-control" id="floatingInput" placeholder="Enter Name" required>
                                    <label for="floatingInput">Full Name</label>
                                    @error('name')
                                    <div style="color:red">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-floating mb-4">
                                    <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com" required>
                                    <label for="floatingInput">Email Id</label>
                                    @error('email')
                                    <div style="color:red">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-floating mb-4">
                                    <input type="text" name="mobile" class="form-control" id="floatingInput" placeholder="+912365241526" required>
                                    <label for="floatingInput">Contact No</label>
                                    @error('mobile')
                                    <div style="color:red">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-floating mb-4">
                                    <input type="text" name="subject" class="form-control" id="floatingInput" placeholder="Enter Subject" required>
                                    <label for="floatingInput">Subject</label>
                                    @error('subject')
                                    <div style="color:red">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-floating mb-4">
                                    <input type="text" name="description" class="form-control" id="floatingInput" placeholder="Enter Description" required>
                                    <label for="floatingInput">Description</label>
                                    @error('description')
                                    <div style="color:red">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-2">
                                    <button type="submit" class="btn btnPrimary d-block">SUBMIT</button>
                                </div>
                            </form>
                        </div>
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
    </section>
@endsection

@section('pageJS')
<!-- Owl carousel js -->
<script src="{{asset('user/js/owl.carousel.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        @if(Session::has('message'))
            $('#message').toast('show');
        @endif
    });
</script>
<!-- Owl carousel js -->
@endsection