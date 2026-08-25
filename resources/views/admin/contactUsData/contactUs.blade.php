<!-- Main layout -->
@extends('admin.layouts.afterLoginLayout')

<!-- Page title -->
@section('title') Admin - All Members @endsection

<!-- Additional page css add here -->
@section('pageCSS') @endsection

@section('content')
<!-- Main content -->
<div class="container pt-3">

    <h3 class="colorSecondary inATitle1">Contact Us Data</h3>

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
                            <a href="javascript:void(0);" class="btn btnSecondary inBorderRightLightGrey"  id="delete">
                                <i class="fas fa-thumbs-up"></i><span class="ps-1 d-none d-lg-inline">Delete</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body inAddDetailTable table-responsive">
                    <form action="{{ route('admin.contactDataStatus')}}" method="post" id="approveForm">
                        @csrf
                        @method('PATCH')
                        <table id="all_religion" class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Email Id</th>
                                    <th>Mobile No</th>
                                    <th>Subject</th>
                                    <th>Desc</th>
                                    <th>Date</th>
                                    <th>Option</th>   
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($contacts as $data)
                                <tr>
                                    <td><input type="checkbox" value="{{$data->id}}" name="selected[]" name="checkbox" id="checkbox" class="checkbox"></td>
                                    <td class="font-13">@if(isset($data->id)){{$data->id}}@endif</td>
                                    <td class="font-13">@if(isset($data->name)){{$data->name}}@endif</td>
                                    <td class="font-13">@if(isset($data->email)){{$data->email}}@endif</td>
                                    <td class="font-13">@if(isset($data->mobile)){{$data->mobile}}@endif</td>
                                    <td class="font-13">@if(isset($data->subject)){{$data->subject}}@endif</td>
                                    <td class="font-13">@if(isset($data->description)){{$data->description}}@endif</td>
                                    <td class="font-13">@if(isset($data->date)){{$data->date}}@endif</td>
                                    <td>
                                        <a href="{{route('admin.contactDataDelete',$data->id)}}" class="btn btnSecondary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete"><i class="fas fa-trash"></i></a>
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
<!-- /. Main content -->
@endsection
<!-- Additional page js add here -->
@section('pageJS')
<script>
    $(document).ready(function () {
        $('#all_religion').DataTable();
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