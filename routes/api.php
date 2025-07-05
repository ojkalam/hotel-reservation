<?php

use App\Http\Controllers\Api\AmenityController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HotelController;
use App\Http\Controllers\Api\RoomTypeController;
use App\Http\Controllers\Api\ReviewController;
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

    // Room Type routes
    Route::get('room-types', [RoomTypeController::class, 'list'])->name('room-types.list');
    Route::get('room-types/{roomType}', [RoomTypeController::class, 'show'])->name('room-types.show');
    Route::post('room-types', [RoomTypeController::class, 'store'])->name('room-types.store');
    Route::put('room-types/{roomType}', [RoomTypeController::class, 'update'])->name('room-types.update');
    Route::delete('room-types/{roomType}', [RoomTypeController::class, 'destroy'])->name('room-types.destroy');

    // Review routes
    Route::get('reviews', [ReviewController::class, 'list'])->name('reviews.list');
    Route::get('reviews/{review}', [ReviewController::class, 'show'])->name('reviews.show');
    Route::post('reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::put('reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});


// Protected routes using basic auth
Route::group(['middleware' => ['force.JSON', 'auth.basic']], function () {
    // Review routes
    Route::get('reviews', [ReviewController::class, 'list'])->name('reviews.list');
    Route::get('reviews/{review}', [ReviewController::class, 'show'])->name('reviews.show');
    Route::post('reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::put('reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});
