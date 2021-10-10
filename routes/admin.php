<?php

use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;

//Route::post('admin/register', [AuthController::class, 'register']);
Route::post('admin/login', [AuthController::class, 'login']);

// authenticated staff routes here
Route::group(['prefix' => 'admin', 'middleware' => ['auth:admin-api', 'scopes:admin']], function () {
    Route::get('/auth', [AuthController::class, 'getAuthData']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/dashboard', DashboardController::class);

    Route::apiResources(['products' => ProductController::class]);
    Route::apiResources(['customers' => CustomerController::class]);
    Route::post('/status-update/{order}/{status}', [OrderController::class, 'orderStatusUpdate']);
    Route::get('/orders', [OrderController::class, 'getOrders']);
    Route::get('/orders/{order}', [OrderController::class, 'show']);
    //admin profile
    Route::get('/profile/{admin}', [ProfileController::class, 'show']);
    Route::put('/profile/{admin}', [ProfileController::class, 'update']);
});
