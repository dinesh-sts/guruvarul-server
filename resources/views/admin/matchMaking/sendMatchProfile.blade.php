@extends('admin.layouts.afterLoginLayout')

@section('title') Admin - Matching Members @endsection

@section('pageCSS') @endsection

@section('content')
<!-- Main Content -->
<div class="container pt-3">
    <div class="row">
        <div class="col-xl-9">
            <h3 class="colorSecondary inATitle1">Send Matching Profile</h3>
        </div>
        <div class="col-xl-3 text-end mb-3">
            <a href="{{ route('admin.matchMaking') }}" class="btn btnSecondary inBorderRightLightGrey inMatchBackBtn" id="emailButton">
                <i class="fas fa-chevron-left pe-1"></i> Back
            </a>
        </div>
        
        <div class="col-12 mb-3">
            <div class="card inMemberActionPanel inBorderColor1">
                <div class="card-body">
                    <h4 class="font-15 colorSecondary">Send Matching Profile</h4>
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <label class="btn btnSecondary inBorderRightLightGrey" for="inCheckbox">
                            <input type="checkbox" value="selectedMembers[]" name="inCheckbox" id="inCheckbox" class="form-check-input inMT-3">
                            <span class="ms-1 d-none d-lg-inline">Select All</span>
                        </label>
                        <a href="javascript:void(0);" class="btn btnSecondary inBorderRightLightGrey" id="emailButton">
                            <i class="fas fa-envelope"></i>
                            <span class="ps-1 d-none d-lg-inline">Send Email To - <b>
                                @if(isset($id->matri_id)) {{$id->matri_id}} @endif 
                                @if(isset($id->firstname))({{$id->firstname}}@endif 
                                @if(isset($id->lastname)){{$id->lastname}})@endif</b>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-12">
            <form action="{{ route('matchmaking.mail.send') }}" method="post">
                @csrf
                @method('PATCH')
                @foreach ($matchmaking as $member)
                <?php $email= DB::table('matches_lists')->where('other_id',$member->id)->first(); ?>

                <div class="card mb-3 inMainResultCard inBorderColor1">
                    <div class="row g-0">
                        <div class="col-lg-3 col-md-3">
                            <label class="inMainResultCheck" for="checkboxprofile">
                                <input type="checkbox" value="{{$member->id}}" name="selectedMembers[]" name="checkbox" id="checkbox" class="checkbox">
                            </label>
                            
                            <a href="" class="text-decoration-none">
                                @if(isset($member))
                                <?php  $filePath = '/userImages/'.$member->photo1; ?>
                                @if($member->photo1 != "" && Storage::disk('public')->exists($filePath))
                                        <img src="{{asset('storage/userImages/'.$member->photo1)}}" class="img-fluid rounded w-100">
                                    @else
                                        @if($member->gender == "Male")
                                            <img src="{{asset('user/img/male.jpg')}}" class="img-fluid rounded w-100">
                                        @else
                                            <img src="{{asset('user/img/female.jpg')}}" class="img-fluid rounded w-100">
                                        @endif
                                    @endif
                                @endif
                            </a>
                        </div>
                        
                        <div class="col-lg-9 col-md-9">
                            <div class="card-body">
                                <a href="" class="text-decoration-none">
                                    <div class="row">
                                        <div class="col-lg-6 col-12">
                                            <h5 class="card-title">@if(isset($member->firstname))({{$member->firstname}}@endif @if(isset($member->lastname)){{$member->lastname}})@endif</h5>
                                            <h6 class="mb-3">@if(isset($member->matri_id)){{$member->matri_id}}@endif &nbsp;&nbsp;|&nbsp;&nbsp; Profile Created by @if(isset($member->profileby)){{$member->profileby}}@else Not Available @endif</h6>
                                        </div>
                                        <div class="col-lg-6 col-12 inAResultStatus mb-3 mb-md-0">
                                            <div class="row">
                                                <div class="col-5">
                                                    @if($member->status === "Active")<i class="fa-solid fa-thumbs-up pe-2"></i><span class="">Approved</span> @endif
                                                </div>
                                                <div class="col-5">
                                                    @if($member->status === "Inactive")<i class="fa-solid fa-thumbs-down pe-2"></i><span class="">Unapproved</span> @endif
                                                </div>
                                                <div class="col-5">
                                                    @if($member->status === "Paid")<i class="fa-solid fa-money-check-dollar pe-2"></i><span class="">Paid</span>@endif
                                                </div>
                                                <div class="col-5">
                                                    @if($member->fstatus == "Featured")<i class="fa-solid fa-star pe-2"></i><span class="">Featured</span>@endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <h5 class="mb-3 font-14 text-danger">@if($email == NULL )This profile have not been sent yet @else This profile have been sent Mail @endif</h5>
                                        </div>
                                    </div>
                                    <div class="row inAResultDatails">
                                        <div class="col-lg-6 mb-1">
                                            <div class="row">
                                                <div class="col-4">
                                                    <b>Email</b>
                                                </div>
                                                <div class="col">
                                                    <span>@if(isset($member->email)){{$member->email}}@else Not Available @endif</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mb-1">
                                            <div class="row">
                                                <div class="col-4">
                                                    <b>Mobile</b>
                                                </div>
                                                <div class="col">
                                                    <span>@if(isset($member->mobile)){{$member->mobile}}@else Not Available @endif</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mb-1">
                                            <div class="row">
                                                <div class="col-4">
                                                    <b>Gender</b>
                                                </div>
                                                <div class="col">
                                                    <span>@if(isset($member->gender)){{$member->gender}}@else Not Available @endif</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mb-1">
                                            <div class="row">
                                                <div class="col-4">
                                                    <b>Age</b>
                                                </div>
                                                <div class="col">
                                                    <?php   
                                                    $from = "";
                                                    if(isset($member->birthdate))
                                                    {
                                                        $from = Carbon\Carbon::parse($member->birthdate);
                                                    }
                                                        $to = Carbon\Carbon::now();
                                                        $age =$from->diff($to)->y;
                                                    ?>
                                                    <span>@if(isset($member->birthdate)){{$age}} Yrs @else Not Available @endif</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mb-1">
                                            <div class="row">
                                                <div class="col-4">
                                                    <b>Height</b>
                                                </div>
                                                <div class="col">
                                                    <span>@if(isset($member->height)){{$member->hei->height}}@else Not Available @endif</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mb-1">
                                            <div class="row">
                                                <div class="col-4">
                                                    <b>Religion</b>
                                                </div>
                                                <div class="col">
                                                    <span>@if(isset($member->religion)){{$member->rel->religion_name}}@else Not Available @endif</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mb-1">
                                            <div class="row">
                                                <div class="col-4">
                                                    <b>Caste</b>
                                                </div>
                                                <div class="col">
                                                    <span>@if(isset($member->caste)){{$member->cast->caste_name}}@else Not Available @endif</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mb-1">
                                            <div class="row">
                                                <div class="col-4">
                                                    <b>Location</b>
                                                </div>
                                                <div class="col">
                                                    <span>
                                                    @if(isset($member->country_id)){{$member->country->country_name}}@else Not Available @endif   
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <!-- Visible in large device only -->
                                <div class="d-none d-lg-block">
                                    <div class="row mt-4 inMainResultAction mt-lg-2 mt-xl-4">
                                        <div class="col col-xl-2 text-center">
                                            <a href="{{ route('admin.view-profile',$member->matri_id) }}">
                                                <i class="fas fa-eye"></i>
                                                <p>View Profile</p>
                                            </a>
                                        </div>
                                        <div class="col col-xl-2 text-center">
                                            <a href="{{ route('admin.edit-profile',$member->matri_id) }}">
                                                <i class="fas fa-pen"></i>
                                                <p>Edit Profile</p>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.Visible in large device only -->
                            </div>
                        </div>
                    
                        <!-- Visible in mobile device only -->
                        <div class="col-md-12 pe-3 ps-3 d-block d-lg-none">
                            <div class="row mt-2 inMainResultAction mt-lg-2 mt-xl-4">
                                <div class="col-4 col-xl-2 text-center mb-3">
                                    <a href="{{ route('admin.view-profile',$member->matri_id) }}">
                                        <i class="fas fa-eye"></i>
                                        <p>View Profile</p>
                                    </a>
                                </div>
                                <div class="col-4 col-xl-2 text-center mb-3">
                                    <a href="{{ route('admin.edit-profile',$member->matri_id) }}">
                                        <i class="fas fa-pen"></i>
                                        <p>Edit Profile</p>
                                    </a>
                                </div>
                                
                            </div>
                        </div>
                        <!-- /.Visible in mobile device only -->
                    </div>
                </div>
                @endforeach
                <input type="hidden" name="action" id="selectedAction" value="">
                <input type="hidden" name="member_id" id="memberid" value="@if(isset($id->id)){{$id->id}}@endif">
                <input type="hidden" name="membermatri_id" id="membermatri_id" value="@if(isset($id->matri_id)){{$id->matri_id}}@endif">
                <input type="hidden" name="email" id="memberemail" value="@if(isset($id->email)){{$id->email}}@endif">
                <button type="submit" id="performActionButton" class="btn btnSecondary d-none">Perform Action</button>
            </form>
            <div class="d-flex justify-content-center">
                {!! $matchmaking->links() !!}
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
        $('#emailButton').on('click', function () {
            if ($('.checkbox:checked').length === 0) {
                alert('Please select at least one member to perform this action.');
            }  else {
                var action = 'approve'; 
                $('#selectedAction').val(action);
                $('#memberid').val();
                $('#memberemail').val();
                $('#membermatri_id').val();
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
      
    });
</script>
@endsection