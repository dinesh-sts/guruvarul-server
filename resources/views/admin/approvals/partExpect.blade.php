<!-- Main layout -->
@extends('admin.layouts.afterLoginLayout')

<!-- Page title -->
@section('title') Admin - Partner Expectation Approval @endsection

<!-- Additional page css add here -->
@section('pageCSS') @endsection

@section('content')
<!-- Main Content -->
<div class="container pt-3">
    <h3 class="colorSecondary inATitle1">Partner Expectation Approval</h3>

    <!-- Top button panel -->     
    <div class="inMemberTopPanel">
        <div class="pb-0">
            <div class="row">
                <div class="mb-3">
                    <div class="dropdown d-inline float-end ms-2 me-2">
                        <a class="btn btnPrimary d-block dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-filter pe-1"></i>Filter
                        </a>
                        <ul class="dropdown-menu inBorderColor1">
                            <li>
                                <a href="{{route('admin.partnerExpectList',['filter' => 'all'])}}" name="filter" value="all" class="dropdown-item">All Partner Expectation<span class="badge text-bg-secondary ms-1">@if(isset($part_expectCount)){{$part_expectCount}}@endif</span></a>
                            </li>
                            <li>
                                <a href="{{route('admin.partnerExpectList',['filter' => 'approved'])}}" name="filter" value="approved" class="dropdown-item">Approved<span class="badge text-bg-secondary ms-1">@if(isset($part_expectApprovedCount)){{$part_expectApprovedCount}}@endif</span></a>
                            </li>
                            <li>
                                <a href="{{route('admin.partnerExpectList',['filter' => 'unapproved'])}}" name="filter" value="unapproved" class="dropdown-item">Unapproved<span class="badge text-bg-secondary ms-1">@if(isset($part_expectUnapprovedCount)){{$part_expectUnapprovedCount}}@endif</span></a>
                            </li>
                            <li>
                                <a href="{{route('admin.partnerExpectList',['filter' => 'pending'])}}" name="filter" value="pending" class="dropdown-item">Pending<span class="badge text-bg-secondary ms-1">@if(isset($part_expectPendingCount)){{$part_expectPendingCount}}@endif</span></a>
                            </li>
                        </ul>
                    </div>
                </div>    
            </div>
        </div>
    </div>
    <!-- /. Top button panel -->

    <div class="row">
        <div class="col-12">
            <div class="card inBorderColor1">
                <div class="card inMemberActionPanel border-0">
                    <div class="card-body">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <label class="btn btnSecondary inBorderRightLightGrey" for="inCheckbox">
                                <input type="checkbox" value="selected[]" name="inCheckbox" id="inCheckbox" class="form-check-input inMT-3">
                                <span class="ms-1 d-none d-lg-inline">Select All</span>
                            </label>
                            <a href="javascript:void(0);" class="btn btnSecondary inBorderRightLightGrey"  id="approveButton">
                                <i class="fas fa-thumbs-up"></i><span class="ps-1 d-none d-lg-inline">Approve</span>
                            </a>
                            <a href="javascript:void(0);" class="btn btnSecondary inBorderRightLightGrey" id="unapproveButton">
                                <i class="fas fa-thumbs-down pe-1"></i><span class="ps-1 d-none d-lg-inline">Unapprove</span>
                            </a>
                            <a href="javascript:void(0);" class="btn btnSecondary inBorderRightLightGrey" id="PendingButton">
                                <i class="fas fa-clock pe-1"></i><span class="ps-1 d-none d-lg-inline">Pending</span>
                            </a>
                            <a href="javascript:void(0);" class="btn btnSecondary inBorderRightLightGrey" id="delete">
                                <i class="fas fa-trash pe-1 "></i><span class="ps-1 d-none d-lg-inline">Delete</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body inAddDetailTable table-responsive">
                    <form action="{{ route('admin.partnerExpectStatus') }}" method="post" id="approveForm">
                        @csrf
                        @method('PATCH')
                        <table id="all_partexpect" class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Member Id</th>
                                    <th>Status</th>
                                    <th>Partner Expectation</th>
                                    <th>Option</th>   
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($part_expect as $data)
                                <tr>
                                    <td><input type="checkbox" value="{{$data->id}}" name="selected[]" name="checkbox" id="checkbox" class="checkbox"></td>
                                    <td class="font-14">@if(isset($data->firstname)){{$data->firstname}}@endif @if(isset($data->lastname)){{$data->lastname}}@endif</td>
                                    <td class="font-14">@if(isset($data->matri_id)){{$data->matri_id}}@endif</td>
                                    <td>@if($data->part_expect_approve == "APPROVED")<i class="fas fa-thumbs-up"></i>@elseif($data->part_expect_approve == "UNAPPROVED")<i class="fas fa-thumbs-down pe-1"></i>@else <i class="fas fa-clock pe-1"></i> @endif</td>
                                    <td>
                                        <p>{{substr($data->part_expect,0,5)}}...&nbsp;<a href="" class="text-decoration-none font-14 colorPrimary" data-bs-toggle="modal" data-bs-target="#partner_expectModal{{$data->id}}">
                                            Read more
                                        </a></p>
                                    </td>
                                    <td>
                                        <a href="{{route('admin.partnerExpectDelete',$data->id)}}" class="btn btnSecondary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                                <div class="modal fade inAddDetailsModal" id="partner_expectModal{{$data->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="religionModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title" id="religionModalLabel">@if(isset($data->firstname)){{$data->firstname}}@endif @if(isset($data->lastname)){{$data->lastname}} ({{$data->matri_id}})@else {{$data->matri_id}} @endif</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-12 mb-3 mt-2">
                                                        <p>@if(isset($data->part_expect)){{$data->part_expect}}@endif</p>
                                                    </div>  
                                                </div>   
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </tbody>
                        </table>
                        <input type="hidden" name="action" id="selectedAction" value="">
                        <button type="submit" id="performActionButton" class="btn btnSecondary d-none">Perform Action</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /. Main Content -->
@endsection

<!-- Additional page js add here -->
@section('pageJS')
<script>
    $(document).ready(function () {
        $('#all_partexpect').DataTable();
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#inCheckbox').on('click', function () {
            @if(Session::has('message'))
            $('#message').toast('show');
        @endif
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
        $('#approveButton').on('click', function () {
            if ($('.checkbox:checked').length === 0) {
                alert('Please select at least one member to perform this action.');
            }  else {
                var action = 'approve'; 
                $('#selectedAction').val(action);
                $('#performActionButton').click(); 
            }
        });
        $('#unapproveButton').on('click', function () {
            if ($('.checkbox:checked').length === 0) {
                alert('Please select at least one member to perform this action.');
            }  else {
                var action = 'unapprove'; 
                $('#selectedAction').val(action);
                $('#performActionButton').click(); 
            }
        });
        $('#PendingButton').on('click', function () {
            if ($('.checkbox:checked').length === 0) {
                alert('Please select at least one member to perform this action.');
            }  else {
                var action = 'pending'; 
                $('#selectedAction').val(action);
                $('#performActionButton').click(); 
            }
        });
        $('#delete').on('click', function () {
            var confirmDelete = confirm("Are you sure you want to delete?");
            if (confirmDelete) {
                if ($('.checkbox:checked').length === 0) {
                    alert('Please select at least one member to perform this action.');
                }  else {
                    var action = 'delete'; 
                    $('#selectedAction').val(action);
                    $('#performActionButton').click(); 
                }
            }
        });
    });
</script>
@endsection