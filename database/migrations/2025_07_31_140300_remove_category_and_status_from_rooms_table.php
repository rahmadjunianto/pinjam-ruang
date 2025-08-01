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
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropForeign(['room_category_id']);
            $table->dropColumn(['room_category_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->foreignId('room_category_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('status', ['available', 'maintenance', 'unavailable'])->default('available');
        });
    }
};
