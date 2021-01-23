<?php

namespace App\Models;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Round extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $dates = ['starts_at'];

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
}
