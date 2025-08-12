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
                'name' => 'Aula Atas',
                'description' => 'Ruang aula atas untuk acara besar dan rapat pleno',
                'capacity' => 200,
                'location' => 'Lantai 2',
                'facilities' => json_encode([
                    'Proyektor', 'Sound System', 'AC', 'Kursi Auditorium',
                    'Podium', 'Microphone Wireless', 'Layar Besar'
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'AULA02',
                'name' => 'Ruang Aula Bawah',
                'description' => 'Ruang aula bawah untuk acara seminar dan workshop',
                'capacity' => 50,
                'location' => 'Lantai 1',
                'facilities' => json_encode([
                    'Meja Oval', 'AC', 'TV LED', 'Teleconference',
                    'WiFi', 'Dispenser', 'Kulkas Mini'
                ]),
                'is_active' => true,
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
