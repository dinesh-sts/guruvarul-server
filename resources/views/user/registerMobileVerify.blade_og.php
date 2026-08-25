@extends('user.layouts.beforeLoginLayout')

@section('pageCSS')
@endsection

<!-- Content Section Start -->
@section('content')

<!-- Login Card -->
<section class="inMobileVerification mb-5 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 offset-xl-3">
                <div class="card">
                    <div class="card-body ps-md-5 pe-md-5 ps-4 pe-4 pt-4 pb-4">
                        <h4 class="text-center inLoginTitle mb-0">Verify Your Mobile No</h4>
                        <p class="text-center mb-4">Enter your OTP to verify your mobile no.</p>
                        <h5 class="text-center">+91-{{substr_replace(Session::get('user_id'),"xxxxxx",2,6)}}</h5>
                        <div class="col-12 text-center mb-5">
                            <a href="{{ route('user.editMobileNo') }}" class="btn btnSecondary"><i class="fas fa-pen pe-2"></i>EDIT MOBILE NO</a>
                        </div>
                        
                        @if(env('DEMO_MODE') == 'On')
                            @if(Session::has('otp'))
                            <p class="alert alert-info">{{ Session::get('otp') }}</p>
                            @endif
                        @endif
                        <form method="POST" action="{{ route('user.registerOtpVerify') }}">
                            @csrf
                            <div class="mb-5 justify-content-center text-center inOtpCode">
                                <div id="otp_target" data-otp-length="4"></div>
                            </div>
                            <div class="mb-5">
                                <input type="hidden" name="varify_code" id="pincode-input1">
                                <input type="submit" value="VERIFY" class="btn btnPrimary d-block w-100">

                            </div>
                        </form>
                        <form method="POST" action="{{ route('user.registerOTPRegenerate') }}">
                            @csrf
                            <div class="row">
                                <input type="hidden" name="user_id" value="{{ Session::get('user_id') }}">
                                <div class="col-xl-12">
                                    <p class="text-center mb-2">Not received verification code yet? <span id="countVerify"></span><b>s</b></p>
                                </div>
                                <div class="col-xl-12 text-center">
                                    <input type="submit" class="btn btn-dark text-center" value="RESEND OTP" id="btnCounterVerify" disabled>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="toast-container position-fixed position-static bottom-0 end-0 p-3 mb-5 mb-sm-0">
        <div id="otp" class="toast inToastExpress" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
            <div class="d-flex">
                <div class="toast-body">
                    <strong class="me-auto">Otp Sent Successfully</strong>
                </div>
                <button type="button" class="btn-close me-2 m-auto bg-white p-1" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
    
</section>

@endsection

@section('pageJS')
<script>
    $(document).ready(function () {
        @if(Session::has('otp'))
            $('#otp').toast('show');
        @endif
    });
</script>
<script>
    const toastTrigger = document.getElementById('reshow')
   
   const toastLiveExample = document.getElementById('liveToast')
    if (toastTrigger) {
      toastTrigger.addEventListener('click', () => {
        const toast = new bootstrap.Toast(toastLiveExample)
        toast.show()
      })
    }
</script>
<!-- Timer js -->
<script>
    // Get refreence to span and button
    var spn = document.getElementById("countVerify");
    var btn = document.getElementById("btnCounterVerify");

    var count = 10;     // Set count
    var timer = null;  // For referencing the timer

    (function countDown(){
      // Display counter and start counting down
      spn.textContent = count;

      // Run the function again every second if the count is not zero
      if(count !== 0){
        timer = setTimeout(countDown, 1000);
        count--; // decrease the timer
      } else {
        // Enable the button
        btn.removeAttribute("disabled");
      }
    }());
</script>
<!-- /. Timer js -->

<!-- Otp js -->
<script src="{{ asset('user/js/otp.js') }}"></script>
<script>
    $(document).ready(function() {
      $('#otp_target').otpdesigner({
        typingDone: function (code) {
          console.log('Entered OTP code: ' + code);
          document.getElementById('pincode-input1').value = code;
        },
      });
    });
</script>
<!-- /. Otp js -->
@endsection