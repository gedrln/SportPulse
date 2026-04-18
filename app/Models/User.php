<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
    use HasFactory, Notifiable;

    protected $fillable = ['username', 'name', 'email', 'password', 'role'];
    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array {
        return [
            'email_verified_at' => 'datetime',
            // REMOVED: 'password' => 'hashed' - so passwords are NOT auto-hashed
        ];
    }

    public function isAdmin(): bool {
        return $this->role === 'admin';
    }

    public function registrations() {
        return $this->hasMany(EventRegistration::class, 'user_name', 'username');
    }

    public function createdEvents() {
        return $this->hasMany(Event::class, 'created_by');
    }
}