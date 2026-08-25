<!-- Main layout -->
@extends('admin.layouts.afterLoginLayout')

<!-- Page title -->
@section('title') Admin - Profile Viewed Activity @endsection

<!-- Additional page css add here -->
@section('pageCSS') @endsection

@section('content')
<!-- Main Content -->
<div class="container pt-3">

    <h3 class="colorSecondary inATitle1">Profile Viewed Activity</h3>

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
                            <a href="javascript:void(0);" class="btn btnSecondary inBorderRightLightGrey" id="delete">
                                <i class="fas fa-trash pe-1 "></i><span class="ps-1 d-none d-lg-inline">Delete</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body inAddDetailTable table-responsive">
                    <form action="{{ route('admin.viewedActivityStatus') }}" method="post" id="approveForm">
                        @csrf
                        @method('PATCH')
                        <table id="all_viewed" class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Member Id</th>
                                    <th>Viewed By</th>
                                    <th>Date</th>
                                    <th>Option</th>   
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($viewedactivity as $data)
                                    <tr>
                                        <td><input type="checkbox" value="@if(isset($data['data']->id)){{$data['data']->id}}@endif" name="selected[]" name="checkbox" id="checkbox" class="checkbox"></td>
                                        <td class="font-14">@if(isset($data['receiver']->firstname)){{$data['receiver']->firstname}}@endif @if(isset($data['receiver']->lastname)){{$data['receiver']->lastname}}({{$data['receiver']->matri_id}})@else @if(isset($data['receiver']->matri_id)){{$data['receiver']->matri_id}}@endif @endif</td>
                                        <td class="font-14">@if(isset($data['sender']->firstname)){{$data['sender']->firstname}}@endif @if(isset($data['sender']->lastname)){{$data['sender']->lastname}}({{$data['sender']->matri_id}})@else @if(isset($data['sender']->matri_id)){{$data['sender']->matri_id}}@endif @endif</td>
                                        <td class="font-13">@if(isset($data['data']->viewed_date)){{$data['data']->viewed_date}}@endif</td>
                                        <td>
                                            <a href="{{ route('admin.viewedActivityDelete',$data['data']->id) }}" onclick="return confirm('Are you sure?')" class="btn btnSecondary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete"><i class="fas fa-trash"></i></a>
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
<!-- /.Main Content -->
@endsection

<!-- Additional page js add here -->
@section('pageJS')
<script>
    $(document).ready(function () {
        $('#all_viewed').DataTable();
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