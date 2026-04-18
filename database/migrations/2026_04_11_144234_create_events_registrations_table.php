<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('events_registrations', function (Blueprint $table) {
            $table->id('registration_id');
            
            // FOREIGN KEY to users.username (MUST exist first!)
            $table->string('user_name');
            $table->foreign('user_name')
                  ->references('username')
                  ->on('users')
                  ->onDelete('cascade');
            
            // FOREIGN KEY to events.event_id
            $table->unsignedBigInteger('event_id');
            $table->foreign('event_id')
                  ->references('event_id')
                  ->on('events')
                  ->onDelete('cascade');
            
            $table->timestamp('registration_date')->useCurrent();
            $table->string('participant_name');
            $table->string('contact_number');
            $table->string('status')->default('pending');
            $table->timestamps();
            
            // Prevent duplicate registrations
            $table->unique(['user_name', 'event_id']);
        });
    }
    
    public function down(): void {
        Schema::dropIfExists('events_registrations');
    }
};