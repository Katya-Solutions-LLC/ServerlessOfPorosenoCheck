<?php
use Illuminate\Support\Facades\Route;
use Modules\Pet\Http\Controllers\Backend\PetsController;
use Modules\Pet\Http\Controllers\Backend\PetNoteController;
use Modules\Pet\Http\Controllers\Backend\PettypeController;
use Modules\Pet\Http\Controllers\Backend\API\PetController;


Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('pet/{id}', [PetsController::class, 'update']);
    Route::Resource('pet', PetsController::class);
     
    Route::post('save-note', [PetNoteController::class,'store']);
    Route::post('delete-note/{id}', [PetNoteController::class,'destroy']);
    Route::Resource('pettype', PettypeController::class);
    Route::get('pet-list', [PetController::class, 'petList']);
    Route::get('pet-details', [PetController::class, 'PetDetails']);
    Route::get('get-notes', [PetController::class, 'petNoteList']);
    Route::get('owner-pet-list', [PetController::class, 'OwnerPetList']);
});

Route::get('pet-types', [PetController::class, 'petTypeList']);
Route::get('breed-list', [PetController::class, 'breedList']);
// Route::get('pet-list', [PetController::class, 'petList']);
 
?>


