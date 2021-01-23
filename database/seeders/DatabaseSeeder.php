<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $game = Game::create([
            'name' => 'Alpha Test 2',
        ]);

        $boiz = [
            ['name' => 'Walter', 'discord_username' => 'Walter_gray#5442'],
            ['name' => 'Daniel', 'discord_username' => 'Coulbourne#9297'],
            ['name' => 'John', 'discord_username' => 'johnrudolph#2789'],
            ['name' => 'Emmett', 'discord_username' => 'Bumpadump#0864'],
            ['name' => 'Stephen', 'discord_username' => 'Bobssled#7270'],
            ['name' => 'Grant', 'discord_username' => 'Indielens#6646'],
        ];

        collect($boiz)->each(function ($boi) use ($game) {
            $user = User::create($boi);

            $game->players()->create([
                'user_id' => $user->id,
            ]);
        });

        dump(route('littlefinger.games.setup', $game));
    }
}
