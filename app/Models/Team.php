<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model {
    use HasFactory;

    protected $primaryKey = 'team_id';

    protected $fillable = [
        'event_id', 'team_name', 'team_size'
    ];

    public function event() {
        return $this->belongsTo(Event::class, 'event_id', 'event_id');
    }

    public function registrations() {
        return $this->hasMany(EventRegistration::class, 'team_id', 'team_id');
    }

    public function approvedCount(): int {
        return $this->registrations()->where('status', 'approved')->count();
    }

    public function isFull(): bool {
        return $this->approvedCount() >= $this->team_size;
    }
}