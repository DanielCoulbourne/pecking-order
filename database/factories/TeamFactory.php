<?php

namespace Database\Factories;

use App\Models\Game;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeamFactory extends Factory
{
    protected $model = Team::class;

    protected $options = [
        'red' => [
            'name' => 'Red',
            'color' => 'red-300',
        ],
        'blue' => [
            'name' => 'Blue',
            'color' => 'blue-300',
        ],
    ];

    public function definition() : array
    {
        $option = $this->options[array_rand($this->options)];

        return [
            'name' => $option['name'],
            'color' => $option['color'],
        ];
    }

    public function game(Game $game)
    {
        return $this->state(fn($attributes) => [
            'game_id' => $game->id,
        ]);
    }
}
