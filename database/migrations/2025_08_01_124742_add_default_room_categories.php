<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\RoomCategory;
use App\Models\Room;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create default room categories
        $categories = [
            [
                'name' => 'Ruang Rapat',
                'description' => 'Ruangan untuk rapat dan pertemuan',
                'color' => '#007bff',
                'icon' => 'fas fa-users',
                'is_active' => true,
            ],
            [
                'name' => 'Aula',
                'description' => 'Aula untuk acara besar dan seminar',
                'color' => '#28a745',
                'icon' => 'fas fa-theater-masks',
                'is_active' => true,
            ],
            [
                'name' => 'Ruang Kelas',
                'description' => 'Ruangan untuk pelatihan dan pembelajaran',
                'color' => '#ffc107',
                'icon' => 'fas fa-chalkboard-teacher',
                'is_active' => true,
            ],
            [
                'name' => 'Laboratorium',
                'description' => 'Laboratorium komputer dan teknis',
                'color' => '#6f42c1',
                'icon' => 'fas fa-flask',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            RoomCategory::create($category);
        }

        // Update existing rooms to have room_category_id
        $defaultCategory = RoomCategory::where('name', 'Ruang Rapat')->first();
        
        if ($defaultCategory) {
            Room::whereNull('room_category_id')->update([
                'room_category_id' => $defaultCategory->id
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove the categories
        RoomCategory::whereIn('name', ['Ruang Rapat', 'Aula', 'Ruang Kelas', 'Laboratorium'])->delete();
    }
};
