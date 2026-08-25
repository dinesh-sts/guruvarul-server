<!DOCTYPE html>
<html lang="en">
    <head>
        @php $siteconfig = DB::table('site_configs')->select('title','description','keyword','favicon','colorPrimary','colorSecondary','colorPrimaryHover','colorSecondaryHover','google_analytics')->first(); @endphp

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        
        <title>@if(isset($siteconfig->title)){{ $siteconfig->title }} @endif</title>
        <meta name="description" content="@if(isset($siteconfig->description)){{ $siteconfig->description }} @endif">
        <meta name="keywords" content="@if(isset($siteconfig->keyword)){{ $siteconfig->keyword }} @endif">
        <link type="image/x-icon" href="{{ asset('storage/siteConfig/'.$siteconfig->favicon) }}" rel="shortcut icon"/>
        
	<!-- Manifest -->
	<link rel="manifest" href="{{ asset('manifest.json') }}">
	<meta name="theme-color" content="#ff6600">

	<!-- iOS support -->
	<link rel="apple-touch-icon" href="{{ asset('icons/favicon.png') }}">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
	<meta name="apple-mobile-web-app-title" content="Guruvarul">

        <!-- URL bar color Change -->
        <meta name="theme-color" content="#ffffff">
        <meta name="msapplication-navbutton-color" content="#ffffff">
        <meta name="apple-mobile-web-app-status-bar-style" content="#ffffff">

        <!-- Bootstap css -->
        <link href="{{ asset('user/css/bootstrap/bootstrap.min.css') }}" rel="stylesheet" crossorigin="anonymous" async>
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

        @yield('pageCSS')

    </head>
    <body class="bg1">
        <div class="preloader-wrapper">
            <center>
                <div class="loader"></div>
                <h5>Loading ...</h5>
            </center>
        </div>
    
        <div id="body" style="display:none">
            <div id="wrap">
                
                <!-- Navigation -->
                <nav class="navbar navbar-expand-lg bg-white inNavbar shadow-sm">
                    <div class="container">
                        <a class="navbar-brand inLogo" href="{{route('home')}}">
                            @php
                                $siteSettings = DB::table('site_configs')->select('web_logo_path','web_name')->first();
                                $menusetting = DB::table('menu_settings')->first();
                            @endphp
                            @if( $siteSettings != null)
                            <img src="{{ asset('storage/siteConfig/'.$siteSettings->web_logo_path) }}" class="" alt="{{ $siteSettings->web_name }}">
                            @endif
                        </a>

                        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                            <div class="offcanvas-header">
                                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">MENU</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body justify-content-end">
                                <ul class="navbar-nav ml-auto">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                                    </li>
                                    @if(!isset($menusetting->menu_membership) || $menusetting->menu_membership == "APPROVED" )
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('user.membershipPlans') }}">Membership</a>
                                        </li>
                                    @endif
                                    @if(!isset($menusetting->menu_search) || $menusetting->menu_search == "APPROVED" )
                                        <!--<li class="nav-item">
                                            <a class="nav-link" href="{{ route('user.search') }}">Search</a>
                                        </li>-->
                                    @endif
                                    @if(!isset($menusetting->menu_success) || $menusetting->menu_success == "APPROVED" )
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{route('user.successStory')}}">Success Story</a>
                                        </li>  
                                    @endif
                                    @if(!isset($menusetting->menu_login) || $menusetting->menu_login == "APPROVED" )
                                        <!-- Visible in Mobile Only -->
                                        <li class="nav-item d-block d-sm-none">
                                            <a class="nav-link" href="{{ route('user.loginWithOtp') }}">Login</a>
                                        </li>
                                    @endif
                                    @if(!isset($menusetting->menu_signup) || $menusetting->menu_signup == "APPROVED" )
                                        <li class="nav-item d-block d-sm-none">
                                            <a class="nav-link" href="{{ route('user.register') }}">Register</a>
                                        </li>
                                    @endif
                                    <!-- /.Visible in Mobile Only -->
                                    
                                    <!-- Visible in Desktop Only -->
                                    @if(!isset($menusetting->menu_login) || $menusetting->menu_login == "APPROVED" )
                                        <a class="nav-link inHeadBtnLogin shadow-sm ms-3 me-3 d-none d-sm-block" href="{{ route('user.loginWithOtp') }}">Login</a>
                                    @endif
                                    @if(!isset($menusetting->menu_signup) || $menusetting->menu_signup == "APPROVED" )
                                        <a class="nav-link inHeadBtnReg shadow-sm d-none d-sm-block" href="{{ route('user.register') }}">Register</a>
                                    @endif
                                    <!-- /. Visible in Desktop Only -->
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
                <!-- /.Navigation -->
                
                @yield('content')

                <!-- Advertisement -->
                @include('user.layouts.advertisement.advLevel1')
                
                <!-- Footer Section -->
                <section class="inFooter1">
                    <div class="container">
                        <div class="row mb-5 mt-4">
                            <div class="col-xl-4">
                                <?php
                                    $siteconfig = DB::table('site_configs')->first();

                                    $helpSectionLinks = DB::table('cms_pages')->where('page_placement','footer_help_section')->where('status','APPROVED')->get();

                                    $privacySectionLinks = DB::table('cms_pages')->where('page_placement','footer_privacy_section')->where('status','APPROVED')->get();

                                    $quickLinks = DB::table('cms_pages')->where('page_placement','footer_quicklink_section')->where('status','APPROVED')->get();

                                    $informationLinks = DB::table('cms_pages')->where('page_placement','footer_information_section')->where('status','APPROVED')->get();

                                    //menu setting
                                    $menusetting = DB::table('menu_settings')->first();
                                    //$login_user = Auth::guard('user')->user();
                                ?>
                                
                                <a href="">
                                    @if(isset($siteconfig->web_logo_path2))
                                    <img src="{{asset('storage/siteConfig/'.$siteconfig->web_logo_path2)}}" class="img-fluid" style="max-height: 70px;">
                                    @endif
                                </a>
                            </div>
                            <div class="col-xl-8">
                                @if(isset($siteconfig->web_fshort_description))
                                <p class="mb-0">{{$siteconfig->web_fshort_description}}</p>
                                @endif
                            </div>
                        </div>
                        <div class="row inFooterLinks pt-3 ps-3 pe-3">
                            <div class="col-lg-3 g-0">
                                <h1 class="font-nunito borderBottomPrimary1">HELP & SUPPORT</h1>
                                <ul class="list-unstyled mt-4">
                                    <li> 
                                        @if(!isset($menusetting->footer_contact) || $menusetting->footer_contact == "APPROVED" )
                                            <a href=" {{ route('user.contactUs') }}">Contact</a>
                                        @endif
                                        @foreach ($helpSectionLinks as $helpSectionLink)
                                            @if($helpSectionLink->page_name != 'contact-us')
                                                <a href="{{ route('user.footer',$helpSectionLink->page_name) }}">{{ $helpSectionLink->cms_title }}</a>
                                            @endif
                                        @endforeach
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-3 g-0">
                                <h1 class="font-nunito borderBottomPrimary1">TERMS & POLICY</h1>
                                <ul class="list-unstyled mt-4">
                                    <li>
                                        @foreach ($privacySectionLinks as $privacySectionLink)
                                           <a href="{{ route('user.footer',$privacySectionLink->page_name) }}">{{ $privacySectionLink->cms_title }}</a>
                                        @endforeach
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-3 g-0">
                                <h1 class="font-nunito borderBottomPrimary1">QUICK LINKS</h1>
                                <ul class="list-unstyled mt-4">
                                    <li>
                                        @if(!isset($menusetting->footer_login) || $menusetting->footer_login == "APPROVED")
                                        <a href="{{ route('user.login') }}">Login</a>
                                        @endif
                                        @if(!isset($menusetting->footer_register) || $menusetting->footer_register == "APPROVED")
                                        <a href="{{ route('user.register') }}">Register</a>
                                        @endif
                                        @if(!isset($menusetting->footer_membership) || $menusetting->footer_membership == "APPROVED")
                                            <a href="{{ route('user.membershipPlans') }}">Membership</a>
                                        @endif
                                        @foreach ($quickLinks as $quickLink)
                                            <a href="{{ route('user.footer',$quickLink->page_name) }}">{{ $quickLink->cms_title }}</a>
                                        @endforeach
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-3 g-0">
                                <h1 class="font-nunito borderBottomPrimary1">INFORMATION</h1>
                                <ul class="list-unstyled mt-4">
                                    <li>
                                        @if(!isset($menusetting->footer_search) || $menusetting->footer_search == "APPROVED")
                                        <a href="{{ route('user.search') }}">Search</a>
                                        @endif
                                        @if(!isset($menusetting->footer_success) || $menusetting->footer_success == "APPROVED")
                                        <a href="{{ route('user.successStory') }}">Success Story</a>
                                        @endif
                                        @foreach ($informationLinks as $informationLink)
                                            <a href="{{ route('user.footer',$informationLink->page_name) }}">{{ $informationLink->cms_title }}</a>
                                        @endforeach
                                    </li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="row inFooterContact mt-4 ps-3 pe-3">
                            @if($siteconfig->footer_email_status == 'show')
                                @if(isset($siteconfig->contact_email))
                                <div class="col-lg-4 g-0 mb-4">
                                    <h1 class="font-nunito">EMAIL</h1>
                                    <h4>{{$siteconfig->contact_email}}</h4>
                                </div>
                                @endif
                            @endif
                            @if($siteconfig->footer_contact_status == 'show')
                                @if(isset($siteconfig->contact_no))
                                <div class="col-lg-3 g-0 mb-4">
                                    <h1 class="font-nunito">CONTACT</h1>
                                    <h4 class="letterSpacing2">{{$siteconfig->contact_no}}</h4>
                                </div>
                                @endif
                            @endif
                            <div class="col-lg-3 g-0 mb-4">
                                <h1 class="font-nunito">FOLLOW US</h1>
                                <ul class="list-unstyled mt-0 mb-0 inFollowIcon">
                                    <li>
                                        @if(isset($siteconfig))
                                            @if($siteconfig->facebook_status == "APPROVED")
                                            <a href="{{url($siteconfig->facebook) }}" target="_blank"><i class="fa-brands fa-square-facebook"></i></a>
                                            @endif
                                            @if($siteconfig->instagram_status == "APPROVED")
                                            <a href="{{url($siteconfig->instagram) }}" target="_blank"><i class="fa-brands fa-square-instagram"></i></a>
                                            @endif
                                            @if($siteconfig->twitter_status == "APPROVED")
                                            <a href="{{url($siteconfig->twitter) }}" target="_blank"><i class="fa-brands fa-square-twitter"></i></i></a>
                                            @endif
                                            @if($siteconfig->linkedin_status == "APPROVED")
                                            <a href="{{url($siteconfig->linkedin) }}" target="_blank"><i class="fa-brands fa-linkedin"></i></a>
                                            @endif
                                            @if($siteconfig->youtube_status == "APPROVED")
                                            <a href="{{url($siteconfig->youtube) }}" target="_blank"><i class="fa-brands fa-square-youtube"></i></a>
                                            @endif
                                            @if($siteconfig->pinterest_status == "APPROVED")
                                            <a href="{{url($siteconfig->pinterest) }}" target="_blank"><i class="fa-brands fa-square-pinterest"></i></a>
                                            @endif
                                        @endif
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </section>

                <footer>
                    <div class="container text-center">
                        <div class="row">
                            <div class="col-12">
                                @if(isset($siteconfig->web_name))
                                All rights reserved by&nbsp;<a href="{{url($siteconfig->web_frienly_name) }}" target="_blank">{{$siteconfig->web_name}}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </footer>
                <!-- /.Footer Section -->
            </div>
        </div>

        @php 
            $whatsappSettings = DB::table('site_configs')->select('whatsapp_btn_status','whatsapp_no','whatsapp_btn_text')->first(); 
        @endphp
        
        @if($whatsappSettings->whatsapp_btn_status == 'APPROVED')
        <!-- Whatsapp Floating Button -->
        <a href="https://api.whatsapp.com/send?phone={{ $whatsappSettings->whatsapp_no }}" class="whatsappFloatingIcon" target="_blank">
            <img src="{{ asset('user/img/whatsapp.png') }}" >
            <div class="showWhatsappMessage">
                {{ $whatsappSettings->whatsapp_btn_text }}
            </div>
        </a>
        <!-- /. Whatsapp Floating Button -->
        @endif

        <!-- Jquery & Bootstrap js -->
        <script src="{{ asset('user/js/jquery.min.js') }}"></script>
        <script src="{{ asset('user/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
        <!-- /. Jquery & Bootstrap js -->
        <script>
            $(document).ready(function() {
                $('#body').show();
                $('.preloader-wrapper').hide();

		if ('serviceWorker' in navigator) {
		    window.addEventListener('load', function() {
		        navigator.serviceWorker.register('/service-worker.js')
		        .then(function(registration) {
		            console.log('ServiceWorker registered with scope:', registration.scope);
		        })
		        .catch(function(error) {
		            console.log('ServiceWorker registration failed:', error);
		        });
		    });
		}
	
            });
        </script>
        
        <script> 
            $(document).ready(function() {
                document.body.style.setProperty("--color-primary", "{{ $siteconfig->colorPrimary }}");
                document.body.style.setProperty("--color-secondary", "{{ $siteconfig->colorSecondary }}");
                document.body.style.setProperty("--color-primary-hover", "{{ $siteconfig->colorPrimaryHover }}");
                document.body.style.setProperty("--color-secondary-hover", "{{ $siteconfig->colorSecondaryHover }}");
            });
        </script>
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $siteconfig->google_analytics }}"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());
        
          gtag('config', '{{ $siteconfig->google_analytics }}');
        </script>
        @yield('pageJS')
        @php 
            $rightClickSettings = DB::table('site_configs')->select('right_click')->first(); 
        @endphp
        @if($rightClickSettings->right_click == 'DISABLED')
        <script>
            $(document).bind("contextmenu", function (e) { 
                return false; 
            });
            $(document).keydown(function (event) {
                if (event.keyCode == 123) { // Prevent F12
                    return false;
                } else if (event.ctrlKey && event.shiftKey && event.keyCode == 73) { // Prevent Ctrl+Shift+I        
                    return false;
                }
            });
        </script>
        @endif
    </body>
</html>
