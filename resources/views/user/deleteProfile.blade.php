@extends('user.layouts.afterLoginLayout')

@section('pageCSS')
<style>
    #qrSection { display: none; }
</style>
@endsection

@section('content')
<section class="inPageHeader">
    <div class="container">
        <h2 class="text-center">Marriage Fixed</h2>
    </div>
</section>
<section class="inHome mt-5">
    <div class="container">
        <div class="row">
            @include('user.layouts.settingsLeftPanel')
            <div class="col-lg-9 col-md-8">
                <div class="card mb-4 inEditCard">
                    <div class="card-body">
                        <form action="{{route('user.deleteProfileStore')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 mb-3">
                                    <label class="label-1">Choose Reason To Set Marriage Fixed</label>
                                    <select class="form-select" name="reason" required>
                                        <option value="" selected>Select</option>
                                        <option value="Marriage Fixed">Marriage Fixed</option>
                                        <option value="Married">Married</option>
                                        <option value="Not Getting Matching Profiles">Not Getting Matching Profiles</option>
                                        <option value="Not Interested In Marriage Now">Not Interested In Marriage Now</option>
                                    </select>
                                </div>

                                <!-- Donate Checkbox -->
                                <div class="col-xl-12 col-lg-12 mb-3">
                                    <label>
                                        <input type="checkbox" id="donateCheck" name="donate" value="1">
                                        Donate
                                    </label>
                                </div>
                            </div>

                            <!-- QR Code + Screenshot Upload -->
                            <div id="qrSection" class="mt-3">
                                <div class="col-md-6 text-center">
                                    <h5>Scan to Pay</h5>
                                    <img src="{{ Storage::url('manualPaymentImg/1752474372.png') }}" 
                                        alt="QR Code" 
                                        class="img-fluid rounded shadow"
                                        style="max-width: 250px;">
                                    <p class="mt-2">Scan the QR code to make your payment</p>
                                </div>

                                <div class="col-xl-12 col-lg-12 mt-3">
                                    <label class="label-1">Upload Payment Screenshot</label>
                                    <input type="file" class="form-control" name="payment_screenshot" accept="image/*">
                                </div>
                            </div>

                            <div class="text-center mt-3">
                                <input type="submit" value="MARRIAGE FIXED" class="btn btnPrimary">
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
<script>
    document.getElementById('donateCheck').addEventListener('change', function () {
        document.getElementById('qrSection').style.display = this.checked ? 'block' : 'none';
    });
</script>
@include('user.layouts.resultActionBtnJs')
@endsection
