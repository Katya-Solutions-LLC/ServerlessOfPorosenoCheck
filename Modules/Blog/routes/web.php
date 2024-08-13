<?php

use Illuminate\Support\Facades\Route;
use Modules\Blog\Http\Controllers\Backend\BlogsController;

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
Route::group(['prefix' => 'app', 'as' => 'backend.', 'middleware' => ['web', 'auth','permission:view_blogs']], function () {
    /*
    * These routes need view-backend permission
    * (good if you want to allow more than one group in the backend,
    * then limit the backend features by different roles or permissions)
    *
    * Note: Administrator has all permissions so you do not have to specify the administrator role everywhere.
    */

    /*
     *
     *  Backend Blogs Routes
     *
     * ---------------------------------------------------------------------
     */

    Route::group(['prefix' => 'blogs', 'as' => 'blogs.'],function () {
      Route::get("index_list", [BlogsController::class, 'index_list'])->name("index_list");
      Route::get("index_data", [BlogsController::class, 'index_data'])->name("index_data");
      Route::get("trashed", [BlogsController::class, 'trashed'])->name("trashed");
      Route::patch("trashed/{id}", [BlogsController::class, 'restore'])->name("restore");
      Route::post('bulk-action', [BlogsController::class, 'bulk_action'])->name('bulk_action');
      Route::post('update-status/{id}', [BlogsController::class, 'update_status'])->name('update_status');
    });
    Route::resource("blogs", BlogsController::class);
});

