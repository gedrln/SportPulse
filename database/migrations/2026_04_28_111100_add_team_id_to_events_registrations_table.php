<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('events_registrations', function (Blueprint $table) {
            $table->unsignedBigInteger('team_id')->nullable()->after('status');
            $table->foreign('team_id')->references('team_id')->on('teams')->onDelete('set null');
        });
    }

    public function down(): void {
        Schema::table('events_registrations', function (Blueprint $table) {
            $table->dropForeign(['team_id']);
            $table->dropColumn('team_id');
        });
    }
};