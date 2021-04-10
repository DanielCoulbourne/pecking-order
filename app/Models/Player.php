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

    public function ballots()
    {
        return $this->hasMany(Ballot::class, 'player_id');
    }

    public function downvotesTaken()
    {
        return $this->hasMany(Ballot::class, 'downvote_id');
    }

    public function upvotesTaken()
    {
        return $this->hasMany(Ballot::class, 'upvote_id');
    }

    public function downvotesTakenInRound(Round $round)
    {
        return $this->downvotesTaken()->where('round_id', $round->id)->get();
    }

    public function upvotesTakenInRound(Round $round)
    {
        return $this->upvotesTaken()->where('round_id', $round->id)->get();
    }

    public function castBallot(Player $upvote, Player $downvote, Round $round = null)
    {
        if ($this->available_ballots < 1) {
            return;
        }

        $round = $round ?? $this->game->currentRound();

        return $this->ballots()->create([
            'upvote_id' => $upvote->id,
            'downvote_id' => $downvote->id,
            'round_id' => $round->id,
        ]);

        $this->decrementAvailableBallots();
    }

    public function incrementAvailableBallots()
    {
        $this->update(['available_ballots' => $this->available_ballots + 1]);
    }

    public function decrementAvailableBallots()
    {
        $this->update(['available_ballots' => $this->available_ballots - 1]);
    }

    // public function getAvailableVotesAttribute()
    // {
    //     return $this->game->rounds()->started()->count();
    // }
}
