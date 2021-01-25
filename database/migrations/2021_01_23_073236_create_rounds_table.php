<?php

use App\Models\Game;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoundsTable extends Migration
{
    public function up()
    {
        Schema::create('rounds', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Game::class, 'game_id');
            $table->integer('round_number');
            $table->boolean('allows_advantages');
            $table->boolean('tribe_swap');
            $table->dateTime('starts_at');
            $table->boolean('started')->default(false); // This can probably go away in favor of checking starts_at
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rounds');
    }
}
