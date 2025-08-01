<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\BidangController;
use App\Http\Controllers\Admin\RoomCategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\BackupController;
use App\Http\Controllers\Admin\HelpController;
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
    // Dashboard accessible by all authenticated users
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/rekap-data', [DashboardController::class, 'getRekapData'])->name('dashboard.rekap-data');
    Route::get('/dashboard/export-pdf', [DashboardController::class, 'exportPdf'])->middleware('role:admin')->name('dashboard.export-pdf');

    // Other admin resources (Admin only)
    Route::resource('bidangs', BidangController::class)->middleware('role:admin');
    Route::resource('room-categories', RoomCategoryController::class)->middleware('role:admin');

    // Permissions Management Routes (Admin only)
    Route::prefix('permissions')->name('permissions.')->middleware('role:admin')->group(function () {
        Route::get('/', [PermissionController::class, 'index'])->name('index');
        Route::get('/roles', [PermissionController::class, 'roles'])->name('roles');
        Route::patch('/users/{user}/role', [PermissionController::class, 'updateRole'])->name('update-role');
    });

    // Backup Management Routes (Admin only)
    Route::prefix('backup')->name('backup.')->middleware('role:admin')->group(function () {
        Route::get('/', [BackupController::class, 'index'])->name('index');
        Route::post('/create', [BackupController::class, 'create'])->name('create');
        Route::get('/download/{filename}', [BackupController::class, 'download'])->name('download');
        Route::delete('/delete/{filename}', [BackupController::class, 'delete'])->name('delete');
    });

    // User Management Routes (Admin only)
    Route::prefix('users')->name('users.')->middleware('role:admin')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{user}', [UserController::class, 'show'])->name('show');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
        Route::patch('/{user}/reset-password', [UserController::class, 'resetPassword'])->name('reset-password');
        Route::patch('/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('toggle-status');
    });

    // Room Management Routes (Admin only)
    Route::prefix('rooms')->name('rooms.')->middleware('role:admin')->group(function () {
        Route::get('/', [RoomController::class, 'index'])->name('index'); // Admin only
        Route::get('/create', [RoomController::class, 'create'])->name('create');
        Route::post('/', [RoomController::class, 'store'])->name('store');
        Route::get('/{room}', [RoomController::class, 'show'])->name('show');
        Route::get('/{room}/edit', [RoomController::class, 'edit'])->name('edit');
        Route::put('/{room}', [RoomController::class, 'update'])->name('update');
        Route::delete('/{room}', [RoomController::class, 'destroy'])->name('destroy');
        Route::get('/{room}/availability', [RoomController::class, 'checkAvailability'])->name('availability');
    });

    // Booking Management Routes (User can create, Admin can approve/reject)
    Route::prefix('bookings')->name('bookings.')->group(function () {
        Route::get('/', [BookingController::class, 'index'])->name('index'); // All users
        Route::get('/available-rooms', [BookingController::class, 'getAvailableRooms'])->middleware('role:admin,user')->name('available-rooms'); // For room selection
        Route::get('/create', [BookingController::class, 'create'])->middleware('role:admin,user')->name('create'); // Admin and User only
        Route::post('/', [BookingController::class, 'store'])->middleware('role:admin,user')->name('store'); // Admin and User only
        Route::get('/{booking}', [BookingController::class, 'show'])->name('show'); // All users

        // Room availability check for booking (accessible by users)
        Route::get('/room/{room}/availability', [BookingController::class, 'checkRoomAvailability'])->middleware('role:admin,user')->name('room-availability');

        // Admin only routes
        Route::middleware('role:admin')->group(function () {
            Route::get('/{booking}/edit', [BookingController::class, 'edit'])->name('edit');
            Route::put('/{booking}', [BookingController::class, 'update'])->name('update');
            Route::delete('/{booking}', [BookingController::class, 'destroy'])->name('destroy');
            Route::patch('/{booking}/approve', [BookingController::class, 'approve'])->name('approve');
            Route::patch('/{booking}/reject', [BookingController::class, 'reject'])->name('reject');
        });

        // User can cancel their own bookings
        Route::patch('/{booking}/cancel', [BookingController::class, 'cancel'])->middleware('role:admin,user')->name('cancel');
    });

    // Calendar - accessible by all authenticated users
    Route::get('calendar', [BookingController::class, 'calendar'])->name('calendar');

    // Help System Routes
    Route::prefix('help')->name('help.')->group(function () {
        Route::get('/', [HelpController::class, 'index'])->name('index');
        Route::get('/user-guide', [HelpController::class, 'userGuide'])->name('user-guide');
        Route::get('/admin-guide', [HelpController::class, 'adminGuide'])->name('admin-guide');
        Route::get('/faq', [HelpController::class, 'faq'])->name('faq');
        Route::get('/contact', [HelpController::class, 'contact'])->name('contact');
        Route::get('/system', [HelpController::class, 'system'])->name('system');
    });
});

require __DIR__.'/auth.php';