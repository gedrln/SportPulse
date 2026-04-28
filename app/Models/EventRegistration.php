<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventRegistration extends Model {
    use HasFactory;

    protected $table = 'events_registrations';
    protected $primaryKey = 'registration_id';

    protected $fillable = [
        'user_name', 'event_id', 'registration_date',
        'participant_name', 'contact_number', 'status', 'team_id'
    ];

    protected function casts(): array {
        return [
            'registration_date' => 'datetime',
        ];
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_name', 'username');
    }

    public function event() {
        return $this->belongsTo(Event::class, 'event_id', 'event_id');
    }

    public function team() {
        return $this->belongsTo(Team::class, 'team_id', 'team_id');
    }
}