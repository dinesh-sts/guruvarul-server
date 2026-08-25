@extends('admin.layouts.afterLoginLayout')

@section('title') Admin - Member approved to paid @endsection

@section('pageCSS') @endsection

@section('content')

<div class="container pt-3">
    <div class="row">
        <h3 class="colorSecondary inATitle1">Approved To Paid Members</h3>

        <!-- All member top bar -->
        @include('admin.parts.memberTopBar')
        <!-- /. All member top bar -->

        <div class="col-12">
            @if(count($members) == 0)
                <img src="{{asset('admin/img/nodata.jpg')}}" class="img-fluid rounded">
            @else
                @foreach($members as $member)
                    <!-- Admin member main result -->
                    @include('admin.parts.adminMainResult')
                    <!-- /. Admin member main result -->

                    <!-- Paid Model -->
                    @include('admin.parts.approveToPaidModel')
                    <!-- /. Paid Model -->
                @endforeach
            @endif
        </div>
    </div>
    <div class="d-flex justify-content-center">
        {!! $members->links() !!}
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
</script>
@endsection