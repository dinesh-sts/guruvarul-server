<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        
        <title>Premium Matrimonial Script - Installation</title>

        <!-- URL bar color Change -->
        <meta name="theme-color" content="#ffffff">
        <meta name="msapplication-navbutton-color" content="#ffffff">
        <meta name="apple-mobile-web-app-status-bar-style" content="#ffffff">

        <!-- Bootstap css -->
        <link href="{{asset('user/css/bootstrap/bootstrap.min.css')}}" rel="stylesheet" crossorigin="anonymous" async>
        <!-- /. Bootstap css -->
            
        <!-- Font Awsome -->
        <link href="{{ asset('user/css/fontawesome/css/fontawesome.min.css') }}" rel="stylesheet">
        <link href="{{ asset('user/css/fontawesome/css/all.min.css') }}" rel="stylesheet">
        <!-- /.Font Awsome -->
        
        <!-- Google fonts -->
        <link rel="preconnect" href="https://user/fonts.googleapis.com">
        <link rel="preconnect" href="https://user/fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;500;600;700;800;900&family=Poppins:wght@200;300;400;500;600;700;800;900&family=Yesteryear&display=swap" rel="stylesheet">
        <!-- Google fonts -->

        <!-- Custom css -->
        <link href="{{ asset('user/css/custom.css') }}" rel="stylesheet">
        <!-- /. Custom css -->

    </head>
    <body>
        <div class="preloader-wrapper">
            <center>
                <h5>Loading ...</h5>
            </center>
        </div>
    
        <div id="body" style="display:none">
            <div id="wrap">
                @yield('content')
            </div>
        </div>

        <!-- Jquery & Bootstrap js -->
        <script src="{{asset('user/js/jquery.min.js')}}"></script>
        <script src="{{asset('user/js/bootstrap/bootstrap.bundle.min.js')}}"></script>
        <!-- /. Jquery & Bootstrap js -->
        <script>
            $(document).ready(function() {
                $('#body').show();
                $('.preloader-wrapper').hide();
            });
        </script>
    </body>
</html>