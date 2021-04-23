<?php

namespace App\Projectors;

use App\Models\Ballot;
use App\StorableEvents\BallotSubmitted;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class BallotProjector extends Projector
{
    public function onBallotSubmitted(BallotSubmitted $event)
    {
        Ballot::create([
            'player_id' => $event->voter->id,
            'upvote_id' => $event->upvote_target->id,
            'downvote_id' => $event->downvote_target->id,
            'round_id' => $event->round->id,
        ]);
    }
}
