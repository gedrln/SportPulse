<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('events', function (Blueprint $table) {
            $table->id('event_id');
            $table->string('event_name');
            $table->string('location');
            $table->dateTime('event_date');
            $table->integer('participants')->default(0);
            $table->string('sport_type')->nullable();
            $table->text('description')->nullable();
            $table->integer('max_participants')->default(50);
            $table->string('status')->default('upcoming');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }
    
    public function down(): void {
        Schema::dropIfExists('events');
    }
};