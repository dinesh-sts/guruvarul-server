<!-- Main layout -->
@extends('admin.layouts.afterLoginLayout')

<!-- Page Title -->
@section('title') Admin Panel - All Members @endsection

<!-- Page Css -->
@section('pageCSS') @endsection

<!-- Main Content -->
@section('content')

<!-- Fixed scroll menu -->
<div class="scroll-menu scroll-theme1">
    <ul class="col-xs-12 list-unstyled">
        <li class="col-xs-12 clearfix">
            <input type="checkbox" value="selectedMembers[]" name="inCheckbox" id="Checkbox" class="form-check-input">
        </li>
        <li class="col-xs-12 clearfix">
            <a href="javascript:void(0);" class="colorPrimary text-decoration-none" id="approve">
                <i class="fa fa-thumbs-up" aria-hidden="true"></i>
            </a>
        </li>
        <li class="col-xs-12 clearfix">
            <a href="javascript:void(0);" class="colorSecondary text-decoration-none" id="unapprove">
                <i class="fa fa-thumbs-down" aria-hidden="true"></i>
            </a>
        </li>
        <li class="col-xs-12 clearfix">
            <a href="javascript:void(0);" class="text-danger text-decoration-none" id="delete">
                <i class="fa fa-trash" aria-hidden="true"></i>
            </a>
        </li>
    </ul>
</div>
<!-- /. Fixed scroll menu -->

<div class="container pt-3">
    <div class="row">
        <h3 class="colorSecondary inATitle1">All Members</h3>
        
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
                        <a href="javascript:void(0);" class="btn btnSecondary inBorderRightLightGrey" id="approveButton">
                            <i class="fas fa-thumbs-up"></i><span class="ps-1 d-none d-lg-inline">Approve</span>
                        </a>
                        <a href="javascript:void(0);" class="btn btnSecondary inBorderRightLightGrey" id="unapproveButton">
                            <i class="fas fa-thumbs-down pe-1"></i><span class="ps-1 d-none d-lg-inline">Unapprove</span>
                        </a>
                        <a href="javascript:void(0);" class="btn btnSecondary inBorderRightLightGrey" id="deleteButton">
                            <i class="fas fa-trash pe-1 "></i><span class="ps-1 d-none d-lg-inline">Delete</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <form action="{{ route('admin.updateStatus') }}" method="post">
                @csrf
                @method('PATCH')

                @if(count($members) == 0)
                    <img src="{{asset('admin/img/nodata.jpg')}}" class="img-fluid rounded">
                @else
                    @foreach ($members as $member)
                        <!-- Admin member main result -->
                        @include('admin.parts.adminMainResult')
                        <!-- /. Admin member main result -->
                    @endforeach
                @endif

                <input type="hidden" name="action" id="selectedAction" value="">
                <button type="submit" id="performActionButton" class="btn btnSecondary d-none">Perform Action</button>
            </form>
        </div>

        <div class="d-flex justify-content-center">
            {{ $members->withQueryString()->links() }}
        </div>
    </div>
</div>
<!-- Admin mebers search model -->
@include('admin.parts.searchModel')
<!-- /. Admin mebers search model -->

@endsection

@section('pageJS')
<script type="text/javascript">
    $(document).ready(function () {

        @if(Session::has('message'))
            $('#message').toast('show');
        @endif

        // for fixed status change bar
        $('#Checkbox').on('click', function () {
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

        $('#approve').on('click', function () {
            if ($('.checkbox:checked').length === 0) {
                alert('Please select at least one member to perform this action.');
            }  else {
                var action = 'approve'; 
                $('#selectedAction').val(action);
                $('#performActionButton').click(); 
            }
        });

        $('#unapprove').on('click', function () {
            if ($('.checkbox:checked').length === 0) {
                alert('Please select at least one member to perform this action.');
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
                } else {
                    var action = 'delete'; 
                    $('#selectedAction').val(action);
                    $('#performActionButton').click(); 
                }
            }
        });

         // for static status change option
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
                alert('Please select at least one member to perform this action.');
            } else {
                var action = 'approve'; 
                $('#selectedAction').val(action);
                $('#performActionButton').click(); 
            }
        });
        $('#unapproveButton').on('click', function () {
            if ($('.checkbox:checked').length === 0) {
                alert('Please select at least one member to perform this action.');
            } else {
                var action = 'unapprove'; 
                $('#selectedAction').val(action);
                $('#performActionButton').click();
            }
        });
        $('#deleteButton').on('click', function () {
            var confirmDelete = confirm("Are you sure you want to delete?");
                if (confirmDelete) {
                    if ($('.checkbox:checked').length === 0) {
                    alert('Please select at least one member to perform this action.');
                } else {
                    var action = 'delete'; 
                    $('#selectedAction').val(action);
                    $('#performActionButton').click(); 
                }
            }
        });

        //Dropdown Js
        $('.dropdown-item[data-filter]').on('click', function (e) {
            e.preventDefault();
            var filter = $(this).data('filter');
            filterMembers(filter);
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
                    $('#caste-dropdown').html('<option value="">-- Select Caste --</option>');
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