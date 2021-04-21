<?php

use App\Models\Game;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayersTable extends Migration
{
    public function up()
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string('alias')->nullable();
            $table->foreignIdFor(Game::class);
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Team::class)->nullable();
            $table->integer('available_ballots')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('players');
    }
}
