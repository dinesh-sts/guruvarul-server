<!-- Main layout -->
@extends('admin.layouts.afterLoginLayout')

<!-- Page title -->
@section('title') Admin - Express Interest Activity @endsection

<!-- Additional page css add here -->
@section('pageCSS') @endsection

@section('content')
<!-- Main Content -->
<div class="container pt-3">

    <h3 class="colorSecondary inATitle1">Express Interest Activity</h3>

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
                    <form action="{{ route('admin.expressActivityStatus') }}" method="post" id="approveForm">
                        @csrf
                        @method('PATCH')
                        <table id="all_expressactivity" class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Sender</th>
                                    <th>Receiver</th>
                                    <th>Receiver Respose</th>
                                    <th>Date</th>
                                    <th>Option</th>   
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($expressactivity as $data)
                                    <tr>
                                        <td><input type="checkbox" value="{{$data['data']->id}}" name="selected[]" name="checkbox" id="checkbox" class="checkbox"></td>
                                        <td class="font-14">@if(isset($data['sender']->firstname)){{$data['sender']->firstname}} @endif @if(isset($data['sender']->lastname)) {{$data['sender']->lastname}}({{$data['data']->ei_sender}}) @else @if(isset($data['data']->ei_sender)){{$data['data']->ei_sender}}@endif @endif </td>
                                        <td class="font-14">@if(isset($data['receiver']->firstname)){{$data['receiver']->firstname}} @endif @if(isset($data['receiver']->lastname)) {{$data['receiver']->lastname}} ({{$data['data']->ei_receiver}}) @else @if(isset($data['data']->ei_receiver)){{$data['data']->ei_receiver}}@endif @endif</td>
                                        <td>@if($data['data']->receiver_response == "Accept")<i class="fas fa-thumbs-up"></i>@elseif($data['data']->receiver_response == "Reject")<i class="fas fa-thumbs-down pe-1"></i>@else <i class="fas fa-clock pe-1"></i> @endif</td>
                                        <td class="font-13">@if(isset($data['data']->ei_sent_date)){{$data['data']->ei_sent_date}}@endif</td>
                                        <td>
                                            <a href="{{ route('admin.expressActivityDelete',$data['data']->id) }}" onclick="return confirm('Are you sure?')" class="btn btnSecondary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete"><i class="fas fa-trash"></i></a>
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
        $('#all_expressactivity').DataTable();
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