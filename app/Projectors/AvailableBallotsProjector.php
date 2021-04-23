<?php

namespace App\Projectors;

use App\StorableEvents\BallotGained;
use App\StorableEvents\BallotSubmitted;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class AvailableBallotsProjector extends Projector
{
    public function onBallotGained(BallotGained $event)
    {
        $event->player->update([
            'available_ballots' => $event->player->available_ballots++,
        ]);
    }

    public function onBallotSubmitted(BallotSubmitted $event)
    {
        $event->voter->update([
            'available_ballots' => $event->voter->available_ballots--,
        ]);
    }
}
