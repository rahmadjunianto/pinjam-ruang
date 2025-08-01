<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UpdateUserNipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update existing users without NIP
        $users = User::whereNull('nip')->orWhere('nip', '')->get();
        
        foreach ($users as $user) {
            // Generate a temporary NIP based on ID and current timestamp
            $nip = '19750101' . str_pad($user->id, 10, '0', STR_PAD_LEFT);
            $user->update(['nip' => $nip]);
        }
        
        // Update admin user with specific NIP if exists
        $adminUser = User::where('email', 'admin@admin.com')->first();
        if ($adminUser) {
            $adminUser->update(['nip' => '198001011980011001']);
        }
        
        echo "Updated " . $users->count() . " users with NIP\n";
    }
}
