<?php
use Illuminate\Support\Facades\Route;
use Modules\Event\Http\Controllers\Backend\API\EventController;

Route::get('event-list', [EventController::class, 'eventList']);
?>


