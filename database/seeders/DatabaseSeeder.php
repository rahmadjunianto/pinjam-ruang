<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('🌱 Mulai seeding database...');

        // Jalankan seeder dalam urutan yang benar - bidang dulu
        $this->call([
            BidangSeeder::class,
        ]);

        // Buat admin user
        User::factory()->create([
            'name' => 'Admin Kemenag',
            'email' => 'admin@kemenag.go.id',
            'nip' => '198501012006011001',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'is_active' => true,
            'bidang_id' => 1,
        ]);

        // Buat user biasa
        User::factory()->create([
            'name' => 'User Kemenag',
            'email' => 'user@kemenag.go.id',
            'nip' => '198502012007012001',
            'password' => bcrypt('password'),
            'role' => 'user',
            'is_active' => true,
            'bidang_id' => 1,
        ]);

        // Buat viewer
        User::factory()->create([
            'name' => 'Viewer Kemenag',
            'email' => 'viewer@kemenag.go.id',
            'nip' => '198503012008013001',
            'password' => bcrypt('password'),
            'role' => 'viewer',
            'is_active' => true,
            'bidang_id' => 1,
        ]);

        // Buat beberapa user tambahan
        User::factory(3)->create();

        $this->command->info('👥 Users berhasil dibuat');

        // Jalankan seeder lainnya
        $this->call([
            RoomSeeder::class,
            BookingSeeder::class,
        ]);

        $this->command->info('✅ Database seeding selesai!');
    }
}
