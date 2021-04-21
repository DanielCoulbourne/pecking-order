<?php

namespace App\StorableEvents;

use App\Models\Player;
use App\Models\Round;
use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class BallotSubmitted extends ShouldBeStored
{
    public Player $voter;
    public Player $upvote_target;
    public Player $downvote_target;
    public Round $round;

    public function __construct(Player $voter, Player $upvote_target, Player $downvote_target, Round $round)
    {
        $this->voter = $voter;
        $this->upvote_target = $upvote_target;
        $this->downvote_target = $downvote_target;
        $this->round = $round;
    }
}
