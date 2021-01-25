<?php

namespace App\Http\Livewire;

use App\Models\Game;
use App\Models\Round;
use Livewire\Component;

class ManageGame extends Component
{
    public Game $game;

    public function mount()
    {
        if (!$this->game->starts_at) {
            return redirect()->route('littlefinger.games.setup', $this->game);
        }
    }

    public function startRound(int $round_id)
    {
        Round::find($round_id)->update(['started' => true]);

        $this->game->refresh();
    }
}
