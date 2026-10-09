<?php

use App\Http\Controllers\Kiosk\KioskAnnouncementController;
use App\Http\Controllers\Kiosk\KioskAuthController;
use App\Http\Controllers\Kiosk\KioskDashboardController;
use App\Http\Controllers\Kiosk\KioskGradeController;
use App\Http\Controllers\Kiosk\KioskHomeController;
use App\Http\Controllers\Kiosk\KioskPaymentController;
use App\Http\Controllers\Kiosk\KioskQueueController;
use App\Http\Controllers\Kiosk\KioskSoaController;
use Illuminate\Support\Facades\Route;

// Redirect root to Kiosk Portal
Route::redirect('/', '/kiosk');

// KIOSK PORTAL ROUTES
Route::prefix('kiosk')->name('kiosk.')->middleware(['kiosk.nocache', 'kiosk.timeout'])->group(function () {

    // Public Kiosk Pages (No Login Required)
    Route::get('/', [KioskHomeController::class, 'index'])->name('home');
    Route::get('/help', fn () => view('kiosk.help'))->name('help');
    Route::get('/announcements', [KioskAnnouncementController::class, 'index'])->name('announcements.index');
    Route::get('/welcome', fn () => view('kiosk.welcome'))->name('welcome');
    Route::get('/queue', [KioskQueueController::class, 'index'])->name('queue.index');

    // Student Authentication
    Route::get('/login', [KioskAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [KioskAuthController::class, 'login'])->name('login.submit');
    Route::match(['get', 'post'], '/logout', [KioskAuthController::class, 'logout'])->name('logout');

    // Protected Student Services (Authentication Required)
    Route::middleware('kiosk.auth')->group(function () {
        Route::get('/soa', [KioskSoaController::class, 'index'])->name('soa.index');
        Route::get('/payments', [KioskPaymentController::class, 'index'])->name('payments.index');
        Route::get('/dashboard', [KioskDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/grades', [KioskGradeController::class, 'index'])
            ->name('grades.index');

        Route::post('/queue', [KioskQueueController::class, 'store'])
            ->name('queue.store');
    });
});
require __DIR__.'/admin.php';
