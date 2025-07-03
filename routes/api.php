<?php

use App\Http\Controllers\HotelController;
use Illuminate\Support\Facades\Route;

Route::get('hotels', [HotelController::class, 'list'])->name('hotel.list');
Route::post('hotels', [HotelController::class, 'store'])->name('hotel.store');
