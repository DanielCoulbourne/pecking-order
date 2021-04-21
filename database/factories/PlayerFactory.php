<?php

namespace Database\Factories;

use App\Models\Game;
use App\Models\Player;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlayerFactory extends Factory
{
    protected $model = Player::class;

    public function definition() : array
    {
        return [
            'user_id' => User::factory(),
            'game_id' => Game::factory(),
        ];
    }

    public function onTeam(Team $team = null)
    {
        return $this->state(function($attributes) use ($team) {
            $team = $team ?? Team::factory()->game(Game::find($attributes['game_id']))->create();

            return [
                'team_id' => $team->id,
            ];
        });
    }

    public function game(Game $game)
    {
        return $this->state(fn($attributes) => [
            'game_id' => $game->id,
        ]);
    }
}
