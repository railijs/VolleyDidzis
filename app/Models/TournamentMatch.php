<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TournamentMatch extends Model
{
    use HasFactory;

    protected $fillable = [
        'tournament_id',
        'round',
        'index_in_round',
        'participant_a_application_id',
        'participant_b_application_id',
        'score_a',
        'score_b',
        'winner_slot',
        'next_match_id',
        'next_slot',
        'status',
        'scheduled_at',
    ];

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    // A-side participant (from tournament_applications)
    public function participantA()
    {
        return $this->belongsTo(\App\Models\TournamentApplication::class, 'participant_a_application_id');
    }

    // B-side participant (from tournament_applications)
    public function participantB()
    {
        return $this->belongsTo(\App\Models\TournamentApplication::class, 'participant_b_application_id');
    }

    public function nextMatch()
    {
        return $this->belongsTo(self::class, 'next_match_id');
    }

    // Convenience accessor used in Blade to show champion name
    public function winnerApplication()
    {
        if ($this->winner_slot === 'A') return $this->participantA;
        if ($this->winner_slot === 'B') return $this->participantB;
        return null;
    }
}
