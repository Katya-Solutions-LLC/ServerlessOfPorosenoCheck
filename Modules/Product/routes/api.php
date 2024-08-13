<?php
use Illuminate\Support\Facades\Route;
use Modules\Product\Http\Controllers\Backend\API\CategoryController;
use Modules\Product\Http\Controllers\Backend\API\ProductsController;
use Modules\Product\Http\Controllers\Backend\API\BrandsController;
use Modules\Product\Http\Controllers\Backend\API\UnitsController;
use Modules\Product\Http\Controllers\Backend\API\CartController;
use Modules\Product\Http\Controllers\Backend\API\WishListController;
use Modules\Product\Http\Controllers\Backend\API\ReviewController;
use Modules\Product\Http\Controllers\Backend\API\DashboardController;
use Modules\Product\Http\Controllers\Backend\API\OrdersController;
use Modules\Product\Http\Controllers\Backend\API\VariationsController;



Route::get('get-product-category', [CategoryController::class, 'categoryList']);
Route::get('get-product-list', [ProductsController::class, 'ProductList']);
Route::get('product_detail', [ProductsController::class, 'product_detail']);
Route::get('product-brand', [BrandsController::class, 'product_brand']);
Route::get('product-variation', [VariationsController::class, 'productVariation']);
Route::get('product-unit', [UnitsController::class, 'product_unit']);
Route::get('product-dashboard', [DashboardController::class, 'productDashboard']);
Route::get('get-review-list', [ReviewController::class, 'getReviewList']);
Route::get('get-order-status-list', [OrdersController::class, 'statusList']);




Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::post('add-to-cart', [CartController::class, 'store']);
    Route::get('get-cart-list', [CartController::class, 'getCartList']);
    Route::get('remove-cart', [CartController::class, 'removeCart']);
    Route::post('update-cart', [CartController::class, 'UpdateCart']);

    Route::post('add-to-wishlist', [WishListController::class, 'store']);
    Route::get('get-wishlist', [WishListController::class, 'getWishList']);
    Route::get('remove-wishlist', [WishListController::class, 'removeWishList']);

    Route::post('add-review',[ReviewController::class,'store']);
    Route::get('remove-review',[ReviewController::class,'removeReview']);
    Route::post('update-review',[ReviewController::class,'UpdateReview']);
    
    Route::post('place-order',[OrdersController::class,'store']);

    Route::get('get-order-list', [OrdersController::class, 'orderList']);
    Route::get('cancle-order', [OrdersController::class, 'cancleOrder']);
    Route::get('get-order-details', [OrdersController::class, 'orderDetails']);

  
    Route::post('save-brand', [ Modules\Product\Http\Controllers\Backend\BrandsController::class, 'store']);
    Route::post('update-brand/{id}', [ Modules\Product\Http\Controllers\Backend\BrandsController::class, 'update']);
    Route::post('delete-brand/{id}', [ Modules\Product\Http\Controllers\Backend\BrandsController::class, 'destroy']);

    Route::post('save-product-category', [Modules\Product\Http\Controllers\Backend\CategoryController::class, 'store']);
    Route::post('update-product-category/{id}', [Modules\Product\Http\Controllers\Backend\CategoryController::class, 'update']);
    Route::post('delete-product-category/{id}', [ Modules\Product\Http\Controllers\Backend\CategoryController::class, 'destroy']);

    Route::post('save-unit', [ Modules\Product\Http\Controllers\Backend\UnitsController::class, 'store']);
    Route::post('update-unit/{id}', [ Modules\Product\Http\Controllers\Backend\UnitsController::class, 'update']);
    Route::post('delete-unit/{id}', [ Modules\Product\Http\Controllers\Backend\UnitsController::class, 'destroy']);

    Route::post('save-product', [ Modules\Product\Http\Controllers\Backend\ProductsController::class, 'store']);
    Route::post('update-product/{id}', [ Modules\Product\Http\Controllers\Backend\ProductsController::class, 'update']);
    Route::post('delete-product/{id}', [ Modules\Product\Http\Controllers\Backend\ProductsController::class, 'destroy']);
    Route::post('create-combination', [ Modules\Product\Http\Controllers\Backend\ProductsController::class, 'CreateCombination']);

    

    Route::post('save-variation', [ Modules\Product\Http\Controllers\Backend\VariationsController::class, 'store']);
    Route::post('update-variation/{id}', [ Modules\Product\Http\Controllers\Backend\VariationsController::class, 'update']);
    Route::post('delete-variation/{id}', [ Modules\Product\Http\Controllers\Backend\VariationsController::class, 'destroy']);
    
    Route::post('update-delivery-status', [Modules\Product\Http\Controllers\Backend\OrdersController::class, 'updateDeliveryStatus']);
    Route::post('update-payment-status', [Modules\Product\Http\Controllers\Backend\OrdersController::class, 'updatePaymentStatus']);

    // Route::apiResource('category', CategoryController::class);
    // Route::post('category-detail', [CategoryController::class, 'categoryDetails']);
    // Route::get('subcategory-list', [CategoryController::class, 'subCategoryList']);
    // Route::post('subcategory-detail', [CategoryController::class, 'subCategoryDetail']);
    // Route::get('subcategories', [CategoryController::class, 'index_SubCategory']);


});
?>