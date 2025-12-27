<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\BookingController;

Route::get('/home', [PageController::class, 'home']);

Route::get('/book', [BookingController::class, 'create']);

Route::post('/book', [BookingController::class, 'store']);
