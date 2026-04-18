<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model {
    use HasFactory;

    protected $primaryKey = 'event_id';

    protected $fillable = [
        'event_name', 'location', 'event_date', 'event_end_date',
        'participants', 'sport_type', 'description', 'max_participants', 'status', 'created_by'
    ];

    protected function casts(): array {
        return [
            'event_date'     => 'datetime',
            'event_end_date' => 'datetime',
        ];
    }

    public function getRouteKeyName()
    {
        return 'event_id';
    }

    public function registrations() {
        return $this->hasMany(EventRegistration::class, 'event_id', 'event_id');
    }

    public function creator() {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approvedCount(): int {
        return $this->registrations()->where('status', 'approved')->count();
    }

    public function isFull(): bool {
        return $this->participants >= $this->max_participants;
    }

    public function syncParticipants(): void {
        $this->update(['participants' => $this->approvedCount()]);
    }
}