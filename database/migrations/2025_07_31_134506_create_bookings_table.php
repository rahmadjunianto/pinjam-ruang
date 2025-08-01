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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_code')->unique(); // Kode booking otomatis
            $table->foreignId('room_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Peminjam
            $table->string('title'); // Judul acara/kegiatan
            $table->text('description')->nullable();
            $table->string('contact_person'); // PIC
            $table->string('contact_phone');
            $table->string('contact_email');
            $table->date('booking_date'); // Tanggal peminjaman
            $table->time('start_time'); // Jam mulai
            $table->time('end_time'); // Jam selesai
            $table->integer('participants_count'); // Jumlah peserta
            $table->text('equipment_needed')->nullable(); // Peralatan yang dibutuhkan
            $table->enum('status', ['pending', 'approved', 'rejected', 'completed', 'cancelled'])->default('pending');
            $table->decimal('total_cost', 10, 2)->nullable(); // Total biaya jika berbayar
            $table->text('approval_notes')->nullable(); // Catatan persetujuan
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
