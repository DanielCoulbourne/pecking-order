<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    public function voter()
    {
        return $this->belongsTo(Player::class, 'voter_id');
    }

    public function target()
    {
        return $this->belongsTo(Player::class, 'target_id');
    }

    public function round()
    {
        return $this->belongsTo(Round::class);
    }
}
