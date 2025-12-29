<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Admin\BookingAdminController;
use App\Http\Controllers\AdminAuthController;

// Admin Auth
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::post('/admin/logout', [AdminAuthController::class, 'logout']);


Route::get('/book', [BookingController::class, 'create']);
Route::post('/book', [BookingController::class, 'store']);

Route::middleware(['admin'])->group(function () {
    Route::get('/admin/bookings', [BookingAdminController::class, 'index']);
    Route::post('/admin/bookings/{booking}/status', [BookingAdminController::class, 'updateStatus']);
});

