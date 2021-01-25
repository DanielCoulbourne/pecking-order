<?php

namespace App\Http\Livewire;

use App\Models\Game;
use App\Models\Player;
use App\Models\Round;
use Livewire\Component;

class PlayerAction extends Component
{
    public Game $game;
    public Round $round;
    public Player $player;

    public array $targets;
    public int $new_team;

    public function maxSpendableVotes()
    {
        return $this->player->available_votes ?? 4;
    }

    public function submit()
    {
        $this->player->teams()->attach($this->new_team);

        foreach ($this->targets as $target) {
            $this->player->votes()->create([
                'target_id' => $target->id,
                'round' => $this->round,
            ]);
        }
    }
}
