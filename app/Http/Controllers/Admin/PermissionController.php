<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Display permission management page
     */
    public function index()
    {
        $users = User::with('bidang')->paginate(10);

        return view('admin.permissions.index', compact('users'));
    }

    /**
     * Update user role
     */
    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:admin,user,viewer'
        ]);

        try {
            // For now, we'll use a simple role field
            // In a real app, you might use Spatie Permission or similar package
            $user->update(['role' => $request->role]);

            return redirect()->back()
                           ->with('success', 'Role user berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Gagal memperbarui role: ' . $e->getMessage());
        }
    }

    /**
     * Show role management form
     */
    public function roles()
    {
        $roles = [
            'admin' => [
                'name' => 'Administrator',
                'description' => 'Akses penuh ke semua fitur sistem',
                'permissions' => [
                    'Dashboard Analytics',
                    'Manajemen User',
                    'Manajemen Ruangan',
                    'Manajemen Peminjaman',
                    'Persetujuan Booking',
                    'Laporan & Export',
                    'Backup & Restore',
                    'Pengaturan Sistem'
                ]
            ],
            'user' => [
                'name' => 'User Biasa',
                'description' => 'Dapat melakukan peminjaman ruangan',
                'permissions' => [
                    'Lihat Dashboard',
                    'Buat Peminjaman',
                    'Lihat Peminjaman Sendiri',
                    'Edit Profil'
                ]
            ],
            'viewer' => [
                'name' => 'Viewer',
                'description' => 'Hanya dapat melihat data',
                'permissions' => [
                    'Lihat Dashboard',
                    'Lihat Kalender Peminjaman',
                    'Lihat Data Ruangan'
                ]
            ]
        ];

        return view('admin.permissions.roles', compact('roles'));
    }
}
