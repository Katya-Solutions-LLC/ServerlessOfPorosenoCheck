<?php

use Illuminate\Support\Facades\Route;
use Modules\Pet\Http\Controllers\Backend\PetsController;
use Modules\Pet\Http\Controllers\Backend\PettypeController;
use Modules\Pet\Http\Controllers\Backend\BreedController;
use Modules\Pet\Http\Controllers\Backend\PetNoteController;

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
Route::group(['prefix' => 'app', 'as' => 'backend.', 'middleware' => ['web', 'auth']], function () {
    /*
    * These routes need view-backend permission
    * (good if you want to allow more than one group in the backend,
    * then limit the backend features by different roles or permissions)
    *
    * Note: Administrator has all permissions so you do not have to specify the administrator role everywhere.
    */

    /*
     *
     *  Backend Pets Routes
     *
     * ---------------------------------------------------------------------
     */

    Route::group(['prefix' => 'pets', 'as' => 'pets.'],function () {
      Route::get("index_list", [PetsController::class, 'index_list'])->name("index_list");
      Route::get("index_data", [PetsController::class, 'index_data'])->name("index_data");
      Route::get("trashed", [PetsController::class, 'trashed'])->name("trashed");
      Route::patch("trashed/{id}", [PetsController::class, 'restore'])->name("restore");
      Route::post('bulk-action', [PetsController::class, 'bulk_action'])->name('bulk_action');
      Route::post('update-status/{id}', [PetsController::class, 'update_status'])->name('update_status');
      Route::get('user_pet_list/{id}', [PetsController::class, 'user_pet_list'])->name("user_pet_list");
      Route::get('pet_notes_list/{id}', [PetsController::class, 'pet_notes_list'])->name("pet_notes_list");
      Route::post('add_pet_notes', [PetsController::class, 'add_pet_notes'])->name("add_pet_notes");
      Route::delete('delete_pet_note/{id}', [PetsController::class, 'delete_pet_note'])->name("delete_pet_note");
      Route::get('edit_pet_note/{id}', [PetNoteController::class, 'edit'])->name("edit_pet_note");
      Route::post('update_pet_note/{id}', [PetNoteController::class, 'update'])->name("update_pet_note");

        
    });
    Route::resource("pets", PetsController::class);

    Route::group(['prefix' => 'pet', 'as' => 'pet.'],function () {
        Route::group(['prefix' => '/pettype', 'as' => 'pettype.'],function () {
            Route::get("index_list", [PettypeController::class, 'index_list'])->name("index_list");
            Route::get("index_data", [PettypeController::class, 'index_data'])->name("index_data");
            Route::get("trashed", [PettypeController::class, 'trashed'])->name("trashed");
            Route::patch("trashed/{id}", [PettypeController::class, 'restore'])->name("restore");
            Route::post('bulk-action', [PettypeController::class, 'bulk_action'])->name('bulk_action');
            Route::post('update-status/{id}', [PettypeController::class, 'update_status'])->name('update_status');
        });
        Route::resource("pettype", PettypeController::class);

        Route::group(['prefix' => '/breed', 'as' => 'breed.'],function () {
            Route::get("index_list", [BreedController::class, 'index_list'])->name("index_list");
            Route::get("index_data", [BreedController::class, 'index_data'])->name("index_data");
            Route::get("trashed", [BreedController::class, 'trashed'])->name("trashed");
            Route::patch("trashed/{id}", [BreedController::class, 'restore'])->name("restore");
            Route::post('bulk-action', [BreedController::class, 'bulk_action'])->name('bulk_action');
            Route::post('update-status/{id}', [BreedController::class, 'update_status'])->name('update_status');
            Route::patch("breed_list/{id}", [BreedController::class, 'breed_list'])->name("breed_list");
        });
        Route::resource("breed", BreedController::class);
        
    });
});

