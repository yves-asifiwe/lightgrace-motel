<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MotelController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\TwoFactorAuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', [AdminController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Two-Factor Authentication verification (no auth required - used during login)
Route::get('/2fa/verify', [TwoFactorAuthController::class, 'showVerificationForm'])->name('2fa.verify');
Route::post('/2fa/verify', [TwoFactorAuthController::class, 'verify']);

// Two-Factor Authentication setup (no auth required - used during forced setup)
Route::get('/2fa/setup', [TwoFactorAuthController::class, 'showSetupForm'])->name('2fa.setup');
Route::post('/2fa/setup', [TwoFactorAuthController::class, 'setup']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Two-Factor Authentication management routes (require auth)
    Route::prefix('2fa')->name('2fa.')->group(function () {
        Route::get('/manage', [TwoFactorAuthController::class, 'showManageForm'])->name('manage');
        Route::post('/disable', [TwoFactorAuthController::class, 'disable'])->name('disable');
        Route::post('/regenerate-codes', [TwoFactorAuthController::class, 'regenerateRecoveryCodes'])->name('regenerate-codes');
    });
    
    // Admin routes (accessible by admin and manager)
    Route::prefix('admin')->middleware('2fa')->group(function () {
        // Dashboard (Room management)
        Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard')->middleware('role:admin,manager');
        Route::get('/rooms/create', [MotelController::class, 'create'])->name('rooms.create')->middleware('role:admin,manager');
        Route::post('/rooms', [MotelController::class, 'store'])->name('rooms.store')->middleware('role:admin,manager');
        Route::get('/rooms/{room}/edit', [MotelController::class, 'edit'])->name('rooms.edit')->middleware('role:admin,manager');
        Route::put('/rooms/{room}', [MotelController::class, 'update'])->name('rooms.update')->middleware('role:admin,manager');
        Route::delete('/rooms/{room}', [MotelController::class, 'destroy'])->name('rooms.destroy')->middleware('role:admin,manager');

        // Other admin sections
        Route::get('/rooms', [AdminController::class, 'rooms'])->name('admin.rooms')->middleware('role:admin,manager');

        // Bookings
        Route::get('/bookings', [BookingController::class, 'index'])->name('admin.bookings');
        Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
        Route::get('/bookings/available-rooms', [BookingController::class, 'getAvailableRooms'])->name('bookings.available-rooms');
        Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
        Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
        Route::patch('/bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('bookings.update-status');
        Route::delete('/bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');

        Route::get('/customers', [AdminController::class, 'customers'])->name('admin.customers');
        Route::get('/reports', [AdminController::class, 'reports'])->name('admin.reports');
        Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings')->middleware('role:admin,manager');
        Route::post('/settings/hotel', [AdminController::class, 'updateHotelInfo'])->name('admin.updateHotelInfo')->middleware('role:admin,manager');
        Route::post('/settings/appearance', [AdminController::class, 'updateAppearance'])->name('admin.updateAppearance')->middleware('role:admin,manager');
        Route::post('/settings/admin', [AdminController::class, 'storeAdmin'])->name('admin.storeAdmin')->middleware('role:admin,manager');
        Route::delete('/settings/admin/{user}', [AdminController::class, 'deleteAdmin'])->name('admin.delete')->middleware('role:admin,manager');
    });

    // Manager routes
    Route::prefix('manager')->middleware(['role:manager', '2fa'])->group(function () {
        Route::get('/', [AdminController::class, 'managerDashboard'])->name('manager.dashboard');
        Route::get('/rooms', [AdminController::class, 'managerRooms'])->name('manager.rooms');
        Route::get('/rooms/create', [MotelController::class, 'create'])->name('manager.rooms.create');
        Route::post('/rooms', [MotelController::class, 'store'])->name('manager.rooms.store');
        Route::get('/rooms/{room}/edit', [MotelController::class, 'edit'])->name('manager.rooms.edit');
        Route::put('/rooms/{room}', [MotelController::class, 'update'])->name('manager.rooms.update');
        Route::delete('/rooms/{room}', [MotelController::class, 'destroy'])->name('manager.rooms.destroy');
        Route::get('/admins', [AdminController::class, 'adminsList'])->name('manager.admins');
    });

    // Recipient routes
    Route::prefix('recipient')->middleware(['role:recipient', '2fa'])->group(function () {
        Route::get('/', [AdminController::class, 'recipientDashboard'])->name('recipient.dashboard');
    });
});
Route::get('/migrate-seed', function () {
    Artisan::call('migrate:fresh', ['--seed' => true]);
    return "Migration and seeding completed successfully.";
});
Route::get('/migrate-seed', function () {
    Artisan::call('migrate:fresh', ['--seed' => true]);
    return "Migration and seeding completed successfully.";
});
Route::get('/clear', function () {
    Artisan::call('config:cache');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');

    return "Caches cleared and config cached successfully.";
});
require __DIR__.'/auth.php';
