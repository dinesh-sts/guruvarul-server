@extends('admin.layouts.afterLoginLayout')

@section('title') Admin - Matching Members @endsection

@section('pageCSS') 
    <link rel="stylesheet" href="{{ asset('admin/css/prism.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/chosen.css') }}">
@endsection

@section('content')
<!-- Main Content -->
<div class="container pt-3">
    <div class="row">
        <h3 class="colorSecondary inATitle1">Custom Match Making</h3>

        @include('admin.parts.matchmakingTopBar')
        
        <div class="col-12">
            @foreach ($paginator as $member)
            <div class="card mb-3 inMainResultCard inBorderColor1">
                <div class="row g-0">
                    <div class="col-lg-3 col-md-3">
                        <label class="inMainResultCheck" for="checkboxprofile">
                            <input type="checkbox" value="{{$member['member_data']->id}}" name="selectedMembers[]" name="checkbox" id="checkbox" class="checkbox">
                        </label>
                        
                        <a href="" class="text-decoration-none">
                            @if(isset($member))
                            <?php  $filePath = '/userImages/'.$member['member_data']->photo1; ?>
                                @if($member['member_data']->photo1 != "" && Storage::disk('public')->exists($filePath))
                                    <img src="{{asset('storage/userImages/'.$member['member_data']->photo1)}}" class="img-fluid rounded w-100">
                                @else
                                    @if($member['member_data']->gender == "Male")
                                        <img src="{{asset('user/img/male.jpg')}}" class="img-fluid rounded w-100">
                                    @else
                                        <img src="{{asset('user/img/female.jpg')}}" class="img-fluid rounded w-100">
                                    @endif
                                @endif
                            @endif
                        </a>
                        <div class="col-12 p-3">
                            <a href="{{ route('admin.sendMailProfile',$member['member_data']->id)}}" class="btn btnSecondary btn-sm font-14 pt-2 pb-2 d-block">
                                <span class="badge bg-light text-dark">{{$member['count']}}</span> Matching Profile Found
                            </a>
                        </div>
                    </div>
                    
                    <div class="col-lg-9 col-md-9">
                        <div class="card-body">
                            <a href="" class="text-decoration-none">
                                <div class="row">
                                    <div class="col-lg-6 col-12">
                                        <h5 class="card-title">{{$member['member_data']->firstname}} {{$member['member_data']->lastname}}</h5>
                                        <h6 class="mb-3">{{$member['member_data']->matri_id}}&nbsp;&nbsp;|&nbsp;&nbsp; Profile Created by @if(isset($member['member_data']->profileby)){{$member['member_data']->profileby}}@else Not Available @endif</h6>
                                        
                                    </div>
                                    <div class="col-lg-6 col-12 inAResultStatus mb-3 mb-md-0">
                                        <div class="row">
                                            @if($member['member_data']->status === "Active")
                                            <div class="col-5">
                                                <i class="fa-solid fa-thumbs-up pe-2"></i><span class="">Approved</span> 
                                            </div>
                                            @endif
                                            @if($member['member_data']->status === "Inactive")
                                            <div class="col-5">
                                                <i class="fa-solid fa-thumbs-down pe-2"></i><span class="">Unapproved</span> 
                                            </div>
                                            @endif
                                            @if($member['member_data']->status === "Paid")
                                            <div class="col-5">
                                                <i class="fa-solid fa-money-check-dollar pe-2"></i><span class="">Paid</span>
                                            </div>
                                            @endif
                                            @if($member['member_data']->fstatus == "Featured")
                                            <div class="col-5">
                                                <i class="fa-solid fa-star pe-2"></i><span class="">Featured</span>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row inAResultDatails">
                                    <div class="col-lg-6 mb-1">
                                        <div class="row">
                                            <div class="col-4">
                                                <b>Email</b>
                                            </div>
                                            <div class="col">
                                                @if(env('DEMO_MODE') == 'On')
                                                    <span>Disabled In Demo</span>
                                                @else
                                                    <span>
                                                        @if(isset($member['member_data']->email)){{ $member['member_data']->email }}@else Not Available @endif
                                                    </span>
                                                @endif  
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-1">
                                        <div class="row">
                                            <div class="col-4">
                                                <b>Mobile</b>
                                            </div>
                                            <div class="col">
                                                @if(env('DEMO_MODE') == 'On')
                                                    <span>Disabled In Demo</span>
                                                @else
                                                    <span>
                                                        @if(isset($member['member_data']->mobile)){{$member['member_data']->mobile}}@else Not Available @endif
                                                    </span>
                                                @endif
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-1">
                                        <div class="row">
                                            <div class="col-4">
                                                <b>Gender</b>
                                            </div>
                                            <div class="col">
                                                <span>@if(isset($member['member_data']->gender)){{$member['member_data']->gender}}@else Not Available @endif</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-1">
                                        <div class="row">
                                            <div class="col-4">
                                                <b>Age</b>
                                            </div>
                                            <div class="col">
                                                @if(isset($member['member_data']->birthdate))
                                                <?php   $from = Carbon\Carbon::parse($member['member_data']->birthdate);
                                                    $to = Carbon\Carbon::now();
                                                    $age =$from->diff($to)->y;
                                                ?>
                                                @endif
                                                <span>@if(isset($age)){{$age}} Yrs @else Not Available @endif</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-1">
                                        <div class="row">
                                            <div class="col-4">
                                                <b>Height</b>
                                            </div>
                                            <div class="col">
                                                <span>@if(isset($member['member_data']->height)){{$member['member_data']->hei->height}}@else Not Available @endif</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-1">
                                        <div class="row">
                                            <div class="col-4">
                                                <b>Religion</b>
                                            </div>
                                            <div class="col">
                                                <span>@if(isset($member['member_data']->religion)){{$member['member_data']->rel->religion_name}}@else Not Available @endif</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-1">
                                        <div class="row">
                                            <div class="col-4">
                                                <b>Caste</b>
                                            </div>
                                            <div class="col">
                                                <span>@if(isset($member['member_data']->caste)){{$member['member_data']->cast->caste_name}}@else Not Available @endif</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-1">
                                        <div class="row">
                                            <div class="col-4">
                                                <b>Location</b>
                                            </div>
                                            <div class="col">
                                                <span>@if(isset($member['member_data']->country_id)){{$member['member_data']->country->country_name}}@else Not Available @endif</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <!-- Visible in large device only -->
                            <div class="d-none d-lg-block">
                                <div class="row mt-4 inMainResultAction mt-lg-2 mt-xl-4">
                                    <div class="col col-xl-2 text-center">
                                        <a href="{{ route('admin.view-profile',$member['member_data']->matri_id) }}">
                                            <i class="fas fa-eye"></i>
                                            <p>View Profile</p>
                                        </a>
                                    </div>
                                    <div class="col col-xl-2 text-center">
                                        <a href="{{ route('admin.edit-profile',$member['member_data']->matri_id) }}">
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
                                <a href="{{ route('admin.view-profile',$member['member_data']->matri_id) }}">
                                    <i class="fas fa-eye"></i>
                                    <p>View Profile</p>
                                </a>
                            </div>
                            <div class="col-4 col-xl-2 text-center mb-3">
                                <a href="{{ route('admin.edit-profile',$member['member_data']->matri_id) }}">
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
            @if(count($paginator) == 0)
                <img src="{{asset('admin/img/nodata.jpg')}}" class="img-fluid rounded">
            @endif
            <div class="d-flex justify-content-center">
                {!! $paginator->links() !!}
            </div>
        </div>
    </div>
</div>
<!-- /.Main Content -->

@include('admin.parts.matchSearchModel')

@include('admin.parts.setMatchCriteriaModel')

@endsection

@section('pageJS')
<script src="{{asset('admin/js/chosen.jquery.js')}}" type="text/javascript"></script>
<script src="{{asset('admin/js/prism.js')}}" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    var config = {
        '.chosen-select': {},
        '.chosen-select-deselect': {allow_single_deselect: true},
        '.chosen-select-no-single': {disable_search_threshold: 10},
        '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
        '.chosen-select-width': {width: "100%"}
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }
</script>
<script type="text/javascript">
    $(document).ready(function () {
        @if(Session::has('message'))
            $('#message').toast('show');
        @endif
    });
</script>
<script>
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
                    $('#caste-dropdown').html('<option value="">-- Select Caste --</option>');
                    $.each(result.caste, function (key, value) {
                        $("#caste-dropdown").append('<option value="' + value
                            .id + '">' + value.caste_name + '</option>');
                    });
                }
            });
        });
</script>
@endsection