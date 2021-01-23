<?php

use App\Models\Game;
use App\Models\Player;
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
            $table->foreignIdFor(Game::class, 'game_id');
            $table->foreignIdFor(User::class, 'user_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('players');
    }
}
