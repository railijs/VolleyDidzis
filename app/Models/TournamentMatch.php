<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TournamentMatch extends Model
{
    use HasFactory;

    protected $fillable = [
        'tournament_id',
        'team_a',
        'team_b',
        'team_a_score',
        'team_b_score',
        'winner',          // 'team_a' | 'team_b' | null
        'round',
        'next_match_id',   // points to the next TournamentMatch id
    ];

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    public function nextMatch()
    {
        return $this->belongsTo(TournamentMatch::class, 'next_match_id');
    }
}
