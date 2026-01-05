<?php

use App\Models\Service;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QueueController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\Admin\BookingAdminController;
use App\Http\Controllers\Admin\ServiceAdminController;

Route::get('/', function () {
    $services = Service::where('is_active', true)->orderBy('name')->get();
    return view('home', compact('services'));
});

// Admin Auth
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::post('/admin/logout', [AdminAuthController::class, 'logout']);


Route::get('/book', [BookingController::class, 'create']);
Route::post('/book', [BookingController::class, 'store']);

Route::get('/track', [BookingController::class, 'trackForm']);
Route::post('/track', [BookingController::class, 'trackResult']);


Route::middleware(['admin'])->group(function () {
    Route::get('/admin/bookings', [BookingAdminController::class, 'index']);
    Route::post('/admin/bookings/{booking}/status', [BookingAdminController::class, 'updateStatus']);
    Route::patch('/admin/bookings/{booking}/status', [BookingAdminController::class, 'updateStatus']);

    Route::get('/admin/services', [ServiceAdminController::class, 'index']);
    Route::get('/admin/services/create', [ServiceAdminController::class, 'create']);
    Route::post('/admin/services', [ServiceAdminController::class, 'store']);

    Route::get('/admin/services/{service}/edit', [ServiceAdminController::class, 'edit']);
    Route::patch('/admin/services/{service}', [ServiceAdminController::class, 'update']);

    Route::delete('/admin/services/{service}', [ServiceAdminController::class, 'delete']);
});

Route::get('/slots', [BookingController::class, 'availableSlots']);

Route::get('/queue', [QueueController::class, 'index']);
