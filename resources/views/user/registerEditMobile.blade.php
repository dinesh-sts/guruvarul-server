@extends('user.layouts.beforeLoginLayout')

@section('pageCSS')
<!-- Otp css -->
<link href="{{ asset('user/css/pincode/bootstrap-pincode-input.css') }}" rel="stylesheet">
@endsection

<!-- Content Section Start -->
@section('content')

<section class="inLogin mb-5 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 offset-xl-3">
                <div class="card">
                    <div class="card-body ps-md-5 pe-md-5 ps-4 pe-4 pt-4 pb-4">
                        <h4 class="text-center inLoginTitle mb-4">Edit Mobile No</h4> 
                    <form method="POST" action="{{ route('registerotpregenerate') }}">
                        @csrf
                            <div class="form-floating mb-4">
                                <input type="text" class="form-control" name="mobile" id="floatingInput" placeholder="Enter Mobile No">
                                <label for="floatingInput">Mobile No</label>
                            </div>
                            <div class="mb-4">
                                <input type="submit" value="Submit" class="btn btnSecondary d-block w-100">
                            </div>
                            
                            <div class="col-12">
                                <div class="inHearts text-center mb-3 bg-white">
                                    <div class="inHeartsGroup pt-2">
                                        <h5>OR</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-2">
                                <a href="{{route('user.mobileVerify')}}" class="btn btnPrimary d-block">Back to mobile verification</a>
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
<script type="text/javascript" src="{{ asset('user/js/pincode/bootstrap-pincode-input.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#pincode-input1').pincodeInput({hidedigits:false,complete:function(value, e, errorElement){
            $("#pincode-callback").html("This is the 'complete' callback firing. Current value: " + value);
        }});  
    });
    window.onload = function() {
        $('#pincode-input1').pincodeInput().data('plugin_pincodeInput').focus();
    };
</script>
@endsection