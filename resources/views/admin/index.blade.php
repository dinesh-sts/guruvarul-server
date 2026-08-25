<!doctype html>
<html>
    <head>

        @php $siteconfig = DB::table('site_configs')->select('favicon','web_logo_path','web_name')->first(); @endphp
        
        <!-- Meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Admin Panel - Login</title>
        <link type="image/x-icon" href="{{ asset('storage/siteConfig/'.$siteconfig->favicon) }}" rel="shortcut icon"/>
        
        <!-- Bootstrap CSS -->
        <link href="{{ asset('admin/css/bootstrap/bootstrap.min.css') }}" rel="stylesheet" crossorigin="anonymous" async>
        
        <!-- Font Awsome -->
        <link href="{{ asset('admin/css/fontawesome/css/fontawesome.min.css') }}" rel="stylesheet">
        <link href="{{ asset('admin/css/fontawesome/css/all.min.css') }}" rel="stylesheet">

        <!-- Google fonts -->
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Public+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
          
        <!-- Custom CSS -->
        <link href="{{ asset('admin/css/custom.css') }}" rel="stylesheet">
                
    </head>
    <body class="inBgLight">
        <section class="inALogin">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 m-auto">
                        <div class="col text-center mb-4">
                            <img src="{{ asset('storage/siteConfig/'.$siteconfig->web_logo_path) }}" class="img-fluid maxH-60" alt="{{ $siteconfig->web_name }}">
                        </div>
                        <div class="card card-hover">
                            <div class="card-body pe-4 ps-4 pt-4">
                                <form action="{{ route('admin.login.post') }}" method="POST">
                                    @csrf
                                    <h4 class="text-center inALoginHeading font-public">Admin Panel</h4>
                                    <p class="text-center inALoginSubHeading">Enter username & password to login</p>
                                    <div class="form-floating mb-3 mt-4">
                                        <input type="text" name="email" value="" class="form-control" id="email" placeholder="Enter Username">
                                        <label for="email">Username</label>
                                    </div>
                                    <div class="form-floating mb-4">
                                        <input type="password" name="pswd" value="" class="form-control" id="password" placeholder="Enter Password">
                                        <label for="password">Password</label>
                                    </div>
                                    <div class="mb-4">
                                        <div class="row">
                                            <div class="col-lg-6 inARemberMe">
                                                <label for="flexCheckDefault">
                                                <input class="form-check-input" type="checkbox" id="flexCheckDefault"><span class="ps-2">Remember Me</span></label>
                                            </div>
                                            <div class="col-lg-6 text-end inAForgot">
                                                <a href="{{ route('admin.forgotAdminPassword') }}" class="text-decoration-none colorSecondary">Forgot Password ?</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-4 col-12">
                                        <input type="submit" value="LOGIN" class="btn btnSecondary d-block w-100 font-public">
                                    </div>
                                </form>
                            </div>
                        </div>
                        @if (env("DEMO_MODE") == "On")
                        <div class="mt-4">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td>
                                            Username - admin1
                                        </td>
                                        <td>
                                            Password - admin1
                                        </td>
                                        <td><button class="btn btn-primary btn-xs" onclick="autoFill()">Copy</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
                
            
        </section>

        <!-- Toast -->
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

        <!-- Latest Jquery CDN -->
		<script src="{{ asset('admin/js/jquery.min.js') }}"></script>
        
        <!-- Bootstrap Js -->
        <script src="{{ asset('admin/js/bootstrap/bootstrap.bundle.min.js') }} " crossorigin="anonymous"></script>

        <!-- Toast js -->
        <script type="text/javascript">
            $(document).ready(function () {
                @if(Session::has('message'))
                    $('#message').toast('show');
                @endif
            });
        </script>

        <script type="text/javascript">
            function autoFill(){
                $('#email').val('admin1');
                $('#password').val('admin1');
            }
        </script>
    </body>
</html>