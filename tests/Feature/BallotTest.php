<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Game;
use App\Models\Team;
use App\Models\Player;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BallotTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_player_can_not_cast_a_ballot_if_they_have_no_ballots()
    {
        $game = Game::factory()->create();
        $game->start(now(), 1);
        $round = $game->round(1);

        $team = Team::factory()->game($game)->create();

        $voter = Player::factory()->game($game)->onTeam($team)->create();
        $teammate = Player::factory()->game($game)->onTeam($team)->create();
        $target = Player::factory()->game($game)->onTeam()->create();

        $this->assertContains($target->id, $voter->targets->pluck('id'));
        $this->assertContains($teammate->id, $voter->teammates->pluck('id'));

        $round->start();
        $this->assertEquals(1, $game->currentRound()->round_number);

        $voter->castBallot($teammate, $target);

        $this->assertCount(0, $round->ballots);

        $this->assertCount(0, $target->upvotesTaken);
        $this->assertCount(0, $target->downvotesTaken);

        $this->assertCount(0, $teammate->upvotesTaken);
        $this->assertCount(0, $teammate->downvotesTaken);
    }

    public function test_a_player_can_cast_a_ballot()
    {
        $game = Game::factory()->create();
        $game->start(now(), 1);
        $round = $game->round(1);

        $team = Team::factory()->game($game)->create();

        $voter = Player::factory()->game($game)->onTeam($team)->create();
        $teammate = Player::factory()->game($game)->onTeam($team)->create();
        $target = Player::factory()->game($game)->onTeam()->create();

        $round->start(); // Starting a round gives everyone 1 ballot
        
        $this->assertEquals(1, $game->currentRound()->round_number);

        $this->assertContains($target->id, $voter->targets->pluck('id'));
        $this->assertContains($teammate->id, $voter->teammates->pluck('id'));

        $voter->fresh()->castBallot($teammate, $target);

        $this->assertCount(1, $round->ballots);

        $this->assertCount(0, $target->upvotesTaken);
        $this->assertCount(1, $target->downvotesTaken);

        $this->assertCount(1, $teammate->upvotesTaken);
        $this->assertCount(0, $teammate->downvotesTaken);
    }
}
