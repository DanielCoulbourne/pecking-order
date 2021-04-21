<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use function floor;

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

    public function round(int $number) : ?Round
    {
        return $this->rounds()->where('round_number', $number)->first();
    }

    public function uniqueAlias()
    {
        shuffle($this->aliases);

        return array_pop($this->aliases);
    }

    public function start($starts_at = null, $number_of_rounds = 7)
    {
        if (!$starts_at) {
            $noon_today = Carbon::today('America/New_York')->setHour('12');

            $starts_at = $noon_today->isFuture()
                ? $noon_today
                : $noon_today->addDay();
        }

        $this->starts_at = $starts_at;

        $rounds = collect(range(1, $number_of_rounds))->map(fn($round_number) => [
            'round_number' => $round_number,
            'starts_at' => $starts_at->clone()->addDays($round_number - 1)->utc(),
            'tribe_swap' => $round_number === floor($number_of_rounds / 2), // Only one Tribe Swap for now
            'allows_advantages' => $round_number !== $number_of_rounds,
        ]);

        $this->rounds()->createMany($rounds);

        $this->players->each(fn($player) => $player->update(['alias' => $this->uniqueAlias()]));
        $this->randomlyAssignTeams();

        $this->save();

        return $this;
    }

    public function teams() : HasMany
    {
        return $this->hasMany(Team::class);
    }

    public function createRedAndBlueTeams()
    {
        return [
            $this->teams()->updateOrCreate(['name' => 'Red', 'color' => 'red-700']),
            $this->teams()->updateOrCreate(['name' => 'Blue', 'color' => 'blue-700']),
        ];
    }

    public function randomlyAssignTeams() : void
    {
        [$red, $blue] = $this->createRedAndBlueTeams();

        $randomized_players = $this->players()->inRandomOrder()->get();
        $cutoff = floor($randomized_players->count() / 2);

        $red_team_players = $randomized_players->slice(0, $cutoff);
        $blue_team_players = $randomized_players->slice($cutoff);

        $red->players()->saveMany($red_team_players);
        $blue->players()->saveMany($blue_team_players);
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
