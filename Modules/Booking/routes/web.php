<?php

use Illuminate\Support\Facades\Route;
use Modules\Booking\Http\Controllers\Backend\BookingsController;
use Modules\Booking\Http\Controllers\Backend\VeterinaryController;
use Modules\Booking\Http\Controllers\Backend\GroomingController;
use Modules\Booking\Http\Controllers\Backend\WalkingController;
use Modules\Booking\Http\Controllers\Backend\TrainingController;
use Modules\Booking\Http\Controllers\Backend\DayCareController;
use Modules\Booking\Http\Controllers\Backend\AllBookingsController;
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
Route::group(['prefix' => 'app', 'as' => 'backend.', 'middleware' => ['auth']], function () {
    /*
    * These routes need view-backend permission
    * (good if you want to allow more than one group in the backend,
    * then limit the backend features by different roles or permissions)
    *
    * Note: Administrator has all permissions so you do not have to specify the administrator role everywhere.
    */

    /*
     *
     *  Backend Bookings Routes
     *
     * ---------------------------------------------------------------------
     */
    Route::group(['prefix' => 'bookings', 'as' => 'bookings.'], function () {
        Route::get('/index_data', [BookingsController::class, 'index_data'])->name('index_data');
        Route::get('/list_view', [BookingsController::class, 'list_view'])->name('list_view');
        Route::get('/index_list', [BookingsController::class, 'index_list'])->name('index_list');
        Route::get('/services-index_list', [BookingsController::class, 'services_index_list'])->name('services_index_list');
        Route::get('/trashed', [BookingsController::class, 'trashed'])->name('trashed');
        Route::patch('/trashed/{id}', [BookingsController::class, 'restore'])->name('restore');
        Route::post('/update-status/{id}', [BookingsController::class, 'updateStatus'])->name('updateStatus');
        Route::post('/update-payment-status/{id}', [BookingsController::class, 'updatePaymentStatus'])->name('updatePaymentStatus');
        Route::post('bulk-action', [BookingsController::class, 'bulk_action'])->name('bulk_action');
        Route::get('slots', [BookingsController::class, 'booking_slots'])->name('slots');
        Route::post('payment', [BookingsController::class, 'booking_payment'])->name('payment');
        Route::get('payment-create', [BookingsController::class, 'payment_create'])->name('payment_create');
        Route::put('booking-payment/{booking_id}', [BookingsController::class, 'booking_payment'])->name('booking_payment');
        Route::put('booking-payment-update/{booking_transaction_id}', [BookingsController::class, 'booking_payment_update'])->name('booking_payment_update');
        Route::put('{booking_id}/checkout', [BookingsController::class, 'checkout'])->name('checkout');
        Route::post('stripe-payment', [BookingsController::class, 'stripe_payment'])->name('stripe_payment');
        Route::get('payment_success/{booking_transaction_id}', [BookingsController::class, 'payment_success'])->name('payment_success');
        Route::post('/update-employee/{id}', [BookingsController::class, 'updateEmployee'])->name('updateEmployee');
        Route::get('/booking-show/{id}', [BookingsController::class, 'bookingShow'])->name('bookingShow');

    });
    
    Route::get('bookings-table-view', [BookingsController::class, 'datatable_view'])
    ->name('bookings.datatable_view')
    ->middleware('permission:view_boarding_booking');

    Route::group(['middleware' => ['permission:view_veterinary_booking']], function () {

    Route::get('veterinary-table-view', [VeterinaryController::class, 'datatable_view'])->name('veterinary.datatable_view');
    Route::get('veterinary', [VeterinaryController::class, 'index'])->name('veterinary');
    Route::get('veterinary.index_data', [VeterinaryController::class, 'index_data'])->name('veterinary.index_data');

    });

    Route::group(['middleware' => ['permission:view_grooming_booking']], function () {

    Route::get('grooming-table-view', [GroomingController::class, 'datatable_view'])->name('grooming.datatable_view');
    Route::get('grooming', [GroomingController::class, 'index'])->name('grooming');
    Route::get('grooming.index_data', [GroomingController::class, 'index_data'])->name('grooming.index_data');

    });


    Route::group(['middleware' => ['permission:view_walking_booking']], function () {

    Route::get('walking-table-view', [WalkingController::class, 'datatable_view'])->name('walking.datatable_view');
    Route::get('walking', [WalkingController::class, 'index'])->name('walking');
    Route::get('walking.index_data', [WalkingController::class, 'index_data'])->name('walking.index_data');
    Route::get('booking-request-datatable', [WalkingController::class, 'booking_request_datatable'])->name('walking.booking_request_datatable');

    Route::get('accept-booking/{id}', [WalkingController::class, 'accept_booking'])->name('walking.accept-booking');


    

   });

    Route::group(['middleware' => ['permission:view_training_booking']], function () {

    Route::get('training-table-view', [TrainingController::class, 'datatable_view'])->name('training.datatable_view');
    Route::get('training', [TrainingController::class, 'index'])->name('training');
    Route::get('training.index_data', [trainingController::class, 'index_data'])->name('training.index_data');

  });

    Route::group(['middleware' => ['permission:view_daycare_booking']], function () {

    Route::get('daycare-table-view', [DayCareController::class, 'datatable_view'])->name('daycare.datatable_view');
    Route::get('daycare', [DayCareController::class, 'index'])->name('daycare');
    Route::get('daycare.index_data', [DayCareController::class, 'index_data'])->name('daycare.index_data');

  });

    Route::group(['middleware' => ['permission:view_booking']], function () {

    Route::get('booking-table-view', [AllBookingsController::class, 'datatable_view'])->name('booking.datatable_view');
    Route::get('booking', [AllBookingsController::class, 'index'])->name('booking');
    Route::get('booking.index_data', [AllBookingsController::class, 'index_data'])->name('booking.index_data');

  });


    Route::get('get-address', [BookingsController::class, 'getAddress'])->name('get-address');

    Route::resource('bookings', BookingsController::class);
});
