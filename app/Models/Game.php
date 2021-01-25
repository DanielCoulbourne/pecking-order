<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    public $aliases = ['Dog', 'Cat', 'Pig', 'Cow', 'Horse', 'Chicken', 'Duck', 'Sheep', 'Goose', 'Mouse', 'Donkey', 'Rabbit'];

    public function players()
    {
        return $this->hasMany(Player::class);
    }

    public function rounds()
    {
        return $this->hasMany(Round::class);
    }

    public function uniqueAlias()
    {
        shuffle($this->aliases);

        return array_pop($this->aliases);
    }

    public function start()
    {
        if ($this->starts_at) {
            return;
        }

        $noon_today = Carbon::today('America/New_York')->setHour('12');

        $starts_at = $noon_today->isFuture()
            ? $noon_today
            : $noon_today->addDay();

        $this->starts_at = $starts_at;

        $rounds = collect(range(1, 7))->map(fn ($round_number) => [
            'round_number' => $round_number,
            'starts_at' => $starts_at->clone()->addDays($round_number - 1)->utc(),
            'tribe_swap' => $round_number % 2 !== 0 && $round_number !== 7, // Number is odd and not 7.
            'allows_advantages' => $round_number !== 7,
        ]);

        $this->rounds()->createMany($rounds);

        $this->players->each(fn ($player) => $player->update(['alias' => $this->uniqueAlias()]));
        $this->randomlyAssignTeams();

        $this->save();

        return redirect()->route('littlefinger.games.show', $this);
    }

    public function randomlyAssignTeams()
    {
        $initial_rounds = $this->rounds()->take(2)->get();

        $red = Team::create(['name' => 'Red', 'color' => 'red-700']);
        $blue = Team::create(['name' => 'Blue', 'color' => 'blue-700']);

        $initial_rounds->each(function ($round) use ($red, $blue) {
            $round->teams()->sync([$red->id, $blue->id]);
        });

        $randomized_players = $this->players()->inRandomOrder()->get();
        $cutoff = floor($randomized_players->count() / 2);

        $red_team_players = $randomized_players->slice(0, $cutoff);
        $blue_team_players = $randomized_players->slice($cutoff);

        $red->players()->sync($red_team_players);
        $blue->players()->sync($blue_team_players);
    }

    public function currentRound()
    {
        return $this->rounds()->started(true)->orderByDesc('round_number')->first();
    }

    public function nextRound()
    {
        return $this->rounds()->started(false)->first();
    }
}
