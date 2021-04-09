<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Player extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function game() : BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function teammates()
    {
        return $this->game->players()
            ->where('team_id', $this->team_id)
            ->where('id', '!=', $this->id);
    }

    public function enemies()
    {
        return $this->game->players()
            ->where('team_id', '!=', $this->team_id)
            ->where('id', '!=', $this->id);
    }

    public function targets()
    {
        return $this->enemies();
    }

    public function votes()
    {
        return $this->hasMany(Vote::class, 'voter_id');
    }

    public function votesTaken()
    {
        return $this->hasMany(Vote::class, 'target_id');
    }

    public function votesTakenInRound(Round $round)
    {
        return $this->votesTaken()->where('round_id', $round->id)->get();
    }

    public function castVote(Player $target, Round $round = null)
    {
        $round = $round ?? $this->game->currentRound();

        return $this->votes()->create([
            'target_id' => $target->id,
            'round_id' => $round->id,
        ]);
    }

    public function getAvailableVotesAttribute()
    {
        return $this->game->rounds()->started()->count();
    }
}
