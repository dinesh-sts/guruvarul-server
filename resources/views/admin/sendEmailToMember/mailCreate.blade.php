<!-- Main layout -->
@extends('admin.layouts.afterLoginLayout')

<!-- Page title -->
@section('title') Admin - Send Email To Members @endsection

<!-- Additional page css add here -->
@section('pageCSS') 
    <link rel="stylesheet" href="{{asset('admin/css/prism.css')}}">
    <link rel="stylesheet" href="{{asset('admin/css/chosen.css')}}">
@endsection

@section('content')
<div class="container pt-3">
    <div class="row">
        <h3 class="colorSecondary inATitle1">Send Email To Member</h3>
   
        <div class="col-xl-12 mb-3">
            <div class="card inBorderColor1 inAAddMembership mb-5">
                <div class="card-body pt-5">
                    <form method="POST" action="{{route('mail.send')}}">
                        @csrf
                        <div class="row">
                            <div class="col-xl-12 mb-4">
                                <div class="row">
                                    <div class="col-xl-3">
                                        <label class="label-1 fw-semibold mt-2">Select Member Status</label>
                                    </div>
                                    <div class="col-xl-9">
                                        <select class="form-control" name="member" required id="memberstatus">
                                            <option value="">Select</option>
                                            <option value="All">All</option>
                                            <option value="Active">Active</option>
                                            <option value="Inactive">Inactive</option>
                                            <option value="Paid">Paid</option>
                                            <option value="Suspended">Suspended</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 mb-4">
                                <div class="row">
                                    <div class="col-xl-3">
                                        <label class="label-1 fw-semibold mt-2">Email To</label>
                                    </div>
                                    <div class="col-xl-9 chosen-style-3">
                                        <select name="emailto[]" class="form-select" id="emailto" data-placeholder="Select Member status first" multiple>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 mb-4">
                                <div class="row">
                                    <div class="col-xl-3">
                                        <label class="label-1 fw-semibold mt-2">Subject</label>
                                    </div>
                                    <div class="col-xl-9">
                                        <input type="text" name="subject" value="{{old('subject')}}" placeholder="Enter Email Subject" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 mb-4">
                                <div class="row">
                                    <div class="col-xl-3">
                                        <label class="label-1 fw-semibold mt-2">Email Content</label>
                                    </div>
                                    <div class="col-xl-9">
                                        <textarea class="form-control height-200" name="content" placeholder="Enter Description" required>{{old('content')}}</textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xl-12 mb-4 text-center">
                                <input type="submit" value="SEND EMAIL" class="btn btnPrimary">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div> 
    </div>
</div>
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

<script>
$(document).ready(function () {
    @if(Session::has('message'))
        $('#message').toast('show');
    @endif
    $('#memberstatus').on('change', function () {
        var memberstatus = this.value;
        $("#emailto").html('');
        $.ajax({
            url: "{{ route('admin.emailFetch') }}",
            type: "POST",
            data: {
                memberstatus: memberstatus,
                _token: '{{csrf_token()}}'
            },
            dataType: 'json',
            success: function (result) {
                $.each(result.email, function (key, value) {
                    $("#emailto").append('<option value="' + value.email + '">' + value.email + '</option>');
                });

                $("#emailto").append('<option value="all">All</option>');

                $("#emailto").chosen().trigger("chosen:updated");

                $('#emailto').chosen().change(function () {
                    var selectedValue = $(this).val();
                    
                    if (selectedValue === 'all') {
                        $('#emailto').val($("#emailto option:not([value='all'])").map(function () {
                            return this.value;
                        })).trigger('chosen:updated');
                    }
                });
                $('#emailto').chosen().change(function () {
                   var selectedValue = $(this).val();
    
                    if (selectedValue === 'all') {
                        $('#emailto option').each(function() {
                            if ($(this).val() !== 'all') {
                                $(this).prop('selected', true);
                            } else {
                                $(this).prop('selected', false);
                            }
                        });
                        $(this).trigger("chosen:updated");
                    }
                });
            }
        });
    });
    $("#emailto").chosen({
        allow_single_deselect: true,
        disable_search_threshold: 10,
        no_results_text: 'Oops, nothing found!',
        width: "100%"
    });
});
</script>
<script type="text/javascript">
    $(document).ready(function () {
        @if(Session::has('message'))
            $('#message').toast('show');
        @endif
    });
</script>

@endsection