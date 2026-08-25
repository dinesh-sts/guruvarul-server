<div class="offcanvas-body justify-content-end width15 c-scrollbar inALeftPanel">
    <ul class="navbar-nav ml-auto width15" id="simple-bar">

        <!-- Dashboard -->
        <div class="accordion-item">
            <div class="accordion-header {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" id="flush-dashboard">
                <a href="{{ route('admin.dashboard') }}" class="accordion-button collapsed" type="button" aria-expanded="true" aria-controls="flush-dashboard">
                    <i class="fas fa-dashboard pe-2"></i>Dashboard
                </a>
            </div>   
        </div>
        <!-- /. Dashboard -->

        <!-- Members -->    
        <div class="accordion-item">
            <div class="accordion-header {{ request()->routeIs(['admin.membersAll','admin.membersApprovedToPaid','admin.membersFeatured','admin.renewMembership']) ? 'active' : '' }}" id="flush-members">
                <a class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-membersTab" aria-expanded="true" aria-controls="flush-members">
                    <i class="fas fa-users pe-2"></i>Members <i class="fas fa-chevron-right inALeftPanelChavron"></i>
                </a>
            </div>
            <div id="flush-membersTab" class="accordion-collapse collapse {{ request()->routeIs(['admin.membersAll','admin.membersApprovedToPaid','admin.membersFeatured','admin.renewMembership']) ? 'show' : '' }}" aria-labelledby="flush-members" data-bs-parent="#accordionFlushExample">
                <ul class="list-unstyled ps-3 pe-2">
                    <li>
                        <a href="{{ route('admin.membersAll') }}" class="{{ request()->routeIs('admin.membersAll') ? 'active' : '' }}">
                            <i class="fa-regular fa-circle pe-2"></i>All Members
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.membersApprovedToPaid') }}" class="{{ request()->routeIs('admin.membersApprovedToPaid') ? 'active' : '' }}">
                            <i class="fa-regular fa-circle pe-2"></i>Approved To Paid Members
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.renewMembership') }}" class="{{ request()->routeIs('admin.renewMembership') ? 'active' : '' }}">
                            <i class="fa-regular fa-circle pe-2"></i>Renew Membership Plan
                        </a>
                    </li>
		    <li>
                        <a href="{{ route('admin.unpaidMembers') }}" class="{{ request()->routeIs('admin.unpaidMembers') ? 'active' : '' }}">
                            <i class="fa-regular fa-circle pe-2"></i>UnPaid Members
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.membersFeatured') }}" class="{{ request()->routeIs('admin.membersFeatured') ? 'active' : '' }}">
                            <i class="fa-regular fa-circle pe-2"></i>Manage Featured Members
                        </a>
                    </li>  
                </ul>
            </div>
        </div>
        <!-- /. Members --> 

        <!-- Profile deactive req -->
        <div class="accordion-item">
            <div class="accordion-header {{ request()->routeIs('members.profileDeactiveRequest') ? 'active' : '' }}" id="flush-deleteProfileReq">
                <a href="{{ route('members.profileDeactiveRequest') }}" class="accordion-button " type="button">
                    <i class="fa-solid fa-person-circle-minus pe-2"></i>Profile Deactive Request
                </a>
            </div>
        </div>
        <!-- /. Profile deactive req -->

        <!-- Membership plan -->
        <div class="accordion-item">
            <div class="accordion-header {{ request()->routeIs(['admin.membershipPlan.create','admin.membershipPlan.all']) ? 'active' : '' }}" id="flush-plan">
                <a class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-membershipTab" aria-expanded="false" aria-controls="flush-membership">
                    <i class="fa-sharp fa-solid fa-id-card pe-2"></i>Membership Plan <i class="fas fa-chevron-right inALeftPanelChavron"></i>
                </a>
            </div>
            <div id="flush-membershipTab" class="accordion-collapse collapse {{ request()->routeIs(['admin.membershipPlan.create','admin.membershipPlan.all']) ? 'show' : '' }}" aria-labelledby="flush-membership" data-bs-parent="#accordionFlushExample">
                <ul class="list-unstyled ps-3 pe-2">
                    <li>
                        <a href="{{ route('admin.membershipPlan.create') }}" class="{{ request()->routeIs('admin.membershipPlan.create') ? 'active' : '' }}">
                            <i class="fa-regular fa-circle pe-2"></i>Add Membership Plan
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin.membershipPlan.all')}}" class="{{ request()->routeIs('admin.membershipPlan.all') ? 'active' : '' }}">
                            <i class="fa-regular fa-circle pe-2"></i>All Membership Plan
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /. Membership plan -->

        <!-- Add details -->
        <div class="accordion-item">
            <div class="accordion-header {{ request()->routeIs(['admin.religionList','admin.casteList','admin.subcasteList','admin.gotraList','admin.countryList','admin.stateList','admin.cityList','admin.occupationList','admin.educationList','admin.mtongueList','admin.starList','admin.rasiList','admin.incomeList','admin.doshList']) ? 'active' : '' }} " id="flush-details">
                <a class="accordion-button collapsed " type="button" data-bs-toggle="collapse" data-bs-target="#flush-detailsTab" aria-expanded="false" aria-controls="flush-details">
                    <i class="fas fa-plus pe-2"></i>Add/Edit Profile Details <i class="fas fa-chevron-right inALeftPanelChavron"></i>
                </a>
            </div>
            <div id="flush-detailsTab" class="accordion-collapse collapse {{ request()->routeIs(['admin.religionList','admin.casteList','admin.subcasteList','admin.gotraList','admin.countryList','admin.stateList','admin.cityList','admin.occupationList','admin.educationList','admin.mtongueList','admin.starList','admin.rasiList','admin.incomeList','admin.doshList']) ? 'show' : '' }}" aria-labelledby="flush-details" data-bs-parent="#accordionFlushExample">
                <ul class="list-unstyled ps-3 pe-2">
                    <li>
                        <a href="{{ route('admin.religionList') }}" class="{{ request()->routeIs('admin.religionList') ? 'active' : '' }}">
                            <i class="fa-regular fa-circle pe-2"></i>Religion
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.casteList') }}" class="{{ request()->routeIs('admin.casteList') ? 'active' : '' }}">
                            <i class="fa-regular fa-circle pe-2"></i>Caste
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.subcasteList') }}" class="{{ request()->routeIs('admin.subcasteList') ? 'active' : '' }}">
                            <i class="fa-regular fa-circle pe-2"></i>Sub Caste
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.gotraList') }}" class="{{ request()->routeIs('admin.gotraList') ? 'active' : '' }}">
                            <i class="fa-regular fa-circle pe-2"></i>Gotra
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.countryList') }}" class="{{ request()->routeIs('admin.countryList') ? 'active' : '' }}">
                            <i class="fa-regular fa-circle pe-2"></i>Country
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.stateList') }}" class="{{ request()->routeIs('admin.stateList') ? 'active' : '' }}">
                            <i class="fa-regular fa-circle pe-2"></i>State
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.cityList') }}" class="{{ request()->routeIs('admin.cityList') ? 'active' : '' }}">
                            <i class="fa-regular fa-circle pe-2"></i>City
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.occupationList') }}" class="{{ request()->routeIs('admin.occupationList') ? 'active' : '' }}">
                            <i class="fa-regular fa-circle pe-2"></i>Occupation
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.educationList') }}" class="{{ request()->routeIs('admin.educationList') ? 'active' : '' }}">
                            <i class="fa-regular fa-circle pe-2"></i>Education
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.mtongueList') }}" class="{{ request()->routeIs('admin.mtongueList') ? 'active' : '' }}">
                            <i class="fa-regular fa-circle pe-2"></i>Mother Tongue
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.starList') }}" class="{{ request()->routeIs('admin.starList') ? 'active' : '' }}">
                            <i class="fa-regular fa-circle pe-2"></i>Star
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.rasiList') }}" class="{{ request()->routeIs('admin.rasiList') ? 'active' : '' }}">
                            <i class="fa-regular fa-circle pe-2"></i>Rasi (Moonsign)
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.incomeList') }}" class="{{ request()->routeIs('admin.incomeList') ? 'active' : '' }}">
                            <i class="fa-regular fa-circle pe-2"></i>Monthly Income
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.doshList') }}" class="{{ request()->routeIs('admin.doshList') ? 'active' : '' }}">
                            <i class="fa-regular fa-circle pe-2"></i>Dosh
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /. Add details -->

        <!-- Matchmaking -->
        <div class="accordion-item">
            <div class="accordion-header {{ request()->routeIs('admin.matchMaking') ? 'active' : '' }}" id="flush-deleteProfileReq">
                <a href="{{ route('admin.matchMaking') }}" class="accordion-button" type="button">
                    <i class="fa-sharp fa-solid fa-id-card pe-2"></i>Match Making
                </a>
            </div>
        </div>
        <!-- /. Matchmaking -->

        <!-- Payments -->
        <div class="accordion-item">
            <div class="accordion-header {{ request()->routeIs('admin.paymentList') ? 'active' : '' }}" id="flush-payments">
                <a href="{{route('admin.paymentList')}}" class="accordion-button" type="button">
                    <i class="fa-solid fa-money-check-dollar pe-2"></i>Payments
                </a>
            </div>
        </div>
        <!-- /. Payments -->

        <!-- Approvals -->
        <div class="accordion-item">
            <div class="accordion-header {{ request()->routeIs(['admin.horoscopeList','admin.documentList','admin.profilePicList','admin.photo2List','admin.photo3List','admin.photo4List','admin.photo5List','admin.photo6List','admin.photo7List','admin.photo8List','admin.aboutMeList','admin.partnerExpectList']) ? 'active' : '' }}" id="flush-approval">
                <a class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-approvalTab" aria-expanded="false" aria-controls="flush-approval">
                    <i class="fa-solid fa-user-check pe-2"></i>Approvals <i class="fas fa-chevron-right inALeftPanelChavron"></i>
                </a>
            </div>
            <div id="flush-approvalTab" class="accordion-collapse collapse {{ request()->routeIs(['admin.horoscopeList','admin.documentList','admin.profilePicList','admin.photo2List','admin.photo3List','admin.photo4List','admin.photo5List','admin.photo6List','admin.photo7List','admin.photo8List','admin.aboutMeList','admin.partnerExpectList']) ? 'show' : '' }}" aria-labelledby="flush-approval" data-bs-parent="#accordionFlushExample">
                <ul class="list-unstyled ps-3 pe-2">
                    <li>
                        <a href="{{ route('admin.horoscopeList') }}" class="{{ request()->routeIs('admin.horoscopeList') ? 'active' : '' }}">
                            <i class="fa-regular fa-circle pe-2"></i>Horoscope Approval
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin.documentList')}}" class="{{ request()->routeIs('admin.documentList') ? 'active' : '' }}">
                            <i class="fa-regular fa-circle pe-2"></i>Document Approval
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin.profilePicList')}}" class="{{ request()->routeIs('admin.profilePicList') ? 'active' : '' }}">
                            <i class="fa-regular fa-circle pe-2"></i>Profile Pic Approval
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin.photo2List')}}" class="{{ request()->routeIs('admin.photo2List') ? 'active' : '' }}">
                            <i class="fa-regular fa-circle pe-2"></i>Photo 2 Approval
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin.photo3List')}}" class="{{ request()->routeIs('admin.photo3List') ? 'active' : '' }}">
                            <i class="fa-regular fa-circle pe-2"></i>Photo 3 Approval
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin.photo4List')}}" class="{{ request()->routeIs('admin.photo4List') ? 'active' : '' }}">
                            <i class="fa-regular fa-circle pe-2"></i>Photo 4 Approval
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin.photo5List')}}" class="{{ request()->routeIs('admin.photo5List') ? 'active' : '' }}">
                            <i class="fa-regular fa-circle pe-2"></i>Photo 5 Approval
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin.photo6List')}}" class="{{ request()->routeIs('admin.photo6List') ? 'active' : '' }}">
                            <i class="fa-regular fa-circle pe-2"></i>Photo 6 Approval
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin.photo7List')}}" class="{{ request()->routeIs('admin.photo7List') ? 'active' : '' }}">
                            <i class="fa-regular fa-circle pe-2"></i>Photo 7 Approval
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin.photo8List')}}" class="{{ request()->routeIs('admin.photo8List') ? 'active' : '' }}">
                            <i class="fa-regular fa-circle pe-2"></i>Photo 8 Approval
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin.aboutMeList')}}" class="{{ request()->routeIs('admin.aboutMeList') ? 'active' : '' }}">
                            <i class="fa-regular fa-circle pe-2"></i>About Me Approval
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin.partnerExpectList')}}" class="{{ request()->routeIs('admin.partnerExpectList') ? 'active' : '' }}">
                            <i class="fa-regular fa-circle pe-2"></i>Partner Expect Approval
                        </a>
                    </li>  
                </ul>
            </div>
        </div>
        <!-- /. Approvals -->
        
        <!-- Success Story -->
        <div class="accordion-item">
            <div class="accordion-header {{ request()->routeIs(['admin.successStoryList','admin.successStoryCreate']) ? 'active' : '' }}" id="flush-plan">
                <a class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-successTab" aria-expanded="false" aria-controls="flush-success">
                    <i class="fa-sharp fa-solid fa-id-card pe-2"></i>Success Story <i class="fas fa-chevron-right inALeftPanelChavron"></i>
                </a>
            </div>
            <div id="flush-successTab" class="accordion-collapse collapse {{ request()->routeIs(['admin.successStoryList','admin.successStoryCreate']) ? 'show' : '' }}" aria-labelledby="flush-success" data-bs-parent="#accordionFlushExample">
                <ul class="list-unstyled ps-3 pe-2">
                    <li>
                        <a href="{{route('admin.successStoryList')}}" class="{{ request()->routeIs('admin.successStoryList') ? 'active' : '' }}">
                            <i class="fa-regular fa-circle pe-2"></i>Success Story Approval
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin.successStoryCreate')}}" class="{{ request()->routeIs('admin.successStoryCreate') ? 'active' : '' }}">
                            <i class="fa-regular fa-circle pe-2"></i>Add Success Story
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /. Success Story -->
        
        <!-- User activity -->
        <div class="accordion-item">
            <div class="accordion-header {{ request()->routeIs(['admin.expressActivity','admin.messageActivity','admin.viewedActivity','admin.ignoredActivity','admin.shortlistedActivity','admin.blockedActivity']) ? 'active' : '' }}" id="flush-activity">
                <a class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-activityTab" aria-expanded="false" aria-controls="flush-activity">
                    <i class="fa-solid fa-user pe-2"></i>User Activity <i class="fas fa-chevron-right inALeftPanelChavron"></i>
                </a>
            </div>
            <div id="flush-activityTab" class="accordion-collapse collapse {{ request()->routeIs(['admin.expressActivity','admin.messageActivity','admin.viewedActivity','admin.ignoredActivity','admin.shortlistedActivity','admin.blockedActivity']) ? 'show' : '' }}" aria-labelledby="flush-activity" data-bs-parent="#accordionFlushExample">
                <ul class="list-unstyled ps-3 pe-2">
                    <li>
                        <a href="{{route('admin.expressActivity')}}" class="{{ request()->routeIs('admin.expressActivity') ? 'active' : '' }}">
                            <i class="fa-regular fa-circle pe-2"></i>Express Interest
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin.messageActivity')}}" class="{{ request()->routeIs('admin.messageActivity') ? 'active' : '' }}">
                            <i class="fa-regular fa-circle pe-2"></i>Message
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin.viewedActivity')}}" class="{{ request()->routeIs('admin.viewedActivity') ? 'active' : '' }}">
                            <i class="fa-regular fa-circle pe-2"></i>Viewed Profile
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin.ignoredActivity')}}" class="{{ request()->routeIs('admin.ignoredActivity') ? 'active' : '' }}">
                            <i class="fa-regular fa-circle pe-2"></i>Ignored Profile
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin.shortlistedActivity')}}" class="{{ request()->routeIs('admin.shortlistedActivity') ? 'active' : '' }}">
                            <i class="fa-regular fa-circle pe-2"></i>Shortlisted Profile
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin.blockedActivity')}}" class="{{ request()->routeIs('admin.blockedActivity') ? 'active' : '' }}">
                            <i class="fa-regular fa-circle pe-2"></i>Blocked Profile
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /. User activity -->
        
        <!-- CMS Pages -->
        <div class="accordion-item">
            <div class="accordion-header {{ request()->routeIs('admin.cmsList') ? 'active' : '' }}" id="flush-cms">
                <a href="{{route('admin.cmsList')}}" class="accordion-button collapsed" type="button">
                    <i class="fas fa-file-text pe-2"></i>CMS Page Management
                </a>
            </div>
        </div>
        <!-- /. CMS Pages -->

        <!-- Send email to members -->
        <div class="accordion-item">
            <div class="accordion-header {{ request()->routeIs('admin.sendMail') ? 'active' : '' }}" id="flush-cms">
                <a href="{{route('admin.sendMail')}}" class="accordion-button collapsed" type="button">
                    <i class="fas fa-paper-plane pe-2"></i>Send Email To Members
                </a>
            </div>
        </div>
        <!-- /. Send email to members -->

        <!-- Advertisement -->
        <div class="accordion-item">
            <div class="accordion-header {{ request()->routeIs(['admin.advertisementList','admin.advertisementCreate']) ? 'active' : '' }}" id="flush-plan">
                <a class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-adsTab" aria-expanded="false" aria-controls="flush-ads">
                    <i class="fa-solid fa-rectangle-ad pe-2"></i>Advertisement <i class="fas fa-chevron-right inALeftPanelChavron"></i>
                </a>
            </div>
            <div id="flush-adsTab" class="accordion-collapse collapse  {{ request()->routeIs(['admin.advertisementList','admin.advertisementCreate']) ? 'show' : '' }}" aria-labelledby="flush-ads" data-bs-parent="#accordionFlushExample">
                <ul class="list-unstyled ps-4 pe-2">
                    <li>
                        <a href="{{route('admin.advertisementList')}}" class="{{ request()->routeIs('admin.advertisementList') ? 'active' : '' }}">
                            <i class="fa-regular fa-circle pe-2"></i>All Advertisement
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin.advertisementCreate')}}" class="{{ request()->routeIs('admin.advertisementCreate') ? 'active' : '' }}">
                            <i class="fa-regular fa-circle pe-2"></i>Add Advertisement
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /. Advertisement -->
        
        <!-- Currency -->
        <div class="accordion-item">
            <div class="accordion-header {{ request()->routeIs('admin.currencyList') ? 'active' : '' }}" id="flush-currencyList">
                <a href="{{ route('admin.currencyList') }}" class="accordion-button collapsed">
                    <i class="fas fa-coins pe-2"></i>Currency
                </a>
            </div>
        </div>
        <!-- /. Currency -->

        <!-- Manual payment method -->
        <div class="accordion-item">
            <div class="accordion-header {{ request()->routeIs('admin.manualPaymentMethod') ? 'active' : '' }}" id="flush-manualpaymentmethod">
                <a href="{{ route('admin.manualPaymentMethod') }}" class="accordion-button collapsed">
                    <i class="fas fa-qrcode pe-2"></i>Manual Payment Method
                </a>
            </div>
        </div>
        <!-- /. Manual payment method -->
        
        <!-- Website Appearance -->
        <div class="accordion-item">
            <div class="accordion-header {{ request()->routeIs(['admin.uploadLogo','admin.uploadBanner','admin.themeColorChange','admin.socialMediaLinks']) ? 'active' : '' }}" id="flush-appearance">
                <a class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-appearanceTab" aria-expanded="false" aria-controls="flush-appearance">
                    <i class="fa-solid fa-paint-brush pe-2"></i>Website Appearance <i class="fas fa-chevron-right inALeftPanelChavron"></i>
                </a>
            </div>
            <div id="flush-appearanceTab" class="accordion-collapse collapse {{ request()->routeIs(['admin.uploadLogo','admin.uploadBanner','admin.themeColorChange','admin.socialMediaLinks','admin.homepageConfig']) ? 'show' : '' }}" aria-labelledby="flush-appearance" data-bs-parent="#accordionFlushExample">
                <ul class="list-unstyled ps-3 pe-2">
                    <li>
                        <a href="{{route('admin.themeColorChange')}}" class="{{ request()->routeIs('admin.themeColorChange') ? 'active' : '' }}">
                            <i class="fa-regular fa-circle pe-2"></i>Change Theme Color
                        </a>
                    </li> 
                    <li>
                        <a href="{{route('admin.uploadLogo')}}" class="{{ request()->routeIs('admin.uploadLogo') ? 'active' : '' }}">
                            <i class="fa-regular fa-circle pe-2"></i>Logo & Favicon Update
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin.homepageConfig')}}" class="{{ request()->routeIs('admin.homepageConfig') ? 'active' : '' }}">
                            <i class="fa-regular fa-circle pe-2"></i>Homepage Config
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin.socialMediaLinks')}}" class="{{ request()->routeIs('admin.socialMediaLinks') ? 'active' : '' }}">
                            <i class="fa-regular fa-circle pe-2"></i>Social Media Link Update
                        </a>
                    </li> 
                </ul>
            </div>
        </div>
        <!-- /. Website Appearance -->
        
        <!-- Site Settings -->
        <div class="accordion-item">
            <div class="accordion-header {{ request()->routeIs(['admin.basicSiteSettings','admin.smsSettings','admin.seoSettings','admin.fieldSettings','admin.menuSettings','admin.paymentMethods','admin.smtpSettings']) ? 'active' : '' }}" id="flush-settings">
                <a class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-settingsTab" aria-expanded="false" aria-controls="flush-settings">
                    <i class="fa-solid fa-gear pe-2"></i>Settings <i class="fas fa-chevron-right inALeftPanelChavron"></i>
                </a>
            </div>
            <div id="flush-settingsTab" class="accordion-collapse collapse {{ request()->routeIs(['admin.whatsappButtonSettings','admin.basicSiteSettings','admin.smsSettings','admin.seoSettings','admin.fieldSettings','admin.menuSettings','admin.paymentMethods','admin.smtpSettings']) ? 'show' : '' }}" aria-labelledby="flush-settings" data-bs-parent="#accordionFlushExample">
                <ul class="list-unstyled ps-3 pe-2">
                    <li>
                        <a href="{{route('admin.whatsappButtonSettings')}}" class="{{ request()->routeIs('admin.whatsappButtonSettings') ? 'active' : '' }}">
                            <i class="fa-regular fa-circle pe-2"></i>Whatsapp Button Setting
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin.basicSiteSettings')}}" class="{{ request()->routeIs('admin.basicSiteSettings') ? 'active' : '' }}">
                            <i class="fa-regular fa-circle pe-2"></i>Basic Site Setting
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin.smsSettings')}}" class="{{ request()->routeIs('admin.smsSettings') ? 'active' : '' }}">
                            <i class="fa-regular fa-circle pe-2"></i>SMS Site Setting
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin.seoSettings')}}" class="{{ request()->routeIs('admin.seoSettings') ? 'active' : '' }}">
                            <i class="fa-regular fa-circle pe-2"></i>SEO Settings
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin.fieldSettings')}}" class="{{ request()->routeIs('admin.fieldSettings') ? 'active' : '' }}">
                            <i class="fa-regular fa-circle pe-2"></i>Field Enable / Disable
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin.menuSettings')}}" class="{{ request()->routeIs('admin.menuSettings') ? 'active' : '' }}">
                            <i class="fa-regular fa-circle pe-2"></i>Menu Item Enable / Disable
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin.paymentMethods')}}" class="{{ request()->routeIs('admin.paymentMethods') ? 'active' : '' }}">
                            <i class="fa-regular fa-circle pe-2"></i>Payment Method
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin.smtpSettings')}}" class="{{ request()->routeIs('admin.smtpSettings') ? 'active' : '' }}">
                            <i class="fa-regular fa-circle pe-2"></i>SMTP Email Setting
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /. Site Settings -->

        <!-- Contact us data -->
        <div class="accordion-item">
            <div class="accordion-header {{ request()->routeIs('admin.contactusData') ? 'active' : '' }}" id="flush-contact">
                <a href="{{route('admin.contactusData')}}" class="accordion-button collapsed">
                    <i class="fas fa-phone pe-2"></i>Contact Us Data
                </a>
            </div>
        </div>
        <!-- /. Contact us data -->
        
        <!-- Database backup -->
        <div class="accordion-item">
            <div class="accordion-header {{ request()->routeIs('admin.databaseBackupShow') ? 'active' : '' }}" id="flush-databaseBackup">
                <a href="{{ route('admin.databaseBackupShow') }}" class="accordion-button collapsed ">
                    <i class="fa-solid fa-server pe-2"></i>Database Backup
                </a>
            </div>
        </div>
        <!-- /. Database backup -->

        <!-- Change password -->
        <div class="accordion-item pb-5">
            <div class="accordion-header {{ request()->routeIs('admin.changeAdminPassword') ? 'active' : '' }}" id="flush-password">
                <a href="{{ route('admin.changeAdminPassword') }}" class="accordion-button collapsed ">
                    <i class="fa-solid fa-user-lock pe-2"></i>Change Password
                </a>
            </div>
        </div>
        <!-- /. Change password -->

    </ul>
</div>


