<?php

namespace App\Projectors;

use App\StorableEvents\BallotSubmitted;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class UpvoteProjector extends Projector
{
    public function onBallotSubmitted(BallotSubmitted $ballot_submitted)
    {
        $ballot_submitted->upvote_target->update(['tally' => $ballot_submitted->upvote_target->tally++]);
    }
}
