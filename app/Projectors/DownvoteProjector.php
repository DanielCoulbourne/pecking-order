<?php

namespace App\Projectors;

use App\StorableEvents\BallotSubmitted;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class DownvoteProjector extends Projector
{
    public function onBallotSubmitted(BallotSubmitted $ballot_submitted)
    {
        $ballot_submitted->downvote_target->update(['tally' => $ballot_submitted->downvote_target->tally--]);
    }
}
