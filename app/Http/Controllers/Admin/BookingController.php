<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Bidang;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        // Base query
        $query = Booking::with(['room', 'user', 'bidang']);

        // Filter based on user role
        if ($user->role === 'user') {
            // Users can only see their own bookings
            $query->where('user_id', $user->id);
        } elseif ($user->role === 'viewer') {
            // Viewers can only see approved bookings
            $query->where('status', 'approved');
        }
        // Admin can see all bookings (no additional filter)

        $bookings = $query
            ->when(request('search'), function ($query) {
                $search = request('search');
                $query->where(function ($q) use ($search) {
                    $q->where('booking_code', 'like', '%' . $search . '%')
                      ->orWhere('title', 'like', '%' . $search . '%')
                      ->orWhere('contact_person', 'like', '%' . $search . '%')
                      ->orWhere('contact_phone', 'like', '%' . $search . '%')
                      ->orWhere('contact_email', 'like', '%' . $search . '%');
                });
            })
            ->when(request('status'), function ($query) {
                $query->where('status', request('status'));
            })
            ->when(request('room_id'), function ($query) {
                $query->where('room_id', request('room_id'));
            })
            ->when(request('bidang_id'), function ($query) {
                $query->where('bidang_id', request('bidang_id'));
            })
            ->when(request('date_from'), function ($query) {
                $query->where('booking_date', '>=', request('date_from'));
            })
            ->when(request('date_to'), function ($query) {
                $query->where('booking_date', '<=', request('date_to'));
            })
            ->latest('booking_date')
            ->latest('start_time')
            ->paginate(15);

        // Get statistics based on user role
        if ($user->role === 'user') {
            // Users can only see statistics for their own bookings
            $pendingCount = Booking::where('user_id', $user->id)->where('status', 'pending')->count();
            $approvedCount = Booking::where('user_id', $user->id)->where('status', 'approved')->count();
            $todayCount = Booking::where('user_id', $user->id)->whereDate('booking_date', today())->count();
            $totalCount = Booking::where('user_id', $user->id)->count();
        } elseif ($user->role === 'viewer') {
            // Viewers can only see statistics for approved bookings
            $pendingCount = 0; // Viewers cannot see pending bookings
            $approvedCount = Booking::where('status', 'approved')->count();
            $todayCount = Booking::where('status', 'approved')->whereDate('booking_date', today())->count();
            $totalCount = Booking::where('status', 'approved')->count();
        } else {
            // Admin can see all statistics
            $pendingCount = Booking::where('status', 'pending')->count();
            $approvedCount = Booking::where('status', 'approved')->count();
            $todayCount = Booking::whereDate('booking_date', today())->count();
            $totalCount = Booking::count();
        }

        // Get data for filters
        $rooms = Room::orderBy('name')->get();
        $bidangs = Bidang::active()->orderBy('nama')->get();

        return view('admin.bookings.index', compact(
            'bookings',
            'pendingCount',
            'approvedCount',
            'todayCount',
            'totalCount',
            'rooms',
            'bidangs'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rooms = Room::where('is_active', true)->orderBy('name')->get();
        $bidangs = Bidang::active()->orderBy('nama')->get();
        $selectedRoom = request('room') ? Room::find(request('room')) : null;

        return view('admin.bookings.create', compact('rooms', 'bidangs', 'selectedRoom'));
    }

    /**
     * Get available rooms for booking (for non-admin users)
     */
    public function getAvailableRooms()
    {
        $rooms = Room::where('is_active', true)
                     ->with('roomCategory')
                     ->orderBy('name')
                     ->get();

        return view('admin.bookings.available-rooms', compact('rooms'));
    }

    /**
     * Check room availability for booking
     */
    public function checkRoomAvailability(Room $room, Request $request)
    {
        $date = $request->get('date', today()->format('Y-m-d'));

        $existingBookings = Booking::where('room_id', $room->id)
                                  ->where('booking_date', $date)
                                  ->where('status', '!=', 'rejected')
                                  ->where('status', '!=', 'cancelled')
                                  ->orderBy('start_time')
                                  ->get(['start_time', 'end_time', 'title', 'status']);

        return response()->json([
            'room' => $room->only(['id', 'name', 'capacity']),
            'date' => $date,
            'bookings' => $existingBookings,
            'available' => $existingBookings->isEmpty()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'bidang_id' => 'required|exists:bidangs,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'contact_person' => 'required|string|max:255',
            'contact_phone' => 'required|string|max:20',
            'contact_email' => 'nullable|email|max:255',
            'booking_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'participants_count' => 'required|integer|min:1',
            'equipment_needed' => 'nullable|string',
        ]);

        // Check for booking conflicts (same room, date, and overlapping time)
        $conflictingBooking = Booking::where('room_id', $validated['room_id'])
            ->where('booking_date', $validated['booking_date'])
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($validated) {
                $query->where(function ($q) use ($validated) {
                    // New booking starts within existing booking
                    $q->where('start_time', '<=', $validated['start_time'])
                      ->where('end_time', '>', $validated['start_time']);
                })->orWhere(function ($q) use ($validated) {
                    // New booking ends within existing booking
                    $q->where('start_time', '<', $validated['end_time'])
                      ->where('end_time', '>=', $validated['end_time']);
                })->orWhere(function ($q) use ($validated) {
                    // New booking completely contains existing booking
                    $q->where('start_time', '>=', $validated['start_time'])
                      ->where('end_time', '<=', $validated['end_time']);
                });
            })
            ->first();

        if ($conflictingBooking) {
            return back()->withInput()->withErrors([
                'booking_date' => 'Ruangan sudah dibooking pada tanggal dan waktu yang sama. Booking konflik: ' . $conflictingBooking->booking_code
            ]);
        }

        // Check room availability
        $room = Room::findOrFail($validated['room_id']);
        if (!$room->isAvailableAt($validated['booking_date'], $validated['start_time'], $validated['end_time'])) {
            return back()->withInput()->withErrors([
                'booking_date' => 'Ruangan tidak tersedia pada tanggal dan waktu yang dipilih.'
            ]);
        }

        // Check capacity
        if ($validated['participants_count'] > $room->capacity) {
            return back()->withInput()->withErrors([
                'participants_count' => "Jumlah peserta melebihi kapasitas ruangan ({$room->capacity} orang)."
            ]);
        }

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'pending';

        $booking = Booking::create($validated);

        return redirect()->route('admin.bookings.index')
            ->with('success', "Booking {$booking->booking_code} berhasil dibuat.");
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        $booking->load(['room', 'user', 'bidang', 'approvedBy']);
        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        if (!$booking->canBeEdited()) {
            return redirect()->route('admin.bookings.index')
                ->with('error', 'Booking tidak dapat diedit.');
        }

        $rooms = Room::where('is_active', true)->orderBy('name')->get();
        $bidangs = Bidang::active()->orderBy('nama')->get();
        return view('admin.bookings.edit', compact('booking', 'rooms', 'bidangs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        if (!$booking->canBeEdited()) {
            return redirect()->route('admin.bookings.index')
                ->with('error', 'Booking tidak dapat diedit.');
        }

        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'bidang_id' => 'required|exists:bidangs,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'contact_person' => 'required|string|max:255',
            'contact_phone' => 'required|string|max:20',
            'contact_email' => 'nullable|email|max:255',
            'booking_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'participants_count' => 'required|integer|min:1',
            'equipment_needed' => 'nullable|string',
        ]);

        // Check for booking conflicts (same room, date, and overlapping time) - exclude current booking
        $conflictingBooking = Booking::where('room_id', $validated['room_id'])
            ->where('booking_date', $validated['booking_date'])
            ->where('status', '!=', 'cancelled')
            ->where('id', '!=', $booking->id) // Exclude current booking
            ->where(function ($query) use ($validated) {
                $query->where(function ($q) use ($validated) {
                    // New booking starts within existing booking
                    $q->where('start_time', '<=', $validated['start_time'])
                      ->where('end_time', '>', $validated['start_time']);
                })->orWhere(function ($q) use ($validated) {
                    // New booking ends within existing booking
                    $q->where('start_time', '<', $validated['end_time'])
                      ->where('end_time', '>=', $validated['end_time']);
                })->orWhere(function ($q) use ($validated) {
                    // New booking completely contains existing booking
                    $q->where('start_time', '>=', $validated['start_time'])
                      ->where('end_time', '<=', $validated['end_time']);
                });
            })
            ->first();

        if ($conflictingBooking) {
            return back()->withInput()->withErrors([
                'booking_date' => 'Ruangan sudah dibooking pada tanggal dan waktu yang sama. Booking konflik: ' . $conflictingBooking->booking_code
            ]);
        }

        // Check room availability (exclude current booking)
        $room = Room::findOrFail($validated['room_id']);
        if (!$room->isAvailableAt($validated['booking_date'], $validated['start_time'], $validated['end_time'], $booking->id)) {
            return back()->withInput()->withErrors([
                'booking_date' => 'Ruangan tidak tersedia pada tanggal dan waktu yang dipilih.'
            ]);
        }

        // Check capacity
        if ($validated['participants_count'] > $room->capacity) {
            return back()->withInput()->withErrors([
                'participants_count' => "Jumlah peserta melebihi kapasitas ruangan ({$room->capacity} orang)."
            ]);
        }

        $booking->update($validated);

        return redirect()->route('admin.bookings.show', $booking)
            ->with('success', 'Booking berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        if (!$booking->canBeCancelled()) {
            return redirect()->route('admin.bookings.index')
                ->with('error', 'Booking tidak dapat dihapus.');
        }

        $booking->delete();

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking berhasil dihapus.');
    }

    /**
     * Approve booking
     */
    public function approve(Request $request, Booking $booking)
    {
        if ($booking->status !== 'pending') {
            return redirect()->route('admin.bookings.index')
                ->with('error', 'Booking sudah diproses sebelumnya.');
        }

        $booking->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => Auth::id(),
            'approval_notes' => $request->approval_notes,
        ]);

        return redirect()->route('admin.bookings.index')
            ->with('success', "Booking {$booking->booking_code} berhasil disetujui.");
    }

    /**
     * Reject booking
     */
    public function reject(Request $request, Booking $booking)
    {
        if ($booking->status !== 'pending') {
            return redirect()->route('admin.bookings.index')
                ->with('error', 'Booking sudah diproses sebelumnya.');
        }

        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        $booking->update([
            'status' => 'rejected',
            'approved_by' => Auth::id(),
            'rejection_reason' => $request->rejection_reason,
        ]);

        return redirect()->route('admin.bookings.index')
            ->with('success', "Booking {$booking->booking_code} berhasil ditolak.");
    }

    /**
     * Cancel booking
     */
    public function cancel(Booking $booking)
    {
        if (!$booking->canBeCancelled()) {
            return redirect()->route('admin.bookings.index')
                ->with('error', 'Booking tidak dapat dibatalkan.');
        }

        $booking->update(['status' => 'cancelled']);

        return redirect()->route('admin.bookings.index')
            ->with('success', "Booking {$booking->booking_code} berhasil dibatalkan.");
    }

    /**
     * Calendar view
     */
    public function calendar()
    {
        $rooms = Room::active()->orderBy('name')->get();
        $bidangs = Bidang::active()->orderBy('nama')->get();

        return view('admin.bookings.calendar', compact('rooms', 'bidangs'));
    }

    /**
     * Booking reports page
     */
    public function reports(Request $request)
    {
        $query = Booking::with(['room', 'user', 'bidang']);

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('room_id')) {
            $query->where('room_id', $request->room_id);
        }

        if ($request->filled('bidang_id')) {
            $query->where('bidang_id', $request->bidang_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('booking_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('booking_date', '<=', $request->date_to);
        }

        if ($request->filled('period')) {
            $period = $request->period;
            $startDate = Carbon::now();

            switch ($period) {
                case 'today':
                    $query->whereDate('booking_date', Carbon::today());
                    break;
                case 'week':
                    $query->whereBetween('booking_date', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ]);
                    break;
                case 'month':
                    $query->whereMonth('booking_date', Carbon::now()->month)
                          ->whereYear('booking_date', Carbon::now()->year);
                    break;
                case 'year':
                    $query->whereYear('booking_date', Carbon::now()->year);
                    break;
            }
        }

        $bookings = $query->orderBy('booking_date', 'desc')->get();

        // Get filter options
        $rooms = Room::active()->orderBy('name')->get();
        $bidangs = Bidang::active()->orderBy('nama')->get();

        // Statistics
        $stats = [
            'total' => $bookings->count(),
            'approved' => $bookings->where('status', 'approved')->count(),
            'pending' => $bookings->where('status', 'pending')->count(),
            'rejected' => $bookings->where('status', 'rejected')->count(),
            'cancelled' => $bookings->where('status', 'cancelled')->count(),
        ];

        // Room usage statistics
        $roomStats = $bookings->where('status', 'approved')
            ->filter(function($booking) {
                return $booking->room && $booking->room->name;
            })
            ->groupBy('room.name')
            ->map(function ($group) {
                return $group->count();
            })
            ->sortDesc()
            ->take(10);

        // Monthly statistics
        $monthlyStats = $bookings->where('status', 'approved')
            ->groupBy(function ($booking) {
                return Carbon::parse($booking->booking_date)->format('Y-m');
            })
            ->map(function ($group) {
                return $group->count();
            })
            ->sortKeys();

        return view('admin.reports.bookings', compact(
            'bookings',
            'rooms',
            'bidangs',
            'stats',
            'roomStats',
            'monthlyStats'
        ));
    }

    /**
     * Export booking reports
     */
    public function exportReports(Request $request)
    {
        $query = Booking::with(['room', 'user', 'bidang']);

        // Apply same filters as reports method
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('room_id')) {
            $query->where('room_id', $request->room_id);
        }

        if ($request->filled('bidang_id')) {
            $query->where('bidang_id', $request->bidang_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('booking_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('booking_date', '<=', $request->date_to);
        }

        if ($request->filled('period')) {
            $period = $request->period;

            switch ($period) {
                case 'today':
                    $query->whereDate('booking_date', Carbon::today());
                    break;
                case 'week':
                    $query->whereBetween('booking_date', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ]);
                    break;
                case 'month':
                    $query->whereMonth('booking_date', Carbon::now()->month)
                          ->whereYear('booking_date', Carbon::now()->year);
                    break;
                case 'year':
                    $query->whereYear('booking_date', Carbon::now()->year);
                    break;
            }
        }

        $bookings = $query->orderBy('booking_date', 'desc')->get();

        // Generate filename based on filters
        $filename = 'laporan_peminjaman_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($bookings) {
            $file = fopen('php://output', 'w');

            // Add BOM for proper UTF-8 encoding in Excel
            fwrite($file, "\xEF\xBB\xBF");

            // Header row
            fputcsv($file, [
                'Kode Booking',
                'Judul Kegiatan',
                'Ruangan',
                'Bidang',
                'Tanggal',
                'Jam Mulai',
                'Jam Selesai',
                'Pemohon',
                'NIP',
                'Email',
                'Telepon',
                'Status',
                'Dibuat Pada'
            ]);

            // Data rows
            foreach ($bookings as $booking) {
                fputcsv($file, [
                    $booking->booking_code,
                    $booking->title,
                    $booking->room->name,
                    $booking->bidang->nama ?? '-',
                    Carbon::parse($booking->booking_date)->format('d/m/Y'),
                    $booking->start_time,
                    $booking->end_time,
                    $booking->user->name,
                    $booking->user->nip ?? '-',
                    $booking->contact_email,
                    $booking->contact_phone,
                    ucfirst($booking->status),
                    Carbon::parse($booking->created_at)->format('d/m/Y H:i')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
