<?php

use App\Models\Player;
use App\Models\Team;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayerTeamTable extends Migration
{
    public function up()
    {
        Schema::create('player_team', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Player::class, 'player_id');
            $table->foreignIdFor(Team::class, 'team_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('player_team');
    }
}
