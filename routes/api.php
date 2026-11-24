<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::get('/rooms', [DashboardController::class, 'rooms']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [UserController::class, 'logout']);

    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::get('/room/{room}', [RoomController::class, 'room_edit']);
    Route::post('/room/store', [RoomController::class, 'room_addform']);
    Route::post('/room/{room}', [RoomController::class, 'room_editform']);
    Route::delete('/room/{room}', [RoomController::class, 'room_delete']);

    Route::get('/booking/my', [BookingController::class, 'booking_list']);
    Route::get('/booking/admin', [BookingController::class, 'booking_admin']);
    Route::get('/booking/room/{id}', [BookingController::class, 'booking_room']);
    Route::post('/booking/store', [BookingController::class, 'booking_addform']);
    Route::post('/booking/{booking}/status', [BookingController::class, 'booking_update_status']);
    Route::post('/booking/{booking}/review', [BookingController::class, 'booking_review']);
});
