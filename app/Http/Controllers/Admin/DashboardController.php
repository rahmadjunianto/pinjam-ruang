<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use App\Models\Bidang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use DateTime;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Get filter parameters
        $month = $request->get('month', Carbon::now()->month);
        $year = $request->get('year', Carbon::now()->year);

        // Get top 10 most frequently booked rooms
        $topRooms = $this->getTopBookedRooms($month, $year);

        // Get top 10 most active bidangs
        $topBidangs = $this->getTopBidangs($month, $year);

        // Get summary statistics
        $statistics = $this->getStatistics($month, $year);

        return view('admin.dashboard', compact('topRooms', 'topBidangs', 'statistics', 'month', 'year'));
    }

    public function getRekapData(Request $request)
    {
        $month = $request->get('month', Carbon::now()->month);
        $year = $request->get('year', Carbon::now()->year);

        return response()->json([
            'topRooms' => $this->getTopBookedRooms($month, $year),
            'topBidangs' => $this->getTopBidangs($month, $year),
            'statistics' => $this->getStatistics($month, $year),
        ]);
    }

    public function exportPdf(Request $request)
    {
        $month = $request->get('month', Carbon::now()->month);
        $year = $request->get('year', Carbon::now()->year);

        $topRooms = $this->getTopBookedRooms($month, $year);
        $topBidangs = $this->getTopBidangs($month, $year);
        $statistics = $this->getStatistics($month, $year);

        $data = [
            'topRooms' => $topRooms,
            'topBidangs' => $topBidangs,
            'statistics' => $statistics,
            'month' => $month,
            'year' => $year,
            'monthName' => DateTime::createFromFormat('!m', $month)->format('F'),
            'generated_at' => Carbon::now()->format('d/m/Y H:i:s')
        ];

        $pdf = Pdf::loadView('admin.dashboard-pdf', $data);
        $filename = "rekap-dashboard-{$year}-{$month}.pdf";

        return $pdf->download($filename);
    }

    private function getTopBookedRooms($month, $year)
    {
        return Booking::select('room_id', DB::raw('COUNT(*) as booking_count'))
            ->with('room')
            ->whereMonth('booking_date', $month)
            ->whereYear('booking_date', $year)
            ->where('status', '!=', 'cancelled')
            ->groupBy('room_id')
            ->orderBy('booking_count', 'desc')
            ->limit(10)
            ->get();
    }

    private function getTopBidangs($month, $year)
    {
        return Booking::select('bidang_id', DB::raw('COUNT(*) as booking_count'))
            ->with('bidang')
            ->whereMonth('booking_date', $month)
            ->whereYear('booking_date', $year)
            ->where('status', '!=', 'cancelled')
            ->groupBy('bidang_id')
            ->orderBy('booking_count', 'desc')
            ->limit(10)
            ->get();
    }

    private function getStatistics($month, $year)
    {
        $totalBookings = Booking::whereMonth('booking_date', $month)
            ->whereYear('booking_date', $year)
            ->count();

        $approvedBookings = Booking::whereMonth('booking_date', $month)
            ->whereYear('booking_date', $year)
            ->where('status', 'approved')
            ->count();

        $pendingBookings = Booking::whereMonth('booking_date', $month)
            ->whereYear('booking_date', $year)
            ->where('status', 'pending')
            ->count();

        $rejectedBookings = Booking::whereMonth('booking_date', $month)
            ->whereYear('booking_date', $year)
            ->where('status', 'rejected')
            ->count();

        return [
            'total' => $totalBookings,
            'approved' => $approvedBookings,
            'pending' => $pendingBookings,
            'rejected' => $rejectedBookings,
        ];
    }
}