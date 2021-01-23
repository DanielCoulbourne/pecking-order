<?php

namespace App\Http\Livewire;

use App\Models\Game;
use App\Models\Player;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class CreateGame extends Component
{
    public Game $game;
    public User $temp_user;

    public $rules = [
        'game.name' => ['string', 'required', 'max:255'],
        'temp_user.discord_username' => ['string', 'required', 'max:255', 'regex:/\w*\#\d{4}/', 'unique:users,discord_username'],
        'temp_user.name' => ['string', 'required', 'max:255'],
    ];

    public function mount(Game $game)
    {
        $this->game = $game ?? new Game;
        $this->temp_user = new User;

        if ($game->starts_at) {
            return redirect()->route('littlefinger.games.show', $game);
        }
    }

    public function saveGame()
    {
        $this->game->save();
        $this->game->refresh();
    }

    public function startGame()
    {
        return $this->game->start();
    }

    public function saveTempUser()
    {
        $this->validate();

        if (!$this->game->exists()) {
            $this->game->save();
        }

        $this->temp_user->save();

        Player::firstOrCreate([
            'game_id' => $this->game->id,
            'user_id' => $this->temp_user->id,
        ]);

        $this->game->refresh();
        $this->temp_user = new User;
    }
}
