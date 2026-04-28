<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Event extends Model {
    use HasFactory;

    protected $primaryKey = 'event_id';

    protected $fillable = [
        'event_name', 'location', 'event_date', 'event_end_date',
        'participants', 'sport_type', 'description',
        'max_participants', 'status', 'created_by'
    ];

    protected function casts(): array {
        return [
            'event_date'     => 'datetime',
            'event_end_date' => 'datetime',
        ];
    }

    public function getRouteKeyName() {
        return 'event_id';
    }

    public function registrations() {
        return $this->hasMany(EventRegistration::class, 'event_id', 'event_id');
    }

    public function teams() {
        return $this->hasMany(Team::class, 'event_id', 'event_id');
    }

    public function creator() {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Count only approved registrations (for participants column)
    public function approvedCount(): int {
        return $this->registrations()->where('status', 'approved')->count();
    }

    // Count all active registrations (pending + approved) for slot display
    public function activeRegistrationsCount(): int {
        return $this->registrations()
            ->whereIn('status', ['pending', 'approved'])
            ->count();
    }

    // Available slots = max - active (pending + approved)
    public function availableSlots(): int {
        return max(0, $this->max_participants - $this->activeRegistrationsCount());
    }

    // Event is full when active registrations >= max_participants
    public function isFull(): bool {
        return $this->activeRegistrationsCount() >= $this->max_participants;
    }

    public function syncParticipants(): void {
        $this->update(['participants' => $this->approvedCount()]);
    }

    // Default team sizes per sport
    public static function defaultTeamSize(string $sport): int {
        return match(strtolower($sport)) {
            'basketball' => 5,
            'volleyball' => 6,
            'football'   => 11,
            'badminton'  => 2,
            'pickle ball'=> 2,
            'tennis'     => 2,
            'swimming'   => 1,
            'running'    => 1,
            default      => 5,
        };
    }
}