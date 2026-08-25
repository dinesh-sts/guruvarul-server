@extends('admin.layouts.afterLoginLayout')

@section('title') Admin - Profile Deactive Request @endsection

@section('pageCSS') @endsection

@section('content')
<div class="container pt-3">
    <div class="row">
        <h3 class="colorSecondary inATitle1">Profile Deactive Request</h3>

        <!-- All member top bar -->
        @include('admin.parts.memberTopBar')
        <!-- /. All member top bar -->
        
        <div class="col-12 mb-3">
            <div class="card inMemberActionPanel inBorderColor1">
                <div class="card-body">
                    <h4 class="font-15 colorSecondary">Profile Action</h4>
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <label class="btn btnSecondary inBorderRightLightGrey" for="inCheckbox">
                            <input type="checkbox" value="selectedMembers[]" name="inCheckbox" id="inCheckbox" class="form-check-input inMT-3">
                            <span class="ms-1 d-none d-lg-inline">Select All</span>
                        </label>
                        <a href="javascript:void(0);" class="btn btnSecondary inBorderRightLightGrey"  id="yes">
                            <i class="fas fa-thumbs-up"></i><span class="ps-1 d-none d-lg-inline">Yes</span>
                        </a>
                        {{-- <a href="javascript:void(0);" class="btn btnSecondary inBorderRightLightGrey" id="no">
                            <i class="fas fa-thumbs-down pe-1"></i><span class="ps-1 d-none d-lg-inline">No</span>
                        </a> --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <form action="{{ route('member.profiledeactiveallstatus') }}" method="post">
                @csrf
                @method('PATCH')
         
                @if($paginator == null)
                    <img src="{{ asset('admin/img/nodata.jpg') }}" class="img-fluid rounded">
                @else
                    @foreach ($paginator as $profile)
                    <div class="card mb-3 inMainResultCard inBorderColor1">
                        <div class="row g-0">
                            <div class="col-lg-2 col-md-2">
                                <label class="inMainResultCheck" for="checkboxprofile">
                                    <input type="checkbox" value="{{$profile['profile']->id}}" name="selectedMembers[]" name="checkbox" id="checkbox" class="checkbox">
                                </label>
                                <a href="" class="text-decoration-none">
                                    <?php  $filePath = '/userImages/'.$profile['registerData']->photo1; ?>
                                        @if($profile['registerData']->photo1 != "" && $profile['registerData']->photo1_approve == "APPROVED" && Storage::disk('public')->exists($filePath))
                                            <img src="{{asset('storage/userImages/'.$profile['registerData']->photo1)}}" class="img-fluid rounded w-100">
                                        @elseif($profile['registerData']->photo1 != ""  && $profile['registerData']->gender == "Female" && $profile['registerData']->photo1_approve == "PENDING" && Storage::disk('public')->exists($filePath))
                                            <img src="{{asset('admin/img/femalepending.jpg')}}" class="card-img-top">
                                        @elseif($profile['registerData']->photo1 != ""  && $profile['registerData']->gender == "Male" && $profile['registerData']->photo1_approve == "PENDING" && Storage::disk('public')->exists($filePath))
                                            <img src="{{asset('admin/img/malepending.jpg')}}" class="card-img-top">
                                        @else
                                            @if($profile['registerData']->gender == "Male")
                                                <img src="{{asset('admin/img/male.jpg')}}" class="card-img-top">
                                            @else
                                                <img src="{{asset('admin/img/female.jpg')}}" class="card-img-top">
                                            @endif
                                        @endif
                                </a>
                            </div>
                            <div class="col-lg-6 col-md-10">
                                <div class="card-body">
                                    <a href="{{route('admin.view-profile',$profile['registerData']->matri_id)}}" class="text-decoration-none">
                                        <div class="row">
                                            <div class="col-7">
                                                <h5 class="card-title">@if(isset($profile['registerData']->firstname)){{$profile['registerData']->firstname}}@endif @if(isset($profile['registerData']->lastname)){{$profile['registerData']->lastname}}@endif</h5>
                                                <h6 class="mb-3">@if(isset($profile['registerData']->matri_id)){{$profile['registerData']->matri_id}}@endif &nbsp;&nbsp;|&nbsp;&nbsp; Profile Created by @if(isset($profile['registerData']->profileby)){{$profile['registerData']->profileby}}@endif</h6>
                                                <!-- Visible In Large Device Only -->
                                                <div class="d-none d-lg-block">
                                                    <div class="row inAResultStatus">
                                                        @if($profile['registerData']->status == "Paid")
                                                        <div class="col-5">
                                                            <i class="fa-solid fa-money-check-dollar pe-2"></i><span class="">Paid</span>
                                                        </div>  
                                                        @elseif($profile['registerData']->status == "Active")
                                                        <div class="col-5">
                                                            <i class="fas fa-thumbs-up"></i><span class="">Approve</span>
                                                        </div>
                                                        @elseif($profile['registerData']->status == "Inactive")
                                                        <div class="col-5">
                                                        <i class="fas fa-thumbs-down"></i><span class="">Unapprove</span>
                                                        </div>
                                                        @elseif($profile['registerData']->status == "Suspended")
                                                        <div class="col-5">
                                                        <i class="fas fa-times"></i><span class="">Suspended</span>
                                                        </div>
                                                        @endif
                                                        @if($profile['registerData']->fstatus == "Featured")
                                                        <div class="col">
                                                            <i class="fa-solid fa-star pe-2"></i><span class="">Featured</span>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <!-- Visible In Large Device Only -->
                                            </div>
                                            <!-- Visible In Small Device Only -->
                                            <div class="col-5 d-block d-lg-none">
                                                <div class="row inAResultStatus">
                                                    @if($profile['registerData']->status == "Paid")
                                                    <div class="col-5">
                                                        <i class="fa-solid fa-money-check-dollar pe-2"></i><span class="">Paid</span>
                                                    </div>  
                                                    @elseif($profile['registerData']->status == "Active")
                                                    <div class="col-5">
                                                        <i class="fas fa-thumbs-up"></i><span class="">Approve</span>
                                                    </div>
                                                    @elseif($profile['registerData']->status == "Inactive")
                                                    <div class="col-5">
                                                    <i class="fas fa-thumbs-down"></i><span class="">Unapprove</span>
                                                    </div>
                                                    @elseif($profile['registerData']->status == "Suspended")
                                                    <div class="col-5">
                                                    <i class="fas fa-times"></i><span class="">Suspended</span>
                                                    </div>
                                                    @endif
                                                    @if($profile['registerData']->fstatus == "Featured")
                                                    <div class="col">
                                                        <i class="fa-solid fa-star pe-2"></i><span class="">Featured</span>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <!-- /.Visible In Small Device Only -->
                                        </div>
                                        <p class="card-text mt-lg-4 inAProfileDeactiveReason"><span class="fw-semibold badge bg-dark me-2">Reason&nbsp;:</span><span class="text-danger">{{$profile['profile']->reason}}</span></p>
                                    </a> 
                                </div>
                            </div>
                    @if($profile['profile']->status == NULL)
                    <div class="col-lg-4 p-3 text-center mt-lg-4">
                        <div class="row">
                            <div class="col-xl-12">
                                <h5 class="font-15 colorSecondary">Want to deactive this profile?</h5>
                            </div>
                            <div class="col-xl-12 inAProfileDeactiveBtn mt-2">
                                <a href="{{route('member.profileStatus',$profile['profile']->id)}}" class="btn btnPrimary"><i class="fas fa-check pe-2"></i>Yes</a>
                                <a href="{{route('member.profileStatus',$profile['profile']->id)}}" class="btn btnSecondary"><i class="fas fa-times pe-2"></i>No</a>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="col-lg-4 p-3 text-center mt-lg-4">
                        <div class="row">
                            <div class="col-xl-12">
                                <h5 class="font-15 colorSecondary">Status</h5>
                            </div>
                            <div class="col-xl-12 inAProfileDeactiveBtn mt-2">
                                <p><h3 class="badge bg-dark">@if(isset($profile['registerData']->status)){{$profile['registerData']->status}}@endif</h3></p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
            <input type="hidden" name="action" id="selectedAction" value="">
            <button type="submit" id="performActionButton" class="btn btnSecondary d-none">Perform Action</button>
        </form>
        <div class="d-flex justify-content-center">
            {!! $paginator->links() !!}
        </div>
        @endif
        </div>
    </div>
</div>
@include('admin.parts.searchModel')

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
@endsection

@section('pageJS')
<script type="text/javascript">
    $(document).ready(function () {
        @if(Session::has('message'))
            $('#message').toast('show');
        @endif
        $('#inCheckbox').on('click', function () {
            if (this.checked) {
                $('.checkbox').each(function () {
                    this.checked = true;
                });
            } else {
                $('.checkbox').each(function () {
                    this.checked = false;
                });
            }
        });
        $('#yes').on('click', function () {
            if ($('.checkbox:checked').length === 0) {
                alert('Please select at least one member to perform this action.');
            }  else {
                var action = 'Yes'; 
                $('#selectedAction').val(action);
                $('#performActionButton').click(); 
            }
        });
        $('#no').on('click', function () {
            if ($('.checkbox:checked').length === 0) {
                alert('Please select at least one member to perform this action.');
            }  else {
                var action = 'No'; 
                $('#selectedAction').val(action);
                $('#performActionButton').click(); 
            }
        });

        $('.inCheckbox').on('click', function () {
            if ($('.checkbox:checked').length === $('.checkbox').length) {
                $('#inCheckbox').prop('checked', true);
            } else {
                $('#inCheckbox').prop('checked', false);
            }
        });  

          //age selcted
          $('#ageToSelect').change(function () {
            var selectedAgeTo = parseInt($(this).val());
            $('#ageFromSelect option').prop('disabled', false);
        
            $('#ageFromSelect option').each(function () {
                var ageValue = parseInt($(this).val());
                if (ageValue <= selectedAgeTo) {
                    $(this).prop('disabled', true);
                    var defaultSelectedValue = ageValue+1; 
                    $('#ageFromSelect').val(defaultSelectedValue);
                }
            
            });
            $('#ageFromSelect').prop('disabled', false);
        });
        //religion cast selected dropdown
        $('#religion-dropdown').on('change', function () {
            var religion_id = this.value;
            $("#caste-dropdown").html('');
            $.ajax({
                url: "{{ route('fetchCaste') }}",
                type: "POST",
                data: {
                    religion_id: religion_id,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (result) {
                    $('#caste-dropdown').html('<option value="">-- Select State --</option>');
                    $.each(result.caste, function (key, value) {
                        $("#caste-dropdown").append('<option value="' + value
                            .id + '">' + value.caste_name + '</option>');
                    });
                }
            });
        });
    });
</script>
@endsection