<?php

use App\Models\Round;
use App\Models\Player;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBallotsTable extends Migration
{
    public function up()
    {
        Schema::create('ballots', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Player::class, 'player_id');
            $table->foreignIdFor(Player::class, 'upvote_id');
            $table->foreignIdFor(Player::class, 'downvote_id');
            $table->foreignIdFor(Round::class, 'round_id');
            $table->timestamp('tallied_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ballots');
    }
}
