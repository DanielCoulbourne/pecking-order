<?php

namespace App\Http\Livewire;

use App\Models\Game;
use App\Models\Player;
use App\Models\Round;
use Livewire\Component;

class PlayerAction extends Component
{
    public Game $game;
    public Round $round;
    public Player $player;

    public $upvote;
    public $downvote;

    protected $rules = [
        'upvote' => 'integer|required',
        'downvote' => 'integer|required',
    ];

    public function submit()
    {
        $this->player->castBallot(
            Player::find($this->upvote),
            Player::find($this->downvote),
            $this->round
        );

        $this->reset(['upvote', 'downvote']);
    }

    public function getTeammatesProperty()
    {
        return $this->game->players()
            ->where('team_id', $this->player->team_id)
            ->where('id', '!=', $this->player->id)->get();
    }

    public function getTargetsProperty()
    {
        return $this->game->players()
            ->where('team_id', '!=', $this->player->team_id)
            ->where('id', '!=', $this->player->id)->get();
    }
}
