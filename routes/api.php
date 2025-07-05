<?php

use App\Http\Controllers\Api\AmenityController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HotelController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Protected routes
Route::group(['middleware' => ['force.JSON', 'auth:sanctum']], function () {
    // Hotel routes
    Route::get('hotels', [HotelController::class, 'list'])->name('hotel.list');
    Route::get('hotels/{id}', [HotelController::class, 'show'])->name('hotel.show');
    Route::post('hotels', [HotelController::class, 'store'])->name('hotel.store');
    Route::put('hotels/{id}', [HotelController::class, 'update'])->name('hotel.update');
    Route::delete('hotels/{id}', [HotelController::class, 'destroy'])->name('hotel.destroy');

    // Amenity routes
    Route::get('amenities', [AmenityController::class, 'list'])->name('amenities.list');
    Route::get('amenities/{amenity}', [AmenityController::class, 'show'])->name('amenities.show');
    Route::post('amenities', [AmenityController::class, 'store'])->name('amenities.store');
    Route::put('amenities/{amenity}', [AmenityController::class, 'update'])->name('amenities.update');
    Route::delete('amenities/{amenity}', [AmenityController::class, 'destroy'])->name('amenities.destroy');
});
