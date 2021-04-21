<?php

namespace App\Models;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Round extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = ['starts_at'];

    protected static function booted()
    {
        static::addGlobalScope('orderByRound', function (Builder $builder) {
            $builder->orderBy('round_number');
        });
    }

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function timeDiff()
    {
        $now = now('America/New_York');

        if ($this->starts_at->isFuture()) {
            $start_diff = $this->starts_at->setTimezone('America/New_York')->diffForHumans($now, [
                'syntax' => CarbonInterface::DIFF_RELATIVE_TO_NOW,
                'options' => Carbon::JUST_NOW | Carbon::ONE_DAY_WORDS,
            ]);

            return "Starts {$start_diff}";
        }

        $ends_at = $this->starts_at->addDay();
        $end_diff = $ends_at->diffForHumans($now, [
            'syntax' => CarbonInterface::DIFF_RELATIVE_TO_NOW,
            'options' => Carbon::JUST_NOW | Carbon::ONE_DAY_WORDS,
        ]);

        if ($ends_at->isPast()) {
            return "Ended {$end_diff}";
        }

        return "Ends {$end_diff}";
    }

    public function ballots()
    {
        return $this->hasMany(Ballot::class);
    }

    public function getCurrentAttribute() : bool
    {
        return $this->game->currentRound()->id === $this->id;
    }

    public function start() : bool
    {
        $this->game->players->each->incrementAvailableBallots();

        return $this->update(['started' => true]);
    }

    public function scopeStarted(Builder $query, bool $is_started = true) : Builder
    {
        return $query->where('started', $is_started);
    }
}
