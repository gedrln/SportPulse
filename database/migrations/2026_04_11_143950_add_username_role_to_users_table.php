<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('users', function (Blueprint $table) {
            // Add username column AFTER id
            $table->string('username')->unique()->after('id');
            // Add role column AFTER email
            $table->string('role')->default('user')->after('email');
        });
    }
    
    public function down(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['username', 'role']);
        });
    }
};


