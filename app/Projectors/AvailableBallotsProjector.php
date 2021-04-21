<?php

namespace App\Projectors;

use App\StorableEvents\BallotGained;
use App\StorableEvents\BallotSubmitted;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class AvailableBallotsProjector extends Projector
{
    public function onBallotGained(BallotGained $player_gained_ballot)
    {
        $player_gained_ballot->player->update([
            'available_ballots' => $player_gained_ballot->player->available_ballots++
        ]);
    }

    public function onBallotSubmitted(BallotSubmitted $player_gained_ballot)
    {
        $player_gained_ballot->voter->update([
            'available_ballots' => $player_gained_ballot->voter->available_ballots--
        ]);
    }
}
