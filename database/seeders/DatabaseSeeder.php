<?php
namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder {
    public function run(): void {
        // ADMIN - Password is ENCRYPTED (HASHED)
        User::create([
            'name' => 'Admin User',
            'username' => 'admin',
            'email' => 'admin@sportpulse.com',
            'password' => Hash::make('password'),  // ← ENCRYPTED
            'role' => 'admin',
        ]);

        // REGULAR USER - Password is PLAIN TEXT (NOT encrypted)
        User::create([
            'name' => 'Juan Dela Cruz',
            'username' => 'juan',
            'email' => 'juan@sportpulse.com',
            'password' => 'password',  // ← PLAIN TEXT, NO HASH
            'role' => 'user',
        ]);

        $adminId = User::where('role', 'admin')->first()->id;

        $events = [
            ['event_name' => 'City Basketball Tournament 2025', 'location' => 'Quezon City Sports Complex', 'event_date' => now()->addDays(14), 'max_participants' => 32, 'sport_type' => 'Basketball', 'description' => 'Annual inter-barangay basketball tournament.', 'created_by' => $adminId],
            ['event_name' => 'Fun Run 5K', 'location' => 'Rizal Park, Davao City', 'event_date' => now()->addDays(30), 'max_participants' => 200, 'sport_type' => 'Running', 'description' => 'Community fun run promoting health.', 'created_by' => $adminId],
            ['event_name' => 'Swimming Championship', 'location' => 'PhilSports Arena Pool', 'event_date' => now()->addDays(7), 'max_participants' => 50, 'sport_type' => 'Swimming', 'description' => 'Regional swimming competition.', 'created_by' => $adminId],
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }
}