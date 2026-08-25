<!-- Main layout -->
@extends('admin.layouts.afterLoginLayout')

<!-- Page title -->
@section('title') Admin - All Currency @endsection

<!-- Additional page css add here -->
@section('pageCSS') @endsection

@section('content')
<!-- Main Content -->
<div class="container pt-3">

    <h3 class="colorSecondary inATitle1">Currency</h3>

    <!-- Top button panel -->     
    <div class="inMemberTopPanel">
        <div class="pb-0">
            <div class="row">
                <div class="mb-3">
                    <a href="#" class="btn btnSecondary" data-bs-toggle="modal" data-bs-target="#currencyModal">
                        <i class="fas fa-plus pe-1"></i>Add Currency
                    </a>
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
                        <div class="btn-group" role="group">
                            <label class="btn btnSecondary inBorderRightLightGrey" for="inCheckbox">
                                <input type="checkbox" value="selectedCurrency[]" name="inCheckbox" id="inCheckbox" class="form-check-input inMT-3">
                                <span class="ms-1 d-none d-lg-inline">Select All</span>
                            </label>
                            <a href="javascript:void(0);" class="btn btnSecondary inBorderRightLightGrey" id="approveButton">
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
                <div class="card-body inAddDetailTable">
                    <form action="{{ route('admin.currencyStatus') }}" method="post" id="approveForm">
                        @csrf
                        @method('PATCH')
                        <table id="all_currency" class="table table-resonsive">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Option</th>   
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($currency as $data)
                                <tr>
                                    <td><input type="checkbox" value="{{ $data->id }}" name="selectedCurrency[]" name="checkbox" id="checkbox" class="checkbox"></td>
                                    <td class="font-14">{{ $data->currency }}</td>
                                    <td>
                                        @if($data->status == "APPROVED")
                                            <i class="fas fa-thumbs-up"></i>
                                        @else
                                            <i class="fas fa-thumbs-down pe-1"></i>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="#" class="btn btnPrimary me-1" data-bs-toggle="modal" data-bs-target="#currencyModal{{ $data->id }}" data-bs-title="Edit">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <a href="{{ route('admin.currencyDelete',$data->id) }}" class="btn btnSecondary" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                                <!-- Edit Currency modal -->
                                <div class="modal fade inAddDetailsModal" id="currencyModal{{ $data->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="currencyModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form method="Post" action="{{ route('admin.currencyStatus') }}">
                                                @csrf
                                                @method('PATCH')

                                                <div class="modal-header">
                                                    <h1 class="modal-title" id="currencyModalLabel">Edit Currency</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-12 mb-3 mt-2">
                                                            <label class="label-1 fw-semibold">Currency</label>
                                                            <input type="text" class="form-control" value="{{ $data->currency }}" name="currency" placeholder="Enter Currency" required>
                                                        </div>
                                                        <div class="col-12 mb-3">
                                                            <div class="row">
                                                                <div class="col-xl-2 col-3">
                                                                    <h5 class="inSwithLabel mb-0">Status :</h5>
                                                                </div>
                                                                <div class="col">
                                                                    <div class="form-check form-switch">
                                                                        <input class="form-check-input" type="checkbox" @if($data->status == 'APPROVED') checked @endif name="status" role="switch" id="flexSwitchCheckDefault">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>   
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" name="save" value="{{ $data->id }}" class="btn btnPrimary">SAVE</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- /. Edit Currency modal -->
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
<!-- /.Main Content -->

<!-- Add currency modal -->
<div class="modal fade inAddDetailsModal" id="currencyModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="currencyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="Post" action="{{ route('admin.currencyStore') }}">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title" id="currencyModalLabel">Add Currency</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 mb-3 mt-2">
                            <label class="label-1 fw-semibold">Currency</label>
                            <input type="text" class="form-control" name="currency" placeholder="Enter Currency" required>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="row">
                                <div class="col-xl-2 col-3">
                                    <h5 class="inSwithLabel mb-0">Status :</h5>
                                </div>
                                <div class="col">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="status" role="switch" id="flexSwitchCheckDefault" checked>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>   
                </div>
                <div class="modal-footer">
                    <button type="submit" name="SAVE" value="SAVE" class="btn btnPrimary">SAVE</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /. Add currency modal -->
@endsection

<!-- Additional page js add here -->
@section('pageJS')
<script>
    $(document).ready(function () {
        $('#all_currency').DataTable();
    });
</script>
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