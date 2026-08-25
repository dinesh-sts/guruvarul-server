@extends('admin.layouts.afterLoginLayout')

@section('title') Admin - Unpaid Members @endsection

@section('pageCSS') @endsection

@section('content')

<div class="container pt-3">
    <div class="row">
        <h3 class="colorSecondary inATitle1">Unpaid Members</h3>

        <!-- All member top bar -->
        @include('admin.parts.memberTopBar')
        <!-- /. All member top bar -->

        <div class="col-12 mb-3">
            <form action="" method="post">
                @csrf
                @method('PATCH')

                @if(count($unpaidMembers) == 0)
                    <img src="{{asset('admin/img/nodata.jpg')}}" class="img-fluid rounded">
                @else
                    @foreach ($unpaidMembers as $member)
                        <!-- Admin member main result -->
                        @include('admin.parts.adminMainResult')
                        <!-- /. Admin member main result -->
                    @endforeach
                @endif
                <input type="hidden" name="action" id="selectedAction" value="">
                <button type="submit" id="performActionButton" class="btn btnSecondary d-none">Perform Action</button>
            </form>
        </div>

    </div>

    <div class="d-flex justify-content-center">
        {!! $unpaidMembers->links() !!}
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
            var action = 'approve'; 
            $('#selectedAction').val(action);
           
            $('#performActionButton').click();
        });
        $('#featuredButton').on('click', function () {
            var action = 'Featured'; 
            $('#selectedAction').val(action);
            $('#performActionButton').click();
        });
        $('#unfeaturedButton').on('click', function () {
            var action = 'unFeatured'; 
            $('#selectedAction').val(action);
            $('#performActionButton').click();
        });
        $('#unapproveButton').on('click', function () {
            var action = 'unapprove'; 
            $('#selectedAction').val(action);
            $('#performActionButton').click();
        });
        $('#delete').on('click', function () {
            var action = 'delete'; 
            $('#selectedAction').val(action);
            $('#performActionButton').click();
        });
        $('.dropdown-item[data-filter]').on('click', function (e) {
            e.preventDefault();
            var filter = $(this).data('filter');
            filterMembers(filter);
        });

        $('.inCheckbox').on('click', function () {
            if ($('.checkbox:checked').length === $('.checkbox').length) {
                $('#inCheckbox').prop('checked', true);
            } else {
                $('#inCheckbox').prop('checked', false);
            }
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
