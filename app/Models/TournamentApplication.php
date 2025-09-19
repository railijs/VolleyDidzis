<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TournamentApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'tournament_id',
        'user_id',
        'team_name',
        'captain_name',
        'email',
    ];

/*************  ✨ Windsurf Command ⭐  *************/
    /**
     * Get the tournament that owns the TournamentApplication
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
/*******  5e86edd5-bbad-4674-a70d-97aacf307541  *******/
    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
