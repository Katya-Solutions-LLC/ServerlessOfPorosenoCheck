<?php

use Illuminate\Support\Facades\Route;
use Modules\Event\Http\Controllers\Backend\EventsController;

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
Route::group(['prefix' => 'app', 'as' => 'backend.', 'middleware' => ['web', 'auth','permission:view_events']], function () {
    /*
    * These routes need view-backend permission
    * (good if you want to allow more than one group in the backend,
    * then limit the backend features by different roles or permissions)
    *
    * Note: Administrator has all permissions so you do not have to specify the administrator role everywhere.
    */

    /*
     *
     *  Backend Events Routes
     *
     * ---------------------------------------------------------------------
     */

    Route::group(['prefix' => 'events', 'as' => 'events.'],function () {
      Route::get("index_list", [EventsController::class, 'index_list'])->name("index_list");
      Route::get("index_data", [EventsController::class, 'index_data'])->name("index_data");
      Route::get("trashed", [EventsController::class, 'trashed'])->name("trashed");
      Route::patch("trashed/{id}", [EventsController::class, 'restore'])->name("restore");
      Route::post('bulk-action', [EventsController::class, 'bulk_action'])->name('bulk_action');
      Route::post('update-status/{id}', [EventsController::class, 'update_status'])->name('update_status');
    });
    Route::resource("events", EventsController::class);
});


