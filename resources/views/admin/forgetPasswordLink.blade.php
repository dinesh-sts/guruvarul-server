<!DOCTYPE html>
<html lang="en">
<head>

    <?php $siteconfig = DB::table('site_configs')->select('favicon')->first(); ?>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link type="image/x-icon" href="{{ asset('storage/siteConfig/'.$siteconfig->favicon) }}" rel="shortcut icon"/>
    
    <!-- Bootstrap CSS -->
    <link href="{{ asset('admin/css/bootstrap/bootstrap.min.css') }}" rel="stylesheet" crossorigin="anonymous" async>

    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;500;600;700;800;900&family=Poppins:wght@200;300;400;500;600;700;800;900&family=Yesteryear&display=swap" rel="stylesheet">
        
    <!-- Custom CSS -->
    <link href="{{ asset('admin/css/custom.css') }}" rel="stylesheet">
 
</head>
<body class="bg-light">
    <section class="inALogin">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 offset-xl-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body pe-5 ps-5 pt-4">
                             <form action="{{route('admin.resetPasswordStore')}}" method="POST">
                                @csrf
                                <input type="hidden" name="token" value="{{ $token }}">
                                <h4 class="text-center inALoginHeading">Reset Password</h4>
                                <div class="form-floating mb-4 mt-4">
                                    <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                                    <label for="floatingInput">E-Mail Address</label>
                                    @error('email')
                                    <div style="color:red">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-floating mb-4 mt-4">
                                    <input type="password" name="password" class="form-control" id="floatingInput" placeholder="name@example.com">
                                    <label for="floatingInput">Password</label>
                                    @error('password')
                                        <div style="color:red">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-floating mb-4 mt-4">
                                    <input type="password" name="confirm_password" class="form-control" id="floatingInput" placeholder="name@example.com">
                                    <label for="floatingInput">Confirm Password</label>
                                    @error('confirm_password')
                                        <div style="color:red">{{ $message }}</div>
                                    @enderror
                                </div>
    
                                <div class="mb-4 col-12">
                                    <input type="submit" value="SUBMIT" class="btn btnSecondary d-block w-100">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="toast-container position-fixed position-static bottom-0 end-0 p-3 mb-5 mb-sm-0">
            <div id="message" class="toast inToastExpress" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
                <div class="d-flex">
                    <div class="toast-body">
                        <strong class="me-auto">{{ Session::get('message') }}</strong>
                    </div>
                    <button type="button" class="btn-close me-2 m-auto bg-white p-1" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </section>
    <!-- Latest Jquery CDN -->
    <script src="{{ asset('admin/js/jquery.min.js') }}"></script>
    
    <!-- Bootstrap Js -->
    <script src="{{ asset('admin/js/bootstrap/bootstrap.bundle.min.js') }} " crossorigin="anonymous"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            @if(Session::has('message'))
                $('#message').toast('show');
            @endif
        });
    </script>

</body>
</html>