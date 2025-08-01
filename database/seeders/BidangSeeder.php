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
                'kode' => 'SEKT',
                'nama' => 'Sekretariat',
                'deskripsi' => 'Melaksanakan tugas kesekretariatan, keprotokolan, dan administrasi umum',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'PMAD',
                'nama' => 'Bidang Pendidikan Madrasah',
                'deskripsi' => 'Menyelenggarakan pembinaan pendidikan madrasah ibtidaiyah, tsanawiyah, dan aliyah',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'PDPP',
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
                'kode' => 'UAPS',
                'nama' => 'Bidang Urusan Agama Islam dan Pembinaan Syariah',
                'deskripsi' => 'Melaksanakan pelayanan kehidupan beragama dan pembinaan syariah Islam',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'BMAS',
                'nama' => 'Bidang Bimbingan Masyarakat Islam',
                'deskripsi' => 'Menyelenggarakan bimbingan keagamaan kepada masyarakat Islam',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'PAHU',
                'nama' => 'Bidang Penyelenggaraan Haji dan Umrah',
                'deskripsi' => 'Melaksanakan pelayanan dan pembinaan penyelenggaraan ibadah haji dan umrah',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'SUTU',
                'nama' => 'Sub Bagian Tata Usaha',
                'deskripsi' => 'Melaksanakan urusan kepegawaian, keuangan, rumah tangga, dan arsip',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'SMAD',
                'nama' => 'Seksi Pendidikan Madrasah',
                'deskripsi' => 'Melaksanakan pembinaan teknis pendidikan madrasah',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'SARP',
                'nama' => 'Seksi Sarana Prasarana Pendidikan',
                'deskripsi' => 'Mengelola sarana dan prasarana pendidikan keagamaan',
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
