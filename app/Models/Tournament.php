<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'location',
        'max_teams',
        'team_size',
        'gender_type',
        'min_boys',
        'min_girls',
        'min_age',
        'max_age',
        'recommendations',
        'status',
        'creator_id'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function applications()
    {
        return $this->hasMany(TournamentApplication::class);
    }

    public function matches()
    {
        return $this->hasMany(TournamentMatch::class);
    }
}
