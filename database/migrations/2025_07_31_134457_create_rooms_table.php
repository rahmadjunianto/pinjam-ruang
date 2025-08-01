<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique(); // Kode ruangan (misal: R001, LAB-01)
            $table->text('description')->nullable();
            $table->foreignId('room_category_id')->constrained()->onDelete('cascade');
            $table->integer('capacity'); // Kapasitas orang
            $table->string('location'); // Lokasi fisik ruangan
            $table->string('floor')->nullable(); // Lantai
            $table->json('facilities')->nullable(); // Fasilitas yang tersedia (AC, Projector, etc)
            $table->string('image')->nullable(); // Foto ruangan
            $table->enum('status', ['available', 'maintenance', 'unavailable'])->default('available');
            $table->decimal('price_per_hour', 10, 2)->nullable(); // Harga per jam jika berbayar
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
