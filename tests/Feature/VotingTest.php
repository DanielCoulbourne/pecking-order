<?php

namespace Tests\Models;

use App\Models\Game;
use App\Models\Player;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VotingTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_player_can_cast_a_vote_for_an_enemy()
    {

        $game = Game::factory()->create();
        $game->start(now(), 1);
        $round = $game->round(1);

        $round->start();

        $this->assertEquals(1, $game->currentRound()->round_number);

        $voter = Player::factory()->game($game)->onTeam()->create();
        $target = Player::factory()->game($game)->onTeam()->create();

        $this->assertContains($target->id, $voter->targets->pluck('id'));

        $vote = $voter->castVote($target, $round);

        $this->assertCount(1, $round->votes);

        $this->assertCount(1, $target->votesTaken);

        $this->assertCount(1, $target->votesTakenInRound($round));
    }
}
