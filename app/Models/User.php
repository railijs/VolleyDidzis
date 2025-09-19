<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // add role to be mass assignable
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Check if user is admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is a regular user.
     */
    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    public function tournaments()
{
    return $this->belongsToMany(Tournament::class, 'tournament_user')
                ->withTimestamps();
}

public function tournamentApplications()
{
    return $this->hasMany(\App\Models\TournamentApplication::class);
}

public function appliedTournaments()
{
    return $this->hasManyThrough(
        \App\Models\Tournament::class,
        \App\Models\TournamentApplication::class,
        'user_id',       // Foreign key on applications table...
        'id',            // Foreign key on tournaments table...
        'id',            // Local key on users table...
        'tournament_id'  // Local key on applications table...
    );
}

}
