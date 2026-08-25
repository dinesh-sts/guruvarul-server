<!-- Main layout -->
@extends('admin.layouts.afterLoginLayout')

<!-- Page title -->
@section('title') Admin - Message Activity @endsection

<!-- Additional page css add here -->
@section('pageCSS') @endsection

@section('content')
<!-- Main Content -->
<div class="container pt-3">

    <h3 class="colorSecondary inATitle1">Message Activity</h3>

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
                    <form action="{{ route('admin.messageActivityStatus') }}" method="post" id="approveForm">
                        @csrf
                        @method('PATCH')
                        <table id="all_messageactivity" class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Message From</th>
                                    <th>Message To</th>
                                    <th>Message</th>
                                    <th>Date</th>
                                    <th>Option</th>   
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($messageactivity as $data)
                                    <tr>
                                        <td><input type="checkbox" value="@if(isset($data['data']->id)){{$data['data']->id}}@endif" name="selected[]" name="checkbox" id="checkbox" class="checkbox"></td>
                                        <td class="font-14">@if(isset($data['data']->sender->firstname)){{$data['data']->sender->firstname}}@endif @if(isset($data['data']->sender->lastname)){{$data['data']->sender->lastname}}({{$data['data']->sender->matri_id}})@else @if(isset($data['data']->matri_id)){{$data['data']->sender->matri_id}}@endif @endif</td>
                                        @if($data['data']->sender->firstname == $data['ChatThread']->receiver->firstname)
                                            <td class="font-14">@if(isset($data['ChatThread']->sender->firstname)){{$data['ChatThread']->sender->firstname}}@endif @if(isset($data['ChatThread']->sender->lastname)){{$data['ChatThread']->sender->lastname}}({{$data['ChatThread']->sender->matri_id}})@else @if(isset($data['ChatThread']->sender->matri_id)){{$data['ChatThread']->sender->matri_id}}@endif @endif</td>
                                        @else
                                            <td class="font-14">@if(isset($data['ChatThread']->receiver->firstname)){{$data['ChatThread']->receiver->firstname}}@endif @if(isset($data['ChatThread']->receiver->lastname)){{$data['ChatThread']->receiver->lastname}}({{$data['ChatThread']->receiver->matri_id}})@else @if(isset($data['ChatThread']->receiver->matri_id)){{$data['ChatThread']->receiver->matri_id}}@endif @endif</td>
                                        @endif
                                    
                                        <td class="font-13">@if(isset($data['data']->message)){{$data['data']->message}}@endif</td>
                                        <td class="font-13">@if(isset($data['data']->created_at)){{$data['data']->created_at}}@endif</td>
                                        <td>
                                            <a href="{{route('admin.messageActivityDelete',$data['data']->id)}}" onclick="return confirm('Are you sure wantto Delete This?')" class="btn btnSecondary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete"><i class="fas fa-trash"></i></a>
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
        $('#all_messageactivity').DataTable();
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