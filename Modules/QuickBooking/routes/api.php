<?php

use Illuminate\Support\Facades\Route;
use Modules\QuickBooking\Http\Controllers\Backend\QuickBookingsController;
use Modules\Category\Http\Controllers\Backend\CategoriesController;
use Modules\Service\Http\Controllers\Backend\ServicesController;
use App\Http\Controllers\Backend\UserController;
use Modules\Booking\Http\Controllers\Backend\BookingsController;

use Modules\Tax\Http\Controllers\Backend\TaxesController;

Route::group(['prefix' => 'quick-booking'], function () {
    Route::get('branch-list', [QuickBookingsController::class, 'branch_list']);
    Route::get('slot-time-list', [QuickBookingsController::class, 'slot_time_list']);
    Route::get('services-list', [QuickBookingsController::class, 'services_list']);
    Route::get('employee-list', [QuickBookingsController::class, 'employee_list']);
    Route::post('verify_customer', [QuickBookingsController::class, 'verify_customer']);
    Route::post('store_customer', [QuickBookingsController::class, 'store_customer']);
    Route::post('store', [QuickBookingsController::class, 'create_booking'])->name('api.quick_bookings.store');
    Route::get('pettype_list', [QuickBookingsController::class, 'pettype_list']);
    Route::get('breed_list', [QuickBookingsController::class, 'breed_list']);
    Route::post('store_pet', [QuickBookingsController::class, 'store_pet']);
    Route::get('index_list', [CategoriesController::class, 'index_list'])->name('index_list');
    Route::get('service_list', [ServicesController::class, 'service_list'])->name('service_list');
    Route::get('service_index_list', [ServicesController::class, 'index_list'])->name('service_index_list');

    Route::get('user-list', [UserController::class, 'user_list'])->name('user-list');
    Route::get('service-price', [ServicesController::class, 'service_price'])->name('service-price');
    Route::get('tax-list', [TaxesController::class, 'tax_list'])->name('tax-list');

    Route::get('breed_list', [QuickBookingsController::class, 'breed_list']);

    Route::post('store_booking', [BookingsController::class, 'store']);
    Route::get('get_booking/{id}', [BookingsController::class, 'edit']);

});
