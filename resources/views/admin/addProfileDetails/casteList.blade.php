<!-- Main layout -->
@extends('admin.layouts.afterLoginLayout')

<!-- Page title -->
@section('title') Admin - All Caste @endsection

<!-- Additional page css add here -->
@section('pageCSS') 
    <link rel="stylesheet" href="{{ asset('admin/css/prism.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/chosen.css') }}"> 
@endsection

@section('content')
<!-- Main Content -->
<div class="container pt-3">
    <h3 class="colorSecondary inATitle1">Caste</h3>

    <!-- Top button panel -->     
    <div class="inMemberTopPanel">
        <div class="pb-0">
            <div class="row">
                <div class="mb-3">
                    <a href="#" class="btn btnSecondary" data-bs-toggle="modal" data-bs-target="#casteModal">
                        <i class="fas fa-plus pe-1"></i>Add Caste
                    </a>
                    <div class="dropdown float-end ms-2 me-2">
                        <a class="btn btnPrimary d-block dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-filter pe-1"></i>Filter
                        </a>
                        <ul class="dropdown-menu inBorderColor1">
                            <li>
                                <a href="{{ route('admin.casteList',['filter' => 'all']) }}" name="filter" value="all" class="dropdown-item">All Caste<span class="badge text-bg-secondary ms-1">{{$casteCount}}</span></a>
                            </li>
                            <li>
                                <a href="{{ route('admin.casteList',['filter' => 'approved']) }}" name="filter" value="approved" class="dropdown-item">Approved<span class="badge text-bg-secondary ms-1">{{$casteApprovedCount}}</span></a>
                            </li>
                            <li>
                                <a href="{{ route('admin.casteList',['filter' => 'unapproved']) }}" name="filter" value="unapproved" class="dropdown-item">Unapproved<span class="badge text-bg-secondary ms-1">{{$casteUnapprovedCount}}</span></a>
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
                            <a href="javascript:void(0);" class="btn btnSecondary inBorderRightLightGrey" id="delete">
                                <i class="fas fa-trash pe-1 "></i><span class="ps-1 d-none d-lg-inline">Delete</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body inAddDetailTable table-responsive">
                    <form action="{{ route('admin.casteList') }}" method="get" class="mb-3">
                        <div class="col-xl-3 offset-xl-9 col-12">
                            <input type="search" id="text" name="search" value="{{ request()->get('search') }}" class="form-control" onkeyup="showResult(this.value)" autofocus="autofocus" placeholder="Search"/>
                        </div>
                    </form>

                    <form action="{{ route('admin.casteStatus') }}" method="post" id="approveForm">
                        @csrf
                        @method('PATCH')
                    
                        <table id="all_caste" class="table table-responsive">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Religion</th>
                                    <th>Caste</th>
                                    <th>Status</th>
                                    <th>Option</th>   
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($caste as $data)
                                <tr>
                                    <td>
                                        <input type="checkbox" value="{{$data->id}}" name="selected[]" name="checkbox" id="checkbox" class="checkbox">
                                    </td>
                                    <td class="font-14"> {{ $data->rel->religion_name }} </td>
                                    <td class="font-14"> {{ $data->caste_name }}</td>
                                    <td>
                                        @if($data->status == "APPROVED") 
                                            <i class="fas fa-thumbs-up"></i>
                                        @else
                                            <i class="fas fa-thumbs-down pe-1"></i>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="" class="btn btnPrimary me-1" data-bs-toggle="modal" data-bs-target="#casteModal{{$data->id}}" data-bs-title="Edit">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <a href="{{ route('admin.casteDelete',$data->id) }}" class="btn btnSecondary" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                        
                                <div class="modal fade inAddDetailsModal" id="casteModal{{ $data->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="religionModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form method="post" action="{{ route('admin.casteStatus') }}">
                                                @csrf
                                                @method('PATCH')

                                                <div class="modal-header">
                                                    <h1 class="modal-title" id="religionModalLabel">Edit Caste</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-12 mb-3 mt-2">
                                                            <label class="label-1 fw-semibold">Religion</label>
                                                            <select name="religion_id" class="form-select chosen-select" data-placeholder="Choose"required>
                                                                <option value="" selected>select</option>
                                                                @foreach($religions as $religion)
                                                                    <option value="{{$religion->id}}"@if(isset($data)){{$data->religion_id == $religion->id ? "selected" : ''}}@else @selected(old('religion_id') == $religion->id)@endif>{{$religion->religion_name}}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-12 mb-3">
                                                            <label class="label-1 fw-semibold">Caste</label>
                                                            <input type="text" value="@if(isset($data)){{$data->caste_name}}@endif" name="caste_name" class="form-control" placeholder="Enter Caste Name" required>
                                                        </div>
                                                        <div class="col-12 mb-3">
                                                            <div class="row">
                                                                <div class="col-xl-2 col-3">
                                                                    <h5 class="inSwithLabel mb-0">Status :</h5>
                                                                </div>
                                                                <div class="col">
                                                                    <div class="form-check form-switch">
                                                                        <input class="form-check-input" type="checkbox" @if($data->status == 'APPROVED')checked @endif name="status" role="switch" id="flexSwitchCheckDefault">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>   
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" name="save" value="{{$data->id}}" class="btn btnPrimary">SAVE</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endforeach  
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">
                            {!! $caste->withQueryString()->links() !!}
                        </div>
                        <input type="hidden" name="action" id="selectedAction" value="">
                        <button type="submit" id="performActionButton" class="btn btnSecondary d-none">Perform Action</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.Main Content -->
 
<!-- Add caste modal -->
<div class="modal fade inAddDetailsModal" id="casteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="religionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="{{ route('admin.casteStore') }}">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title" id="religionModalLabel">Add Caste</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 mb-3 mt-2">
                            <label class="label-1 fw-semibold">Religion</label>
                            <select name="religion_id" class="form-select chosen-select" data-placeholder="Choose" required>
                                <option value="" selected>select</option>
                                @foreach($religions as $religion)
                                    <option value="{{$religion->id}}"@selected(old('religion_id') == $religion->id)> {{$religion->religion_name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="label-1 fw-semibold">Caste</label>
                            <input type="text" name="caste_name" class="form-control" placeholder="Enter Caste Name" required>
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
<!-- /. Add caste modal -->

@endsection

<!-- Additional page js add here -->
@section('pageJS')
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