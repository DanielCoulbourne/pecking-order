<?php

namespace App\StorableEvents;

use App\Models\Player;
use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class BallotGained extends ShouldBeStored
{
    public Player $player;

    public function __construct(Player $player)
    {
        $this->player = $player;
    }
}
