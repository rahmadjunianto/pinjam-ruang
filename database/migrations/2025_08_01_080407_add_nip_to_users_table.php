<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nip')->nullable()->after('id');
        });

        // Update existing users to have temporary NIP values
        DB::table('users')->update(['nip' => DB::raw('CONCAT("TEMP", id)')]);

        // Now make the column unique and non-nullable
        Schema::table('users', function (Blueprint $table) {
            $table->string('nip')->unique()->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('nip');
        });
    }
};
