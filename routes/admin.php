<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use Illuminate\Support\Facades\Route;

//Route::post('admin/register', [AuthController::class, 'register']);
Route::post('admin/login', [AuthController::class, 'login']);

// authenticated staff routes here
Route::group(['prefix' => 'admin', 'middleware' => ['auth:admin-api', 'scopes:admin']], function () {
    Route::get('/auth', [AuthController::class, 'getAuthData']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/dashboard', DashboardController::class);

    Route::apiResources(['amenities' => \App\Http\Controllers\Admin\AmenityController::class]);
    Route::apiResources(['rooms' => \App\Http\Controllers\Admin\RoomController::class]);
    Route::apiResources(['products' => ProductController::class]);
    Route::apiResources(['customers' => CustomerController::class]);
    //Orders
    Route::get('/delivered-orders', [OrderController::class, 'deliveredOrders']);
    Route::post('/status-update/{order}/{status}', [OrderController::class, 'orderStatusUpdate']);
    Route::get('/orders', [OrderController::class, 'getOrders']);
    Route::get('/orders/{order}', [OrderController::class, 'show']);
    //admin profile
    Route::get('/profile/{admin}', [ProfileController::class, 'show']);
    Route::put('/profile/{admin}', [ProfileController::class, 'update']);
});
