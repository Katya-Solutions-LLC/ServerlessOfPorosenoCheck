<?php
use Illuminate\Support\Facades\Route;
use Modules\Tag\Http\Controllers\Backend\API\TagsController;

Route::get('product-tag', [TagsController::class, 'productTag']);

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::post('save-tag', [Modules\Tag\Http\Controllers\Backend\TagsController::class, 'store']);
    Route::post('update-tag/{id}', [Modules\Tag\Http\Controllers\Backend\TagsController::class, 'update']);
    Route::post('delete-tag/{id}', [Modules\Tag\Http\Controllers\Backend\TagsController::class, 'destroy']);
    
});
?>