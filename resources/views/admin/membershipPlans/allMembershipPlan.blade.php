<!-- Main layout -->
@extends('admin.layouts.afterLoginLayout')

<!-- Page title -->
@section('title') Admin - All Membership Plans @endsection

<!-- Additional page css add here -->
@section('pageCSS') @endsection

@section('content')
<!-- Main content -->
<div class="container pt-3">
    
    <h3 class="colorSecondary inATitle1">All Membership Plan</h3>

    <!-- Top button panel -->     
    <div class="inMemberTopPanel">
        <div class="pb-0">
            <div class="row">
                <div class="mb-3">
                    <a href="{{ route('admin.membershipPlan.create') }}" class="btn btnSecondary">
                        <i class="fas fa-plus pe-1"></i>Add Membership Plan
                    </a>
                    <div class="dropdown d-inline float-end ms-2 me-2">
                        <a class="btn btnPrimary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-filter pe-1"></i>Filter
                        </a>
                        <ul class="dropdown-menu inBorderColor1">
                            <li>
                                <a href="{{ route('admin.membershipPlan.all',['filter' => 'all']) }}" name="filter" value="all" class="dropdown-item">
                                    All 
                                    <span class="badge text-bg-secondary ms-1">
                                        @if(isset($membershipPlansCount)){{ $membershipPlansCount }} @endif
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.membershipPlan.all',['filter' => 'active']) }}" name="filter" value="active" class="dropdown-item">
                                    Approved
                                    <span class="badge text-bg-secondary ms-1">
                                        @if(isset($membershipPlansApproveCount)){{ $membershipPlansApproveCount }} @endif
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.membershipPlan.all',['filter' => 'inactive']) }}" name="filter" value="inactive" class="dropdown-item">
                                    Unapproved
                                    <span class="badge text-bg-secondary ms-1">
                                        @if(isset($membershipPlansUnapproveCount)){{ $membershipPlansUnapproveCount }} @endif
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>    
            </div>
        </div>
    </div>
    <!-- /. Top button panel -->

    <div class="row">
        <div class="col-12 mb-5">
            <div class="card cardHover inBorderColor1">
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
                            <a href="javascript:void(0);" class="btn btnSecondary inBorderRightLightGrey" id="delete">
                                <i class="fas fa-trash pe-1 "></i><span class="ps-1 d-none d-lg-inline">Delete</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body inAddDetailTable table-responsive">
                    <form action="{{ route('admin.membershipPlan.status') }}" method="post" id="approveForm">
                        @csrf
                        @method('PATCH')
                        
                        <table id="all_membershipPlan" class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Plan Name</th>
                                    <th>Price</th>
                                    <th>Duration</th>   
                                    <th>Contact View</th>   
                                    <th>Live Chat</th>   
                                    <th>Status</th> 
                                    <th>Plan for</th>   
                                    <th>Option</th>   
                                </tr>
                            </thead>
                            <tbody id="table-to-refresh">
                                @foreach($membershipPlans as $membershipPlan)
                                <tr>
                                    <td>
                                        <input type="checkbox" value="@if(isset($membershipPlan->id)) {{ $membershipPlan->id }} @endif" name="selected[]" name="checkbox" id="checkbox" class="checkbox">
                                    </td>
                                    <td class="font-13">
                                        @if(isset($membershipPlan->plan_name)){{ $membershipPlan->plan_name }}@endif 
                                    </td>
                                    <td class="font-13">
                                        @if(isset($membershipPlan->currency)) {{ $membershipPlan->currency }}
                                        @endif @if(isset($membershipPlan->plan_amount)) {{ $membershipPlan->plan_amount }}
                                        @endif
                                    </td>
                                    <td class="font-13">
                                        @if(isset($membershipPlan->plan_duration)) {{ $membershipPlan->plan_duration }}
                                        @endif Days
                                    </td>
                                    <td class="font-13">
                                        @if(isset($membershipPlan->plan_contacts)) {{ $membershipPlan->plan_contacts }} @endif
                                    </td>
                                    <td class="font-13">
                                        @if(isset($membershipPlan->chat)) {{ $membershipPlan->chat }} @endif
                                    </td>
                                    <td class="inTableStatus">
                                        @if($membershipPlan->status == 'APPROVED') 
                                            <span class="inApproved">
                                                <i class="fas fa-thumbs-up"></i> Approved 
                                            </span>
                                        @elseif($membershipPlan->status == 'UNAPPROVED')
                                            <span class="inUnapproved">
                                                <i class="fas fa-thumbs-down"></i> Unapproved 
                                            </span>
                                        @endif
                                    </td>
                                    <td class="font-13">
                                        @if(isset($membershipPlan->only_for)) {{ $membershipPlan->only_for }} Only @else All @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.membershipPlan.edit',$membershipPlan->id) }}" class="btn btnPrimary me-1" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit"><i class="fas fa-pen fa-fw"></i></a>
                                        <a href="{{ route('admin.membershipPlan.destroy',$membershipPlan->id) }}" class="btn btnSecondary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete" onclick="return confirm('Are you sure?')"><i class="fas fa-trash fa-fw"></i></a>
                                    </td>
                                </tr>
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
<!-- /. Main content-->
@endsection

<!-- Additional page js add here -->
@section('pageJS')
    <script>
        $(document).ready(function () {
            $('#all_membershipPlan').DataTable();
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
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

            $('#approveButton').on('click', function () {
                if ($('.checkbox:checked').length === 0) {
                    alert('Please select at least one plan to perform this action.');
                }  else {
                    var action = 'approve'; 
                    $('#selectedAction').val(action);
                    $('#performActionButton').click(); 
                }
            });
            $('#unapproveButton').on('click', function () {
                if ($('.checkbox:checked').length === 0) {
                    alert('Please select at least one plan to perform this action.');
                }  else {
                    var action = 'unapprove'; 
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