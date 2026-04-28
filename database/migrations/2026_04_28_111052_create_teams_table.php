<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('teams', function (Blueprint $table) {
            $table->id('team_id');
            $table->unsignedBigInteger('event_id');
            $table->foreign('event_id')->references('event_id')->on('events')->onDelete('cascade');
            $table->string('team_name');
            $table->integer('team_size')->default(5);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('teams');
    }
};