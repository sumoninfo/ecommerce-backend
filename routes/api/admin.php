<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;

//Route::post('admin/register', [AuthController::class, 'register']);
Route::post('admin/login', [AuthController::class, 'login']);

// authenticated staff routes here
Route::group(['prefix' => 'admin', 'middleware' => ['auth:admin-api', 'scopes:admin']], function () {
    Route::get('/auth', [AuthController::class, 'getAuthData']);
    Route::post('/logout', [AuthController::class, 'logout']);

//    Route::apiResource('/products', )

});
