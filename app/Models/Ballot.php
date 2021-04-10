<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Ballot extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function player() : BelongsTo
    {
        return $this->belongsTo(Player::class, 'player_id');
    }

    public function upTarget() : BelongsTo
    {
        return $this->belongsTo(Player::class, 'upvote_id');
    }

    public function downTarget() : BelongsTo
    {
        return $this->belongsTo(Player::class, 'downvote_id');
    }

    public function round() : BelongsTo
    {
        return $this->belongsTo(Round::class);
    }

    public function game() : HasManyThrough
    {
        return $this->hasManyThrough(Game::class, Round::class);
    }
}
