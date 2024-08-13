<?php
use Illuminate\Support\Facades\Route;
use Modules\Page\Http\Controllers\Backend\API\PageController;

Route::get('page-list', [PageController::class, 'pageList']);

?>


