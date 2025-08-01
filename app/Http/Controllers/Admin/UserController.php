<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use App\Models\Bidang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::with('bidang');

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by bidang
        if ($request->has('bidang_id') && $request->bidang_id) {
            $query->where('bidang_id', $request->bidang_id);
        }

        $users = $query->paginate(10);
        $bidangs = Bidang::all();

        return view('admin.users.index', compact('users', 'bidangs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $bidangs = Bidang::all();
        return view('admin.users.create', compact('bidangs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
        try {
            User::create([
                'nip' => $request->nip,
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'bidang_id' => $request->bidang_id,
            ]);

            return redirect()->route('admin.users.index')
                           ->with('success', 'User berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Gagal menambahkan user: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->load(['bidang', 'bookings.room']);
        
        // User statistics
        $totalBookings = $user->bookings()->count();
        $approvedBookings = $user->bookings()->where('status', 'approved')->count();
        $pendingBookings = $user->bookings()->where('status', 'pending')->count();
        $rejectedBookings = $user->bookings()->where('status', 'rejected')->count();
        
        // Recent bookings
        $recentBookings = $user->bookings()
                              ->with('room')
                              ->latest()
                              ->take(10)
                              ->get();

        return view('admin.users.show', compact(
            'user', 
            'totalBookings', 
            'approvedBookings', 
            'pendingBookings', 
            'rejectedBookings',
            'recentBookings'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $bidangs = Bidang::all();
        return view('admin.users.edit', compact('user', 'bidangs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        try {
            $data = [
                'nip' => $request->nip,
                'name' => $request->name,
                'email' => $request->email,
                'bidang_id' => $request->bidang_id,
            ];

            // Only update password if provided
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);

            return redirect()->route('admin.users.index')
                           ->with('success', 'User berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Gagal memperbarui user: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            // Check if user has bookings
            if ($user->bookings()->count() > 0) {
                return redirect()->back()
                               ->with('error', 'Tidak dapat menghapus user yang memiliki riwayat peminjaman!');
            }

            $user->delete();

            return redirect()->route('admin.users.index')
                           ->with('success', 'User berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Gagal menghapus user: ' . $e->getMessage());
        }
    }

    /**
     * Reset user password
     */
    public function resetPassword(User $user)
    {
        try {
            // Generate default password (NIP)
            $defaultPassword = $user->nip;
            
            $user->update([
                'password' => Hash::make($defaultPassword)
            ]);

            return redirect()->back()
                           ->with('success', 'Password berhasil direset ke NIP user!');
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Gagal mereset password: ' . $e->getMessage());
        }
    }

    /**
     * Toggle user status (activate/deactivate)
     */
    public function toggleStatus(User $user)
    {
        try {
            $user->update([
                'is_active' => !$user->is_active
            ]);

            $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
            
            return redirect()->back()
                           ->with('success', "User berhasil {$status}!");
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Gagal mengubah status user: ' . $e->getMessage());
        }
    }
}
