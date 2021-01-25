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

    public function teams()
    {
        return $this->belongsToMany(Team::class);
    }

    public function team()
    {
        if (! $this->game->currentRound()) {
            return null;
        }

        return $this->game->currentRound()->teams()->whereIn('teams.id', $this->teams()->get()->pluck('id'))->first();
    }

    public function targets()
    {
        return $this->game->players()->whereDoesntHave('teams', fn ($query) => $query->where('teams.id', $this->team()->id))->get();
    }

    public function votes()
    {
        return $this->hasMany(Vote::class, 'voter_id');
    }

    public function votesFor()
    {
        return $this->hasMany(Vote::class, 'target_id');
    }

    public function getAvailableVotesAttribute()
    {
        return $this->game->rounds()->started()->count();
    }
}
