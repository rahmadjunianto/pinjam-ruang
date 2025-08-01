<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use App\Models\Bidang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan ada data user, room, dan bidang
        $users = User::all();
        $rooms = Room::all();
        $bidangs = Bidang::all();

        if ($users->isEmpty() || $rooms->isEmpty() || $bidangs->isEmpty()) {
            $this->command->warn('Pastikan sudah ada data User, Room, dan Bidang sebelum menjalankan BookingSeeder');
            return;
        }

        // Array untuk tipe acara
        $eventTypes = [
            'Rapat Koordinasi',
            'Rapat Evaluasi',
            'Workshop',
            'Seminar',
            'Pelatihan',
            'Rapat Pleno',
            'Presentasi',
            'Diskusi',
            'Sosialisasi',
            'Rapat Kerja'
        ];

        // Array untuk keperluan
        $purposes = [
            'Rapat koordinasi bulanan bidang',
            'Evaluasi program kerja triwulan',
            'Workshop peningkatan kapasitas SDM',
            'Seminar nasional pendidikan Islam',
            'Pelatihan teknologi informasi',
            'Rapat pleno pimpinan',
            'Presentasi proposal program',
            'Diskusi kebijakan pendidikan',
            'Sosialisasi peraturan baru',
            'Rapat kerja tahunan'
        ];

        // Buat booking untuk bulan ini dan beberapa bulan ke depan
        $bookings = [];

        for ($i = 0; $i < 50; $i++) {
            // Random tanggal antara hari ini dan 3 bulan ke depan
            $startDate = Carbon::now()->addDays(rand(-30, 90));

            // Pastikan bukan weekend untuk beberapa booking
            if (rand(1, 100) <= 80) { // 80% booking di hari kerja
                while ($startDate->isWeekend()) {
                    $startDate->addDay();
                }
            }

            // Random jam mulai antara 08:00 - 16:00
            $startHour = rand(8, 16);
            $startMinute = rand(0, 1) * 30; // 00 atau 30 menit
            $startTime = sprintf('%02d:%02d', $startHour, $startMinute);

            // Durasi acara antara 1-4 jam
            $duration = rand(1, 4);
            $endTime = Carbon::createFromFormat('H:i', $startTime)->addHours($duration)->format('H:i');

            // Jika lewat jam kerja, sesuaikan
            if ($endTime > '17:00') {
                $endTime = '17:00';
            }

            $user = $users->random();
            $room = $rooms->random();
            $bidang = $bidangs->random();
            $eventType = $eventTypes[array_rand($eventTypes)];
            $purpose = $purposes[array_rand($purposes)];

            // Status booking
            $statuses = ['pending', 'approved', 'rejected', 'completed'];
            $weights = [10, 60, 10, 20]; // 10% pending, 60% approved, 10% rejected, 20% completed
            $status = $this->weightedRandom($statuses, $weights);

            // Jika tanggal sudah lewat, status tidak boleh pending
            if ($startDate->isPast() && $status === 'pending') {
                $status = $this->weightedRandom(['approved', 'completed'], [30, 70]);
            }

            $bookings[] = [
                'booking_code' => 'BK' . date('Y') . sprintf('%04d', $i + 1),
                'user_id' => $user->id,
                'room_id' => $room->id,
                'bidang_id' => $bidang->id,
                'title' => $eventType . ' - ' . $bidang->nama,
                'description' => $purpose,
                'contact_person' => $user->name,
                'contact_phone' => '081' . rand(10000000, 99999999),
                'contact_email' => $user->email,
                'booking_date' => $startDate->format('Y-m-d'),
                'start_time' => $startTime,
                'end_time' => $endTime,
                'participants_count' => rand(5, min($room->capacity, 50)),
                'equipment_needed' => 'Proyektor, Sound System, AC',
                'status' => $status,
                'total_cost' => null, // Gratis untuk instansi pemerintah
                'approval_notes' => in_array($status, ['approved', 'completed']) ? 'Disetujui sesuai jadwal' : null,
                'rejection_reason' => $status === 'rejected' ? 'Ruangan sudah dibooking untuk waktu yang sama' : null,
                'approved_by' => in_array($status, ['approved', 'completed']) ? $users->random()->id : null,
                'approved_at' => in_array($status, ['approved', 'completed']) ? $startDate->subDays(rand(1, 7)) : null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert booking dalam batch
        collect($bookings)->chunk(10)->each(function ($chunk) {
            Booking::insert($chunk->toArray());
        });

        $this->command->info('📅 ' . count($bookings) . ' booking berhasil dibuat!');

        // Tampilkan statistik
        $this->showBookingStats();
    }

    /**
     * Weighted random selection
     */
    private function weightedRandom($values, $weights)
    {
        $totalWeight = array_sum($weights);
        $random = rand(1, $totalWeight);

        $currentWeight = 0;
        foreach ($values as $index => $value) {
            $currentWeight += $weights[$index];
            if ($random <= $currentWeight) {
                return $value;
            }
        }

        return $values[0];
    }

    /**
     * Show booking statistics
     */
    private function showBookingStats()
    {
        $stats = [
            'Total Booking' => Booking::count(),
            'Pending' => Booking::where('status', 'pending')->count(),
            'Approved' => Booking::where('status', 'approved')->count(),
            'Rejected' => Booking::where('status', 'rejected')->count(),
            'Completed' => Booking::where('status', 'completed')->count(),
        ];

        $this->command->table(['Status', 'Jumlah'], collect($stats)->map(function ($count, $status) {
            return [$status, $count];
        })->toArray());
    }
}
