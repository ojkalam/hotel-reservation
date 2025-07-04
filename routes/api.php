<?php

use App\Http\Controllers\Api\AmenityController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HotelController;
use Illuminate\Support\Facades\Route;

//public route
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('hotels', [HotelController::class, 'list'])->name('hotel.list');
Route::get('hotels/{id}', [HotelController::class, 'show'])->name('hotel.show');
Route::post('hotels', [HotelController::class, 'store'])->name('hotel.store');
Route::put('hotels/{id}', [HotelController::class, 'update'])->name('hotel.update');
Route::delete('hotels/{id}', [HotelController::class, 'destroy'])->name('hotel.destroy');

//without force json middleware
Route::post('amenities', [AmenityController::class, 'store'])->name('amenities.store');
//with force json middleware
Route::group(['middleware' => ['force.JSON', 'auth:sanctum']], function () {
    Route::get('amenities', [AmenityController::class, 'list'])->name('amenities.list');
    Route::get('amenities/{id}', [AmenityController::class, 'show'])->name('amenities.show');
    Route::post('amenities/{id}', [AmenityController::class, 'update'])->name('amenities.update');
    Route::delete('amenities/{id}', [AmenityController::class, 'destroy'])->name('amenities.destroy');
});
