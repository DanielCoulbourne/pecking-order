<?php

namespace App\Http\Livewire;

use App\Models\Game;
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
}
