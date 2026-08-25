        <?php
            $log_inid = Auth::guard('user')->user();
            $expressInterestssend = DB::table('expressinterests')->where('ei_sender', $log_inid->matri_id)
            ->where(function($query) {
                $query->where('trash_sender', '!=', 'Yes')
                    ->orWhereNull('trash_sender');
            })->count();
            $expressInterestsreceive = DB::table('expressinterests')->where('ei_receiver', $log_inid->matri_id)
            ->where(function($query) {
            $query->where('trash_receiver', '!=', 'Yes')
                ->orWhereNull('trash_receiver');
        })->count();
            $siteconfig = DB::table('site_configs')->first();
            ?>
             <div class="col-lg-3 col-md-4">
                
                <!-- Interest Panel -->
                   <!-- Visible in small screen only -->
                    @if($siteconfig->username_setting == "full_username")
                        <h2 class="inDashHello mb-3 d-block d-md-none">Hello,&nbsp;<small>{{$log_inid->firstname}} {{$log_inid->lastname}}</small></h2>
                    @elseif($siteconfig->username_setting == "first_surname")
                        <h2 class="inDashHello mb-3 d-block d-md-none">Hello,&nbsp;<small>{{$log_inid->firstname}} {{substr($log_inid->lastname, 0, 1)}}</small></h2>
                    @else
                    <h2 class="inDashHello mb-3 d-block d-md-none">Hello,&nbsp;<small>{{$log_inid->matri_id}}</small></h2>
                    @endif
               <!-- /.Visible in small screen only -->
                <div class="card mb-3 inCardHomeProfile">
                    @if(isset($log_inid))
                        <?php  $filePath = '/userImages/'.$log_inid->photo1; ?>
                        @if($log_inid->photo1 != "" && Storage::disk('public')->exists($filePath))
                            <img src="{{asset('storage/userImages/'. $log_inid->photo1)}}" class="card-img-top">
                            @if($log_inid->photo1_approve == "PENDING")
                            <span class="inPhotoUploadStatus">
                                <p class="inStatusPending mb-0">
                                    <i class="fas fa-clock"></i> Pending Approval 
                                </p>
                            </span>
                            @endif
                        @elseif($log_inid->photo1 != ""  && $log_inid->gender == "Female" && $log_inid->photo1_approve == "PENDING" && Storage::disk('public')->exists($filePath))
                            <img src="{{asset('user/img/femalepending.jpg')}}" class="card-img-top">
                        @elseif($log_inid->photo1 != ""  && $log_inid->gender == "Male" && $log_inid->photo1_approve == "PENDING" && Storage::disk('public')->exists($filePath))
                            <img src="{{asset('user/img/malepending.jpg')}}" class="card-img-top">
                        @else
                            @if($log_inid->gender == "Male")
                                <img src="{{asset('user/img/male.jpg')}}" class="card-img-top">
                            @else
                                <img src="{{asset('user/img/female.jpg')}}" class="card-img-top">
                            @endif
                        @endif
                    @endif
                   
                    
                    <div class="card-body text-center">
                       <a href="{{route('user.memberProfile',$log_inid->matri_id)}}" class="btn btnSecondary d-block mb-0">VIEW PUBLIC PROFILE</a>
                    </div>
                </div>
                <div class="card mb-3 inLeftPanelCard d-none d-md-block">
                    <div class="card-header">
                        <i class="fas fa-heart pe-2"></i>INTEREST
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <ul class="list-unstyled mb-0">
                                <li>
                                    <a href="{{ route('user.expressInterest', ['tab' => 'received']) }}">
                                        <span>Received</span>
                                        <span class="badge text-bg-primary float-end">@if(isset($expressInterestsreceive)){{ $expressInterestsreceive }}@endif</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('user.expressInterest', ['tab' => 'sent']) }}">
                                        <span>Sent</span>
                                        <span class="badge text-bg-primary float-end">@if(isset($expressInterestssend)){{ $expressInterestssend }}@endif</span>
                                    </a>
                                </li>
                            </ul>
                        </ul>
                    </div>
                </div>

                <!-- /.Interest Panel -->
                
                <!-- Profile Details Panel -->
                @include('user.layouts.profileLeftPanel')
            </div>
               
