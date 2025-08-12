<?php

namespace Database\Seeders;

use App\Models\Bidang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BidangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bidangs = [
            [
                'kode' => 'PENDMA',
                'nama' => 'Bidang Pendidikan Madrasah',
                'deskripsi' => 'Menyelenggarakan pembinaan pendidikan madrasah ibtidaiyah, tsanawiyah, dan aliyah',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'PONTREN',
                'nama' => 'Bidang Pendidikan Diniyah dan Pondok Pesantren',
                'deskripsi' => 'Melaksanakan pembinaan pendidikan diniyah formal, nonformal, dan pondok pesantren',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'PAIS',
                'nama' => 'Bidang Pendidikan Agama Islam',
                'deskripsi' => 'Menyelenggarakan pembinaan pendidikan agama Islam di sekolah umum',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'PHU',
                'nama' => 'Bidang Penyelenggaraan Haji dan Umrah',
                'deskripsi' => 'Melaksanakan pelayanan dan pembinaan penyelenggaraan ibadah haji dan umrah',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'TU',
                'nama' => 'Sub Bagian Tata Usaha',
                'deskripsi' => 'Melaksanakan urusan kepegawaian, keuangan, rumah tangga, dan arsip',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'PENZAWA',
                'nama' => 'Seksi Penyelenggaraan Zakat dan Wakaf',
                'deskripsi' => 'Mengelola zakat, infak, sedekah, dan wakaf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'BIMAS',
                'nama' => 'Seksi Bimbingan Masyarakat Islam',
                'deskripsi' => 'Menyelenggarakan bimbingan keagamaan kepada masyarakat Islam',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($bidangs as $bidang) {
            Bidang::create($bidang);
        }

        $this->command->info('🏢 ' . count($bidangs) . ' bidang berhasil dibuat!');
    }
}
