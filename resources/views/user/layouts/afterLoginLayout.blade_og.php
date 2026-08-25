<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        @php $siteconfig = DB::table('site_configs')->select('title','description','keyword','favicon','colorPrimary','colorSecondary','colorPrimaryHover','colorSecondaryHover','google_analytics')->first(); @endphp
        <title>@if(isset($siteconfig->title)){{$siteconfig->title}}@endif</title>
        <meta name="description" content="@if(isset($siteconfig->description)){{$siteconfig->description}}@endif">
        <meta name="keywords" content="@if(isset($siteconfig->keyword)){{$siteconfig->keyword}} @endif">
        <link type="image/x-icon" href="{{ asset('storage/siteConfig/'.$siteconfig->favicon) }}" rel="shortcut icon"/>

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
                <h6 class="mt-2">Loading ...</h6>
            </center>
        </div>
    
        <div id="body" style="display:none">
            <div id="wrap">
                <nav class="bg-white pt-1 pb-1">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 col-lg-4 col-md-12 inHeaderImg mb-2">
                                <a class="navbar-brand inLogo" href="{{ route('user.dashboard') }}">
                                    @php $data = DB::table('site_configs')->first(); @endphp
                                    @php  $filePath = '/siteConfig/'.$data->web_logo_path; @endphp
                                    @if($data->web_logo_path != "" && Storage::disk('public')->exists($filePath))
                                    <img src="{{ asset('storage/siteConfig/'.$data->web_logo_path) }}" class="img-fluid" alt="{{ $data->web_name }}">
                                    @endif
                                </a>
                            </div>
                            <div class="col-6 col-lg-4 offset-lg-4 col-md-6 offset-md-2 inHeaderUser mb-2 d-none d-lg-block">
                                <div class="card border-0">
                                    <div class="row g-0">
                                        @php $user = Auth::guard('user')->user(); @endphp
                                        <div class="col-3 col-xl-2 col-lg-3 col-md-2 pt-1">
                                            @php  $filePath = '/userImages/'. $user->photo1; @endphp
                                            @if($user->photo1 != "" && $user->photo1_approve == "APPROVED" && Storage::disk('public')->exists($filePath))
                                                <img src="{{asset('storage/userImages/'.$user->photo1)}}" class="img-fluid">
                                            @elseif($user->photo1 != ""  && $user->gender == "Female" && $user->photo1_approve == "PENDING" && Storage::disk('public')->exists($filePath))
                                                <img src="{{asset('user/img/femalepending.jpg')}}" class="img-fluid">
                                            @elseif($user->photo1 != ""  && $user->gender == "Male" && $user->photo1_approve == "PENDING" && Storage::disk('public')->exists($filePath))
                                                <img src="{{asset('user/img/malepending.jpg')}}" class="img-fluid">
                                            @else
                                                @if($user->gender == "Male")
                                                    <img src="{{asset('user/img/male.jpg')}}" class="img-fluid">
                                                @else
                                                    <img src="{{asset('user/img/female.jpg')}}" class="img-fluid">
                                                @endif
                                            @endif
                                        </div>
                                        <div class="col-9 col-xl-10 col-lg-9 col-md-10">
                                            <div class="card-body">
                                                <h5 class="card-title inHeaderName">Hello, <span>@if(isset(Auth::guard('user')->user()->firstname)){{Auth::guard('user')->user()->firstname}}@endif @if(isset(Auth::guard('user')->user()->lastname)){{substr(Auth::guard('user')->user()->lastname, 0, 1)}}({{Auth::guard('user')->user()->matri_id}})@endif</span></h5>
                                                <p class="card-text mb-0 inHeaderStatus">Status: <b>{{Auth::guard('user')->user()->status}}</b></p>
                                                <p class="card-text mb-0 inHeaderLastLogin"><small class="text-muted"><span class="text-dark">Last Login:</span> @if(isset(Auth::guard('user')->user()->last_login)){{ \Carbon\Carbon::parse(Auth::guard('user')->user()->last_login)->format('h:iA, jS M Y')}}@endif</small></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
                @php $menusetting = DB::table('menu_settings')->first(); @endphp
                <nav class="navbar navbar-expand-lg bgPrimary inAfterNav shadow">
                    <div class="container">
            
                        <button class="navbar-toggler mt-2 mb-2 ms-auto ms-lg-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                            <div class="offcanvas-header pb-0">
                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body justify-content-end">
                                @php $user = Auth::guard('user')->user(); @endphp
                                
                                <!-- Visible Only In Small Screen -->
                                <div class="col-12 borderBottomLgtGrey1 d-block d-lg-none mt-2 pb-3">
                                    <div class="row">
                                        <div class="col-3">
                                            <?php  $filePath = '/userImages/'. $user->photo1; ?>
                                            @if($user->photo1 != "" && $user->photo1_approve == "APPROVED" && Storage::disk('public')->exists($filePath))
                                                <img src="{{asset('storage/userImages/'.$user->photo1)}}" class="img-fluid avtar110">
                                            @elseif($user->photo1 != ""  && $user->gender == "Female" && $user->photo1_approve == "PENDING" && Storage::disk('public')->exists($filePath))
                                                <img src="{{asset('user/img/femalepending.jpg')}}" class="img-fluid avtar110">
                                            @elseif($user->photo1 != ""  && $user->gender == "Male" && $user->photo1_approve == "PENDING" && Storage::disk('public')->exists($filePath))
                                                <img src="{{asset('user/img/malepending.jpg')}}" class="img-fluid avtar110">
                                            @else
                                                @if($user->gender == "Male")
                                                    <img src="{{asset('user/img/male.jpg')}}" class="img-fluid avtar110">
                                                @else
                                                    <img src="{{asset('user/img/female.jpg')}}" class="img-fluid avtar110">
                                                @endif
                                            @endif
                                        </div>
                                        <div class="col-9">
                                            <h5 class="inOffNavName">@if(isset(Auth::guard('user')->user()->firstname)){{Auth::guard('user')->user()->firstname}}@endif @if(isset(Auth::guard('user')->user()->lastname)){{substr(Auth::guard('user')->user()->lastname, 0, 1)}}@endif</h5>
                                        <p class="inOffNavId">@if(isset(Auth::guard('user')->user()->matri_id))({{Auth::guard('user')->user()->matri_id}})@endif</p>
                                        </div>
                                    </div>
                                
                                </div>
                                <!-- /.Visible Only In Small Screen -->
                                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                    <li class="nav-item">
                                        <a class="nav-link active" aria-current="page" href="{{route('user.dashboard')}}"><i class="fas fa-home"></i>HOME</a>
                                    </li>
                                    @if(!isset($menusetting->menu_search) || $menusetting->menu_search == "APPROVED" )
                                    <li class="nav-item">
                                        <!--<a class="nav-link" href="{{route('user.searchUser')}}"><i class="fas fa-magnifying-glass"></i>SEARCH</a>-->
					<a class="nav-link" href="{{route('user.searchResultView')}}"><i class="fas fa-magnifying-glass"></i>PROFILES</a>
                                    </li>
                                    @endif
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-user"></i>MY PROFILE
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="{{ route('user.profileEdit') }}">Edit Profile</a></li>
                                            <li><a class="dropdown-item" href="{{ route('user.managePhotos') }}">Manage Photos</a></li>
                                            <li><a class="dropdown-item" href="{{ route('user.manageHoroscopePhoto') }}">Manage Horoscope</a></li>
                                            <li><a class="dropdown-item" href="{{ route('user.manageDocumentPhoto') }}">Manage Document</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item" href="{{route('user.message')}}">Messages</a></li>
                                            <li><a class="dropdown-item" href="{{route('user.expressInterest',['tab' => 'sent'])}}">Express Interest</a></li>
                                            
                                        </ul>
                                    </li>
                                    <!--<li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-list"></i>MATCHES
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="{{ route('user.oneWayMatch') }}">One Way Match</a></li>
                                            <li><a class="dropdown-item" href="{{ route('user.twoWayMatch') }}">Two Way Match</a></li>
                                            <li><a class="dropdown-item" href="{{ route('user.broaderWayMatch') }}">Broader Match</a></li>
                                            <li><a class="dropdown-item" href="{{ route('user.preferedWayMatch') }}">Prefered Match</a></li>
                                            <li><a class="dropdown-item" href="{{ route('user.customWayMatch') }}">Custom Match</a></li>
                                        </ul>
                                    </li>-->
                                    @if(!isset($menusetting->menu_membership) || $menusetting->menu_membership == "APPROVED" )
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-star"></i>MEMBERSHIP
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="{{ route('user.userMembershipPlans') }}">Membership Plans</a></li>
                                            <li><a class="dropdown-item" href="{{ route('user.currenMembershipPlan') }}">Current Membership</a></li>
                                        </ul>
                                    </li>
                                    @endif
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-users"></i>PROFILE DETAILS
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="{{ route('user.shortListedProfiles') }}">Shortlisted Profiles</a></li>
                                            <li><a class="dropdown-item" href="{{ route('user.ignoredProfiles') }}">Ignored Profiles</a></li>
                                            <li><a class="dropdown-item" href="{{ route('user.myProfileViewedBy') }}">My Profile Viewed By</a></li>
                                            <li><a class="dropdown-item" href="{{ route('user.iVisitedProfiles') }}">I Visited Profiles</a></li>
                                            <li><a class="dropdown-item" href="{{ route('user.contactDetailsViewedBy') }}">Contact Details Viewed By</a></li>
                                            <li><a class="dropdown-item" href="{{ route('user.recentelyJoinedProfiles') }}">Recently Joined Profiles</a></li>
                                            <li><a class="dropdown-item" href="{{ route('user.featuredProfiles') }}">Featured Profiles</a></li>
                                            <li><a class="dropdown-item" href="{{ route('user.blockedProfiles') }}">Blocked Profiles</a></li>
                                        </ul>
                                    </li>
                                    <!-- Visible Only In Small Screen -->
                                    <li class="nav-item dropdown d-block d-lg-none">
                                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-gear"></i>SETTINGS
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="{{ route('user.photoPrivacy') }}">Photo Privacy</a></li>
                                            <li><a class="dropdown-item" href="{{ route('user.contactPrivacy') }}">Contact Privacy</a></li>
                                            <li><a class="dropdown-item" href="{{ route('user.deleteProfile') }}">Marriage Fixed</a></li>
                                            <li><a class="dropdown-item" href="{{ route('user.changePassword') }}">Change Password</a></li>
                                            <li><a class="dropdown-item" href="{{ route('user.logout') }}">Logout</a></li>
                                        </ul>
                                    </li>
                                    <!-- /.Visible Only In Small Screen -->
                                </ul>
                                <ul class="justify-content-end navbar-nav me-auto mb-2 mb-lg-0 ">
                                    <li class="nav-item dropdown inIconMenu inBorderLeftMenu d-none d-lg-block">
                                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-gear"></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="{{ route('user.photoPrivacy') }}">Photo Privacy</a></li>
                                            <li><a class="dropdown-item" href="{{ route('user.contactPrivacy') }}">Contact Privacy</a></li>
                                            <li><a class="dropdown-item" href="{{ route('user.deleteProfile') }}">Marriage Fixed</a></li>
                                            <li><a class="dropdown-item" href="{{ route('user.changePassword') }}">Change Password</a></li>
                                            <li><a class="dropdown-item" href="{{ route('user.logout') }}">Logout</a></li>
                                        </ul>
                                    </li>
                                    <li class="nav-item dropdown inIconMenu inBorderLeftMenu inBorderRightMenu d-none d-lg-block">
                                        <?php
                                            $id = Auth::guard('user')->user()->matri_id;
                                            $ignore = DB::table('ignores')->where('ignore_by', $id)->pluck('ignore_to')->toArray();
                                            $blockuser = DB::table('block_profiles')->where('block_by', $id)->pluck('block_to')->toArray();
                                            $registeruser = DB::table('registers')->whereNotIn('status',['Inactive','Suspended'])->pluck('matri_id')->toArray();
                                            $notification = DB::table('notifications')->whereIn('sender_id', $registeruser)->whereNot('sender_id',$id)->whereNotIn('sender_id', $ignore)->whereNotIn('sender_id', $blockuser)->where('receiver_id',$id)->where('seen',0)->count();
                                        ?>
                                        
                                        <a class="nav-link" href="{{ route('user.notification') }}">
                                            <i class="fas fa-bell"></i>
                                            @if($notification != 0)
                                            <span class="position-absolute top-2 start-100 translate-middle badge rounded-pill bg-dark">
                                                {{$notification}}+
                                            </span> 
                                            @endif
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
            
                <!-- Visible Only In Small Screen -->
                <nav class="navbar fixed-bottom ps-2 pe-2 inBottomFixNav d-lg-none">
                    <div class="shadow w-100 row ms-2 me-2">
                        <div class="col-3 bgPrimary rounded-start inNavShadow">
                            <a href="{{ route('user.dashboard') }}" class="text-white">
                                <i class="fas fa-home fa-fw"></i>
                                <h5>Home</h5>
                            </a>
                        </div>
                        <div class="col-3 bgPrimary inNavShadow">
                            <a href="{{ route('user.notification') }}" class="text-white">
                                <i class="fas fa-bell fa-fw"></i>
                                <h5>Notification</h5>
                                @if($notification != 0)
                                <span class="position-absolute badge rounded-pill bg-dark inMobileNotiBadge">
                                    {{$notification}}+
                                </span> 
                                @endif
                            </a>
                        </div>
                        <div class="col-3 bgPrimary inNavShadow">
                            <a href="{{route('user.message')}}" class="text-white">
                                <i class="fas fa-envelope fa-fw"></i>
                                <h5>Message</h5>
                            </a>
                        </div>
                        <div class="col-3 bgPrimary rounded-end inNavShadow">
                            <a href="{{route('user.searchResultView')}}" class="text-white">
                                <i class="fas fa-search fa-fw"></i>
                                <h5>Profiles</h5>
                            </a>
                        </div>
                    </div>
                </nav>
                <!-- /.Visible Only In Small Screen -->
                
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
                                    $login_user = Auth::guard('user')->user()->id;
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
                                        
                                        @if($login_user == '' )
                                            @if(!isset($menusetting->footer_login) || $menusetting->footer_login == "APPROVED")
                                            <a href="{{ route('user.login') }}">Login</a>
                                            @endif
                                            @if(!isset($menusetting->footer_register) || $menusetting->footer_register == "APPROVED")
                                            <a href="{{ route('user.register') }}">Register</a>
                                            @endif
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
