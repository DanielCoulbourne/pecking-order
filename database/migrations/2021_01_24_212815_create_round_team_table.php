<?php

use App\Models\Round;
use App\Models\Team;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoundTeamTable extends Migration
{
    public function up()
    {
        Schema::create('round_team', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Round::class, 'round_id');
            $table->foreignIdFor(Team::class, 'team_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('round_team');
    }
}
