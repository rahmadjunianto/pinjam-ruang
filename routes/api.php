<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// API endpoint untuk kalender
Route::get('/bookings-calendar', function (Request $request) {
    $query = \App\Models\Booking::with(['room', 'bidang', 'user']);

    // Date range filter
    if ($request->has('start') && $request->has('end')) {
        $start = \Carbon\Carbon::parse($request->start)->startOfDay();
        $end = \Carbon\Carbon::parse($request->end)->endOfDay();
        $query->whereBetween('booking_date', [$start, $end]);
    } else {
        // Default range: 1 month before to 2 months after
        $query->where('booking_date', '>=', now()->subMonths(1))
              ->where('booking_date', '<=', now()->addMonths(2));
    }

    // Additional filters
    if ($request->filled('room_id')) {
        $query->where('room_id', $request->room_id);
    }

    if ($request->filled('bidang_id')) {
        $query->where('bidang_id', $request->bidang_id);
    }

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    $bookings = $query->orderBy('booking_date')->orderBy('start_time')->get();

    $events = $bookings->map(function ($booking) {
        // Format datetime untuk FullCalendar
        $bookingDate = \Carbon\Carbon::parse($booking->booking_date)->format('Y-m-d');
        $startTime = \Carbon\Carbon::parse($booking->start_time)->format('H:i:s');
        $endTime = \Carbon\Carbon::parse($booking->end_time)->format('H:i:s');
        $startDateTime = $bookingDate . 'T' . $startTime;
        $endDateTime = $bookingDate . 'T' . $endTime;

        // Determine color based on status
        $color = '#6c757d'; // default gray
        switch ($booking->status) {
            case 'approved':
                $color = '#28a745'; // green
                break;
            case 'pending':
                $color = '#ffc107'; // yellow
                break;
            case 'rejected':
                $color = '#dc3545'; // red
                break;
            case 'cancelled':
                $color = '#6c757d'; // gray
                break;
        }

        return [
            'title' => $booking->title,
            'start' => $startDateTime,
            'end' => $endDateTime,
            'color' => $color,
            'borderColor' => $color,
            'classNames' => ['booking-event'],
            'extendedProps' => [
                'booking_id' => $booking->id,
                'booking_code' => $booking->booking_code,
                'room' => $booking->room->name ?? 'N/A',
                'bidang' => $booking->bidang->nama ?? 'N/A',
                'bidang_kode' => $booking->bidang->kode ?? 'N/A',
                'pic' => $booking->contact_person,
                'contact' => $booking->contact_phone . ($booking->contact_email ? ' / ' . $booking->contact_email : ''),
                'status' => ucfirst($booking->status),
                'time' => \Carbon\Carbon::parse($booking->start_time)->format('H:i') . ' - ' . \Carbon\Carbon::parse($booking->end_time)->format('H:i'),
                'participants_count' => $booking->participants_count,
                'description' => $booking->description,
                'user_name' => $booking->user->name ?? 'N/A'
            ]
        ];
    });

    return response()->json($events);
});
