<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Kiosk\KioskQueueAdminController;
use Illuminate\Support\Facades\Route;

// Admin authentication routes
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Admin protected routes
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth:admin', 'admin'])
    ->group(function () {
        Route::get('/queue', [KioskQueueAdminController::class, 'index'])->name('queue.index');
        Route::post('/queue/call-next', [KioskQueueAdminController::class, 'callNext'])->name('queue.callNext');
        Route::post('/queue/{ticket}/serve', [KioskQueueAdminController::class, 'serve'])->name('queue.serve');
        Route::post('/queue/{ticket}/complete', [KioskQueueAdminController::class, 'complete'])->name('queue.complete');
    });
