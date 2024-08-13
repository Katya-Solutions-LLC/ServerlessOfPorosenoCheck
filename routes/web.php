<?php

use App\Http\Controllers\Backend\BackendController;
use App\Http\Controllers\Backend\BackupController;
use App\Http\Controllers\Backend\BranchController;
use App\Http\Controllers\Backend\CustomerController;
use App\Http\Controllers\Backend\NotificationsController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RolePermission;
use App\Http\Controllers\SearchController;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Auth Routes
require __DIR__.'/auth.php';
Route::get('/', function () {
    if (auth()->user()->hasRole('boarder')) {
        return redirect(RouteServiceProvider::BOARDER_LOGIN_REDIRECT);
    }else if(auth()->user()->hasRole('vet')){

        return redirect(RouteServiceProvider::VET_LOGIN_REDIRECT);
  
    }else if(auth()->user()->hasRole('groomer')){

        return redirect(RouteServiceProvider::GROOMER_LOGIN_REDIRECT);
  
    }else if(auth()->user()->hasRole('trainer')){

        return redirect(RouteServiceProvider::TRAINER_LOGIN_REDIRECT);
  
    }else if(auth()->user()->hasRole('walker')){

        return redirect(RouteServiceProvider::WALKER_LOGIN_REDIRECT);
  
    }else if(auth()->user()->hasRole('day_taker')){

        return redirect(RouteServiceProvider::DAYTAKER_LOGIN_REDIRECT);
  
    }else if(auth()->user()->hasRole('pet_sitter')){
        return redirect(RouteServiceProvider::PETSITTER_LOGIN_REDIRECT);
  
    }else if(auth()->user()->hasRole('pet_store')){
        return redirect(RouteServiceProvider::PETSTORE_LOGIN_REDIRECT);
  
    }
    
    else {
        return redirect(RouteServiceProvider::HOME);
    }
})->middleware('auth');

Route::group(['middleware' => ['auth']], function () {
    Route::get('notification-list', [NotificationsController::class, 'notificationList'])->name('notification.list');
    Route::get('notification-counts', [NotificationsController::class, 'notificationCounts'])->name('notification.counts');
    Route::delete('notification-remove/{id}', [NotificationsController::class, 'notificationRemove'])->name('notification.remove');
});

Route::group(['prefix' => 'app'], function () {

    // Language Switch
    Route::get('language/{language}', [LanguageController::class, 'switch'])->name('language.switch');
    Route::post('set-user-setting', [BackendController::class, 'setUserSetting'])->name('backend.setUserSetting');

    Route::group(['as' => 'backend.', 'middleware' => ['auth']], function () {
        Route::post('update-player-id', [UserController::class, 'update_player_id'])->name('update-player-id');
        Route::get('get_search_data', [SearchController::class, 'get_search_data'])->name('get_search_data');

        Route::get('get_order_status_data', [SearchController::class, 'get_order_status_data'])->name('get_order_status_data');

        // Sync Role & Permission
        Route::group(['middleware' => 'permission:view_permission'], function () {
        Route::get('/permission-role', [RolePermission::class, 'index'])->name('permission-role.list')->middleware('password.confirm');
        Route::post('/permission-role/store/{role_id}', [RolePermission::class, 'store'])->name('permission-role.store');
        Route::get('/permission-role/reset/{role_id}', [RolePermission::class, 'reset_permission'])->name('permission-role.reset');
        // Role & Permissions Crud
        Route::resource('permission', PermissionController::class);
        Route::resource('role', RoleController::class);

    });


    Route::group(['middleware' => 'permission:view_modules'], function () {
        Route::group(['prefix' => 'module', 'as' => 'module.'], function () {

            Route::get('index_data', [ModuleController::class, 'index_data'])->name('index_data');
            Route::post('update-status/{id}', [ModuleController::class, 'update_status'])->name('update_status');
        });

       Route::resource('module', ModuleController::class);

    });

   


        /*
          *
          *  Settings Routes
          *
          * ---------------------------------------------------------------------
          */
        Route::group(['middleware' => ['permission:edit_settings']], function () {
            Route::get('settings/{vue_capture?}', [SettingController::class, 'index'])->name('settings')->where('vue_capture', '^(?!storage).*$');
            Route::get('settings-data', [SettingController::class, 'index_data']);
            Route::post('settings', [SettingController::class, 'store'])->name('                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            .store');
            Route::post('setting-update', [SettingController::class, 'update'])->name('setting.update');
            Route::get('clear-cache', [SettingController::class, 'clear_cache'])->name('clear-cache');
            Route::get('reload-database', [SettingController::class, 'reload_database'])->name('reload-database');
            Route::post('verify-email', [SettingController::class, 'verify_email'])->name('verify-email');
            Route::get('get-service-price', [SettingController::class, 'get_service_price']);

            
        });

        /*                                                                                                                  
        *
        *  Notification Routes
        *
        * ---------------------------------------------------------------------
        */
        Route::group(['prefix' => 'notifications', 'as' => 'notifications.'], function () {
            Route::get('/', [NotificationsController::class, 'index'])->name('index');
            Route::get('/markAllAsRead', [NotificationsController::class, 'markAllAsRead'])->name('markAllAsRead');
            Route::delete('/deleteAll', [NotificationsController::class, 'deleteAll'])->name('deleteAll');
            Route::get('/{id}', [NotificationsController::class, 'show'])->name('show');

        });

        /*
        *
        *  Backup Routes
        *
        * ---------------------------------------------------------------------
        */
        Route::group(['prefix' => 'backups', 'as' => 'backups.'], function () {
            Route::get('/', [BackupController::class, 'index'])->name('index');
            Route::get('/create', [BackupController::class, 'create'])->name('create');
            Route::get('/download/{file_name}', [BackupController::class, 'download'])->name('download');
            Route::get('/delete/{file_name}', [BackupController::class, 'delete'])->name('delete');
        });

        Route::group(['middleware' => 'permission:view_daily_bookings'], function () {

        Route::get('daily-booking-report', [ReportsController::class, 'daily_booking_report'])->name('reports.daily-booking-report');
        Route::get('daily-booking-report-index-data', [ReportsController::class, 'daily_booking_report_index_data'])->name('reports.daily-booking-report.index_data');
    });
        Route::group(['middleware' => 'permission:view_overall_bookings'], function () {
        Route::get('overall-booking-report', [ReportsController::class, 'overall_booking_report'])->name('reports.overall-booking-report');
        Route::get('overall-booking-report-index-data', [ReportsController::class, 'overall_booking_report_index_data'])->name('reports.overall-booking-report.index_data');
    });
        Route::group(['middleware' => 'permission:view_reports'], function () {
        Route::get('payout-report', [ReportsController::class, 'payout_report'])->name('reports.payout-report');
        Route::get('payout-report-index-data', [ReportsController::class, 'payout_report_index_data'])->name('reports.payout-report.index_data');
    });
        Route::group(['middleware' => 'permission:view_reports'], function () {
        Route::get('staff-report', [ReportsController::class, 'staff_report'])->name('reports.staff-report');
        Route::get('staff-report-index-data', [ReportsController::class, 'staff_report_index_data'])->name('reports.staff-report.index_data');
    });
        Route::group(['middleware' => 'permission:view_order_reports'], function () {
        Route::get('order-report', [ReportsController::class, 'order_report'])->name('reports.order-report');
        Route::get('order-report-index-data', [ReportsController::class, 'order_report_index_data'])->name('reports.order-report.index_data');
    });

});

  

    /*
    *
    * Backend Routes
    * These routes need view-backend permission
    * --------------------------------------------------------------------
    */
    Route::group(['as' => 'backend.', 'middleware' => ['auth']], function () {

        /**
         * Backend Dashboard
         * Namespaces indicate folder structure.
         */
        Route::get('/', [BackendController::class, 'index'])->name('home');

        Route::get('/employee-dashboard', [BackendController::class, 'employeeDashboard'])->name('employee-dashboard');

        Route::get('/get_revnue_chart_data/{type}', [BackendController::class, 'getRevenuechartData']);
        Route::get('/get_employee_revnue_chart_data/{type}', [BackendController::class, 'getEmployeeRevenuechartData']);
        Route::get('/get_booking_chart_data/{type}', [BackendController::class, 'getBookingchartData']);
        Route::get('/get_booking_status_chart_data/{type}', [BackendController::class, 'getStatusBookingchartData']);
        Route::get('/get_profit_chart_data/{type}', [BackendController::class, 'getProfitchartData']);
        

        Route::post('set-current-branch/{branch_id}', [BackendController::class, 'setCurrentBranch'])->name('set-current-branch');
        Route::post('reset-branch', [BackendController::class, 'resetBranch'])->name('reset-branch');

        Route::group(['prefix' => ''], function () {
            Route::get('dashboard', [BackendController::class, 'index'])->name('dashboard');

            /**
             * Branch Routes
             */

             Route::group(['middleware' => ['permission:view_branch']], function () {
            Route::group(['prefix' => 'branch', 'as' => 'branch.'], function () {
                Route::get('index_list', [BranchController::class, 'index_list'])->name('index_list');
                Route::get('assign/{id}', [BranchController::class, 'assign_list'])->name('assign_list');
                Route::post('assign/{id}', [BranchController::class, 'assign_update'])->name('assign_update');
                Route::get('index_data', [BranchController::class, 'index_data'])->name('index_data');
                Route::get('trashed', [BranchController::class, 'trashed'])->name('trashed');
                Route::patch('trashed/{id}', [BranchController::class, 'restore'])->name('restore');
                // Branch Gallery Images
                Route::get('gallery-images/{id}', [BranchController::class, 'getGalleryImages']);
                Route::post('gallery-images/{id}', [BranchController::class, 'uploadGalleryImages']);
                Route::post('bulk-action', [BranchController::class, 'bulk_action'])->name('bulk_action');
                Route::post('update-status/{id}', [BranchController::class, 'update_status'])->name('update_status');
                Route::post('update-select-value/{id}/{action_type}', [BranchController::class, 'update_select'])->name('update_select');
            });
            Route::resource('branch', BranchController::class);

        });

            /*
            *
            *  Users Routes
            *
            * ---------------------------------------------------------------------
            */
            Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
                
                Route::get('/user-list', [UserController::class, 'user_list'])->name('user_list');
                Route::get('/profile/{id}', [UserController::class, 'profile'])->name('profile');
                Route::get('/profile/{id}/edit', [UserController::class, 'profileEdit'])->name('profileEdit');
                Route::patch('/profile/{id}/edit', [UserController::class, 'profileUpdate'])->name('profileUpdate');
                Route::get('/emailConfirmationResend/{id}', [UserController::class, 'emailConfirmationResend'])->name('emailConfirmationResend');
                Route::delete('/userProviderDestroy', [UserController::class, 'userProviderDestroy'])->name('userProviderDestroy');
                Route::get('/profile/changeProfilePassword/{id}', [UserController::class, 'changeProfilePassword'])->name('changeProfilePassword');
                Route::patch('/profile/changeProfilePassword/{id}', [UserController::class, 'changeProfilePasswordUpdate'])->name('changeProfilePasswordUpdate');
                Route::get('/changePassword/{id}', [UserController::class, 'changePassword'])->name('changePassword');
                Route::patch('/changePassword/{id}', [UserController::class, 'changePasswordUpdate'])->name('changePasswordUpdate');
                Route::get('/trashed', [UserController::class, 'trashed'])->name('trashed');
                Route::patch('/trashed/{id}', [UserController::class, 'restore'])->name('restore');
                Route::get('customer', [CustomerController::class, 'index'])->name('customer');
                Route::get('/index_data/{role}', [UserController::class, 'index_data'])->name('index_data');
                Route::get('/index_list', [UserController::class, 'index_list'])->name('index_list');
                Route::get('/owner_list', [UserController::class, 'owner_list'])->name('owner_list');
                Route::get('/organizer_list', [UserController::class, 'organizer_list'])->name('organizer_list');
                Route::post('/create-customer', [UserController::class, 'create_customer'])->name('create_customer');
                Route::patch('/{id}/block', [UserController::class, 'block', 'middleware' => ['permission:block_users']])->name('block');
                Route::patch('/{id}/unblock', [UserController::class, 'unblock', 'middleware' => ['permission:block_users']])->name('unblock');
                Route::post('information', [UserController::class, 'updateData'])->name('information');

                Route::post('change-password', [UserController::class, 'change_password'])->name('change_password');
            });
            Route::resource('users', UserController::class);
        });

        Route::get('my-profile/{vue_capture?}', [UserController::class, 'myProfile'])->name('my-profile')->where('vue_capture', '^(?!storage).*$');
        Route::get('my-info', [UserController::class, 'authData'])->name('authData');
        Route::get('app-configuration', [App\Http\Controllers\Backend\API\SettingController::class, 'appConfiguraton']);
    });
});
