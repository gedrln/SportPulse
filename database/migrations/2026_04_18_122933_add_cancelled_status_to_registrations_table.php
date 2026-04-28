<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        DB::statement("ALTER TABLE events_registrations MODIFY COLUMN status ENUM('pending','approved','rejected','archived','cancelled') DEFAULT 'pending'");
    }

    public function down(): void {
        DB::statement("ALTER TABLE events_registrations MODIFY COLUMN status ENUM('pending','approved','rejected','archived') DEFAULT 'pending'");
    }
};