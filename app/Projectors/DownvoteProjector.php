<?php

namespace App\Projectors;

use App\StorableEvents\BallotSubmitted;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class DownvoteProjector extends Projector
{
    public function onBallotSubmitted(BallotSubmitted $event)
    {
        $event->downvote_target->update(['tally' => $event->downvote_target->tally--]);
    }
}
