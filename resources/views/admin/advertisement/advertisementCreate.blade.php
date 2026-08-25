<!-- Main layout -->
@extends('admin.layouts.afterLoginLayout')

<!-- Page title -->
@section('title') Admin - Add / Edit Advertisement @endsection

<!-- Additional page css add here -->
@section('pageCSS') @endsection

@section('content')
<!-- Main Content -->
<div class="container pt-3">
    <div class="row mb-3 inMemberTopPanel">
        <div class="col-xl-9">
            <h3 class="colorSecondary inATitle1">
                @if(isset($advertisement))
                    Edit Advertisement
                @else
                    Add Advertisement
                @endif
            </h3>
        </div>
        <div class="col-xl-3 text-end">
            <a href="{{ route('admin.advertisementList') }}" class="btn btnPrimary">
                <i class="fas fa-chevron-left pe-1"></i>Back
            </a>   
        </div>
    </div>
    <div class="row">
        <div class="col-xl-8 offset-xl-2 mb-3">
            <div class="card inBorderColor1 inAAddMembership mb-5">
                <div class="card-body pt-5">
                    <form action="{{ isset($advertisement) ? route('admin.advertisementUpdate', $advertisement->id) : route('admin.advertisementPost') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-xl-12 mb-4">
                                <div class="row">
                                    <div class="col-xl-4">
                                        <label class="label-1 fw-semibold mt-2">Advertisement Name</label>
                                    </div>
                                    <div class="col-xl-8">
                                        <input type="text" value="@if(isset($advertisement->adv_name)){{ $advertisement->adv_name }}@else{{ old('adv_name') }}@endif" name="adv_name" class="form-control @error('adv_name') is-invalid @enderror" placeholder="Enter advertisement name" required>
                                    </div>
                                    @error('adv_name')
                                        <p class="mb-0 mt-1 text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xl-12 mb-4">
                                <div class="row">
                                    <div class="col-xl-4">
                                        <label class="label-1 fw-semibold mt-2">Advertisement URL</label>
                                    </div>
                                    <div class="col-xl-8">
                                        <input type="text" value="@if(isset($advertisement->adv_link)){{ $advertisement->adv_link }}@else{{ old('adv_link') }}@endif" name="adv_link" class="form-control @error('adv_link') is-invalid @enderror" placeholder="Enter advertisement link" required>
                                        @error('adv_link')
                                            <p class="mb-0 mt-1 text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 mb-4">
                                <div class="row">
                                    <div class="col-xl-4">
                                        <label class="label-1 fw-semibold mt-2">Advertisement Size</label>
                                    </div>
                                    <div class="col-xl-8">
                                        <select name="adv_level" class="form-control @error('adv_level') is-invalid @enderror" required>
                                            <option value=""section>Select</option>
                                            <option value="level-1" @if(isset($advertisement->adv_level)) {{ $advertisement->adv_level == "level-1" ? "selected" : '' }}@endif>level-1 (1170px(Width) X 80px(Height))</option>
                                            <option value="level-2" @if(isset($advertisement->adv_level)) {{ $advertisement->adv_level == "level-2" ? "selected" : '' }}@endif>level-2 (250px(Width) X 600px(Height))</option>
                                        </select>
                                        @error('adv_level')
                                            <p class="mb-0 mt-1 text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 mb-4">
                                <div class="row">
                                    <div class="col-xl-4">
                                        <label class="label-1 fw-semibold mt-2">Advertiser's Contact No</label>
                                    </div>
                                    <div class="col-xl-8">
                                        <input type="text" value="@if(isset($advertisement->phone)){{ $advertisement->phone }}@else{{ old('phone') }}@endif" name="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="Enter advertiser's contact no" required>
                                        @error('phone')
                                            <p class="mb-0 mt-1 text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xl-12 mb-4">
                                <div class="row">
                                    <div class="col-xl-4">
                                        <label class="label-1 fw-semibold mt-2">Advertise Image</label>
                                    </div>
                                    @if(isset($advertisement))
                                        @if($advertisement->adv_img != "")
                                            <div class="col-xl-8 mb-3">
                                                <img src="{{asset('storage/advImage/'.$advertisement->adv_img)}}" class="img-fluid inProfileThumb">
                                                <br>
                                                <input type="file" name="adv_img" class="form-control">
                                            </div>
                                        @endif
                                    @else
                                    <div class="col-xl-8">
                                        <input type="file" name="adv_img" class="form-control @error('adv_img') is-invalid @enderror" required>
                                        @error('adv_img')
                                            <p class="mb-0 mt-1 text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-xl-12 mb-4">
                                <div class="row">
                                    <div class="col-xl-4">
                                        <label class="label-1 fw-semibold mt-1">Status</label>
                                    </div>
                                    <div class="col-xl-8">
                                        <div class="form-check form-check-inline pe-3">
                                            <input class="form-check-input" type="radio" value="APPROVED" @if(isset($advertisement)){{ $advertisement->status == "APPROVED" ? "checked" : '' }}@endif name="status" id="flexRadioDefault1" checked required>
                                            <label class="form-check-label" for="flexRadioDefault1">
                                                Approved
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" value="UNAPPROVED" @if(isset($advertisement)){{ $advertisement->status == "UNAPPROVED" ? "checked" : '' }}@endif name="status" id="flexRadioDefault2" required>
                                            <label class="form-check-label" for="flexRadioDefault2">
                                                Unapproved
                                            </label>
                                        </div>
                                        @error('status')
                                            <p class="mb-0 mt-1 text-danger">{{ $message }}</p>
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
</div>
<!-- /.Main Content -->
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