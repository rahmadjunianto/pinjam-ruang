<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rooms = [
            [
                'code' => 'AULA01',
                'name' => 'Aula Utama',
                'description' => 'Ruang aula utama untuk acara besar dan rapat pleno',
                'capacity' => 200,
                'location' => 'Lantai 1',
                'facilities' => json_encode([
                    'Proyektor', 'Sound System', 'AC', 'Kursi Auditorium',
                    'Podium', 'Microphone Wireless', 'Layar Besar'
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'RRK01',
                'name' => 'Ruang Rapat Kepala Kantor',
                'description' => 'Ruang rapat khusus untuk kepala kantor dan pimpinan',
                'capacity' => 15,
                'location' => 'Lantai 2',
                'facilities' => json_encode([
                    'Meja Oval', 'AC', 'TV LED', 'Teleconference',
                    'WiFi', 'Dispenser', 'Kulkas Mini'
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'RRP01',
                'name' => 'Ruang Rapat Bidang Pendidikan',
                'description' => 'Ruang rapat untuk bidang pendidikan madrasah dan diniyah',
                'capacity' => 30,
                'location' => 'Lantai 2',
                'facilities' => json_encode([
                    'Meja Persegi', 'AC', 'Proyektor', 'Whiteboard',
                    'WiFi', 'Sound System Mini'
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'RRH01',
                'name' => 'Ruang Rapat Bidang Haji',
                'description' => 'Ruang rapat untuk bidang penyelenggaraan haji dan umrah',
                'capacity' => 25,
                'location' => 'Lantai 2',
                'facilities' => json_encode([
                    'Meja U-Shape', 'AC', 'TV LED', 'Whiteboard',
                    'WiFi', 'Flipchart'
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'RSG01',
                'name' => 'Ruang Serba Guna',
                'description' => 'Ruang multiguna untuk berbagai kegiatan dan pelatihan',
                'capacity' => 80,
                'location' => 'Lantai 1',
                'facilities' => json_encode([
                    'Meja Lipat', 'AC', 'Proyektor', 'Sound System',
                    'Panggung Kecil', 'WiFi', 'Layar Proyektor'
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'RDA01',
                'name' => 'Ruang Diskusi A',
                'description' => 'Ruang diskusi kecil untuk meeting tim atau koordinasi',
                'capacity' => 12,
                'location' => 'Lantai 1',
                'facilities' => json_encode([
                    'Meja Bundar', 'AC', 'TV LED', 'Whiteboard',
                    'WiFi', 'Kursi Empuk'
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'RDB01',
                'name' => 'Ruang Diskusi B',
                'description' => 'Ruang diskusi alternatif untuk meeting kecil',
                'capacity' => 10,
                'location' => 'Lantai 1',
                'facilities' => json_encode([
                    'Meja Persegi', 'AC', 'TV LED', 'Whiteboard',
                    'WiFi', 'Kursi Kantor'
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'RWS01',
                'name' => 'Ruang Workshop',
                'description' => 'Ruang khusus untuk workshop dan pelatihan intensif',
                'capacity' => 40,
                'location' => 'Lantai 1',
                'facilities' => json_encode([
                    'Meja Workshop', 'AC', 'Proyektor', 'Sound System',
                    'Whiteboard Besar', 'WiFi', 'Colokan Listrik'
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'RSM01',
                'name' => 'Ruang Seminar',
                'description' => 'Ruang khusus untuk seminar dan presentasi',
                'capacity' => 60,
                'location' => 'Lantai 2',
                'facilities' => json_encode([
                    'Kursi Theater', 'AC', 'Proyektor HD', 'Sound System',
                    'Podium', 'Microphone', 'Layar Besar', 'WiFi'
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'RARS01',
                'name' => 'Ruang Arsip (Non-Aktif)',
                'description' => 'Ruang yang sedang direnovasi untuk arsip',
                'capacity' => 20,
                'location' => 'Lantai 3',
                'facilities' => json_encode([
                    'Lemari Arsip', 'Ventilasi'
                ]),
                'is_active' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($rooms as $room) {
            Room::create($room);
        }

        $this->command->info('🏠 ' . count($rooms) . ' ruangan berhasil dibuat!');

        // Tampilkan statistik
        $activeRooms = Room::where('is_active', true)->count();
        $totalCapacity = Room::where('is_active', true)->sum('capacity');

        $this->command->table(
            ['Statistik', 'Jumlah'],
            [
                ['Total Ruangan', count($rooms)],
                ['Ruangan Aktif', $activeRooms],
                ['Total Kapasitas', $totalCapacity . ' orang'],
            ]
        );
    }
}
