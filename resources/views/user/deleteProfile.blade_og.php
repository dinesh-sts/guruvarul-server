@extends('user.layouts.afterLoginLayout')

@section('pageCSS')
    
@endsection

<!-- Content Section Start -->
@section('content')
<section class="inPageHeader">
    <div class="container">
        <h2 class="text-center">Marriage Fixed</h2>
    </div>
</section>
<section class="inHome mt-5">
    <div class="container">
        <div class="row">
            <!-- Settings Panel -->
            @include('user.layouts.settingsLeftPanel')
            <!-- /.Settings Panel -->
            <div class="col-lg-9 col-md-8">
                
                <div class="card mb-4 inEditCard">
                    <div class="card-body">
                        <form action="{{route('user.deleteProfileStore')}}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 mb-3">
                                    <label class="label-1">Choose Reason To Set Marriage Fixed</label>
                                    <select class="form-select" name="reason" id="floatingSelect" required>
                                        <option value="" selected>Select</option>
                                        <option value="Marriage Fixed">Marriage Fixed</option>
                                        <option value="Married">Married</option>
                                        <option value="Not Getting Matching Profiles">Not Getting Matching Profiles</option>
                                        <option value="Not Interested In Marriage Now">Not Interested In Marriage Now</option>
                                    </select>
                                </div>
                            </div>
                            <div class="text-center mt-3">
                                <input type="submit" value="MARRIAGE FIXED" name="" class="btn btnPrimary">
                            </div>
                        </form>
                    </div>
                </div>
               
            </div>
        </div>
    </div>
</section>

@endsection

@section('pageJS')

    @include('user.layouts.resultActionBtnJs')

@endsection
