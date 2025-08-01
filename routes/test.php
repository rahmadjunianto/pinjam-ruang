<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

Route::get('/test-bidang-access', function () {
    // Login as admin user
    $admin = User::where('email', 'admin@kemenag.go.id')->first();

    if (!$admin) {
        return response()->json(['error' => 'Admin user not found']);
    }

    Auth::login($admin);

    // Redirect ke halaman bidang
    return redirect()->route('admin.bidangs.index');
})->name('test.bidang.access');
