<?php

use Modules\Logistic\Http\Controllers\Backend\API\LogisticZoneController;
use Modules\Logistic\Http\Controllers\Backend\API\LogisticsController;


Route::get('get-logisticzone-list', [LogisticZoneController::class, 'logisticzoneList']);
Route::get('logistics-list', [LogisticsController::class, 'logisticsList']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('save-logistics', [ Modules\Logistic\Http\Controllers\Backend\LogisticsController::class, 'store']);
    Route::post('update-logistics/{id}', [ Modules\Logistic\Http\Controllers\Backend\LogisticsController::class, 'update']);
    Route::post('delete-logistics/{id}', [ Modules\Logistic\Http\Controllers\Backend\LogisticsController::class, 'destroy']);

    Route::post('save-logisticzone', [ Modules\Logistic\Http\Controllers\Backend\LogisticZoneController::class, 'store']);
    Route::post('update-logisticzone/{id}', [ Modules\Logistic\Http\Controllers\Backend\LogisticZoneController::class, 'update']);
    Route::post('delete-logisticzone/{id}', [ Modules\Logistic\Http\Controllers\Backend\LogisticZoneController::class, 'destroy']);
});