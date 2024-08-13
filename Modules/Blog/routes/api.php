<?php
use Illuminate\Support\Facades\Route;
use Modules\Blog\Http\Controllers\Backend\API\BlogController;

Route::get('blog-list', [BlogController::class, 'blogList']);
?>


