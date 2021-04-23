<?php

namespace App\Projectors;

use App\StorableEvents\BallotSubmitted;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class UpvoteProjector extends Projector
{
    public function onBallotSubmitted(BallotSubmitted $event)
    {
        $event->upvote_target->update(['tally' => $event->upvote_target->tally++]);
    }
}
