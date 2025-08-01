<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\BidangController;
use App\Http\Controllers\Admin\RoomCategoryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('admin.dashboard');
    }
    return view('welcome');
});

Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/rekap-data', [DashboardController::class, 'getRekapData'])->name('dashboard.rekap-data');
    Route::get('/dashboard/export-pdf', [DashboardController::class, 'exportPdf'])->name('dashboard.export-pdf');

    // Room Booking System Routes
    Route::resource('rooms', RoomController::class);
    Route::resource('bookings', BookingController::class);
    Route::resource('bidangs', BidangController::class);
    Route::resource('room-categories', RoomCategoryController::class);

    Route::get('calendar', [BookingController::class, 'calendar'])->name('calendar');
    // Additional booking routes
    Route::prefix('bookings')->name('bookings.')->group(function () {
        Route::patch('{booking}/approve', [BookingController::class, 'approve'])->name('approve');
        Route::patch('{booking}/reject', [BookingController::class, 'reject'])->name('reject');
        Route::patch('{booking}/cancel', [BookingController::class, 'cancel'])->name('cancel');
    });

    // Room availability check
    Route::get('rooms/{room}/availability', [RoomController::class, 'checkAvailability'])->name('rooms.availability');
});

require __DIR__.'/auth.php';