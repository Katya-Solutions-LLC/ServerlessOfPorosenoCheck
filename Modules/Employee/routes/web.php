<?php

use Illuminate\Support\Facades\Route;
use Modules\Employee\Http\Controllers\Backend\EmployeesController;
use Modules\Employee\Http\Controllers\Backend\EmployeeSlotMappingController;

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
/*
*
* Backend Routes
*
* --------------------------------------------------------------------
*/
Route::group(['prefix' => 'app', 'as' => 'backend.', 'middleware' => ['web', 'auth','permission:view_employees|view_veterinary|view_grooming|view_boarding|view_traning|view_walking|view_daycare|view_order_review']], function () {
    /*
    * These routes need view-backend permission
    * (good if you want to allow more than one group in the backend,
    * then limit the backend features by different roles or permissions)
    *
    * Note: Administrator has all permissions so you do not have to specify the administrator role everywhere.
    */

    /*
     *
     *  Backend Employees Routes
     *
     * ---------------------------------------------------------------------
     */

    Route::group(['prefix' => 'employees', 'as' => 'employees.'], function () {
        Route::get('index_list', [EmployeesController::class, 'index_list'])->name('index_list');
        Route::get('commision_list', [EmployeesController::class, 'commision_list'])->name('commision_list');

        Route::get('employee_list', [EmployeesController::class, 'employee_list'])->name('employee_list');
        Route::post('change-password', [EmployeesController::class, 'change_password'])->name('change_password');
        Route::post('update-status/{id}', [EmployeesController::class, 'update_status'])->name('update_status');
        Route::post('block-employee/{id}', [EmployeesController::class, 'block_employee'])->name('block-employee');
        Route::get('verify-employee/{id}', [EmployeesController::class, 'verify_employee'])->name('verify-employee');
        Route::get('review_data', [EmployeesController::class, 'review_data'])->name('review_data');
        Route::delete('destroy_review/{id}', [EmployeesController::class, 'destroy_review'])->name('destroy_review');
        Route::get('index_data', [EmployeesController::class, 'index_data'])->name('index_data');
        Route::get('trashed', [EmployeesController::class, 'trashed'])->name('trashed');
        Route::get('trashed/{id}', [EmployeesController::class, 'restore'])->name('restore');
        Route::post('bulk-action', [EmployeesController::class, 'bulk_action'])->name('bulk_action');
        Route::post('bulk-action-review', [EmployeesController::class, 'bulk_action_review'])->name('bulk_action_review');
        Route::get('/employee_slot/{id}', [EmployeeSlotMappingController::class, 'employee_slot_list'])->name('employee_slot_list');
        Route::post('/employee_slot', [EmployeeSlotMappingController::class, 'store_employee_slot'])->name('store_employee_slot');
        Route::get('/type/{type}', [EmployeesController::class, 'employees_type_data'])->name('employee_type');
        Route::post('/send-push-notification', [EmployeesController::class, 'send_push_notification'])->name('send-push-notification');
        Route::get('order_review_data', [EmployeesController::class, 'order_review_data'])->name('order_review_data');
        Route::delete('destroy_order_review/{id}', [EmployeesController::class, 'destroy_order_review'])->name('destroy_order_review');
        Route::post('bulk-action-order-review', [EmployeesController::class, 'bulk_action_order_review'])->name('bulk_action_order_review');

    });
    Route::get('employees-review', [EmployeesController::class, 'review'])->name('employees.review');
    Route::get('employees-order-review', [EmployeesController::class, 'orderReview'])->name('employees.order-review');
    Route::get('all-employees', [EmployeesController::class, 'index'])->name('employees.all');
    Route::resource('employees', EmployeesController::class);
});
