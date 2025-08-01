<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RoomCategory;
use App\Models\Room;
use App\Models\User;
use App\Models\Booking;

class RoomBookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Room Categories
        $categories = [
            [
                'name' => 'Ruang Rapat',
                'description' => 'Ruangan untuk rapat dan pertemuan resmi',
                'color' => '#28a745',
                'icon' => 'fas fa-users',
            ],
            [
                'name' => 'Aula',
                'description' => 'Ruangan besar untuk acara dan seminar',
                'color' => '#17a2b8',
                'icon' => 'fas fa-building',
            ],
            [
                'name' => 'Ruang Kelas',
                'description' => 'Ruangan untuk pelatihan dan pembelajaran',
                'color' => '#ffc107',
                'icon' => 'fas fa-chalkboard-teacher',
            ],
            [
                'name' => 'Laboratorium',
                'description' => 'Laboratorium untuk praktikum dan penelitian',
                'color' => '#dc3545',
                'icon' => 'fas fa-flask',
            ],
            [
                'name' => 'Musholla',
                'description' => 'Tempat ibadah dan kegiatan keagamaan',
                'color' => '#6f42c1',
                'icon' => 'fas fa-mosque',
            ],
        ];

        foreach ($categories as $category) {
            RoomCategory::create($category);
        }

        // Create Rooms
        $rooms = [
            // Ruang Rapat
            [
                'name' => 'Ruang Rapat Utama',
                'code' => 'RRU-001',
                'description' => 'Ruang rapat utama dengan fasilitas lengkap',
                'room_category_id' => 1,
                'capacity' => 50,
                'location' => 'Lantai 3, Gedung A',
                'floor' => 'Lantai 3',
                'facilities' => ['AC', 'Proyektor', 'Sound System', 'WiFi', 'Whiteboard'],
                'status' => 'available',
                'price_per_hour' => 0,
                'notes' => 'Ruang rapat VIP untuk acara penting',
            ],
            [
                'name' => 'Ruang Rapat Kecil',
                'code' => 'RRK-001',
                'description' => 'Ruang rapat untuk pertemuan tim kecil',
                'room_category_id' => 1,
                'capacity' => 15,
                'location' => 'Lantai 2, Gedung A',
                'floor' => 'Lantai 2',
                'facilities' => ['AC', 'TV LED', 'WiFi', 'Meja Bundar'],
                'status' => 'available',
                'price_per_hour' => 0,
            ],

            // Aula
            [
                'name' => 'Aula Serbaguna',
                'code' => 'AULA-001',
                'description' => 'Aula besar untuk acara seminar dan workshop',
                'room_category_id' => 2,
                'capacity' => 300,
                'location' => 'Lantai 1, Gedung B',
                'floor' => 'Lantai 1',
                'facilities' => ['AC', 'Sound System', 'Proyektor', 'Panggung', 'WiFi', 'Kursi Auditorium'],
                'status' => 'available',
                'price_per_hour' => 0,
                'notes' => 'Aula utama untuk acara besar',
            ],

            // Ruang Kelas
            [
                'name' => 'Ruang Kelas A',
                'code' => 'RKA-001',
                'description' => 'Ruang kelas untuk pelatihan pegawai',
                'room_category_id' => 3,
                'capacity' => 40,
                'location' => 'Lantai 2, Gedung C',
                'floor' => 'Lantai 2',
                'facilities' => ['AC', 'Proyektor', 'WiFi', 'Whiteboard', 'Meja Lipat'],
                'status' => 'available',
                'price_per_hour' => 0,
            ],
            [
                'name' => 'Ruang Kelas B',
                'code' => 'RKB-001',
                'description' => 'Ruang kelas dengan setup U-shape',
                'room_category_id' => 3,
                'capacity' => 25,
                'location' => 'Lantai 2, Gedung C',
                'floor' => 'Lantai 2',
                'facilities' => ['AC', 'TV LED', 'WiFi', 'Flipchart'],
                'status' => 'available',
                'price_per_hour' => 0,
            ],

            // Laboratorium
            [
                'name' => 'Lab Komputer',
                'code' => 'LAB-001',
                'description' => 'Laboratorium komputer untuk pelatihan IT',
                'room_category_id' => 4,
                'capacity' => 30,
                'location' => 'Lantai 1, Gedung C',
                'floor' => 'Lantai 1',
                'facilities' => ['AC', '30 PC', 'Proyektor', 'WiFi', 'Server', 'Printer'],
                'status' => 'available',
                'price_per_hour' => 0,
                'notes' => 'Dilengkapi komputer terbaru dengan software lengkap',
            ],

            // Musholla
            [
                'name' => 'Musholla At-Taqwa',
                'code' => 'MSL-001',
                'description' => 'Musholla untuk ibadah dan kajian keagamaan',
                'room_category_id' => 5,
                'capacity' => 100,
                'location' => 'Lantai 1, Gedung A',
                'floor' => 'Lantai 1',
                'facilities' => ['AC', 'Sound System', 'Sajadah', 'Al-Quran', 'Tempat Wudhu'],
                'status' => 'available',
                'price_per_hour' => 0,
                'notes' => 'Tersedia untuk sholat berjamaah dan kajian',
            ],
        ];

        foreach ($rooms as $room) {
            Room::create($room);
        }

        // Create sample bookings (optional)
        $today = now();
        $tomorrow = now()->addDay();

        $sampleBookings = [
            [
                'room_id' => 1,
                'user_id' => 1,
                'title' => 'Rapat Koordinasi Bulanan',
                'description' => 'Rapat koordinasi rutin pegawai Kementerian Agama',
                'contact_person' => 'Ahmad Fauzi',
                'contact_phone' => '081234567890',
                'contact_email' => 'ahmad.fauzi@kemenag.go.id',
                'booking_date' => $tomorrow->format('Y-m-d'),
                'start_time' => '09:00',
                'end_time' => '11:00',
                'participants_count' => 25,
                'equipment_needed' => 'Microphone tambahan',
                'status' => 'approved',
                'approved_at' => now(),
                'approved_by' => 1,
            ],
            [
                'room_id' => 3,
                'user_id' => 1,
                'title' => 'Seminar Nasional Pendidikan Agama',
                'description' => 'Seminar tentang peningkatan kualitas pendidikan agama',
                'contact_person' => 'Dr. Siti Nurhaliza',
                'contact_phone' => '081234567891',
                'contact_email' => 'siti.nurhaliza@kemenag.go.id',
                'booking_date' => $tomorrow->addDays(3)->format('Y-m-d'),
                'start_time' => '08:00',
                'end_time' => '16:00',
                'participants_count' => 200,
                'equipment_needed' => 'Standing banner, sound system wireless',
                'status' => 'pending',
            ],
        ];

        foreach ($sampleBookings as $booking) {
            Booking::create($booking);
        }
    }
}
