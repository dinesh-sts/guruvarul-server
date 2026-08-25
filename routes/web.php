<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\user\PayuController;
use App\Http\Controllers\user\UserContactUsController;
use App\Http\Controllers\user\RegisterController;
use App\Http\Controllers\user\HomeController;
use App\Http\Controllers\user\MatchesController;
use App\Http\Controllers\user\MessageController;
use App\Http\Controllers\user\NotificationController;
use App\Http\Controllers\user\ProfileDetailsController;
use App\Http\Controllers\user\RazorpayController;
use App\Http\Controllers\user\SearchController;
use App\Http\Controllers\user\UserDashboardController;
use App\Http\Controllers\user\UserLoginController;
use App\Http\Controllers\user\UserMembershipController;
use App\Http\Controllers\user\UserProfileController;
use App\Http\Controllers\user\FooterController;
use App\Http\Controllers\admin\AdminDashboardController;
use App\Http\Controllers\admin\MembersController;
use App\Http\Controllers\admin\MembershipPlanController;
use App\Http\Controllers\admin\addProfileDetails\AddProfileAnualIncomeController;
use App\Http\Controllers\admin\addProfileDetails\AddProfileReligionController;
use App\Http\Controllers\admin\addProfileDetails\AddProfileCasteController;
use App\Http\Controllers\admin\addProfileDetails\AddProfileCityController;
use App\Http\Controllers\admin\addProfileDetails\AddProfileCountryController;
use App\Http\Controllers\admin\addProfileDetails\AddProfileDoshController;
use App\Http\Controllers\admin\addProfileDetails\AddProfileEducationController;
use App\Http\Controllers\admin\addProfileDetails\AddProfileGotraController;
use App\Http\Controllers\admin\addProfileDetails\AddProfileMotherTongueController;
use App\Http\Controllers\admin\addProfileDetails\AddProfileOccupationController;
use App\Http\Controllers\admin\addProfileDetails\AddProfileRasiController;
use App\Http\Controllers\admin\addProfileDetails\AddProfileStarController;
use App\Http\Controllers\admin\addProfileDetails\AddProfileStateController;
use App\Http\Controllers\admin\addProfileDetails\AddProfileSubCasteController;
use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\admin\AdvertisementController;
use App\Http\Controllers\admin\approvals\ApprovalAboutMeController;
use App\Http\Controllers\admin\approvals\ApprovalDocumentController;
use App\Http\Controllers\admin\approvals\ApprovalHoroscopeController;
use App\Http\Controllers\admin\approvals\ApprovalPartnerExpectController;
use App\Http\Controllers\admin\approvals\ApprovalPhoto2Controller;
use App\Http\Controllers\admin\approvals\ApprovalPhoto3Controller;
use App\Http\Controllers\admin\approvals\ApprovalPhoto4Controller;
use App\Http\Controllers\admin\approvals\ApprovalPhoto5Controller;
use App\Http\Controllers\admin\approvals\ApprovalPhoto6Controller;
use App\Http\Controllers\admin\approvals\ApprovalPhoto7Controller;
use App\Http\Controllers\admin\approvals\ApprovalPhoto8Controller;
use App\Http\Controllers\admin\approvals\ApprovalProfilepicController;
use App\Http\Controllers\admin\CmsPageController;
use App\Http\Controllers\admin\ContactUsController;
use App\Http\Controllers\admin\CurrencyController;
use App\Http\Controllers\admin\DatabaseBackupController;
use App\Http\Controllers\admin\MailController;
use App\Http\Controllers\admin\MatchMakingController;
use App\Http\Controllers\admin\PaymentController;
use App\Http\Controllers\admin\ProfileDeactiveController;
use App\Http\Controllers\admin\settings\HomepageController;
use App\Http\Controllers\admin\settings\BasicSiteController;
use App\Http\Controllers\admin\settings\FieldSettingController;
use App\Http\Controllers\admin\settings\LogoController;
use App\Http\Controllers\admin\settings\MenuSettingController;
use App\Http\Controllers\admin\settings\PaymentMethodController;
use App\Http\Controllers\admin\settings\SeoSettingController;
use App\Http\Controllers\admin\settings\SMSController;
use App\Http\Controllers\admin\settings\SMTPEmailController;
use App\Http\Controllers\admin\settings\SocialMediaController;
use App\Http\Controllers\admin\settings\AppearanceController;
use App\Http\Controllers\admin\settings\WaterMarkController;
use App\Http\Controllers\admin\settings\WhatsappButtonController;
use App\Http\Controllers\admin\SuccessStoryController;
use App\Http\Controllers\admin\userActivity\BlockedUserActivityController;
use App\Http\Controllers\admin\userActivity\ExpressIntrestActivityController;
use App\Http\Controllers\admin\userActivity\IgnoreUserActivityController;
use App\Http\Controllers\admin\userActivity\MessageUserActivityController;
use App\Http\Controllers\admin\userActivity\ShortlistedUserActivityController;
use App\Http\Controllers\admin\userActivity\ViewedUserActivityController;
use App\Http\Controllers\admin\UserRegisterController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Storage link generate
Route::get('/storage-link', function () {
    $targetFolder =  storage_path('app/public');
    $linkFolder  = $_SERVER['DOCUMENT_ROOT'] . '/storage';
    symlink($targetFolder,$linkFolder);
}); 


Route::controller(HomeController::class)->group(function () {
    // Homepage
    Route::get('/', 'index')->name('home');

    // Membership Plan
    Route::get('/membership-plans',  'membershipPlans')->name('user.membershipPlans');


    //Search without login
    Route::get('/search',  'search')->name('user.search');
    Route::post('searchfetchcaste',  'searchfetchcaste')->name('searchfetchcaste');
    Route::post('searchfetchcastesingle',  'searchfetchcastesingle')->name('searchfetchcastesingle');
    Route::get('/profileCheck/{approval}',  'profileCheck')->name('user.profileCheck');

    //Success story
    Route::get('/success-story',  'successStory')->name('user.successStory');
    Route::post('/success-story-post',  'successStoryPost')->name('user.successStoryPost');
    Route::get('/success-story-read/{id}',  'successStoryRead')->name('user.successStoryRead');
});

//Search Profile After Login
Route::controller(SearchController::class)->group(function () {  
    Route::get('/search-user', [SearchController::class, 'search'])->name('user.searchUser');
    Route::post('/search-result', [SearchController::class, 'quickSearch'])->name('user.searchResult');
    Route::get('/search-result-view', [SearchController::class, 'result'])->name('user.searchResultView');
    //Route::get('/search-result-view', [SearchController::class, 'result'])
    //->middleware('auth') // 👈 This enforces login
    //->name('user.searchResultView');
    Route::post('/search-single-result', [SearchController::class, 'singlesearch'])->name('user.profile.singlesearch');
    Route::get('/search-data', [SearchController::class, 'searchdata'])->name('user.searchData');
    Route::post('s-fetchcaste', [SearchController::class, 'searchfetchcaste'])->name('search.fetch.caste');
    Route::post('searchstate', [SearchController::class, 'searchstate'])->name('searchstate');
    Route::post('searchcity', [SearchController::class, 'searchcity'])->name('searchcity');
});
/*Route::middleware(['auth'])->group(function () {
    Route::controller(SearchController::class)->group(function () {  
        Route::get('/search-user', 'search')->name('user.searchUser');
        Route::post('/search-result', 'quickSearch')->name('user.searchResult');
        Route::get('/search-result-view', 'result')->name('user.searchResultView');
        Route::post('/search-single-result', 'singlesearch')->name('user.profile.singlesearch');
        Route::get('/search-data', 'searchdata')->name('user.searchData');
        Route::post('s-fetchcaste', 'searchfetchcaste')->name('search.fetch.caste');
        Route::post('searchstate', 'searchstate')->name('searchstate');
        Route::post('searchcity', 'searchcity')->name('searchcity');
    });
});*/



Route::controller(UserLoginController::class)->group(function () {
    //Login
    Route::get('/login-admin', 'login')->name('user.login');
    /*Route::get('/login', function () {
        return redirect()->route('user.loginWithOtp');
    })->name('user.login');*/
    Route::post('/loginPost',  'logincheck')->name('user.loginPost');

    //Forgot password
    Route::get('/forgot-password',  'forgotPassword')->name('user.forgotPassword');
    Route::post('/forgot-password',  'forgotPasswordPost')->name('user.forgotPasswordPost');
    Route::get('reset-password/{token}',  'resetpassword')->name('user.reset');
    Route::post('reset-password',  'postresetpassword')->name('user.reset.post');

    //Login with OTP
    Route::get('/login-with-otp',  'loginWithOtp')->name('user.loginWithOtp');
    Route::post('/generateOtp',  'generateOtp')->name('user.generateOtp');
    Route::get('/mobile-verification',  'mobileVerification')->name('user.mobileVerification');
    Route::post('/loginOtpVerify',  'loginOtpVerify')->name('user.loginOtpVerify');
    Route::post('/regenerateOtp',  'regenerateOtp')->name('user.regenerateOtp');
    Route::get('/login-mobile-verify',  'loginMobileVerify')->name('user.loginMobileVerify');
});


Route::get('/login-otp', [UserLoginController::class, 'loginWithOtp'])->name('user.loginWithOtp');
Route::post('/firebase-login', [UserLoginController::class, 'firebaseLogin'])->name('user.firebaseLogin');
Route::post('/otp-trusted-check', [UserLoginController::class, 'checkTrustedDevice'])->name('user.otpTrustedCheck');

//Register
Route::controller(RegisterController::class)->group(function () {
    Route::get('/register',  'register')->name('user.register');
    Route::post('/registerPost',  'registerPost')->name('user.registerPost');
    Route::post('/registerOtpVerify',  'registerOtpVerify')->name('user.registerOtpVerify');
    Route::get('/register-mobile-verify',  'registerMobileVerify')->name('user.mobileVerify');
    Route::get('/register-personal-details',  'registerPersonalDetails')->name('user.registerPersonalDetails');
    Route::post('/register-personal-details-post',  'registerPersonalDetailsPost')->name('user.registerPersonalDetailsPost');
    Route::get('/register-preference-details',  'registerPreferenceDetails')->name('user.registerPreferenceDetails');
    Route::post('/register-preference-details-post',  'registerPreferenceDetailsPost')->name('user.registerPreferenceDetailsPost');

    Route::get('/register-confirmation',  'registerConfirmation')->name('user.registerConfirmation');
    Route::get('/register-confirmation/{token}',  'emailVerification')->name('user.emailVerification');
    Route::get('/register-mobile-edit',  'registerMobileEdit')->name('user.editMobileNo');
    Route::post('/register/otp/generate',  'registerOTPRegenerate')->name('user.registerOTPRegenerate');
    Route::get('/document',  'documentupload')->name('user.registerDocumentUpload');
    Route::post('/documentpost',  'documentpost')->name('user.registerDocumentPost');

    Route::post('userprofilestate',  'userprofilestate')->name('userprofilestate');
    Route::post('userprofilecity',  'userprofilecity')->name('userprofilecity');
    Route::post('userprofilepartcaste',  'userprofilepartcaste')->name('userprofilepartcaste');
    Route::post('userprofilepartstate',  'userprofilepartstate')->name('userprofilepartstate');
    Route::post('userprofilepartcity',  'userprofilepartcity')->name('userprofilepartcity');
});

Route::post('/registerOtpVerify', [RegisterController_firebase::class, 'registerOtpVerify'])->name('user.registerOtpVerify');

//Contact Us
Route::controller(UserContactUsController::class)->group(function () {
    Route::get('/contactus',  'contactUs')->name('user.contactUs');
    Route::post('/contactUsPost',  'contactUsPost')->name('user.contactUsPost');
});

Route::controller(FooterController::class)->group(function () {
    Route::get('/cms/{slug}', 'cmspage')->name('user.footer');
});

Route::controller(PayuController::class)->group(function () {
    Route::any('pay-u-cancel','payUCancel')->name('pay.u.cancel');
    Route::any('pay-u-success','payUSuccess')->name('pay.u.success');
});


Route::group(['middleware' => ['user']], function () {

    //User dashboard
    Route::controller(UserDashboardController::class)->group(function () {
        Route::get('/home',  'userDashboard')->name('user.dashboard');
        Route::get('/emailvarify', 'varify')->name('user.varifyloginemail');
        Route::get('/register-email-confirmation/{token}',  'varifyemailaccount')->name('user.login.varification');
    });

    //Search after login
    Route::controller(SearchController::class)->group(function () {
        Route::get('/search-after', 'search')->name('user.profile.search');
    });


    Route::controller(UserProfileController::class)->group(function () {
        //Edit Profile
        Route::get('/edit-profile',  'profileEdit')->name('user.profileEdit');
        Route::post('/update-profile/{id}',  'profileupdate')->name('user.profileupdate');
        Route::get('/delete-profile/{id}',  'profileimage')->name('user.profileimagedelete');
        Route::post('profilestate',  'profilestate')->name('profilestate');
        Route::post('profilecaste',  'profilecaste')->name('profilecaste');
        Route::post('profilecity',  'profilecity')->name('profilecity');
        Route::post('profilepartcaste',  'profilepartcaste')->name('profilepartcaste');
        Route::post('profilepartstate',  'profilepartstate')->name('profilepartstate');
        Route::post('profilepartcity',  'profilepartcity')->name('profilepartcity');

        //member Profile
        Route::get('/member-profile/{id}',  'memberProfile')->name('user.memberProfile');

        //Profile Action In Member Profile
        Route::post('/shortlist-remove', 'removeshortlist')->name('user.shortlistremove');
        Route::post('/shortlist-store', 'addshortlist')->name('user.shortliststore');
        Route::post('/Interest-remove', 'removeinterest')->name('user.interestremove');
        Route::post('/Interest-store', 'addinterest')->name('user.intereststore');
        Route::post('/ignore-store', 'ignore')->name('user.ignore');
        Route::post('/unignore-store', 'unignore')->name('user.unignore');
        Route::get('/Block-store/{id}', 'block')->name('user.blockedstore');
        Route::get('/unBlock-user/{id}', 'Unblock')->name('user.Unblock');
        Route::post('/contactdetailsshow', 'contactdetailsshow')->name('user.contactdetailsshow');

        //Manage Photos
        Route::get('/manage-photos', 'managePhotos')->name('user.managePhotos');
        Route::post('/manage-photos-update/{id}',  'managePhotoUpdate')->name('user.managePhotoUpdate');

        //Manage Horoscope
        Route::get('/manage-horoscope', 'manageHoroscopePhoto')->name('user.manageHoroscopePhoto');

        //Manage Document
        Route::get('/manage-document', 'manageDocumentPhoto')->name('user.manageDocumentPhoto');

        //Express Interest
        Route::get('/express-interest/{tab}', 'expressInterest')->name('user.expressInterest');
        Route::post('/express-interest-accept','expressInterestAccept')->name('user.expressInterestAccept');
        Route::post('/express-interest-reject','expressInterestReject')->name('user.expressInterestReject');
        Route::post('/express-interest-delete','expressInterestDelete')->name('user.expressInterestDelete');

        //Delete Profile
        Route::get('/delete-profile', 'deleteProfile')->name('user.deleteProfile');
        Route::post('/delete-profile-post', 'deleteProfileStore')->name('user.deleteProfileStore');

        //Contact Privacy
        Route::get('/contact-privacy', 'contactPrivacy')->name('user.contactPrivacy');
        Route::post('/contact-privacy-post', 'contactPrivacyStore')->name('user.contactPrivacyStore');

        //Photo Privacy
        Route::get('/photo-privacy', 'photoPrivacy')->name('user.photoPrivacy');
        Route::post('/photo-privacy-post', 'photoPrivacyStore')->name('user.photoPrivacyStore');
    });

    //Messages
    Route::controller(MessageController::class)->group(function () {
        Route::get('/messages-inbox', 'message')->name('user.message');
        Route::get('/single-chat/{id}', 'chat_view')->name('user.chat_view');
        Route::post('/get_old_messages', 'getoldmessages')->name('get-old-messages');
        Route::get('/chatthreadpost/{id}', 'chatthreadpost')->name('user.chatthreadpost');
        Route::post('/delete-record', 'deleteRecord')->name('delete.record');
        Route::post('/chat-reply', 'chat_reply')->name('user.chat_reply');
        Route::get('/chat/refresh/{id}', 'chat_refresh')->name('user.chat_refresh');
        Route::post('/chat/old-messages', 'get_old_messages')->name('user.get-old-message');
    });

    //Matches
    Route::controller(MatchesController::class)->group(function () {
        Route::get('/one-way-match', 'oneWayMatch')->name('user.oneWayMatch');
        Route::get('/two-way-match', 'twoWayMatch')->name('user.twoWayMatch');
        Route::get('/broader-way-match', 'broaderWayMatch')->name('user.broaderWayMatch');
        Route::get('/prefered-way-match', 'preferedWayMatch')->name('user.preferedWayMatch');
        Route::get('/custom-way-match', 'customWayMatch')->name('user.customWayMatch');
        Route::Post('/customwayPost', 'customwayPost')->name('user.customwayPost');
    });

    // Membership plan after login
    Route::controller(UserMembershipController::class)->group(function () {
        Route::get('/user-membership-plans', 'userMembershipPlans')->name('user.userMembershipPlans');
        Route::get('/payment-options/{id}', 'paymentOptions')->name('user.paymentOptions');
        Route::get('/current-plan', 'currenMembershipPlan')->name('user.currenMembershipPlan');
        Route::get('/invoice/{id}', 'invoice')->name('user.invoice');
        Route::get('/profileCheckPayment/{approval}', 'profileCheckPayment')->name('membership.profileCheckPayment');
        Route::get('/payment-failed', 'paymentFailed')->name('user.paymentFailed');
        Route::get('/payment-success', 'paymentSuccess')->name('user.paymentSuccess');
    });

    Route::controller(RazorpayController::class)->group(function () {
        Route::get('/razorpay-response', 'razorpayResponse')->name('user.razorpayResponse');
        Route::post('razorpay-payment', 'razorpayResponseStore')->name('razorpay.payment.store');
	// New route for payment upload
        Route::post('/payment/upload', [RazorpayController::class, 'uploadPayment'])->name('payment.upload');
    });

    Route::controller(PayuController::class)->group(function () {
        Route::get('pay-u-money-view/{membership}', 'payUMoneyView')->name('pay.u');
    });

    //Profile Details
    Route::controller(ProfileDetailsController::class)->group(function () {
        Route::get('/shortlisted-profiles', 'shortListedProfiles')->name('user.shortListedProfiles');
        Route::get('/ignored-profiles', 'ignoredProfiles')->name('user.ignoredProfiles');
        Route::get('/my-profile-viewed-by', 'myProfileViewedBy')->name('user.myProfileViewedBy');
        Route::get('/contact-details-viewed-by', 'contactDetailsViewedBy')->name('user.contactDetailsViewedBy');
        Route::get('/i-visited-profiles', 'iVisitedProfiles')->name('user.iVisitedProfiles');
        Route::get('/recent-joined-profiles', 'recentelyJoinedProfile')->name('user.recentelyJoinedProfiles');
        Route::get('/featured-profiles', 'featuredProfiles')->name('user.featuredProfiles');
        Route::get('/blocked-profiles', 'blockedProfiles')->name('user.blockedProfiles');
    });

    Route::controller(UserLoginController::class)->group(function () {
        // Change Password
        Route::get('/change-password', 'changePassword')->name('user.changePassword');
        Route::post('/change-password-check', 'checkChangePassword')->name('user.checkChangePassword');

        //Logout
        Route::get('/logout', 'logout')->name('user.logout');
    });

    //Notification
    Route::controller(NotificationController::class)->group(function () {
        Route::get('/notification', 'notification')->name('user.notification');
        Route::get('/markread', 'markread')->name('user.markread');
    });

});

Route::group(['prefix'=>'secureadmin'],function (){

    Route::controller(AdminLoginController::class)->group(function () {
        // Admin login
        Route::get('/', 'index');
        Route::get('/index', 'index')->name('admin.login');
        Route::post('/login', 'login')->name('admin.login.post');

        //Forgot password
        Route::get('/forgotPassword', 'forgotAdminPassword')->name('admin.forgotAdminPassword');
        Route::post('/forgotPassword', 'forgotAdminPasswordStore')->name('admin.forgotAdminPasswordStore');
        Route::get('resetPassword/{token}','resetPassword')->name('admin.resetPassword');
        Route::post('resetPassword', 'resetPasswordStore')->name('admin.resetPasswordStore');
    });


    Route::group(['middleware' => ['admin']], function () {

        // Dashboard
        Route::controller(AdminDashboardController::class)->group(function () { 
            Route::get('/dashboard', 'index')->name('admin.dashboard');
        });

        Route::controller(MembersController::class)->group(function () {
            //Members        
            Route::get('/all-members', 'membersAll')->name('admin.membersAll');
            Route::get('/approved-to-paid-members', 'membersApprovedToPaid')->name('admin.membersApprovedToPaid');
            Route::get('/featured-members', 'membersFeatured')->name('admin.membersFeatured');
            Route::get('/renew-membership', 'renewMembership')->name('admin.renewMembership');
	    Route::get('/unpaid-members', 'unpaidMembers')->name('admin.unpaidMembers');

            //Profile Featured Add / Remove
            Route::get('/featured-profile/{id}', 'makeFeaturedProfile')->name('admin.makeFeaturedProfile');
            Route::get('/featured-profile-remove/{id}', 'removeFeaturedProfile')->name('admin.removeFeaturedProfile');

            //Profile Approve / Unapprove
            Route::get('/approve-profile/{id}', 'approveProfile')->name('admin.approveProfile');
            Route::get('/unapprove-profile/{id}', 'unApproveProfile')->name('admin.unApproveProfile');
            Route::post('/approved-to-paid-profile', 'approvedToPaidStore')->name('admin.approvedToPaidStore');
            Route::get('/delete-profile/{id}', 'memberDelete')->name('admin.memberDelete');

            Route::post('fetchCaste', 'fetchCaste')->name('fetchCaste');

            // Profile status change for multiple select
            Route::patch('/memberUpdateStatus', 'updateStatus')->name('admin.updateStatus');
        });

        // Register profile
        Route::controller(UserRegisterController::class)->group(function () {
            Route::get('/registerFirst', 'registerFirst')->name('admin.registerFirst');
            Route::post('edituserstate', 'edituserstate')->name('edituserstate');
            Route::post('usercaste', 'usercaste')->name('usercaste');
            Route::post('editusercity', 'editusercity')->name('editusercity');
            Route::post('userpartcaste', 'userpartcaste')->name('userpartcaste');
            Route::post('partstate', 'partstate')->name('partstate');
            Route::post('partcity', 'partcity')->name('partcity');
            Route::post('creteprofilecaste', 'fetchcaste')->name('creteprofilecaste');
            Route::post('/store-profile', 'storeProfile')->name('admin.store-profile');
            Route::get('/edit-profile/{id}', 'EditProfile')->name('admin.edit-profile');
            Route::post('/update-profile/{id}', 'UpdateProfile')->name('admin.update-profile');
            Route::get('/profile/{id}', 'ViewProfile')->name('admin.view-profile');
            Route::get('/imagestatus-change/{id}', 'imageStatus')->name('admin.image-status');
            Route::post('/userstatus-change/{id}', 'userStatus')->name('admin.user-status');
            Route::get('/image-delete/{id}', 'imageDelete')->name('admin.image-delete');
        });

        

        //Profile Delete Req
        Route::controller(ProfileDeactiveController::class)->group(function () {
            Route::get('profileDeactiveRequest', 'profileDeactiveRequest')->name('members.profileDeactiveRequest');
            Route::PATCH('/profiledeactiveallstatus', 'profiledeactiveallstatus')->name('member.profiledeactiveallstatus');
            Route::get('/profile-deactive-req/{id}', 'ProfileStatus')->name('member.profileStatus');
            Route::get('/profile-delete/{id}', 'ProfileStatusdelete')->name('member.profile.delete');
        });

        // Membership Plans --
        Route::controller(MembershipPlanController::class)->group(function () {
            Route::get('/membership-plans-all', 'membershipPlan')->name('admin.membershipPlan.all');
            Route::get('/membership-plan-add', 'membershipPlanCreate')->name('admin.membershipPlan.create');
            Route::post('/membership-plan-store', 'membershipPlanStore')->name('admin.membershipPlan.store');
            Route::get('/membership-plan-delete/{id}', 'membershipPlanDestroy')->name('admin.membershipPlan.destroy');
            Route::get('/membership-plan-edit/{id}/edit', 'membershipPlanEdit')->name('admin.membershipPlan.edit');
            Route::post('/membership-plan-update/{id}', 'membershipPlanUpdate')->name('admin.membershipPlan.update');
            Route::patch('/membership-plan-status', 'membershipPlanStatus')->name('admin.membershipPlan.status');
        });
        
        Route::controller(AddProfileReligionController::class)->group(function () {
            Route::get('/religion', 'religion')->name('admin.religionList');
            Route::get('/religionDelete/{id}', 'religionDelete')->name('admin.religionDelete');
            Route::patch('/religionStatus', 'religionStatus')->name('admin.religionStatus');
            Route::post('/religionStore', 'religionStore')->name('admin.religionStore');
        });

        Route::controller(AddProfileCasteController::class)->group(function () {
            Route::get('/caste', 'caste')->name('admin.casteList');
            Route::PATCH('/casteStatus', 'casteStatus')->name('admin.casteStatus');
            Route::post('/casteStore', 'casteStore')->name('admin.casteStore');
            Route::get('/casteDelete/{id}', 'casteDelete')->name('admin.casteDelete');
        });

        Route::controller(AddProfileSubCasteController::class)->group(function () {
            Route::get('/subcaste', 'subcaste')->name('admin.subcasteList');
            Route::PATCH('/subcasteStatus', 'subcasteStatus')->name('admin.subcasteStatus');
            Route::post('/subcasteStore', 'subcasteStore')->name('admin.subcasteStore');
            Route::get('/subcasteDelete/{id}', 'subcasteDelete')->name('admin.subcasteDelete');
        });

        Route::controller(AddProfileGotraController::class)->group(function () {
            Route::get('/gotra', 'gotra')->name('admin.gotraList');
            Route::PATCH('/gotraStatus', 'gotraStatus')->name('admin.gotraStatus');
            Route::post('/gotraPost', 'gotraStore')->name('admin.gotraStore');
            Route::get('/gotraDelete/{id}', 'gotraDelete')->name('admin.gotraDelete');
        });

        Route::controller(AddProfileCountryController::class)->group(function () {
            Route::get('/country', 'country')->name('admin.countryList');
            Route::PATCH('/countryStatus', 'countryStatus')->name('admin.countryStatus');
            Route::post('/countryStore', 'countryStore')->name('admin.countryStore');
            Route::get('/countryDelete/{id}', 'countryDelete')->name('admin.countryDelete');
        });

        Route::controller(AddProfileStateController::class)->group(function () {
            Route::get('/state', 'state')->name('admin.stateList');
            Route::PATCH('/stateStatus', 'stateStatus')->name('admin.stateStatus');
            Route::post('/stateStore', 'stateStore')->name('admin.stateStore');
            Route::get('/stateDelete/{id}', 'stateDelete')->name('admin.stateDelete');
        });

        Route::controller(AddProfileCityController::class)->group(function () {
            Route::get('/city',  'city')->name('admin.cityList');
            Route::post('/fetchState',  'fetchState')->name('fetchState');
            Route::GET('/stateEdit/{id}',  'editState')->name('editState');
            Route::GET('/editCountry/{id}',  'editCountry')->name('edit_country');
            Route::GET('/editCountryState/{id}',  'editCountryState')->name('editCountryState');
            Route::PATCH('/cityStatus',  'cityStatus')->name('admin.cityStatus');
            Route::post('/cityStore',  'cityStore')->name('admin.cityStore');
            Route::get('/cityDelete/{id}',  'cityDelete')->name('admin.cityDelete');
        });

        Route::controller(AddProfileOccupationController::class)->group(function () {
            Route::get('/occupation',  'occupation')->name('admin.occupationList');
            Route::PATCH('/occupationStatus',  'occupationStatus')->name('admin.occupationStatus');
            Route::post('/occupationStore',  'occupationStore')->name('admin.occupationStore');
            Route::get('/occupationDelete/{id}',  'occupationDelete')->name('admin.occupationDelete');
        });

        Route::controller(AddProfileEducationController::class)->group(function () {
            Route::get('/education',  'education')->name('admin.educationList');
            Route::PATCH('/educationStatus',  'educationStatus')->name('admin.educationStatus');
            Route::post('/educationStore',  'educationStore')->name('admin.educationStore');
            Route::get('/educationDelete/{id}',  'educationDelete')->name('admin.educationDelete');
        });

        Route::controller(AddProfileMotherTongueController::class)->group(function () {
            Route::get('/mtongue', [AddProfileMotherTongueController::class, 'mtongue'])->name('admin.mtongueList');
            Route::PATCH('/mtongueStatus', [AddProfileMotherTongueController::class, 'mtongueStatus'])->name('admin.mtongueStatus');
            Route::post('/mtongueStore', [AddProfileMotherTongueController::class, 'mtongueStore'])->name('admin.mtongueStore');
            Route::get('/mtongueDelete/{id}', [AddProfileMotherTongueController::class, 'mtongueDelete'])->name('admin.mtongueDelete');
        });

        Route::controller(AddProfileStarController::class)->group(function () {
            Route::get('/star', 'star')->name('admin.starList');
            Route::PATCH('/starStatus',  'starStatus')->name('admin.starStatus');
            Route::post('/starStore',  'starStore')->name('admin.starStore');
            Route::get('/starDelete/{id}',  'starDelete')->name('admin.starDelete');
        });

        Route::controller(AddProfileRasiController::class)->group(function () {
            Route::get('/rasi', 'rasi')->name('admin.rasiList');
            Route::PATCH('/rasiStatus', 'rasiStatus')->name('admin.rasiStatus');
            Route::post('/rasiStore', 'rasiStore')->name('admin.rasiStore');
            Route::get('/rasiDelete/{id}', 'rasiDelete')->name('admin.rasiDelete');
        });
        
        Route::controller(AddProfileAnualIncomeController::class)->group(function () {
            Route::get('/income',  'income')->name('admin.incomeList');
            Route::PATCH('/incomeStatus',  'incomeStatus')->name('admin.incomeStatus');
            Route::post('/incomeStore',  'incomeStore')->name('admin.incomeStore');
            Route::get('/incomeDelete/{id}',  'incomeDelete')->name('admin.incomeDelete');
        });

        Route::controller(AddProfileDoshController::class)->group(function () {
            Route::get('/dosh',  'dosh')->name('admin.doshList');
            Route::PATCH('/doshStatus',  'doshStatus')->name('admin.doshStatus');
            Route::post('/doshStore',  'doshStore')->name('admin.doshStore');
            Route::get('/doshDelete/{id}',  'doshDelete')->name('admin.doshDelete');
        });

        //Match Making
        Route::controller(MatchMakingController::class)->group(function () {
            Route::get('/matchmaking',  'matchmaking')->name('admin.matchMaking');
            Route::get('/sendMatchProfile/{id}',  'sendmailprofile')->name('admin.sendMailProfile');
            Route::patch('/matchis-email-send',  'matchismailsend')->name('matchmaking.mail.send');
            Route::post('/set-match-criteria',  'setMatchCriteria')->name('admin.setMatchCriteria');
        });
        
        //Payments
        Route::controller(PaymentController::class)->group(function () {
            Route::get('/payment',  'payment')->name('admin.paymentList');
            Route::get('/invoice/{id}',  'invoice')->name('admin.paymentInvoice');
        });

        Route::controller(ApprovalHoroscopeController::class)->group(function () {
            Route::get('/horoscopeApproval',  'horoscope')->name('admin.horoscopeList');
            Route::PATCH('/horoscopeStatus',  'horoscopeStatus')->name('admin.horoscopeStatus');
            Route::get('/horoscopeDelete/{id}',  'horoscopeDelete')->name('admin.horoscopeDelete');
        });

        Route::controller(ApprovalDocumentController::class)->group(function () {
            Route::get('/documentApproval',  'document')->name('admin.documentList');
            Route::PATCH('/documentStatus',  'documentStatus')->name('admin.documentStatus');
            Route::get('/documentDelete/{id}',  'documentDelete')->name('admin.documentDelete');
        });

        Route::controller(ApprovalProfilepicController::class)->group(function () {
            Route::get('/profilePicApproval',  'profilepic')->name('admin.profilePicList');
            Route::PATCH('/profilepicStatus',  'profilepicStatus')->name('admin.profilepicStatus');
            Route::get('/profilepicDelete/{id}', 'profilepicDelete')->name('admin.profilepicDelete');
        });

        Route::controller(ApprovalPhoto2Controller::class)->group(function () {
            Route::get('/photo2Approval',  'photo2')->name('admin.photo2List');
            Route::PATCH('/photo2Status',  'photo2Status')->name('admin.photo2Status');
            Route::get('/photo2Delete/{id}',  'photo2Delete')->name('admin.photo2Delete');
        });

        Route::controller(ApprovalPhoto3Controller::class)->group(function () {
            Route::get('/Photo3Approval',  'photo3')->name('admin.photo3List');
            Route::PATCH('/Photo3Status',  'photo3Status')->name('admin.photo3Status');
            Route::get('/Photo3Delete/{id}',  'photo3Delete')->name('admin.photo3Delete');
        });

        Route::controller(ApprovalPhoto4Controller::class)->group(function () {
            Route::get('/Photo4Approval',  'photo4')->name('admin.photo4List');
            Route::PATCH('/photo4Status',  'photo4Status')->name('admin.photo4Status');
            Route::get('/photo4Delete/{id}',  'photo4Delete')->name('admin.photo4Delete');
        });

        Route::controller(ApprovalPhoto5Controller::class)->group(function () {
            Route::get('/photo5Approval',  'photo5')->name('admin.photo5List');
            Route::PATCH('/photo5Status',  'photo5Status')->name('admin.photo5Status');
            Route::get('/photo5Delete/{id}', 'photo5Delete')->name('admin.photo5Delete');
        });

        Route::controller(ApprovalPhoto6Controller::class)->group(function () {
            Route::get('/photo6Approval',  'photo6')->name('admin.photo6List');
            Route::PATCH('/photo6Status',  'photo6Status')->name('admin.photo6Status');
            Route::get('/photo6Delete/{id}',  'photo6Delete')->name('admin.photo6Delete');
        });

        Route::controller(ApprovalPhoto7Controller::class)->group(function () {
            Route::get('/photo7Approval', 'photo7')->name('admin.photo7List');
            Route::PATCH('/photo7Status',  'photo7Status')->name('admin.photo7Status');
            Route::get('/photo7Delete/{id}',  'photo7Delete')->name('admin.photo7Delete');
        });

        Route::controller(ApprovalPhoto8Controller::class)->group(function () {
            Route::get('/photo8Approval', 'photo8')->name('admin.photo8List');
            Route::PATCH('/photo8Status',  'photo8Status')->name('admin.photo8Status');
            Route::get('/photo8Delete/{id}', 'photo8Delete')->name('admin.photo8Delete');
        });

        Route::controller(ApprovalAboutMeController::class)->group(function () {
            Route::get('/aboutMeApproval',  'aboutMe')->name('admin.aboutMeList');
            Route::PATCH('/aboutMeStatus',  'aboutMeStatus')->name('admin.aboutMeStatus');
            Route::get('/aboutMeDelete/{id}',  'aboutMeDelete')->name('admin.aboutMeDelete');
        });
        
        Route::controller(ApprovalPartnerExpectController::class)->group(function () {
            Route::get('/partnerExpectationApproval',  'partnerExpect')->name('admin.partnerExpectList');
            Route::PATCH('/partnerExpecatationStatus',  'partnerExpectStatus')->name('admin.partnerExpectStatus');
            Route::get('/partnerExpecatationDelete/{id}', 'partnerExpectDelete')->name('admin.partnerExpectDelete');
        });

        // Success Story
        Route::controller(SuccessStoryController::class)->group(function () {
            Route::get('/successStoryApproval',  'successStory')->name('admin.successStoryList');
            Route::get('/successStoryEdit/{id}',  'successStoryEdit')->name('admin.successStoryEdit');
            Route::get('/successStoryDelete/{id}',  'successStoryDelete')->name('admin.successStoryDelete');
            Route::PATCH('/successStoryStatus',  'successStoryStatus')->name('admin.successStoryStatus');
            Route::get('/addSuccessStory',  'successStoryCreate')->name('admin.successStoryCreate');
            Route::post('/successStoryStore',  'successStoryStore')->name('admin.successStoryStore');
            Route::post('/successStoryUpdate/{id}',  'successStoryUpdate')->name('admin.successStoryUpdate');
        });

        Route::controller(ExpressIntrestActivityController::class)->group(function () {
            Route::get('/expressInterestActivity',  'expressActivity')->name('admin.expressActivity');
            Route::PATCH('/expressActivityStatus',  'expressActivityStatus')->name('admin.expressActivityStatus');
            Route::get('/expressActivityDelete/{id}',  'expressActivityDelete')->name('admin.expressActivityDelete');
        });

        Route::controller(MessageUserActivityController::class)->group(function () {
            Route::get('/messageProfileActivity',  'messageActivity')->name('admin.messageActivity');
            Route::PATCH('/messageStatus',  'messageActivityStatus')->name('admin.messageActivityStatus');
            Route::get('/messageDelete/{id}',  'messageaAtivityDelete')->name('admin.messageActivityDelete');
        });

        Route::controller(ViewedUserActivityController::class)->group(function () {
            Route::get('/viewedProfileActivity',  'viewedActivity')->name('admin.viewedActivity');
            Route::PATCH('/viewedStatus',  'viewedActivityStatus')->name('admin.viewedActivityStatus');
            Route::get('/viewedDelete/{id}',  'viewedActivityDelete')->name('admin.viewedActivityDelete');
        });

        Route::controller(IgnoreUserActivityController::class)->group(function () {
            Route::get('/ignoredProfileActivity',  'ignoredActivity')->name('admin.ignoredActivity');
            Route::PATCH('/ignoredStatus',  'ignoredActivityStatus')->name('admin.ignoredActivityStatus');
            Route::get('/ignoredDelete/{id}',  'ignoredActivityDelete')->name('admin.ignoredActivityDelete');
        });

        Route::controller(ShortlistedUserActivityController::class)->group(function () {
            Route::get('/shortlistedProfileActivity',  'shortlistedActivity')->name('admin.shortlistedActivity');
            Route::PATCH('/shortlistedStatus',  'shortlistedActivityStatus')->name('admin.shortlistedActivityStatus');
            Route::get('/shortlistedDelete/{id}',  'shortlistedActivityDelete')->name('admin.shortlistedActivityDelete');
        });

        Route::controller(BlockedUserActivityController::class)->group(function () {
            Route::get('/blockedProfileActivity',  'blockedActivity')->name('admin.blockedActivity');
            Route::PATCH('/blockedStatus',  'blockedActivityStatus')->name('admin.blockedActivityStatus');
            Route::get('/blockedDelete/{id}',  'blockedActivityDelete')->name('admin.blockedActivityDelete');
        });

        // CMS pages
        Route::controller(CmsPageController::class)->group(function () {
            Route::get('/cmsPages',  'cms')->name('admin.cmsList');
            Route::patch('/cmsStatus',  'cmsStatus')->name('admin.cmsStatus');
            Route::get('/addCmsPage',  'cmsCreate')->name('admin.cmsCreate');
            Route::post('/cmsStore',  'cmsStore')->name('admin.cmsStore');
            Route::get('/editCmsPage/{id}',  'cmsEdit')->name('admin.cmsEdit');
            Route::post('/cmsUpdate/{id}',  'cmsUpdate')->name('admin.cmsUpdate');
            Route::get('/cmsDelete/{id}',  'cmsDelete')->name('admin.cmsDelete');
        });

        // Send email to members
        Route::controller(MailController::class)->group(function () {
            Route::get('/sendMail',  'sendMail')->name('admin.sendMail');
            Route::post('emailFetch',  'emailFetch')->name('admin.emailFetch');
        });

        Route::controller(LogoController::class)->group(function () {
            //Website Appearance
            Route::get('/uploadLogo', 'uploadLogo')->name('admin.uploadLogo');
            Route::post('/uploadLogoUpdate', 'uploadLogoUpdate')->name('admin.uploadLogoUpdate');
        });

        Route::controller(HomepageController::class)->group(function () {
            Route::get('/homepage-config',  'homepageConfig')->name('admin.homepageConfig');
            Route::post('/homepage-banner-store',  'uploadBannerUpdate')->name('admin.uploadBannerUpdate');
            Route::post('/homepage-config-store',  'homepageConfigUpdate')->name('admin.homepageConfigUpdate');
        });

        Route::controller(SocialMediaController::class)->group(function () {
            Route::get('/socialMediaLinks', 'socialMediaLinks')->name('admin.socialMediaLinks');
            Route::post('/socialMediaLinksUpdate', 'socialMediaLinksUpdate')->name('admin.socialMediaLinksUpdate');
        });

        Route::controller(AppearanceController::class)->group(function () {
            Route::get('/themeColorChange', 'themeColorChange')->name('admin.themeColorChange');
            Route::post('themeColorChangeUpdate', 'themeColorChangeUpdate')->name('admin.themeColorChangeUpdate');
        });

        Route::controller(WhatsappButtonController::class)->group(function () {
            Route::get('/whatsappButtonSettings',  'whatsappButtonSettings')->name('admin.whatsappButtonSettings');
            Route::post('/whatsappButtonSettingsUpdate',  'whatsappButtonSettingsUpdate')->name('admin.whatsappButtonSettingsUpdate');
        });

        Route::controller(WaterMarkController::class)->group(function () {
            Route::get('/uploadWatermark', 'uploadWatermark')->name('admin.uploadWatermark');
            Route::post('/uploadWatermarkUpdate',  'uploadWatermarkUpdate')->name('admin.uploadWatermarkUpdate');
        });

        Route::controller(BasicSiteController::class)->group(function () {
            Route::get('/basicSiteSettings',  'basicSiteSettings')->name('admin.basicSiteSettings');
            Route::post('/basicSiteSettingsUpdate', 'basicSiteSettingsUpdate')->name('admin.basicSiteSettingsUpdate');
        });

        Route::controller(SMSController::class)->group(function () {
            Route::get('/smsSettings',  'smsSettings')->name('admin.smsSettings');
            Route::post('/smsSettingsUpdate', 'smsSettingsUpdate')->name('admin.smsSettingsUpdate');
        });

        Route::controller(SeoSettingController::class)->group(function () {
            Route::get('/seoSettings', 'seoSettings')->name('admin.seoSettings');
            Route::post('/seoSettingsUpdate', 'seoSettingsUpdate')->name('admin.seoSettingsUpdate');
        });

        Route::controller(SMTPEmailController::class)->group(function () {
            Route::get('/smtpSettings',  'smtpSettings')->name('admin.smtpSettings');
            Route::post('/smtpSettingsUpdate',  'smtpSettingsUpdate')->name('admin.smtpSettingsUpdate');
            Route::post('/mailsend',  'mail')->name('mail.send');
            Route::post('/testmailsend',  'testMail')->name('mail.testSend');
        });

        Route::controller(PaymentMethodController::class)->group(function () {
            // Payment method
            Route::get('/paymentMethods',  'paymentMethods')->name('admin.paymentMethods');
            Route::post('/paymentMethodsUpdate', 'paymentMethodsUpdate')->name('admin.paymentMethodsUpdate');

            //Manual payment method
            Route::get('/manualPaymentMethod',  'manualPaymentMethod')->name('admin.manualPaymentMethod');
            Route::post('/manualPaymentMethodUpdate',  'manualPaymentMethodUpdate')->name('admin.manualPaymentMethodUpdate');
        });

        Route::controller(FieldSettingController::class)->group(function () {
            Route::get('/fieldSettings', 'fieldSettings')->name('admin.fieldSettings');
            Route::post('/fieldSettingsUpdate', 'fieldSettingsUpdate')->name('admin.fieldSettingsUpdate');
        });

        Route::controller(MenuSettingController::class)->group(function () {
            Route::get('/menuSettings', 'menuSettings')->name('admin.menuSettings');
            Route::post('/menuSettingsUpdate',  'menuSettingsUpdate')->name('admin.menuSettingsUpdate');
        });

        Route::controller(ContactUsController::class)->group(function () {
            Route::get('/contactusData',  'contactusData')->name('admin.contactusData');
            Route::patch('/contactDataStatus',  'contactDataStatus')->name('admin.contactDataStatus');
            Route::get('/contactDataDelete/{id}',  'contactDataDelete')->name('admin.contactDataDelete');
        });

        Route::controller(AdminLoginController::class)->group(function () {
            // Change password
            Route::get('/changeAdminPassword',  'changeAdminPassword')->name('admin.changeAdminPassword');
            Route::post('/changeAdminPassword', 'changeAdminPasswordStore')->name('admin.changeAdminPasswordStore');

            // Admin Profile Update
            Route::get('/admin-profile', 'adminProfileUpdate')->name('admin.adminProfileUpdate');
            Route::post('/admin-profile',  'adminProfileUpdatePost')->name('admin.adminProfileUpdatePost');

            // Logout
            Route::get('/logout', 'logout')->name('admin.logout');
        });

        //Advertisement
        Route::controller(AdvertisementController::class)->group(function () {
            Route::get('/all-advertisement',  'advertisement')->name('admin.advertisementList');
            Route::patch('/advertisement-status',  'advertisementStatus')->name('admin.advertisementStatus');
            Route::get('/add-advertisement',  'advertisementCreate')->name('admin.advertisementCreate');
            Route::post('/advertisement-post',  'advertisementPost')->name('admin.advertisementPost');
            Route::get('/advertisement-edit/{id}',  'advertisementEdit')->name('admin.advertisementEdit');
            Route::post('/advertisement-update/{id}',  'advertisementUpdate')->name('admin.advertisementUpdate');
            Route::get('/advertisement-delete/{id}',  'advertisementDelete')->name('admin.advertisementDelete');
        });

        // Currency
        Route::controller(CurrencyController::class)->group(function () {
            Route::get('/currency',  'currency')->name('admin.currencyList');
            Route::get('/currencyDelete/{id}',  'currencyDelete')->name('admin.currencyDelete');
            Route::patch('/currencyStatus',  'currencyStatus')->name('admin.currencyStatus');
            Route::post('/currencyStore',  'currencyStore')->name('admin.currencyStore');
        });

        // Database backup
        Route::controller(DatabaseBackupController::class)->group(function () {
            Route::get('/db-backup', 'databaseBackupShow')->name('admin.databaseBackupShow');
            Route::get('/db-backup-get', 'databaseBackup')->name('admin.databaseBackup');
        });

    });

});
    




