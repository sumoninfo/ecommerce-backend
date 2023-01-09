<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/rooms', [FrontendController::class, 'getRooms']);
Route::get('/room/{room}', [FrontendController::class, 'getRoom']);

//Customer Login & Register
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// authenticated staff routes here
Route::group(['prefix' => 'user', 'middleware' => ['auth:user-api', 'scopes:user']], function () {
    Route::get('/auth', [AuthController::class, 'getAuthData']);
    Route::post('/logout', [AuthController::class, 'logout']);

    //User profile update
    Route::get('/profile/{user}', [ProfileController::class, 'show']);
    Route::put('/profile/{user}', [ProfileController::class, 'update']);
    Route::apiResources(['bookings' => BookingController::class]);
});
