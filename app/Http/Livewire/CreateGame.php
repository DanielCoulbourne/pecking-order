<?php

namespace App\Http\Livewire;

use App\Models\Game;
use App\Models\Player;
use App\Models\User;
use Livewire\Component;

class CreateGame extends Component
{
    public Game $game;

    public function mount()
    {
        $this->game = $this->game ?? new Game();
    }

    public function createPlayer($discord_username, $nice_name)
    {
        if (!$this->game->exists()) {
            $this->game->save();
        }

        $user = User::firstOrCreate([
            'discord_username' => $discord_username,
            'nice_name' => $nice_name,
        ]);

        Player::create([
            'game_id' => $this->game->id,
            'user_id' => $user->id,
        ]);
    }

    public function addUserAsPlayer(Player $player)
    {
        $this->game->players()->save($player);

        $this->game->refresh();
    }
}
