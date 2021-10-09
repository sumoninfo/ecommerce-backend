<?php

use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/products', [\App\Http\Controllers\FrontendController::class, 'getProducts']);

//Customer Login & Register
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// authenticated staff routes here
Route::group(['prefix' => 'user', 'middleware' => ['auth:user-api', 'scopes:user']], function () {
    Route::get('/auth', [AuthController::class, 'getAuthData']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResources(['orders' => OrderController::class]);
});
