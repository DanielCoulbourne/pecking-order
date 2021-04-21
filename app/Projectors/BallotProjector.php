<?php

namespace App\Projectors;

use App\Models\Ballot;
use App\StorableEvents\BallotGained;
use App\StorableEvents\BallotSubmitted;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;
use Spatie\EventSourcing\StoredEvents\StoredEvent;

class BallotProjector extends Projector
{
    public function onBallotSubmitted(BallotSubmitted $ballot_submitted)
    {
        Ballot::create([
            'player_id' => $ballot_submitted->voter->id,
            'upvote_id' => $ballot_submitted->upvote_target->id,
            'downvote_id' => $ballot_submitted->downvote_target->id,
            'round_id' => $ballot_submitted->round->id,
        ]);
    }
}
