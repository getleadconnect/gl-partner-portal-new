<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Web\AdminController;
use App\Http\Controllers\Doctor\DoctorController;
use App\Http\Controllers\Web\PartnerController;
use App\Http\Controllers\Web\AgentController;
use App\Http\Controllers\InviteController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\Web\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Web\WhatsappController;

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


Route::get('dashboard', function () {
    return view('dash');
});

Route::get('/clear-configs', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:cache');
    Artisan::call('view:cache');
    Artisan::call('optimize:clear');
    return 'Application refreshed !!!!';
});

Route::get('/', function () {
    // return view('index');
    return view('landing_page');
});

Route::get('/admin', function () {
    // return view('index');
    return redirect('admin/login');
});

Route::get('design', function () {
    return view('design');
});

//Route::get('/update-lead-status', [App\Http\Controllers\Web\PartnerController::class, 'updateLeadStatusFromCrm'])->name('update-lead-status');


Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('user')->name('user.')->group(function(){
  
    Route::middleware(['guest:web','PreventBackHistory'])->group(function(){
          Route::view('/login','dashboard.user.login')->name('login');
          Route::view('/register','dashboard.user.register')->name('register');
          Route::post('/create',[UserController::class,'create'])->name('create');
          Route::post('/check',[UserController::class,'check'])->name('check');
    });

    Route::middleware(['auth:web','PreventBackHistory'])->group(function(){
          Route::view('/home','dashboard.user.home')->name('home');
          Route::post('/logout',[UserController::class,'logout'])->name('logout');
          Route::get('/add-new',[UserController::class,'add'])->name('add');
    });
});


Route::prefix('admin')->name('admin.')->group(function(){
       
    Route::middleware(['guest:admin','PreventBackHistory'])->group(function()
	{
          Route::get('login',[AdminController::class,'login'])->name('login');
          Route::post('/check',[AdminController::class,'check'])->name('check');
		  
		  Route::get('forgot-password',[AdminController::class,'forgotPassword'])->name('forgot-password');  
		  Route::post('send-forgot-password-otp',[AdminController::class,'sendForgotPasswordOtp'])->name('send-forgot-password-otp');  
		  Route::get('resend-forgot-password-otp/{email}',[AdminController::class,'resendForgotPasswordOtp'])->name('resend-forgot-password-otp');  
		  Route::get('verify-otp',[AdminController::class,'verifyOtp'])->name('verify-otp');  
		  Route::post('check-forgot-password-otp',[AdminController::class,'checkForgotPasswordOtp'])->name('check-forgot-password-otp');  
		  Route::get('change-user-password',[AdminController::class,'changeUserPassword'])->name('change-user-password');  
		  Route::post('update-user-password',[AdminController::class,'updateUserPassword'])->name('update-user-password');  
    });
	
    Route::middleware(['auth:admin','PreventBackHistory'])->group(function(){

        Route::controller(AdminController::class)->group(function()
        {
            Route::get('send','send')->name('send');
			
			Route::post('logout','logout')->name('logout');
			Route::get('terms','terms')->name('terms');
			Route::get('channel-partners','channelPartners')->name('channel-partners');
            Route::get('get-partners','getPartners')->name('get-partners');
			Route::get('edit-partner/{id}','editPartner')->name('edit-partner');
			Route::post('update-partner','updatePartner')->name('update-partner');
			
			Route::post('set-partner-commission-percentage','setPartnerCommissionPercentage')->name('set-partner-commission-percentage');
						
            Route::get('leads','leads')->name('leads');
            Route::get('list-leads','listLeads')->name('list-leads');
            Route::get('update-payment-status','updatePaymentStatus')->name('update-payment-status');
			Route::get('update-lead-status','updateLeadStatus')->name('update-lead-status');
			
 			Route::post('update-lead-commission','updateLeadCommission')->name('update-lead-commission');
			
			Route::post('create-lead','createLead')->name('create-lead');
            Route::get('edit-lead/{id}','editLeadDetails')->name('edit-lead');
            Route::post('update-lead','updateLead')->name('update-lead');
            Route::post('assign-agent','assignAgent')->name('assign-agent');

            Route::get('agents','agentList')->name('agents');
			Route::get('edit-agent/{id}','editAgent')->name('edit-agent');
			Route::post('update-agent','updateAgent')->name('update-agent');
			Route::post('delete-agent','deleteAgent')->name('delete-agent');
			
            Route::post('delete-lead','deleteLead')->name('delete-lead');
            Route::post('create-agent','createAgent')->name('create-agent');

            Route::get('product-services','showProductServices')->name('product-services');
            Route::get('list-product-services','listProductServices')->name('list-product-services');
            Route::get('get-product-service-details','getProductServiceDetails')->name('get-product-service-details');
            Route::post('update-product-service-details','updateProductServiceDetails')->name('update-product-service-details');
            Route::post('create-product-service-details','createProductServiceDetails')->name('create-product-service-details');
            
            Route::get('user-profile','userProfile')->name('user-profile');
            Route::get('change-password','changePassword')->name('change-password');
			
			Route::get('payouts','payouts')->name('payouts');
			Route::get('payout-history','payoutHistory')->name('payout-history');
			Route::post('save-payout','savePayout')->name('save-payout');
			//Route::get('get-lead-payment-details','getLeadPaymentDetails')->name('get-lead-payment-details');

			Route::get('view-payment-details','viewPaymentDetails')->name('view-payment-details');
			Route::get('view-all-payment-history','viewAllPaymentHistory')->name('view-all-payment-history');
			
			Route::post('update-payout-payment-status','updateLeadPaymentStatus')->name('update-payout-payment-status');
			
			
			//Route::get('notification-settings','notificationSettings')->name('notification-settings');
			Route::get('notifications','notifications')->name('notifications');
			Route::get('notification-list','notificationList')->name('notification-list');
			Route::get('delete-notification/{id}','deleteNotification')->name('delete-notification');
			
			Route::get('integrations','integrations')->name('integrations');
			Route::get('settings','settings')->name('settings');
			Route::get('notification-settings','notificationSettings')->name('notification-settings');
			
			Route::post('create-partner','createPartner')->name('create-partner');
			Route::post('change-notification-status','changeNotificationStatus')->name('change-notification-status');
			Route::post('update-admin-password','changePassword')->name('update-admin-password');
			Route::post('change-partner-status','changePartnerStatus')->name('change-partner-status');
			
			Route::post('delete-partner','deletePartner')->name('delete-partner');
			Route::get('partner-details/{id}','partnerDetails')->name('partner-details');
			Route::get('get-partner-leads/{id}','getPartnerLeads')->name('get-partner-leads');
			
			Route::get('/export-partner-list/{status}', 'exportPartnerList')->name('export-partner-list');
			Route::get('/export-lead-list/{status}/{partner}/{payment}', 'exportLeadList')->name('export-lead-list');

			Route::get('/developer-api', 'developerApi')->name('developer-api');
			
			Route::post('/save-lead-status', 'saveLeadStatus')->name('save-lead-status');
			Route::get('/delete-lead-status/{id}', 'deleteLeadStatus')->name('delete-lead-status');

			Route::get('/got-business-paid-leads', 'gotBusinessPaidLeads')->name('got-business-paid-leads');
			Route::get('/got-business-unpaid-leads', 'gotBusinessUnPaidLeads')->name('got-business-unpaid-leads');
			
			Route::get('news','news')->name('news'); 
			Route::get('add-news','addNews')->name('add-news'); 
			Route::get('edit-news/{id}','editNews')->name('edit-news'); 
			Route::post('update-news','updateNews')->name('update-news'); 
			Route::post('create-news','createNews')->name('create-news');
			Route::get('get-news-list','getNewsList')->name('get-news-list'); 
			Route::post('delete-news','deleteNews')->name('delete-news'); 
			
			Route::get('list-product-plans','listProductPlans')->name('list-product-plans');
			Route::post('save-plan','savePlan')->name('save-plan'); 
			Route::get('delete-plan/{id}','deletePlan')->name('delete-plan'); //product and services
			Route::post('update-plan','updatePlan')->name('update-plan'); 
			
			Route::get('set-notifications-as-read','setNotificationsAsRead')->name('set-notifications-as-read');
			Route::get('get-latest-notifications','getLatestNotifications')->name('get-latest-notifications');  //master page top bar bell icon
			
			Route::get('list-business-category','listBusinessCategory')->name('list-business-category');
			Route::post('save-business-category','saveBusinessCategory')->name('save-business-category'); 
			Route::get('delete-business-category/{id}','deleteBusinessCategory')->name('delete-business-category'); //product and services
			Route::post('update-business-category','updateBusinessCategory')->name('update-business-category'); 
			Route::post('update-email-whatsapp-no','updateEmailWhatsappNo')->name('update-email-whatsapp-no'); 
						
			Route::get('pay-partner-payment/{id}','payPartnerPayment')->name('pay-partner-payment'); 
			Route::get('got-business-partner-unpaid-leads/{id}', 'gotBusinessPartnerUnpaidLeads')->name('got-business-partner-unpaid-leads');
			Route::get('view-partner-payment-history/{id}','viewPartnerPaymentHistory')->name('view-partner-payment-history');
			
		});
		
		Route::controller(WhatsappController::class)->group(function()
        {
            Route::get('whatsapp','whatsapp')->name('whatsapp');
        });
		

        Route::controller(AdminDashboard::class)->group(function()
        {
            Route::get('dashboard','dashboard')->name('dashboard');
            Route::get('home','dashboard')->name('home');
			Route::get('get-latest-leads','getLatestLeads')->name('get-latest-leads');
        });

		// Route::view('/home','admin.dashboard')->name('home');
    });

});


	Route::prefix('partner')->name('partner.')->group(function(){

    Route::middleware(['guest:partner','PreventBackHistory'])->group(function(){
        //Route::view('/login','partner.login')->name('login');
         Route::get('login',[PartnerController::class,'login'])->name('login');
		//Route::view('/register','dashboard.partner.register')->name('register');
		 Route::get('/signup',[PartnerController::class,'signup'])->name('signup');
         Route::post('/create',[PartnerController::class,'create'])->name('create');
         Route::post('/check',[PartnerController::class,'check'])->name('check');
		 
		 Route::get('forgot-password',[PartnerController::class,'forgotPassword'])->name('forgot-password');  
		 Route::post('send-forgot-password-otp',[PartnerController::class,'sendForgotPasswordOtp'])->name('send-forgot-password-otp');  
		 Route::get('resend-forgot-password-otp/{email}',[PartnerController::class,'resendForgotPasswordOtp'])->name('resend-forgot-password-otp');  
		 Route::get('otp-verify',[PartnerController::class,'verifyPasswordOtp'])->name('otp-verify');  
		 Route::post('check-forgot-password-otp',[PartnerController::class,'checkForgotPasswordOtp'])->name('check-forgot-password-otp');  
		 Route::get('change-user-password',[PartnerController::class,'changeUserPassword'])->name('change-user-password');  
		 Route::post('update-user-password',[PartnerController::class,'updateUserPassword'])->name('update-user-password');
    });


    Route::middleware(['auth:partner','PreventBackHistory'])->group(function(){

        Route::controller(PartnerController::class)->group(function()
        {
            Route::post('logout','logout')->name('logout');
			Route::get('terms','terms')->name('terms');
            Route::get('leads','index')->name('leads');
            Route::get('home','home')->name('home');
			Route::get('dashboard','home')->name('dashboard');
            Route::get('get-leads','getLeads')->name('get-leads');
            Route::post('create-lead','createLead')->name('create-lead');
			Route::get('edit-lead/{id}','editLead')->name('edit-lead');
            Route::post('update-lead','updateLead')->name('update-lead');
            Route::get('user-profile','userProfile')->name('user-profile');
            Route::post('update-profile','updateProfile')->name('update-profile');
            Route::post('update-account-details','updateAccountDetails')->name('update-account-details');
            Route::post('send-otp','sendOtp')->name('send-otp');
			//Route::get('send-otp','sendOtp')->name('send-otp');
            Route::post('verify-otp','verifyOtp')->name('verify-otp');
            Route::post('change-password','changePassword')->name('change-password');
			
			Route::get('settings','settings')->name('settings');
			
			Route::get('get-business-leads','getBusinessLeads')->name('get-business-leads'); //dashboard
			Route::post('delete-lead','deleteLead')->name('delete-lead'); //dashboard
			
			Route::get('news','news')->name('news'); 
			Route::get('get-news-data/{id}','getNewsData')->name('get-news-data'); 

			Route::get('set-notifications-as-read','setNotificationsAsRead')->name('set-notifications-as-read');
			Route::get('get-latest-notifications','getLatestNotifications')->name('get-latest-notifications');  //master page top bar bell icon
						
			Route::get('notifications','notifications')->name('notifications');
			Route::get('notification-list','notificationList')->name('notification-list');
			Route::get('delete-notification/{id}','deleteNotification')->name('delete-notification');
			
			Route::get('payout-history','payoutHistory')->name('payout-history');
			Route::get('view-payment-details','viewPaymentDetails')->name('view-payment-details');
			Route::get('view-payment-history','viewPaymentHistory')->name('view-payment-history');
			
        });

    });

});

Route::controller(PartnerController::class)->group(function()
{
    Route::get('accept-invitation/{token}','acceptInvitation')->name('accept-invitation');
    Route::get('country-states','getStates')->name('country-states');
    Route::get('get-plans','getPlans')->name('get-plans');
});


Route::prefix('agent')->name('agent.')->group(function(){

    Route::middleware(['guest:agent','PreventBackHistory'])->group(function(){
         Route::view('/login','agent.auth-login')->name('login');
         Route::view('/register','dashboard.agent.register')->name('register');
         Route::post('/create',[AgentController::class,'create'])->name('create');
         Route::post('/check',[AgentController::class,'check'])->name('check');
    });

    Route::middleware(['auth:agent','PreventBackHistory'])->group(function(){
        Route::controller(AgentController::class)->group(function()
        {
			Route::get('/home','dashboard')->name('home');
			Route::get('/dashboard','dashboard')->name('dashboard');
            Route::post('logout','logout')->name('logout');
            Route::get('partners','index')->name('partners');
            Route::get('list-partners','listPartners')->name('list-partners');
            Route::post('invite-partner','invitePartner')->name('invite-partner');
            Route::post('create-partner','createPartner')->name('create-partner');
            Route::get('create-lead','createLead')->name('create-lead');
            Route::post('update-lead','updateLead')->name('update-lead');
            Route::post('save-lead','saveLead')->name('save-lead');
            Route::get('list-leads','listLeads')->name('list-leads');
            Route::post('get-invite-link','getInviteLink')->name('get-invite-link');
            Route::get('edit-agent-lead/{id}','editLeadDetails')->name('edit-agent-lead');
			
        });

        //  Route::post('logout',[AgentController::class,'logout'])->name('logout');
    });

});

Route::controller(InviteController::class)->group(function()
{
    Route::post('invite','process')->name('process');
    Route::get('invite','invite')->name('invite');
    Route::get('accept/{token}','accept')->name('accept');
});

Route::controller(TestController::class)->group(function()
{
    Route::get('import-partner','importLeads')->name('import-partner');
});
