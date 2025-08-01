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

        // Buat admin user
        User::factory()->create([
            'name' => 'Admin Kemenag',
            'email' => 'admin@kemenag.go.id',
            'password' => bcrypt('password'),
        ]);

        // Buat beberapa user tambahan
        User::factory(5)->create();

        $this->command->info('👥 Users berhasil dibuat');

        // Jalankan seeder lainnya dalam urutan yang benar
        $this->call([
            BidangSeeder::class,
            RoomSeeder::class,
            BookingSeeder::class,
        ]);

        $this->command->info('✅ Database seeding selesai!');
    }
}
