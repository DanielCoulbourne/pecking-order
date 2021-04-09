<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Vote extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function voter() : BelongsTo
    {
        return $this->belongsTo(Player::class, 'voter_id');
    }

    public function target() : BelongsTo
    {
        return $this->belongsTo(Player::class, 'target_id');
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
