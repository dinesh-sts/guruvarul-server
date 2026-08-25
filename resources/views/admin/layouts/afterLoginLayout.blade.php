<!DOCTYPE html>
<html lang="en">
    <head>
        <?php $siteconfig = DB::table('site_configs')->select('favicon')->first(); ?>
        
        <title>@yield('title')</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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
        <link href="{{ asset('admin/css/custom.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('admin/css/jquery.dataTables.css') }}" rel="stylesheet" type="text/css">

        <!-- Scroll bar css -->
		<link rel="stylesheet" type="text/css" href="{{ asset('admin/css/scrollbar.css') }}">

        <!-- page css -->
        @yield('pageCSS')

    </head>
    <body>   
        <div id="layoutSidenav" class="inBglight">
            
            <!-- Sidebar -->

            <!-- Visible in Large Devices -->
            <div id="layoutSidenav_nav" class="d-none d-lg-block font-public">
                <div class="sidenav width15 show bgSecondary" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="offcanvasNavbar1" aria-labelledby="offcanvasWithBothOptionsLabel">
                    <div class="inALeftPanelLogo">
                        <a href="#" class="w-100 colorPrimary">
                            <h3><b>Admin</b> Panel</h3>
                        </a>
                    </div>
                    <!-- Menu Options -->
                    @include('admin.parts.sidebar')
                </div>
            </div>
            <!-- /.Visible in Large Devices -->

            <!-- Visible in Small Devices -->
            <div id="layoutSidenav_nav" class="d-block d-lg-none font-public">
                <div class="offcanvas offcanvas-start sidenav width15 pt-5" data-bs-scroll="true" data-bs-backdrop="true" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasWithBothOptionsLabel">
                    <div class="inALeftPanelLogo pt-3">
                        <a href="" class="w-100 colorPrimary">
                            <h3><b>Admin</b> Panel</h3>
                        </a>
                    </div>
                    <!-- Menu Options -->
                    @include('admin.parts.sidebar')
                </div>
            </div>
            <!-- /.Visible in Small Devices -->

            <!-- /. Sidebar -->

            <!-- Loader -->
            <div class="preloader-wrapper">
                <center>
                    <div class="loader mb-2"></div>
                    <h5>Loading ...</h5>
                </center>
            </div>
            <!-- /. Loader -->

            <div id="body" style="display:none">
                <div id="wrap">
                    <div id="layoutSidenav_content">
                        
                        <!-- Top Navbar -->
                        <nav class="navbar fixed-top bg-white inANav">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-2 d-block d-lg-none">
                                        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                                            <span class="navbar-toggler-icon"></span>
                                        </button>
                                    </div>
                                    
                                    <!-- Visible in small device only -->
                                    <div class="col-3 col-sm-2 d-block d-lg-none">
                                        <a href="{{ route('home') }}" class="btn btnPrimary d-block ms-2">
                                            <span class="d-block"><i class="fas fa-desktop"></i></span>
                                        </a>
                                    </div>
                                    <!-- /.Visible in small device only -->
                                    
                                    <!-- Visible in large device only -->
                                    <div class="col-xl-2 offset-xl-8 col-lg-3 offset-lg-5 d-none d-lg-block text-end">
                                        <a href="{{ route('home') }}" class="btn btnLight" target="_blank">
                                            <span class="d-block inMT-2"><i class="fas fa-desktop pe-2"></i>Front End</span>
                                        </a>
                                    </div>
                                    <!-- /.Visible in large device only -->
                                    
                                    <div class="col-7 col-sm-5 offset-sm-3 col-md-4 offset-md-4 col-lg-4 offset-lg-0 col-xl-2 offset-xl-0 inANavThumb dropdown-center">
                                        <a href="" class="row g-0 dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <div class="col-3 text-center">
                                                <i class="fas fa-user-circle inNavUserIcon mt-0"></i>
                                            </div>
                                            <div class="col-9 ps-2">
                                                <h4><b class="fw-light pe-1">Hi,</b>@if(isset(Auth::guard('admin')->user()->uname)){{ Auth::guard('admin')->user()->uname }}@endif</h4>
                                                <p class="colorSecondary">Admin <i class="fas fa-chevron-down"></i></p>
                                            </div>
                                        </a>
                                        <ul class="dropdown-menu mt-2 inBorderColor1 ms-3">
                                            <li><a class="dropdown-item" href="{{route('admin.adminProfileUpdate')}}"><i class="fas fa-user-circle pe-2"></i>Update Profile</a></li>
                                            <li><a class="dropdown-item" href="{{route('admin.logout')}}"><i class="fas fa-sign-out pe-2"></i>Logout</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </nav>
                        <!-- /.Top Navbar -->

                        <!-- Main Content -->
                        @yield('content')
                        <!-- /. Main Content -->
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Toast -->
        <div class="toast-container position-fixed position-static bottom-0 end-0 p-3 mb-5 mb-sm-0" style="z-index: 1000">
            <div id="message" class="toast inToastExpress" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
                <div class="d-flex">
                    <div class="toast-body">
                        <strong class="me-auto">{{ Session::get('message') }}</strong>
                    </div>
                    <button type="button" class="btn-close me-2 m-auto bg-white p-1" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
        
        <!-- Jquery -->
        <script src="{{ asset('admin/js/jquery.min.js') }}"></script>
        
        <!-- Bootstrap Js -->
        <script src="{{ asset('admin/js/bootstrap/bootstrap.bundle.min.js') }}" crossorigin="anonymous"></script>
        <script src="{{ asset('admin/js/jquery.dataTables.js') }}" type="text/javascript" charset="utf8"></script>

        <!-- Loader Js -->
        <script>
            $(document).ready(function() {
                $('#body').show();
                $('.preloader-wrapper').hide();
            });
        </script>
        
        <!-- Tooltip Js -->
        <script>
            $(document).ready(function() {
                const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
                const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
            });
        </script>

        <!-- scrollbar simplebar js -->
		<script src="{{ asset('admin/js/scrollbar/simplebar.js') }}"></script>
		<script src="{{ asset('admin/js/scrollbar/custom.js') }}"></script>

        <!-- Sidebar Js -->
        <script>
            // jQuery script to add class on hover for the active tab
            $(document).ready(function() {
                $('.accordion-header.active').hover(function() {
                    $(this).addClass('hovered');
                }, function() {
                    $(this).removeClass('hovered');
                });
                    $('.accordion-header.active').hover(function() {
                    $(this).addClass('hovered');
                }, function() {
                    $(this).removeClass('hovered');
                });
            });
        </script>
        
        <!-- page js -->
        @yield('pageJS')

    </body>
</html>