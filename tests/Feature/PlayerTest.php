<?php

namespace Tests\Models;

use App\Models\Game;
use App\Models\Player;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlayerTest extends TestCase
{
    public Game $game;

    public Player $player;

    public Team $red_team;

    public Team $blue_team;

    use RefreshDatabase;

    public function test_a_player_can_be_on_a_team()
    {

        $game = Game::factory()->create();

        $team = Team::factory()->create([
            'game_id' => $game->id,
        ]);

        $player = Player::factory()->create([
            'game_id' => $game->id,
        ]);

        $team->players()->save($player);

        $this->assertEquals($team->id, $player->team_id);
    }

    // RULE: Players can only vote for players on the other team
    public function test_a_players_targets_only_include_the_other_team()
    {
        $game = Game::factory()->create();

        $my_team = Team::factory()->create([
            'game_id' => $game->id,
        ]);

        $me = Player::factory()->create([
            'game_id' => $game->id,
            'team_id' => $my_team->id,
        ]);

        $other_team = Team::factory()->create([
            'game_id' => $game->id,
        ]);

        $friends = Player::factory(2)->game($game)->onTeam($my_team)->create();
        $foes = Player::factory(3)->game($game)->onTeam($other_team)->create();

        $this->assertCount(2, $me->teammates);
        $this->assertCount(3, $me->enemies);

        $friends->each(fn($friend) => $this->assertNotContains(
            $friend->id, $me->targets->pluck('id')
        ));

        $foes->each(fn($foe) => $this->assertContains(
            $foe->id, $me->targets->pluck('id')
        ));
    }
}
